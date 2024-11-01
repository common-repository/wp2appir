<?php
if (!defined( 'ABSPATH' )) exit;
wp_register_style( 'bootstrap', WP2APPIR_CSS_URL.'bootstrap.css'  );
wp_enqueue_style( 'bootstrap' );

if(isset($_POST['hide_exit'])){
	delete_option("email_WP2APPIR");
	delete_option("password_WP2APPIR");
	delete_option("appid_WP2APPIR");
	delete_option("exp_time_WP2APPIR");
	delete_option("last_android_apk_WP2APPIR");
	delete_option("last_android_ver_number_WP2APPIR");
	delete_option("last_android_ver_name_WP2APPIR");
}
if (isset($_POST["txt_email_woo"]) && isset($_POST["txt_password_woo"]) && isset($_POST["txt_app_id_woo"]) ) {

	session_start();
	$_SESSION["WP2APPIR_ERR_LOGIN"]=0;
	$email = $_POST["txt_email_woo"];
	$password = md5($_POST["txt_password_woo"]);
	$app_id = $_POST["txt_app_id_woo"];
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://panel.wp2app.ir/panel/api/login?email=$email&password=$password&app_id=$app_id");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$response = curl_exec($ch);
	curl_close($ch);
	$response = json_decode($response,TRUE);

	//var_dump($response);
	if($response["error"] == 1){

		$last_android_apk = $response["app_info"]["last_android_apk"];
		$exp_time = $response["app_info"]["exp_time"];
		$last_android_ver_number = $response["app_info"]["last_android_ver_number"];
		$last_android_ver_name = $response["app_info"]["last_android_ver_name"];

		update_option("email_WP2APPIR",$email);
		update_option("password_WP2APPIR",$_POST["txt_password_woo"]);
		update_option("appid_WP2APPIR",$app_id);
		update_option("exp_time_WP2APPIR", $exp_time);
		update_option("last_android_apk_WP2APPIR",$last_android_apk);
		update_option("last_android_ver_number_WP2APPIR",$last_android_ver_number);
		update_option("last_android_ver_name_WP2APPIR",$response["app_info"]["last_android_ver_name"]);
	}elseif ($response["error"] == -1) {
		$_SESSION["WP2APPIR_ERR_LOGIN"] = -1;
	}elseif ($response["error"] == -2) {
		$_SESSION["WP2APPIR_ERR_LOGIN"] = -2;
	}

}
?>
<?php
$flag = 0;
$email = get_option("email_WP2APPIR");
$password = md5(get_option("password_WP2APPIR"));
$app_id = get_option("appid_WP2APPIR");
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://panel.wp2app.ir/panel/api/login?email=$email&password=$password&app_id=$app_id");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$response = json_decode($response,TRUE);
//var_dump($response);

if($response["error"] == 1){
	$flag = 1;
	$last_android_apk = $response["app_info"]["last_android_apk"];
	$exp_time = $response["app_info"]["exp_time"];
	$last_android_ver_number = $response["app_info"]["last_android_ver_number"];
	$last_android_ver_name = $response["app_info"]["last_android_ver_name"];

	update_option("exp_time_WP2APPIR", $exp_time);
	update_option("last_android_apk_WP2APPIR",$last_android_apk);
	update_option("last_android_ver_number_WP2APPIR",$last_android_ver_number);
	update_option("last_android_ver_name_WP2APPIR",$response["app_info"]["last_android_ver_name"]);
}elseif ($response["error"] == -1) {
	$flag = 0;
	delete_option("email_WP2APPIR");
	delete_option("password_WP2APPIR");
	delete_option("appid_WP2APPIR");
	delete_option("exp_time_WP2APPIR");
	delete_option("last_android_apk_WP2APPIR");
	delete_option("last_android_ver_number_WP2APPIR");
	delete_option("last_android_ver_name_WP2APPIR");
}


?>
<div id="" class="modal-dialog">
    <div class="">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel" style="font-family: 'tahoma', Arial, Helvetica, sans-serif">
                اطلاعات اپلیکیشن
            </h4>
        </div>
        <div class="modal-body ">
            <div class="row">
				<?php
				if($flag == 0) {
					?>
                    <div class="col-xs-8 pull-right">
                        <div class="">
                            <form  method="POST" >
                                <div class="form-group">
                                    <label for="username" class="control-label">  ایمیل </label>
                                    <input type="text" class="text-left form-control" id="username" name="txt_email_woo" value="" required="" title="Please enter you username" placeholder="example@gmail.com">
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="control-label"> رمزعبور </label>
                                    <input type="password" class="text-left form-control" id="txt_password_woo" name="txt_password_woo" value="" required="" title="Please enter your password">
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="control-label">
                                        کلید اپ
                                    </label>
                                    <a target="_blank" style="color: red" href="http://mr2app.com/blog/%D8%B1%D8%A7%D9%87%D9%86%D9%85%D8%A7%DB%8C-%D8%AF%D8%B1%DB%8C%D8%A7%D9%81%D8%AA-%DA%A9%D9%84%DB%8C%D8%AF-%D8%A7%D9%BE/" >
                                        (راهنمای دریافت کلید اپ)
                                    </a>
                                    <input type="text" class="text-left form-control" id="txt_app_id_woo" name="txt_app_id_woo" value="" required="" title="Please enter your password">
                                </div>
								<?php
								if($_SESSION["WP2APPIR_ERR_LOGIN"] == -1 || $_SESSION["WP2APPIR_ERR_LOGIN"] == -2){
									?>
                                    <div  class="alert alert-warning" style="font-size: 11px;color: red">
                                        مشخصات وارد شده ، اشتباه می باشد.
                                    </div>
									<?php
								}
								?>
                                <button type="submit" class="btn btn-success btn-block"> ورود</button>
                                <a href="http://mr2app.com/panel/"  target="_blank" class="btn btn-info btn-block"> پنل کاربری Mr2App</a>
                            </form>
                        </div>
                    </div>
					<?php
				}
				else{
					?>
                    <div class="col-xs-12 pull-right">

                        <ul class="list-unstyled" style="line-height: 3;direction: rtl">
                            <li><span class="fa fa-check text-success"></span>
                                تاریخ انقضا :
                                <strong dir="rtl">
									<?php
									if(get_option("exp_time_WP2APPIR")){
										if(get_option("exp_time_WP2APPIR") == -1){
											echo "اپ شما دائمی است.";
										}
										else{
											echo  date_i18n( 'Y/m/d' , get_option("exp_time_WP2APPIR"));
										}
									}
									else{
										echo "-------------------------------";
									}
									?>
                                </strong>
                            </li>
                            <li><span class="fa fa-check text-success"></span>
                                آخرین لینک دانلود اپلیکیشن :
                                <strong>
									<?php
									if(get_option("last_android_apk_WP2APPIR")){
										?>
                                        <a href="<?= get_option("last_android_apk_WP2APPIR"); ?>">دانلود اپلیکیشن</a>
										<?php
									}
									else{
										echo "-----------";
									}
									?>
                                </strong>
                            </li>
                            <li><span class="fa fa-check text-success"></span>
                                آخرین نسخه اپلیکیشن :
                                <strong>
									<?php
									if(get_option("last_android_ver_number_WP2APPIR")){
										?>
										<?= get_option("last_android_ver_number_WP2APPIR"); ?>
										<?php
									}
									else{
										echo "-----------";
									}
									?>
                                </strong>
                            </li>
                            <li><span class="fa fa-check text-success"></span>
                                نام نسخه اپلیکیشن :
                                <strong dir="rtl">
									<?php
									if(get_option("last_android_ver_name_WP2APPIR")){
										?>
										<?= get_option("last_android_ver_name_WP2APPIR"); ?>
										<?php
									}
									else{
										echo "-----------";
									}
									?>
                                </strong>
                            </li>
                            <li>
                                <form action="" method="post">
                                    <input type="hidden" name="hide_exit" value="1">
                                    <input type="submit"  class="btn btn-warning" value="خروج" / >
                                </form>
                            </li>
                        </ul>
                    </div>
					<?php
				}
				?>
            </div>
        </div>
    </div>
</div>
