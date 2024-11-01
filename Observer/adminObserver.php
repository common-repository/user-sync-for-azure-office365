<?php

namespace MoAzureObjectSync\Observer;

use DateTime;
use DateTimeZone;
use MoAzureObjectSync\API\Azure;
use MoAzureObjectSync\API\CustomerMOAZOS;
use MoAzureObjectSync\Wrappers\pluginConstants;
use MoAzureObjectSync\Wrappers\wpWrapper;

class adminObserver{

    private static $obj;

    public static function getObserver(){
        if(!isset(self::$obj)){
            self::$obj = new adminObserver();
        }
        return self::$obj;
    }

    public function mo_azos_admin_observer(){


        if (wpWrapper::mo_azos_get_option(pluginConstants::PLUGIN_ACTIVATED)) {
			wpWrapper::mo_azos_delete_option(pluginConstants::PLUGIN_ACTIVATED);
			
            wp_safe_redirect(admin_url() . 'admin.php?page=mo_azos_welcome_page');
            exit;
		}

        $push_user_to_ad = get_option('push_user_to_ad');
        if(isset($_REQUEST['option']) && $_REQUEST['option'] == 'push_user_to_ad'){
            $username_id = $_REQUEST['username_id'];
            update_option('push_user_to_ad',$username_id);
            wp_redirect(remove_query_arg(['option','username_id'],admin_url('users.php')));
            exit();

        }

        if(!empty($push_user_to_ad)){
            delete_option('push_user_to_ad');
            $this->mo_azos_push_user_to_ad($push_user_to_ad);
        }

        if(isset($_REQUEST['option']) && $_REQUEST['option'] == 'testUser'){
            $config = wpWrapper::mo_azos_get_option('mo_azos_application_config');
            if(!isset($config['upn_id']) || empty($config['upn_id'])){
                $error_code = [
                     "Error" => "EmptyUPN",
                    "Description" => "UPN is not configured in the plugin or incorrect."
                ];
                $this->mo_azos_display_error_message($error_code);
            }
            $client = Azure::getClient($config);
            $user_details = $client->mo_azos_get_specific_user_detail();
            $user_details = wpWrapper::mo_azos_array_flatten_attributes($user_details);

            if(isset($user_details['error|code'])){
                $this->mo_azos_display_error_message($user_details);
            }

            $profile_pic = $client->mo_azos_get_profile_pic($user_details['id']);

            if(!empty($profile_pic)){
                $user_details['Profile Picture'] = $profile_pic;
            }

            $this->mo_azos_display_test_attributes($user_details);
        }

        if(isset($_REQUEST['option']) && $_REQUEST['option'] == 'pre-integrated_app_status'){
            echo '<div style="display:flex;justify-content:center;align-items:center;flex-direction:column;border:1px solid #eee;padding:10px;">
            <div style="width:90%;color: #3c763d;background-color: #dff0d8;padding: 2%;margin-bottom: 20px;text-align: center;border: 1px solid #AEDB9A;font-size: 18pt;">
                Success
            </div>';
            die();
        }

        if(isset($_REQUEST['option']) && $_REQUEST['option'] == 'generateApp'){
            $customer_tenant_id = 'common';
            $mo_client_id = base64_decode(pluginConstants::CID);
            wp_redirect("https://login.microsoftonline.com/$customer_tenant_id/oauth2/authorize?response_type=code&client_id=$mo_client_id&scope=openid&redirect_uri=https://connect.xecurify.com/&state=".home_url()."");
            exit();
        }

        if(isset($_REQUEST['code'])){

            wpWrapper::mo_azos_delete_option(pluginConstants::azos_refresh_token);
            wpWrapper::mo_azos_set_option(pluginConstants::azos_auth_code,$_REQUEST['code']);
            
            $config = wpWrapper::mo_azos_get_option('mo_azos_application_config');
            $client = Azure::getClient($config);
            $client->mo_azos_get_access_token_for_automatic_app_creation();
            
            wp_safe_redirect(admin_url('?option=pre-integrated_app_status'));
            exit();
        }

        if(isset($_REQUEST['option']) && $_REQUEST['option'] == 'mo_azos_contact_us_query_option'){
            $submited = $this->mo_azos_send_support_query();
            if(!is_null($submited)){
                if ( $submited == false ) {
                    wpWrapper::mo_azos__show_error_notice(esc_html__("Your query could not be submitted. Please try again."));
                } else {
                    wpWrapper::mo_azos__show_success_notice(esc_html__("Thanks for getting in touch! We shall get back to you shortly."));
                }
            }
        }

        if(isset($_REQUEST['option']) && $_REQUEST['option'] == 'mo_azos_feedback'){

            $submited = $this->mo_azos_send_email_alert();

           
            if ( json_last_error() == JSON_ERROR_NONE ) {
                if ( is_array( $submited ) && array_key_exists( 'status', $submited ) && $submited['status'] == 'ERROR' ) {
                    wpWrapper::mo_azos__show_error_notice(esc_html__($submited['message']));
                }
                else {
                    if ( $submited == false ) {
                        wpWrapper::mo_azos__show_error_notice(esc_html__("Error while submitting the query."));
                    }
                }
            }

            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
           
            deactivate_plugins( MO_AZOS_PLUGIN_FILE );
            wpWrapper::mo_azos__show_success_notice(esc_html__("Thank you for the feedback."));
            
        }

        if(isset($_REQUEST['option']) && $_REQUEST['option'] == 'mo_azos_skip_feedback'){


            $submited = $this->mo_azos_send_email_alert(true);

           
            if ( json_last_error() == JSON_ERROR_NONE ) {
                if ( is_array( $submited ) && array_key_exists( 'status', $submited ) && $submited['status'] == 'ERROR' ) {
                    wpWrapper::mo_azos__show_error_notice(esc_html__($submited['message']));
                }
                else {
                    if ( $submited == false ) {
                        wpWrapper::mo_azos__show_error_notice(esc_html__("Error while submitting the query."));
                    }
                }
            }

            wpWrapper::mo_azos__show_success_notice(esc_html__("Plugin deactivated successfully."));
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
           
            deactivate_plugins( MO_AZOS_PLUGIN_FILE );
        }

        if(isset($_REQUEST['option']) && $_REQUEST['option'] == 'mo_azos_demo_request_option'){
            $features_list = pluginConstants::DEMO_REQUEST_FEATURES_LIST;

            $addons_selected = array();
            foreach($features_list as $key => $value){
                if(isset($_POST[$key]) && $_POST[$key] == "on")
                    $addons_selected[$key] = $value;
            }

            $submited = $this->mo_azos_send_demo_request($addons_selected);
        }
    }

    private function mo_azos_send_demo_request($addons_selected){

        if(isset($_POST['demo_email']))
            $demo_email = htmlspecialchars($_POST['demo_email']);

        if(isset($_POST['demo_desc']))
            $demo_desc = htmlspecialchars($_POST['demo_desc']);

            $message = "[Demo For Customer] : " . $demo_email;
     
            if(!empty($demo_desc))
                $message .= " <br>[Requirements] : " . $demo_desc;

            $message .= " <br>[Status] : " .'Please setup a demo for user sync for Azure AD/B2C premium plugin';
            if(!empty($addons_selected)){
                $message .= " <br>[Featues Interested] : ";
                foreach($addons_selected as $key => $value){
                    $message .= $value;
                    if(next($addons_selected))
                        $message .= ", ";
                }
            }

            $user = wp_get_current_user();
            $customer = new CustomerMOAZOS();
            $email = get_option( "mo_saml_admin_email" );
            if ( $email == '' ) {
                $email = $user->user_email;
            }
            $phone = get_option( 'mo_saml_admin_phone' );
            $submited = json_decode( $customer->mo_azos_send_email_alert( $email, $phone, $message, true ), true );
            if ( json_last_error() == JSON_ERROR_NONE ) {
                if ( is_array( $submited ) && array_key_exists( 'status', $submited ) && $submited['status'] == 'ERROR' ) {
                    wpWrapper::mo_azos__show_error_notice(esc_html__($submited['message']));
                }
                else {
                    wpWrapper::mo_azos__show_success_notice('Thanks! We have received your request and will shortly get in touch with you.');
                }
            }



    }

    private function mo_azos_push_user_to_ad($wp_username){

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

    private function mo_azos_send_email_alert($isSkipped = false){
        $user = wp_get_current_user();

        $message = 'Plugin Deactivated';

        $deactivate_reason_message = array_key_exists( 'query_feedback', $_POST ) ? htmlspecialchars($_POST['query_feedback']) : false;

        if($isSkipped)
            $deactivate_reason_message = "skipped";

        $reply_required = '';
        if(isset($_POST['get_reply']))
            $reply_required = htmlspecialchars($_POST['get_reply']);
        if(empty($reply_required)){
            $reply_required = "don't reply";
            $message.='<b style="color:red";> &nbsp; [Reply :'.$reply_required.']</b>';
        }else{
            $reply_required = "yes";
            $message.='[Reply :'.$reply_required.']';
        }

        if(is_multisite())
            $multisite_enabled = 'True';
        else
            $multisite_enabled = 'False';

        $message.= ', [Multisite enabled: ' . $multisite_enabled .']';
        
        $message.= ', Feedback : '.$deactivate_reason_message.'';
            
        $email = '';
        $rate_value = '';

        if (isset($_POST['rate']))
            $rate_value = htmlspecialchars($_POST['rate']);
        
        $message.= ', [Rating :'.$rate_value.']';

        if (isset($_POST['query_mail']))
            $email = $_POST['query_mail'];

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email = get_option('mo_saml_admin_email');
            if(empty($email))
                $email = $user->user_email;
        }
        $phone = get_option( 'mo_saml_admin_phone' );
        $feedback_reasons = new CustomerMOAZOS();

        $response = json_decode( $feedback_reasons->mo_azos_send_email_alert( $email, $phone, $message ), true );

        return $response;

    } 

    private function mo_azos_send_support_query(){
        $email    = sanitize_email($_POST['mo_azos_contact_us_email']);
        $phone    = htmlspecialchars($_POST['mo_azos_contact_us_phone']);
        $query    = htmlspecialchars($_POST['mo_azos_contact_us_query']);

        $query = '[WordPress AzureAD User Sync] ' . $query;
                
        if(array_key_exists('mo_azos_setup_call',$_POST)===true){
            $time_zone = $_POST['mo_azos_setup_call_timezone'];
            $call_date = $_POST['mo_azos_setup_call_date'];
            $call_time = $_POST['mo_azos_setup_call_time'];

            $local_timezone='Asia/Kolkata';
            $call_datetime=$call_date.$call_time;
            $convert_datetime = strtotime ( $call_datetime );
            $ist_date = new DateTime(date ( 'Y-m-d H:i:s' , $convert_datetime ), new DateTimeZone($time_zone));
            $ist_date->setTimezone(new DateTimeZone($local_timezone));

            $query = $query .  '<br><br>' .'Meeting Details: '.'('.$time_zone.') '. date('d M, Y  H:i',$convert_datetime). ' [IST Time -> '. $ist_date->format('d M, Y  H:i').']'.'<br><br>';

            $query = '[Call Request - WordPress AzureAD User Sync] ' . $query ;
        }


        $customer = new CustomerMOAZOS();
  
        $response = $customer->mo_azos_submit_contact_us($email,$phone,$query);

        return $response;
    }

    public function mo_azos_display_error_message($error_code){
        ?>
            <div style="width:100%;display:flex;flex-direction:column;justify-content:center;align-items:center;font-size:15px;margin-top:10px;width:100%;">
                
                <div style="width:86%;padding: 15px;text-align: center;background-color:#f2dede;color:#a94442;border: 1px solid #E6B3B2;font-size: 18pt;margin-bottom:20px;">
                    Error
                </div>

                <table class="mo-ms-tab-content-app-config-table" style="border-collapse:collapse;width:90%">
                    <tr>
                        <td align="center" style="padding: 30px 5px 30px 5px;border:1px solid #757575;" colspan="2"><h2><span>Test Configuration Failed</span></h2></td>
                    </tr>
                    <?php foreach ($error_code as $key => $value){
                       echo '<tr><td style="padding: 30px 5px 30px 5px;border:1px solid #757575;" class="left-div"><span style="margin-right:10px;"><b>'.esc_html($key).':</b></span></td>
                       <td style="padding: 30px 5px 30px 5px;border:1px solid #757575;" class="right-div"><span>'.esc_html($value).'</span></td></tr>';
                    }?>
                </table>
                <h3 style="margin:20px;">
                    Contact us at <a style="color:#dc143c" href="mailto:samlsupport@xecurify.com">samlsupport@xecurify.com</a>
                </h3>
            </div>
        <?php
        exit();
    }
    private function mo_azos_display_test_attributes($details){
        wpWrapper::mo_azos_set_option('mo_azos_test_config_attrs',$details);
        ?>
        <div style="display:flex;justify-content:center;align-items:center;flex-direction:column;border:1px solid #eee;padding:10px;">
                <div style="width:90%;color: #3c763d;background-color: #dff0d8;padding: 2%;margin-bottom: 20px;text-align: center;border: 1px solid #AEDB9A;font-size: 18pt;">
                    Success
                </div>
                    <div style="border-top:1px solid #eee;width:95%;"></div>

                    <div class="test-container" style="margin-top:10px;">
                    <table class="mo-ms-tab-content-app-config-table">
                        <tr>
                            <td align="center" colspan="2">
                                <span><h2>Test Attributes:</h2></span>
                            </td>
                        </tr>
                        <?php
                        if(isset($details['Profile Picture'])){
                            ?>
                                <tr>
                                    <td align="center" colspan="2">
                                        <div class="row">
                                        <div class="small-12 medium-2 large-2 columns">
                                            <div class="circle">
                                                <img width="90px" height="90px" class="mo_azos_profile_pic" src="<?php echo esc_html('data:image/jpeg;base64,'. $details['Profile Picture']);?>">
                                            </div>
                                        </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr><td></br></td></tr>
                            <?php
                        }
                        ?>
                        <?php
                        foreach ($details as $key => $value){
                            if(!is_array($value) && !empty($value) && $key !== 'Profile Picture'){
                            ?>
                            <tr>
                                <td class="left-div"><span><?php echo esc_html($key);?></span></td>
                                <td class="right-div"><span><?php echo esc_html($value);?></span></td>
                            </tr>
                            <?php
                            }
                        }
                        ?>
                    </table>
                </div>


                </div>
                
                
        </div>
        
        <?php
        $this->load_css();
        exit();
    }

    private function load_css(){
        ?>
        <style>
            .test-container{
                width: 100%;
                margin-top: -30px;
            }

            .mo-ms-tab-content-app-config-table{
                max-width: 1000px;
                background: white;
                padding: 1em 2em;
                margin: 2em auto;
                border-collapse:collapse;
                border-spacing:0;
                display:table;
                font-size:14pt;
            }

            .mo-ms-tab-content-app-config-table td.left-div{
                width: 40%;
                word-break: break-all;
                font-weight:bold;
                border:2px solid #949090;
                padding:2%;
            }
            .mo-ms-tab-content-app-config-table td.right-div{
                width: 40%;
                word-break: break-all;
                padding:2%;
                border:2px solid #949090;
                word-wrap:break-word;
            }
        </style>
        <?php
    }
}