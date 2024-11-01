<?php

namespace MoAzureObjectSync\View;
use MoAzureObjectSync\Wrappers\wpWrapper;

class appConfig{

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
            'app' => 'mo_azos_display__client_config',
        ];

        ?>
        <div class="mo-ms-tab-content" style="width: 60%">
            <h1>Configure Microsoft Graph Application</h1>
            <div>
                <div class="mo-ms-tab-content-left-border">
                    <?php
                        foreach ($tiles_arr as $key => $value){
                            $this->$value();
                        }
                    ?>
                </div>
            </div>
            </br></br></br>
        </div>
        <?php
    }

    private function mo_azos_display__client_config(){
        $app = wpWrapper::mo_azos_get_option('mo_azos_application_config');
        $is_automatic = wpWrapper::mo_azos_get_option('is_automatic_app_configured');
        $is_manual = wpWrapper::mo_azos_get_option('is_manual_app_configured');

        if(!$is_automatic && !$is_manual)
            $is_automatic = 1;

        ?>
        
            <div class="mo-ms-tab-content-tile">
                <div class="mo-ms-tab-content-tile-content">
                    <span style="font-size: 18px;font-weight: 200">
                    1. Basic App Configuration 
                    </span>
                    <div id="app_config_access_desc" class="mo_azos_help_desc">
                    </div>
                    </br>

                    <?php

                        $this->mo_azos_display_application_types(false,$is_automatic,$is_manual);
                        $this->mo_azos_display_manual_app_configurations($app,$is_manual);
                        $this->mo_azos_display_automatic_app_configurations($app,$is_automatic);
                        
                    ?>
                </div>
            </div>
        <script>
            function editName(){

            document.querySelector('#redirect_uri').removeAttribute('readonly');
            document.querySelector('#redirect_uri').focus();
            return false;

            }

            function mo_azos_sync_show_manual_configuration(){
                document.getElementById("manual_app_config").removeAttribute("hidden");
                document.getElementById("automatic_app_config").setAttribute("hidden","");
                document.getElementById("manual_app_type_block").style.border = "4px solid #1976D2";
                document.getElementById("auto_app_type_block").style.border = "";
                document.getElementById("manual_app_config").scrollIntoView({behavior: 'smooth'});
            }

            function mo_azos_sync_show_automatic_configuration(){
                document.getElementById("automatic_app_config").removeAttribute("hidden");
                document.getElementById("manual_app_config").setAttribute("hidden","");
                document.getElementById("manual_app_type_block").style.border = "";
                document.getElementById("auto_app_type_block").style.border = "4px solid #1976D2";
                document.getElementById("automatic_app_config").scrollIntoView({behavior: 'smooth'});
            }

            function goBackToApplicationTypes(){
                document.getElementById("manual_app_config").setAttribute("hidden","");
                document.getElementById("automatic_app_config").setAttribute("hidden","");
                document.getElementById("select_application_label").removeAttribute("hidden");
                document.getElementById("select_application_container").removeAttribute("hidden");
                document.getElementById("sync_dir_container").removeAttribute("hidden");
                
            }

            function showAttributeWindow(){
                document.getElementById("app_config").value = "mo_azos_app_test_config_option";
                var myWindow = window.open("<?php echo esc_url_raw($this->mo_azos_get_test_url()); ?>", "TEST User Attributes", "scrollbars=1 width=800, height=600");
            }

            function GenerateCustomerApp(){
                var myWindow = window.open("<?php echo esc_url_raw($this->mo_azos_get_url_to_generate_app()); ?>", "Generate Application", "scrollbars=1 width=600, height=400");
            }

            function changeSyncWay(sync_way){
                document.getElementById("sync_way_option").value = sync_way;
                document.getElementById("mo_azos_change_sync_form").submit();
            }

            function mo_azos_open_setup_guide(){
                window.open("https://plugins.miniorange.com/azure-ad-user-sync-wordpress-with-microsoft-graph","_blank");
            }

            jQuery("#app_config_access").click(function (e) {
                e.preventDefault();
                jQuery("#app_config_access_desc").slideToggle(400);
            });
        </script>
        <?php
    }

    private function mo_azos_display_application_types($is_configured,$is_automatic,$is_manual){
        $hidden = $is_configured?"hidden":"";
        ?>
                    <div <?php echo $hidden; ?> id="select_application_label">
                        <div style="font-size:15px;margin-top:10px;font-weight:500;">Select Application Type
                        </div>
                        <hr style="height:3px;background-color:#64B5F6;width:8%;float:left;border-radius:10px">
                    </div>

                    <div <?php echo $hidden; ?> id="select_application_container">
                    <div style="display:flex;justify-content:center;align-items:center;width:100%;height:100%;">
                        <div id="auto_app_type_block" style="display:flex;justify-content:cente;align-items:center;align-content:center;flex-direction:column;width:50%;height:300px;margin:10px;border:<?php echo $is_automatic?'4px solid #1976D2':''?>;box-shadow: 1px 2.5px 6px 6px rgb(207 207 207);">

                        <div>
                        <img style="margin-top:15px;transform:scale(1.5)" width="55" height="55" src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/automatic-adv.svg');?>">
                        </div>
                        

                        <div style="font-size: 16px;font-weight: 600;justify-content: center;line-height: 1.25;margin-top:10px;">Automatic (Pre-Integrated App)</div>

                        <div style="display: flex;justify-content:center;align-items:center">
                            <div><input type="button" style="background-color: #17a2b8!important;cursor: pointer;height: 40px;font-size: 16px;padding: 0;color: #fff;width: 150px;font-size: 16px;border: none;box-shadow: inset 2px 2px 2px 0 rgb(255 255 255 / 50%), 7px 7px 20px 0 rgb(0 0 0 / 10%), 4px 4px 5px 0 rgb(0 0 0 / 10%);border-radius: 9px;margin-top:10px" id="Automatic_Config" value="Get Started" onclick="mo_azos_sync_show_automatic_configuration()"></div>

                            <div><input type="button" style="background-color: #039BE5!important;cursor: pointer;height: 40px;font-size: 16px;padding: 0;color: #fff;width: 150px;font-size: 16px;border: none;box-shadow: inset 2px 2px 2px 0 rgb(255 255 255 / 50%), 7px 7px 20px 0 rgb(0 0 0 / 10%), 4px 4px 5px 0 rgb(0 0 0 / 10%);border-radius: 9px;margin-top:10px;margin-left:5px" id="Automatic_Config" value="Setup Guide" onclick="mo_azos_open_setup_guide()"></div>
                        </div>

                        <div style="background: #d5e2ff;padding: 0.2rem 1.5rem;border-radius: 5px;font-size: 1.2em;line-height: 1.4;margin:15px" >
                            <h5>
                                <span>
                                    This will require to have Tenant Adminstrator credntials to authorize and create the Azure AD application in your tenant automatically without configuring client ID and client secret.
                                </span>
                            </h5>
					    </div>

                        </div>

                        <div id="manual_app_type_block" style="display:flex;justify-content:center;align-items:center;align-content:center;flex-direction:column;border:<?php echo $is_manual?'4px solid #1976D2':''?>;width:50%;height:300px;margin:10px;box-shadow: 1px 2.5px 6px 6px rgb(207 207 207);">

                        <img style="margin-top:10px;" width="80" height="80" src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/manual-adv.svg');?>">

                        <div style="font-size: 16px;font-weight: 600;justify-content: center;line-height: 1.25;margin-top:10px;">Manual (Custom App)</div>

                        <div style="display: flex;justify-content:center;align-items:center">
                            <div><input type="button" style="background-color: #17a2b8!important;cursor: pointer;height: 40px;font-size: 16px;padding: 0;color: #fff;width: 150px;font-size: 16px;border: none;box-shadow: inset 2px 2px 2px 0 rgb(255 255 255 / 50%), 7px 7px 20px 0 rgb(0 0 0 / 10%), 4px 4px 5px 0 rgb(0 0 0 / 10%);border-radius: 9px;margin-top:10px" id="Automatic_Config" value="Get Started" onclick="mo_azos_sync_show_manual_configuration()"></div>

                            <div><input type="button" style="background-color: #039BE5!important;cursor: pointer;height: 40px;font-size: 16px;padding: 0;color: #fff;width: 150px;font-size: 16px;border: none;box-shadow: inset 2px 2px 2px 0 rgb(255 255 255 / 50%), 7px 7px 20px 0 rgb(0 0 0 / 10%), 4px 4px 5px 0 rgb(0 0 0 / 10%);border-radius: 9px;margin-top:10px;margin-left:5px" id="Automatic_Config" value="Setup Guide" onclick="mo_azos_open_setup_guide()"></div>
                        </div>
                        
                        <div style="background: #d5e2ff;padding: 0.2rem 1.5rem;border-radius: 5px;font-size: 1.2em;line-height: 1.4;margin:15px" >
                            <h5>
                                <span>
                                This will require to create Azure AD application in your tenant. You are required to enter the client credentials (client id and client secret) by creating an application in your Azure AD Tenant.
                                </span>
                            </h5>
					    </div>
                    
                        </div>
                    </div>
                    </div>
        <?php
    }

    private function mo_azos_display_manual_app_configurations($app,$is_manual){

        $client_id = !empty($app['client_id'])?$app['client_id']:'';
        $redirect_uri = !empty($app['redirect_uri'])?$app['redirect_uri']:site_url();
        $tenant_id = !empty($app['tenant_id'])?$app['tenant_id']:'';
        $tenant_name = !empty($app['tenant_name'])?$app['tenant_name']:'';
        $upn_id = !empty($app['upn_id'])?$app['upn_id']:'';
        if(isset($app['client_secret']) && !empty($app['client_secret'])){
            $client_secret = wpWrapper::mo_azos_decrypt_data($app['client_secret'],hash("sha256",$client_id));
        }else{
            $client_secret = '';
        }

        $hidden = $is_manual?"":"hidden";

        ?>
            <form <?php echo $hidden; ?> id="manual_app_config" class="mo_azos_ajax_submit_form" id="app_config_form" action="" method="post">
                    <input type="hidden" name="option" id="app_config" value="mo_azos_client_config_option">
                    <input type="hidden" name="mo_azos_tab" value="app_config">
                    <?php wp_nonce_field('mo_azos_client_config_option');?>

                    <div>
                        <div  style="font-size:15px;margin-top:40px;font-weight:500;">Manual App Configurations
                        </div>
                        <hr style="height:3px;background-color:#64B5F6;width:8%;float:left;border-radius:10px">
                    </div>

                    <table class="mo-ms-tab-content-app-config-table">
                        <colgroup>
                            <col span="1" style="width: 15%;">
                            <col span="2" style="width: 75%;">
                        </colgroup>
                        <tr>
                            <td><span>Application ID <span style="color:red;font-weight:bold;">*</span></span></td>
                            <td>
                                <input placeholder="Enter Your Application (Client) ID" type="text" name="client_id" value="<?php echo esc_html($client_id);?>">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <b>Note:</b> You can find the <b>Application ID</b> in your Active Directory application's Overview tab. 
                            </td>
                        </tr>
                        <tr>
                            <td></br></td>
                        </tr>
                        <tr>
                            <td><span>Client Secret <span style="color:red;font-weight:bold;">*</span></span></td>
                            <td><input placeholder="Enter Your Client Secret" type="password" name="client_secret" value="<?php echo esc_html($client_secret);?>"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <b>Note:</b> You can find the <b>Client Secret</b> value in your Active Directory application's Certificates & Secrets tab. 
                            </td>
                        </tr>
                        <tr>
                            <td></br></td>
                        </tr>
                        <tr>
                            <td><span>Redirect URI <span style="color:red;font-weight:bold;">*</span></span></td>
                            <td>
                                <input readonly="readonly" placeholder="Enter Redirect URI of Your Application" type="url" id="redirect_uri" name="redirect_uri" value="<?php echo esc_html($redirect_uri);?>">
                            </td>
                            <td>
                                <input type="radio" name="edit" id="edit" onclick="editName()" value=""/>
                                <label  for="edit"><img class="editable" src="<?php echo esc_url(plugin_dir_url( __FILE__ ) . '../images/61456.png'); ?>" />
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <b>Note:</b> This is your WordPress site URL 
                            </td>
                        </tr>
                        <tr>
                            <td></br></td>
                        </tr>
                        <tr>
                            <td><span>Tenant ID <span style="color:red;font-weight:bold;">*</span></span></td>
                            <td><input placeholder="Enter Your Directory (Tenant) ID" type="text" name="tenant_id" value="<?php echo esc_html($tenant_id);?>"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <b>Note:</b> You can find the <b>Tenant ID</b> in your Active Directory application's Overview tab. 
                            </td>
                        </tr>
                        <tr>
                            <td></br></td>
                        </tr>
                        <tr>
                            <td><span>Tenant Name (Primary Domain)</span></td>
                            <td><input placeholder="Enter Your Directory (Tenant) Name For ex. demo.onmicrosoft.com" type="text" name="tenant_name" value="<?php echo esc_html($tenant_name);?>"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <b>Note:</b> You can find the <b>Tenant Name</b> in your Active Directory's Overview tab under primary domain. 
                            </td>
                        </tr>
                        <tr>
                            <td></br></td>
                        </tr>
                        <tr>
                            <td><span>Test UPN/ID</span></td>
                            <td ><input placeholder="Enter UserPrincipalName/Object ID of User To Test (optional)" type="text" name="upn_id" value="<?php echo esc_html($upn_id);?>"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <b>Note:</b> You can find the <b>User Principle Name / Object ID</b> in the user profile in Users tab in your active directory. You can click on <b>Test Configuration</b> to see all the attributes of this user.
                            </td>
                        </tr>
                        <tr><td colspan="2"></td></tr>
                    </table>
                    <div>
                        <div style="display: flex;justify-content:center;align-items:center;">
                            <div style="display: flex;margin:10px;">
                                <input style="height:30px;" type="submit" id="saveButton" class="mo-ms-tab-content-button" value="Save">
                            </div>
                            <div hidden id="automatic_app_button" style="margin:10px;">
                                <input style="height:30px;" id="generate_app" type="button" class="mo-ms-tab-content-button" value="Connect To Azure AD" onclick="GenerateCustomerApp()">
                            </div>
                            <div style="margin:10px;">
                                <input style="height:30px;" id="view_attributes" type="button" class="mo-ms-tab-content-button" value="Test Configuration" onclick="showAttributeWindow()">
                            </div>
                            <!-- <div style="margin:10px;">
                                <input style="height:30px;" type="button" class="mo-ms-tab-content-button" value="Go back to application types" onclick="goBackToApplicationTypes()">
                            </div> -->
                        </div>
                    </div>
                    </form>
        <?php
    }

    private function mo_azos_display_automatic_app_configurations($app,$is_automatic){
        $tenant_name = !empty($app['tenant_name'])?$app['tenant_name']:'';
        $upn_id = !empty($app['upn_id'])?$app['upn_id']:'';
        $hidden = $is_automatic?"":"hidden";

        ?>
            <form <?php echo $hidden; ?> class="mo_azos_automatic_app_form" id="automatic_app_config" action="" method="post">
                        <input type="hidden" name="option" id="app_config" value="mo_azos_automatic_client_config_option">
                        <input type="hidden" name="mo_azos_tab" value="app_config">
                        <?php wp_nonce_field('mo_azos_automatic_client_config_option');?>
                    
                    <div>
                        <div  style="font-size:15px;margin-top:40px;font-weight:500;">Automatic App Configurations
                        </div>
                        <hr style="height:3px;background-color:#64B5F6;width:8%;float:left;border-radius:10px">
                    </div>

                    <table class="mo-ms-tab-content-app-config-table">
                        <colgroup>
                            <col span="1" style="width: 15%;">
                            <col span="2" style="width: 75%;">
                        </colgroup>
                        <tr>
                            <td></br></td>
                        </tr>
                        <tr>
                            <td><span>Tenant Name (Primary Domain)</span></td>
                            <td><input placeholder="Enter Your Directory (Tenant) Name For ex. demo.onmicrosoft.com" type="text" name="tenant_name" value="<?php echo esc_html($tenant_name);?>"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <b>Note:</b> You can find the <b>Tenant Name</b> in your Active Directory's Overview tab under primary domain. 
                            </td>
                        </tr>
                        <tr>
                            <td></br></td>
                        </tr>
                        <tr>
                            <td><span>Test UPN/ID</span></td>
                            <td ><input placeholder="Enter UserPrincipalName/Object ID of User To Test (optional)" type="text" name="upn_id" value="<?php echo esc_html($upn_id);?>"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <b>Note:</b> You can find the <b>User Principle Name / Object ID</b> in the user profile in Users tab in your active directory. You can click on <b>Test Configuration</b> to see all the attributes of this user.
                            </td>
                        </tr>
                        <tr><td colspan="2"></td></tr>
                    </table>
                        <div>
                            <div style="display: flex;justify-content:center;align-items:center;">
                                <div style="display: flex;margin:10px;">
                                    <input style="height:30px;" type="submit" id="saveButton" class="mo-ms-tab-content-button" value="Save">
                                </div>
                                <div id="automatic_app_button" style="margin:10px;">
                                    <input style="height:30px;" id="generate_app" type="button" class="mo-ms-tab-content-button" value="Connect To Azure AD" onclick="GenerateCustomerApp()">
                                </div>
                                <div style="margin:10px;">
                                    <input style="height:30px;" id="view_attributes" type="button" class="mo-ms-tab-content-button" value="Test Configuration" onclick="showAttributeWindow()">
                                </div>
                                <!-- <div style="margin:10px;">
                                    <input style="height:30px;" type="button" class="mo-ms-tab-content-button" value="Go back to application types" onclick="goBackToApplicationTypes()">
                                </div> -->
                            </div>
                        </div>
                    </form>
        <?php
    }

    private function mo_azos_get_test_url(){
        return admin_url('?option=testUser');
    }

    private function mo_azos_get_url_to_generate_app(){
        return admin_url('?option=generateApp');
    }
}