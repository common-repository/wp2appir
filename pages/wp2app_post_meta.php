<?php
/**
 * Created by mr2app.
 * User: hani
 * Date: 1/13/18
 * Time: 5:24 PM
 */


$current_url = admin_url().'admin.php?page=wp2appir/pages/hami_manager_post_types.php&tab=3';
function insert_wp2app_custom_field(){
	$meta_type = $_POST["meta_type"];
	$meta_key =  trim($_POST["meta_key"]);
	$display_type = $_POST["display_type"];
	$meta_value = "";
	if($display_type == 'title') $meta_value = $_POST["title"];
	if($display_type == 'select') $meta_value = $_POST["drop_display"];
	if($display_type == 'image') $meta_value = $_POST["src_val"];

	$array = get_option("wp2app_custom_fields");
	if(!is_array($array)){
		$array = array();
	}
	$array["wp2pp_cf"][] = array(
		"meta_type" => $meta_type ,
		"meta_key" => $meta_key ,
		"display_type" => $display_type ,
		"value" => $meta_value ,
	);
	update_option("wp2app_custom_fields",$array);
}
function update_wp2app_custom_field() {
	if ( isset( $_GET['field'] ) ) {
		if ( $_GET['field'] != "" ) {
			$meta_type = $_POST["meta_type"];
			$meta_key =  trim($_POST["meta_key"]);
			$display_type = $_POST["display_type"];
			$meta_value = "";
			if($display_type == 'title') $meta_value = $_POST["title"];
			if($display_type == 'select') $meta_value = $_POST["drop_display"];
			if($display_type == 'image') $meta_value = $_POST["src_val"];
			$key = $_GET["field"];
			$types = get_option("wp2app_custom_fields");
			$i = 0;
			foreach ($types["wp2pp_cf"] as $value) {
				if ($key == $value["meta_key"]) {
					$array["wp2pp_cf"][] = array(
						"meta_type" => $meta_type ,
						"meta_key" => $meta_key ,
						"display_type" => $display_type ,
						"value" => $meta_value ,
					);
				}
				else{
					$array["wp2pp_cf"][] = array(
						"meta_type" => $value["meta_type"] ,
						"meta_key" => $value["meta_key"] ,
						"display_type" => $value["display_type"] ,
						"value" => $value["value"] ,
					);
				}
				$i++;
			}
			update_option("wp2app_custom_fields",$array);
			?>
            <p>
                #زمینه دلخواه ویرایش شد.
            </p>
            <a class="button button-primary" href="<?= admin_url().'admin.php?page=wp2appir/pages/hami_manager_post_types.php&tab=3';?>">  بازگشت </a>
			<?php
			exit();
		}
	}
}
function delete_wp2app_custom_field(){
	if(isset($_GET['field'])){
		if($_GET['field'] != ""){
			$key = $_GET["field"];
			$types = get_option("wp2app_custom_fields");
			$f = "";
			$i = 0;
			foreach ($types["wp2pp_cf"] as $value) {
				if ($key == trim($value["meta_key"])) {
					$f = $i;
				}
				$i++;
			}
			array_splice($types["wp2pp_cf"], $f, 1);
			update_option("wp2app_custom_fields",$types);
			?>
            <p>
                #زمینه دلخواه پاک شد.
            </p>
            <a class="button button-primary" href="<?= admin_url().'admin.php?page=wp2appir/pages/hami_manager_post_types.php&tab=3';?>">  بازگشت </a>
			<?php
			exit();
		}
	}
}
$for_edit = array();
$for_edit['meta_type'] = '';
$for_edit['meta_key'] = '';
$for_edit['display_type'] = 'title';
$for_edit['value'] = '';
if(isset($_GET["action"])){
	if($_GET['action'] == 'delete'){
		delete_wp2app_custom_field();
	}
    elseif($_GET['action'] == 'edit'){
		if (
			isset($_POST["meta_type"])
			&& $_POST["meta_type"] != ""
			&& isset($_POST["meta_key"])
			&& $_POST["meta_key"] != ""
			&& isset($_POST["display_type"])
			&& $_POST["display_type"] != ""
		)
		{
			update_wp2app_custom_field();
		}
		else{
			if(isset($_GET['field'])){
				$types = get_option("wp2app_custom_fields");
				$i = 0;
				$key = $_GET['field'];
				foreach ($types["wp2pp_cf"] as $value) {
					if ($key == $value["meta_key"]) {
						$for_edit = array(
							"meta_type" => $value["meta_type"] ,
							"meta_key" => $value["meta_key"] ,
							"display_type" => $value["display_type"] ,
							"value" => $value["value"] ,
						);
					}
				}
			}
		}
	}
}
else{
	if (
		isset($_POST["meta_type"])
		&& $_POST["meta_type"] != ""
		&& isset($_POST["meta_key"])
		&& $_POST["meta_key"] != ""
		&& isset($_POST["display_type"])
		&& $_POST["display_type"] != ""
	)
	{
		insert_wp2app_custom_field();
	}
}
$my_cf = get_option("wp2app_custom_fields");
?>
<div class="wrap">
    <form action="" method="post">
        <table class="form-table " style="direction: rtl">
            <tbody>
            <tr valign="top" class="">
                <th scope="row" class="titledesc">
                    <label > نوع زمینه دلخواه  </label>
                </th>
                <td class="forminp">
                    <select class="form-control" id="select_meta_type" name="meta_type" required="required">
                        <option <?= ($for_edit['meta_type'] == 'text') ? 'selected' : '' ;?> value="text"> متن </option>
                        <option <?= ($for_edit['meta_type'] == 'music') ? 'selected' : '' ;?> value="music" >   موزیک </option>
                        <option <?= ($for_edit['meta_type'] == 'video') ? 'selected' : '' ;?> value="video">ویدیو </option>
                        <option <?= ($for_edit['meta_type'] == 'image') ? 'selected' : '' ;?> value="image"> تصویر </option>
                        <option <?= ($for_edit['meta_type'] == 'link') ? 'selected' : '' ;?> value="link"> لینک </option>
                        <option <?= ($for_edit['meta_type'] == 'file') ? 'selected' : '' ;?> value="file"> فایل </option>
                    </select>
                </td>
            </tr>
            <tr valign="top" class="">
                <th scope="row" class="titledesc">
                    <label > کلید زمینه دلخواه </label>
                </th>
                <td class="forminp">
                    <input type="text" value="<?= $for_edit['meta_key'];?>"  name="meta_key" id="meta_key"  placeholder="زمینه های دلخواه" >
                </td>
            </tr>

            <tr valign="top" >
                <input type="hidden" name="display_type" value="title" />

            </tr>
            <tr valign="top" class="el_type" id="display" <?= ($for_edit['display_type'] == 'select') ? '' : 'style="display: none"' ;?> >
                <th scope="row" class="titledesc">
                    <label > محصول </label>
                </th>
                <td class="forminp">
                    <select name="drop_display" id="drop_display" style="width:200px" class="form-control">
                        <option <?= ($for_edit['value'] == '1') ? 'selected' : ''?> value="1"> model 1 </option>
                        <option <?= ($for_edit['value'] == '2') ? 'selected' : ''?> value="2"> model 2 </option>
                        <option <?= ($for_edit['value'] == '3') ? 'selected' : ''?> value="3"> model 3 </option>
                    </select>
                </td>
            </tr>
            <tr valign="top" class="el_type" id="title"   <?= ($for_edit['display_type'] == 'title') ? '' : 'style="display: none"' ;?>>
                <th scope="row" class="titledesc">
                    <label >  عنوان </label>
                </th>
                <td class="forminp">
                    <input type="text"  value="<?= ($for_edit['display_type'] == 'title') ? $for_edit['value'] : '';?>" name="title"   placeholder="عنوان">
                </td>
            </tr>
            <tr  valign="top"  class="el_type"  id="image"  <?= ($for_edit['display_type'] == 'image') ? '' : 'style="display: none"' ;?> >
                <th scope="row" class="titledesc">
                    <label dir="rtl">    عکس </label>
                </th>
                <td class="forminp">
                    <input type="hidden" value="<?= $for_edit['value']?>" id="txt_url_item_hami" name="src_val">
                    <img id="div_image_item_hami" class="banner" style="height:75px;cursor: pointer;" src="<?= ($for_edit['value'] != '')? $for_edit['value'] : 'http://placehold.it/150x75'?>">
                </td>
            </tr>
            <tr >
                <th scope="row" class="titledesc">

                </th>
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
                <label > کلید زمینه دلخواه  </label>
            </th>
            <th scope="row" class="">
                <label > نوع زمینه دلخواه  </label>
            </th>
            <th scope="row" class="">
                <label > مدل نمایش  </label>
            </th>
            <th scope="row" class="">
                <label > ویرایش / حذف  </label>
            </th>
        </tr>
		<?php
		$i = 0;
		if(isset($my_cf['wp2pp_cf'])){
			foreach ($my_cf['wp2pp_cf'] as $key){
				$i++;
				?>
                <tr valign="top" class="">
                    <th scope="row" class="">
                        <label > <?= $i; ?>  </label>
                    </th>
                    <th scope="row" class="">
                        <label > <?= $key['meta_key'];?>  </label>
                    </th>
                    <th scope="row" class="">
                        <label > <?= $key['meta_type'];?>  </label>
                    </th>
                    <th scope="row" class="">
                        <label > <?= $key['display_type'];?>  </label>
                    </th>
                    <th scope="row" class="">
                        <a href="<?= $current_url . '&action=edit&field='.$key['meta_key']?>"  > ویرایش </a>
                        |
                        <a href="<?= $current_url . '&action=delete&field='.$key['meta_key']?>" style="color: red;"  >  حذف </a>
                    </th>
                </tr>
				<?php
			}
		}
		?>
        </tbody>
    </table>
</div>
<?php
wp_enqueue_media();
?>
<script>
    jQuery('#display_type').on('change', function() {

        var type_val = (jQuery('#display_type').val());
        //alert(type_val)
        jQuery('.el_type').css('display','none');
        if(type_val == 'select'){
            jQuery('#display').css('display','table-row');
        }
        else if(type_val == 'title'){
            jQuery('#title').css('display','table-row');
        }
        else if(type_val == 'image'){
            jQuery('#image').css('display','table-row');
        }
    });
    var custom_uploader_hami;
    jQuery('#div_image_item_hami').click(function (e) {
        e.preventDefault();
        custom_uploader_hami = wp.media.frames.custom_uploader_hami = wp.media({
            title: 'انتخاب تصویر',
            library: {type: 'image'},
            button: {text: 'انتخاب'},
            multiple: false
        });
        custom_uploader_hami.on('select', function() {
            attachment = custom_uploader_hami.state().get('selection').first().toJSON();
            jQuery('#txt_url_item_hami').val(attachment.url);
            url_image = attachment.url;
            jQuery('#div_image_item_hami').attr("src",url_image);
        });
        custom_uploader_hami.open();
    })
</script>
