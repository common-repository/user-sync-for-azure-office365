<?php

namespace MoAzureObjectSync\View;

class powerBI{

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
            'app' => 'mo_azos_display__powerbi_config',
        ];

        ?>
        <div class="mo-ms-tab-content" style="width: 60%">
            <h1>Configure PowerBI Application</h1>
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

    private function mo_azos_display__powerbi_config(){
       
        ?>
        
            <div class="mo-ms-tab-content-tile">
                <div class="mo-ms-tab-content-tile-content">
                    <span style="font-size: 18px;font-weight: 200">
                    1. Generate a Shortcode to Embed
                        <sup style="font-size: 12px;color:red;font-weight:600;">
                                [Available in Premium Plugin]
                        </sup>
                    </span>
                    <div id="app_config_access_desc" class="mo_azos_help_desc">
						<span>
                         Configure following settings to generate a <b>shortcode</b> to embed the different artifacts like reports, dashboards, tiles in the WordPress.
                         You can restrict these artifacts based on user roles, memberships with the help of RLS ( Row Level Security ).
                         </span>
                    </div>
                    <div style="margin-top:20px;font-size:15px;display:flex;justify-content:flex-start;align-items:center;">
                        <p style="font-size: 14px;">Please find the button to the <b> step by step guide </b> for setting up the following configurations:  </p> 
                        <a target="_blank" class="mo_azos_integration_button" style="height:12px;width:190px;font-size:0.84em;box-shadow:none;font-weight:600;" href='https://plugins.miniorange.com/microsoft-power-bi-embed-for-wordpress#setup-guidelines'> Click here to open Guide </a>  
                    </div>
                    </br>
                    <table class="mo-ms-tab-content-app-config-table">
                        <colgroup>
                            <col span="1" style="width: 20%;">
                            <col span="2" style="width: 70%;">
                        </colgroup>
                        <tr>
                            <td><span>Select PowerBI Artifact</span></td>
                            <td>
                            <select style="padding:1px 10px;width:91%;margin-top:5px;background-color:#fff" onclick="handleArtifact(this)">
                                <option value="report">Report</option>
                                <option value="dashboard">Dashboard</option>
                                <option value="tile">Tile</option>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td></br></td>
                        </tr>
                        <tr>
                            <td><span>WorkSpace ID <span style="color:red;font-weight:bold;">*</span></span></td>
                            <td>
                                <input disabled style="border:1px solid #eee;" placeholder="Enter WorkSpace ID Here" type="text" name="workspace_id" value="">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <b>Note:</b> You can find the <b>WorkSpace ID</b> in your powerBI report URL. 
                            </td>
                        </tr>
                        <tr>
                            <td></br></td>
                        </tr>
                        <tr id="report_row">
                            <td><span>Report ID <span style="color:red;font-weight:bold;">*</span></span></td>
                            <td><input disabled style="border:1px solid #eee;" placeholder="Enter Report ID Here" type="text" name="report_id" value=""></td>
                        </tr>
                        <tr id="report_row_note">
                            <td></td>
                            <td>
                                <b>Note:</b> You can find the <b>Report ID</b> in your powerBI report URL.  
                            </td>
                        </tr>
                        <tr id="report_row_margin">
                            <td></br></td>
                        </tr>
                        <tr id="dashboard_row" hidden>
                            <td><span>Dashboard ID <span style="color:red;font-weight:bold;">*</span></span></td>
                            <td><input disabled style="border:1px solid #eee;" placeholder="Enter Dashboard ID Here" type="text" name="report_id" value=""></td>
                        </tr>
                        <tr id="dashboard_row_note" hidden>
                            <td></td>
                            <td>
                                <b>Note:</b> You can find the <b>Dashboard ID</b> in your powerBI dashboard URL.  
                            </td>
                        </tr>
                        <tr id="dashboard_row_margin" hidden>
                            <td></br></td>
                        </tr>
                        <tr id="tile_row" hidden>
                            <td><span>Tile ID <span style="color:red;font-weight:bold;">*</span></span></td>
                            <td><input disabled style="border:1px solid #eee;" placeholder="Enter Tile ID Here" type="text" name="report_id" value=""></td>
                        </tr>
                        <tr id="tile_row_note" hidden>
                            <td></td>
                            <td>
                                <b>Note:</b> You can find the <b>Tile ID</b> in your powerBI tile URL.  
                            </td>
                        </tr>
                        <tr id="tile_row_margin" hidden>
                            <td></br></td>
                        </tr>
                        <tr>
                            <td><span>Width</span></td>
                            <td><input disabled style="border:1px solid #eee;" placeholder="Enter Width of Report" type="text" name="report_width" value=""></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <b>Note:</b> You can mention the width of report in px,vh,%, etc.  
                            </td>
                        </tr>
                        <tr>
                            <td></br></td>
                        </tr>
                        <tr>
                            <td><span>Height</span></td>
                            <td><input disabled style="border:1px solid #eee;" placeholder="Enter Height of Report" type="text" name="report_height" value=""></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <b>Note:</b> You can mention the height of report in px,vh,%, etc. 
                            </td>
                        </tr>
                        <tr>
                            <td></br></td>
                        </tr>
                    </table>
                    <div style="display: flex;">
                        <input disabled style="background-color: #DCDAD1;border:none;width:150px;height:30px;" type="submit" class="mo-ms-tab-content-button" value="Generate ShortCode">
                    </div>
                   
                    <div style="background-color:#eee;display:flex;justify-content:center;align-items:center;width:94%;padding:20px;margin-top:14px;border:1px dashed #000;">
                        <span>[MO_API_POWER_BI&nbsp; workspace_id="YOUR_WORKSPACE_ID_HERE" &nbsp; <span id="shortcode_report">report_id="YOUR_REPORT_ID_HERE"&nbsp;</span> <span hidden id="shortcode_dashboard">dashboard_id="YOUR_DASHBOARD_ID_HERE"&nbsp;</span> <span hidden id="shortcode_tile">tile_id="YOUR_TILE_ID_HERE"&nbsp;</span> width="800px"&nbsp; height="800px" ]</span>
                    </div>                   
                </div>
                <script>
                    function handleArtifact(ele){
                        let artifact = ele.value;

                        if(artifact === 'report'){
                            document.getElementById('report_row').removeAttribute('hidden');
                            document.getElementById('report_row_note').removeAttribute('hidden');
                            document.getElementById('report_row_margin').removeAttribute('hidden');
                            document.getElementById('shortcode_report').style.display = 'inline-block';

                            document.getElementById('dashboard_row').setAttribute("hidden",true)
                            document.getElementById('dashboard_row_note').setAttribute("hidden",true)
                            document.getElementById('dashboard_row_margin').setAttribute("hidden",true)
                            document.getElementById('shortcode_dashboard').style.display = 'none';

                            document.getElementById('tile_row').setAttribute("hidden",true)
                            document.getElementById('tile_row_note').setAttribute("hidden",true)
                            document.getElementById('tile_row_margin').setAttribute("hidden",true)
                            document.getElementById('shortcode_tile').style.display = 'none';

                        }else if(artifact === 'dashboard'){
                            document.getElementById('dashboard_row').removeAttribute('hidden');
                            document.getElementById('dashboard_row_note').removeAttribute('hidden');
                            document.getElementById('dashboard_row_margin').removeAttribute('hidden');
                            document.getElementById('shortcode_dashboard').style.display = 'inline-block';

                            document.getElementById('report_row').setAttribute("hidden",true)
                            document.getElementById('report_row_note').setAttribute("hidden",true)
                            document.getElementById('report_row_margin').setAttribute("hidden",true)
                            document.getElementById('shortcode_report').style.display = 'none';

                            document.getElementById('tile_row').setAttribute("hidden",true)
                            document.getElementById('tile_row_note').setAttribute("hidden",true)
                            document.getElementById('tile_row_margin').setAttribute("hidden",true)
                            document.getElementById('shortcode_tile').style.display = 'none';
                        }else{
                            document.getElementById('report_row').setAttribute("hidden",true)
                            document.getElementById('report_row_note').setAttribute("hidden",true)
                            document.getElementById('report_row_margin').setAttribute("hidden",true)
                            document.getElementById('shortcode_report').style.display = 'none';

                            document.getElementById('dashboard_row').removeAttribute('hidden');
                            document.getElementById('dashboard_row_note').removeAttribute('hidden');
                            document.getElementById('dashboard_row_margin').removeAttribute('hidden');
                            document.getElementById('shortcode_dashboard').style.display = 'inline-block';

                            document.getElementById('tile_row').removeAttribute('hidden');
                            document.getElementById('tile_row_note').removeAttribute('hidden');
                            document.getElementById('tile_row_margin').removeAttribute('hidden');
                            document.getElementById('shortcode_tile').style.display = 'inline-block';
                        }

                    }
                </script>
            </div>
        <?php
    }

}