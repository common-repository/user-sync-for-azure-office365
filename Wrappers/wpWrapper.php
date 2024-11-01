<?php

namespace MoAzureObjectSync\Wrappers;

class wpWrapper{

    private static $instance;

    public static function getWrapper(){
        if(!isset(self::$instance)){
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }

    public static function mo_azos_set_option($key, $value){
        update_option($key,$value);
    }

    public static function mo_azos_get_option($key){
        return get_option($key);
    }

    public static function mo_azos_delete_option($key){
        return delete_option($key);
    }

    public static function mo_azos__show_error_notice($message){
        self::mo_azos_set_option(pluginConstants::notice_message,$message);
        $hook_name = 'admin_notices';
        remove_action($hook_name,[self::getWrapper(),'mo_azos_success_notice']);
        add_action($hook_name,[self::getWrapper(),'mo_azos_error_notice']);
    }

    public static function mo_azos__show_success_notice($message){
        self::mo_azos_set_option(pluginConstants::notice_message,$message);
        $hook_name = 'admin_notices';
        remove_action($hook_name,[self::getWrapper(),'mo_azos_error_notice']);
        add_action($hook_name,[self::getWrapper(),'mo_azos_success_notice']);
    }

    public function mo_azos_success_notice(){
        $class = "updated";
        $message = self::mo_azos_get_option(pluginConstants::notice_message);
        echo "<div style='margin:0;width:97%' class='" . esc_attr($class) . "'> <p>" . esc_attr($message) . "</p></div>";
    }

    public function mo_azos_error_notice(){
        $class = "error";
        $message = self::mo_azos_get_option(pluginConstants::notice_message);
        echo "<div class='" . esc_attr($class) . "'> <p>" . esc_attr($message) . "</p></div>";
    }

    /**
     * @param string $data - the key=value pairs separated with &
     * @return string
     */
    public static function mo_azos_encrypt_data($data, $key) {
        $key    = openssl_digest($key, 'sha256');
        $method = 'aes-128-ecb';
        $strCrypt = openssl_encrypt ($data, $method, $key,OPENSSL_RAW_DATA||OPENSSL_ZERO_PADDING);
        return base64_encode($strCrypt);
    }


    /**
     * @param string $data - crypt response from Sagepay
     * @return string
     */
    public static function mo_azos_decrypt_data($data, $key) {
        $strIn = base64_decode($data);
        $key    = openssl_digest($key, 'sha256');
        $method = 'AES-128-ECB';
        $ivSize = openssl_cipher_iv_length($method);
        $iv     = substr($strIn,0,$ivSize);
        $data   = substr($strIn,$ivSize);
        $clear  = openssl_decrypt ($data, $method, $key, OPENSSL_RAW_DATA||OPENSSL_ZERO_PADDING, $iv);

        return $clear;
    }

    public static function mo_azos_array_flatten_attributes($details){
        $arr = [];
        foreach ($details as $key => $value){
            if(empty($value)){continue;}
            if(!is_array($value)){
                $arr[$key] = sanitize_text_field($value);
            }else{
                wpWrapper::mo_azos_flatten_lvl_2($key,$value,$arr);
            }
        }
        return $arr;
    }

    public static function mo_azos_flatten_lvl_2($index,$arr,&$haystack){
        foreach ($arr as $key => $value) {
            if(empty($value)){continue;}
            if(!is_array($value)){
                if(!strpos(strtolower($index),'error'))
                    $haystack[$index."|".$key] = $value;
            }else{
                wpWrapper::mo_azos_flatten_lvl_2($index."|".$key,$value,$haystack);
            }
        }
    }

}