<?php

namespace MoAzureObjectSync\View;

use MoAzureObjectSync\Wrappers\wpWrapper;

class adMail{

    private static $instance;

    public static function getView(){
        if(!isset(self::$instance)){
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }

    public function mo_azos_display__tab_details(){
        $tiles_arr = [
            'basic' => 'mo_azos_display_ad_mail_settings',
            'adv' => 'mo_azos_send_ad_mail_on_user_register',
        ];
    
        ?>
    
        <div class="mo-ms-tab-content" style="width: 60%">
            <h1>Send Mails using Microsoft Graph</h1>
            <div class="mo-ms-tab-content-left-border">
                <?php
                foreach ($tiles_arr as $key => $value){
                    $this->$value();
                }
                ?>
            </div>
        </div>
    <?php
    }

    public function mo_azos_display_ad_mail_settings(){
        $mail_app = wpWrapper::mo_azos_get_option('mo_azos_ad_mail_config');
        $mailFrom = !empty($mail_app['mailFrom'])?$mail_app['mailFrom']:'';
        $mailTo = !empty($mail_app['mailTo'])?$mail_app['mailTo']:'';
        $saveToSentItems = !empty($mail_app['saveToSentItems'])?$mail_app['saveToSentItems']:'';
        ?>
        <form class="mo_azos_ajax_submit_form" action="" method="post">
            <input type="hidden" name="option" id="ad_mail" value="mo_azos_ad_mail_option">
            <input type="hidden" name="mo_azos_tab" value="app_config">
            <?php wp_nonce_field('mo_azos_ad_mail_option');?>
            <div class="mo-ms-tab-content-tile">
                <div class="mo-ms-tab-content-tile-content">
                        <span style="font-size: 18px;font-weight: 200;">1. Send Emails Manually
                            
                        </span>
                        <div id="send_email_attr_access_desc" class="mo_azos_help_desc">
                            <span>
                            You can send a email using your licensed microsoft office365 exchange account's userprinciplename to any other user
                            email.
                            </span>
                        </div>
                    
                        <table class="mo-ms-tab-content-app-config-table">
                        <colgroup>
                            <col span="1" style="width: 20%;">
                            <col span="2" style="width: 80%;">
                        </colgroup>
                        <tr>
                            <td><span>From <span style="color:red;font-weight:bold;">*</span></span></td>
                            <td>
                                <input required placeholder="Enter UserPrincipalName/Object ID e.g. user@example.onmicrosoft.com" type="email" name="mailFrom" value="<?php echo esc_html($mailFrom);?>">
                            </td>
                        </tr>
                        <tr>
                            <td><span>To <span style="color:red;font-weight:bold;">*</span></span></td>
                            <td><input required placeholder="Enter Any Test User Email e.g. user@example.com" type="email" name="mailTo" value="<?php echo esc_html($mailTo);?>"></td>
                        </tr>
                        <tr>
                            <td><span>Save Emails to Sent Items</span></td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" name="saveToSentItems" <?php echo $saveToSentItems === "on"?"checked":""; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                        </tr>
                        </table>
                        <fieldset style="border:2px solid #eee;padding:10px;margin-top:0px;background-color:#ECEFF1;border-radius:8px">
                        <legend style="font-size: 13px;color:red;font-weight:600;margin-left:auto;">
                        [Available in Premium Plugin]
                        </legend>
                        <table class="mo-ms-tab-content-app-config-table" style="margin-top:0px;">
                            <colgroup>
                                <col span="1" style="width: 20%;">
                                <col span="2" style="width: 80%;">
                            </colgroup>
                            <tr>
                                <td ><span>CC</span></td>
                                <td><div style="border:1px solid #eee;background-color:rgba(255,255,255,.5);height:30px;width:100%;border-radius:5px;display:flex;justify-content:flex-start;align-items:center;">
                                    <div style="background-color:#eee;border-radius:10px;width:120px;height:24px;font-size:9px;display:flex;justify-content:space-around;align-items:center;margin:5px">
                                        <span>demo1@example.com</span>
                                        <span style="border-radius:50%;background-color:#fff;display:flex;justify-content:center;align-items:center;width:10px;height:10px;font-size:8px;">X</span>
                                    </div>
                                    <div style="background-color:#eee;border-radius:10px;width:120px;height:24px;font-size:9px;display:flex;justify-content:space-around;align-items:center;margin:5px">
                                        <span>demo2@example.com</span>
                                        <span style="border-radius:50%;background-color:#fff;display:flex;justify-content:center;align-items:center;width:10px;height:10px;font-size:8px;">X</span>
                                    </div>
                                </div></td>
                            </tr>
                            <tr>
                                <td><span>BCC</span></td>
                                <td><div style="border:1px solid #eee;background-color:rgba(255,255,255,.5);height:30px;width:100%;border-radius:5px;display:flex;justify-content:flex-start;align-items:center;">
                                    <div style="background-color:#eee;border-radius:10px;width:120px;height:24px;font-size:9px;display:flex;justify-content:space-around;align-items:center;margin:5px">
                                        <span>demo@example.com</span>
                                        <span style="border-radius:50%;background-color:#fff;display:flex;justify-content:center;align-items:center;width:10px;height:10px;font-size:8px;">X</span>
                                    </div>
                                </div></td>
                            </tr>
                            <tr>
                                <td><span>Subject</td>
                                <td><input disabled style="border:1px solid #eee;" placeholder="" type="text" name="tenant_id" value="<?php echo esc_html("Graph Mail Test");?>"></td>
                            </tr>
                            <tr>
                                <td><span>Text/HTML</span></td>
                                <td >
                                <select disabled placeholder="" type="text" name="mo_azos_select_text_format" value="">
                                    <option class="Select-placeholder" value="" disabled>Select Format</option>
                                    <option value="text_format">Text</option>
                                    <option value="html_format">HTML</option>
                                </select></td>
                            </tr>
                            <tr>
                                <td><span>Content</td>
                                <td><textarea disabled class="mo_azos_table_textbox" style="width:100%" name="mo_azos_contact_us_query" rows="7" style="resize: vertical;" >Hi, You are recieving this test email using Microsoft Graph API.</textarea></td>
                            </tr>
                            <tr>
                                <td><span>Attachments</span></td>
                                <td><input disabled type="file" name="mo_azos_email_to" value="<?php echo esc_html("");?>"></td>
                            </tr>
                            <tr><td colspan="2"></td></tr>
                        </table>
                        </fieldset>
                    <div style="display: flex;justify-content:flex-start;align-items:center;">
                        <div style="display: flex;margin:10px;">
                            <input style="height:30px;" type="submit" id="saveButton" class="mo-ms-tab-content-button" value="Save">
                        </div>
                        <div style="margin:10px;">
                            <input style="height:30px;" id="ad_send_email" type="button" class="mo-ms-tab-content-button" value="Send Test Email">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form id="mo_azos_send_test_mail_form" method="post">
            <input type="hidden" value="mo_azos_send_test_mail_option" name="option">
            <input type="hidden" name="mo_azos_tab" value="app_config">
            <?php wp_nonce_field('mo_azos_send_test_mail_option');?>
        </form>
        <script>
            document.getElementById('ad_send_email').addEventListener('click',function (){
                document.getElementById('mo_azos_send_test_mail_form').submit();
            });
        </script>
        <?php
    }

    public function mo_azos_send_ad_mail_on_user_register(){
        $mail_on_user_register_app = wpWrapper::mo_azos_get_option('mo_azos_ad_mail_on_user_register_config');
        $message = !empty($mail_on_user_register_app['message'])?$mail_on_user_register_app['message']:'';
        $sendToNewUser = !empty($mail_on_user_register_app['sendToNewUser'])?$mail_on_user_register_app['sendToNewUser']:'';
        ?>
        <form class="mo_azos_ajax_submit_form" action="" method="POST">
            <input type="hidden" name="option" id="ad_mail" value="mo_azos_send_ad_mail_on_user_register_option">
            <input type="hidden" name="mo_azos_tab" value="app_config">
            <?php wp_nonce_field('mo_azos_send_ad_mail_on_user_register_option');?>
            <div class="mo-ms-tab-content-tile">
                <div class="mo-ms-tab-content-tile-content">
                    <span style="font-size: 18px;font-weight: 200;">2. Send Emails on User Registration
                    </span>
                    <div id="send_email_on_register_attr_access_desc" class="mo_azos_help_desc">
						<span>
                        Enable this option to send a welcome email when new user is synced/registred on your WordPress site. 
                         </span>
                    </div>
                    <table class="mo-ms-tab-content-app-config-table">
                        <colgroup>
                            <col span="1" style="width: 26%;">
                            <col span="1" style="width: 80%;">
                        </colgroup>
                        <tr>
                            <td><span>Send welcome email to new users</span></td>
                            <td>
                                <div style="display: flex">
                                    <div style="padding-right: 15px;padding-top: 2px;">
                                        <label class="switch">
                                            <input type="checkbox" name="sendToNewUser" <?php echo $sendToNewUser === "on"?"checked":""; ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><textarea disabled class="mo_azos_table_textbox" style="width:100%;border:1px solid #eee;" name="message" rows="7" style="resize: vertical;" ><?php echo !empty($message) ? esc_html($message) : "Hi there,\r\n\nWelcome to ".esc_html(get_option('blogname'))."!\nIf you have any problems, please contact me at ".esc_html(get_option('admin_email'))."."; ?></textarea></td>
                        </tr>
                    </table>
                    <table class="mo-ms-tab-content-app-config-table">
                        <colgroup>
                            <col span="1" style="width: 28%;">
                            <col span="1" style="width: 58%;">
                        </colgroup>
                        <tr>
                            <td><span>Send email to users when role / membership changed</span></td>
                            <td>
                                <div style="display: flex">
                                    <div style="padding-right: 15px;padding-top: 2px;">
                                        <label class="switch">
                                            <input disabled type="checkbox" name="sendToNewUser">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><textarea disabled class="mo_azos_table_textbox" style="width:100%;border:1px solid #eee;" name="message" rows="7" style="resize: vertical;" ><?php echo "Hi there,\r\n\nYour role has been changed recently.\nIf you have any problems, please contact me at ".esc_html(get_option('admin_email'))."."; ?></textarea></td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex">
                                    <input type="submit" class="mo-ms-tab-content-button" value="Save">
                                    <input type="submit" disabled style="margin-left:10px;background-color: #DCDAD1;border:none;" class="mo-ms-tab-content-button" value="Send Reset Password Link to All Users">
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
        <?php
    }

    
}