<?php
if(isset($_POST['submit_update'])){
	$update = array();
	$update = get_option('wp2app_update');
	if(!is_array($update)){
		$update = array();
		$update['android_ver_code'] = '' ;
		$update['android_update_url'] = '' ;
		$update['android_update_req'] = false ;
		//$update['ios_ver_code'] = '' ;
		//$update['ios_update_url'] = '' ;
		$update['description_update'] = '' ;
		//$update['description_update_ios'] = '' ;
		//$update['ios_update_req'] = false ;
		update_option('wp2app_update' , $update);
	}
	$update['android_ver_code'] = $_POST['android_ver_code'] ;
	$update['android_update_url'] = $_POST['android_update_url'] ;
	$update['android_update_req'] = (isset($_POST['android_update_req']) && $_POST['android_update_req'] == 'on' ) ? true : false;
	//$update['ios_ver_code'] = $_POST['ios_ver_code'] ;
	//$update['ios_update_url'] = $_POST['ios_update_url'] ;
	$update['description_update'] = $_POST['description_update'] ;
	//$update['description_update_ios'] = $_POST['description_update_ios'] ;
	//$update['ios_update_req'] = (isset($_POST['ios_update_req']) &&  $_POST['ios_update_req'] == 'on') ? true : false;
	update_option('wp2app_update' , $update);
}


$update = array();
$update = get_option('wp2app_update');
if(!is_array($update)){
	$update = array();
	$update['android_ver_code'] = '' ;
	$update['android_update_url'] = '' ;
	$update['android_update_req'] = false ;
	//$update['ios_ver_code'] = '' ;
	//$update['ios_update_url'] = '' ;
	//$update['ios_update_req'] = false ;
	update_option('wp2app_update' , $update);
}
?>
<form method="post">
	<table class="form-table " style="direction: rtl">
		<tbody>
		<tr valign="top" class="" >
			<th scope="row" class="titledesc">
				<label > کد نسخه اندروید </label>
			</th>
			<td class="forminp">
				<input type="text" class="regular-text" name="android_ver_code" value="<?= $update['android_ver_code']?>">
			</td>
		</tr>
		<tr valign="top" class="" >
			<th scope="row" class="titledesc">
				<label > لینک آپدیت اندروید </label>
			</th>
			<td class="forminp">
				<input type="text" class="regular-text" name="android_update_url" value="<?= $update['android_update_url']?>">
			</td>
		</tr>
		<tr valign="top" class="" >
			<th scope="row" class="titledesc">
				<label > آپدیت اجباری اندروید</label>
			</th>
			<td class="forminp">
				<input type="checkbox" name="android_update_req" <?= checked( $update['android_update_req']  );?> />
				در صورت فعال بودن ،آپدیت اپلیکیشن برای کاربر اجباری می شود.
			</td>
		</tr>
		<tr valign="top" class="" >
			<th scope="row" class="titledesc">
				<label >  توضیحات آپدیت اندروید </label>
			</th>
			<td class="forminp">
				<?php
				wp_editor( $update['description_update'],'description_update');
				?>
			</td>
		</tr>

		</tbody>
	</table>
	<input name="submit_update"  class="button button-primary" value="ذخیره‌" type="submit">
</form>
