<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class wp2appir_metabox_telegram


{


	
	const BASE_URL = 'https://api.telegram.org';
  	const BOT_URL = '/bot';

	public $token;
	public $url;

	function __construct()


	{

		$this->token = get_option('hrt_telegram_token');

		$this->url = self::BASE_URL . self::BOT_URL . $this->token ."/";

		add_action( 'add_meta_boxes', array($this , 'wp2appir_metabox_telegram_add') );


		add_action( 'save_post', array($this , 'wp2appir_metabox_telegram_save') );


		add_filter( 'excerpt_length', array($this , 'wp2appir_excerpt_length'), 999 );


	}





	function wp2appir_metabox_telegram_add()


	{


	    add_meta_box( 'tel-meta-box-id',


				      'ارسال با تلگرام',


				      array($this , 'hami_teleg_meta_box_telegram_design'),


				      'post',


				      'side',


				      'high' );


	}








	function hami_teleg_meta_box_telegram_design()


	{


		global $wpdb;


		$type = get_option('PLAN_TYPE');


		$send = get_option('wp2app_telg_default');


	    global $post;


	    $values = get_post_custom( $post->ID );


	    $check = isset( $values['my_meta_box_check_tel'] ) ? esc_attr( $values['my_meta_box_check_tel'] ) : '';


	     


	    // We'll use this nonce field later on when saving.


	    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );


	    ?>


		<p>


		<a target="_blank" href="http://wp2app.ir/telegram/">راهنما <i class="fa fa-1x fa-mortar-board"></i></a>


		</p>


		<?php if($send == 0) {?>


		<p>


	      <input type="radio" name="telegram" value="voice_tel"> ارسال با صدا<br>


		  <input type="radio" name="telegram" value="silent_tel"> ارسال بدون صدا<br>


		  <input type="radio" name="telegram" value="no_send_tel" checked> عدم ارسال


		</p>


		<?php } ?>


		<?php if($send == 1) {?>


		<p>


	      <input type="radio" name="telegram" value="voice_tel"> ارسال با صدا<br>


		  <input type="radio" name="telegram" value="silent_tel" checked> ارسال بدون صدا<br>


		  <input type="radio" name="telegram" value="no_send_tel"> عدم ارسال


		</p>


		<?php } ?>


		<?php if($send == 2) {?>


		<p>


	      <input type="radio" name="telegram" value="voice_tel" checked> ارسال با صدا<br>


		  <input type="radio" name="telegram" value="silent_tel"> ارسال بدون صدا<br>


		  <input type="radio" name="telegram" value="no_send_tel"> عدم ارسال


		</p>


		<?php }   


	}





	function wp2appir_metabox_telegram_save( $post_id )


	{


	      // Bail if we're doing an auto save


	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;


	     


	    // if our nonce isn't there, or we can't verify it, bail


	    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;


	     


	    // if our current user can't edit this post, bail


	    if( !current_user_can( 'edit_post' ) ) return;


	     


	    // now we can actually save the data


	    $allowed = array( 


	        'a' => array( // on allow a tags


	            'href' => array() // and those anchors can only have href attribute


	        )


	    );


	     


	    if(isset($_POST['telegram']) && get_post_status($post_id)=="publish"){


			$token = get_option('hrt_telegram_token');


			$chat = get_option('hrt_telegram_chatid');


			$sign = get_option('hrt_telegram_sign');


			//$code = get_option('SITE_CODE');


			//$plan = get_option('PLAN_TYPE');


			//$SITE_TOKEN = get_option('hami_site_token');


			


			if($_POST['telegram']=='voice_tel'){

				//---------------------------------------------------------
					
				global $wpdb;

				$post = get_post( $post_id );
				$link = get_site_url()."/?p=".$post_id;
				$summury = $this->wp2appir_excerpt($post);
				$summury = str_replace( '&nbsp;', ' ', $summury );
			    $pic_post ="";			

				if ( has_post_thumbnail( $post_id ) ) {
					$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'large' );
					$pic_post = $large_image_url[0]; 	
				}
				
				$this->sendPhoto($chat,$pic_post,$post->post_title,false);
				$message = $summury.chr(10).'<a href="'.$link.'"> ادامه مطلب </a>'.chr(10).$sign;
				$this->sendMessage($chat, $message ,"HTML",flase);
				$this->delete_files();

			}else if($_POST['telegram']=='silent_tel'){

				global $wpdb;
				$post = get_post( $post_id );
				$link = get_site_url()."/?p=".$post_id;
				$summury = $this->wp2appir_excerpt($post);
				$summury = str_replace( '&nbsp;', ' ', $summury );
			    $pic_post ="";			

				if ( has_post_thumbnail( $post_id ) ) {
					$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'large' );
					$pic_post = $large_image_url[0]; 	
				}
				
				$this->sendPhoto($chat,$pic_post,$post->post_title,true);
				$message = $summury.chr(10).'<a href="'.$link.'"> ادامه مطلب </a>'.chr(10).$sign;
				$this->sendMessage($chat, $message ,"HTML",true);
				$this->delete_files();

			}else{


				return;


			}


			


		}else{


			return;


		}


		


	}








	function wp2appir_excerpt( $post )


	{


	  $text = $post->post_content;


	  $text = strip_shortcodes( $text );


	  $text = apply_filters( 'the_content', $text );


	  $text = str_replace( ']]>', ']]>', $text );


	 


	  $excerpt_length = apply_filters( 'excerpt_length', 55 );


	  $excerpt_more   = apply_filters( 'excerpt_more', ' ' . '[...]' );


	  $text           = wp_trim_words( $text, $excerpt_length, '' );


	  return $text;


	}


	


	function wp2appir_excerpt_length( $length ) {


	    return 20;


	}


	public function sendPhoto( $chat , $photo_url , $caption , $notif ){
			
			$url1 = $this->url . "sendPhoto?chat_id=" . $chat ;
			$photo = WP2APPIR_PATH."/dl_telegram/".$this->upload_url($photo_url);

			$post_fields = array( 'chat_id'   => $chat ,

			    'photo'     => new CURLFile(realpath($photo)),
				'caption'   => $caption , 
				'disable_notification' => $notif

			);

			global $wpdb;
			$wpdb->query( $wpdb->prepare("INSERT INTO wp_errors_pey 
							( content ) 
							VALUES (%s)", $photo ) ); 

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_HTTPHEADER, array(

			    "Content-Type:multipart/form-data"

			));

			curl_setopt($ch, CURLOPT_URL, $url1); 

			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

			curl_setopt($ch, CURLOPT_SAFE_UPLOAD, 1);

			curl_setopt($ch, CURLOPT_POST, 1);

			curl_setopt($ch, CURLOPT_POSTFIELDS,$post_fields );

			$output = curl_exec($ch);
			

	}

	public function sendMessage($chat_id, $text ,$parse_mode = null,$disable_notification = false, $disable_web_page_preview = false, $reply_to_message_id = null, $reply_markup = null)
	{
		$params = compact('chat_id', 'text', 'parse_mode','disable_notification' , 'disable_web_page_preview', 'reply_to_message_id', 'reply_markup');

		return $this->sendRequest('sendMessage', $params);
	}
  
	public function sendRequest($method, $params)
	{	
	    return json_decode(file_get_contents($this->url . $method . '?' . http_build_query($params)), true);
	}

	public function upload_url($url){

			$url = trim($url);
			if($url){
			$file = fopen($url,"rb");

			if($file){
			$directory = WP2APPIR_PATH."/dl_telegram/"; // Directory to upload files to.
			$valid_exts = array("jpg","jpeg","gif","png"); // default image only extensions
			$ext = explode(".",strtolower(basename($url)));
			$ext = end($ext);
			if(in_array($ext,$valid_exts)){
			//$rand = rand(1000,9999);
			//$filename = $rand . basename($url);
			$filename = "hami.".$ext;
			$newfile = fopen($directory . $filename, "wb"); // creating new file on local server
			if($newfile){
			while(!feof($file)){
			// Write the url file to the directory.
			fwrite($newfile,fread($file,1024 * 8),1024 * 8); // write the file to the new directory at a rate of 8kb/sec. until we reach the end.
			}
				 return $filename;
			} else { return false; }
			} else { return false; }
			} else { return false; }
			} else { return false; }
	}

	public function delete_files(){
		$files = glob(WP2APPIR_PATH.'/dl_telegram/*'); 
		foreach($files as $file){ 
		  if(is_file($file))
		    unlink($file); 
		}
	}


}