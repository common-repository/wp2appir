<?php


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


function wp2appir_activeFunction($email,$active){


	$error = "";


	$fields = array(


	  'email' =>$active ,


	  'code' => $email


	);





	$ch = curl_init();


	curl_setopt($ch, CURLOPT_URL, "http://api.wp2app.ir/active/".$active."/".$email);


	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);


	$response = curl_exec($ch);





	if($errno = curl_errno($ch)) {


	    $error = "لطفا با پشتیبانی تماس بگیرید.</br>خطا شماره :({$errno})";


	}





	curl_close($ch);





	if(!empty($error)){


		//$_SESSION["code_error"] = $error;


		return array("log_wp2app" => 1 , "log_text" => $error);


	}elseif ($response == "Error0") {


		$_SESSION["error"] = "error0";


		return -1;


	}elseif ($response == "Error1") {


		$_SESSION["error"] = "error1";


		return -2;


	}else{


		$response2 = json_decode($response,TRUE);


	    $apikey = $response2[0]["API_KEY"];


		$expdate = $response2[0]["EXP_DATE"];


		$type = $response2[0]["PLAN_TYPE"];


		$sitecode = $response2[0]["SITE_CODE"];					





		if ($apikey != "" && $expdate != "" && $type != "" && $sitecode != "") {


			$SITE_CODE = get_option('SITE_CODE'); 


			if($SITE_CODE){


				$_SESSION["error"] = "error";


				return -4;


			}else{


				add_option('API_KEY',$apikey);


				add_option('EXP_DATE',$expdate);


				add_option('PLAN_TYPE',$type);


				add_option('SITE_CODE',$sitecode);


				return 1;


			}





		}else{


			$_SESSION["error"] = "error";


			return -3;


		}


	}





	


}





function wp2appir_activeforceFunction($email,$active){


	$response = file_get_contents("http://api.wp2app.ir/active/".$active."/".$email);


	if ($response == "Error0") {


		$_SESSION["error"] = "error0";


		return -1;


	}elseif ($response == "Error1") {


		$_SESSION["error"] = "error1";


		return -2;


	}else{


		$response2 = json_decode($response,TRUE);


	    $apikey = $response2[0]["API_KEY"];


		$expdate = $response2[0]["EXP_DATE"];


		$type = $response2[0]["PLAN_TYPE"];


		$sitecode = $response2[0]["SITE_CODE"];					





		if ($apikey != "" && $expdate != "" && $type != "" && $sitecode != "") {


			$SITE_CODE = get_option('SITE_CODE'); 


			if($SITE_CODE){


				$_SESSION["error"] = "error";


				return -4;


			}else{


				add_option('API_KEY',$apikey);


				add_option('EXP_DATE',$expdate);


				add_option('PLAN_TYPE',$type);


				add_option('SITE_CODE',$sitecode);


				return 1;


			}





		}else{


			$_SESSION["error"] = "error";


			return -3;


		}


	}


}