<?php

namespace MoAzureObjectSync\View;

use MoAzureObjectSync\Wrappers\wpWrapper;

class showTestAttributes{

    private static $instance;

    public static function getView(){
        if(!isset(self::$instance)){
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }

  
    function mo_azos_display_attrs_list($test_attrs){
        
        if(!empty($test_attrs)){
            echo '<div class="mo_azos_support_layout" style="padding-bottom:20px; padding-right:5px;margin-right:8px;">
            <h3>Attributes received for test user:</h3>
                    <div>
                        <table style="border-collapse:collapse;border-spacing:0;table-layout: fixed; width: 95%;background-color:#ffffff;">
                        <tr style="text-align:center;"><td style="font-weight:bold;border:1px solid #949090;padding:2%; width:65%;">ATTRIBUTE NAME</td><td style="font-weight:bold;padding:2%;border:1px solid #949090; word-wrap:break-word; width:35%;">ATTRIBUTE VALUE</td></tr>';
    
                            foreach($test_attrs as $attr_name => $attr_val){
                                if(!is_array($attr_val) && !empty($attr_val) && $attr_name !== 'Profile Picture'){
                                    
                                    echo '<tr style="text-align:center;"><td style="font-weight:bold;border:1px solid #949090;padding:2%; word-wrap:break-word;">' . esc_html($attr_name) . '</td>';
                                    echo '<td style="padding:2%;border:1px solid #949090; word-wrap:break-word;">' .esc_html($attr_val) . '</td>
                                    </tr>';
                                }
                            }
                            echo '
                        </table>
                        <br/>
                    </div>
            </div>';
        }
    }
    

}