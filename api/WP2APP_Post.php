<?php
/**
 * Created by PhpStorm.
 * User: hani
 * Date: 4/30/18
 * Time: 5:16 PM
 */

class WP2APP_Post {



    public function posts( WP_REST_Request $request ){
        //Let Us use the helper methods to get the parameters

        ob_start();
        $in = $_POST['in'];
        $slashless = stripcslashes($in);
        $url_json = urldecode($slashless);
        $url_json = str_replace("\\",'',$url_json);
        $json =  json_decode($url_json );
        $json->count  = ($json->count != "") ? $json->count : 30;
        $json->page = (int)$json->count * (int)$json->page;
        $cat = "";
        $cats = get_option('mr2app_post_category');
        if(is_array($cats) && !empty($cats)){
            $cat = get_option('mr2app_post_category');
        }
        //return $json->filter->cat_id;
        if(!empty($json->filter->cat_id)){
            //$cat = array();
            foreach ($json->filter->cat_id as $c){
                if($c == "") continue;
                $cat = $json->filter->cat_id;
            }
        }
        $args = array(
            's' => $json->filter->search,
            'name' => $json->filter->slug == '' ? null : $json->filter->slug,
            'include' => $json->filter->post_id,
            'numberposts'   => $json->count ,
            'offset'           => $json->page,
            'category'         => $cat,
            'orderby'          => ($json->sort == 'newest' || $json->sort == "") ? 'date' : 'meta_value_num',
            'order'            => 'desc',
            'tag'              => $json->filter->tag,
            'post_type'        => WP2APP_Post::wp2app_post_type(),
            'post_status'      => 'publish',
            'suppress_filters' => true
        );
        $setting = get_option('wp2app_setting');
        if(empty($json->filter->post_id)){

            $args['tax_query'] = array( 'relation' => 'OR' );
            foreach (WP2APP_Post::wp2app_post_type() as $key) {
                if(empty(get_object_taxonomies($key))) continue;
                foreach (get_object_taxonomies($key) as $k){
                    $args['tax_query'][] = array(
                        'taxonomy' =>  $k,
                        'field'    => 'term_id',
                        'terms'    => $cat,
                    );
                }
            }
        }

        if($args['orderby'] == 'meta_value_num'){
            if($json->sort == 'most_visited' ) $meta_key = $setting['meta_visit'] ;
            if($json->sort == 'most_liked' ) $meta_key = $setting['meta_like'] ;
            $args['meta_query'] = array(
                'relation' => 'OR',
                array(
                    'key' => $meta_key,
                    'compare' => 'NOT EXISTS', // limit to "karma value = 100"
                    'value' => ''
                ),
                array(
                    'key' => $meta_key,
                    'compare' => '>=',
                    'value' => 0
                ),
            );
        }
        //return $args;
        $posts = get_posts($args);
        $i = 0;
        $post = array();
        foreach($posts as $_post){

            if ( has_post_thumbnail( $_post->ID ) ) {
                $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $_post->ID ), 'large' );
                $pic_post = $large_image_url[0];
            }
            $array_cf = WP2APP_Post::get_custom_fields($_post->ID);
            $cat_post = WP2APP_Post::wp_get_post_categories_hami($_post->ID , $args , "category");
            $cats = "";

            foreach($cat_post as $cat){
                $cats = $cats.$cat . ",";
            }
            $recent_author = get_user_by( 'ID', $_post->post_author );
            $author_display_name = $recent_author->display_name;
            $content = apply_filters("the_content" , $_post->post_content);
            $post[] = array(
                'id' => $_post->ID,
                'Post_author' => $author_display_name ,
                'Post_date' => $_post->post_date,
                'Post_content' => $content,
                'Post_title' => $_post->post_title,
                'Comment_count' => $_post->comment_count,
                'Comment_status' => $_post->comment_status,
                'Post_pic' => $pic_post ? $pic_post : '',
                'cat' => $cats,
                'Post_link' => get_permalink($_post->ID),
                'post_visit' => WP2APP_Post::get_visit_post($_post->ID),
                'post_like' => WP2APP_Post::get_like_post($_post->ID),
                'Custom_fields' => $array_cf,
                'mr2app_post_option' => WP2APP_Post::mr2app_post_option($_post->ID),
            );
            $i++;
            $pic_post = "";
            $arr = "";
            $array_cf = "";
        }
        $array['status'] = 1;
        $array['post'] = $post;
        ob_clean();
        return $array;

    }

    public function wp_get_post_categories_hami( $post_id = 0, $args = array() ,$my_tax) {
        $post_id = (int) $post_id;

        $defaults = array('fields' => 'ids');
        $args = wp_parse_args( $args, $defaults );

        $cats = wp_get_object_terms($post_id, $my_tax , $args);
        return $cats;
    }

    function get_visit_post($post_id){

        $meta_like = get_option('wp2app_setting');
        if($meta_like['meta_visit']){
            return  get_post_meta($post_id , $meta_like['meta_visit'], true);
        }
        return "";
    }

    function get_like_post($post_id){
        $meta_like = get_option('wp2app_setting');
        //return $meta_like['meta_like'];
        //return  get_post_meta($post_id , $meta_like['meta_like'], true);
        if($meta_like['meta_like']){
            return  get_post_meta($post_id , $meta_like['meta_like'], true);
        }
        return '0';
    }

    public function wp2app_post_type(){
        $post_types = get_option('mr2app_post_type');
        if(!is_array($post_types) || empty($post_types)) return '';
        return $post_types;
    }

    public function post_permission(){
        if( isset($_POST['in']) ) {
            return true;
        }
        else{
            return new WP_Error( 'rest_forbidden', esc_html__( 'You do not have permissions to view this data.', 'my-text-domain' ), array( 'status' => 401 ) );
        }
    }

    private function  mr2app_post_option($post_id){
        $x = get_post_meta($post_id , 'mr2app_post_option',true);
        return $x ? $x : array();
    }

    private function  wp2app_get_post_typs($post_types){
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

    private function calc_args($cats = "" , $num , $search = ''){
        $flag_all = 0;
        if($cats == ""){
            $cat_selected = get_option('wp2app_cats');
            $post_types = get_option("wp2app_post_types");
            $ar = json_decode($post_types,true);
            if($cat_selected != ""){
                $cats1 = explode(",",$cat_selected);
                foreach ($cats1 as $cat) {
                    if($cat == 0){
                        $flag_all = 1;
                    }
                }
            }
            else{
                $flag_all = 1;
            }
        }
        else{
            $cat_selected = $cats;
            $cats1 = explode(",",$cat_selected);
        }

        $args = array();
        if($cat_selected != "" && $cat_selected != null && ! empty($cat_selected) && $flag_all == 0){
            if($post_types == ""){
                $args = array(
                    'numberposts' => $num ,
                    'post_type' => $post_types,
                    "s" => $search ,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field'    => 'term_id',
                            'terms'    => $cats1,
                        ),
                    ),
                );
            }
            else{
                foreach ($ar as $key) {
                    foreach ($key as $k => $v) {
                        //$array_types[] = $k;
                        $tax_query[] = $v;
                    }
                }
                $ar1 = array( 'relation' => 'OR' );
                foreach ($tax_query as $key) {
                    foreach ($key as $k) {
                        $ar1[] = array(
                            'taxonomy' => $k,
                            'field'    => 'term_id',
                            'terms'    => $cats1,
                        );
                    }
                }
                $args = array(
                    'numberposts' => $num ,
                    'post_type' => $post_types,
                    'tax_query' => $ar1,
                    "s" => $search ,
                );
            }
        }
        else{
            $args = array(
                'numberposts' => $num,
                'post_type' => $post_types ,
                "s" => $search ,
            );
        }
        return $args;
    }

    private function get_custom_fields($post_ID){
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

    public function like(){
        ob_start();
        $in = $_POST['in'];
        $slashless = stripcslashes($in);
        $url_json = urldecode($slashless);
        $json =  json_decode($url_json );
        $post_id = $json->post_id;
        $counter = 0;
        if($json->like == 0 ) $counter = -1;
        elseif($json->like == 1 ) $counter = 1;

        //return $counter;
        if($post = get_post($post_id)){
            $wp2app_setting = get_option('wp2app_setting');
            //$meta_like = $wp2app_setting['meta_like'];
            if($wp2app_setting == false || empty($wp2app_setting)) {
                $wp2app_setting = array();
                $wp2app_setting['meta_like'] = 'like' ;
                $wp2app_setting['meta_visit'] = 'visit' ;
                $wp2app_setting['display_author'] = '' ;
                update_option('wp2app_setting' , $wp2app_setting);
            }
            $meta_like = $wp2app_setting['meta_like'] ;
            if(!isset($wp2app_setting['meta_like']) || $wp2app_setting['meta_like'] == "" ){
                $meta_like = 'like' ;
            }

            $count = get_post_meta($post_id,$meta_like, true);
            $like = $count + $counter;
            update_post_meta($post_id ,$meta_like,$like);
            return $result = array(
                'result'=> array(
                    'status' => 1,
                    'likes' => $like
                )
            );
        }

        return $result = array(
            'result'=> array(
                'status' => 0,
                'likes' => 0
            )
        );

    }

    public function visit(){
        ob_start();
        $in = $_POST['in'];
        $slashless = stripcslashes($in);
        $url_json = urldecode($slashless);
        $json =  json_decode($url_json );
        $post_id = $json->post_id;
        $counter = 1;

        //return $counter;
        if($post = get_post($post_id)){
            $wp2app_setting = get_option('wp2app_setting');
            //$meta_like = $wp2app_setting['meta_like'];
            if($wp2app_setting == false || empty($wp2app_setting)) {
                $wp2app_setting = array();
                $wp2app_setting['meta_like'] = 'like' ;
                $wp2app_setting['meta_visit'] = 'visit' ;
                $wp2app_setting['display_author'] = '' ;
                update_option('wp2app_setting' , $wp2app_setting);
            }
            $meta_visit = $wp2app_setting['meta_visit'] ;
            if(!isset($wp2app_setting['meta_visit']) || $wp2app_setting['meta_visit'] == "" ){
                $meta_visit = 'visit' ;
            }

            $count = get_post_meta($post_id,$meta_visit, true);
            $visit = $count + $counter;
            update_post_meta($post_id ,$meta_visit,$visit);
            return $result = array(
                'result'=> array(
                    'status' => 1,
                    'visit' => $visit
                )
            );
        }
        return $result = array(
            'result'=> array(
                'status' => 0,
                'visit' => 0
            )
        );
    }
}