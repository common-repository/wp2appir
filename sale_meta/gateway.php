<?php
/**
 * Created by PhpStorm.
 * User: hani
 * Date: 1/16/18
 * Time: 4:53 PM
 */

$page = 'zarinpal';
if (array_key_exists('sub_page', $_GET)) {
	$page = $_GET['sub_page'];
}
?>
	<ul class="subsubsub" dir="rtl">
		<li><a href="<?= $current_url.'&sub_page=zarinpal' ?>" class="<?= ($page =="zarinpal")?'current':'';?>"> زرین پال </a> </li>
	</ul>

<?php
if($page == 'zarinpal'){
	save_zarinpal();
	$gateway = get_option('mr2app_wp2app_sale_meta_gateway');
	$zarinpal = $gateway['zarinpal'];
	?>
	<form method="post">
		<h1 class="screen-reader-text">پرداخت</h1>
		<br class="clear">
		<h2> درگاه  زرین پال </h2>
		<table class="form-table">
			<tbody>
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label for="woocommerce_cod_enabled">فعال/غیرفعال</label>
				</th>
				<td class="forminp">
					<label for="woocommerce_cod_enabled">
						<input name="zarinpal[checked]" <?= checked($zarinpal['active'])?> type="checkbox">
						فعال کردن درگاه زرین پال
					</label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label for="woocommerce_cod_title">  مرچنت کد زرین پال  </label>
				</th>
				<td class="forminp">
					<input class="regular-text" name="zarinpal[merchant_code]"   value="<?= $zarinpal['merchant_code']; ?>"  type="text">
				</td>
			</tr>
			</tbody>
		</table>
		<p class="submit">
			<input name="save" class="button-primary " value="ذخیره تغییرات" type="submit">
		</p>
	</form>
	<?php
}
function save_zarinpal(){
	if (array_key_exists('zarinpal', $_POST)) {
		$gateway = get_option('mr2app_wp2app_sale_meta_gateway');
		$gateway['zarinpal'] = array(
			'active' =>  (isset($_POST['zarinpal']['checked']) && $_POST['zarinpal']['checked'] == 'on') ? 1 : 0,
			'merchant_code' => $_POST['zarinpal']['merchant_code'],
			'label' => ' زرین پال',
			'icon' => '',
		);
		return update_option( 'mr2app_wp2app_sale_meta_gateway',	$gateway);
	}
}
?>