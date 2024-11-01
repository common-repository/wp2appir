<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class wp2appir_config_tables
{
 
    public function __construct() {
		$this->config_tables_setting();
		$this->config_tables_appost();
		$this->config_tables_appstatic();
		$this->create_tbl_wp2app_mainpage();
		$this->create_tbl_wp2app_slider();
		$this->config_tables_commission();
		$this->config_tables_checkout();
    }



    function config_tables_commission(){
        $version = get_option("WP2APPIR_VERSION");
        if($version != WP2APPIR_VERSION){
            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();
            $table_name = $wpdb->prefix . 'wp2app_commission';
            $sql = "CREATE TABLE $table_name (
                id int(11) NOT NULL AUTO_INCREMENT,
                PRIMARY KEY (id),
				marketer_id int(11) NOT NULL,
				user_id int(11) NOT NULL,
				f_time bigint(20) NOT NULL,
				payed int(11) NOT NULL DEFAULT 0
			) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
    }

    function config_tables_checkout(){
        $version = get_option("WP2APPIR_VERSION");
        if($version != WP2APPIR_VERSION){
            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();
            $table_name = $wpdb->prefix . 'wp2app_checkout';
            $sql = "CREATE TABLE $table_name (
                id int(11) NOT NULL AUTO_INCREMENT,
                PRIMARY KEY (id),
                user_id int(11) NOT NULL,
				amount TEXT NOT NULL,
				user_count int(11) NOT NULL,
				f_time bigint(20) NOT NULL,
				f_status int(11) NOT NULL DEFAULT 0,
				marketer_note TEXT NULL,
				admin_note TEXT NULL 
				
			) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
    }

	function config_tables_setting(){
		$version = get_option("WP2APPIR_VERSION");
		if($version != WP2APPIR_VERSION){
			global $wpdb;
			$charset_collate = $wpdb->get_charset_collate();
			$table_name = $wpdb->prefix . 'hami_set';
			$sql = "CREATE TABLE $table_name (
				name TEXT NOT NULL,
				value TEXT NOT NULL,
				description TEXT NOT NULL,
				time bigint(20) NOT NULL DEFAULT 0
			) $charset_collate;";
			
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
	}
	
	
	function config_tables_appost(){
		$version = get_option("WP2APPIR_VERSION");
		if($version != WP2APPIR_VERSION){
				global $wpdb;
				$charset_collate = $wpdb->get_charset_collate();
				$table_name = $wpdb->prefix . 'hami_appost';
				$sql = "CREATE TABLE $table_name (
				id int(11) NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (id),
				post_id int(11) NOT NULL,
				type int(11) NOT NULL,	
				title TEXT NOT NULL,
				Metadata TEXT NOT NULL,	
				icon TEXT NOT NULL,	
				order_post int(11),
				Menu int(11),
				req_login int(11)
			) $charset_collate;";
				
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $sql );
		}
	}
	
	
	
	function config_tables_appstatic(){
		$version = get_option("WP2APPIR_VERSION");
		if($version != WP2APPIR_VERSION){
				global $wpdb;
				$charset_collate = $wpdb->get_charset_collate();
				$table_name = $wpdb->prefix . 'hami_appstatic';
				$sql = "CREATE TABLE $table_name (
				apst_id bigint(20) NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (apst_id),
				apst_time varchar(50) NOT NULL,
				apst_ip varchar(50) NOT NULL,
				apst_unifo varchar(150) NOT NULL
			) $charset_collate;";
				
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $sql );
		}
	}
	
	function create_tbl_wp2app_mainpage(){
		$version = get_option("WP2APPIR_VERSION");
		if($version != WP2APPIR_VERSION){
			global $wpdb;
			$charset_collate = $wpdb->get_charset_collate();
			$table_name = $wpdb->prefix . 'hami_mainpage';
			$sql = "CREATE TABLE $table_name (
				mp_id bigint(20) NOT NULL AUTO_INCREMENT,
				PRIMARY key(mp_id),
				mp_title varchar(100) NOT NULL,
				mp_type tinyint(4) NOT NULL ,
				mp_value text NOT NULL ,
				mp_showtype tinyint(4) NOT NULL,
				mp_pic text NOT NULL,
				mp_order bigint(20)
			) $charset_collate;";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
	}
	function create_tbl_wp2app_slider(){
		$version = get_option("WP2APPIR_VERSION");
		if($version != WP2APPIR_VERSION){
			global $wpdb;
			$charset_collate = $wpdb->get_charset_collate();
			$table_name = $wpdb->prefix . 'hami_slider';
			$sql = "CREATE TABLE $table_name (
			sl_id bigint(20) NOT NULL AUTO_INCREMENT,
			PRIMARY KEY (sl_id),
			sl_title varchar(100) NOT NULL ,
			sl_type tinyint(4) NOT NULL,
			sl_value varchar(150) NOT NULL,
			sl_pic TEXT NOT NULL
			) $charset_collate;";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
	}
}