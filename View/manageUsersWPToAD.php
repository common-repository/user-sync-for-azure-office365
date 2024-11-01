<?php

namespace MoAzureObjectSync\View;

class manageUsersWPToAD{

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
        ];
    
        ?>
    
        <div class="mo-ms-tab-content" style="width: 60%">
            <h1>Configure Profile Mapping ( WP to AD )</h1>
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
    
}