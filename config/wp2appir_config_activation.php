<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class wp2appir_config_activation


{


	


	function __construct()


	{


		$this->config_activation_menu();


	}





	function config_activation_menu(){


		add_menu_page( __( 'فعال سازی WP2APP', 'wp2appir' ),__( 'فعال سازی WP2APP', 'wp2appir' ), 'manage_options', 'wp2appir/pages/page_view_activate.php','',


					plugins_url(plugin_basename(dirname(__FILE__))).'/../assets/img/mobile_catalog.png' );


	}





}