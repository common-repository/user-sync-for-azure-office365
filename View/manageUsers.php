<?php

namespace MoAzureObjectSync\View;
use MoAzureObjectSync\Wrappers\wpWrapper;
use WP_Roles;

class manageUsers{

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
            'basic' => 'mo_azos_display_profile_mapping',
            'taxanomy'=> 'mo_azos_display__texanomy_mapping',
            'grp_map' => 'mo_azos_display__group_mapping',
        ];

        $tiles_arr_wp_to_ad = [
            'basic_wp_to_ad' => 'mo_azos_display_profile_mapping_wp_to_ad',
        ];
    
        ?>
    
        <div class="mo-ms-tab-content" style="width: 60%">
            <h1>Configure Profile Mapping</h1>
            <?php $this->mo_azos_display_sync_direction(); ?>
            <div hidden id="profile_ad_to_wp" class="mo-ms-tab-content-left-border">
                <?php
                foreach ($tiles_arr as $key => $value){
                    $this->$value();
                }
                ?>
            </div>

            <div hidden id="profile_wp_to_ad" class="mo-ms-tab-content-left-border">
                <?php
                foreach ($tiles_arr_wp_to_ad as $key => $value){
                    $this->$value();
                }
                ?>
            </div>
            <script>
                let syncway = localStorage.getItem("is_wpToad_sync");
                
                applySyncWayChanges(syncway);

                function applySyncWayChanges(syncway){
                    if(syncway === "on"){
                        document.getElementById("wpToad").style.backgroundColor = '#E3E2E1';
                        document.getElementById("wpToad").style.fontWeight = 500;
                        document.getElementById("adTowp").style.backgroundColor = '#F5F5F5';
                        document.getElementById("adTowp").style.fontWeight = 400;
                        document.getElementById('profile_wp_to_ad').removeAttribute("hidden");
                        document.getElementById('profile_ad_to_wp').setAttribute("hidden","");
                    }else{
                        document.getElementById("adTowp").style.backgroundColor = '#E3E2E1';
                        document.getElementById("adTowp").style.fontWeight = 500;
                        document.getElementById("wpToad").style.backgroundColor = '#F5F5F5';
                        document.getElementById("wpToad").style.fontWeight = 400;
                        document.getElementById('profile_ad_to_wp').removeAttribute("hidden");
                        document.getElementById('profile_wp_to_ad').setAttribute("hidden","");
                    }
                }

                function changeSyncWay(syncway){
                    localStorage.setItem("is_wpToad_sync",syncway);
                    applySyncWayChanges(syncway);
                }
            </script>
        </div>
    <?php
    }

    public function mo_azos_display_sync_direction(){
        ?>
            <div style="display:flex;justify-content:center;align-items:center;width: 100%;height:20px;margin-left:20px;        padding:20px 21px 20px;background-color:#F5F5F5">
                <div id="adTowp" onclick='changeSyncWay("")' style="display:flex;justify-content:center;align-items:center;width:50%;margin:2px;padding:16px;cursor:pointer;">Azure AD to WordPress</div>
                <div id="wpToad" onclick='changeSyncWay("on")' style="display:flex;justify-content:center;align-items:center;width:50%;margin:2px;padding:16px;cursor:pointer">WordPress to Azure AD</div>
            </div>
        <?php
    }

    public function mo_azos_display_profile_mapping(){
        ?>
            <form class="mo_azos_ajax_submit_form" id="manage_users_save_basic_attr_mapping">
            <div class="mo-ms-tab-content-tile">
                <div class="mo-ms-tab-content-tile-content">
                    <span style="font-size: 18px;font-weight: 200;">User Profile Mapping
                        <sup style="font-size: 12px;color:red;font-weight:600;">
                                [Available in Premium Plugin]
                                <!-- [Available in Premium Plugin <a id="basic_attr_access" href="#"> Click Here </a> To Know More] -->
                        </sup>
                    </span>
                    <div id="basic_attr_access_desc" class="mo_azos_help_desc">
						<span>Map attributes like Username, Email, First Name, Last Name, Display Name to the attributes released from your Active Directory.
                         While syncing the users in your WordPress site, these attributes will automatically get mapped to your WordPress user details.
                         </span>
                    </div>
                </div>
                <table class="mo-ms-tab-content-app-config-table">
                        <tr>
                            <td class="left-div"><span>Profile Picture</span></td>
                            <td class="right-div">
                                <div class="row">
                                    <div class="small-12 medium-2 large-2 columns">
                                        <div class="circle">
                                        <img class="mo_azos_profile_pic" src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/profilepic.jpg');?>">

                                        </div>
                                        <div class="mo_azos_p_image">
                                        <img width="30px" height="30px" style=""  src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/camera.png');?>">
                                            <input disabled class="mo_azos_file_upload" type="file" accept="image/*"/>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span style="color: black">The free plugin uses the default mapping. Below fields can be configured with the IDP attributes using the <span style="color: brown"><b><i><u>Premium version</u></i></b></span> of the plugin.</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="left-div"><span>Username</span></td>
                            <td class="right-div">
                                <input disabled style="border:1px solid #eee; background: lightgrey;" placeholder="Enter attribute name for Username" type="text" name="user_login" value="id">
                            </td>
                        </tr>
                        <tr>
                            <td class="left-div"><span>Email</span></td>
                            <td class="right-div"><input disabled style="border:1px solid #eee;background: lightgrey;" placeholder="Enter attribute name for Email" type="text" name="email" value="userPrincipalName"></td>
                        </tr>
                        <tr>
                            <td class="left-div"><span>First Name</span></td>
                            <td class="right-div"><input disabled style="background: lightgrey;border:1px solid #eee;" placeholder="Enter attribute name for First Name" type="text" name="first_name" value="Enter attribute name for First Name"></td>
                        </tr>
                        <tr>
                            <td class="left-div"><span>Last Name</span></td>
                            <td class="right-div"><input disabled style="background: lightgrey;border:1px solid #eee;" placeholder="Enter attribute name for Last Name" type="text" name="last_name" value="Enter attribute name for Last Name"></td>
                        </tr>
                        <tr>
                            <td class="left-div"><span>Display Name</span></td>
                            <td class="right-div"><input disabled style="background: lightgrey;border:1px solid #eee;" placeholder="Enter attribute name for Display Name" type="text" name="display_name" value="Enter attribute name for Display Name"></td>
                        </tr>
                        <tr>
                            <td><br></td>
                        </tr>
                </table>
                <a id="show_advance_attribute_settings" href="#">Hide Advance Settings</a>
                <div id="show_advance_attribute_settings_desc">
                    <div id="advance_attr_access_desc" class="mo_azos_help_desc">
                            <span>
                            Map extra attributes which you wish to be synced in the user profile.</br>
                        <b>NOTE:</b> Advanced Attribute Mapping means you can map any attribute of Azure AD / B2C to the attributes of user-meta table of your database.
                            </span>
                    </div>
                    <table class="mo-ms-tab-content-app-config-table">
                        <tr>
                            <td colspan="2"><input disabled style="background-color: #DCDAD1;border:none;" type="button" class="mo-ms-tab-content-button" id="add_rows" value="Add Attribute"></td>
                        </tr>
                    </table>
                    <table id="attr_mapping" class="mo-azos-custom-attr-mapping-table">
                        <colgroup>
                            <col span="1" style="width: 50%;">
                            <col span="1" style="width: 50%;">
                        </colgroup>
                        <thead>
                        <tr>
                            <th class="left-div"><h4>Attribute Name</h4></th>
                            <th class="right-div"><h4>Attribute Value</h4></th>
                        </tr>
                        </thead>
                        <tr>
                            <td class="left-div"><input disabled style="border:1px solid #eee;" placeholder="Enter attribute name" type="text" value="Enter attribute name (WP meta key)"></td>
                            <td class="right-div"><input disabled style="border:1px solid #eee;" placeholder="Enter attribute value" type="text" value="Enter attribute value (AD attribute name)"></td>
                        </tr>
                    </table>
                </div>
                <script>
                    jQuery("#show_advance_attribute_settings").click(function (e) {
                        e.preventDefault();
                        jQuery("#show_advance_attribute_settings_desc").slideToggle(400);
                        if (jQuery(this).text() == "Show Advance Settings")
                            jQuery(this).text("Hide Advance Settings")
                        else
                            jQuery(this).text("Show Advance Settings");
                    });
                </script>
                <div style="display: flex;margin-top:30px;">
                    <input disabled style="background-color: #DCDAD1;border:none;width:100px;height:30px;" type="submit" class="mo-ms-tab-content-button" value="SAVE">
                    <div class="loader-placeholder"></div>
                </div>
            </div>
            </form>
        <?php
    }

    public function mo_azos_display_profile_mapping_wp_to_ad(){
        ?>
            <form class="mo_azos_ajax_submit_form" id="manage_users_save_basic_attr_mapping_wp_to_ad">
            <div class="mo-ms-tab-content-tile">
                <div class="mo-ms-tab-content-tile-content">
                    <span style="font-size: 18px;font-weight: 200;">User Profile Mapping
                        <sup style="font-size: 12px;color:red;font-weight:600;">
                                [Available in Premium Plugin]
                                <!-- [Available in Premium Plugin <a id="basic_attr_access" href="#"> Click Here </a> To Know More] -->
                        </sup>
                    </span>
                    <div id="basic_attr_access_desc" class="mo_azos_help_desc">
						<span>Map AD attributes like userPrincipalName, mailNickName, mail, givenName, surname to the WordPress attributes.
                         While syncing the users in your Active Directory, these attributes will automatically get mapped to your AD user details.
                         </span>
                    </div>
                </div>
                <table class="mo-ms-tab-content-app-config-table">
                        <tr>
                            <td class="left-div"><span>Profile Picture</span></td>
                            <td class="right-div">
                                <div class="row">
                                    <div class="small-12 medium-2 large-2 columns">
                                        <div class="circle">
                                        <img class="mo_azos_profile_pic" src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/profilepic.jpg');?>">

                                        </div>
                                        <div class="mo_azos_p_image">
                                        <img width="30px" height="30px" style=""  src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/camera.png');?>">
                                            <input disabled class="mo_azos_file_upload" type="file" accept="image/*"/>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="left-div"><span>userPrincipalName</span></td>
                            <td class="right-div">
                                <input disabled style="border:1px solid #eee;" placeholder="Enter attribute name for userPrincipalName" type="text" name="user_login" value="user_login">
                            </td>
                        </tr>
                        <tr>
                            <td class="left-div"><span>mailNickName</span></td>
                            <td class="right-div"><input disabled style="border:1px solid #eee;" placeholder="Enter attribute name for Email" type="text" name="email" value="user_login"></td>
                        </tr>
                        <tr>
                            <td class="left-div"><span>mail</span></td>
                            <td class="right-div"><input disabled style="border:1px solid #eee;" placeholder="Enter attribute name for mail" type="text" name="first_name" value="Enter attribute name for mail"></td>
                        </tr>
                        <tr>
                            <td class="left-div"><span>givenName</span></td>
                            <td class="right-div"><input disabled style="border:1px solid #eee;" placeholder="Enter attribute name for givenName" type="text" name="first_name" value="Enter attribute name for givenName"></td>
                        </tr>
                        <tr>
                            <td class="left-div"><span>surname</span></td>
                            <td class="right-div"><input disabled style="border:1px solid #eee;" placeholder="Enter attribute name for surname" type="text" name="last_name" value="Enter attribute name for surname"></td>
                        </tr>
                        <tr>
                            <td class="left-div"><span>displayName</span></td>
                            <td class="right-div"><input disabled style="border:1px solid #eee;" placeholder="Enter attribute name for displayName" type="text" name="display_name" value="Enter attribute name for displayName"></td>
                        </tr>
                        <tr>
                            <td><br></td>
                        </tr>
                </table>
                <a id="show_advance_attribute_settings" href="#">Hide Advance Settings</a>
                <div id="show_advance_attribute_settings_desc">
                    <div id="advance_attr_access_desc" class="mo_azos_help_desc">
                            <span>
                            Map extra attributes which you wish to be synced in the user profile.</br>
                        <b>NOTE:</b> Advanced Attribute Mapping means you can map any attribute of user-meta table of your database to the attributes of your active directory.
                            </span>
                    </div>
                    <table class="mo-ms-tab-content-app-config-table">
                        <tr>
                            <td colspan="2"><input disabled style="background-color: #DCDAD1;border:none;" type="button" class="mo-ms-tab-content-button" id="add_rows" value="Add Attribute"></td>
                        </tr>
                    </table>
                    <table id="attr_mapping" class="mo-azos-custom-attr-mapping-table">
                        <colgroup>
                            <col span="1" style="width: 50%;">
                            <col span="1" style="width: 50%;">
                        </colgroup>
                        <thead>
                        <tr>
                            <th class="left-div"><h4>Attribute Name</h4></th>
                            <th class="right-div"><h4>Attribute Value</h4></th>
                        </tr>
                        </thead>
                        <tr>
                            <td class="left-div"><input disabled style="border:1px solid #eee;" placeholder="Enter attribute name" type="text" value="Enter attribute name (AD attribute name)"></td>
                            <td class="right-div"><input disabled style="border:1px solid #eee;" placeholder="Enter attribute value" type="text" value="Enter attribute value (WP meta key)"></td>
                        </tr>
                    </table>
                </div>
                <script>
                    jQuery("#show_advance_attribute_settings").click(function (e) {
                        e.preventDefault();
                        jQuery("#show_advance_attribute_settings_desc").slideToggle(400);
                        if (jQuery(this).text() == "Show Advance Settings")
                            jQuery(this).text("Hide Advance Settings")
                        else
                            jQuery(this).text("Show Advance Settings");
                    });
                </script>
                <div style="display: flex;margin-top:30px;">
                    <input disabled style="background-color: #DCDAD1;border:none;width:100px;height:30px;" type="submit" class="mo-ms-tab-content-button" value="SAVE">
                    <div class="loader-placeholder"></div>
                </div>
            </div>
            </form>
        <?php
    }

    public function mo_azos_display__texanomy_mapping(){

		$taxonomies = get_object_taxonomies('user');
        
        ?>
        <form class="mo_msgraph_ajax_submit_form" id="mo_api_user_taxonomy_mapping" method="">
            <div class="mo-ms-tab-content-tile">
                <div class="mo-ms-tab-content-tile-content">
                    <span style="font-size: 18px;font-weight: 200;">
                    Taxanomy Mapping
                    <sup style="font-size: 12px;color:red;font-weight:600;">
                            [Available in Premium Plugin]
                            <!-- [Available in Premium Plugin <a id="basic_attr_access" href="#"> Click Here </a> To Know More] -->
                    </sup>
                </span>
                <div id="basic_attr_access_desc" class="mo_azos_help_desc">
                    <span>Map your WordPress taxanomies of User object to Azure AD attribute. 
                    </span>
                </div>
                    <div>
                        <table class="mo-ms-tab-content-app-config-table">
                                <colgroup>
                                    <col span="1" style="width: 15%;">
                                    <col span="2" style="width: 60%;">
                                </colgroup>
                                <?php
                                    if(empty($taxonomies)){
                                        ?>
                                            </br></br>
                                            <p style="padding:5px;width:16%;font-size:12px;font-weight:bold">No taxonomies found</p>
                                        <?php
                                    }
                                    foreach($taxonomies as $taxanomy_value => $taxanomy_name){
                                        ?>
                                            <tr>
                                                <td><span><?php echo esc_html($taxanomy_name); ?></span></td>
                                                <td>
                                                    <input disabled style="border:1px solid #eee;" placeholder="Enter Azure AD Attribute Name" type="text" value=''>
                                                </td>
                                            </tr>
                                        <?php
                                    }
                                ?>
                                <tr><td></br></td></tr>
                                <tr>
                                    <td>
                                        <input disabled style="background-color: #DCDAD1;border:none;width:100px;height:30px;" type="button" class="mo-ms-tab-content-button" value="Save">
                                    </td>
                                </tr>
                        </table>
                    </div>
                </div>
            </div>
        </form>
        <?php
    }

    public function mo_azos_display__group_mapping(){
        $wp_roles         = new WP_Roles();
        $roles            = $wp_roles->get_names();
        ?>
        <form class="mo_msgraph_ajax_submit_form" id="mo_api_user_grp_mapping" method="post">
            <div class="mo-ms-tab-content-tile">
                        <div class="mo-ms-tab-content-tile-content">
                                <span style="font-size: 18px;font-weight: 200;">Role/Group Mapping
                                    <sup style="font-size: 12px;color:red;font-weight:600;">
                                            [Available in Premium Plugin]
                                            <!-- [Available in Premium Plugin <a id="basic_attr_access" href="#"> Click Here </a> To Know More] -->
                                    </sup>
                                </span>
                                <div id="basic_attr_access_desc" class="mo_azos_help_desc">
                                    <span>Map your WordPress Roles / BuddyPress Groups / Membership Levels to Azure AD Groups. 
                                    </span>
                                </div>
                        </div>
                        <table class="mo-ms-tab-content-app-config-table">
                                <colgroup>
                                    <col span="1" style="width: 15%;">
                                    <col span="2" style="width: 60%;">
                                </colgroup>
                                <?php
                                    foreach($roles as $role_value => $role_name){
                                        $configured_role_value = empty($roles_configured)?'':$roles_configured[$role_value];
                                        ?>
                                            <tr>
                                                <td><span><?php echo esc_html($role_name); ?></span></td>
                                                <td>
                                                    <input disabled style="border:1px solid #eee;" value="Enter Azure AD group ID to map with corresponding role" type="text">
                                                </td>
                                            </tr>
                                        <?php
                                    }
                                ?>
                                <tr><td></br></td></tr>
                                <tr>
                                    <td>
                                        <input disabled style="background-color: #DCDAD1;border:none;width:100px;height:30px;" type="submit" class="mo-ms-tab-content-button" value="Save">
                                    </td>
                                </tr>
                        </table>
            </div>
        </form>
        <?php
    }
    
}