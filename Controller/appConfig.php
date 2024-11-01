<?php

namespace MoAzureObjectSync\Controller;

use MoAzureObjectSync\API\Azure;
use MoAzureObjectSync\Wrappers\wpWrapper;

class appConfig{

    private static $instance;

    public static function getController(){
        if(!isset(self::$instance)){
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }

    public function mo_azos_save_settings(){
        $option = sanitize_text_field($_POST['option']);
        switch ($option){
            case 'mo_azos_client_config_option':{
                $this->mo_azos_save_client_config();
                break;
            }
            case 'mo_azos_automatic_client_config_option':{
                $this->mo_azos_automatic_client_config();
                break;
            }
            case 'mo_azos_client_wp_sync_all_users_option':{
                $this->mo_azos_sync_all_users();
                break;
            }
            case 'mo_azos_client_wp_sync_individual_user_option':{
                $this->mo_azos_sync_individual_user();
                break;
            }
            case 'mo_azos_client_ad_sync_individual_user_option':{
                $this->mo_azos_ad_sync_individual_user();
                break;
            }
            case 'mo_azos_ad_mail_option':{
                $this->mo_azos_ad_mail_option();
                break;
            }
            case 'mo_azos_send_test_mail_option':{
                $this->mo_azos_send_test_mail_option();
                break;
            }
            case 'mo_azos_send_ad_mail_on_user_register_option':{
                $this->mo_azos_send_ad_mail_on_user_register_save_settings();
                break;
            }
        }
    }

    private function mo_azos_check_for_empty_or_null(&$input,$arr){
        foreach ($arr as $key){
            if(!isset($_POST[$key]) || empty($_POST[$key])){
                return false;
            }
            $input[$key] = sanitize_text_field($_POST[$key]);
        }
        return $input;
    }

    private function mo_azos_save_client_config(){
        check_admin_referer('mo_azos_client_config_option');
        
        $input_arr = ['client_id','client_secret','tenant_id'];

        $sanitized_arr = [];
        if(!$this->mo_azos_check_for_empty_or_null($sanitized_arr,$input_arr)){
            wpWrapper::mo_azos__show_error_notice(esc_html__("Mandatory input field is empty or present in the incorrect format."));
            return;
        }
        $sanitized_arr['upn_id'] = isset($_POST['upn_id'])?sanitize_text_field($_POST['upn_id']):'';
        $sanitized_arr['redirect_uri'] = isset($_POST['redirect_uri'])?trailingslashit(sanitize_text_field($_POST['redirect_uri'])):'';
        $sanitized_arr['tenant_name'] = isset($_POST['tenant_name'])?sanitize_text_field($_POST['tenant_name']):'';
        
        $sanitized_arr['client_secret'] = wpWrapper::mo_azos_encrypt_data($sanitized_arr['client_secret'],hash("sha256",$sanitized_arr['client_id']));

        wpWrapper::mo_azos_set_option("is_automatic_app_configured",false);
        wpWrapper::mo_azos_set_option('is_manual_app_configured',true);
        wpWrapper::mo_azos_set_option("mo_azos_application_config",$sanitized_arr);
        wpWrapper::mo_azos__show_success_notice(esc_html__("Settings Saved Successfully."));
    }

    private function mo_azos_automatic_client_config(){
        check_admin_referer('mo_azos_automatic_client_config_option');
      
        $sanitized_arr = [];
        
        $sanitized_arr['upn_id'] = isset($_POST['upn_id'])?sanitize_text_field($_POST['upn_id']):'';
        $sanitized_arr['tenant_name'] = isset($_POST['tenant_name'])?sanitize_text_field($_POST['tenant_name']):'';
        
        wpWrapper::mo_azos_set_option("is_automatic_app_configured",true);
        wpWrapper::mo_azos_set_option("is_manual_app_configured",false);
        wpWrapper::mo_azos_set_option("mo_azos_application_config",$sanitized_arr);
        wpWrapper::mo_azos__show_success_notice(esc_html__("Settings Saved Successfully."));
    }

    private function mo_azos_sync_all_users(){
        check_admin_referer('mo_azos_client_wp_sync_all_users_option');
        $data = wpWrapper::mo_azos_get_option('mo_azos_application_config');
        if(!$data || empty($data)){
            return;
        }
        $azure_client = Azure::getClient($data);
        $azure_client->mo_azos_sync_all_azure_users();
        wpWrapper::mo_azos__show_success_notice(esc_html__("Users synced successfully."));
    }

    private function mo_azos_sync_individual_user(){
        check_admin_referer('mo_azos_client_wp_sync_individual_user_option');

        $user_upn_id = $_POST['user_upn_id'];

        if(empty($user_upn_id)){
            wpWrapper::mo_azos__show_error_notice(esc_html__("Please provide UserPrincipalName/ID of user."));
            return;
        }


        $data = wpWrapper::mo_azos_get_option('mo_azos_application_config');
        if(!$data || empty($data)){
            return;
        }
        $azure_client = Azure::getClient($data);
        $status = $azure_client->mo_azos_sync_individual_azure_user(urlencode($user_upn_id));

        if(is_array($status)){
            if(isset($status['user_login_too_long']))
                wpWrapper::mo_azos__show_error_notice(esc_html__($status['user_login_too_long'][0]));
        }

        if(is_bool($status))
            wpWrapper::mo_azos__show_success_notice(esc_html__("User synced successfully."));
            
    }

    private function mo_azos_ad_sync_individual_user(){
        check_admin_referer('mo_azos_client_ad_sync_individual_user_option');

        $wp_username = $_POST['username_id'];

        $data = wpWrapper::mo_azos_get_option('mo_azos_application_config');

        if(!isset($data['tenant_name']) || (isset($data['tenant_name']) && empty($data['tenant_name']))){
            wpWrapper::mo_azos__show_error_notice(esc_html__("Tenant name need to be configured in basic app configuration."));
            return;
        }

        if(empty($wp_username)){
            wpWrapper::mo_azos__show_error_notice(esc_html__("Please provide username of user."));
            return;
        }

        $user_id = username_exists($wp_username);

        if(!is_numeric($user_id)){
            wpWrapper::mo_azos__show_error_notice(esc_html__("User doesn't exist in WordPress."));
            return;
        }
        
        if(!$data || empty($data)){
            return;
        }

        $azure_client = Azure::getClient($data);

        $status = $azure_client->mo_azos_create_user_in_ad($user_id,$wp_username);


        if(is_array($status)){
            if(isset($status['error']))
                wpWrapper::mo_azos__show_error_notice(esc_html__($status['error']['message']));
        }

        if(is_bool($status))
            wpWrapper::mo_azos__show_success_notice(esc_html__("User synced successfully."));
    }

    private function mo_azos_ad_mail_option(){
        check_admin_referer('mo_azos_ad_mail_option');

        $mail_app = [];
        $mail_app['mailFrom'] = isset($_POST['mailFrom'])?sanitize_text_field($_POST['mailFrom']):'';
        $mail_app['mailTo'] = isset($_POST['mailTo'])?sanitize_text_field($_POST['mailTo']):'';
        $mail_app['saveToSentItems'] = isset($_POST['saveToSentItems'])?sanitize_text_field($_POST['saveToSentItems']):'';
        
        wpWrapper::mo_azos_set_option("mo_azos_ad_mail_config",$mail_app);

        wpWrapper::mo_azos__show_success_notice(esc_html__("Configurations Saved Successfully."));
    }

    private function mo_azos_send_test_mail_option(){
        check_admin_referer('mo_azos_send_test_mail_option');

        $data = wpWrapper::mo_azos_get_option('mo_azos_application_config');
        if(!$data || empty($data)){
            return;
        }
        $azure_client = Azure::getClient($data);
        $status = $azure_client->mo_azos_send_mail_to_azure_user();

        if(is_bool($status)){
            wpWrapper::mo_azos__show_success_notice(esc_html__("Test Email Sent successfully."));
            return;
        }

        wpWrapper::mo_azos__show_error_notice(esc_html__($status));
    }

    private function mo_azos_send_ad_mail_on_user_register_save_settings(){
        check_admin_referer('mo_azos_send_ad_mail_on_user_register_option');
        
        $mail_on_user_register_app = [];
        $mail_on_user_register_app['message'] = isset($_POST['message'])?$_POST['message']:'';
        // $mail_on_user_register_app['message'] = explode(PHP_EOL,$mail_on_user_register_app['message']);
        // $mail_on_user_register_app['message'] = implode("\n",$mail_on_user_register_app['message']);
        $mail_on_user_register_app['sendToNewUser'] = isset($_POST['sendToNewUser'])?$_POST['sendToNewUser']:'';

        if($mail_on_user_register_app['sendToNewUser'] == "on"){
            $mail_app = wpWrapper::mo_azos_get_option('mo_azos_ad_mail_config');
            if(!isset($mail_app['mailFrom'])){
                wpWrapper::mo_azos__show_error_notice(esc_html__("From value to send email is not configured."));
                return;
            }
        }
        
        wpWrapper::mo_azos_set_option("mo_azos_ad_mail_on_user_register_config",$mail_on_user_register_app);

        wpWrapper::mo_azos__show_success_notice(esc_html__("Configurations Saved Successfully."));

    }
}