<?php

namespace MoAzureObjectSync\View;

class dynamicsCRM365{

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
            'app' => 'mo_azos_display__dcrm365_config',
            'sync' => 'mo_azos_display__dcrm365_sync',
            'sync_to_wp' => 'mo_azos_display__dcrm365_sync_to_wp'
        ];

        ?>
        <div class="mo-ms-tab-content" style="width: 60%">
            <h1>Configure Dynamics CRM 365 Application</h1>
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

    private function mo_azos_display__dcrm365_config(){
       
        ?>
        
            <div class="mo-ms-tab-content-tile">
                <div class="mo-ms-tab-content-tile-content">
                    <span style="font-size: 18px;font-weight: 200">
                    1. Dynamics CRM 365 Connection
                        <sup style="font-size: 12px;color:red;font-weight:600;">
                                [Available in Premium Plugin]
                        </sup>
                    </span>
                    <div id="app_config_access_desc" class="mo_azos_help_desc">
						<span>
                         Configure following settings to connect with the Dynamics CRM Portal to sync the data like sales, leads, entity data from your
                         CRM.
                         </span>
                    </div>
                   
                    <table class="mo-ms-tab-content-app-config-table">
                        <colgroup>
                            <col span="1" style="width: 20%;">
                            <col span="2" style="width: 75%;">
                        </colgroup>
                        <tr>
                            <td><span>Select Connection Method</span></td>
                            <td>
                            <select style="padding:1px 10px;width:91%;margin-top:5px;background-color:#fff" onclick="handleConnection(this)">
                                <option value="graph">Using Graph API</option>
                                <option value="auth">Using Username/Password Auth</option>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td id="connection_desc">
                                <b>Note:</b> Connection will be established using <b>Application ID</b> and <b>Client Secret</b> of <a href="<?php echo esc_url(add_query_arg('tab','app_config'));?>">App Configurations</a>.
                            </td>
                        </tr>
                        <tr>
                            <td></br></td>
                        </tr>
                        <tr>
                            <td><span>Dynamics 365 Address (URL) <span style="color:red;font-weight:bold;">*</span></span></td>
                            <td>
                                <input disabled style="border:1px solid #eee;" placeholder="https://contoso.crm.dynamics.com" type="text" name="workspace_id" value="">
                            </td>
                        </tr>
                        <tr>
                            <td></br></td>
                        </tr>
                        <tr id="username_row" hidden>
                            <td><span>Username <span style="color:red;font-weight:bold;">*</span></span></td>
                            <td><input disabled style="border:1px solid #eee;" placeholder="Enter username" type="text" name="username" value=""></td>
                        </tr>
                        <tr id="username_row_note" hidden>
                            <td></td>
                            <td>
                                <b>Note:</b> CRM User Login 
                            </td>
                        </tr>
                        <tr id="username_row_margin" hidden>
                            <td></br></td>
                        </tr>
                        <tr id="password_row" hidden>
                            <td><span>Password<span style="color:red;font-weight:bold;">*</span></span></td>
                            <td><input disabled style="border:1px solid #eee;" placeholder="Enter password" type="text" name="password" value=""></td>
                        </tr>
                        <tr id="password_row_note" hidden>
                            <td></td>
                            <td>
                                <b>Note:</b> CRM User Password  
                            </td>
                        </tr>
                        <tr id="password_row_margin" hidden>
                            <td></br></td>
                        </tr>
                    </table>
                    <div style="display: flex;">
                        <input disabled style="background-color: #DCDAD1;border:none;width:100px;height:30px;" type="submit" class="mo-ms-tab-content-button" value="Connect">
                    </div>
                </div>
                <script>
                    function handleConnection(ele){
                        let type = ele.value;
                        
                        if(type === 'graph'){
                            document.getElementById('username_row').setAttribute("hidden",true);
                            document.getElementById('username_row_note').setAttribute("hidden",true);
                            document.getElementById('username_row_margin').setAttribute("hidden",true);

                            document.getElementById('password_row').setAttribute("hidden",true);
                            document.getElementById('password_row_note').setAttribute("hidden",true);
                            document.getElementById('password_row_margin').setAttribute("hidden",true);

                            document.getElementById("connection_desc").innerHTML = '<b>Note:</b> Connection will be established using <b>Application ID</b> and <b>Client Secret</b> of <a href="<?php echo esc_url(add_query_arg('tab','app_config'));?>">App Configurations</a>.';

                        }else{

                            document.getElementById('username_row').removeAttribute('hidden');
                            document.getElementById('username_row_note').removeAttribute('hidden');
                            document.getElementById('username_row_margin').removeAttribute('hidden');

                            document.getElementById('password_row').removeAttribute('hidden');
                            document.getElementById('password_row_note').removeAttribute('hidden');
                            document.getElementById('password_row_margin').removeAttribute('hidden');

                            document.getElementById("connection_desc").innerHTML = "<b>Note:</b> Connection will be established using CRM username and password";
                        }
                        

                    }
                </script>
            </div>
        <?php
    }

    private function mo_azos_display__dcrm365_sync(){
        ?>
        <form id="ad_sync_users_auto" method="post" name="ad_sync_users_auto">
            <div class="mo-ms-tab-content-tile">
                <div class="mo-ms-tab-content-tile-content">
                    <span style="font-size: 18px;font-weight: 200;">2. Sync WooCommerce Order Details
                        <sup style="font-size: 12px;color:red;font-weight:600;">
                        [Available in Premium Plugin]
                        <!-- [Available in Premium Plugin <a id="adTowpSyncAuto_attr_access" href="#"> Click Here </a> To Know More] -->
                        </sup>
                    </span>
                    <div id="adTowpSyncAuto_attr_access_desc" class="mo_azos_help_desc">
						<span>
                        It provides the feature to sync WooCommerce Order history, customers directly to Dynamics CRM on the checkout process.
                        </span>
                    </div>
                    <table class="mo-ms-tab-content-app-config-table">
                        <colgroup>
                            <col span="1" style="width: 30%;">
                            <col span="2" style="width: 10%;">
                        </colgroup>
                        <tr>
                            <td class="left-div"><span>Enable WooComerce Integration:</span></td>
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
        </form>
    <?php
    }

    private function mo_azos_display__dcrm365_sync_to_wp(){
        ?>
        <form id="ad_sync_users_auto" method="post" name="ad_sync_users_auto">
            <div class="mo-ms-tab-content-tile">
                <div class="mo-ms-tab-content-tile-content">
                    <span style="font-size: 18px;font-weight: 200;">3. Sync CRM Data Into WordPress
                        <sup style="font-size: 12px;color:red;font-weight:600;">
                        [Available in Premium Plugin]
                        <!-- [Available in Premium Plugin <a id="adTowpSyncAuto_attr_access" href="#"> Click Here </a> To Know More] -->
                        </sup>
                    </span>
                    <div id="adTowpSyncAuto_attr_access_desc" class="mo_azos_help_desc">
						<span>
                        It provides the feature to sync CRM Data like sales, leads and Entity Data directly into WordPress.
                        </span>
                    </div>
                    <table class="mo-ms-tab-content-app-config-table">
                        <colgroup>
                            <col span="1" style="width: 20%;">
                            <col span="2" style="width: 70%;">
                        </colgroup>
                        <tr>
                            <td><span>Select Object Type</span></td>
                            <td>
                            <select style="padding:1px 10px;width:91%;margin-top:5px;background-color:#fff">
                                <option value="Sales">Sales</option>
                                <option value="Leads">Leads</option>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex">
                                    <input disabled style="background-color: #DCDAD1;border:none;" type="submit" class="mo-ms-tab-content-button" value="Sync All">
                                    <div class="loader-placeholder"></div>
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