<?php

require_once  "class_sale_meta.php";

$class_sale_meta = new class_sale_meta_wp2app();
add_action('add_meta_boxes', 'wp2app_meta_box_vip_post');
add_action('save_post', 'wp2app_meta_box_vip_save_postdata');
add_action( 'edit_user_profile', 'wp2app_meta_sale_box_vip_time' );



function wp2app_meta_box_vip_post() {

	$screens = ['post', 'product'];
	foreach ($screens as $screen) {
		add_meta_box(
			'mr2app_meta_box_vip_post',           // Unique ID
			'فروش زمینه دلخواه',  // Box title
			'wp2app_meta_box_vip_html',  // Content callback, must be of type callable
			$screen                   // Post type
		);
	}
}

function wp2app_meta_box_vip_html($post) {
	$metas = get_custom_fields_for_post_meta($post->ID);
	if(!is_array($metas)){
        $metas = array();
    }
	$meta = get_post_meta($post->ID, 'mr2app_post_option', true);
	if(isset($meta['meta_sale'])){
        $meta_sale = $meta['meta_sale'];
    }

	foreach ($metas as $m){
		$this_meta = $meta_sale[$m];
        $vip = $this_meta['vip'] ? (int)$this_meta['vip'] : 0;
		$single = $this_meta['single'] ? (int)$this_meta['single'] : 0;
		$price = $this_meta['price'] ? (int)$this_meta['price'] : 0;
		?>
        <p>
            <input type="hidden" name="meta_sale" value="1">
			<strong> نام زمینه دلخواه : <?= $m; ?> </strong>
        </p>
        <p>
            <label >  Vip  </label>
            <input name="<?= $m; ?>[vip]"  <?= checked($vip)?> type="checkbox"  />
            <label >  فروش تکی  </label>
            <input name="<?= $m; ?>[single]"  <?= checked($single)?> type="checkbox"  />
            <input type="number"  class="form-input-tip" style="width: 230px" name="<?= $m; ?>[price]" value="<?= $price;?>"  placeholder="قیمت فروش تکی را وارد کنید" />
        </p>
        <hr>
		<?php
	}
	?>
    <a target="_blank" href="<?= admin_url().'admin.php?page=wp2appir/pages/hami_manager_post_types.php&tab=3'?>" class="button button-primary"> اضافه کنید </a>
    <?php
}

function get_custom_fields_for_post_meta($post_ID){
	$wp2app_cf = get_option("wp2app_custom_fields");
	if (!is_null($wp2app_cf) || $wp2app_cf != "") {
		if(isset($wp2app_cf["wp2pp_cf"])){
		    $wp2app_cf = $wp2app_cf["wp2pp_cf"];
        }
		else{
            $array_cf = array();
        }
		foreach ($wp2app_cf as $key) {
			$value = get_post_meta($post_ID,$key["meta_key"],true);
			$for_edit['meta_type'] = '';
			$for_edit['meta_key'] = '';
			$for_edit['display_type'] = 'title';
			$for_edit['value'] = '';
			if( strlen(trim($value)) > 0 ){
				$array_cf[] = $key['meta_key'];
			}
		}
	}
	return $array_cf;
}

function wp2app_meta_box_vip_save_postdata($post_id) {

	if (array_key_exists('meta_sale', $_POST)) {
		$metas = get_custom_fields_for_post_meta($post_id);
		$meta = get_post_meta($post_id, 'mr2app_post_option', true);
		if($meta == "") $meta = array();
        //var_dump($metas);
		foreach ($metas as $m){
			$meta['meta_sale'][$m] = array(
			    'vip' => (isset($_POST[$m]['vip']) && $_POST[$m]['vip'] == 'on') ? 1 : 0,
			    'single' => (isset($_POST[$m]['single']) && $_POST[$m]['single'] == 'on') ? 1 : 0,
			    'price' => (int)$_POST[$m]['price'] ,
            );
		}
		update_post_meta(
			$post_id,
			'mr2app_post_option',
			$meta
		);
	}
}

function wp2app_meta_sale_box_vip_time($user){
	$vip_time = get_user_meta($user->ID,'_vip_time',true);
	$time = 0;
	if($vip_time < time()) $time = 0;
	else{
		$time = (int)$vip_time - time();
		$time = (int)($time / (24*60*60));
	}
	?>
    <table class="form-table">
        <tr>
            <th><label >  مدت زمان اشتراک </label>
            </th>
            <td>
                <input type="text" id="vip_time" name="_vip_time" class="regular-text" value="<?= $time;?>">
            </td>
        </tr>
    </table>
	<?php
}

// Hook is used to save custom fields that have been added to the WordPress profile page (if not current user)
add_action( 'edit_user_profile_update', 'wp2app_update_extra_profile_meta_sale' );

function wp2app_update_extra_profile_meta_sale( $user_id ) {
	if ( current_user_can( 'edit_user', $user_id ) ){
		$time = 0;
		if($_POST['_vip_time'] < 1){
			$time = 0;
		}
		else{
			$time = (strtotime('tomorrow') + (int) $_POST['_vip_time'] * (24*60*60) - 1);
		}
		update_user_meta( $user_id, '_vip_time', $time );
	}
}
