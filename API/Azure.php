<?php

namespace MoAzureObjectSync\API;

use MoAzureObjectSync\Wrappers\wpWrapper;

class Azure{

    private static $obj;
    private $endpoints;
    private $config;
    private $scope = "https://graph.microsoft.com/.default";
    private $access_token;
    private $handler;

    private function __construct($config){
        $this->config = $config;
        $this->handler = Authorization::getController();
    }

    public static function getClient($config){
        if(!isset(self::$obj)){
            self::$obj = new Azure($config);
            self::$obj->setEndpoints();
        }
        return self::$obj;
    }

    public function mo_azos_sync_all_azure_users(){
        $this->access_token = sanitize_text_field($this->handler->mo_azos_get_access_token_using_client_credentials($this->endpoints,$this->config,$this->scope));
        if(!$this->access_token){
            wp_die(esc_html("Access token is missing from the response. Please try again later."));
        }
        $this->fetch_users_using_access_token();
    }

    public function mo_azos_sync_individual_azure_user($user_upn_id){
        $this->access_token = sanitize_text_field($this->handler->mo_azos_get_access_token_using_client_credentials($this->endpoints,$this->config,$this->scope));
        if(!$this->access_token){
            wp_die(esc_html("Access token is missing from the response. Please try again later."));
        }
        
        $status = $this->fetch_individual_user_using_access_token($user_upn_id);

        return $status;

    }

    public function mo_azos_create_user_in_ad($user_id,$username){
        $this->access_token = sanitize_text_field($this->handler->mo_azos_get_access_token_using_client_credentials($this->endpoints,$this->config,$this->scope));
        if(!$this->access_token){
            wp_die(esc_html("Access token is missing from the response. Please try again later."));
        }

        $username = $username;
        $username = str_replace(' ', '', $username);

        $mailNickName = $username;
        if(is_email($username))
            $mailNickName = bin2hex(random_bytes(16));

        $userObject = '{
             "accountEnabled":true,
             "passwordProfile" : {
             "password": "'.wp_generate_password().'",
             "forceChangePasswordNextSignIn": false
             },
             "mailNickname": "'.$mailNickName.'",
            "passwordPolicies": "DisablePasswordExpiration"
        }';
        $userObject = json_decode($userObject,true);

		$userObject['userPrincipalName'] = $username.'@'.$this->config['tenant_name'];
		$userObject['displayName'] = $username;

        $headers = [
            'Authorization' => 'Bearer '.$this->access_token,
            'Content-Type' => 'application/json'
        ];

        $body = json_encode($userObject);

        $response = $this->handler->mo_azos_post_request($this->endpoints['users'],$headers,$body);
     
        // error_log(print_r($response,true));
        if(is_array($response) && array_key_exists('id',$response)){
            update_user_meta( $user_id, "AD_SYNC_ID" , $response['id'] );
            return true;
        }

        return $response;
    }

    private function fetch_individual_user_using_access_token($user_upn_id){
        $this->access_token = $this->handler->mo_azos_get_access_token_using_client_credentials($this->endpoints,$this->config,$this->scope);
        $args = [
            'Authorization' => 'Bearer '.$this->access_token
        ];
        $user_info_url = $this->endpoints['users'].$user_upn_id;
        $user = $this->handler->mo_azos_get_request($user_info_url,$args);
        if(!is_array($user) || count($user)<=0){
            wp_die(esc_html("Unknown error occurred. Please try again later."));
        }

        if(array_key_exists('error',$user)){
            wpWrapper::mo_azos__show_error_notice(esc_html__($user['error']['message']));
            return false;
        }

        if(!empty($user)){
            $user_login = sanitize_user($user['id']);
            $user_email = sanitize_email($user['userPrincipalName']);
            $user_id = username_exists($user_login);
            if(!$user_id){
                $user_id = email_exists($user_email);
            }
            if(!$user_id){
                $random_pass = wp_generate_password('12', false);
                $user_id = wp_create_user($user_login, $random_pass, $user_email);
                if(!is_numeric($user_id)){
                    return $user_id->errors;
                }

                $this->mo_azos_send_mail_to_new_user($user_email);

            }else{
                wp_update_user([
                    'user_email' => $user_email
                ]);
            }
        }

        return true;

    }

    private function setEndpoints(){
        $this->endpoints['authorize'] = 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize';
        if(isset($this->config['tenant_id']))
            $this->endpoints['token'] = 'https://login.microsoftonline.com/'.$this->config['tenant_id'].'/oauth2/v2.0/token';
        $this->endpoints['users'] = 'https://graph.microsoft.com/beta/users/';
    }

    private function fetch_users_using_access_token(){
        $args = [
            'Authorization' => 'Bearer '.$this->access_token
        ];
        $users = $this->handler->mo_azos_get_request($this->endpoints['users'].'?$select=id,userPrincipalName',$args);
        if(!is_array($users) || count($users)<=0){
            wp_die(esc_html("Unknown error occurred. Please try again later."));
        }

        foreach ($users['value'] as $user){
            if(!empty($user)){
                $user_login = sanitize_user($user['id']);
                $user_email = sanitize_email($user['userPrincipalName']);
                $user_id = username_exists($user_login);
                if(!$user_id){
                    $user_id = email_exists($user_email);
                }
                if(!$user_id){
                    $random_pass = wp_generate_password('12', false);
                    $user_id = wp_create_user($user_login, $random_pass, $user_email);
                }else{
                    wp_update_user([
                        'user_email' => $user_email
                    ]);
                }
            }
        }
    }

    public function mo_azos_get_specific_user_detail(){
        $this->access_token = $this->handler->mo_azos_get_access_token_using_client_credentials($this->endpoints,$this->config,$this->scope);
        $args = [
            'Authorization' => 'Bearer '.$this->access_token
        ];
        $user_info_url = $this->endpoints['users'].urlencode($this->config['upn_id']);
        $users = $this->handler->mo_azos_get_request($user_info_url,$args);
        
        if(!is_array($users) || count($users)<=0){
            wp_die(esc_html("Unknown error occurred. Please try again later."));
        }

        $users['manager'] = $this->mo_azos_get_manager_data(urlencode($this->config['upn_id']));

        return $users;
    }

    public function mo_azos_get_manager_data($upn){
        $args = [
            'Authorization' => 'Bearer '.$this->access_token
        ];
        $manager_url =$this->endpoints['users'].$upn.'/manager';
        $manager = $this->handler->mo_azos_get_request($manager_url,$args);
        if(!is_array($manager) || count($manager)<=0 || isset($manager['error'])){
            // error_log("Cannot fetch manager details for:".$$upn);
        }
        return $manager;
    }

    public function mo_azos_get_profile_pic($upn){
        $args = [
            'Authorization' => 'Bearer '.$this->access_token
        ];
        $profile_pic_url = $this->endpoints['users'].$upn.'/photo/$value';
        $pic = $this->handler->mo_azos_get_request_for_media($profile_pic_url,$args);

        return $pic;
    }

    public function mo_azos_get_access_token_for_automatic_app_creation(){
        $this->access_token = $this->handler->mo_azos_get_access_token_using_client_credentials($this->endpoints,$this->config,$this->scope);
    }

    public function mo_azos_send_mail_to_azure_user(){
        $mail_app = wpWrapper::mo_azos_get_option('mo_azos_ad_mail_config');
        
        $this->access_token = $this->handler->mo_azos_get_access_token_using_client_credentials($this->endpoints,$this->config,$this->scope);
        $graph_mail_url = 'https://graph.microsoft.com/beta/users/'.urlencode($mail_app['mailFrom']).'/sendMail';

        $userObject = '{}';
        $userObject = json_decode($userObject,true);

        

       $userObject['message'] = [
        "subject" => "Graph Mail Test",
        "body" => [
            "contentType" => "Text",
            "content" => "Hi, You are recieving this test email using Microsoft Graph API."
        ],
        "toRecipients" => [
            [
                "emailAddress" =>[
                    "address" => $mail_app['mailTo']
                ]
            ]
        ]
        ];

        $userObject['saveToSentItems'] = !empty($mail_app['saveToSentItems']) && $mail_app['saveToSentItems'] === "on"?true:false;

       $headers = [
           'Authorization' => 'Bearer '.$this->access_token,
           'Content-Type' => 'application/json'
       ];

       $body = json_encode($userObject);

       $response = $this->handler->mo_azos_post_request($graph_mail_url,$headers,$body);

       if(isset($response['error'])){
           return $response['error']['message'];
       }

       return true;
    }

    public function mo_azos_send_mail_to_new_user($email){
        $mail_on_user_register_app = wpWrapper::mo_azos_get_option('mo_azos_ad_mail_on_user_register_config');
        $mail_app = wpWrapper::mo_azos_get_option('mo_azos_ad_mail_config');

        $message = !empty($mail_on_user_register_app['message'])?$mail_on_user_register_app['message']:'';
        $sendToNewUser = !empty($mail_on_user_register_app['sendToNewUser'])?$mail_on_user_register_app['sendToNewUser']:'';

        if($sendToNewUser != "on")
            return false;

            $graph_mail_url = 'https://graph.microsoft.com/beta/users/'.urlencode($mail_app['mailFrom']).'/sendMail';
    
            $userObject = '{}';
            $userObject = json_decode($userObject,true);
    
            
    
           $userObject['message'] = [
            "subject" => "Thanks for creating an account with us",
            "body" => [
                "contentType" => "Text",
                "content" => $message
            ],
            "toRecipients" => [
                [
                    "emailAddress" =>[
                        "address" => $email
                    ]
                ]
            ]
            ];
    
            $userObject['saveToSentItems'] = !empty($mail_app['saveToSentItems']) && $mail_app['saveToSentItems'] === "on"?true:false;
    
           $headers = [
               'Authorization' => 'Bearer '.$this->access_token,
               'Content-Type' => 'application/json'
           ];
    
           $body = json_encode($userObject);
    
           $response = $this->handler->mo_azos_post_request($graph_mail_url,$headers,$body);

        return true;
    }
}