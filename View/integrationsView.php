<?php

namespace MoAzureObjectSync\View;

use MoAzureObjectSync\Wrappers\pluginConstants;

class integrationsView{

    private static $instance;

    public static function getView(){
        if(!isset(self::$instance)){
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }

    public function mo_azos_display_integrations_view(){
        $this->mo_azos_show_support_form_widget();
        ?>
        <div style="display:flex;justify-content:space-between;align-items:flex-start;padding-top:20px;">
            <div style="width:97%;" id="mo_azos_container" class="mo-container">
                <a class="mo_azos_integration_button" style="width:10%;margin:10px;" href='<?php echo esc_url(remove_query_arg("tab")); ?>'><- Go Back</a>
                <div style="display:flex;justify-content:center;align-items:center;flex-direction:column;">
                    <div class="mo_azos_heading_container" style="justify-content:center;">
                        <img id="mo-ms-title-logo" src="<?php echo esc_url(plugin_dir_url(MO_AZOS_PLUGIN_FILE).'images/miniorange.png');?>">
                        <h1><label for="sync_integrator">User Sync for Azure AD / Azure B2C</label></h1>
                    </div>
                    <div>
                        <h2 style="color:#039BE5;"><i>Check out all our Office 365 Integrations with WordPress</i></h2>
                    </div>
                    <hr style="border:solid 1px #eee;width:80%;"/>
                </div>

                <!-- Show all cards here -->
                <div class="mo_azos_integrations_card_container">
                    <?php
                            $allCards = pluginConstants::ALL_INTEGRATIONS_CARDS;
                            
                            foreach($allCards as $card_key => $card_val){
                                ?>
                                        <div id="<?php echo esc_html($card_key); ?>_key" class="mo_azos_integrations_card">
                                            <img width="60px" height="60px"  src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/'.$card_val["image"] );?>">
                                            <div class="mo_azos_integrations_card__title"><?php echo esc_html($card_val["title"]); ?></div>
                                            <ul class="mo_azos_integrations_card__description">
                                                <?php echo ($card_val["description"]); ?>
                                            </ul>
                                            <div id="<?php echo esc_html($card_key); ?>" onclick="selectCategoryFunction(this)" style="background-color:#039BE5;padding:12px;color:#fff;border-radius:12px;cursor:pointer">
                                                Contact Us
                                            </div>
                                        </div>
                                <?php
                            }

                    ?>
                    <script>
                        function selectCategoryFunction(ele){
                            jQuery('select').val(ele.id);
                            jQuery(".support-form-container").css('display','block');
                        }
                    </script>
                </div>
            </div>
       
        <?php
    }


    // contact us widget
    public function mo_azos_show_support_form_widget(){
        $supportmail = "samlsupport@xecurify.com";
        $current_user = wp_get_current_user();
        $fname = $current_user->user_firstname;
        $lname = $current_user->user_lastname;
        ?>
        <div class="support-icon">
            <div class="help-container" id="help-container">
                <span class="container-core">
                    <div class="need">
                        <span class="container-rel"></span>
                        <div class="container-details">
                            <div class="container-text">
                                <span style="font-family:Trebuchet MS, Helvetica, sans-serif;color:#333333;"> Hello there! </span><br>
                                <p class="helpline">Need Help? We are right here!</p>
                            </div>
                        </div>
                    </div>
                </span>
            </div>

            <div class="service-btn" id="service-btn">
                <div class="service-icon">
                    <img src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/mail.png');?>" class="service-img" alt="support">
                </div>
            </div>
        </div>

        <div class="support-form-container">
            <span class="container-rel"></span>
            <div class="widget-header" >
                <div class="widget-header-text"><h4>Contact miniOrange Support</h4></div>
                <div class="widget-header-close-icon">
                    <button type="button" class="notice-dismiss" id="mo_saml_close_form">
                        </button>
                </div>
            </div>

            <div class="loading-inner" style="overflow:hidden;">
                <div class="loading-icon">
                    <div class="loading-icon-inner">
                    <span class="icon-box">
                        <img class="icon-image" src="<?php echo esc_html(plugin_dir_url(__FILE__).'../images/success.png');?>" alt="success">
                    </span>
                    <p class="loading-icon-text">
                        <p>Thanks for your inquiry.<br><br>If you dont hear from us within 24 hours, please feel free to send a follow up email to <a href="mailto:<?php echo esc_html($supportmail);?>"><?php echo esc_html($supportmail);?></a></p>
                    </p>
                    </div>
                </div>
            </div>

            <div class="loading-inner-2" style="overflow:hidden;">
                <div class="loading-icon-2">
                    <div class="loading-icon-inner-2">
                    <br>
                    <span class="icon-box-2">
                        <img class="icon-image-2" src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/error.png');?>" alt="error">
                    </span>
                    <p class="loading-icon-text-2">
                        <p>Unable to connect to Internet.<br>Please try again.</p>
                    </p>
                    </div>
                </div>
            </div>
        
            <div class="loading-inner-3" style="overflow:hidden;">
                <div class="loading-icon-3">
                    <p class="loading-icon-text-3">
                        <p style="font-size:18px;">Please Wait...</p>
                    </p>
                    <div class="loader"></div>
                </div>
            </div>
        

            <form role="form" action="" id="support-form" method="post" class="support-form top-label">
                <div class="field-group">
                <label class="field-group-label" for="email">
                    <span class="label-name">Your Contact E-mail</span>
                </label>
                <input value="<?php echo ( esc_html(get_option( 'mo_saml_admin_email' )) == '' ) ? esc_html(get_option( 'admin_email' )) : esc_html(get_option( 'mo_saml_admin_email' )); ?>" type="email" class="field-label-text" style="background-color: #f1f1f1;height:30px;" name="email" id="person_email" dir="auto"  required="true"  title="Enter a valid email address." placeholder="Enter valid email">
                </div>
                <div class="field-group">
                    <label class="field-group-label">
                        <span class="label-name">What are you looking for</span>
                    </label >
                    <select class="what_you_looking_for" style="background-color: #f1f1f1; max-width:26.5rem;">
                            <option class="Select-placeholder" value="" disabled>Select Category</option>
                            <option value="Azure Integration">Azure AD / B2C User Sync</option>
                            <option value="SharePoint Integration">SharePoint Integration</option>
                            <option value="PowerBI Integration">Power BI Integration</option>
                            <option value="MSTeams Integration">Microsoft Teams Integration</option>
                            <option value="OneDrive Integration">One Drive Integration</option>
                            <option value="PowerApps Integration">Power Apps Integration</option>
                            <option value="Outlook Integration">Outlook Calender/Mails Integration</option>
                            <option value="DyanamicCRM365 Integration">Dyanamic CRM 365 Integration</option>
                            <option value="ApplicationInsights Integration">MS Application Insights Integration</option>
                            <option value="Yammer Integration">Yammer Integration</option>
                            <option value="OneNote Integration">OneNote Integration</option>
                            <option value="Planner Integration">Microsoft Planner Integration</option>
                            <option value="MSBookings Integration">Microsoft Bookings Integration</option>
                            <option value="MSExcel Integration">Microsoft Excel Integration</option>
                            <option value="MSToDo Integration">Microsoft To-Do Integration</option>
                            <option value="Plugin Pricing">I want to discuss about Plugin Pricing</option>
                            <option value="Custom Requirement">I have custom requirement</option>
                            <option value="Others">My reason is not listed here </option>
                    </select>
                </div>
                <div class="field-group">
                <label class="field-group-label" for="description">
                    <span class="label-name">How can we help you?</span>
                </label>
                <textarea rows="4" id="person_query" name="description" dir="auto" required="true" class="field-label-textarea" placeholder="You will get reply via email"></textarea>
                </div>
                <div class="submit_button">
                <button id="" type="submit" class="button1 button_new_color button__appearance-primary submit-button" value="Submit" aria-disabled="false">Submit</button>
                </div>
            </form>
        </div>
    

        <script>
            jQuery("#mo_saml_close_form").click(function(){
                jQuery(".support-form-container").css('display','none');
            });

        </script>

        <script>
            jQuery(".help-container").click(function(){
                jQuery(".support-form-container").css('display','block');
                //jQuery(".help-container").css('display','none');
            });

            jQuery(".service-img").click(function(){
                jQuery('input[type="text"], textarea').val('');
                jQuery('select').val('');
                jQuery(".support-form-container").css('display','block');
                jQuery(".support-form").css('display','block');
                jQuery(".loading-inner").css('display','none');
                jQuery(".loading-inner-2").css('display','none');
                jQuery(".loading-inner-3").css('display','none');
                //jQuery(".help-container").css('display','none');
            });
        </script>

        <script>
            jQuery('.support-form').submit(function(e){
                e.preventDefault();
                
                var email = jQuery('#person_email').val();
                var query = jQuery('#person_query').val();
                var look= jQuery('.what_you_looking_for').val();
                var fname = "<?php echo esc_html($fname); ?>";
                var lname = "<?php echo esc_html($lname); ?>";

                if(look == '' || look == null){
                    look = 'empty';
                }
            
                query1= '<b>['+look+']</b> <br><b>Azure AD Sync Plugin Integration Question: </b>'+query+' <br> ';

                if(email == "" || query == "" || query1 == ""){

                    jQuery('#login-error').show();
                    jQuery('#errorAlert').show();

                }
                else{
                    jQuery('input[type="text"], textarea').val('');
                    jQuery('select').val('Select Category');
                    jQuery(".support-form").css('display','none');
                    jQuery(".loading-inner-3").css('display','block');
                    var json = new Object();

                    json = {
                        "email" : email,
                        "query" : query1,
                        "ccEmail" : "samlsupport@xecurify.com",
                        "company" : "<?php esc_html($_SERVER ['SERVER_NAME']) ?>",
                        "firstName" : fname,
                        "lastName" : lname,
                    }
                    
                    var jsonString = JSON.stringify(json);
                    jQuery.ajax({

                        url: "https://login.xecurify.com/moas/rest/customer/contact-us",
                        type : "POST",
                        data : jsonString,
                        crossDomain: true,
                        dataType : "text",
                        contentType : "application/json; charset=utf-8",
                        success: function (data, textStatus, xhr) { successFunction();},
                        error: function (jqXHR, textStatus, errorThrown) { errorFunction(); }

                    });
                
                }
            });

            function successFunction(){
                
                jQuery(".loading-inner-3").css('display','none');
                jQuery(".loading-inner").css('display','block');
            }

            function errorFunction(){
                
                jQuery(".loading-inner-3").css('display','none');
                jQuery(".loading-inner-2").css('display','block');
            }
        </script>
        <?php
    }
}