<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class wp2appir_config_menu
{
	function __construct()
	{
		$this->config_menu();
	}
	function config_menu(){

		add_menu_page( __( 'wp2app', 'wp2appir' ),__( 'wp2app', 'wp2app' ), 'administrator', 'wp2appir/pages/wp2appir_theme_new.php','',
			plugins_url(plugin_basename(dirname(__FILE__))).'/../assets/img/mobile_catalog.png' );
		add_submenu_page( 'wp2appir/pages/wp2appir_theme_new.php', __( 'تنظیمات پوسته', 'wp2appir' ),__( 'تنظیمات پوسته', 'wp2appir' ), 'administrator', 'wp2appir/pages/wp2appir_theme_new.php');
		add_submenu_page( 'wp2appir/pages/wp2appir_theme_new.php', __( 'تنظیمات اصلی', 'wp2appir' ),__( 'تنظیمات اصلی', 'wp2appir' ), 'administrator', 'wp2appir/pages/hami_manager_primery.php');
		add_submenu_page( 'wp2appir/pages/wp2appir_theme_new.php', __( 'تنظیمات نمایش مطالب', 'wp2appir' ),__( 'تنظیمات نمایش مطالب', 'wp2appir' ), 'administrator', 'wp2appir/pages/hami_manager_post_types.php');
		add_submenu_page( 'wp2appir/pages/wp2appir_theme_new.php', __( 'تنظیمات منو', 'wp2appir' ),__( 'تنظیمات منو', 'wp2appir' ), 'administrator', 'wp2appir/pages/hami_manager_appost.php');
		add_submenu_page( 'wp2appir/pages/wp2appir_theme_new.php', __( 'ارسال نوتیفیکیشن', 'wp2appir' ),__( 'ارسال نوتیفیکیشن', 'wp2appir' ), 'administrator', 'wp2appir/pages/send_notif_hami.php');
		add_submenu_page( 'wp2appir/pages/wp2appir_theme_new.php', __( 'تنظیمات حساب کاربری ', 'wp2appir' ),__( 'تنظیمات حساب کاربری', 'wp2appir' ), 'administrator', 'wp2appir/register/register.php');
		add_submenu_page( 'wp2appir/pages/wp2appir_theme_new.php', __( '  فروش فایل ', 'wp2appir' ),__( '  فروش فایل', 'wp2appir' ), 'administrator', 'wp2appir/sale_meta/sale_meta.php');
		add_submenu_page( 'wp2appir/pages/wp2appir_theme_new.php', __( '   تنظیمات عدد ', 'wp2appir' ),__( ' تنظیمات عدد', 'wp2appir' ), 'administrator', 'wp2appir/pages/adver_addad_hami.php');
		add_submenu_page( 'wp2appir/pages/wp2appir_theme_new.php', __( '  تنظیمات تپسل ', 'wp2appir' ),__( ' تنظیمات تپسل', 'wp2appir' ), 'administrator', 'wp2appir/pages/tapsell.php');
//		add_submenu_page( 'wp2appir/pages/wp2appir_theme_new.php', __( ' تسویه حساب', 'wp2appir' ),__( ' تسویه حساب ', 'wp2appir' ), 'administrator', 'wp2appir/account/tasv.php');
//        add_submenu_page( 'wp2appir/pages/wp2appir_theme_new.php', __( ' بازاریاب ', 'wp2appir' ),__( ' بازاریاب ', 'wp2appir' ), 'administrator', 'wp2appir/account/bazaryab.php');
	}

}