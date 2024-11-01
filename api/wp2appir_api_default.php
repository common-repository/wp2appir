<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class wp2appir_api_default
{

	function __construct()
	{
		add_action( 'init',array ( $this , 'wp2appir_regular_all' ));
		add_filter( 'query_vars', array ( $this , 'wp2appir_query_vars' ));
		add_action( 'parse_request', array( $this , 'wp2appir_parse_request' ));
	}
	function wp2appir_regular_all()
	{
		add_rewrite_rule( 'my-api.php$', 'index.php?setting', 'top' );
		add_rewrite_rule( 'my-api.php$', 'index.php?check', 'top' );
		add_rewrite_rule( 'my-api.php$', 'index.php?appost', 'top' );
		add_rewrite_rule( 'my-api.php$', 'index.php?cats', 'top' );
		add_rewrite_rule('', 'index.php?wp_get_a_post', 'top');
		add_rewrite_rule('', 'index.php?mr2app_upload_base64', 'top');
		add_rewrite_rule('', 'index.php?mr2app_login_web_view', 'top');
		add_rewrite_rule('', 'index.php?mr2app_logout_web_view', 'top');
		add_rewrite_rule('', 'index.php?mr2app_upload_base64', 'top');
		add_rewrite_rule('', 'index.php?mr2app_filter_user', 'top');
		//add_rewrite_rule( 'my-api.php$', 'index.php?login', 'top' );
	}
	function wp2appir_query_vars($query_vars)
	{
		$query_vars[] = 'setting';
		$query_vars[] = 'check';
		$query_vars[] = 'appost';
		$query_vars[] = 'wp_get_a_post';
		$query_vars[] = 'cats';
		$query_vars[] = 'mr2app_upload_base64';
		$query_vars[] = 'mr2app_login_web_view';
		$query_vars[] = 'mr2app_logout_web_view';
		$query_vars[] = 'mr2app_filter_user';
		//$query_vars[] = 'login';
		return $query_vars;
	}

	function wp2appir_parse_request(&$wp)
	{
		if ( array_key_exists( 'setting', $wp->query_vars ) ) {
			$this->setting_webservice();
			exit();
		}
		if ( array_key_exists( 'check', $wp->query_vars ) ) {
			$this->check_webservice();
			exit();
		}
		if ( array_key_exists( 'appost', $wp->query_vars ) ) {
			$this->appost_webservice();
			exit();
		}
		if ( array_key_exists( 'cats', $wp->query_vars ) ) {
			$this->cats_webservice();
			exit();
		}
		if ( array_key_exists( 'login', $wp->query_vars ) ) {
			$this->login_webservice();
			exit();
		}
		if ( array_key_exists( 'wp_get_a_post', $wp->query_vars ) ) {
			$this->wp_get_a_post();
			exit();
		}
		if ( array_key_exists( 'mr2app_upload_base64', $wp->query_vars ) ) {
			$this->mr2app_upload_base64();
			exit();
		}
		if ( array_key_exists( 'mr2app_login_web_view', $wp->query_vars ) ) {
			$this->wp2app_login_web_view();
			exit();
		}
		if ( array_key_exists( 'mr2app_logout_web_view', $wp->query_vars ) ) {
			$this->wp2app_logout_web_view();
			exit();
		}
		if ( array_key_exists( 'mr2app_filter_user', $wp->query_vars ) ) {
			$this->mr2app_filter_user();
			exit();
		}
		return;
	}

	function mr2app_filter_user(){
		header('Content-Type: application/json; charset=utf-8');
		ob_start();
		$result = array(
			'status' => false,
			'msg' => 'ورودی اشتباه است.',
			'users' => ''
		);
		if(isset($_POST['in'])) {
			$in = $_POST['in'];
			$slashless = stripcslashes($in);
			$url_json = urldecode($slashless);
			$url_json = str_replace("\\", '', $url_json);
			$json = json_decode($url_json);
			$json->count  = ($json->count != "") ? $json->count : 30;
			$json->page = (int)$json->count * (int)$json->page;
			//we use the meta_query argument to load a set of rules
			$args = array(
				'number'   => $json->count ,
				'offset'           => $json->page,
				'meta_query' => array(
					'relation' => 'AND', // Could be OR, default is AND
				)
			);
			foreach ($json->user_meta as $key => $val){
				if ($val == "") continue;
				//echo $key . '=>' . $val . '<br>';
				$args['meta_query'][] = array(
					'key'     => $key,
					'value'   => $val,
					'compare' => 'LIKE'
				);
			}

			$users = get_users($args);
			if($users){
				$user_data = array();
				$x = array();
				foreach ($users as $user){
					$x['info_user'] = $this->mr2app_get_customer( $user->ID);
					$x['meta'] = $this->mr2app_get_user_meta( $user->ID);
					$user_data[] = $x;
				}
				$result = array(
					'status' => true,
					'msg' => 'جستجو ، موفقیت آمیز بود.',
					'users' => $user_data
				);
			}
			else{
				$result = array(
					'status' => true,
					'msg' => 'کاربری وجود ندارد ...',
					'users' => []
				);
			}
		}
		echo json_encode($result);
		exit();
	}
	public function mr2app_get_customer($user){
		$user = get_user_by( 'id', $user);
		$customer = array(
			"id" => $user->ID,
			"first_name" => get_user_meta($user->ID,'first_name',true),
			"last_name" => get_user_meta($user->ID,'last_name',true),
			"phone" => get_user_meta($user->ID,'billing_phone',true),
			"address" => get_user_meta($user->ID,'billing_address_1',true),
			"city" =>get_user_meta($user->ID,'billing_city',true) ,
			"email" => $user->user_email,
			"state" => get_user_meta($user->ID,'billing_state',true),
			"postcode" => get_user_meta($user->ID,'billing_postcode',true),
		);
		return $customer;
	}
	public function mr2app_get_user_meta($user){
		$user = get_user_by('id' , $user);
		//return $user;
		$args = array(
			'post_type'   => 'woo2app_register',
			'post_status' => 'draft',
			'posts_per_page' => -1,
			'orderby' => 'menu_order',
			'order' => 'ASC'
		);
		$the_query = get_posts( $args );
		$array = array();
		$default_fields  = array( 'user_login'  , 'user_email' , 'user_pass','user_url' ,  'display_name' );
		$array['user_login'] = $user->user_login;
		$array['user_email'] = $user->user_email;
		$array['user_url'] = $user->user_url;
		$array['display_name'] = $user->display_name;
		foreach ($the_query as $f){
			if(in_array($f->post_content ,$default_fields)){
				continue;
			}
			else{
				$array[$f->post_content] = get_user_meta($user->ID,$f->post_content , true);
			}
		}
		return $array;
	}

	function wp2app_login_web_view(){
		header('Content-Type: application/json; charset=utf-8');
		if(isset($_GET["api_key"]) && !empty($_GET['api_key'])){
			//wp_logout();
			$json = base64_decode($_GET['api_key']);
			$json =  (array) json_decode($json);
			$username = isset($json['username']) ? $json['username'] : $json['nameKarbari'];
			$password = isset($json['password']) ? $json['password'] : $json['ramz'];
			if (!empty($username) && !empty($password)) {
				$u = wp_authenticate_username_password(null , $username , $password );

				if(!$u->errors){
					//echo $u->ID;return;
					//wp_set_current_user( $u->ID );
					$creds = array();
					$creds['user_login'] = $username;
					$creds['user_password'] = $password;
					$creds['remember'] = true;

					wp_signon( $creds, false );
					die();
				}
			}
		}
		echo json_encode(array('status' => false));
		die();
	}

	function wp2app_logout_web_view(){
		wp_logout();
		exit();
	}

	function mr2app_upload_base64(){
		header('Content-Type: application/json; charset=utf-8');
		ob_start();
		$result = array(
			'status' => false,
			'msg' => 'ورودی اشتباه است.',
			'url' => ''
		);
		if(isset($_POST['in'])){
			$in = $_POST['in'];
			$slashless = stripcslashes($in);
			$url_json = urldecode($slashless);
			$json =  json_decode($url_json);
			$base64  = $json->base;
			$r = $this->save_image($base64,time());
			if($r){
				$result = array(
					'status' => true,
					'msg' => 'آپلود با موفقیت انجام شد.',
					'url' => $r
				);
			}
			else{
				$result = array(
					'status' => false,
					'msg' => 'خطا در آپلود ...',
					'url' => ''
				);
			}
		}
		//update_user_meta();
		ob_clean();
		echo json_encode($result);
		exit();
	}
	function save_image( $base64_img, $title ) {

		// Upload dir.
		//return $base64_img;
		$upload_dir  = wp_upload_dir();
		$upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;

		$img = str_replace('data:image/jpg;base64,', '', $base64_img);
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace('data:image/gif;base64,', '', $img);
		$img = str_replace('data:image/jpeg;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$decoded          = base64_decode($img) ;
		//$filename         = '.jpg';
		$filename        = $title . '.jpg';
		$file_type       = 'image/jpg';
		$hashed_filename = md5( $filename . microtime() ) . '_' . $filename;

		// Save the image in the uploads directory.
		$upload_file = file_put_contents( $upload_path . $hashed_filename, $decoded );
		if($upload_file){
			return $upload_dir['url'] . '/' . basename( $hashed_filename );
		}
		return false;
//        $attachment = array(
//            'post_mime_type' => $file_type,
//            'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $hashed_filename ) ),
//            'post_content'   => '',
//            'post_status'    => 'inherit',
//            'guid'           => $upload_dir['url'] . '/' . basename( $hashed_filename )
//        );
//
//        $attach_id = wp_insert_attachment( $attachment, $upload_dir['path'] . '/' . $hashed_filename );


	}


	function wp_get_a_post(){
		?>
        <meta charset="<?php bloginfo( 'charset' ); ?>">

		<?php wp_head(); ?>
        <div  style="width: 96%;padding: 0 10px">
			<?php
			$post_id = $_GET['post_id'];
			//echo $post_url = get_permalink($post_id);
			$queried_post = get_post($post_id);
			$content = $queried_post->post_content;
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
			echo $content;
			?>
        </div>

		<?php
	}
	function setting_webservice()
	{
		header('Content-Type: application/json; charset=utf-8');
		ob_start();
		global $wpdb;
		$table_name = $wpdb->prefix . 'hami_set';
		$records = $wpdb->get_results("select * from $table_name");
		foreach ($records as $record) {
			if(in_array($record->name , array('TXT_SPLASHPL'))) {
				continue;
			}
			$array[] = array(
				'name' => $record->name,
				'value' => $record->value );
		}

		$wp2app_setting = get_option('wp2app_setting');
		if(!is_array($wp2app_setting)){
			$wp2app_setting = array();
			$wp2app_setting['meta_like'] = '' ;
			$wp2app_setting['meta_visit'] = '' ;
			$wp2app_setting['display_author'] = '' ;
			$wp2app_setting['share_post'] = 'false' ;
			$wp2app_setting['display_link_webview'] = 'false' ;
			$wp2app_setting['post_date'] = 'false' ;
		}
		$update = get_option('wp2app_update');
		if(!is_array($update)) {
			$update = array();
			$update['android_ver_code'] = '';
			$update['android_update_url'] = '';
			$update['android_update_req'] = false ;
			//$update['ios_ver_code'] = '' ;
			//$update['ios_update_url'] = '' ;
			//$update['ios_update_req'] = false ;
		}
		$wp2app_splash = get_option('wp2app_splash');
		if(!is_array($wp2app_splash)){
			$wp2app_splash = array();
			$wp2app_splash['URL_SPLASH_PIC'] = '' ;
		}
		$array[] = array(
			'name' => 'meta_like',
			'value' => $wp2app_setting['meta_like']);
		$array[] = array(
			'name' => 'txt_post_meta_visit',
			'value' =>$wp2app_setting['meta_visit']);
		$array[] = array(
			'name' => 'display_author',
			'value' => $wp2app_setting['display_author'] );
		$array[] = array(
			'name' => 'share_post',
			'value' => $wp2app_setting['share_post'] );
		$array[] = array(
			'name' => 'display_link_webview',
			'value' => $wp2app_setting['display_link_webview'] ?: 'false' );
		$array[] = array(
			'name' => 'txt_url_default_image',
			'value' => $wp2app_setting['txt_url_default_image'] ?: '' );
		$array[] = array(
			'name' => 'post_date',
			'value' => $wp2app_setting['post_date'] );
		$array[] = array(
			'name' => 'TXT_SPLASHPL',
			'value' => $wp2app_splash['URL_SPLASH_PIC'] );

		$main_page = $this->get_mainpage();
		$slider = $this->get_slider();
		$tapsell = $this->tapsell();
		ob_clean();
		echo json_encode(
			array(
				'app_set' => $array ,
				'wp2app_mainpage' => $main_page ,
				'wp2app_slider' => $slider,
				'tapsell' => $tapsell,
				'update' => $update,
			)
		);
	}
	function tapsell(){
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
		return $tapsell;
	}
	function check_webservice()
	{
		ob_start();
		$in = "";
		if(isset($_GET["in"])){
			$in = $_GET['in'];
		}
        elseif(isset($_POST["in"])){
			$in = $_POST['in'];
		}
		if($in != ""){
			global $wpdb;
			$table_appstatic = $wpdb->prefix . 'hami_appstatic';
			$slashless = stripcslashes($in);
			$url_json = urldecode($slashless);
			$json =  json_decode($url_json);

			$time = current_time('mysql');
			$ip = $_SERVER['REMOTE_ADDR'];
			$wpdb->query( $wpdb->prepare("INSERT INTO $table_appstatic 
               ( apst_time, apst_ip , apst_unifo ) 
               VALUES ( %s, %s, %s )", $time , $ip , $url_json) );
			$hrt_lastmf_cat = get_option('hrt_lastmf_cat');
			$hrt_lastmf_appost = get_option('hrt_lastmf_appost');
			$hrt_lastmf_appsetting = get_option('hrt_lastmf_appsetting');
			$hrt_lastmf_cat = strtotime($hrt_lastmf_cat);
			$hrt_lastmf_appost = strtotime($hrt_lastmf_appost);
			$hrt_lastmf_appsetting = strtotime($hrt_lastmf_appsetting);
			$array = array(
				'hrt_lastmf_cat' => $hrt_lastmf_cat,
				'hrt_lastmf_appost' => $hrt_lastmf_appost,
				'hrt_lastmf_appsetting' => $hrt_lastmf_appsetting
			);

			ob_clean();
			echo json_encode($array);

		}
		else
		{
			echo "not found page";
		}

	}
	function appost_webservice()
	{
		header('Content-Type: application/json; charset=utf-8');
		ob_start();
		global $wpdb;
		$table_posts = $wpdb->prefix . 'posts';
		$table_appost = $wpdb->prefix . 'hami_appost';
		$data = $wpdb->get_results("select * from $table_appost order by order_post asc");
		$array = array('appost' => array());
		foreach ($data as $key ) {
			if($key->post_id == -1)
			{
				$array['appost'][] = array(
					'post_id' => (int) $key->post_id,
					'Type' => $key->type,
					'Title' => $key->title,
					'Metadata' => $key->Metadata,
					'order_post' => $key->order_post,
					'Menu' => $key->Menu,
					'icon' => $key->icon,
					'required_login' => (int) $key->req_login,
				);
			}else{
				$record = get_post($key->post_id);
				$recent_author = get_user_by( 'ID', $record->post_author );
				$content = apply_filters("the_content" , $record->post_content);
				// Get user display name
				$author_display_name = $recent_author->display_name;
				$id =  $record->ID;
				$author = $author_display_name;
				$date = $record->post_date;
				$content = $content;
				$title = $record->post_title;
				$comment_count = $record->comment_count;
				$comment_status = $record->comment_status;
				$order_post = $key->order_post;
				$menu = $key->Menu;
				$icon = $key->icon;
				$type = $key->type;
				$req_login = intval($key->req_login);
				$metadata = $key->Metadata;
				$Post_link = get_permalink($record->ID);
				$content = apply_filters("the_content" , $content );
				if ( has_post_thumbnail( $id ) ) {
					$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
					$pic_post = $large_image_url[0];
				}
				$array['appost'][] = array(
					'post_id' => $id,
					'Post_author' => $author,
					'Post_date' => $date,
					'Post_content' => $content,
					'Post_title' => $title,
					'Comment_count' => $comment_count,
					'Comment_status' => $comment_status,
					'Post_pic' => $pic_post,
					'order_post' => $order_post,
					'Menu' => $menu,
					'icon' => $icon,
					'Type' => $type,
					'Metadata' => $metadata,
					'Post_link' => $Post_link,
					'required_login' => $req_login,
				);
			}
			$pic_post = "";
		}//end foreach $data

		ob_clean();
		echo json_encode($array);
	}
	public function cats_webservice()
	{

		header('Content-Type: application/json; charset=utf-8');
		ob_start();
		$args = get_option('mr2app_post_category');

		if(!is_array($args)) {
			// Get the categories for post and product post types
			$cats = get_terms('category', array(
				'post_type' => array('post'),
				'hide_empty'  => false,
			));
		}
		else{
			$cats = get_terms( array(
				'include' => $args,
				'hide_empty'  => false,
				'orderby'  => 'include',
			) );
		}
		ob_clean();
		echo json_encode(array('cats' => $cats));
		return;

	}

	function get_category_hami( $category, $output = OBJECT, $filter = 'raw', $cat_hami )
	{
		$category = get_term( $category, $cat_hami, $output, $filter );
		if ( is_wp_error( $category ) )
			return $category;

		_make_cat_compat( $category );

		return $category;
	}
	private function get_mainpage(){
		global $wpdb;
		$table_name = $wpdb->prefix . "hami_mainpage order by mp_order asc";
		$rec = $wpdb->get_results("select * from $table_name");
		$array = array();
		foreach ($rec as $key ) {
			if (in_array($key->mp_showtype , array(4,7,8,9))) {
				$slashless = stripcslashes($key->mp_value);
			}
			else if($key->mp_showtype == 5 || $key->mp_showtype == 6){
				$slashless = stripcslashes($key->mp_value);
			}
			else{
				$slashless = $key->mp_value;
			}
			$array[] = array(
				"type" => $key->mp_showtype,
				"action" => $key->mp_type,
				"value" => $slashless,
				"title" => $key->mp_title,
				"pic" => $key->mp_pic,
				"sort" => $key->mp_pic,
				"order" => $key->mp_order
			);
		}
		return $array;
	}
	private function get_slider(){
		global $wpdb;
		$table_name = $wpdb->prefix . "hami_slider";
		$rec = $wpdb->get_results("select * from $table_name");
		$array = array();
		foreach ($rec as $key ) {
			$array[] = array(
				"action" => $key->sl_type,
				"value" => $key->sl_value,
				"title" => $key->sl_title,
				"pic" => $key->sl_pic
			);
		}
		return $array;
	}
}