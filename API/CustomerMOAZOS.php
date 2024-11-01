<?php
/** miniOrange User Sync for Azure Office365 enables user to sync objects from Azure AD / Azure B2C / Office 365 to wordpress.
 Copyright (C) 2015  miniOrange

 This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program.  If not, see <http://www.gnu.org/licenses/>
 * @package 		miniOrange User Sync for Azure AD Azure B2C Office365
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

namespace MoAzureObjectSync\API;

use MoAzureObjectSync\Wrappers\pluginConstants;
use MoAzureObjectSync\Wrappers\wpWrapper;

/**
 * This library is miniOrange Authentication Service.
 *
 * Contains Request Calls to Customer service.
 */

class CustomerMOAZOS {
	public $email;
	public $phone;

	/*
	 * * Initial values are hardcoded to support the miniOrange framework to generate OTP for email.
	 * * We need the default value for creating the first time,
	 * * As we don't have the Default keys available before registering the user to our server.
	 * * This default values are only required for sending an One Time Passcode at the user provided email address.
	 */
    private $defaultCustomerKey = "16555";
    private $defaultApiKey = "fFd2XcvTGDemZvbw1bcUesNJWEqKbbUq";

	function mo_azos_create_customer() {
		$url = pluginConstants::HOSTNAME . '/moas/rest/customer/add';

		$current_user = wp_get_current_user();
		$this->email = get_option ( 'mo_saml_admin_email' );
		$password = get_option ( 'mo_saml_admin_password' );

		$fields = array (
				'areaOfInterest' => 'WP miniOrange SAML 2.0 SSO Plugin',
				'email' => $this->email,
				'password' => $password
		);
		$field_string = json_encode ( $fields );

		$headers = array("Content-Type"=>"application/json","charset"=>"UTF-8","Authorization"=>"Basic");

		$args = array(
			'method' => 'POST',
			'body' => $field_string,
			'timeout' => '5',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => $headers
		);
		$response = wp_remote_post(esc_url_raw($url),$args);
		return $response['body'];

	}

	function mo_azos_get_customer_key() {
		$url = pluginConstants::HOSTNAME . "/moas/rest/customer/key";

		$email = get_option ( "mo_saml_admin_email" );

		$password = get_option ( "mo_saml_admin_password" );

		$fields = array (
				'email' => $email,
				'password' => $password
		);
		$field_string = json_encode ( $fields );

		$headers = array("Content-Type"=>"application/json","charset"=>"UTF-8","Authorization"=>"Basic");
		$args = array(
			'method' => 'POST',
			'body' => $field_string,
			'timeout' => '5',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => $headers
		);
		$response = wp_remote_post(esc_url_raw($url),$args);
		return $response['body'];

	}
	function mo_azos_check_customer() {
		$url = pluginConstants::HOSTNAME . "/moas/rest/customer/check-if-exists";

		$email = get_option ( "mo_saml_admin_email" );

		$fields = array (
				'email' => $email
		);
		$field_string = json_encode ( $fields );

		$headers = array("Content-Type"=>"application/json","charset"=>"UTF-8","Authorization"=>"Basic");
		$args = array(
			'method' => 'POST',
			'body' => $field_string,
			'timeout' => '5',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => $headers
		);
		$response = wp_remote_post(esc_url_raw($url),$args);
		return $response['body'];

	}

    function mo_azos_submit_contact_us($email, $phone, $query) {
        $url = pluginConstants::HOSTNAME. '/moas/rest/customer/contact-us';
        $current_user = wp_get_current_user();

        $fields = array (
            'firstName' => $current_user->user_firstname,
            'lastName' => $current_user->user_lastname,
            'company' => $_SERVER ['SERVER_NAME'],
            'email' => $email,
            'ccEmail'=>'samlsupport@xecurify.com',
            'phone' => $phone,
            'query' => $query
        );

        $field_string = json_encode ( $fields );

        $headers = array("Content-Type"=>"application/json","charset"=>"UTF-8","Authorization"=>"Basic");
        $args = array(
            'method' => 'POST',
            'body' => $field_string,
            'timeout' => '6',
            'redirection' => '6',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => $headers
        );
        $response = wp_remote_post(esc_url_raw($url),$args);

		if(!is_wp_error($response)){
			return $response['body'];
		} else {
			wpWrapper::mo_azos__show_error_notice('Unable to connect to the Internet. Please try again.');
			return null;
        }
        

    }

	function mo_azos_send_email_alert($email,$phone,$message, $demo_request=false){

		$url = pluginConstants::HOSTNAME . '/moas/api/notify/send';

		$customerKey = $this->defaultCustomerKey;
		$apiKey =  $this->defaultApiKey;

		$currentTimeInMillis = $this->mo_azos_get_timestamp();
		$currentTimeInMillis = number_format ( $currentTimeInMillis, 0, '', '' );
		$stringToHash 		= $customerKey .  $currentTimeInMillis . $apiKey;
		$hashValue 			= hash("sha512", $stringToHash);
		$fromEmail			= 'no-reply@xecurify.com';
		$subject            = "Feedback: WordPress AzureAD User Sync";
		if($demo_request)
			$subject = "DEMO REQUEST: WordPress AzureAD User Sync";

		global $user;
		$user         = wp_get_current_user();


		$query        = '[WordPress AzureAD User Sync]: ' . $message;


		$content='<div >Hello, <br><br>First Name :'.$user->user_firstname.'<br><br>Last  Name :'.$user->user_lastname.'   <br><br>Company :<a href="'.$_SERVER['SERVER_NAME'].'" target="_blank" >'.$_SERVER['SERVER_NAME'].'</a><br><br>Phone Number :'.$phone.'<br><br>Email :<a href="mailto:'.$email.'" target="_blank">'.$email.'</a><br><br>Query :'.$query.'</div>';


		$fields = array(
			'customerKey'	=> $customerKey,
			'sendEmail' 	=> true,
			'email' 		=> array(
								'customerKey' 	=> $customerKey,
								'fromEmail' 	=> $fromEmail,
								'bccEmail' 		=> $fromEmail,
								'fromName' 		=> 'Xecurify',
								'toEmail' 		=> 'info@xecurify.com',
								'toName' 		=> 'samlsupport@xecurify.com',
								'bccEmail'		=> 'samlsupport@xecurify.com',
								'subject' 		=> $subject,
								'content' 		=> $content
								),
		);
		$field_string = json_encode($fields);

		$headers = array(
			"Content-Type" => "application/json",
			"Customer-Key" => $customerKey,
			"Timestamp" => $currentTimeInMillis,
			"Authorization" => $hashValue
		);
		$args = array(
			'method' => 'POST',
			'body' => $field_string,
			'timeout' => '5',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => $headers
		);
		$response = wp_remote_post(esc_url_raw($url),$args);
		
		if(!is_wp_error($response)){
			return $response['body'];
		} else {
			wpWrapper::mo_azos__show_error_notice('Unable to connect to the Internet. Please try again.');
			return null;
        }

	}
	function mo_saml_forgot_password($email) {
		$url = pluginConstants::HOSTNAME . '/moas/rest/customer/password-reset';

		/* The customer Key provided to you */
		$customerKey = get_option ( 'mo_saml_admin_customer_key' );

		/* The customer API Key provided to you */
		$apiKey = get_option ( 'mo_saml_admin_api_key' );

		/* Current time in milliseconds since midnight, January 1, 1970 UTC. */
		$currentTimeInMillis = round ( microtime ( true ) * 1000 );

		/* Creating the Hash using SHA-512 algorithm */
		$stringToHash = $customerKey . number_format ( $currentTimeInMillis, 0, '', '' ) . $apiKey;
		$hashValue = hash ( "sha512", $stringToHash );

		$fields = '';

		// *check for otp over sms/email
		$fields = array (
				'email' => $email
		);

		$field_string = json_encode ( $fields );
		$headers = array(
			"Content-Type" => "application/json",
			"Customer-Key" => $customerKey,
			"Timestamp" => $currentTimeInMillis,
			"Authorization" => $hashValue
		);
		$args = array(
			'method' => 'POST',
			'body' => $field_string,
			'timeout' => '5',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => $headers
		);
		$response = wp_remote_post(esc_url_raw($url),$args);
		return $response['body'];

	}
	function mo_azos_get_timestamp() {
		$url = pluginConstants::HOSTNAME . '/moas/rest/mobile/get-timestamp';
		$response = wp_remote_post(esc_url_raw($url));
		return $response['body'];

	}






}
?>