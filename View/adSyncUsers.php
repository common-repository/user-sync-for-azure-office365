<?php

namespace MoAzureObjectSync\View;

class adSyncUsers{

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
            'ad_user_manual_sync' => 'mo_azos_display_ad_to_wp_sync_manual_settings',
            'ad_user_auto_sync' => 'mo_azos_display_ad_to_wp_sync_automatic_settings',
        ];
    
        ?>
    
        <div class="mo-ms-tab-content" style="width: 60%">
            <h1>
                Users Sync From WordPress To Azure Settings
            </h1>
            
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