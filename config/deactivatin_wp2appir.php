<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class deactivatin_wp2appir


{


	


	function __construct()


	{


		$this->deactivatin_wp2appir_options();


	}





	function deactivatin_wp2appir_options(){


		delete_option("API_KEY");


		delete_option("EXP_DATE");


		delete_option("PLAN_TYPE");


		delete_option("SITE_CODE");


		delete_option("hami_site_token");


	}








}