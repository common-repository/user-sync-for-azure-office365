<?php

namespace MoAzureObjectSync\View;

use MoAzureObjectSync\Wrappers\pluginConstants;

class supportForm{

    private static $instance;

    public static function getView(){
        if(!isset(self::$instance)){
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }

    public function mo_azos_display_support_form(){
    ?>
        <style>

            .support_container{ 
                display:flex;
                justify-content:flex-start;
                align-items:center;
                flex-direction:column;
                /*width:32em;*/
                margin:55px 10px;
                background-color:#BBDEFB;
                box-shadow: rgb(207,213,222) 1px 2px 4px;
                border: 1px solid rgb(216,216,216);
            }

            .support__telphone{
                width:27em;
            }

            .support_header{
                /* display: flex;
                justify-content: center;
                align-items: center; */
                width: 100%;
                height: 246px;
                background-image: url(<?php echo esc_url(plugin_dir_url(__FILE__).'../images/support-header2.jpg');?>);
                background-color: #fff;
                background-size: cover;
            }

            @media only screen and (min-width: 1700px) {
                .support_container{
                /*width:37em;*/
                }
            }

            @media only screen and (max-width: 1400px) {
                .support_container{
                /*width:28em;*/
                }
                .support__telphone{
                width:24em;
                }
            }

            @media only screen and (max-width: 1229px) {
                .support_container{
                /*width:23em;*/
                }
                .support__telphone{
                width:19.5em;
                }
            }

        </style>


        <div style="width: 32%">
            <form method="post" action="">
                <input type="hidden" name="option" value="mo_azos_contact_us_query_option" />
                <div class="support_container">
                    <div class="support_header">
                    </div>

			        <?php  wp_nonce_field('mo_azos_contact_us_query_option'); ?>
                    <div style="display:flex;justify-content:flex-start;align-items:center;width:90%;margin-top:8px;font-size:14px;font-weight:500;">Email:</div>
                    <input style="padding:10px 10px;width:91%;border:none;margin-top:4px;background-color:#fff" type="email" required name="mo_azos_contact_us_email" value="<?php echo ( esc_html(get_option( 'mo_saml_admin_email' )) == '' ) ? esc_html(get_option( 'admin_email' )) : esc_html(get_option( 'mo_saml_admin_email' )); ?>" placeholder="Email">
                    <div style="display:flex;justify-content:flex-start;align-items:center;width:90%;margin-top:8px;font-size:14px;font-weight:500;">Contact No.:</div>
                    <input id="contact_us_phone" class="" type="tel" style="padding:10px 42px;border:none;margin:5px;background-color:#fff;width:91%"  pattern="[\+]?[0-9]{1,4}[\s]?([0-9]{4,12})*" name="mo_azos_contact_us_phone" value="<?php echo esc_html(get_option( 'mo_saml_admin_phone' )); ?>" placeholder="Enter your phone">
                    <!-- <div style="display:flex;justify-content:flex-start;align-items:center;width:90%;margin-top:15px;font-size:14px;font-weight:500;">What you are looking for?</div> -->
                    <!-- <select class="what_you_looking_for" style="padding:1px 10px;width:91%;border:none;margin-top:5px;background-color:#fff">
                            <option value="AzureSync">I want to know about Azure AD / B2C User Sync</option>
                            <option value="AzureSyncPricing">I want to know about pricing of the premium plugin.</option>
                            <option value="AzureSyncIntegration">I want to know about Office365 integrations with WordPress.</option>
                    </select> -->
                    <div style="display:flex;justify-content:flex-start;align-items:center;width:90%;margin-top:5px;font-size:14px;font-weight:500;">How can we help you?</div>
                    <textarea style="padding:10px 10px;width:91%;border:none;margin-top:5px;background-color:#fff" onkeypress="mo_azos_valid_query(this)" onkeyup="mo_azos_valid_query(this)" onblur="mo_azos_valid_query(this)" required name="mo_azos_contact_us_query" rows="3" style="resize: vertical;" placeholder="You will get reply via email"></textarea>

                    <div style="text-align:center;">
                        <input type="submit" name="submit" style=" width:120px;margin:8px;" class="button button-primary button-large"/>
                    </div>
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
    <?php
    }
}