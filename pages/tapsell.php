<?php
/**
 * Created by mr2app.
 * User: hani
 * Date: 2020-05-06
 * Time: 18:58
 */

if (!defined( 'ABSPATH' )) exit;
$current_url="//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(isset($_REQUEST["submit_edit"])){
	$array = array(
		'bottomMainPage'=> array(
			'enable' => ($_POST["tapsell"]['bottomMainPage']['enable'] == 'on') ? true : false,
			'zoonID' => $_POST["tapsell"]['bottomMainPage']['zoonID'],
		),
		'bottomPostPage'=> array(
			'enable' => ($_POST["tapsell"]['bottomPostPage']['enable'] == 'on') ? true : false,
			'zoonID' => $_POST["tapsell"]['bottomPostPage']['zoonID'],
		),
		'BetweenPosts'=> array(
			'enable' => ($_POST["tapsell"]['BetweenPosts']['enable'] == 'on') ? true : false,
			'zoonID' => $_POST["tapsell"]['BetweenPosts']['zoonID'],
			'count' => $_POST["tapsell"]['BetweenPosts']['count'],
		),
		'BeforeDisplayPost'=> array(
			'enable' => ($_POST["tapsell"]['BeforeDisplayPost']['enable'] == 'on') ? true : false,
			'zoonID' => $_POST["tapsell"]['BeforeDisplayPost']['zoonID'],
			'count' => $_POST["tapsell"]['BeforeDisplayPost']['count'],
		),
		'LoginApp'=> array(
			'enable' => ($_POST["tapsell"]['LoginApp']['enable'] == 'on') ? true : false,
			'zoonID' => $_POST["tapsell"]['LoginApp']['zoonID'],
			'count' => $_POST["tapsell"]['LoginApp']['count'],
		),
		'tapsellKey' => $_POST["tapsell"]['tapsellKey'],
	);
	//var_dump($array);
	if(update_option( 'wp2app_tapsell',$array )){
		?>
        <div class="notice notice-success is-dismissible">
            <p>  تنظیمات با موفقیت اعمال شد.</p>
        </div>
		<?php
	}
}
$tapsell = get_option('wp2app_tapsell');
if(!is_array($tapsell)){
	$tapsell = array(
		'bottomMainPage'=> array(
			'enable' => false,
			'zoonID' => '',
		),
		'bottomPostPage'=> array(
			'enable' => false,
			'zoonID' => '',
		),
		'BetweenPosts'=> array(
			'enable' => false,
			'zoonID' => '',
			'count' => '',
		),
		'BeforeDisplayPost'=> array(
			'enable' => false,
			'zoonID' => '',
			'count' => '',
		),
		'LoginApp'=> array(
			'enable' => false,
			'zoonID' => '',
			'count' => '',
		),
		'tapsellKey' => '',
	);
}
?>
<div class="wrap" >
    <h2> تنظیمات تپسل</h2>
    <hr>
    <div id="col-container" class="">
        <div class="col-wrap">
            <div class="form-wrap">
                <form id="addtag" method="post" action="" >
                    <table class="form-table" >
                        <tr valign="top" class="" >
                            <th colspan="2">
                                مکان های نمایش تبلیغ
                            </th>
                        </tr>
                        <tr valign="top" class="" style="border-bottom: 1px solid #ccc">
                            <th>
                                <div>
                                    <input type="checkbox" name="tapsell[bottomMainPage][enable]" <?= checked($tapsell['bottomMainPage']['enable'])?>  />
                                    <span>پایین صفحه اصلی</span>
                                </div>
                                <div style="margin-top: 10px;margin-right: 10px;color: red">
                                    <small>
                                        نوع بنر استاندارد
                                        <a href="">  راهنما </a>
                                    </small>
                                </div>
                            </th>
                            <td>
                                <label>زون آی دی</label>
                                <input type="text"  class="regular-text" name="tapsell[bottomMainPage][zoonID]"  value="<?= $tapsell['bottomMainPage']['zoonID']?>"/>
                            </td>
                        </tr>
                        <tr valign="top" class=""  style="border-bottom: 1px solid #ccc">
                            <th>
                                <div>
                                    <input type="checkbox" name="tapsell[bottomPostPage][enable]" <?= checked($tapsell['bottomPostPage']['enable'])?> />
                                    <span>پایین صفحه پست ها</span>
                                </div>
                                <div style="margin-top: 10px;margin-right: 10px;color: red">
                                    <small>
                                        نوع بنر استاندارد
                                        <a href="">  راهنما </a>
                                    </small>
                                </div>
                            </th>
                            <td>
                                <label>زون آی دی</label>
                                <input type="text"  class="regular-text" name="tapsell[bottomPostPage][zoonID]" value="<?= $tapsell['bottomPostPage']['zoonID']?>"  />
                            </td>
                        </tr>
                        <tr valign="top" class=""  style="border-bottom: 1px solid #ccc">
                            <th>
                                <div>
                                    <input type="checkbox" name="tapsell[BetweenPosts][enable]" <?= checked($tapsell['BetweenPosts']['enable'])?> />
                                    <span> بین پست ها در لیست ها </span>
                                </div>
                                <div style="margin-top: 10px;margin-right: 10px;color: red">
                                    <small>
                                        نوع بنر همسان
                                        <a href="">  راهنما </a>
                                    </small>
                                </div>
                            </th>
                            <td>
                                <div>
                                    <label>زون آی دی</label>
                                    <input type="text"  class="regular-text" name="tapsell[BetweenPosts][zoonID]" value="<?= $tapsell['BetweenPosts']['zoonID']?>"  />
                                </div>
                                <div style="margin-top: 10px">
                                    <label> هر چند پست دیده شود ؟</label>
                                    <input type="number"  style="width: 180px" class="regular-text" name="tapsell[BetweenPosts][count]" value="<?= $tapsell['BetweenPosts']['count']?>" />
                                </div>
                            </td>
                        </tr>
                        <tr valign="top" class="" style="border-bottom: 1px solid #ccc">
                            <th>
                                <div>
                                    <input type="checkbox" name="tapsell[BeforeDisplayPost][enable]" <?= checked($tapsell['BeforeDisplayPost']['enable'])?> />
                                    <span>  قبل از نمایش صفحه پست </span>
                                </div>
                                <div style="margin-top: 10px;margin-right: 10px;color: red">
                                    <small>
                                        نوع آنی ویدیو یا بنری آنی
                                        <a href="">  راهنما </a>
                                    </small>
                                </div>
                            </th>
                            <td>
                                <div>
                                    <label>زون آی دی</label>
                                    <input type="text"  class="regular-text" name="tapsell[BeforeDisplayPost][zoonID]" value="<?= $tapsell['BeforeDisplayPost']['zoonID']?>" />
                                </div>
                                <div style="margin-top: 10px">
                                    <label> هر چند بار اجرا شود ؟</label>
                                    <input type="number" style="width: 180px" class="regular-text" name="tapsell[BeforeDisplayPost][count]" value="<?= $tapsell['BeforeDisplayPost']['count']?>" />
                                </div>
                            </td>
                        </tr>
                        <tr valign="top" class="" style="border-bottom: 1px solid #ccc">
                            <th>
                                <div>
                                    <input type="checkbox" name="tapsell[LoginApp][enable]"  <?= checked($tapsell['LoginApp']['enable'])?>/>
                                    <span>  موقع ورود به اپ </span>
                                </div>
                                <div style="margin-top: 10px;margin-right: 10px;color: red">
                                    <small>
                                        نوع آنی ویدیو یا بنر آنی
                                        <a href="">  راهنما </a>
                                    </small>
                                </div>
                            </th>
                            <td>
                                <div>
                                    <label>زون آی دی</label>
                                    <input type="text"  class="regular-text" name="tapsell[LoginApp][zoonID]" value="<?= $tapsell['LoginApp']['zoonID']?>" />
                                </div>
                                <div style="margin-top: 10px">
                                    <label> هر چند بار اجرا شود ؟</label>
                                    <input type="number"  style="width: 180px" class="regular-text" name="tapsell[LoginApp][count]" value="<?= $tapsell['LoginApp']['count']?>" />
                                </div>
                            </td>
                        </tr>
                        <tr valign="top" class="" >
                            <th colspan="2">
                                تنظیمات اصلی
                            </th>
                        </tr>
                        <tr valign="top" style="border-bottom: 1px solid #ccc">
                            <th>
                                <span> کلید تپسل را وارد کنید </span>
                            </th>
                            <td>
                                <div>
                                    <input type="text"  class="regular-text" name="tapsell[tapsellKey]"  value="<?= $tapsell['tapsellKey']?>" />
                                    <a href=""> راهنما</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" name="submit_edit"  class="button button-primary" value="ذخیره"  />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>