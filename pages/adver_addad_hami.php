<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( isset( $_POST['wp2appir_adver_adad'] ) &&
wp_verify_nonce( $_POST['wp2appir_adver_adad'], 'wp2appir_adad_adver' ) && current_user_can("update_plugins") ) {

	if( isset($_POST['check_adver_setting']) && $_POST['check_adver_setting'] == 1 ){
		$main = sanitize_text_field($_POST['check_adver_hami_main']);
		$post = sanitize_text_field($_POST['check_adver_hami_post']);
		global $wpdb;
		$table_name = $wpdb->prefix . 'hami_set';
		if($main == 1){
			$r = $wpdb->update( $table_name, 
				array( 'value' => "YES"),
				array( 'name' => 'BOL_ADADSHOWMAIN' ) );
		}else{
			$r = $wpdb->update( $table_name, 
				array( 'value' => "NO"),
				array( 'name' => 'BOL_ADADSHOWMAIN' ) );
		}
		if($post == 2)
		{
			$r = $wpdb->update( $table_name, 
				array( 'value' => "YES"),
				array( 'name' => 'BOL_ADADSHOWPOST' ) );
		}else{
			$r = $wpdb->update( $table_name, 
				array( 'value' => "NO"),
				array( 'name' => 'BOL_ADADSHOWPOST' ) );
		}
		do_action( 'myplugin_after_form_settings' );
		$_SESSION["adver_alarm"] = 1;
	}

} 


wp_register_style( 'bootstrap', WP2APPIR_CSS_URL.'bootstrap.css'  );
wp_enqueue_style('bootstrap');
wp_register_style( 'font-awesome', WP2APPIR_CSS_URL.'font-awesome.css'  );
wp_enqueue_style('font-awesome');
/*wp_register_style( 'wp2app_fonts', 'http://wp2app.ir/downloads/plugin-asset/wp2app_fonts.css'  );
wp_enqueue_style('wp2app_fonts');*/

global $wpdb;
$table_name = $wpdb->prefix . 'hami_set';
$res = $wpdb->get_results("select * from $table_name where name = 'BOL_ADADSHOWMAIN' or name = 'BOL_ADADSHOWPOST' ");
$check_1 = "";
$check_2 = "";
foreach ($res as $key) {
	if($key->name == 'BOL_ADADSHOWMAIN'){
		if($key->value == 'YES'){
			 $check_1 = 'checked';
		}
	}
    if ($key->name == 'BOL_ADADSHOWPOST') {
		if($key->value == 'YES'){
			 $check_2 = 'checked';
		}
	}
}
?>
<div class="col-md-12">
	<div class="col-md-6"></div>
	<div class="col-md-6">
		<div class="panel panel-default">
            <div class="panel-heading">
                تنظیمات تبلیغات عدد
				<div class="col-md-4 text-left" style="padding:0px;">
					<a target="_blank" href="http://wp2app.ir/adad_configuration/">راهنما <i class="fa fa-1x fa-mortar-board"></i></a>
				</div>
            </div>
            <div class="panel-body">
            	<div class="col-md-12">
            		<p>
            			شما میتوانید از طریق اپلیکیشن خود از راه تبلیغات سیستم عدد کسب درآمد کنید مراحل انجام کار را میتوانید از لینک راهنما مشاهده
						کنید.
            		</p>
            	</div>
            	<div class="col-md-12">
            		
            		<form role="form" action="" method="post"> 
            		<?php wp_nonce_field('wp2appir_adad_adver','wp2appir_adver_adad'); ?>
                	  <div class="checkbox">
                        <label>
                            <input value="1" name="check_adver_hami_main" type="checkbox" <?php echo $check_1; ?> >&nbsp&nbsp&nbsp&nbsp نمایش تبلیغات عدد در صفحه اصلی اپلیکیشن
                        </label>
                       </div>                  
                       <div class="checkbox">
                        <label>
                            <input value="2" name="check_adver_hami_post" type="checkbox" <?php echo $check_2; ?> >&nbsp&nbsp&nbsp&nbsp نمایش تبلیغات عدد در صفحه نمایش مطلب
							<input type="hidden" value="1" name="check_adver_setting">
                        </label>
                       </div> 
                       <div class="col-md-12" style="padding:5px;">
							<button type="submit" class="btn btn-primary">ذخیره کردن</button>
						</div>
                    </form>
            	</div>
            	<div class="col-md-12">
            		<?php
            			if ($_SESSION["adver_alarm"] == 1) {
        				?>
							<div class="alert alert-success">
                                تنظیمات شما ذخیره شد لطفا برای اعمال تغییرات اپلیکیشن خود را بسته و دوباره باز کنید.
                            </div>
        				<?php
            			}
            		?>
            	</div>
            </div>
		</div>
	</div>
</div>