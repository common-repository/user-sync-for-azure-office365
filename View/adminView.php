<?php


namespace MoAzureObjectSync\View;

use MoAzureObjectSync\Wrappers\wpWrapper;

class adminView{

    private static $instance;

    public static function getView(){
        if(!isset(self::$instance)){
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }

    public function mo_azos_menu_display(){
        if( isset( $_GET[ 'tab' ] ) ) {
            $active_tab = sanitize_text_field($_GET['tab']);
        }else{
            $active_tab = 'app_config';
        }
        $this->mo_azos_display_tabs($active_tab);
    }

    private function mo_azos_display_tabs($active_tab){
        

        if($active_tab == 'integrations'){
            $this->mo_azos_display__integration_page();
        }else{
            $this->mo_azos_display__tab_container($active_tab);
        }

    }

    private function mo_azos_display__tab_container($active_tab){
        echo '<div style="display:flex;justify-content:space-between;align-items:flex-start;padding-top:8px;">
            <div style="width:98%;" id="mo_azos_container" class="mo-container">';
            $this->mo_azos_display__header_menu();
            $this->mo_azos_display__tabs($active_tab);
            echo '<div style="display:flex;justify-content:space-between;align-items:flex-start;">';
            $this->mo_azos_display__tab_content($active_tab);
            $supportFormHandler = supportForm::getView();
            $supportFormHandler->mo_azos_display_support_form(); 
            echo '</div></div>';
            
        echo'</div>';
    } 

    private function mo_azos_display__header_menu(){
       ?>
        <div class="mo_azos_heading_container">
            <img id="mo-ms-title-logo" src="<?php echo esc_url(plugin_dir_url(MO_AZOS_PLUGIN_FILE).'images/miniorange.png');?>">
            <h1><label for="sync_integrator">User Sync for Azure AD / Azure B2C</label></h1>
            <a class="mo_azos_integration_button" style="margin-left:10px;" href='<?php echo esc_url(add_query_arg("tab","integrations")); ?>'>Office 365 Integrations</a>
            <!-- <a class="mo_azos_integration_button" style="margin-left:10px;" href='<?php echo esc_url(add_query_arg("tab","license_plan")); ?>'>Licensing Plan</a> -->
        </div>
        <?php
    }

    private function mo_azos_display__tabs($active_tab){
        $app = wpWrapper::mo_azos_get_option('mo_azos_application_config');
        ?>
        <div class="mo-ms-tab">
            <div class="mo-ms-tab-ul">
                <li id="app_config" class="mo-ms-tab-li">
                    <a href="<?php echo esc_url_raw(add_query_arg('tab','app_config'));?>">
                        <div id="application_div_id" class='mo-ms-tab-li-div <?php
                        if($active_tab == 'app_config'){
                            echo 'mo-ms-tab-li-div-active';
                        }
                        ?>' aria-label="Application" title="Application Configuration" role="button" tabindex="0">
                            <div id="add_icon" class="mo-ms-tab-li-icon" >
                                <img style="width:18px;height:18px;" src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/add-64.png');?>">
                            </div>
                            <div id="add_app_label" class="mo-ms-tab-li-label">
                                Manage Application
                            </div>
                        </div>
                    </a>
                </li>
                <li id="user_manage" class="mo-ms-tab-li" role="presentation" title="user_manage">
                    <a href="<?php echo esc_url(add_query_arg('tab','manage_users'));?>">
                        <div id="user_manage_div_id" class="mo-ms-tab-li-div <?php
                            if($active_tab == 'manage_users'){
                                echo 'mo-ms-tab-li-div-active';
                            }
                            ?>" aria-label="user_manage" title="User Management" role="button" tabindex="1">
                            <div id="user_manage_icon" class="mo-ms-tab-li-icon" >
                                <img  src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/users.svg');?>">
                            </div>
                            <div id="user_manage_label" class="mo-ms-tab-li-label">
                                Profile Mapping
                            </div>
                        </div>
                    </a>
                </li>
                <li id="wp_user_sync" class="mo-ms-tab-li" role="presentation" title="wp_user_sync">
                    <a href="<?php echo esc_url(add_query_arg('tab','wp_sync_users'));?>">
                        <div id="wp_user_sync_div_id" class="mo-ms-tab-li-div <?php
                            if($active_tab == 'wp_sync_users'){
                                echo 'mo-ms-tab-li-div-active';
                            }
                            ?>" aria-label="wp_user_sync" title="WordPress User Sync" role="button" tabindex="2">
                            <div id="ad_user_sync_icon" class="mo-ms-tab-li-icon" >
                                <img  src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/ad.svg');?>">
                            </div> 
                            <div id="wp_user_sync_label" class="mo-ms-tab-li-label">
                                Synchronization
                            </div>
                        </div>
                    </a>
                </li>
                <li id="powerbi" class="mo-ms-tab-li" role="presentation" title="powerbi">
                    <a href="<?php echo esc_url(add_query_arg('tab','powerbi'));?>">
                        <div id="powerbi_div_id" class="mo-ms-tab-li-div <?php
                            if($active_tab == 'powerbi'){
                                echo 'mo-ms-tab-li-div-active';
                            }
                            ?>" aria-label="powerbi" title="Mail" role="button" tabindex="4">
                            <div id="powerbi_icon" class="mo-ms-tab-li-icon" >
                                <img style="width:20px;height:20px;" src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/power-bi.svg');?>">
                            </div>
                            <div id="powerbi_label" class="mo-ms-tab-li-label">
                                Power BI
                            </div>
                        </div>
                    </a>
                </li>
                <li id="DCRM365" class="mo-ms-tab-li" role="presentation" title="DCRM365">
                    <a href="<?php echo esc_url(add_query_arg('tab','DCRM365'));?>">
                        <div id="DCRM365_div_id" class="mo-ms-tab-li-div <?php
                            if($active_tab == 'DCRM365'){
                                echo 'mo-ms-tab-li-div-active';
                            }
                            ?>" aria-label="DCRM365" title="Mail" role="button" tabindex="5">
                            <div id="DCRM365_icon" class="mo-ms-tab-li-icon" >
                                <img style="width:20px;height:20px;" src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/dynamics-crm.svg');?>">
                            </div>
                            <div id="DCRM365_label" class="mo-ms-tab-li-label">
                                Dynamics CRM 365
                            </div>
                        </div>
                    </a>
                </li>
                <li id="ad_mail" class="mo-ms-tab-li" role="presentation" title="ad_mail">
                    <a href="<?php echo esc_url(add_query_arg('tab','send_ad_mail'));?>">
                        <div id="ad_mail_div_id" class="mo-ms-tab-li-div <?php
                            if($active_tab == 'send_ad_mail'){
                                echo 'mo-ms-tab-li-div-active';
                            }
                            ?>" aria-label="ad_mail" title="Mail" role="button" tabindex="6">
                            <div id="ad_mail_icon" class="mo-ms-tab-li-icon" >
                                <img style="width:20px;height:20px;" src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/email.png');?>">
                            </div>
                            <div id="ad_mail_label" class="mo-ms-tab-li-label">
                                Mail
                            </div>
                        </div>
                    </a>
                </li>
                <li id="demo_request" class="mo-ms-tab-li" role="presentation" title="demo_request">
                    <a href="<?php echo esc_url(add_query_arg('tab','send_demo_request'));?>">
                        <div id="demo_request_div_id" class="mo-ms-tab-li-div <?php
                            if($active_tab == 'send_demo_request'){
                                echo 'mo-ms-tab-li-div-active';
                            }
                            ?>" aria-label="demo_request" title="Mail" role="button" tabindex="6">
                            <div id="demo_request_icon" class="mo-ms-tab-li-icon" >
                                <img style="width:20px;height:20px;" src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/demo.png');?>">
                            </div>
                            <div id="demo_request_label" class="mo-ms-tab-li-label">
                                Demo Request
                            </div>
                        </div>
                    </a>
                </li>
            </div>
        </div>
        <?php
    }

    private function mo_azos_display__tab_content($active_tab){
        $handler = self::getView();
        switch ($active_tab){
            case 'app_config':{
                $handler = appConfig::getView();
                break;
            }
            case 'manage_users':{
                $handler = manageUsers::getView();
                break;
            }
            case 'powerbi':{
                $handler = powerBI::getView();
                break;
            }
            case 'DCRM365':{
                $handler = dynamicsCRM365::getView();
                break;
            }
            case 'wp_sync_users':{
                $handler = wpSyncUsers::getView();
                break;
            }
            case 'ad_sync_users':{
                $handler = adSyncUsers::getView();
                break;
            }
            case 'manage_users_wp_to_ad':{
                $handler = manageUsersWPToAD::getView();
                break;
            }
            case 'send_ad_mail':{
                $handler = adMail::getView();
                break;
            }
            case 'send_demo_request':{
                $handler = demoRequest::getView();
                break;
            }

        }
        $handler->mo_azos_display__tab_details();
    }

    private function mo_azos_display__integration_page(){

        $handler = integrationsView::getView();
        $handler->mo_azos_display_integrations_view();

    }

    private function mo_azos_display__tab_details(){
       esc_html_e("Class missing. Please check if you've installed the plugin correctly.");
    }
}