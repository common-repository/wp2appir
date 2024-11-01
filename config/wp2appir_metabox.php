<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class wp2appir_metabox_notif
{

	function __construct()
	{
		add_action( 'add_meta_boxes', array($this , 'wp2appir_metabox_notif_add') );
		add_action( 'save_post', array($this , 'wp2appir_metabox_notif_save') );
        add_filter( 'excerpt_length', array($this , 'wp2appir_excerpt_length'), 999 );
	}
	function wp2appir_metabox_notif_add()
	{
		add_meta_box( 'my-meta-box-id',
			'ارسال نوتیفیکیشن',
			array($this , 'wp2appir_metabox_notif_design'),
			'post',
			'side',
			'high' );
	}

	function wp2appir_metabox_notif_design(){
        wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce_wp2app' );
        ?>
        <p>
            <input type="radio" name="notify" value="1" > ارسال با صدا<br>
            <input type="radio" name="notify" value="2"> ارسال بدون صدا<br>
            <input type="radio" name="notify" value="0" checked> عدم ارسال
        </p>
        <?php
	}

	function wp2appir_metabox_notif_save( $post_id ){

        // Bail if we're doing an auto save
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        // if our nonce isn't there, or we can't verify it, bail
        if( !isset( $_POST['meta_box_nonce_wp2app'] ) || !wp_verify_nonce( $_POST['meta_box_nonce_wp2app'], 'my_meta_box_nonce' ) ) return;
        // if our current user can't edit this post, bail
        if( !current_user_can( 'edit_post' ) ) return;

        $notif_type = get_option('notification_type');

        if(isset($_POST['notify']) && get_post_status($post_id)== "publish" && $_POST['notify'] != 0){
            if($notif_type == 'direct'){
                $r = wp2app_send_notif(get_the_title($post_id) , $_POST["notify"] , 2 , $post_id);
                $r = json_decode($r , true);
            }
            else{
                $r = wp2app_send_notif_mr2app( get_the_title($post_id) , $_POST["notify"] , 2 , $post_id);
                $r = json_decode($r , true);
            }
        }
	}
    function wp2appir_excerpt_length( $length ) {
        return 20;
    }
}