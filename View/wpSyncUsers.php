<?php

namespace MoAzureObjectSync\View;

class wpSyncUsers{

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
            'wp_user_manual_sync' => 'mo_azos_display_wp_to_ad_sync_manual_settings',
            'wp_user_auto_sync' => 'mo_azos_display_wp_to_ad_sync_automatic_settings',
            'wp_user_profile_pic_sync' => 'mo_azos_display_sync_profile_pic_settings',
        ];

        $tiles_arr1 = [
            'ad_user_manual_sync' => 'mo_azos_display_ad_to_wp_sync_manual_settings',
            'ad_user_auto_sync' => 'mo_azos_display_ad_to_wp_sync_automatic_settings',
        ];
    
        ?>
    
        <div class="mo-ms-tab-content" style="width: 60%">
            <h1>
                Users Sync Settings
            </h1>
            <?php $this->mo_azos_display_sync_direction(); ?>
            <div hidden id="sync_ad_to_wp" class="mo-ms-tab-content-left-border">
                <?php
                foreach ($tiles_arr as $key => $value){
                    $this->$value();
                }
                ?>
            </div>

            <div hidden id="sync_wp_to_ad" class="mo-ms-tab-content-left-border">
                <?php
                foreach ($tiles_arr1 as $key => $value){
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
                        document.getElementById('sync_wp_to_ad').removeAttribute("hidden");
                        document.getElementById('sync_ad_to_wp').setAttribute("hidden","");
                    }else{
                        document.getElementById("adTowp").style.backgroundColor = '#E3E2E1';
                        document.getElementById("adTowp").style.fontWeight = 500;
                        document.getElementById("wpToad").style.backgroundColor = '#F5F5F5';
                        document.getElementById("wpToad").style.fontWeight = 400;
                        document.getElementById('sync_ad_to_wp').removeAttribute("hidden");
                        document.getElementById('sync_wp_to_ad').setAttribute("hidden","");
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

    private function mo_azos_display_sync_direction(){
        ?>
            <div style="display:flex;justify-content:center;align-items:center;width: 100%;height:20px;margin-left:20px;        padding:20px 21px 20px;background-color:#F5F5F5">
                <div id="adTowp" onclick='changeSyncWay("")' style="display:flex;justify-content:center;align-items:center;width:50%;margin:2px;padding:16px;cursor:pointer;">Azure AD to WordPress</div>
                <div id="wpToad" onclick='changeSyncWay("on")' style="display:flex;justify-content:center;align-items:center;width:50%;margin:2px;padding:16px;cursor:pointer">WordPress to Azure AD</div>
            </div>
        <?php
    }
    
    private function mo_azos_display_wp_to_ad_sync_manual_settings(){
        ?>
        <form id="wp_sync_individual_user" method="post" name="wp_sync_individual_user">
            <input type="hidden" name="option" value="mo_azos_client_wp_sync_individual_user_option">
            <input type="hidden" name="mo_azos_tab" value="wp_sync_users">
            <?php wp_nonce_field('mo_azos_client_wp_sync_individual_user_option');?>
            <div class="mo-ms-tab-content-tile">
                <div class="mo-ms-tab-content-tile-content">
                    <span style="font-size: 18px;font-weight: 200;">
                        1. Manual provisioning
                        <!-- <sup style="font-size: 12px;font-weight:600;">
                        [ <a id="wpToadSync_attr_access" href="#"> Click Here </a> To Know More ]
                        </sup> -->
                    </span>
                    <div id="wpToadSync_attr_access_desc" class="mo_azos_help_desc">
						<span>
                        It provides the feature to sync an individual user and to sync all the users at once.
                         </span>
                    </div>

                    <table class="mo-ms-tab-content-app-config-table">
                        <colgroup>
                            <col span="1" style="width: 40%;">
                            <col span="2" style="width: 10%;">
                        </colgroup>
                        <tbody>
                            <tr>
                                <td><span style="font-size: 15px;font-weight: 200;"> Sync an individual user</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <input placeholder="Enter UserPrincipalName/ID of User To Sync" type="text" name="user_upn_id" value="">
                                </td>
                                <td style="text-align:center;">
                                    <input style="height:30px;" type="button" id="syncUserManualButton" class="mo-ms-tab-content-button" value="Sync">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Note:</b> You can find the <b>User Principle Name / Object ID</b> of user in the user profile in Users tab in your active directory. 
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></br></td>
                            </tr>
                            <tr>
                                <td><span>
                                    Group IDs
                                    <sup style="font-size: 12px;color:red;font-weight:600;">
                                        [Available in Premium Plugin]
                                    </sup>
                                </span></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><input disabled style="border:1px solid #eee;" type="text" placeholder="" name="mo_api_group_id_to_sync" value="Enter '|' separated group IDs"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                <b>Note:</b>(Optional) You can enter Group IDs to sync the users from mentioned groups only. To sync users from multiple 
                                        group IDs you can enter the Group IDs separated by <b>|</b> character like this group_id1<b>|</b>group_id2...
                                </td>
                                <td></td>
                            </tr>
                            <tr><td></br></td></tr>
                            <tr>
                                <td><span style="font-size: 15px;font-weight: 200;"> Sync All Users</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Note:</b> This will sync all users from your active directory to WordPress.
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                <input style="height:30px;" type="button" id="syncAllUserButton" class="mo-ms-tab-content-button" value="Sync All Users">
                                </td>
                            </tr>
                        </tbody>
                    </table>    
                    </form>
                    <form id="wp_sync_all_users" method="post" name="wp_sync_all_users">
                        <input type="hidden" name="option" value="mo_azos_client_wp_sync_all_users_option">
                        <input type="hidden" name="mo_azos_tab" value="wp_sync_users">
                        <?php wp_nonce_field('mo_azos_client_wp_sync_all_users_option');?>
                    </form>
                    <script>
                        document.getElementById("syncUserManualButton").addEventListener("click",function (){
                            document.getElementById("wp_sync_individual_user").submit();
                        });
                        document.getElementById("syncAllUserButton").addEventListener("click",function (){
                            document.getElementById("wp_sync_all_users").submit();
                        });
                        jQuery("#wpToadSync_attr_access").click(function (e) {
                            e.preventDefault();
                            jQuery("#wpToadSync_attr_access_desc").slideToggle(400);
                        });
                        jQuery("#wpToad_heading_access").click(function (e) {
                            e.preventDefault();
                            jQuery("#wpToad_heading_access_desc").slideToggle(400);
                        });
                    </script>
                </div>
            </div>
    <?php
    }

    private function mo_azos_display_wp_to_ad_sync_automatic_settings(){
        ?>
        <form class="mo_azos_ajax_submit_form" id="app_config_provisioning_rate">
            <div class="mo-ms-tab-content-tile">
                <div class="mo-ms-tab-content-tile-content">
                    <span style="font-size: 18px;font-weight: 200;">2. Automatic provisioning
                        <sup style="font-size: 12px;color:red;font-weight:600;">
                            [Available in Premium Plugin]
                            <!-- [Available in Premium Plugin <a id="wpToadSyncAuto_attr_access" href="#"> Click Here </a> To Know More] -->
                        </sup>
                    </span>
                    <div id="wpToadSyncAuto_attr_access_desc" class="mo_azos_help_desc">
						<span>
                        Azure AD / B2C to WordPress user sync can be scheduled at a specific time interval. This will create / update the users
                         automatically after the time spcified in the Enable Automatic User Creation field. Number of users synced per request can be configured here in Limit Provising Rate input field.  
                         </span>
                    </div>
                    <table class="mo-ms-tab-content-app-config-table">
                        <tr>
                            <td class="left-div" style="width: 25%"><span>No. of User Records / Request</span></td>
                            <td class="right-div"><input placeholder="Enter the limit provisioning rate" disabled style="border:1px solid #eee;" type="number" name="request_rate" value=""></td>
                        </tr>
                        <tr>
                            <td class="left-div"><span>Enable Automatic User Creation</span></td>
                            <td class="right-div">
                                <div style="display: flex">
                                    <div style="padding-right: 15px;padding-top: 2px;">
                                        <label class="switch">
                                            <input disabled type="checkbox" name="automatic_user_creation" >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <input disabled style="border:1px solid #eee;" type="number" name="user_create_sync_interval" value="" placeholder="Fetch all user's details again in next * minutes">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex">
                                    <input disabled style="background-color: #DCDAD1;border:none;" type="submit" class="mo-ms-tab-content-button" value="Save">
                                    <div class="loader-placeholder"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <script>
                jQuery("#wpToadSyncAuto_attr_access").click(function (e) {
                    e.preventDefault();
                    jQuery("#wpToadSyncAuto_attr_access_desc").slideToggle(400);
                });
            </script>
        </form>
    <?php
    }
    
    private function mo_azos_display_sync_profile_pic_settings(){
        ?>
    
        <form class="mo_azos_ajax_submit_form" id="mo_azos_client_default_profile_image">
            <div class="mo-ms-tab-content-tile">
                <div class="mo-ms-tab-content-tile-content">
                    <span style="font-size: 18px;font-weight: 200;">3. Profile Picture Sync
                        <sup style="font-size: 12px;color:red;font-weight:600;">
                            [Available in Premium Plugin]
                            <!-- [Available in Premium Plugin <a id="wpToadProfilePic_attr_access" href="#"> Click Here </a> To Know More] -->
                        </sup>
                    </span>
                    <div id="wpToadProfilePic_attr_access_desc" class="mo_azos_help_desc">
						<span>
                        It provides the feature to sync profile picture of users from your Active Directory. Default profile picture value can be set in the profile mapping settings in case there is no
                        profile picture associated for some user accounts.
                        </span>
                    </div>
                    <table class="mo-ms-tab-content-app-config-table">
                    <colgroup>
                        <col span="1" style="width: 25%;">
                        <col span="2" style="width: 40%;">
                    </colgroup>
                    <tbody>
                        <tr>
                            <td class="left-div"><span>Enable Profile Picture Sync</span></td>
                            <td class="right-div">
                                <label class="switch">
                                    <input disabled type="checkbox" name="profile_pic_sync">
                                    <span class="slider round"></span>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex">
                                    <input disabled style="background-color: #DCDAD1;border:none;" type="submit" class="mo-ms-tab-content-button" value="Save">
                                    <div class="loader-placeholder"></div>
                                </div>
                            </td>
                        </tr>
                    </tbody>                        
                    </table>
                </div>
            </div>
            <script>
                jQuery("#wpToadProfilePic_attr_access").click(function (e) {
                    e.preventDefault();
                    jQuery("#wpToadProfilePic_attr_access_desc").slideToggle(400);
                });
            </script>
        </form>
    <?php
    }

    private function mo_azos_display_ad_to_wp_sync_manual_settings(){
        ?>
    
        <form id="ad_sync_individual_user" method="post" name="ad_sync_individual_user">
            <input type="hidden" name="option" value="mo_azos_client_ad_sync_individual_user_option">
            <input type="hidden" name="mo_azos_tab" value="ad_sync_users">
            <?php wp_nonce_field('mo_azos_client_ad_sync_individual_user_option');?>
            <div class="mo-ms-tab-content-tile">
                <div class="mo-ms-tab-content-tile-content">
                    <span style="font-size: 18px;font-weight: 200;">1. Manual provisioning
                    </span>
                    <div id="adTowpSync_attr_access_desc" class="mo_azos_help_desc">
						<span>
                        It provides the feature to sync an individual user and to sync all the users at once on the Azure side. User will be updated if 
                        it already present in your Active Directory else it will be created.
                        </span>
                    </div>
                    <table class="mo-ms-tab-content-app-config-table">
                        <colgroup>
                            <col span="1" style="width: 40%;">
                            <col span="2" style="width: 10%;">
                        </colgroup>
                        <tbody>
                            <tr>
                                <td><span style="font-size: 15px;font-weight: 200;"> Sync an individual user</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Note:</b> search the username of user to sync (create) it to the Active Directory.
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <input id="username_id" autocomplete="off" onkeyup="searchUsers(this);" placeholder='Search WordPress username of User To Sync' type="text" name="username_id" value="">
                                </td>
                                <td style="text-align:center;">
                                    <input style="height:30px;" type="submit" id="syncUserToADManualButton" class="mo-ms-tab-content-button" value="Sync">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="search_container_id" class="search_container" style="width:100%;display:flex;flex-direction:column;align-items:flex-start;overflow-y: scroll;">
                                        <?php
                                            $allusers = get_users();
                                            foreach($allusers as $user){
                                                echo '<span onclick="selectUserItem(this);" class="user_item" id="user_'.esc_html($user->data->user_login).'" style="display:none;">'.esc_html($user->data->user_login).'</span>';
                                            }
                                        ?>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <style>
                                .user_item{
                                    background-color: #eee;
                                    width: 80%;
                                    padding:7px;
                                    border-radius:10px;
                                    margin:2px;
                                    cursor: pointer;
                                }
                                .user_item:hover{
                                    background-color: #9E9E9E;
                                }

                                .search_container::-webkit-scrollbar {
                                    display: none;
                                }
                            </style>
                            <script>
                                function searchUsers(e){
                                    var allusers = document.getElementsByClassName('search_container')[0].children;
                                    let found = false;
                                    for(let index=0;index<allusers.length;index++){
                                        let user = allusers[index];
                                        if(e.value != '' && user.innerHTML.includes(e.value)){
                                            found = true;
                                            user.style.display = "block";
                                        }else{
                                            user.style.display = "none";
                                        }
                                    };

                                    if(found)
                                        document.getElementById("search_container_id").style.height = "150px";
                                    else
                                        document.getElementById("search_container_id").style.height = "";
                                }

                                function selectUserItem(el){
                                    document.getElementById("username_id").value = el.innerHTML;
                                }
                            </script>
                            <tr>
                                <td></br></td>
                            </tr>
                            <tr>
                                <td><span style="font-size: 15px;font-weight: 200;"> Sync All Users
                                <sup style="font-size: 12px;color:red;font-weight:600;">
                                    [Available in Premium Plugin]
                                </sup>
                                </span></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Note:</b> This will sync all users from your WordPress databse to your Active Directory.
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                <input disabled style="background-color: #DCDAD1;border:none;" style="height:30px;" type="button" id="syncAllUserButton" class="mo-ms-tab-content-button" value="Sync All Users">
                                </td>
                            </tr>
                        </tbody>
                    </table>    
                </div>
            </div>
            <script>
                jQuery("#adTowpSync_attr_access").click(function (e) {
                    e.preventDefault();
                    jQuery("#adTowpSync_attr_access_desc").slideToggle(400);
                });
                jQuery("#adTowp_heading_access").click(function (e) {
                    e.preventDefault();
                    jQuery("#adTowp_heading_access_desc").slideToggle(400);
                });
            </script>
        </form>
    
    <?php
    }
    
    private function mo_azos_display_ad_to_wp_sync_automatic_settings(){
        ?>
        <form id="ad_sync_users_auto" method="post" name="ad_sync_users_auto">
            <div class="mo-ms-tab-content-tile">
                <div class="mo-ms-tab-content-tile-content">
                    <span style="font-size: 18px;font-weight: 200;">2. Automatic provisioning
                        <sup style="font-size: 12px;color:red;font-weight:600;">
                        [Available in Premium Plugin]
                        <!-- [Available in Premium Plugin <a id="adTowpSyncAuto_attr_access" href="#"> Click Here </a> To Know More] -->
                        </sup>
                    </span>
                    <div id="adTowpSyncAuto_attr_access_desc" class="mo_azos_help_desc">
						<span>
                        It provides the feature to automatically sync WordPress user to Active Directory if new user is created or
                        existing user is updated on WordPress database.
                        </span>
                    </div>
                    <table class="mo-ms-tab-content-app-config-table">
                        <colgroup>
                            <col span="1" style="width: 30%;">
                            <col span="2" style="width: 10%;">
                        </colgroup>
                        <tr>
                            <td class="left-div"><span>Enable Automatic User Creation:</span></td>
                            <td class="right-div">
                                <label class="switch">
                                    <input disabled type="checkbox" name="automatic_user_creation" >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="left-div"><span>Enable Automatic User Update:</span></td>
                            <td class="right-div">
                                <label class="switch">
                                    <input disabled type="checkbox" name="automatic_user_creation" >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex">
                                    <input disabled style="background-color: #DCDAD1;border:none;" type="submit" class="mo-ms-tab-content-button" value="Save">
                                    <div class="loader-placeholder"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <script>
                jQuery("#adTowpSyncAuto_attr_access").click(function (e) {
                    e.preventDefault();
                    jQuery("#adTowpSyncAuto_attr_access_desc").slideToggle(400);
                });
            </script>
        </form>
    <?php
    }
    
}