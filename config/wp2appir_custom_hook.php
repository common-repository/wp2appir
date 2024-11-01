<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class wp2appir_custom_hook


{


	


	function __construct()


	{


		add_action("myplugin_after_form_settings" , array($this , "update_setting_check"));		


		add_action("myplugin_after_form_cats" , array($this , "update_cats_check"));


		add_action( 'wp_trash_post' , array($this , 'wp2appir_post_trash' ));


		add_action( 'edit_terms', array($this , 'wp2appir_update_terms'), 10, 2 ); 


		add_action( 'create_term', array($this,'wp2appir_create_terms'), 10, 3 );


		add_action( 'delete_term', array($this,'wp2appir_delete_terms'), 10, 2);


		add_action( 'save_post', array($this , 'wp2appir_update_appost' ));

	}





	function update_setting_check(){


		$time = current_time( 'mysql' );


		update_option('hrt_lastmf_appsetting' , $time);


	}


	


	function update_cats_check(){


		$time = current_time( 'mysql' );


		update_option('hrt_lastmf_cat' , $time);


	}





	function wp2appir_post_trash( $post_id )


	{


		global $wpdb;


		$table_post = $wpdb->prefix . 'hami_appost';


		$result = $wpdb->get_results("select * from $table_post where post_id = $post_id");


		if($result)


		{


			$r = $wpdb->query($wpdb->prepare("DELETE FROM $table_post WHERE post_id = %d" , $post_id));


			if($r)


			{





			}


		}


	}





	function wp2appir_update_terms($term_id, $taxonomy){


		$time = current_time( 'mysql' );


		update_option('hrt_lastmf_cat',$time);


	}





	function wp2appir_create_terms( $term_id, $tt_id, $taxonomy ){


	    $time = current_time( 'mysql' );


		update_option('hrt_lastmf_cat',$time);


	}





	function wp2appir_delete_terms( $term_id, $taxonomy ){


	    $time = current_time( 'mysql' );


		update_option('hrt_lastmf_cat',$time);


	}


	function wp2appir_update_appost($post_id){
		global $wpdb;
		$table_post = $wpdb->prefix . 'hami_appost';
		$result = $wpdb->get_results("select * from $table_post where post_id = $post_id");
		if($result){
			$time = current_time( 'mysql' );
			update_option('hrt_lastmf_appost',$time);
		}
	}


}