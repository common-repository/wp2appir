<?php/** * Created by mr2app. * User: hani * Date: 12/18/17 * Time: 9:44 AM */if (!defined( 'ABSPATH' )) exit;$sms = get_option('mr2app_sms');if(!is_array($sms)){	$sms = array(		'enable' => 0,		'field' => '',		'panel' =>'',		'number' => '',		'username'=> '',		'password' => '',		'pattern_code' => '',		'pattern_password' => '',	);}$current_url="//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];if(isset($_REQUEST["submit_edit"]) || isset($_REQUEST["submit_test"])){	$pattern_code = "";	$pattern_password = "";	if($sms['panel'] == 'kavenegar'){		$pattern_code = $_POST['pattern_code_kave'];		$pattern_password =  $_POST['pattern_password_kave'];	}	else{		$pattern_code = $_POST['pattern_code_sms_ir'];		$pattern_password =  $_POST['pattern_password_sms_ir'];	}	$sms = array(		'enable' => (isset($_POST['enable']) && $_POST['enable'] == 'on') ? 1 : 0,		'field' => $_POST['field'],		'panel' => $_POST['panel'],		'number' => $_POST['number'],		'username'=> $_POST['username'],		'password' => $_POST['password'],		'pattern_code' => $pattern_code,		'pattern_password' => $pattern_password,	);	if(update_option( 'mr2app_sms',$sms )){		?>        <div class="notice notice-success is-dismissible">            <p>  تنظیمات با موفقیت اعمال شد.</p>        </div>		<?php	}	else {		if(isset($_REQUEST["submit_edit"])) {			?>            <div class="notice notice-danger is-dismissible">                <p> متاسفانه ، به مشکل برخوردیم. مجدد امتحان کنید.</p>            </div>			<?php		}	}	if(isset($_REQUEST["submit_test"])){		global $class_custom_register_wp2app;		//echo $_POST['mobile'];		$test = $class_custom_register_wp2app->test_sms($_POST['mobile']);		if(isset($test['status']) && $test['status'] == true){			?>            <div class="notice notice-success is-dismissible">                <p>   پیامک با موفقیت ارسال شد .</p>            </div>			<?php		}		else{			?>            <div class="notice notice-danger is-dismissible">                <p>  ارسال پیامک با خطا مواجه است .</p>            </div>			<?php		}	}}if(!isset($sms['pattern_password'])) $sms['pattern_password'] = '117';if(!isset($sms['pattern_code'])) $sms['pattern_code'] = '681';?><div class="wrap" >    <div id="col-container" class="">        <h2>            سیستم تایید پیامکی ثبت نام        </h2>        <div class="col-wrap" style="width: 50%;">            <div class="form-wrap">                <form id="addtag" method="post" action="" class="validate">                    <div class="form-field ">                        <p >                            <input   style="float: right"  type="checkbox" <?= $sms['enable'] ? 'checked' : '';?>  name="enable"  />                            <label style="float: right;margin-right: 5px" > فعال کردن سیستم </label>                        </p>                    </div>                    <br>                    <div class="form-field ">                        <label> انتخاب فیلد شماره تماس </label>						<?php						$args      = array(							'post_type'   => 'woo2app_register',							'post_status' => 'draft',							'posts_per_page' => -1,							'orderby' => 'menu_order',							'order' => 'ASC'						);						$the_query = get_posts( $args );						?>                        <select name="field" style="width: 90%">							<?php							foreach ($the_query as $f){								?>                                <option <?= ($sms['field'] == $f->post_content)? 'selected' : '' ;?> value="<?= $f->post_content; ?>">									<?= $f->post_title;?>                                </option>								<?php							}							?>                        </select>                    </div>                    <div class="form-field ">                        <label> انتخاب پنل پیامک </label>                        <select name="panel" style="width: 90%" onchange="change_panel(this)">                            <option <?= ($sms['panel'] == 'payamresan')? 'selected' : '' ;?> value="payamresan">  پیام رسان - payamresan </option>                            <option <?= ($sms['panel'] == 'rangine')? 'selected' : '' ;?> value="rangine">  rangine </option>                            <option <?= ($sms['panel'] == 'melipayamak')? 'selected' : '' ;?> value="melipayamak">  melipayamak </option>                            <option <?= ($sms['panel'] == 'fast_sms_ir')? 'selected' : '' ;?> value="fast_sms_ir">  sms.ir </option>                            <option <?= ($sms['panel'] == 'farazsms')? 'selected' : '' ;?> value="farazsms">  farazsms </option>                            <option <?= ($sms['panel'] == 'parsgreen')? 'selected' : '' ;?> value="parsgreen">  Parsgreen.com </option>                            <option <?= ($sms['panel'] == 'dlesms_ir')? 'selected' : '' ;?> value="dlesms_ir">  dlesms.ir </option>                            <option <?= ($sms['panel'] == 'kavenegar')? 'selected' : '' ;?> value="kavenegar">  kavenegar.com </option>                            <option <?= ($sms['panel'] == 'aryan_sms_ir')? 'selected' : '' ;?> value="aryan_sms_ir">  aryan_sms_ir </option>                            <option <?= ($sms['panel'] == 'ippanel')? 'selected' : '' ;?> value="ippanel">  ippanel </option>                            <option <?= ($sms['panel'] == 'parsniaz')? 'selected' : '' ;?> value="parsniaz">  parsniaz </option>                        </select>                    </div>                    <div class="form-field ">                        <label> شماره پیامک </label>                        <input name="number" dir="ltr" type="text" value="<?= $sms['number'];?>" />                    </div>                    <div class="form-field ">                        <label> نام کاربری پنل (کلید وب سرویس)</label>                        <input name="username" dir="ltr"  type="text" value="<?= $sms['username'];?>" />                    </div>                    <div class="form-field ">                        <label> رمز عبور پنل (کد امنیتی)</label>                        <input name="password" dir="ltr" type="password" value="<?= $sms['password'];?>" />                    </div>                    <div class="pattern_div_kavenegar form-field <?= ($sms['panel'] == 'kavenegar') ?: 'hide-all' ;?> ">                        <label> نام الگویی که در کاوه نگار ایجاد کردید ، در باکس زیر وارد کنید.  </label>                        <input type="text" name="pattern_code_kave"  value="<?= $sms['pattern_code']?>"/>                        <p id="msg_passwordk">                        </p>                    </div>                    <div class="pattern_div_kavenegar form-field <?= ($sms['panel'] == 'kavenegar') ?: 'hide-all' ;?> ">                        <label> نام الگویی که در کاوه نگار ایجاد کردید ، در باکس زیر وارد کنید.  </label>                        <input type="text" name="pattern_password_kave"  value="<?= $sms['pattern_password']?>"/>                        <p id="msg_passwordk">                        </p>                    </div>					<?php					$array = array(						"rangine", "dlesms_ir" , "ippanel" , "parsniaz" , 'farazsms' , 'fast_sms_ir'					);					?>                    <div class="pattern_div_sms_ir form-field <?= (in_array($sms['panel'],$array)  ) ?: 'hide-all' ;?> ">                        <label> نام الگوی ثبت شده برای ارسال کد تایید، در باکس زیر وارد کنید.  </label>                        <input type="text" name="pattern_code_sms_ir"  value="<?= $sms['pattern_code']?>"/>                        <p id="msg_passwordk">                        </p>                    </div>                    <div class="pattern_div_sms_ir form-field <?= (in_array($sms['panel'],$array)  ) ?: 'hide-all' ;?> ">                        <label> نام الگوی ثبت شده برای رمز عبور ، در باکس زیر وارد کنید.  </label>                        <input type="text" name="pattern_password_sms_ir"  value="<?= $sms['pattern_password']?>"/>                        <p id="msg_passwordk">                        </p>                    </div>                    <div class="form-field " >                        <p class="submit">                            <input type="submit" name="submit_edit"  class="button button-primary" value="ویرایش"  />                            <button type="submit" onclick="send_test()" name="submit_test" class="button"> تست پیامک </button>                            <input type="hidden" id="mobile" name="mobile" value="" />                        </p>                    </div>                </form>            </div>        </div>    </div></div><script>    function change_panel(e) {        var myarr = ["rangine", "dlesms_ir" , "ippanel" , "parsniaz" , 'farazsms' , 'fast_sms_ir'];        if(myarr.indexOf(e.value) > -1){            //jQuery(".pattern_div").removeClass('hide-all')            jQuery(".pattern_div_sms_ir").removeClass('hide-all')            jQuery(".pattern_div").addClass('hide-all')        }        else if(e.value == 'kavenegar'){            jQuery(".pattern_div_kavenegar").removeClass('hide-all')            jQuery(".pattern_div_sms_ir").addClass('hide-all')        }        else{            jQuery(".pattern_div_sms_ir").addClass('hide-all')            jQuery(".pattern_div_kavenegar").addClass('hide-all')        }    }    function send_test() {        let mobile = prompt("لطفا شماره همراه را وارد کنید.");        if(mobile != null){            jQuery("#mobile").val(mobile);            jQuery("form").submit();        }    }</script>