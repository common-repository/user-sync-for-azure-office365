<?php

namespace MoAzureObjectSync\View;

use MoAzureObjectSync\Wrappers\pluginConstants;

class demoRequest{

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
            'app' => 'mo_azos_display__demo_request_form',
        ];

        ?>
        <div class="mo-ms-tab-content" style="width: 60%">
            <h1>Request For Demo</h1>
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

    private function mo_azos_display__demo_request_form(){

        $features_list = pluginConstants::DEMO_REQUEST_FEATURES_LIST;
        $mo_saml_admin_email = !empty(get_option('mo_saml_admin_email')) ? get_option('mo_saml_admin_email') : get_option('admin_email');
       
        ?>
        
            <div class="mo-ms-tab-content-tile">
                <div class="mo-ms-tab-content-tile-content">
                    <div style="font-size: 16px;font-weight: 480;background-color:#B3E5FC;width:95%;padding:20px;text-align:center">
                   <i> Want to try out the paid features before purchasing the license? Just let us know about your requirements and we will setup a demo for you.</i>
                </div>
                <form method="post" action="">
                    <?php wp_nonce_field("mo_azos_demo_request_option");?>
                    <input type="hidden" name="option" value="mo_azos_demo_request_option"/>
                    <table class="mo-ms-tab-content-app-config-table">
                        <colgroup>
                            <col span="1" style="width: 20%;">
                            <col span="2" style="width: 70%;">
                        </colgroup>
                        <tr>
                            <td><span>Email :</span></td>
                            <td><input placeholder="We will use this email to setup the demo for you" required type="email" name="demo_email" value="<?php echo esc_html($mo_saml_admin_email); ?>"></td>
                        </tr>
                        <tr>
                            <td><span>Description :</span></td>
                            <td>
                            <textarea class="mo_azos_table_textbox" placeholder="Write us about your requirement" style="width:100%;" name="demo_desc" rows="7" style="resize: vertical;" ></textarea>
                            </td>
                        </tr>
                    </table>
                    <div style="margin:10px 0px;">Select the features you are interested in :</div>
                    <div style="display:flex;justify-content:flex-start;align-items:flex-start;flex-direction:column">
                    <?php
                        foreach($features_list as $key => $feature){?>
                            <div style="display:flex;justify-content:center;align-items:center;margin:8px;">
                                <input type="checkbox" name="<?php echo esc_html($key);?>"/>
                                <span><?php echo esc_html($feature); ?></span>
                            </div>
                    <?php
                        }
                    ?>
                    </div>
                    <div style="display: flex;margin-top:20px;">
                        <input style="width:150px;height:30px;" type="submit" class="mo-ms-tab-content-button" value="Send Request">
                    </div>
                </form>
                            
                </div>
            </div>
        <?php
    }

}