<?php

if (!defined( 'ABSPATH' )) exit;

class api_webservices_hami_user_wp2app {

	public function __construct(){

		//hami end reg_user

		add_action( 'init', array( $this , 'webservice_hami_register_hami' ));

		add_filter( 'query_vars', array( $this , 'wp_hami_hami_register_query_vars' ));

		add_action( 'parse_request', array( $this , 'wp_hami_hami_register_parse_request' ));

		//end hami reg_user

		//hami end hami_forget

		add_action( 'init', array( $this , 'webservice_hami_forget_hami' ));

		add_filter( 'query_vars', array( $this , 'wp_hami_hami_forget_query_vars' ));

		add_action( 'parse_request', array( $this , 'wp_hami_hami_forget_parse_request' ));

		//end hami hami_forget

		//begin hami login

		add_action( 'init', array( $this , 'webservice_hami_login_hami' ));

		add_filter( 'query_vars', array( $this , 'wp_hami_hami_login_query_vars' ));

		add_action( 'parse_request', array( $this , 'wp_hami_hami_login_parse_request' ));

		//end hami login

		//begin hami user edit

		add_action( 'init', array( $this , 'webservice_hami_useredit_hami' ));

		add_filter( 'query_vars', array( $this , 'wp_hami_hami_useredit_query_vars' ));

		add_action( 'parse_request', array( $this , 'wp_hami_hami_useredit_parse_request' ));

		//end hami user edit

		//begin hami user change pass

		add_action( 'init', array( $this , 'webservice_hami_changepass_hami' ));

		add_filter( 'query_vars', array( $this , 'wp_hami_hami_changepass_query_vars' ));

		add_action( 'parse_request', array( $this , 'wp_hami_hami_changepass_parse_request' ));

		//end hami user change pass

	}//end consttructor

	//---------------begin WEBSERVICE for APPLICATION------------------------------------

	//---------begin WEBSERVICE for REGISTER ORDER----------------

//localhost:8080/newwordpress/?reg_user&in={"username":"gheysar","pass":"123456","email":"gheysar1365@gmail.com","hami_name":"hamid gheysary","hami_tell":"0915280034","hami_mobile":"09157599303","hami_address":"mashhad - tolab","hami_postcode":"09145748126"}

	function hami_register_webservice(){

		header('Content-Type: application/json; charset=utf-8');

		ob_start();

		if(!empty($_GET["in"])){

			$in = $_GET['in'];

			$slashless = stripcslashes($in);

			$url_json = urldecode($slashless);

			$json = (array)  json_decode($url_json);

			$user = $json["username"];

			$pass = $json["password"];

			$email = $json["email"];

			$name = $json["hami_name"];

			$tell = $json["hami_tell"];

			$mobile = $json["hami_mobile"];

			$address = $json["hami_address"];

			$postcode = $json["hami_postcode"];

			$user_id = username_exists( $user );



			if ( ! $user_id && false == email_exists( $email ) ) {

				//$random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );

				$user_id = wp_create_user( $user, $pass, $email );

				if($user_id){

					add_user_meta($user_id, 'hami_name', $name);

					add_user_meta($user_id, 'hami_tell', $tell);

					add_user_meta($user_id, 'hami_mobile', $mobile);

					add_user_meta($user_id, 'hami_address', $address);

					add_user_meta($user_id, 'hami_postcode', $postcode);

					ob_clean();

					echo $user;

				}

			} else {

				ob_clean();

				echo "0";

			}

		}else{

			return 0;

		}

	}//end webservice apost

	function webservice_hami_register_hami(){

		add_rewrite_rule( 'my-api.php$', 'index.php?hami_register', 'top' );

	}

	function wp_hami_hami_register_query_vars( $query_vars ){

		$query_vars[] = 'hami_register';

		return $query_vars;

	}

	function wp_hami_hami_register_parse_request( &$wp ){

		if ( array_key_exists( 'hami_register', $wp->query_vars ) ) {

			$this->hami_register_webservice();

			exit();

		}

		return;

	}

	//---------end WEBSERVICE for REG USER--------------------------

	//---------begin WEBSERVICE for HAMI FORGET----------------



	function hami_forget_webservice() {

		ob_start();

		if ( ! empty( $_GET["in"] ) ) {

			$in = $_GET['in'];

			$slashless = stripcslashes( $in );

			$url_json = urldecode( $slashless );

			$json = (array) json_decode( $url_json );

			$user = $json['user_name'];
			$x    = $this->retrieve_password( $user );
			ob_clean();
			if ( isset($x->errors)) {
				echo -1;
			} else {
				echo 1;
			}

			return;

		}//end webservice apost
	}

	function retrieve_password($user_login) {
		$errors = new WP_Error();

		if ( strpos( $user_login, '@' ) ) {
			$user_data = get_user_by( 'email', trim( wp_unslash( $user_login ) ) );
			if ( empty( $user_data ) )
				$errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.'));
		} else {
			$login = trim($user_login);
			$user_data = get_user_by('login', $login);
		}

		/**
		 * Fires before errors are returned from a password reset request.
		 *
		 * @since 2.1.0
		 * @since 4.4.0 Added the `$errors` parameter.
		 *
		 * @param WP_Error $errors A WP_Error object containing any errors generated
		 *                         by using invalid credentials.
		 */
		do_action( 'lostpassword_post', $errors );

		if ( $errors->get_error_code() )
			return $errors;

		if ( !$user_data ) {
			$errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or email.'));
			return $errors;
		}

		// Redefining user_login ensures we return the right case in the email.
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
		$key = get_password_reset_key( $user_data );

		if ( is_wp_error( $key ) ) {
			return $key;
		}

		$message = __('Someone has requested a password reset for the following account:') . "\r\n\r\n";
		$message .= network_home_url( '/' ) . "\r\n\r\n";
		$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
		$message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
		$message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
		$message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

		if ( is_multisite() ) {
			$blogname = get_network()->site_name;
		} else {
			/*
			 * The blogname option is escaped with esc_html on the way into the database
			 * in sanitize_option we want to reverse this for the plain text arena of emails.
			 */
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
		}

		/* translators: Password reset email subject. 1: Site name */
		$title = sprintf( __('[%s] Password Reset'), $blogname );

		/**
		 * Filters the subject of the password reset email.
		 *
		 * @since 2.8.0
		 * @since 4.4.0 Added the `$user_login` and `$user_data` parameters.
		 *
		 * @param string  $title      Default email title.
		 * @param string  $user_login The username for the user.
		 * @param WP_User $user_data  WP_User object.
		 */
		$title = apply_filters( 'retrieve_password_title', $title, $user_login, $user_data );

		/**
		 * Filters the message body of the password reset mail.
		 *
		 * If the filtered message is empty, the password reset email will not be sent.
		 *
		 * @since 2.8.0
		 * @since 4.1.0 Added `$user_login` and `$user_data` parameters.
		 *
		 * @param string  $message    Default mail message.
		 * @param string  $key        The activation key.
		 * @param string  $user_login The username for the user.
		 * @param WP_User $user_data  WP_User object.
		 */
		$message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );

		if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) )
			wp_die( __('The email could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function.') );

		return true;
	}

	function webservice_hami_forget_hami(){

		add_rewrite_rule( 'my-api.php$', 'index.php?hami_forget', 'top' );

	}

	function wp_hami_hami_forget_query_vars( $query_vars ){

		$query_vars[] = 'hami_forget';

		return $query_vars;

	}

	function wp_hami_hami_forget_parse_request( &$wp ){

		if ( array_key_exists( 'hami_forget', $wp->query_vars ) ) {

			$this->hami_forget_webservice();

			exit();

		}

		return;

	}

//  ***********************function for forget password**********************



	//---------end WEBSERVICE for HAMI FORGET--------------------------

	//---------begin WEBSERVICE for login-----------------------

	function hami_login_webservice(){

		ob_start();

		if(!empty($_GET["in"])){

			$in = $_GET["in"];

			$slashless = stripcslashes($in);

			$url_json = urldecode($slashless);

			$json = (array)  json_decode($url_json);

			$user =  $json["user_name"];

			$pass =  $json["password"];



			$flag = 0;

			$hami_check = get_user_by( 'login', $user );



			if(username_exists( $user ) == false){

				ob_clean();

				echo $flag = -2;

			}elseif ( $hami_check && !wp_check_password( $pass, $hami_check->data->user_pass, $hami_check->ID)){

				ob_clean();

				echo $flag = -1;

			}

			if($flag == 0){

				if($user != "" && $pass != ""){

					$ok = wp_authenticate ( $user, $pass );



					if($ok->user_login == $user){

						$options = array(

							'debug'           => true,

							'return_as_array' => false,

							'validate_url'    => false,

							'timeout'         => 30,

							'ssl_verify'      => false,

						);

						$json = $this->get_customer($hami_check->ID);

						ob_clean();

						echo json_encode($json);



					}else{

						ob_clean();

						echo 0;

					}

				}//end

			}

		}else{

			return 0;

		}

	}//end webservice hami login

	function webservice_hami_login_hami(){

		add_rewrite_rule( 'my-api.php$', 'index.php?hami_login', 'top' );

	}

	function wp_hami_hami_login_query_vars( $query_vars ){

		$query_vars[] = 'hami_login';

		return $query_vars;

	}

	function wp_hami_hami_login_parse_request( &$wp ){

		if ( array_key_exists( 'hami_login', $wp->query_vars ) ){

			$this->hami_login_webservice();

			exit();

		}

		return;

	}

	//---------end WEBSERVICE for login--------------------------

	//---------begin WEBSERVICE for user edit-----------------------

	function hami_useredit_webservice(){

		header('Content-Type: application/json; charset=utf-8');

		ob_start();

		if(!empty($_GET["in"])){

			$in = $_GET['in'];

			$slashless = stripcslashes($in);

			$url_json = urldecode($slashless);

			$json = (array)  json_decode($url_json);

			$user = $json["username"];

			$pass = $json["password"];

			$email = $json["email"];

			$name = $json["hami_name"];

			$tell = $json["hami_tell"];

			$mobile = $json["hami_mobile"];

			$address = $json["hami_address"];

			$postcode = $json["hami_postcode"];

			$flag = 0;

			$hami_check = get_user_by( 'login', $user );

			if(username_exists( $user ) == false){

				$flag = -1;

			}elseif ( $hami_check && !wp_check_password( $pass, $hami_check->data->user_pass, $hami_check->ID)){

				$flag = -1;

			}

			if($flag != -1){

				$user_id = $hami_check->ID;

				update_user_meta($user_id,'hami_name',$name);

				update_user_meta($user_id,'hami_tell',$tell);

				update_user_meta($user_id,'hami_mobile',$mobile);

				update_user_meta($user_id,'hami_address',$address);

				update_user_meta($user_id,'hami_postcode',$postcode);

				ob_clean();

				echo 1;

			}else{

				ob_clean();

				echo -1;

			}





		}else{

			return 0;

		}

	}//end webservice hami login

	function webservice_hami_useredit_hami(){

		add_rewrite_rule( 'my-api.php$', 'index.php?hami_useredit', 'top' );

	}

	function wp_hami_hami_useredit_query_vars( $query_vars ){

		$query_vars[] = 'hami_useredit';

		return $query_vars;

	}

	function wp_hami_hami_useredit_parse_request( &$wp ){

		if ( array_key_exists( 'hami_useredit', $wp->query_vars ) ){

			$this->hami_useredit_webservice();

			exit();

		}

		return;

	}

	//---------end WEBSERVICE for user edit--------------------------

	//---------begin WEBSERVICE for user edit-----------------------

	function hami_changepass_webservice(){

		ob_start();

		if(!empty($_GET["in"])){

			$in = $_GET['in'];

			$slashless = stripcslashes($in);

			$url_json = urldecode($slashless);

			$json = (array)  json_decode($url_json);

			$user = $json["user_name"];

			$pass = $json["old_pass"];

			$new_pass = $json["new_pass"];



			$flag = 0;

			$hami_check = get_user_by( 'login', $user );
			if(!$hami_check){
				$hami_check = get_user_by( 'email', $user );
			}

			if(username_exists( $user ) == false && email_exists( $user ) == false){

				ob_clean();

				echo $flag = -1;

			}elseif ( $hami_check && !wp_check_password( $pass, $hami_check->data->user_pass, $hami_check->ID)){

				ob_clean();

				echo $flag = -1;

			}

			if ($flag != -1) {



				$update_user = wp_update_user( array (

						'ID' => $hami_check->ID,

						'user_pass' => $new_pass

					)

				);

				if ($update_user) {

					ob_clean();

					echo 1;

				}

			}



		}else{

			return 0;

		}

	}//end webservice hami login

	function webservice_hami_changepass_hami(){

		add_rewrite_rule( 'my-api.php$', 'index.php?hami_changepass', 'top' );

	}

	function wp_hami_hami_changepass_query_vars( $query_vars ){

		$query_vars[] = 'hami_changepass';

		return $query_vars;

	}

	function wp_hami_hami_changepass_parse_request( &$wp ){

		if ( array_key_exists( 'hami_changepass', $wp->query_vars ) ){

			$this->hami_changepass_webservice();

			exit();

		}

		return;

	}

	//---------end WEBSERVICE for user change pass--------------------------

	public function get_customer( $id, $fields = null ) {

		ob_start();

		global $wpdb;

		//$id = $this->validate_request( $id, 'customer', 'read' );

		if ( is_wp_error( $id ) ) {

			return $id;

		}

		$customer = new WP_User( $id );

		// Get info about user's last order

		$last_order = $wpdb->get_row( "SELECT id, post_date_gmt

						FROM $wpdb->posts AS posts

						LEFT JOIN {$wpdb->postmeta} AS meta on posts.ID = meta.post_id

						WHERE meta.meta_key = '_customer_user'

						AND   meta.meta_value = {$customer->ID}

						AND   posts.post_type = 'shop_order'

						AND   posts.post_status IN ( '" . implode( "','", array_keys( wc_get_order_statuses() ) ) . "' )

						ORDER BY posts.ID DESC

					" );

		$roles = array_values( $customer->roles );

		$customer_data = array(

			'id'               => $customer->ID,

			'created_at'       => $this->format_datetime( $customer->user_registered ),

			'last_update'      => $this->format_datetime( get_user_meta( $customer->ID, 'last_update', true ) ),

			'email'            => $customer->user_email,

			'first_name'       => $customer->first_name,

			'last_name'        => $customer->last_name,

			'username'         => $customer->user_login,

			'role'             => $roles[0],

			'last_order_id'    => is_object( $last_order ) ? $last_order->id : null,

			'last_order_date'  => is_object( $last_order ) ? $this->format_datetime( $last_order->post_date_gmt ) : null,

			'orders_count'     => wc_get_customer_order_count( $customer->ID ),

			'total_spent'      => wc_format_decimal( wc_get_customer_total_spent( $customer->ID ), 2 ),

			'avatar_url'       => $this->get_avatar_url( $customer->customer_email ),

			'billing_address'  => array(

				'first_name' => $customer->billing_first_name,

				'last_name'  => $customer->billing_last_name,

				'company'    => $customer->billing_company,

				'address_1'  => $customer->billing_address_1,

				'address_2'  => $customer->billing_address_2,

				'city'       => $customer->billing_city,

				'state'      => $customer->billing_state,

				'postcode'   => $customer->billing_postcode,

				'country'    => $customer->billing_country,

				'email'      => $customer->billing_email,

				'phone'      => $customer->billing_phone,

			),

			'shipping_address' => array(

				'first_name' => $customer->shipping_first_name,

				'last_name'  => $customer->shipping_last_name,

				'company'    => $customer->shipping_company,

				'address_1'  => $customer->shipping_address_1,

				'address_2'  => $customer->shipping_address_2,

				'city'       => $customer->shipping_city,

				'state'      => $customer->shipping_state,

				'postcode'   => $customer->shipping_postcode,

				'country'    => $customer->shipping_country,

			),

		);

		return array( 'customer' => apply_filters( 'woocommerce_api_customer_response', $customer_data, $customer, $fields, ""/*$this->server*/ ) );

	}

	private function get_avatar_url( $email ) {

		$avatar_html = get_avatar( $email );

		// Get the URL of the avatar from the provided HTML

		preg_match( '/src=["|\'](.+)[\&|"|\']/U', $avatar_html, $matches );

		if ( isset( $matches[1] ) && ! empty( $matches[1] ) ) {

			return esc_url_raw( $matches[1] );

		}

		return null;

	}

	public function format_datetime( $timestamp, $convert_to_utc = false ) {

		if ( $convert_to_utc ) {

			$timezone = new DateTimeZone( wc_timezone_string() );

		} else {

			$timezone = new DateTimeZone( 'UTC' );

		}

		try {

			if ( is_numeric( $timestamp ) ) {

				$date = new DateTime( "@{$timestamp}" );

			} else {

				$date = new DateTime( $timestamp, $timezone );

			}

			// convert to UTC by adjusting the time based on the offset of the site's timezone

			if ( $convert_to_utc ) {

				$date->modify( -1 * $date->getOffset() . ' seconds' );

			}

		} catch ( Exception $e ) {

			$date = new DateTime( '@0' );

		}

		return $date->format( 'Y-m-d\TH:i:s\Z' );

	}

}// end class