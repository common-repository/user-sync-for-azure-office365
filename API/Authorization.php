<?php

namespace MoAzureObjectSync\API;

use MoAzureObjectSync\Observer\adminObserver;
use MoAzureObjectSync\Wrappers\pluginConstants;
use MoAzureObjectSync\Wrappers\wpWrapper;

class Authorization{
    private static $instance;

    public static function getController(){
        if(!isset(self::$instance)){
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }

    public function mo_azos_get_access_token_using_client_credentials($endpoints,$config,$scope){


        $is_automatic_app_configured = wpWrapper::mo_azos_get_option('is_automatic_app_configured');
        $is_manual_app_configured = wpWrapper::mo_azos_get_option('is_manual_app_configured');

        if(!empty($is_automatic_app_configured) || (empty($is_automatic_app_configured) && empty($is_manual_app_configured))){

            $customer_tenant_id = 'common';
            $mo_client_id = base64_decode(pluginConstants::CID);
            $mo_client_secret = base64_decode(pluginConstants::CSEC);
            $server_url = base64_decode(pluginConstants::CONNECT_SERVER_URI);

            $refresh_token = wpWrapper::mo_azos_get_option(pluginConstants::azos_refresh_token);


            if(empty($refresh_token)){
                $code = wpWrapper::mo_azos_get_option(pluginConstants::azos_auth_code);

                $args =  [
                    'body' => [
                        'grant_type' => 'authorization_code',
                        'client_secret' => $mo_client_secret,
                        'client_id' => $mo_client_id,
                        'scope' => $scope." offline_access",
                        'code'=> $code,
                        'redirect_uri' => $server_url
                    ],
                    'headers' => [
                        'Content-type' => 'application/x-www-form-urlencoded'
                    ]
                ];
            }else{
                $args =  [
                    'body' => [
                        'grant_type' => 'refresh_token',
                        'client_secret' => $mo_client_secret,
                        'client_id' => $mo_client_id,
                        'scope' => $scope." offline_access",
                        'refresh_token'=>$refresh_token,
                    ],
                    'headers' => [
                        'Content-type' => 'application/x-www-form-urlencoded'
                    ]
                ];
            }

            $response = wp_remote_post(esc_url_raw('https://login.microsoftonline.com/'.$customer_tenant_id.'/oauth2/v2.0/token'),$args);

        }else{

            $client_secret = wpWrapper::mo_azos_decrypt_data($config['client_secret'],hash("sha256",$config['client_id']));
            $args = [
                'body' => [
                    'grant_type' => 'client_credentials',
                    'client_secret' => $client_secret,
                    'client_id' => $config['client_id'],
                    'scope' => $scope
                ],
                'headers' => [
                    'Content-type' => 'application/x-www-form-urlencoded'
                ]
            ];

            $response = wp_remote_post(esc_url_raw($endpoints['token']),$args);

        }


        

        
        if ( is_wp_error( $response ) ) {
            $error_message = $response->get_error_message();
            wp_die("Error Occurred : ".esc_html($error_message));
        } else {
            $body= json_decode($response["body"],true);
            if(isset($body['error'])){
                $observer = adminObserver::getObserver();
                $error_code = [
                    "Error" => $body['error'],
                   "Description" => $body['error_description']
               ];
               $observer->mo_azos_display_error_message($error_code);
            }
            if(isset($body['refresh_token'])){
                wpWrapper::mo_azos_set_option(pluginConstants::azos_refresh_token,$body['refresh_token']);
            }
            if(isset($body["access_token"])){
                return $body["access_token"];
            }
        }
        return false;
    }

    public function mo_azos_get_request($url,$headers){
        $args = [
            'headers' => $headers
        ];
        $response = wp_remote_get(esc_url_raw($url),$args);
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            return json_decode($response["body"],true);
        } else {
            wp_die("Error occurred: ".esc_html($response->get_error_message()));
        }
    }

    public function mo_azos_post_request($url,$headers,$body){
        $args = [
            'body' => $body,
            'headers' => $headers
        ];
        $response = wp_remote_post(esc_url_raw($url),$args);
        if ( is_wp_error( $response ) ) {
            $error_message = $response->get_error_message();
            wp_die("Error Occurred : ".esc_html($error_message));
        } else {
            $body= json_decode($response["body"],true);
            return $body;
        }
        return false;
        
    }

    public function mo_azos_get_request_for_media($url,$headers = []){
        $args = [
            'headers' => $headers
        ];
        $response = wp_remote_get(esc_url_raw($url),$args);
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $response_array = (array)json_decode($response["body"],true);
            
            if(array_key_exists('error',$response_array)){

                return null;
            }
            return base64_encode($response["body"]);
        } else {
            wp_die("Error occurred: ".esc_html($response->get_error_message()));
        }
    }
}