<?php


namespace MoAzureObjectSync\View;

use MoAzureObjectSync\Wrappers\pluginConstants;

class welcomeView{

    private static $instance;

    public static function getView(){
        if(!isset(self::$instance)){
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }

    public function mo_azos_display_welcome_page(){
        $this->mo_azos_show_support_form_widget();
        ?>
    
        <div id="mo_azos_getting-started">
            <div class="mo_azos_header__container">
                <div class="mo_azos_header__left">
                    <div class="mo_azos_header__left_title">Let's Get Started!</div>
                    <p class="mo_azos_header__left_description">
                        Hey there, Thank you for installing <span style="font-weight:700">User Sync For Azure AD / B2C plugin!</span>
                        This plugin offers user synchronization from your Azure AD/Azure B2C/Office365 Microsoft tenant into your WordPress site using microsoft graph APIs.
                        Make sure to check out the list of supported features and integrations to increase the functionality of your WordPress site.<br><br>
                        Feel free to contact us at <a style="color: springgreen" href="mailto:samlsupport@xecurify.com">samlsupport@xecurify.com</a> for further queries or questions.
                    </p>
                    <div class="mo_azos_header__left_buttons">
                    <a target="_blank" class="mo_azos_integration_button" style="height:18px;width:165px;font-size:14px;background-color:#fff;color:#0091EA;z-index:5;font-weight:bold;" href='https://plugins.miniorange.com/azure-ad-user-sync-wordpress-with-microsoft-graph'>
                        <img width="15" height="15" style="margin-right:5px;" src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/ad.svg');?>"> Azure AD / B2C Guide 
                    </a>  
                    <a class="mo_azos_integration_button" style="height:18px;width:160px;font-size:14px;background-color:#fff;color:#0091EA;z-index:5;font-weight:bold;" href='<?php echo esc_url(admin_url()).'admin.php?page=mo_azos&tab=integrations'; ?>'>
                        <span style="margin-right: 10px;" class="dashicons dashicons-image-filter"></span> Features
                    </a>  
                    </div>
                    <div class="mo_azos_header__left_buttons">
                        <a class="mo_azos_integration_button" style="height:18px;width:350px;font-size:14px;background-color:#fff;color:#115e70;z-index:5;font-weight:bold;" href='<?php echo esc_url(admin_url()).'admin.php?page=mo_azos'; ?>'>
                            <span style="margin-right: 6px;" class="dashicons dashicons-admin-generic"></span> Let's configure the plugin →
                        </a>
                    </div>
                </div>
                <div class="mo_azos_header__right">
                    <div class="mo_azos_guide__video">
                        <iframe style="height:92%;width:99%" src='<?php echo esc_url(pluginConstants::YOUTUBE_GUIDE_LINK); ?>'>
                        </iframe>
                    </div>
                </div>
            </div>

        </div>
        <?php
    }

    public function mo_azos_show_support_form_widget(){
        $supportmail = "samlsupport@xecurify.com";
        $current_user = wp_get_current_user();
        $fname = $current_user->user_firstname;
        $lname = $current_user->user_lastname;
        ?>
        <div class="support-icon">
            <!-- <div class="help-container" id="help-container">
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
            </div> -->

            <div class="service-btn" id="service-btn" >
                <div class="service-icon" style="display: flex;justify-content:center;align-items:center;background-color:#1565C0;box-shadow: rgba(1, 87, 155, 0.35) 0px 5px 15px;">
                    <img src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/mail.png');?>" class="service-img" alt="support">
                </div>
            </div>
        </div>

        <div class="support-form-container">
        <span class="container-rel"></span>
            <div class="widget-header" style="background-color:#0288D1">
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
                        <img class="icon-image" src="<?php echo esc_url(plugin_dir_url(__FILE__).'../images/success.png');?>" alt="success">
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
                        <span class="label-name">Your Contact Mobile No.</span>
                    </label >
                    <input type="tel" id="contact_us_phone" style="background-color: #f1f1f1;height:30px;" pattern="[\+]?[0-9]{1,4}[\s]?([0-9]{4,12})*" class="field-label-text" name="mo_azos_contact_us_phone" value="<?php echo  esc_html(get_option( 'mo_saml_admin_phone' )); ?>" placeholder="Enter your phone">
                </div>
                <div class="field-group">
                <label class="field-group-label" for="description">
                    <span class="label-name">How can we help you?</span>
                </label>
                <textarea rows="4" id="person_query" name="description" dir="auto" required="true" class="field-label-textarea" placeholder="You will get reply via email"></textarea>
                </div>
                <div class="submit_button">
                <button id="" type="submit" class="button1 button__appearance-primary submit-button" style="background-color:#0277BD" value="Submit" aria-disabled="false">Submit</button>
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
                var phone = jQuery('#contact_us_phone').val();
                var query = jQuery('#person_query').val();
                var fname = "<?php echo esc_html($fname); ?>";
                var lname = "<?php echo esc_html($lname); ?>";

                query = '[WordPress AzureAD User Sync] ' + query;

                if(email == "" || query == ""){

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
                        "query" : query,
                        'phone' : phone,
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
            function mo_azos_valid_query(f) {
            !(/^[a-zA-Z?,.\(\)\/@ 0-9]*$/).test(f.value) ? f.value = f.value.replace(
                /[^a-zA-Z?,.\(\)\/@ 0-9]/, '') : null;
            }

            jQuery("#contact_us_phone").intlTelInput();

            jQuery( function() {
            jQuery("#js-timezone").select2();

            jQuery("#js-timezone").click(function() {
                var name = $('#name').val();
                var email = $('#email').val();
                var message = $('#message').val();
                jQuery.ajax ({
                    type: "POST",
                    url: "form_submit.php",
                    data: { "name": name, "email": email, "message": message },
                    success: function (data) {
                        jQuery('.result').html(data);
                        jQuery('#contactform')[0].reset();
                    }
                });
            });

            jQuery("#datepicker").datepicker("setDate", +1);
            jQuery('#timepicker').timepicker('option', 'minTime', '00:00');

            jQuery("#mo_azos_setup_call").click(function() {
                if(jQuery(this).is(":checked")) {
                    document.getElementById("js-timezone").required = true;
                    document.getElementById("js-timezone").removeAttribute("disabled");
                    document.getElementById("datepicker").required = true;
                    document.getElementById("datepicker").removeAttribute("disabled");
                    document.getElementById("timepicker").required = true;
                    document.getElementById("timepicker").removeAttribute("disabled");
                    document.getElementById("mo_mo_azos_query").required = false;
                } else {
                    document.getElementById("timepicker").required = false;
                    document.getElementById("timepicker").disabled = true;
                    document.getElementById("datepicker").required = false;
                    document.getElementById("datepicker").disabled = true;
                    document.getElementById("js-timezone").required = false;
                    document.getElementById("js-timezone").disabled = true;
                    document.getElementById("mo_mo_azos_query").required = true;
                }
            });
            jQuery( "#datepicker" ).datepicker({
                minDate: +1,
                dateFormat: 'M dd, yy'
            });
        });

        jQuery('#timepicker').timepicker({
            timeFormat: 'HH:mm',
            interval: 30,
            minTime: new Date(),
            disableTextInput: true,
            dynamic: false,
            dropdown: true,
            scrollbar: true,
            forceRoundTime: true
        });
        </script>
        <?php
    }

    public function mo_azos_display_support_form(){
        ?>
        
        <div class="mo_azos_support_layout" style="width:100%">
            <div>
                <form method="post" action="">
                    <input type="hidden" name="option" value="mo_azos_contact_us_query_option" />
                    <?php  wp_nonce_field('mo_azos_contact_us_query_option'); ?>
                    <table class="mo_azos_settings_table">
                        <tr>
                            <td colspan="2"><input style="width:94%" type="email" class="mo_azos_table_textbox" required name="mo_azos_contact_us_email" value="<?php echo ( get_option( 'mo_saml_admin_email' ) == '' ) ? esc_html(get_option( 'admin_email' )) : esc_html(get_option( 'mo_saml_admin_email' )); ?>" placeholder="Email"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="tel" style="width:94%" id="contact_us_phone" pattern="[\+]?[0-9]{1,4}[\s]?([0-9]{4,12})*" class="mo_azos_table_textbox" name="mo_azos_contact_us_phone" value="<?php echo esc_html(get_option( 'mo_saml_admin_phone' )); ?>" placeholder="Enter your phone"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><textarea class="mo_azos_table_textbox" style="width:94%" onkeypress="mo_azos_valid_query(this)" onkeyup="mo_azos_valid_query(this)" onblur="mo_azos_valid_query(this)" required name="mo_azos_contact_us_query" rows="4" style="resize: vertical;" placeholder="How we can help you?"></textarea></td>
                        </tr> 
                        </table>
                        <div style="display: flex;justify-content:flex-start;align-items:center;">
                            <label class="switch" style="margin: 5px;">
                                        <input type="checkbox" style="background: #DCDAD1;" id="mo_azos_setup_call" name="mo_azos_setup_call"/>
                                        <span class="slider round"></span>
                                    </label>
                            <b style="margin: 5px;font-size:14px;"><?php esc_html_e('Enable to Setup a Call/Screen-Share Session With Us','WP Azure Object Sync');?></b>
                        </div>
                        <table class="mo_azos_settings_table">
                        <tr class="call_setup_dets">
                            <td>
                                <div style="width: 21%;"><strong><?php _e('TimeZone','WP Azure Object Sync');?><font color="#FF0000">*</font>:</strong></div> 
                            </td>
                            <td>
                                <div style="width: 100%;">
                                    <select disabled id="js-timezone" name="mo_azos_setup_call_timezone">
                                    <?php $zones = pluginConstants::time_zones; ?>
                                        <option value="" selected disabled>---------<?php _e('Select your timezone','WP Azure Object Sync');?>--------</option> <?php
                                        foreach($zones as $zone=>$value) {
                                            if($value == 'Etc/GMT'){ ?>
                                                <option value="<?php echo $value; ?>" selected><?php echo $zone; ?></option>
                                            <?php
                                            }
                                            else { ?>
                                                <option value="<?php echo $value; ?>"><?php echo $zone; ?></option>
                                                <?php
                                            }
                                        } ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr class="call_setup_dets">
                            <td>
                                <strong> <?php _e('Date','WP Azure Object Sync');?><font color="#FF0000">*</font>:</strong><br>
                            </td>
                            <td>
                                <input disabled type="text" id="datepicker" class="call-setup-textbox" placeholder="<?php _e('Select Meeting Date','WP Azure Object Sync');?>" autocomplete="off" name="mo_azos_setup_call_date">
                            </td>
                        </tr>
                        <tr class="call_setup_dets">
                            <td>
                                <strong> <?php _e('Time (24-hour)','WP Azure Object Sync');?><font color="#FF0000">*</font>:</strong><br>
                            </td>
                            <td>
                                <input disabled type="text" id="timepicker" placeholder="<?php _e('Select Meeting Time','WP Azure Object Sync');?>" class="call-setup-textbox" autocomplete="off" name="mo_azos_setup_call_time">
                            </td>
                        </tr>
                        <tr class="call_setup_dets">
                            <td colspan="2">
                                <p class="call-setup-notice">
                                    <b><font color="#dc143c"><?php _e('Call and Meeting details will be sent to your email. Please verify the email before submitting your query.','WP Azure Object Sync');?></font></b>
                                </p>
                            </td>
                        </tr>
                    </table>
                    
                    <div style="text-align:center;">
                        <input type="submit" name="submit" style=" width:120px;margin-top:4px;" class="button button-primary button-large"/>
                    </div>
                <div>
                    </div>
                </form>
            </div>
            <script>
            function mo_azos_valid_query(f) {
            !(/^[a-zA-Z?,.\(\)\/@ 0-9]*$/).test(f.value) ? f.value = f.value.replace(
                /[^a-zA-Z?,.\(\)\/@ 0-9]/, '') : null;
            }

            jQuery("#contact_us_phone").intlTelInput();

            jQuery( function() {
            jQuery("#js-timezone").select2();

            jQuery("#js-timezone").click(function() {
                var name = $('#name').val();
                var email = $('#email').val();
                var message = $('#message').val();
                jQuery.ajax ({
                    type: "POST",
                    url: "form_submit.php",
                    data: { "name": name, "email": email, "message": message },
                    success: function (data) {
                        jQuery('.result').html(data);
                        jQuery('#contactform')[0].reset();
                    }
                });
            });

            jQuery("#datepicker").datepicker("setDate", +1);
            jQuery('#timepicker').timepicker('option', 'minTime', '00:00');

            jQuery("#mo_azos_setup_call").click(function() {
                if(jQuery(this).is(":checked")) {
                    document.getElementById("js-timezone").required = true;
                    document.getElementById("js-timezone").removeAttribute("disabled");
                    document.getElementById("datepicker").required = true;
                    document.getElementById("datepicker").removeAttribute("disabled");
                    document.getElementById("timepicker").required = true;
                    document.getElementById("timepicker").removeAttribute("disabled");
                    document.getElementById("mo_mo_azos_query").required = false;
                } else {
                    document.getElementById("timepicker").required = false;
                    document.getElementById("timepicker").disabled = true;
                    document.getElementById("datepicker").required = false;
                    document.getElementById("datepicker").disabled = true;
                    document.getElementById("js-timezone").required = false;
                    document.getElementById("js-timezone").disabled = true;
                    document.getElementById("mo_mo_azos_query").required = true;
                }
            });
            jQuery( "#datepicker" ).datepicker({
                minDate: +1,
                dateFormat: 'M dd, yy'
            });
        });

        jQuery('#timepicker').timepicker({
            timeFormat: 'HH:mm',
            interval: 30,
            minTime: new Date(),
            disableTextInput: true,
            dynamic: false,
            dropdown: true,
            scrollbar: true,
            forceRoundTime: true
        });

        </script>
        </div>&nbsp
    <?php
    }
}