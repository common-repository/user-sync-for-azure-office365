<?php

/*
Plugin Name: User Sync for Azure AD / Azure B2C
Plugin URI: https://plugins.miniorange.com/
Description: This plugin will allow you to sync users from Azure AD / Azure B2C / Office 365 to wordpress. Also, you can integrate wordpress site with microsoft apps like Power BI, Dynamics CRM, SharePoint,etc.
Version: 2.0.3
Author: miniOrange
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

namespace MoAzureObjectSync;
require_once __DIR__ . '/vendor/autoload.php';

use MoAzureObjectSync\View\adminView;
use MoAzureObjectSync\Controller\adminController;
use MoAzureObjectSync\Observer\adminObserver;
use MoAzureObjectSync\View\feedbackForm;
use MoAzureObjectSync\View\welcomeView;
use MoAzureObjectSync\Wrappers\pluginConstants;
use MoAzureObjectSync\Wrappers\wpWrapper;

define('MO_AZOS_PLUGIN_FILE',__FILE__);
define('MO_AZOS_PLUGIN_DIR',__DIR__.DIRECTORY_SEPARATOR);

class MOAZOS{

    private static $instance;
    public static $version = "2.0.3";
    public static function mo_azos_load_instance(){
        if(!isset(self::$instance)){
            $class = __CLASS__;
            self::$instance = new $class;
            self::$instance->mo_azos_load_hooks();
        }
        return self::$instance;
    }

    public function mo_azos_load_hooks(){
        add_action('admin_menu',[$this,'mo_azos_admin_menu']);
        add_action('admin_init',[adminController::getController(),'mo_azos_admin_controller']);
        add_action('init',[adminObserver::getObserver(),'mo_azos_admin_observer']);
        add_action( 'admin_footer', [feedbackForm::getView() , 'mo_azos_display_feedback_form'] );
        add_action( 'admin_enqueue_scripts', [$this, 'mo_azos_settings_style' ] );
        add_action( 'admin_enqueue_scripts', array( $this, 'mo_azos_settings_script' ) );
        add_filter( 'user_row_actions', array($this,'mo_azos_show_extra_user_actions'), 10, 2 );
        add_action( 'show_user_profile', array($this,'mo_azos_custom_user_profile_fields'), 10, 1 );
        add_action( 'edit_user_profile', array($this,'mo_azos_custom_user_profile_fields'), 10, 1 );
        register_activation_hook(__FILE__,array($this,'mo_azos_plugin_activate'));
    }

    public function mo_azos_admin_menu(){
        $page = add_menu_page(
            'WP Azure Users Sync Settings ' .__('API Configuration'),
            'Azure AD / B2C User Sync',
            'administrator',
            'mo_azos',
            [adminView::getView(),'mo_azos_menu_display'],
            plugin_dir_url( __FILE__ ) . 'images/miniorange.png'
        );

        $app = wpWrapper::mo_azos_get_option('mo_azos_application_config');
        if(empty($app)){
	        add_submenu_page('mo_azos','General Settings','General Settings','administrator','mo_azos',[adminView::getView(),'mo_azos_menu_display']);
	        add_submenu_page('mo_azos','Dashboard','Dashboard','administrator','mo_azos_welcome_page',[welcomeView::getView(),'mo_azos_display_welcome_page'],0);
        }else{
	        add_submenu_page('mo_azos','General Settings','General Settings','administrator','mo_azos',[adminView::getView(),'mo_azos_menu_display'],0);
	        add_submenu_page('mo_azos','Dashboard','Dashboard','administrator','mo_azos_welcome_page',[welcomeView::getView(),'mo_azos_display_welcome_page']);
        }
        
    }

    function mo_azos_settings_style($page){
        if( $page != 'toplevel_page_mo_azos' && $page != 'azure-ad-b2c-user-sync_page_mo_azos_welcome_page'){
            return;
        }
        $css_url = plugins_url('includes/css/mo_azos_settings.css',__FILE__);
        $css_phone_url = plugins_url('includes/css/phone.css',__FILE__);
        $css_date_time_url = plugins_url('includes/css/datetime-style-settings.css',__FILE__);
        $css_jquery_ui_url = plugins_url('includes/css/jquery-ui.css',__FILE__);
        $css_support = plugins_url('includes/css/support.css',__FILE__);
        
        wp_enqueue_style('mo_azos_css',$css_url,array(),self::$version);
        wp_enqueue_style('mo_azos_phone_css',$css_phone_url,array(),self::$version);
        wp_enqueue_style('mo_azos_date_time_css',$css_date_time_url,array(),self::$version);
        wp_enqueue_style('mo_azos_jquery_ui_css',$css_jquery_ui_url,array(),self::$version);
        wp_enqueue_style('mo_azos_support_css',$css_support,array(),self::$version);
    }

    function mo_azos_settings_script($page){
        if( $page != 'toplevel_page_mo_azos' && $page != 'azure-ad-b2c-user-sync_page_mo_azos_welcome_page'){
            return;
        }
        $phone_js_url = plugins_url('includes/js/phone.js',__FILE__);
        $timepicker_js_url = plugins_url('includes/js/timepicker.min.js',__FILE__);
        $select2_js_url = plugins_url('includes/js/select2.min.js',__FILE__);

        wp_enqueue_script('jquery-ui-datepicker'); 
        wp_enqueue_script('mo_azos_phone_js',$phone_js_url,array(),self::$version);
        wp_enqueue_script('mo_azos_timepicker_js',$timepicker_js_url,array(),self::$version);
        wp_enqueue_script('mo_azos_select2_js',$select2_js_url,array(),self::$version);
    }

    function mo_azos_plugin_activate(){
        wpWrapper::mo_azos_set_option(pluginConstants::PLUGIN_ACTIVATED,true);
    }

    function mo_azos_show_extra_user_actions($actions, $userObject){

        if ( current_user_can( 'administrator', $userObject->ID ))
            $actions['Push to AD'] = '<a href="?option=push_user_to_ad&username_id='.$userObject->data->user_login.'">Push to Azure AD</a>';
        
        return $actions;
    }

    function mo_azos_custom_user_profile_fields($profileuser){

        ?>
    <table class="form-table">
        <colgroup>
            <col span="1" style="width: 10%;">
            <col span="2" style="width: 60%;">
        </colgroup>
        <tr>
            <th>
                <label for="user_location"><?php esc_html_e( 'Push to Azure AD' ); ?></label>
            </th>
            <td>
                <style>
                    .mo_azos_integration_button{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    margin-left: 5px;
                    padding: 10px;
                    background-color: #0288D1;
                    color:#fff;
                    font-size: 15px;
                    font-weight: 400;
                    cursor: pointer;
                    box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
                    }

                    .mo_azos_integration_button:link {
                    text-decoration: none;
                    color:#fff;
                    }

                    .mo_azos_integration_button:visited {
                    text-decoration: none;
                    color:#fff;
                    }

                    .mo_azos_integration_button:hover {
                    text-decoration: none;
                    color:#fff;
                    background-color: #01579B;
                    }

                    .mo_azos_integration_button:active {
                    text-decoration: none;
                    color:#fff;
                    }
                </style>
                <a class="mo_azos_integration_button" style="height:12px;width:130px;font-size:0.84em;box-shadow:none;font-weight:600" href="?option=push_user_to_ad&username_id=<?php echo $profileuser->data->user_login?>">Push to Azure AD</a>
            </td>
        </tr>
    </table>
<?php
    }

}
MOAZOS::mo_azos_load_instance();