<?php



require_once  "class_custom_register.php";

$class_custom_register = new class_custom_register_WP2APP();

register_activation_hook( __FILE__ ,  'activation_wp2app_custom_register');

function activation_wp2app_custom_register(){


	$default_fields = array();
	$default_fields [] = array( 'name' => 'user_login' , 'title' => 'نام کاربری','order' => 1);
	$default_fields [] = array( 'name' => 'user_email' , 'title' => 'ایمیل','order' => 3);
	$default_fields [] = array( 'name' => 'user_pass' , 'title' => 'رمز عبور','order' => 4);
	$default_fields [] = array( 'name' => 'user_url' , 'title' => 'آدرس سایت','order' => 5);
	$default_fields [] = array( 'name' => 'display_name' , 'title' => 'نام نمایشی','order' => 6);
	$default_fields [] = array( 'name' => 'first_name' , 'title' => 'نام','order' => 7);
	$default_fields [] = array( 'name' => 'last_name' , 'title' => 'نام خانوادگی','order' => 8);
	$default_fields [] = array( 'name' => 'description' , 'title' => 'توضیحات','order' => 9);
	$default_fields [] = array( 'name' => 'billing_company' , 'title' => 'شرکت','order' => 11);
	$default_fields [] = array( 'name' => 'billing_address_1' , 'title' => 'آدرس 1','order' => 12);
	$default_fields [] = array( 'name' => 'billing_address_2' , 'title' => 'آدرس 2','order' => 13);
	$default_fields [] = array( 'name' => 'billing_city' , 'title' => 'شهر','order' => 14);
	$default_fields [] = array( 'name' => 'billing_state' , 'title' => 'استان','order' => 15);
	$default_fields [] = array( 'name' => 'billing_postcode' , 'title' => 'کدپستی','order' => 16);
	$default_fields [] = array( 'name' => 'billing_country' , 'title' => 'کشور','order' => 17);
	$default_fields [] = array( 'name' => 'billing_email' , 'title' => 'ایمیل','order' => 18);
	$default_fields [] = array( 'name' => 'billing_phone' , 'title' => 'تلفن','order' => 19);

	foreach ($default_fields as $f){

		$array = array(
			'post_title'    => $f['title'],
			'post_content' => $f['name'],
			'post_type'     => 'woo2app_register',
			'post_status'   => 'draft',
			'menu_order' => $f['order'],
		);
		$post = wp_insert_post( $array );
		add_post_meta($post,'default','');
		add_post_meta($post,'required',1);
		add_post_meta($post,'active',1);
		add_post_meta($post,'display_edit',1);
		add_post_meta($post,'display_register',1);
		add_post_meta($post,'values','');
		add_post_meta($post,'type','text');
	}
	$array = array(
		'enable' => 0,
		'field' => '',
		'panel' => '',
		'number' => '',
		'username'=> '',
		'password' => ''
	);
	if(!get_option('mr2app_sms')){
		add_option('mr2app_sms',$array);
	}

}



function wp2app_tm_additional_profile_fields( $user ) {

	$default_fields  = array( 'user_login'  , 'user_email' , 'user_pass','user_url' ,  'display_name' ,
		'first_name' , 'last_name' , 'description'  ,'billing_company','billing_address_1',
		'billing_address_2','billing_city','billing_state','billing_postcode','billing_country','billing_email','billing_phone');
	$args      = array(
		'post_type'   => 'woo2app_register',
		'post_status' => 'draft',
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC'
	);
	$the_query = get_posts( $args );
	?>
    <table class="form-table">
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1grFb5dYPNOQ5FaDHMkZLmVz3s3OerbI"></script>
		<?php
		foreach ($the_query as $f){
			if(in_array($f->post_content,$default_fields)){
				continue;
			}
			$x = get_user_meta($user->ID,$f->post_content , true);
			if(get_post_meta($f->ID , 'type',true) == 'map'){
			    $x = explode(',',$x);
			    if($x[0]){ $lat = $x[0];} else{ $lat = '32.2972692';}
			    if($x[1]){ $lng = $x[1];} else{ $lng = '54.582283';}
				?>
                <tr>
                    <th><label >  <?= $f->post_title;?></label></th>
                    <td>
                        <div id="map-canvas_<?= $f->ID;?>" style="width: 300px;height: 150px"></div><!-- #map-canvas -->
                        <script type="text/javascript">
                            google.maps.event.addDomListener( window, 'load', gmaps_results_initialize );
                            var map;
                            var markers = [];
                            function gmaps_results_initialize() {
                                map = new google.maps.Map( document.getElementById( 'map-canvas_' + <?= $f->ID;?> ), {
                                    zoom:           13,
                                    center:         new google.maps.LatLng( <?= $lat ;?>, <?= $lng ;?> ),
                                });
                                var  marker = new google.maps.Marker({
                                    position: new google.maps.LatLng( <?= $lat ;?>, <?= $lng ;?> ),
                                    map:      map,
                                    animation: google.maps.Animation.BOUNCE
                                });
                            }
                        </script>
                    </td>
                </tr>
				<?php
			}
			else{
				?>
                <tr>
                    <th><label >  <?= $f->post_title;?></label></th>
                    <td>
                        <input type="text" id="<?= $f->post_content; ?>" name="<?= $f->post_content; ?>" class="regular-text" value="<?= $x; ?>">
                    </td>
                </tr>
				<?php
			}
		}
		?>
    </table>
	<?php
}

add_action( 'edit_user_profile', 'wp2app_tm_additional_profile_fields' );

// Hook is used to save custom fields that have been added to the WordPress profile page (if not current user)
add_action( 'edit_user_profile_update', 'wp2app_update_extra_profile_fields' );

function wp2app_update_extra_profile_fields( $user_id ) {
	if ( current_user_can( 'edit_user', $user_id ) ){
		$default_fields  = array( 'user_login'  , 'user_email' , 'user_pass','user_url' ,  'display_name' ,
			'first_name' , 'last_name' , 'description'  ,'billing_company','billing_address_1',
			'billing_address_2','billing_city','billing_state','billing_postcode','billing_country','billing_email','billing_phone');
		$args      = array(
			'post_type'   => 'woo2app_register',
			'post_status' => 'draft',
			'posts_per_page' => -1,
			'orderby' => 'menu_order',
			'order' => 'ASC'
		);
		$the_query = get_posts( $args );
		foreach ($the_query as $f){
			update_user_meta( $user_id, $f->post_content, $_POST["$f->post_content"] );
		}
	}
}
