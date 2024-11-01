<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class wp2appir_api_primery
{
	function __construct() {
		add_action( 'init',array ( $this , 'wp2appir_regular_all' ));
		add_filter( 'query_vars', array ( $this , 'wp2appir_query_vars' ));
		add_action( 'parse_request', array( $this , 'wp2appir_parse_request' ));
	}

	function wp2appir_regular_all()
	{
		add_rewrite_rule( 'my-api.php$', 'index.php?gpost', 'top' );
		add_rewrite_rule( 'my-api.php$', 'index.php?gpostcat', 'top' );
		add_rewrite_rule( 'my-api.php$', 'index.php?search', 'top' );
		add_rewrite_rule( 'my-api.php$', 'index.php?apost', 'top' );
		add_rewrite_rule( 'my-api.php$', 'index.php?gcomments', 'top' );
		add_rewrite_rule( 'my-api.php$', 'index.php?scomments', 'top' );
		add_rewrite_rule( 'my-api.php$', 'index.php?wp2app_version', 'top' );
		add_rewrite_rule( 'my-api.php$', 'index.php?add_to_visit', 'top' );
	}

	function wp2appir_query_vars($query_vars)
	{
		$query_vars[] = 'gpost';
		$query_vars[] = 'gpostcat';
		$query_vars[] = 'search';
		$query_vars[] = 'apost';
		$query_vars[] = 'scomments';
		$query_vars[] = 'gcomments';
		$query_vars[] = 'wp2app_version';
		$query_vars[] = 'add_to_visit';
		return $query_vars;
	}

	function wp2appir_parse_request(&$wp)
	{
		if ( array_key_exists( 'gpost', $wp->query_vars ) ) {
			$this->gpost_webservice();
			exit();
		}
		if ( array_key_exists( 'gpostcat', $wp->query_vars ) ) {
			$this->gpostcat_webservice();
			exit();
		}
		if ( array_key_exists( 'search', $wp->query_vars ) ) {
			$this->search_webservice();
			exit();
		}
		if ( array_key_exists( 'apost', $wp->query_vars ) ) {
			$this->apost_webservice();
			exit();
		}
		if ( array_key_exists( 'gcomments', $wp->query_vars ) ) {
			$this->gcomments_webservice();
			exit();
		}
		if ( array_key_exists( 'scomments', $wp->query_vars ) ) {
			$this->scomments_webservice();
			exit();
		}

		if ( array_key_exists( 'wp2app_version', $wp->query_vars ) ) {
			$this->wp2app_version();
			exit();
		}
		if ( array_key_exists( 'add_to_visit', $wp->query_vars ) ) {
			$this->add_to_visit();
			exit();
		}
		return;
	}

	function wp2app_version(){
		echo 'WP2APPIR_VERSION : ' . WP2APPIR_VERSION;
		return;
	}

	function add_to_visit(){
		header('Content-Type: application/json; charset=utf-8');
		ob_start();
		$array = array();
		if(!empty($_GET["in"])) {
			$in = $_GET['in'];
			$slashless = stripcslashes($in);
			$url_json = urldecode($slashless);
			$json = (array)  json_decode($url_json);
			$post_id = $json['post_id'];
			if($post = get_post($post_id)){
				global $wpdb;
				$table_name = $wpdb->prefix . 'hami_set';
				if($q = $wpdb->query("select * from $table_name WHERE name = 'txt_post_meta_visit'")){
					$records = $wpdb->get_results("select * from $table_name WHERE name = 'txt_post_meta_visit'");
					$meta_visit = ($records[0]->value);
					$old_visit = (int)get_post_meta($post_id,$meta_visit, true);
					update_post_meta($post_id ,$meta_visit,$old_visit + 1);
					wp_send_json_success(array('visit' => $old_visit + 1));
				}
			}
		}
		ob_clean();
		wp_send_json_error();
	}
	function get_bazdid_post($post_id){
		global $wpdb;
		$table_name = $wpdb->prefix . 'hami_set';
		if($q = $wpdb->query("select * from $table_name WHERE name = 'txt_post_meta_visit'")){
			$records = $wpdb->get_results("select * from $table_name WHERE name = 'txt_post_meta_visit'");
			$meta_visit = ($records[0]->value);
			$old_visit = (int)get_post_meta($post_id,$meta_visit, true);
			return $old_visit;
		}
		return -1;
	}

	function gpost_webservice()
	{
		header('Content-Type: application/json; charset=utf-8');
		ob_start();
		if(!empty($_GET["in"]))
		{
			$in = $_GET['in'];
			$slashless = stripcslashes($in);
			$url_json = urldecode($slashless);
			$json = (array)  json_decode($url_json);
			$count = (int)$json["Count"];
			$last_count =(int)$json["LastCount"];
			$cat = "";
			$cats = get_option('mr2app_post_category');
			if(is_array($cats) && !empty($cats)){
				$cat = get_option('mr2app_post_category');
			}
			$args = array(
				's' => '',
				'include' => '',
				'posts_per_page'   => $count ,
				'offset'           => $last_count,
				'category'         => $cat,
				'post_type'        => $this->wp2app_post_type(),
				'post_status'      => 'publish',
				'suppress_filters' => true
			);
			$args['tax_query'] = array( 'relation' => 'OR' );
			foreach ($this->wp2app_post_type() as $key) {
				if(!(get_object_taxonomies($key))) continue;
				foreach (get_object_taxonomies($key) as $k){
					$args['tax_query'][] = array(
						'taxonomy' =>  $k,
						'field'    => 'term_id',
						'terms'    => $cat,
					);
				}
			}
			//echo json_encode($args);return;
			$i = 1;
			$array = array('posts' =>array());
			$posts = get_posts( $args );
			foreach($posts as $_post){
				if(1){
					if ( has_post_thumbnail( $_post->ID ) ) {
						$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $_post->ID ), 'large' );
						$pic_post = $large_image_url[0];
					}
					$array_cf = $this->get_custom_fields($_post->ID);

					$cat_post = $this->wp_get_post_categories_hami($_post->ID , $args , "category");
					$cats = "";
					foreach($cat_post as $cat){
						$cats = $cats.$cat . ",";
					}
					$recent_author = get_user_by( 'ID', $_post->post_author );
					$author_display_name = $recent_author->display_name;
					$content = apply_filters("the_content" , $_post->post_content);
					$array['posts'][] = array(
						'id' => $_post->ID,
						'Post_author' => $author_display_name ,
						'Post_date' => $_post->post_date,
						'Post_content' => $content,
						'Post_title' => $_post->post_title,
						'Comment_count' => $_post->comment_count,
						'Comment_status' => $_post->comment_status,
						'Post_pic' => $pic_post,
						'cat' => $cats,
						'Post_link' => get_permalink($_post->ID),
						'bazdid_post' => $this->get_bazdid_post($_post->ID),
						'Custom_fields' => $array_cf,
						'mr2app_post_option' => $this->mr2app_post_option($_post->ID),
					);
				}
				$i++;
				$cats = "";
				$pic_post = "";
				$arr = "";
				$array_cf = "";
			}
			ob_clean();
			echo json_encode($array);
		}
		else
		{
			echo "not found page";
		}
	}
	public function wp2app_post_type(){
		$post_types = get_option('mr2app_post_type');
		if(!is_array($post_types) || empty($post_types)) return '';
		return $post_types;
	}

	function  mr2app_post_option($post_id){
		$x = get_post_meta($post_id , 'mr2app_post_option',true);
		return $x ? $x : array();
	}

	function  wp2app_get_post_typs($post_types){
		$ar = json_decode($post_types,true);
		$array_types = array();
		if ($post_types != "") {
			foreach ($ar as $key) {
				foreach ($key as $k => $v) {
					if($k == 'product') continue;
					$array_types[] = $k;
				}
			}
		}
		else{
			$array_types = array( 'post' );
		}
		return $array_types;
	}

	function calc_args($cats = "" , $num , $search = ''){

		$args = array(
			's' => $search,
			'numberposts'   => $num ,
			'offset'           => $json->page,
			'category'         => $json->filter->cat_id,
			'orderby'          => ($json->filter->sort == 'newest' || $json->filter->sort == "") ? 'date' : 'meta_value_num',
			'order'            => 'desc',
			'tag'              => $json->filter->tag,
			'post_type'        => WP2APP_Post::wp2app_post_type(),
			'post_status'      => 'publish',
			'suppress_filters' => true
		);

	}

	function get_custom_fields($post_ID){
		$wp2app_cf = get_option("wp2app_custom_fields");
		$array_cf = array();
		if (!is_null($wp2app_cf) || $wp2app_cf != "") {
			$wp2app_cf = $wp2app_cf["wp2pp_cf"];
			foreach ($wp2app_cf as $key) {
				$value = get_post_meta($post_ID,$key["meta_key"],true);
				$for_edit['meta_type'] = '';
				$for_edit['meta_key'] = '';
				$for_edit['display_type'] = 'title';
				$for_edit['value'] = '';
				if( strlen(trim($value)) > 0 ){
					$array_cf[] = array(
						"value" => $value ,
						"label" => $key['value'],
						"meta_key" => $key['meta_key'],
						"meta_type" => $key['meta_type'],
						"display_type" => $key['display_type'],
					);
				}
			}
		}
		return $array_cf;
	}

	function gpostcat_webservice() {
		header('Content-Type: application/json; charset=utf-8');
		ob_start();
		if(!empty($_GET["in"]))
		{
			$in = $_GET['in'];
			$slashless = stripcslashes($in);
			$url_json = urldecode($slashless);
			$json = (array)  json_decode($url_json);
			$cat = (string) $json["Cat"];
			$count =(int) $json["Count"];
			$last_count =(int) $json["LastCount"];
			$num = $count + $last_count;
			$cats1 = explode(",",$cat);
//			$post_types = get_option("wp2app_post_types");
//			$ar = json_decode($post_types,true);
			//$post_types = $this->wp2app_get_post_typs($post_types);
			$args = array(
				's' => '',
				'include' => '',
				'posts_per_page'   => $count ,
				'offset'           => $last_count,
				'category'         => $cats1,
				'orderby'          => 'date',
				'order'            => 'desc',
				'post_type'        => $this->wp2app_post_type(),
				'post_status'      => 'publish',
				'suppress_filters' => true
			);
			$args['tax_query'] = array( 'relation' => 'OR' );
			foreach ($this->wp2app_post_type() as $key) {
				if(!(get_object_taxonomies($key))) continue;
				foreach (get_object_taxonomies($key) as $k){
					$args['tax_query'][] = array(
						'taxonomy' =>  $k,
						'field'    => 'term_id',
						'terms'    => $cat,
					);
				}
			}
			//var_dump($args);return;
			$posts = get_posts( $args );
			$i = 1;
			//-------------------------------------
			foreach($posts as $_post){

				if(1){
					$pic_post = "";
					if ( has_post_thumbnail( $_post->ID ) ) {
						$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $_post->ID ), 'large' );
						$pic_post = $large_image_url[0];
					}

					$cat_post = $this->wp_get_post_categories_hami($_post->ID , $args , "category");
					$cats = "";
					foreach($cat_post as $cat){
						$cats = $cats.$cat . ",";
					}
					$array_cf = $this->get_custom_fields($_post->ID);

					$recent_author = get_user_by( 'ID',  $_post->post_author );
					$author_display_name = $recent_author->display_name;
					$content = apply_filters("the_content" ,$_post->post_content);
					$array['posts'][] = array(
						'id' => $_post->ID,
						'Post_author' => $author_display_name,
						'Post_date' => $_post->post_date,
						'Post_content' => $content,
						'Post_title' => $_post->post_title,
						'Comment_count' => $_post->comment_count,
						'Comment_status' => $_post->comment_status,
						'Post_pic' => $pic_post,
						'cat' => $cats,
						'bazdid_post' => $this->get_bazdid_post($_post->ID),
						'Post_link' => get_permalink($_post->ID),
						'Custom_fields' => $array_cf,
						'mr2app_post_option' => $this->mr2app_post_option($_post->ID),
					);
				}
				$i++;
				$cats="";
				$pic_post="";
				$array_cf = "";
			}
			ob_clean();
			echo json_encode($array);
		}
		else
		{
			echo "not found page";
		}
	}

	function Search_webservice() {
		header('Content-Type: application/json; charset=utf-8');
		ob_start();
		if(!empty($_GET["in"]))
		{
			$in = $_GET['in'];
			$slashless = stripcslashes($in);
			$url_json = urldecode($slashless);
			$json = (array)  json_decode($url_json);
			$search =  $json["search"];
			//$post_types = $this->wp2app_get_post_typs($post_types);
			$args = array(
				's' => $search,
				'numberposts'   => -1 ,
				'orderby'          => '',
				'order'            => 'desc',
				'post_type'        => $this->wp2app_post_type(),
				'post_status'      => 'publish',
				'suppress_filters' => true
			);
			$posts = get_posts( $args );
			if(!empty($posts)){
				$i = 1;
				foreach($posts as $_post){
					if ( has_post_thumbnail( $_post->ID ) ) {
						$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $_post->ID ), 'large' );
						$pic_post = $large_image_url[0];
					}
					if ($post_types != "") {
						foreach ($ar as $key) {
							foreach ($key as $k => $v) {
								foreach ($v as $x) {
									if($_post->post_type == $k){
										$cat_post = $this->wp_get_post_categories_hami($_post->ID , $args , $x);
									}
								}
							}
						}
					}else{
						$cat_post = $this->wp_get_post_categories_hami($_post->ID , $args , "category");
					}
					$cats = "";
					foreach($cat_post as $cat){
						$cats = $cats.$cat . ",";
					}

					$array_cf = $this->get_custom_fields($_post->ID);
					$recent_author = get_user_by( 'ID',  $_post->post_author );
					$author_display_name = $recent_author->display_name;
					$content = apply_filters("the_content" , $_post->post_content);
					$array['posts'][] = array(
						'id' => $_post->ID,
						'Post_author' => $author_display_name,
						'Post_date' => $_post->post_date,
						'Post_content' => $content,
						'Post_title' => $_post->post_title,
						'Comment_count' => $_post->comment_count,
						'Comment_status' => $_post->comment_status,
						'Post_pic' => $pic_post,
						'cat' => $cats,
						'bazdid_post' => $this->get_bazdid_post($_post->ID),
						'Post_link' => get_permalink($_post->ID),
						'Custom_fields' => $array_cf,
						'mr2app_post_option' => $this->mr2app_post_option($_post->ID),
					);
					$i++;
					$cats="";
					$pic_post="";
					$array_cf = "";
				}
				ob_clean();
				echo json_encode($array);
			}else{
				echo 0;
			}
		}
		else
		{
			echo "not found page";
		}

	}

	function apost_webservice()
	{
		header('Content-Type: application/json; charset=utf-8');
		ob_start();
		if(!empty($_GET["in"]))
		{
			$in = $_GET['in'];
			$slashless = stripcslashes($in);
			$url_json = urldecode($slashless);
			$json = (array)  json_decode($url_json);
			$post_id =  $json["post_id"];

			$post = get_post( $post_id );

			$array_cf = $this->get_custom_fields($post->ID);

			$post_types = get_option("wp2app_post_types");
			$ar = json_decode($post_types,true);
			//$array_types = $this->wp2app_get_post_typs($post_types);

			if ( has_post_thumbnail( $post_id ) ) {
				$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'large' );
				$pic_post = $large_image_url[0];
			}

			if ($post_types != "") {
				foreach ($ar as $key) {
					foreach ($key as $k => $v) {
						foreach ($v as $x) {
							if($post->post_type == $k){
								$args = array();
								$cat_post = $this->wp_get_post_categories_hami($post_id , $args , $x);

							}
						}
					}
				}
			}else{
				$args = array();
				$cat_post = $this->wp_get_post_categories_hami($post_id , $args , "category");
			}
			$cats = "";
			foreach($cat_post as $cat){
				$cats = $cats.$cat . ",";
			}

			//$author = $author_display_name; //comment recently
			//$date = $post->post_date; //comment recently
			$content = apply_filters("the_content" , $post->post_content);
			$title = $post->post_title;
			$comment_count = $post->comment_count;
			$comment_status = $post->comment_status;
			$post_pic = $pic_post;
			$cat = $cats;

			$recent_author = get_user_by( 'ID',  $post->post_author );
			$author_display_name = $recent_author->display_name;
			$array['post'][] = array(
				'id' => $post->ID,
				'Post_author' => $author_display_name,
				'Post_date' => $post->post_date,
				'Post_content' => $content,
				'Post_title' => $title,
				'Comment_count' => $comment_count,
				'Comment_status' => $comment_status,
				'Post_pic' => $post_pic,
				'cat' => $cat,
				'bazdid_post' => $this->get_bazdid_post($post->ID),
				'Post_link' => get_permalink($post->ID),
				'Custom_fields' => $array_cf,
				'mr2app_post_option' => $this->mr2app_post_option($post->ID),
			);
			ob_clean();
			echo json_encode($array);
		}
		else{
			return 0;
		}

	}

	public function wp_get_post_categories_hami( $post_id = 0, $args = array() ,$my_tax) {
		$post_id = (int) $post_id;

		$defaults = array('fields' => 'ids');
		$args = wp_parse_args( $args, $defaults );

		$cats = wp_get_object_terms($post_id, $my_tax , $args);
		return $cats;
	}

	function gcomments_webservice()
	{
		ob_start();
		if(!empty($_GET["in"]))
		{


			$in = $_GET['in'];
			$slashless = stripcslashes($in);
			$url_json = urldecode($slashless);

			$json = (array)  json_decode($url_json);
			$count =(int) $json["Count"];
			$last_count =(int) $json["LastCount"];
			$post = (int) $json["Post_id"];

			$num=$count+$last_count;
			$args = array(
				'number' =>$num,
				'post_id' => $post
			);
			$records = get_comments($args );

			$i=1;
			foreach($records as $record)
			{
				if ($record->comment_approved == 1) {
					if($i>$last_count){

						$array_p['comments'][] = array(
							'Comment_id'=>$record->comment_ID,
							'Comment_author'=>$record->comment_author,
							'Comment_date'=>$record->comment_date,
							'Comment_content'=>$record->comment_content,
							'Comment_parent'=>$record->comment_parent
						);
					}
					$i++;
				}
			}
			ob_clean();
			echo json_encode($array_p);
		}
		else
		{
			echo "not found page";
		}
	}

	function scomments_webservice()
	{
		ob_start();
		if(!empty($_GET["in"]))
		{
			global $wpdb;
			$table_comments = $wpdb->prefix . 'comments';
			$in = $_GET['in'];
			$slashless = stripcslashes($in);
			$url_json = urldecode($slashless);
			$json = (array)  json_decode($url_json);

			$comment_author       = ! isset( $json['comment_author'] )       ? '' : $json['comment_author'];
			$comment_author_email = ! isset( $json['comment_author_email'] ) ? '' : $json['comment_author_email'];
			$comment_author_url   = ! isset( $json['comment_author_url'] )   ? '' : $json['comment_author_url'];
			$comment_author_IP    = ! isset( $json['comment_author_IP'] )    ? '' : $json['comment_author_IP'];
			$comment_date     = ! isset( $json['comment_date'] )     ? current_time( 'mysql' )            : $json['comment_date'];
			$comment_date_gmt = ! isset( $json['comment_date_gmt'] ) ? get_gmt_from_date( $comment_date ) : $json['comment_date_gmt'];
			$comment_post_id  = ! isset( $json['comment_post_id'] )  ? '' : $json['comment_post_id'];
			$comment_content  = ! isset( $json['comment_content'] )  ? '' : $json['comment_content'];
			$comment_karma    = ! isset( $json['comment_karma'] )    ? 0  : $json['comment_karma'];
			$comment_approved = ! isset( $json['comment_approved'] ) ? 0  : $json['comment_approved'];
			$comment_agent    = ! isset( $json['comment_agent'] )    ? '' : $json['comment_agent'];
			$comment_type     = ! isset( $json['comment_type'] )     ? '' : $json['comment_type'];
			$comment_parent   = ! isset( $json['comment_parent'] )   ? 0  : $json['comment_parent'];

			$user_id  = ! isset( $json['user_id'] ) ? 0 : $json['user_id'];

			$compacted = compact( 'comment_post_id', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_author_IP', 'comment_date', 'comment_date_gmt', 'comment_content', 'comment_karma', 'comment_approved', 'comment_agent', 'comment_type', 'comment_parent', 'user_id' );
			if ( ! $wpdb->insert( $wpdb->comments, $compacted ) ) {
				return false;
			}else{
				ob_clean();
				echo json_encode(array("result"=>1));
			}
			$id = (int) $wpdb->insert_id;
			if ( $comment_approved == 1 ) {
				wp_update_comment_count( $comment_post_id );
			}
			$comment = get_comment( $id );
			// If metadata is provided, store it.
			if ( isset( $commentdata['comment_meta'] ) && is_array( $commentdata['comment_meta'] ) ) {
				foreach ( $commentdata['comment_meta'] as $meta_key => $meta_value ) {
					add_comment_meta( $comment->comment_ID, $meta_key, $meta_value, true );
				}
			}

		}
		else
		{
			echo "not found page";
		}

	}
}