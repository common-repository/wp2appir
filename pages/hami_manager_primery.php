<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$table_name = $wpdb->prefix . 'hami_set';
$table_option = $wpdb->prefix . 'options';
wp_register_style( 'bootstrap', WP2APPIR_CSS_URL.'bootstrap.css' );
wp_enqueue_style('bootstrap');
$current_url = admin_url().'admin.php?page=wp2appir/pages/hami_manager_primery.php';
if(isset($_GET["tab"]))	$tab = $_GET["tab"];
else $tab = 'main';
if($wpdb->query("select * from $table_name WHERE name = 'txt_post_meta_visit'")){
	$wpdb->delete( $table_name, array( 'name' => 'txt_post_meta_visit' ) );
}
$wp2app_setting = array();
$wp2app_setting = get_option('wp2app_setting');
if(!is_array($wp2app_setting)){
	$wp2app_setting = array();
	$wp2app_setting['meta_like'] = '' ;
	$wp2app_setting['meta_visit'] = '' ;
	$wp2app_setting['display_author'] = '' ;
	$wp2app_setting['share_post'] = 'false' ;
	$wp2app_setting['display_link_webview'] = 'false' ;
	$wp2app_setting['txt_url_default_image'] = '' ;
}
if ( isset( $_POST['primery_wp2appir'] ) &&
     wp_verify_nonce( $_POST['primery_wp2appir'], 'wp2appir_primery' ) && current_user_can("update_plugins") ) {
	if(!empty($_POST['NUM_CALTYPE'])){
		do_action( 'myplugin_after_form_settings' );
		global $wpdb;

		$wp2app_setting['meta_like'] = $_POST['meta_like'];
		$wp2app_setting['meta_visit'] = $_POST['meta_visit'];
		$wp2app_setting['display_author'] = $_POST['display_author'];
		$wp2app_setting['txt_url_default_image'] = $_POST['txt_url_default_image'];
		$wp2app_setting['share_post'] = (isset($_POST['share_post']) &&  $_POST['share_post'] == 'on') ? 'true' : 'false';
		$wp2app_setting['display_link_webview'] = (isset($_POST['display_link_webview']) &&  $_POST['display_link_webview'] == 'on') ? 'true' : 'false';
		$wp2app_setting['post_date'] = (isset($_POST['post_date']) &&  $_POST['post_date'] == 'on')  ? 'true' : 'false';
		update_option('wp2app_setting' , $wp2app_setting);

		if(isset($_POST["TXT_LASTANDRVER"]) and !empty($_POST["TXT_LASTANDRVER"])) {
			$dater = sanitize_text_field($_POST["TXT_LASTANDRVER"]);
			$r = $wpdb->update( $table_name,
				array( 'value' => $dater),
				array( 'name' => 'TXT_LASTANDRVER'  ), array( '%s' ), array( '%s' ) );
		}
		if(isset($_POST["TXT_visit_post_meta"]) and !empty($_POST["TXT_visit_post_meta"])) {
			update_option('',$_POST["TXT_visit_post_meta"]);
		}
		if(isset($_POST["TXT_LASTANDRLINK"]) and !empty($_POST["TXT_LASTANDRLINK"])) {
			$version = sanitize_text_field($_POST["TXT_LASTANDRLINK"]);
			$r = $wpdb->update( $table_name,
				array( 'value' => $version),
				array( 'name' => 'TXT_LASTANDRLINK'  ), array( '%s' ), array( '%s' ) );
		}
		if(isset($_POST["TXT_LASTANDRLINK"]) and !empty($_POST["TXT_LASTANDRLINK"])) {
			$version = sanitize_text_field($_POST["TXT_LASTANDRLINK"]);
			$r = $wpdb->update( $table_name,
				array( 'value' => $version),
				array( 'name' => 'TXT_LASTANDRLINK'  ), array( '%s' ), array( '%s' ) );
		}
		if(isset($_POST["txt_post_meta_visit"]) ) {
			$meta_visit = sanitize_text_field($_POST["txt_post_meta_visit"]);
			$r = $wpdb->update( $table_name,
				array( 'value' => $meta_visit),
				array( 'name' => 'txt_post_meta_visit'  ), array( '%s' ), array( '%s' ) );
		}
		if(isset($_POST["NUM_CALTYPE"]) and !empty($_POST["NUM_CALTYPE"]) ) {
			$links = sanitize_text_field($_POST["NUM_CALTYPE"]);
			$r = $wpdb->update( $table_name,
				array( 'value' => $links),
				array( 'name' => 'NUM_CALTYPE'  ), array( '%s' ), array( '%s' ) );
		}
		if(isset($_POST["NUM_FMAIN"]) and !empty($_POST["NUM_FMAIN"]) ) {
			$fonts = sanitize_text_field($_POST["NUM_FMAIN"]);
			$r = $wpdb->update( $table_name,
				array( 'value' => $fonts),
				array( 'name' => 'NUM_FMAIN'  ), array( '%s' ), array( '%s' ) );
		}
		if(isset($_POST['notif_default'])){
			$notify = sanitize_text_field($_POST['notif_default']);
			update_option('wp2app_notif_default' , $notify);
		}
		$records = $wpdb->get_results("select * from $table_name where (value = 'YES' OR value = 'NO') AND  name NOT IN('BOL_SHOWLAND','BOL_ADADSHOWMAIN','BOL_ADADSHOWPOST')  ");
		if(isset($_POST["vehicle"])){
			$flag = 0;
			foreach($records as $r)
			{
				foreach($_POST["vehicle"] as $name)
				{
					if($name == $r->name) $flag = 1;
				}

				if($flag == 1)
				{
					$r = $wpdb->update( $table_name,
						array( 'value' => "YES"),
						array( 'name' => $r->name ), array( '%s' ), array( '%s' ) );
				}else{
					$r = $wpdb->update( $table_name,
						array( 'value' => "NO"),
						array( 'name' => $r->name ), array( '%s' ), array( '%s' ) );
				}
				$flag = 0;
			}
		}else{
			foreach($records as $r)
			{
				$r = $wpdb->update( $table_name,
					array( 'value' => "NO"),
					array( 'name' => $r->name ), array( '%s' ), array( '%s' ) );
			}
		}

	}
}


?>
<div class="wrap">
    <h2 class="nav-tab-wrapper koodak">
        <a href="<?= $current_url.'&tab=main' ?>" class="nav-tab <?php echo ('main' == $tab) ? 'nav-tab-active' : ''; ?>"> تنظیمات اصلی </a>
        <a href="<?= $current_url.'&tab=update' ?>" class="nav-tab <?php echo ('update' == $tab) ? 'nav-tab-active' : ''; ?>"> آپدیت </a>
    </h2>
	<?php
	if($tab == 'main'){
		?>
        <div class="col-md-12">

            <div class="col-md-7"></div>
            <div class="col-md-5">
                <div id="show_alert_backup" class="alert alert-success hide">
                    اطلاعات شما بازگردادنده شد.
                </div>
            </div>
        </div>
        <style>
            td{
                font-size :12px;
            }
            th{
                font-size :12px;
            }
        </style>
        <div class="col-md-12 text-right">
            <div  class="col-md-5  pull-right">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        تنظیمات اصلی
                        <div class="col-md-4 text-left" style="padding:0px;">
                            <a target="_blank" href="http://wp2app.ir/plugin_app_setting/">راهنما <i class="fa fa-1x fa-mortar-board"></i></a>
                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <form method="post">
						<?php wp_nonce_field('wp2appir_primery' , 'primery_wp2appir'); ?>
                        <div class="panel-body">
                            <div class="table-responsive pull-right text-right">
                                <table style="direction:rtl;"  class="table table-hover pull-right text-right">
                                    <thead>
                                    <tr>
                                        <th class="text-right" >#</th>
                                        <th class="text-right" >توضیحات</th>
                                        <th class="text-right" >تغییرات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
									<?php
									global $wpdb;
									$table_name = $wpdb->prefix . 'hami_set';
									//'BOL_SHOWLAND',
									$records = $wpdb->get_results("select * from $table_name where
													name IN ('BOL_SHOWSPL','BOL_SETCOM','BOL_SHOWCOM','txt_post_meta_visit',
															 'BOL_STA','NUM_CALTYPE','TXT_LASTANDRVER','TXT_LASTANDRLINK','NUM_FMAIN')");
									$notif = get_option('wp2app_notif_default');
									$i = 1;
									$exp = 1;
									foreach($records as $record){
										?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $record->description; ?></td>
                                            <td>
                                                <div>
																<span id="div_color_change" class="icon-eraser">
																</span>
													<?php
													if( $record->name == "TXT_LASTANDRVER" )
													{
														?>
                                                        <input  class="form-control" id="<?php echo $record->name; ?>" value="<?php echo $record->value; ?>" type="text" name="<?php echo $record->name; ?>" style="font-weight:bold;" placeholder="نسخه اپلیکیشن" >
														<?php
													}else if($record->name == "TXT_LASTANDRLINK"){

														?>
                                                        <input  class="form-control" id="<?php echo $record->name; ?>" value="<?php echo $record->value; ?>" type="text" name="<?php echo $record->name; ?>" style="font-weight:bold;" placeholder="لینک دانلود" >
														<?php

													}
													else if($record->name == "NUM_CALTYPE")
													{

														?>
                                                        <select <?= ( $exp == 0)? 'disabled' : ''?> name="<?php echo $record->name; ?>" class="form-control">
															<?php if($record->value == "1"){?>
                                                                <option value="1" selected>شمسی</option>
                                                                <option value="2" >میلادی</option>
                                                                <option value="3" >چند روز پیش</option>
															<?php }else if($record->value == "2"){?>
                                                                <option value="1" >شمسی</option>
                                                                <option value="2" selected>میلادی</option>
                                                                <option value="3" >چند روز پیش</option>
															<?php }else if($record->value == "3"){?>
                                                                <option value="1" >شمسی</option>
                                                                <option value="2" >میلادی</option>
                                                                <option value="3" selected>چند روز پیش</option>
															<?php } ?>
                                                        </select>
														<?php
													}else if($record->name == "NUM_FMAIN"){
														?>
                                                        <select <?= ( $exp == 0)? 'disabled' : ''?> name="<?php echo $record->name; ?>" class="form-control">
                                                            <option <?php echo ($record->value == 1) ? "selected" : "" ; ?> value="1">یکان</option>
                                                            <option <?php echo ($record->value == 2) ? "selected" : "" ; ?> value="2">کودک</option>
                                                            <option <?php echo ($record->value == 3) ? "selected" : "" ; ?> value="3">ترافیک</option>
                                                            <option <?php echo ($record->value == 4) ? "selected" : "" ; ?> value="4">نازنین</option>
                                                            <option <?php echo ($record->value == 5) ? "selected" : "" ; ?> value="5">ایران سنس </option>
                                                        </select>
														<?php

													}else
													{
														if($record->value == "YES")
														{
															?>

                                                            <input <?= ( $exp == 0)? 'disabled' : ''?> checked type="checkbox" name="vehicle[]" value="<?php echo $record->name; ?>">
															<?php
														}else{
															?>

                                                            <input <?= ( $exp == 0)? 'disabled' : ''?> type="checkbox" name="vehicle[]" value="<?php echo $record->name; ?>">

															<?php
														}
													}
													?>
                                                </div>
                                            </td>
                                        </tr>
										<?php
									}
									?>
                                    <tr>
                                        <td> 10 </td>
                                        <td> زمینه دلخواه بازدید پست</td>
                                        <td> <input  class="form-control" id="" value="<?= $wp2app_setting['meta_visit'] ?>" type="text" name="meta_visit" style="font-weight:bold;" > </td>
                                    </tr>
                                    <tr>
                                        <td> 11 </td>
                                        <td> زمینه دلخواه لایک پست</td>
                                        <td> <input  class="form-control" id="" value="<?= $wp2app_setting['meta_like'] ?>" type="text" name="meta_like" style="font-weight:bold;" > </td>
                                    </tr>
                                    <tr>
                                        <td> 12 </td>
                                        <td>  نام نویسنده پست </td>
                                        <td>
                                            <select class="form-control" name="display_author">
                                                <option <?= selected($wp2app_setting['display_author'], '1' )?> value="1">   نمایش  </option>
                                                <option  <?= selected($wp2app_setting['display_author'], '-1')?> value="-1">   عدم نمایش </option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td>حالت پیشفرض ارسال نوتیفیکیشن :</td>
                                        <td>

                                            <select <?= ( $exp == 0)? 'disabled' : ''?> name="notif_default" class="form-control">
												<?php if($notif == 0){?>
                                                    <option value="0" selected>عدم ارسال</option>
                                                    <option value="1">ارسال بدون صدا</option>
                                                    <option value="2">ارسال با صدا</option>
												<?php } ?>
												<?php if($notif == 1){?>
                                                    <option value="0">عدم ارسال</option>
                                                    <option value="1" selected>ارسال بدون صدا</option>
                                                    <option value="2">ارسال با صدا</option>
												<?php } ?>
												<?php if($notif == 2){ ?>
                                                    <option value="0">عدم ارسال</option>
                                                    <option value="1">ارسال بدون صدا</option>
                                                    <option value="2" selected>ارسال با صدا</option>
												<?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> 14 </td>
                                        <td> فعال کردن اشتراک گذاری در پست ها </td>
                                        <td>
                                            <input  class="form-control"  <?= $wp2app_setting['share_post'] == 'true' ? 'checked' : '' ?> type="checkbox" name="share_post" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> 15 </td>
                                        <td> نمایش تاریخ در پست </td>
                                        <td>
                                            <input  class="form-control"  <?= $wp2app_setting['post_date'] == 'true' ? 'checked' : '' ?> type="checkbox" name="post_date" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> 16 </td>
                                        <td> نمایش آدرس لینک در وب ویو </td>
                                        <td>
                                            <input  class="form-control"  <?= $wp2app_setting['display_link_webview']  == 'true' ? 'checked' : '' ?> type="checkbox" name="display_link_webview" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> 17 </td>
                                        <td> تصویر شاخص پیشفرض </td>
                                        <td>
                                            <input type="hidden" id="txt_url_default_image" value="<?= $wp2app_setting['txt_url_default_image'] ?: ''?>" name="txt_url_default_image">
                                            <img id="div_image_default_image"  style="cursor: pointer;width: 150px;height: 150px" src="<?= $wp2app_setting['txt_url_default_image']?:'http://placehold.it/150x150'?>">
											<?php
											if(!empty($wp2app_setting['txt_url_default_image'])){
												?>
                                                <br>
                                                <br>
                                                <button onclick="remove_icon()" class="button" style="color: red;" type="button">  <?php _e( 'Remove image' ); ?></button>
												<?php
											}
											?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td> <button type="submit" class="btn btn-primary">
                                                تایید تغییرات
                                                <label class="fa fa-2x fa-save"><label>
                                            </button> </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                    </form>
                    <!-- /.panel-body -->
                </div>
            </div>
            <div  class="col-md-7  pull-right">

            </div>
        </div>
		<?php
	}
	else{
	    require_once 'update_setting.php';
	}
	?>
</div>
<?php
if ( isset( $_POST['wp2appir_primery_backup'] ) &&
     wp_verify_nonce( $_POST['wp2appir_primery_backup'] , 'wp2appir_backup_primery' ) ) {
	if($_FILES["file_backup"]){
		if(!is_dir("backups")){
			mkdir("backups");
		}
		$ext = explode(".", $_FILES['file_backup']["name"]);
		if($ext[1] == "txt"){
			if ($_FILES["file_backup"]["error"] > 0){
				echo "Return Code: " . $_FILES["file_backup"]["error"] . "<br>";
			}else{
				if (file_exists( "backups/".$_FILES["file_backup"]["name"])){
					echo $_FILES["file_backup"]["name"] . " already exists. ";
				}else{
					move_uploaded_file($_FILES["file_backup"]["tmp_name"],
						"backups/".$_FILES["file_backup"]["name"]);

					$homepage = file_get_contents("backups/".$_FILES["file_backup"]["name"]);
					$homepage = (string) $homepage;
					$homepage = str_replace("CHARSET=latin1","CHARSET=utf8",$homepage);
					$array_query = explode(";",$homepage);
					foreach ($array_query as $key) {
						$r = $wpdb->query($key);
					}
					unlink("backups/".$_FILES["file_backup"]["name"]);
					?>
                    <script type="text/javascript">
                        jQuery('#show_alert_backup').removeClass('hide');
                    </script>
					<?php
				}
			}
		}else{
		}
	}
}

wp_enqueue_media();
?>
<script>
    var custom_uploader_hami;
    jQuery('#div_image_default_image').click(function (e) {
        e.preventDefault();
        custom_uploader_hami = wp.media.frames.custom_uploader_hami = wp.media({
            title: 'انتخاب تصویر',
            library: {type: 'image'},
            button: {text: 'انتخاب'},
            multiple: false
        });
        custom_uploader_hami.on('select', function() {
            attachment = custom_uploader_hami.state().get('selection').first().toJSON();
            jQuery('#txt_url_default_image').val(attachment.url);
            url_image = attachment.url;
            jQuery('#div_image_default_image').attr("src",url_image);
        });
        custom_uploader_hami.open();
    })

    function remove_icon() {
        jQuery("#div_image_default_image").attr("src" ,'http://placehold.it/64x64&text=1x1');
        jQuery("#txt_url_default_image").val('');
    }
</script>
