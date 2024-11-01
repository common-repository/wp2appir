<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class wp2appir_config_data
{
	public function __construct() {
		$version = get_option("WP2APPIR_VERSION");
		if($version != WP2APPIR_VERSION){
			$this->insert_into_hami_set();
			$this->insert_into_options();
			//$this->insert_into_appost();
		}
	}

	function insert_into_hami_set(){

		global $wpdb;
		$table_name = $wpdb->prefix . 'hami_set';

		$res = $wpdb->get_results("select * from $table_name where name = 'BOL_SHOWLAND'");
		if($res){
			return false;
		}
		else{

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
							( name, value , description ) 
							VALUES ( %s, %s, %s )", 'TXT_ACTT','عنوان برنامه','عنوان اکشن بار') );
			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'CLR_MBG','#d4d4d4','رنگ پیش زمینه اصلی') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'CLR_ACTBG','#0061b0','رنگ پیش زمینه اکشن بار') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'CLR_ACTTX','#FFFFFF','رنگ متن اکشن بار') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'CLR_LISTHBG','#820002','رنگ پیش زمینه هدر') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'CLR_LISTHTX','#f7f7f7','رنگ متن هدر') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'CLR_LISTSBG','#ffffff','رنگ پیش زمینه خلاصه مطلب') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'CLR_LISTFBG','#F0F0F0','رنگ پیش زمینه فوتر') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'CLR_LISTFTX','#404040','رنگ متن فوتر') );


			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'CLR_LISTSTX','#000000','رنگ متن خلاصه مطلب') );

			//--------------new setting--------------------------------------------------------------
			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'BOL_SHOWLAND','YES','نمایش صفحه لندینگ') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'BOL_SHOWSPL','YES','نمایش اسپلش اسکرین') );


			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'BOL_SETCOM','YES','قابلیت کامنت گذاری') );
			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'BOL_SHOWCOM','YES','نمایش کامنت') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'BOL_STA','YES','جمع آوری اطلاعات آماری') );
			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'NUM_CALTYPE','1','نحوه نمایش تاریخ') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'TXT_LASTANDRVER','1','آخرین نسخه') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'TXT_LASTANDRLINK','www.hami-r.com','لینک آخرین نسخه آندروید') );
			//new base setting-------------------------------------------------------------------------------------
//			$url_image = plugins_url(plugin_basename(dirname(__FILE__))).'/../assets/img/defult_splash.jpg';
//			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name
//						   ( name, value , description )
//						   VALUES ( %s, %s, %s )", 'TXT_SPLASHPL',$url_image,'لینک تصویر اسپلش') );

//			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name
//						   ( name, value , description )
//						   VALUES ( %s, %s, %s )", 'NUM_SPLASHT','3','مدت زمان اسپلش') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'NUM_MNRTYPE','1','موضوع منوی راست') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'TXT_MNRTI','منو','عنوان منوی راست') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'TXT_MNRIC','fa-align-right__f038','آیکون منوی راست') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'NUM_MNLTYPE','3','موضوع منوی چپ') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'TXT_MNLTI','دسته بندی','عنوان منوی چپ') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'TXT_MNLIC','fa-th-large__f009','آیکون منوی چپ') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'NUM_LVT','1','نحوه نمایش لیست') );
			//------------------------------------------------------------------------------
			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'NUM_SRCHP','1','مکان نمایش آیکون منوی شناور') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'NUM_SRCHIC','fa-info-circle__f05a','آیکون منوی شناور') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'CLR_SRCHIC','#FFFFFF','رنگ آیکون منوی شناور') );

			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'NUM_FMAIN','2','فونت قالب برنامه') );
			//-----------------update 1.2 plugin-------------------------------------------------
			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'NUM_MNFTYPE','2','موضوع منوی شناور') );
			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'TXT_MNFTI','منوی شناور','عنوان منوی شناور') );
			//-----------------------update plugin 1.3--------------------------------------------
			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'BOL_ADADSHOWMAIN','NO','نمایش تبلیغات عدد در صفحه اصلی') );
			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
						   ( name, value , description ) 
						   VALUES ( %s, %s, %s )", 'BOL_ADADSHOWPOST','NO','نمایش تبلیغات عدد در صفحه نمایش مطلب') );

		}//end else if

	}

	function insert_into_options(){

		$hrt_lastmf_appsetting = get_option('hrt_lastmf_appsetting');
		if($hrt_lastmf_appsetting)
		{
			return false;
		}
		else{

			$time = current_time( 'mysql' );
			// insert update time for setting table
			add_option('hrt_lastmf_appsetting' , $time);
			// insert update time for appost table
			add_option('hrt_lastmf_appost',$time);
			// insert update time for cat table
			add_option('hrt_lastmf_cat',$time);
			//--------------------------------------------------------------
			add_option('hrt_telegram_token','');
			add_option('hrt_telegram_chatid','');
			add_option('hrt_telegram_sign','');
			add_option('wp2app_telg_default','0');
			add_option('wp2app_notif_default','0');
			add_option('wp2app_cats','');
			add_option('WP2APPIR_VERSION','');
			//---------------------------------------------------
			add_option('hami_site_token','');
			add_option('wp2app_post_types','');
			add_option("wp2app_custom_fields","");
		}//end if
	}

	function insert_into_appost(){
		global $wpdb;
		$wpdb->show_errors();
		$table_name = $wpdb->prefix . 'hami_appost';

		$res = $wpdb->get_results("select * from $table_name where Metadata = 'http://telegram.me/wp2app'");
		if($res)
		{
			return false;
		}
		else{
			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
			   ( post_id, type, title, Metadata, icon, order_post, Menu ) 
			   VALUES ( %d, %d, %s, %s, %s, %d, %d)",
				-1,3,"کانال تلگرام ما","http://telegram.me/wp2app","",1,1)
			);
			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
			   ( post_id, type, title, Metadata, icon, order_post, Menu ) 
			   VALUES ( %d, %d, %s, %s, %s, %d, %d)",
				-1,3,"پشتیبانی","http://wp2app.ir/پشتیبانی/","",2,1)
			);
			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
			   ( post_id, type, title, Metadata, icon, order_post, Menu ) 
			   VALUES ( %d, %d, %s, %s, %s, %d, %d)",
				-1,3,"سفارشی سازی این منو","http://wp2app.ir/category/learn_wp2app/menu_settings/","",3,1)
			);
			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
			   ( post_id, type, title, Metadata, icon, order_post, Menu ) 
			   VALUES ( %d, %d, %s, %s, %s, %d, %d)",
				-1,7,"ارسال برای دیگران","","",4,2)
			);
			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
			   ( post_id, type, title, Metadata, icon, order_post, Menu ) 
			   VALUES ( %d, %d, %s, %s, %s, %d, %d)",
				-1,6,"جست و جو","","",5,2)
			);
			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
			   ( post_id, type, title, Metadata, icon, order_post, Menu ) 
			   VALUES ( %d, %d, %s, %s, %s, %d, %d)",
				-1,8,"خروج","","",6,2)
			);
			$wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
			   ( post_id, type, title, Metadata, icon, order_post, Menu ) 
			   VALUES ( %d, %d, %s, %s, %s, %d, %d)",
				-1,3,"سفارشی سازی این منو","http://wp2app.ir/category/learn_wp2app/menu_settings/","",7,2)
			);
		}
	}

}