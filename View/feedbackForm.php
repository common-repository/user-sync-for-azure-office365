<?php

namespace MoAzureObjectSync\View;

class feedbackForm{

    private static $instance;

    public static function getView(){
        if(!isset(self::$instance)){
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }

    public function mo_azos_display_feedback_form(){

        if ( 'plugins.php' != basename( $_SERVER['PHP_SELF'] ) ) {
            return;
        }

        wp_enqueue_style( 'mo_azos_css_plugin', plugins_url( '../includes/css/mo_azos_settings.css', __FILE__ ) );

        ?>


        <div id="feedback_modal" class="mo_modal" style="width:90%; margin-left:12%; margin-top:5%; text-align:center;">

            <div class="mo_modal-content" style="width:50%;">
                <h3 style="margin: 2%; text-align:center;"><b><?php esc_html_e('Your feedback','WP Azure Object Sync');?></b><span class="mo_close" style="cursor: pointer">&times;</span>
                </h3>
                <hr style="width:75%;">
                
                <form name="f" method="post" action="" id="mo_feedback">
                    <?php wp_nonce_field("mo_azos_feedback");?>
                    <input type="hidden" name="option" value="mo_azos_feedback"/>
                    <div>
                        <p style="margin:2%">
                        <h4 style="margin: 2%; text-align:center;"><?php esc_html_e('Please help us to improve our plugin by giving your opinion.','WP Azure Object Sync');?><br></h4>
                        
                        <div id="smi_rate" style="text-align:center">
                        <input type="radio" name="rate" id="angry" value="1"/>
                            <label for="angry"><img class="sm" src="<?php echo esc_url(plugin_dir_url( __FILE__ ) . '../images/angry.png'); ?>" />
                            </label>
                            
                        <input type="radio" name="rate" id="sad" value="2"/>
                            <label for="sad"><img class="sm" src="<?php echo esc_url(plugin_dir_url( __FILE__ ) . '../images/sad.png'); ?>" />
                            </label>
                        
                        
                        <input type="radio" name="rate" id="neutral" value="3"/>
                            <label for="neutral"><img class="sm" src="<?php echo esc_url(plugin_dir_url( __FILE__ ) . '../images/normal.png'); ?>" />
                            </label>
                            
                        <input type="radio" name="rate" id="smile" value="4"/>
                            <label for="smile">
                            <img class="sm" src="<?php echo esc_url(plugin_dir_url( __FILE__ ) . '../images/smile.png'); ?>" />
                            </label>
                            
                        <input type="radio" name="rate" id="happy" value="5" checked/>
                            <label for="happy"><img class="sm" src="<?php echo esc_url(plugin_dir_url( __FILE__ ) . '../images/happy.png'); ?>" />
                            </label>
                            
                        <div id="outer" style="visibility:visible"><span id="result"><?php esc_html_e('Thank you for appreciating our work','WP Azure Object Sync');?></span></div>
                        </div><br>
                        <hr style="width:75%;">
                        <?php $email = get_option("mo_saml_admin_email");
                            if(empty($email)){
                                $user = wp_get_current_user();
                                $email = $user->user_email;
                            }
                            ?>
                        <div style="text-align:center;">
                            
                            <div style="display:inline-block; width:60%;">
                            <input type="email" id="query_mail" name="query_mail" style="text-align:center; border:0px solid black; border-style:solid; background:#f0f3f7; width:20vw;border-radius: 6px;"
                                placeholder="<?php _e('Please enter your email address','WP Azure Object Sync');?>" required value="<?php echo $email; ?>" readonly="readonly"/>
                            
                            <input type="radio" name="edit" id="edit" onclick="editName()" value=""/>
                            <label for="edit"><img class="editable" src="<?php echo esc_url(plugin_dir_url( __FILE__ ) . '../images/61456.png'); ?>" />
                            </label>
                            
                            </div>
                            <br><br>
                            <textarea id="query_feedback" name="query_feedback" rows="4" style="width: 60%"
                                placeholder="<?php _e('Tell us what happened!','WP Azure Object Sync');?>"></textarea>
                            <br><br>
                            <input type="checkbox" name="get_reply" value="reply" checked><?php esc_html_e('miniOrange representative will reach out to you at the email-address entered above.','WP Azure Object Sync');?></input>
                        </div>
                        <br>
                    
                        <div class="mo-modal-footer" style="text-align: center;margin-bottom: 2%">
                            <input type="submit" name="miniorange_feedback_submit"
                                class="button button-primary button-large" value="<?php esc_html_e('Send','WP Azure Object Sync');?>"/>
                            <span width="30%">&nbsp;&nbsp;</span>
                            <input type="button" name="miniorange_skip_feedback"
                                class="button button-primary button-large" value="<?php esc_html_e('Skip','WP Azure Object Sync');?>" onclick="document.getElementById('mo_feedback_form_close').submit();"/>
                        </div>
                    </div>
                    

                </form>
                <form name="f" method="post" action="" id="mo_feedback_form_close">
                    <?php wp_nonce_field("mo_azos_skip_feedback");?>
                    <input type="hidden" name="option" value="mo_azos_skip_feedback"/>
                </form>

            </div>

        </div>

        <script>
            jQuery('a[aria-label="Deactivate User Sync for Azure AD / Azure B2C"]').click(function () {

                var mo_modal = document.getElementById('feedback_modal');

                var span = document.getElementsByClassName("mo_close")[0];

                mo_modal.style.display = "block";
                document.querySelector("#query_feedback").focus();
                span.onclick = function () {
                    mo_modal.style.display = "none";
                    jQuery('#mo_feedback_form_close').submit();
                };

                window.onclick = function (event) {
                    if (event.target === mo_modal) {
                        mo_modal.style.display = "none";
                    }
                };
                return false;

            });

            const INPUTS_AZOS = document.querySelectorAll('#smi_rate input');
            INPUTS_AZOS.forEach(el => el.addEventListener('click', (e) => updateValue(e)));


            function editName(){

                document.querySelector('#query_mail').removeAttribute('readonly');
                document.querySelector('#query_mail').focus();
                return false;

            }
            function updateValue(e) {
                document.querySelector('#outer').style.visibility="visible";
                var result = '<?php esc_html_e('Thank you for appreciating our work','WP Azure Object Sync');?>';
                switch(e.target.value){
                    case '1':	result = '<?php esc_html_e('Not happy with our plugin? Let us know what went wrong','WP Azure Object Sync');?>';
                        break;
                    case '2':	result = '<?php esc_html_e('Found any issues? Let us know and we\'ll fix it ASAP','WP Azure Object Sync');?>';
                        break;
                    case '3':	result = '<?php esc_html_e('Let us know if you need any help','WP Azure Object Sync');?>';
                        break;
                    case '4':	result = '<?php esc_html_e('We\'re glad that you are happy with our plugin','WP Azure Object Sync');?>';
                        break;
                    case '5':	result = '<?php esc_html_e('Thank you for appreciating our work');?>';
                        break;
                }
                document.querySelector('#result').innerHTML = result;

            }
        </script><?php

    } 
}