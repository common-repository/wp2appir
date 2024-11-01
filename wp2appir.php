<?php
/*
Plugin Name: WP2APP
Plugin URI: http://mr2app.com
Description: اپلیکیشن ساز وردپرس
Version: 2.6.2
Author: مستر 2 اپ
Author URI: http://mr2app.com
Text Domain: Mr2app
*/

if (!defined( 'ABSPATH' )) exit;

define('WP2APPIR_VERSION' , "2.6.2");
define( 'WP2APPIR_PATH' , plugin_dir_path( __FILE__ ));
define('WP2APPIR_URL', plugin_dir_url(__FILE__));
define('WP2APPIR_CSS_URL', trailingslashit(WP2APPIR_URL.'assets/css'));
define('WP2APPIR_JS_URL', trailingslashit(WP2APPIR_URL.'assets/js'));

//error_reporting(E_ALL);
ini_set('display_errors', 0);


include_once( 'assets/other/backup_hami_plugins.php');
include_once( 'assets/other/icons_div.php') ;


add_action('admin_init', 'wp2appir_config' );
function wp2appir_config() {
	include_once( 'config/wp2appir_config_tables.php') ;
	$wp2appir_config_tables = new wp2appir_config_tables();
	include_once( 'config/wp2appir_config_data.php') ;
	$wp2appir_config_data = new wp2appir_config_data();
	update_option("WP2APPIR_VERSION" , WP2APPIR_VERSION);
}

add_action( 'admin_menu', 'wp2appir_config_menu' );
function wp2appir_config_menu(){
	include_once( 'config/wp2appir_config_menu.php') ;
	$wp2appir_config_menu = new wp2appir_config_menu();
}

add_action( 'init', 'wp2appir_init' );

function wp2appir_init() {
	include_once( 'api/wp2appir_api_default.php') ;
	$wp2appir_api_default = new wp2appir_api_default();
	include_once( 'api/wp2appir_api_primery.php') ;
	$wp2appir_api_default = new wp2appir_api_primery();

	include_once( 'api/api_users_hami.php') ;
	$user_login = new api_webservices_hami_user_wp2app();

	include_once( 'api/WP2APP_Post.php' );
	include_once( 'api/WP2APP_Route.php' );
	new WP2APP_Route();

	include_once( 'config/wp2appir_custom_hook.php') ;
	$wp2appir_custom_hook = new wp2appir_custom_hook();

	include_once( 'config/wp2appir_feed.php');
	$wp2appir_feed = new wp2appir_feed();

	include_once( 'config/wp2appir_metabox.php') ;
	$wp2appir_metabox = new wp2appir_metabox_notif();

	include_once( 'ajax/wp2appir_ajax.php') ;
	$wp2appir_ajax = new wp2appir_ajax();
	include_once( 'ajax/wp2appir_ajax_insert.php') ;
	$wp2appir_ajax_insert = new wp2appir_ajax_insert();
	include_once( 'ajax/wp2appir_ajax_appost.php') ;
	$wp2appir_ajax_appost = new wp2appir_ajax_appost();


}

register_activation_hook( __FILE__ ,  'activation_wp2app_custom_register');
function activation_wp2app_custom_register(){
	$wp2app_setting = get_option('wp2app_setting');
	$wp2app_setting['meta_like'] = $wp2app_setting['meta_like'] ? $wp2app_setting['meta_like'] : '';
	$wp2app_setting['meta_visit'] = $wp2app_setting['meta_visit'] ? $wp2app_setting['meta_visit'] : '';
	$wp2app_setting['display_author'] = $wp2app_setting['display_author'] ? $wp2app_setting['display_author'] : '';
	$wp2app_setting['user_score'] = $wp2app_setting['user_score'] ? $wp2app_setting['user_score'] : '';
	$wp2app_setting['share_post'] = $wp2app_setting['share_post'] ? $wp2app_setting['share_post'] : 'false';
	$wp2app_setting['display_link_webview'] = $wp2app_setting['display_link_webview'] ? $wp2app_setting['display_link_webview'] : 'false';
	$wp2app_setting['post_date'] = $wp2app_setting['post_date'] ? $wp2app_setting['post_date'] : 'false';
	update_option('wp2app_setting',$wp2app_setting);

	$default_fields = array();
	$default_fields [] = array( 'name' => 'user_login' , 'title' => 'نام کاربری','order' => 1);
	$default_fields [] = array( 'name' => 'user_email' , 'title' => 'ایمیل','order' => 3);
	$default_fields [] = array( 'name' => 'user_pass' , 'title' => 'رمز عبور','order' => 4);
	$default_fields [] = array( 'name' => 'user_url' , 'title' => 'آدرس سایت','order' => 5);
	$default_fields [] = array( 'name' => 'display_name' , 'title' => 'نام نمایشی','order' => 6);
	$default_fields [] = array( 'name' => 'first_name' , 'title' => 'نام','order' => 7);
	$default_fields [] = array( 'name' => 'last_name' , 'title' => 'نام خانوادگی','order' => 8);
	$default_fields [] = array( 'name' => 'description' , 'title' => 'توضیحات','order' => 9);

	$array_name_new = array('user_login','user_email','user_pass','user_url','display_name','first_name','last_name','description');
	$args      = array(
		'post_type'   => 'woo2app_register',
		'post_status' => 'draft',
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC',
	);
	$the_query = get_posts( $args );
	$array_name_old = array();
	foreach ($the_query as $p){
		$array_name_old[] = $p->post_content;
	}

	$result = array_diff($array_name_new,$array_name_old);
	foreach ($default_fields as $f){
		if(in_array($f['name'] , $result)) {
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
        update_user_meta( $user_id, 'inviter_code', $_POST["inviter_code"] );
	}
}


add_action('admin_menu', 'add_custom_link_into_appearnace_menu');
function add_custom_link_into_appearnace_menu() {
	global $submenu;
	$permalink = 'https://mr2app.com/blog/category/mr2app-leran/';
	$submenu['wp2appir/pages/wp2appir_theme_new.php'][] = array( 'راهنما', 'manage_options', $permalink );
}

require_once  "register/class_custom_register.php";
$class_custom_register_wp2app = new class_custom_register_WP2APP();

require_once  "sale_meta/mr2app_sale_meta.php";

function get_tags_post(){
	get_tags();
}

function get_posts_wp2app(){

	$post_type = get_option('mr2app_post_type');
	if(!is_array($post_type)) $post_type = array('post');
	$args = array(
		'numberposts' => 20,
		'post_type' =>  $post_type,
	);
	return $posts = get_posts( $args );
}

//********************************************************************

function get_cat_wp2app(){

	$args = get_option('mr2app_post_category');
	if(!is_array($args)) {
		$args = array('category');
		return get_terms($args);
	}
	return get_terms( array(
		'include' => $args,
		'hide_empty'  => false,
		'orderby'  => 'include',
	) );

}


function get_tags_wp2app(){

	$args = array();
	$post_types = get_option('mr2app_post_type');
	if(!is_array($post_types)) $args = array('post_tag');
	//$post_types = array( 'product');
	foreach ( $post_types as $t ){
		$args[] = $t.'_tag';
	}
	//return $args;
	return get_terms($args);

}

//*****************************************************************************************

function get_category_hami( $category, $output = OBJECT, $filter = 'raw', $cat_hami )
{
	$category = get_term( $category, $cat_hami, $output, $filter );
	if ( is_wp_error( $category ) )
		return $category;

	_make_cat_compat( $category );

	return $category;
}


//global $wp_roles;
if ( ! isset( $wp_roles ) )
    $wp_roles = new WP_Roles();

$adm = $wp_roles->get_role('subscriber');
////Adding a 'new_role' with all admin caps
$wp_roles->add_role('marketer', 'بازاریاب', $adm->capabilities);

add_action( 'edit_user_profile', 'wp2app_tm_additional_profile_fields_marketer' );
function wp2app_tm_additional_profile_fields_marketer($user){

//var_dump($users);
    $x = get_user_meta($user->ID , 'inviter_code' , true);
    if($user->roles[0] == 'marketer') :
        ?>
        <table class="form-table">
            <tr>
                <th><label>  کد بازاریابی </label></th>
                <td>
                    <input type="text" id="inviter_code" name="inviter_code" class="regular-text" value="<?= $x; ?>">
                </td>
            </tr>
        </table>
    <?php
    endif;
}

function wp2app_send_notif($description , $sound , $action , $value) {
    $app_id = get_option('app_id');
    $api_id = get_option('api_id');
	update_option('testNotif1' , $description . '_' . $sound . '_' . $action . '_' . $value);
    $content = array(
        "en" => $description
    );
    if($sound == 2){ //mute notifaction
        $fields = array(
            'app_id' => $app_id,
            'included_segments' => array('All'),
            'data' => array(
                "action" => $action,
                'value' => $value,
                'title' => get_option('blogname'),
                'alert' => get_option('blogname'),
                'time' => time()
            ),
            'contents' =>  $content,
            'android_sound' => 'mute',
            'ios_sound' => 'mute.wav'
        );
    }
    else{
        $fields = array(
            'app_id' => $app_id,
            'included_segments' => array('All'),
            'data' => array(
                "action" => $action,
                'value' => $value,
                'title' =>  get_option('blogname'),
                'alert' => get_option('blogname'),
                'time' => time()),
            'contents' =>  $content,
        );
    }
    $fields = json_encode($fields);
    //return $app->wp->one_app_id;
    $ch1 = curl_init();
    curl_setopt($ch1, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
        "Authorization: Basic  ". $api_id  ));
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch1, CURLOPT_HEADER, FALSE);
    curl_setopt($ch1, CURLOPT_POST, TRUE);
    curl_setopt($ch1, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = curl_exec($ch1);
    curl_close($ch1);
    //var_dump($response);
    return $response;
}

function wp2app_send_notif_mr2app($description , $sound , $action , $value){


    $email = get_option('email_WOO2APP');
    $pass = get_option('password_WOO2APP');
    $appid = get_option('appid_WOO2APP');
    if( $email != "" && $pass != "" && $appid != "" ){
        if($sound == 1){
            $data = array(
                "sound" => 1,
                "title" => "",
                "description" => $description,
                "action" => $action,
                "value" => $value
            );
            $data = json_encode($data);
            $data = array(
                "data" => $data
            );
        }
        elseif($sound == 2){
            $data = array(
                "sound" => 2,
                "title" => "",
                "description" => $description,
                "action" => $action,
                "value" => $value
            );
            $data = json_encode($data);
            $data = array(
                "data" => $data
            );
        }


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://panel.wp2app.ir/panel/api/send_notification2all?email=$email&password=$pass&app_id=$appid");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"	));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}


