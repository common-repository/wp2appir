<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wp_register_style( 'bootstrap', WP2APPIR_CSS_URL.'bootstrap.css'  );
wp_enqueue_style('bootstrap');
wp_register_style( 'font-awesome', WP2APPIR_CSS_URL.'font-awesome.css'  );
wp_enqueue_style('font-awesome');
wp_register_style( 'wp2app_fonts', 'http://wp2app.ir/downloads/plugin-asset/wp2app_fonts.css'  );
wp_enqueue_style('wp2app_fonts');

if ( isset( $_POST['telegram_wp2appir'] ) &&
wp_verify_nonce( $_POST[telegram_wp2appir], 'wp2appir_telegram' ) && current_user_can("update_plugins") ) {

		if(!empty($_POST)){
				if(!empty($_POST['txt_token']) && !empty($_POST['txt_chanal']) ){
					global $wpdb;
					$table_option = $wpdb->prefix . 'options';
				if(!empty($_POST['txt_token']) ){
					$token = sanitize_text_field($_POST["txt_token"]);
					update_option('hrt_telegram_token' , $token);
					$_SESSION['alert_t'] = 'alert_t';  
				}else{
					$_SESSION['alert_t'] = 'danger';  
				}
				if(!empty($_POST['txt_chanal'])) {
					$chanal = sanitize_text_field($_POST["txt_chanal"]);
					update_option('hrt_telegram_chatid' , $chanal);
					$_SESSION['alert_t'] = 'alert_t';  
				}else{
					$_SESSION['alert_t'] = 'danger';  
					
				}
				if(!empty($_POST['txt_sign']) ){
					$sign = sanitize_text_field($_POST["txt_sign"]);
					update_option('hrt_telegram_sign' , $sign);
					$_SESSION['alert_t'] = 'alert_t';  
				}
				if(!empty($_POST['txt_default']) || $_POST['txt_default'] == 0 ){
					$default = sanitize_text_field($_POST["txt_default"]);
					update_option('wp2app_telg_default' , $default);
					$_SESSION['alert_t'] = 'alert_t';  
				}
				}else{
					$_SESSION['alert_t'] = 'danger'; 
				}
		}
}

//---------------------------------------------------------------------
	$token = get_option('hrt_telegram_token');
	$chat = get_option('hrt_telegram_chatid');
	$sign = get_option('hrt_telegram_sign');
	$txt_default = get_option('wp2app_telg_default');
//---------------------------------------------------------------------
?>
<div class="col-md-12">

	<div class="col-md-6"></div>
	<div class="col-md-6">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            تنظیمات تلگرام
	            <div class="col-md-4 text-left" style="padding:0px;">
					<a target="_blank" href="http://wp2app.ir/telegram/">راهنما <i class="fa fa-1x fa-mortar-board"></i></a>
				</div>	
	        </div>
	        <div class="panel-body">
	        <form method="POST">
	        <?php wp_nonce_field('wp2appir_telegram' , 'telegram_wp2appir'); ?>
	        	  <div class="col-md-12" >
	        	  <?php
	        	  	if($_SESSION['alert_t'] == 'alert_t'){
	        	  ?>
	        		<div class="alert alert-success">
	        			تنظیمات شما ذخیره شد.
	        		</div>
	        	  <?php } ?>
	        	   <?php
	        	  	if($_SESSION['alert_t'] == 'danger'){
	        	  ?>
	        		<div class="alert alert-danger">
	        			لطفا فیلدها را پر کنید.
	        		</div>
	        	  <?php } ?>
	        	  </div>
	              <div class="col-md-12" style="margin-bottom : 10px;">
	              	<div class="col-md-8" style="padding:0px; ">
	              		<input type="text" name="txt_token" class="form-control text-left" style="direction:ltr;" value="<?php echo $token; ?>">
	              	</div>
	              	<div class="col-md-4 text-right" style="padding:0px;">
	              			TOKEN ربات تلگرام :
	              	</div>
	              </div>
	              <div class="col-md-12" style="margin-bottom : 10px;">
	              	<div class="col-md-8" style="padding:0px;">
	              		<input type="text" name="txt_chanal" class="form-control text-left" style="direction:ltr;"  value="<?php echo $chat; ?>">
	              	</div>
	              	<div class="col-md-4 text-right" style="padding:0px;">
	              		کانال تلگرام :
	              	</div>
	              </div>
	              <div class="col-md-12" style="margin-bottom : 10px;" >
	              	<div class="col-md-8" style="padding:0px;">
	              		<input type="text" name="txt_sign" class="form-control" value="<?php echo $sign; ?>">
	              	</div>
	              	<div class="col-md-4 text-right" style="padding:0px;">
	              		امضای آخر پیام :
	              	</div>
	              </div>
	              <div class="col-md-12" style="margin-bottom : 10px;" >
	              	<div class="col-md-8" style="padding:0px;">
	              		<select name="txt_default" class="form-control">
	              			<?php if($txt_default == 0){?>
	              				<option value="0" selected>عدم ارسال</option>
	              				<option value="1">ارسال بدون صدا</option>
	              				<option value="2">ارسال با صدا</option>
              				<?php } ?>
              				<?php if($txt_default == 1){?>
	              				<option value="0">عدم ارسال</option>
	              				<option value="1" selected>ارسال بدون صدا</option>
	              				<option value="2">ارسال با صدا</option>
              				<?php } ?>
              				<?php if($txt_default == 2){?>
	              				<option value="0">عدم ارسال</option>
	              				<option value="1">ارسال بدون صدا</option>
	              				<option value="2" selected>ارسال با صدا</option>
              				<?php } ?>
	              		</select>
	              	</div>
	              	<div class="col-md-4 text-right" style="padding:0px;">
	              		حالت پیش فرض ارسال روی تلگرام :
	              	</div>
	              </div>
	              <div class="col-md-12" style="padding:0px;">
	              	<div class="col-md-6 text-left">
	              		<button type="submit" class="btn btn-primary">
							ذخیره کردن
							<label class="fa fa-2x fa-save"></label>
						</button>
	              	</div>
	              	<div class="col-md-6"></div>
	              </div>
            </form>
	        </div>
	    </div>			
    </div>	
</div>