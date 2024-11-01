<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wp_register_style( 'bootstrap', WP2APPIR_CSS_URL.'bootstrap.css'  );
wp_enqueue_style('bootstrap');
wp_register_style( 'font-awesome', WP2APPIR_CSS_URL.'font-awesome.css'  );
wp_enqueue_style('font-awesome');
?>


<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<?php

if(isset($_POST['save_api'])){
    if($_POST['type'] == 'direct'){

        $notif_type = trim(update_option('notification_type',$_POST['type']));
        $app_id = trim(update_option('app_id',$_POST['app_id']));
        $api_id = trim(update_option('api_id' , $_POST['api_id']));
    }
    elseif($_POST['type'] == 'mr2app'){
        $notif_type = trim(update_option('notification_type',$_POST['type']));
        $email = trim(update_option('email_WOO2APP',$_POST['mr2app_username']));
        $pass = trim(update_option('password_WOO2APP' , $_POST['mr2app_password']));
        $app_id_2 = trim(update_option('appid_WOO2APP' , $_POST['mr2app_app_id']));
    }
}

$app_id = get_option('app_id');
$api_id = get_option('api_id');
$email = get_option('email_WOO2APP');
$pass = get_option('password_WOO2APP');
$app_id_2 = get_option('appid_WOO2APP');
$notif_type = get_option('notification_type');
if(!$notif_type){
    $notif_type = 'direct';
}

if ( isset( $_POST['send_notif_wp2appir'] ) &&
    wp_verify_nonce( $_POST["send_notif_wp2appir"], 'wp2appir_send_notif' ) && current_user_can("update_plugins") ) {
    if($_POST["select_notif_hami"] == 1){
        $value = $_POST["txt_link"];
        $action = 1;
    }
    elseif ($_POST["select_notif_hami"] == 2){
        $action = 2;
        $value = $_POST["value_post_notif"];
    }
    elseif ($_POST["select_notif_hami"] == 3) {
        $action = 3;
        $value = $_POST["value_cat_notif"];
    }
    if($notif_type == 'direct'){
        $r = wp2app_send_notif($_POST["txt_title"],$_POST["wp2app_voice"],$action,$value);
        $r = json_decode($r , true);
    }
    else{
        $r = wp2app_send_notif_mr2app( $_POST["txt_title"],$_POST["wp2app_voice"],$action,$value);
        $r = json_decode($r , true);
    }
}


?>
<div class="wrap div_mainpage">
    <div class="col-md-8 pull-right" style="margin-top: 10px">
        <form method="POST">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapse1">تنظیم روش ارسال</a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse <?= (!$notif_type) ? 'in':''?>">
                    <div class="panel-body">
                        <input type="radio" name="type" value="direct" checked/>
                        ارسال مستقیم

                        <input type="radio" name="type" value="mr2app" <?= ($notif_type == 'mr2app') ? 'checked': ''?> />
                        ارسال از طریق مستر 2 اپ
                        <hr>
                        <div id="info_onesignal" class="<?= ($notif_type== 'direct' || $notif_type == '') ? '': 'hide'?>">
                            <div class="col-md-12 form-group">
                                <input name="app_id"  placeholder=" کلید اپ نوتیفیکیشن (درصفحه مشخصات اپ مشاهده کنید) " value="<?= $app_id;?>" class="form-control" type="text">
                            </div>
                            <div  class="col-md-12 form-group">
                                <input name="api_id" placeholder="  کلید api نوتیفیکیشن (درصفحه مشخصات اپ مشاهده کنید)  " value="<?= $api_id;?>" class="form-control" type="text">
                            </div>
                        </div>
                        <div id="info_mr2app" class="<?= ($notif_type == 'mr2app') ? '': 'hide'?>">
                            <div class="col-md-12 form-group">
                                <input name="mr2app_username"  placeholder=" ایمیل (ایمیلی که در مستر2اپ ثبت نام کرده اید) " value="<?= $email;?>" class="form-control" type="text">
                            </div>
                            <div class="col-md-12 form-group" >
                                <input name="mr2app_password" placeholder=" رمز عبور (رمزعبور مستر2اپ) " value="<?= $pass;?>" class="form-control" type="text">
                            </div>
                            <div class="col-md-12 form-group" >
                                <input name="mr2app_app_id" placeholder=" کلید اپ ( عدد 7 رقمی که در لیست اپ های من مشاهده کنید) " value="<?= $app_id_2;?>" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-footer text-left">
                        <button type="submit" name="save_api" class="button button-primary">
                            ذخیره
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-8 pull-right" >
        <div class="panel panel-default">
            <div class="panel-heading">
                ارسال نوتیفیکیشن
            </div>
            <div class="panel-body">
                <form method="POST">
                    <?php wp_nonce_field('wp2appir_send_notif' , 'send_notif_wp2appir'); ?>
                    <div class="col-md-12" >
                        <?php
                        if(isset($r['recipients'])){
                            ?>
                            <span style="color:green">
					            نوتیفیکیشن برای
                                <?= $r['recipients']; ?>
                                نفر ارسال شد.
				            </span>
                            <?php
                        }
                        if(isset($r['errors'])){
                            foreach ($r['errors'] as $e){
                                ?>
                                <p style="color:red">
                                    - <?= $e; ?>
                                </p>
                                <?php
                            }
                        }
                        ?>
                        <div class="clearfix"></div>
                        <hr>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-6 pill-right">
                            <p>
                                <input checked="" type="radio" class="form-control" value="2" name="wp2app_voice" id="wp2app_silent">
                                <span>بی صدا</span>
                            </p>
                        </div>
                        <div class="col-md-6 pill-right">
                            <p>
                                <input checked="" type="radio" class="form-control" value="1" name="wp2app_voice" id="wp2app_voice">
                                <span>با صدا</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-bottom : 10px;">
                        <div class="col-md-10" style="padding:0px; ">
                            <textarea name="txt_title" class="form-control text-right"></textarea>
                        </div>
                        <div class="col-md-2 text-right" style="padding:0px;">
                            عنوان پیام :
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-bottom : 10px;">
                        <div class="col-md-10" style="padding:0px; ">

                            <select id="select_notif_hami" name="select_notif_hami" class="form-control">
                                <option value="1">لینک</option>
                                <option value="2">پست</option>
                                <option value="3">دسته بندی</option>
                            </select>
                        </div>
                        <div class="col-md-2 text-right" style="padding:0px;">
                            نوع :
                        </div>
                    </div>

                    <div class="col-md-12 hide" id="product_list_notif" style="margin:10px;">
                        <div class="col-md-10" >
                            <select name="value_post_notif"  id="value_post_notif"  style="width: 100%;" class="col-md-10 js-data-example-ajax form-control"></select>
                        </div>
                        <div class="col-md-2"> جستجو کنید </div>
                    </div>

                    <div class="col-md-12 hide" id="category_list_notif" style="margin-top:10px;">
                        <select style="height:40px;" name="value_cat_notif" id="value_cat_notif" class="selectpicker col-md-12 form-control" data-live-search="true" title="انتخاب کنید...">
                            <option value="0" style="text-align:right;">دسته خود را انتخاب کنید</option>
                            <?php
                            $cats = get_cat_wp2app();
                            foreach ($cats as $cat) {
                                ?>
                                <option style="text-align:right;" value="<?= $cat->term_id; ?>"><?= $cat->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div id="link_notif_hami" class="col-md-12 " style="margin-bottom : 10px;">
                        <div class="col-md-10" style="padding:0px;">
                            <input type="text" name="txt_link" class="form-control text-left " style="direction:ltr;" placeholder="[http || https] :// mysite.ir">
                            <p>
                                در هنگام قرار دادن لینک حتما مقدار وارد شده را با http یا https وارد نمایید.
                            </p>
                        </div>
                        <div class="col-md-2 text-right" style="padding:0px;">
                            لینک پیام :
                        </div>
                    </div>

                    <div class="col-md-12" style="padding:0px;">
                        <div class="col-md-6 text-left">
                            <button type="submit" class="button button-primary">
                                ارسال پیام
                            </button>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
wp_enqueue_script( 'notification_hami.js' , WP2APPIR_JS_URL.'notification_hami.js', array('jquery'));
wp_enqueue_script( 'bootstrap.min.js' , WP2APPIR_JS_URL.'bootstrap.min.js', array('jquery'));
wp_enqueue_script( 'loadajax.js' , WP2APPIR_JS_URL.'loadAjaxPosts.js', array('jquery'));
?>
<script>
    jQuery('input[type=radio][name=type]').change(function() {
        if (this.value == 'direct') {
            jQuery("#info_onesignal").removeClass('hide')
            jQuery("#info_mr2app").addClass('hide')
        }
        else if (this.value == 'mr2app') {
            jQuery("#info_mr2app").removeClass('hide')
            jQuery("#info_onesignal").addClass('hide')
        }
    });
</script>
