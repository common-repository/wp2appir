<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wp_register_style( 'bootstrap', WP2APPIR_CSS_URL.'bootstrap.css');
wp_enqueue_style('bootstrap');
wp_register_style( 'font-awesome', WP2APPIR_CSS_URL.'font-awesome.css');
wp_enqueue_style('font-awesome');
wp_register_style( 'poste', WP2APPIR_CSS_URL.'poste.css');
wp_enqueue_style('poste');
wp_register_style( 'devices.min', WP2APPIR_CSS_URL.'devices.min.css'  );
wp_enqueue_style('devices.min');
wp_register_style( 'style', WP2APPIR_CSS_URL.'style.css' );
wp_enqueue_style('style');
wp_register_style( 'colpick', WP2APPIR_CSS_URL.'colpick.css');
wp_enqueue_style('colpick');
wp_register_style( 'zistyle', WP2APPIR_CSS_URL.'zistyle.css' );
wp_enqueue_style('zistyle');
wp_register_style( 'jquery.rollbar', WP2APPIR_CSS_URL.'jquery.rollbar.css');
wp_enqueue_style('jquery.rollbar');
wp_register_style( 'style_roll', WP2APPIR_CSS_URL.'style_roll.css');
wp_enqueue_style('style_roll');

//-------------------------------------upload file------------------------------------------------------------------------------------
define ( 'ONETAREK_WPMUT_PLUGIN_URL', plugin_dir_url(__FILE__)); // with forward slash (/).
global $wpdb;
$table_name = $wpdb->prefix . 'hami_set';
$res = $wpdb->get_results("select * from $table_name where name = 'NUM_FMAIN'");
$class="";
foreach($res as $r){
	$class=$r->value;
	if($class==1) $class = "yekan";
	if($class==2) $class = "koodak";
	if($class==3) $class = "tahoma";
	if($class==4) $class = "traffic";
	if($class==5) $class = "nazanin";
}
function onetarek_wpmut_admin_scripts()
{
	if (isset($_GET['page']) && $_GET['page'] == 'wp2appir/pages/hami_manager_setting.php')
	{
		wp_enqueue_media();
		wp_register_script('upload_setting_page.js', WP2APPIR_JS_URL.'upload_setting_page.js', array('jquery'));
		wp_enqueue_script('upload_setting_page.js');
	}
}
onetarek_wpmut_admin_scripts();
function onetarek_wpmut_admin_styles()
{
	if (isset($_GET['page']) /*&& $_GET['page'] == 'oneTarek_wpmut_plugin_page'*/)
	{
		wp_enqueue_style('thickbox');
	}
}
onetarek_wpmut_admin_styles();
//--------------------------------------------------------------------------------------------------------------------------
?>
<div style="width:85%;margin-top:20px;z-index:9999;">
    <div id="picker_check" class="hami_img_mob_set" style="float:right;margin-top:50px;height:500px;">
		<?php
		//require_once('wp2appir_theme_show.php');
		?>
    </div>
    <div class="hami_img_mob" style="float:right;">

        <div class="marvel-device s5 white">
            <div class="top-bar" ></div>
            <div class="sleep" ></div>
            <div class="camera" ></div>
            <div class="sensor"></div>
            <div class="speaker"></div>

            <div class="screen <?php echo $class ;?>" id="theme_1" >

                <div id="set_splash" class="hide" style="position:absolute;width:100%;height:100%;z-index:500;"></div>

                <div id="actionbar_theme1" class="col-md-12" style="padding-top:0px;padding-bottom:0px;padding-right:3px;padding-left:3px;height:30px;margin-bottom:5px;">
                    <div style="padding:0px;margin-top:10px;" class="col-md-1 text-left">
                        <label id="left_icon_theme1" class="fa fa-1x text-left"></label>
                    </div>
                    <div class="col-md-3 text-left" style="padding:0;margin-top:8px;">
                        <label id="title_left_menu_theme1" style="font-size:12px;" class="text-left" ></label>
                    </div>
                    <div class="col-md-4 text-center" style="padding:0px;margin-top:5px;">
                        <p id="title_theme1" style="font-size:11px;font-weight:bold;padding:0px;" class="text-center" ></p>
                    </div>
                    <div class="col-md-3 text-right" style="padding:0;margin-top:8px;">
                        <label id="title_right_menu_theme1" style="font-size:12px;" class="text-right" ></label>
                    </div>
                    <div style="padding:0;margin-top:10px;" class="col-md-1 text-right">
                        <label id="right_icon_theme1" class="fa fa-1x text-right  "></label>
                    </div>
                </div>


                <div id="search1" class="text-right hide" style="position:absolute;z-index:150;bottom:5px;left:5px;">
                    <label  class="search_icon search1 fa fa-1x"></label>
                </div>

                <div id="search2" class="text-left hide" style="position:absolute;z-index:150;bottom:5px;right:5px;">
                    <label class="search_icon search2 fa fa-1x"></label>
                </div>

                <div id="search3" class="text-right hide" style="position:absolute;z-index:150;top:35px;left:5px;">
                    <label class="search_icon search3 fa fa-1x"></label>
                </div>

                <div id="search4" class="text-left hide" style="position:absolute;z-index:150;top:35px;right:5px;">
                    <label class="search_icon search4 fa fa-1x"></label>
                </div>

                <!-- begin create theme 1 -->
				<?php include_once( 'themes/theme1.php') ; ?>
                <!-- end create theme 1 -->

                <!-- begin create theme 2 -->
				<?php include_once( 'themes/theme2.php') ; ?>
                <!-- end create theme 2 -->

                <!-- begin create theme 3 -->
				<?php include_once( 'themes/theme3.php') ; ?>
                <!-- end create theme 3 -->

                <!-- begin create theme 4 -->
				<?php include_once( 'themes/theme4.php') ; ?>
                <!-- end create theme 4 -->

                <!-- begin create theme 5 -->
				<?php include_once( 'themes/theme5.php') ; ?>
                <!-- end create theme 5 -->

                <!-- begin create theme 6 -->
				<?php include_once( 'themes/theme6.php') ; ?>
                <!-- end create theme 6 -->

                <!-- begin create theme 7 -->
				<?php include_once( 'themes/theme7.php') ; ?>
                <!-- end create theme 7 -->

                <!-- begin create theme 8 -->
				<?php include_once( 'themes/theme8.php') ; ?>
                <!-- end create theme 8 -->

            </div>
            <div class="home"></div>
        </div>


    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">انتخاب آیکون</h4>
            </div>
            <div class="modal-body row" >
                <style>
                    .div_font div {
                        width:25%;
                        float:right;
                    }
                </style>
                <div class="div_font col-md-12">
					<?php echo wp2appir_icons(); ?>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php
//------------load modal------------------------------------------------------------
?>
<!-- Modal -->
<?php
$exp_time = get_option('exp_time_WP2APPIR');
$exp = 1;
?>
<button id="btn_alert_wp2appir" class=" hide btn btn-primary btn-lg" data-toggle="modal" data-target="#alert_wp2appir">
</button>
<div class="modal fade" id="alert_wp2appir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel" style="color:green;">توجه توجه !!!</h4>
            </div>
            <div class="modal-body">
				<?php
				if( $exp == 0){
					?>
                    <p style="color: red">
                        کاربر گرامی ! تاریخ انقضای اپ شما به اتمام رسیده است و تغییرات انجام نخواهد شد.
                    </p>
					<?php
				}
				else{
					?>
                    <span style="color:green;">
				                	کاربر گرامی تغییرات شما اعمال شد .</br>
                        لطفا جهت مشاهده تغییرات اپلیکیشن را بسته و مجدداٌ اجرا کنید.
				                	</span>
					<?php
				}
				?>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php
//-----------load js files-----------------------------------------------------------------------------------------------------------
wp_enqueue_script( 'bootstrap.min.js' , WP2APPIR_JS_URL.'bootstrap.min.js', array('jquery'));
wp_enqueue_script( 'poste.js' , WP2APPIR_JS_URL.'poste.js', array('jquery'));
wp_enqueue_script( 'script.js' , WP2APPIR_JS_URL.'script.js', array('jquery'));
wp_enqueue_script( 'colpick.js' , WP2APPIR_JS_URL.'colpick.js', array('jquery'));
?>
