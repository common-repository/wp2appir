<?php
/**
 * Created by mr2app.
 * User: hani
 * Date: 1/16/18
 * Time: 4:53 PM
 */

$current_url = "//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
function insert_wp2app_sale_meta_plan(){
	$time = $_POST["time"];
	$price = $_POST["price"];
	$uniqid = uniqid();

	$array = get_option("mr2app_wp2app_sale_meta_plans");
	$array[] = array(
		"uniqid" => $uniqid ,
		"time" => $time ,
		"price" => $price ,
	);
	update_option("mr2app_wp2app_sale_meta_plans",$array);
}
function update_wp2app_sale_meta_plan() {
	if ( isset( $_GET['field'] ) ) {
		if ( $_GET['field'] != "" ) {
			$price = $_POST["price"];
			$time = $_POST["time"];
			$key = $_GET["field"];
			$plans = get_option("mr2app_wp2app_sale_meta_plans");
			$i = 0;
			foreach ($plans as $value) {
				if ($key == $value["uniqid"]) {
					$array[] = array(
						"uniqid" => $value["uniqid"] ,
						"price" => $price ,
						"time" => $time ,
					);
				}
				else{
					$array[] = array(
						"uniqid" => $value["uniqid"] ,
						"price" => $value["price"] ,
						"time" => $value["time"] ,
					);
				}
				$i++;
			}
			update_option("mr2app_wp2app_sale_meta_plans",$array);
			?>
            <p>
                ویرایش انجام شد...
                <br>
                <a href="admin.php?page=wp2appir/sale_meta/sale_meta.php&tab=plans" > بازگشت </a>
            </p>
            <?php
            exit;
			//wp_redirect('admin.php?page=mr2app_sale_meta/sale_meta.php&tab=plans');
		}
	}
}
function delete_wp2app_sale_meta_plan(){
	if(isset($_GET['field'])){
		if($_GET['field'] != ""){
			$key = $_GET["field"];
			$plans = get_option("mr2app_wp2app_sale_meta_plans");
			$f = "";
			$i = 0;
			foreach ($plans as $value) {
				if ($key == $value["uniqid"]) {
					$f = $i;
				}
				$i++;
			}
			array_splice($plans, $f, 1);
			update_option("mr2app_wp2app_sale_meta_plans",$plans);
			?>
            <p>
                پلن مورد نظر حذف شد...
                <br>
                <a href="admin.php?page=wp2appir/sale_meta/sale_meta.php&tab=plans" > بازگشت </a>
            </p>
			<?php
			exit;
			//wp_redirect('admin.php?page=mr2app_sale_meta/sale_meta.php&tab=plans');
		}
	}
}
$for_edit = array();
$for_edit['uniqid'] = '';
$for_edit['time'] = '';
$for_edit['price'] = '';

if(isset($_GET["action"])){
	if($_GET['action'] == 'delete'){
		delete_wp2app_sale_meta_plan();
	}
	elseif($_GET['action'] == 'edit'){
		if (
			isset($_POST["price"])
			&& $_POST["price"] != ""
			&& isset($_POST["time"])
			&& $_POST["time"] != ""
		)
		{
			update_wp2app_sale_meta_plan();
		}
		else{
			if(isset($_GET['field'])){
				$plans = get_option("mr2app_wp2app_sale_meta_plans");
				$i = 0;
				$key = $_GET['field'];
				foreach ($plans as $value) {
					if ($key == $value["uniqid"]) {
						$for_edit = array(
							"uniqid" => $value["uniqid"] ,
							"price" => $value["price"] ,
							"time" => $value["time"] ,
						);
					}
				}
			}
		}
	}
}
else{
	if (
		isset($_POST["time"])
		&& $_POST["time"] != ""
		&& isset($_POST["price"])
		&& $_POST["price"] != ""
	)
	{
		insert_wp2app_sale_meta_plan();
	}
}
$plans = get_option("mr2app_wp2app_sale_meta_plans");
if (!is_array($plans)){
    $plans = array();
}
?>
<div class="wrap">
	<form action="" method="post">
		<table class="form-table" style="direction: rtl">
			<tbody>
			<tr valign="top" class="">
				<th scope="row" class="titledesc">
					<label> مدت زمان (روز) </label>
				</th>
				<td class="forminp">
					<input type="number" value="<?= $for_edit['time']?>"  name="time"   placeholder="مدت زمان" >
				</td>
			</tr>
			<th scope="row" class="titledesc">
				<label >  قیمت (تومان)  </label>
			</th>
			<td class="forminp">
				<input type="number"  value="<?= $for_edit['price']?>" name="price"   placeholder="قیمت">
			</td>
			</tr>
			<tr >
				<th scope="row" class="titledesc"></th>
				<td class="forminp">
					<input type="submit"  value="ذخیره"  name="submit_banner">
				</td>
			</tbody>
		</table>
	</form>
	<hr>
	<table class="wp-list-table widefat striped" style="direction: rtl">
		<tbody>
		<tr valign="top" class="">
			<th scope="row" class="">
				<label > #  </label>
			</th>
			<th scope="row" class="">
				<label > مدت زمان (روز)  </label>
			</th>
			<th scope="row" class="">
				<label > قیمت (تومان)  </label>
			</th>
            <th scope="row" class="">
				<label >  ویرایش / حذف   </label>
			</th>
		</tr>
		<?php
		$i = 0;
		foreach ($plans as $key){
			$i++;
			?>
			<tr valign="top" class="">
				<th scope="row" class="">
					<label > <?= $i; ?>  </label>
				</th>
				<th scope="row" class="">
					<label > <?= $key['time'];?>  روز </label>
				</th>
				<th scope="row" class="">
					<label > <?= $key['price'];?>  تومان </label>
				</th>
				<th scope="row" class="">
					<a href="<?= $current_url . '&action=edit&field='.$key['uniqid']?>"  > ویرایش </a>
					|
					<a href="<?= $current_url . '&action=delete&field='.$key['uniqid']?>" style="color: red;"  >  حذف </a>
				</th>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
</div>
