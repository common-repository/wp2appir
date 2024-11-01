<?php
/**
 * Created by mr2app.
 * User: hani
 * Date: 11/13/18
 * Time: 16:16
 */

if (!defined( 'ABSPATH' )) exit;
$current_url="//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(isset($_REQUEST["submit_edit"])){
    $array = array(
        'ENTER_WITH_LOGIN' => ($_POST["ENTER_WITH_LOGIN"] == 'on') ? true : false
    );
    if(update_option( 'wp2app_register_form',$array )){
        ?>
        <div class="notice notice-success is-dismissible">
            <p>  تنظیمات با موفقیت اعمال شد.</p>
        </div>
        <?php
    }
    else {
        ?>
        <div class="notice notice-danger is-dismissible">
            <p> متاسفانه ، به مشکل برخوردیم. مجدد امتحان کنید.</p>
        </div>
        <?php
    }
}
$setting = get_option('wp2app_register_form');
?>
<div class="wrap" >
    <div id="col-container" class="">
        <div class="col-wrap">
            <div class="form-wrap">
                <form id="addtag" method="post" action="" class="validate">
                    <table class="form-table">
                        <tr valign="top" class="" >
                            <th>
                                ثبت نام برای ورود به اپ
                            </th>
                            <td>
                                <input type="checkbox" name="ENTER_WITH_LOGIN" <?= checked($setting['ENTER_WITH_LOGIN']);?> />
                                در صورت فعال بودن ، ورود به اپ فقط با عضویت امکان پذیر هست
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" name="submit_edit"  class="button button-primary" value="ویرایش"  />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>