<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wp_register_style( 'bootstrap', WP2APPIR_CSS_URL . 'bootstrap.css'  );


wp_enqueue_style('bootstrap');


wp_register_style( 'wp2app_fonts', 'http://wp2app.ir/downloads/plugin-asset/wp2app_fonts.css'  );


wp_enqueue_style('wp2app_fonts');



if ( isset( $_POST['activate_wp2appir'] ) &&


wp_verify_nonce( $_POST[activate_wp2appir], 'wp2appir_activate' ) && current_user_can("update_plugins") ) {





		if(!empty($_POST["txt_activate"])){


			$active =  sanitize_text_field($_POST["txt_activate"]);


			$email =   sanitize_text_field($_POST["txt_email"]);





			if($active == "demo" && $email == "demo@wp2app.ir" ){


					$SITE_CODE = get_option('SITE_CODE');


					if($SITE_CODE){


						$_SESSION["error"] = "error";


					}else{


						add_option('API_KEY',"demo");


						add_option('EXP_DATE',-1);


						add_option('PLAN_TYPE',4);


						add_option('SITE_CODE',"demo");


						?><script>


								window.location.assign("<?php echo get_admin_url().'?page=wp2appir/pages/hami_manager_setting.php'; ?>");


						</script><?php


					}





			}else{

				$activation =  wp2appir_activeFunction($email,$active);
				if ($activation == 1) {
					?><script>
						window.location.assign("<?php echo get_admin_url().'?page=wp2appir/pages/hami_manager_setting.php'; ?>");
					</script><?php
				}elseif($activation["log_wp2app"] == 1){
					$activation_force = wp2appir_activeforceFunction($email,$active);
					if ($activation_force == 1) {
						?><script>
						window.location.assign("<?php echo get_admin_url().'?page=wp2appir/pages/hami_manager_setting.php'; ?>");
						</script><?php
					}
					//$activation["log_text"];
				}

			}

		}//for isset

}		








?>


<div class="col-md-12" style="">


		<div class="col-md-4"></div>


		<div class="col-md-4" style="border:1px solid #e5e5e5;border-radius:3px;paddinf:5px;">


			<form action="" method="post">


			<?php wp_nonce_field('wp2appir_activate' , 'activate_wp2appir'); ?>


				<div class="col-md-12" style="padding:5px;">


					<input type="email" class="form-control" name="txt_email" placeholder="ایمیل خود را وارد نمایید" style="text-align:right;" >


				</div>


				<div class="col-md-12" style="padding:5px;">


					<input class="form-control" name="txt_activate" placeholder="کد وب سایت را وارد نمایید">


				</div>


				<div class="col-md-12" style="padding:5px;">


					<button type="submit" class="btn btn-primary">فعال سازی</button>


				</div>


				<div class="col-md-12" style="padding:5px;">


					<a target="_blank" href="http://panel.wp2app.ir/user/remember">


						کد وب سایت را فراموش کرده ام


					</a>


				</div>


				<div class="col-md-12" style="padding:5px;">


					<a target="_blank" href="http://panel.wp2app.ir/register">


						ثبت نام در wp2app.ir


					</a>


				</div>


				<div class="col-md-12" style="padding:5px;">


					<a target="_blank" href="http://wp2app.ir/%D9%BE%D8%B4%D8%AA%DB%8C%D8%A8%D8%A7%D9%86%DB%8C/">


						تماس با پشتیبانی


					</a>


				</div>


			</form>


		</div>


		<div class="col-md-4"></div>


</div>


<div class="col-md-12" style="">


		<div class="col-md-4"></div>


		<div class="col-md-4">


			<?php if( $_SESSION["error"] == "error0" ){


					?>


						<div class="alert alert-danger">


                            اطلاعات نامعتبر است.


						</div>


					<?php


			}elseif ( $_SESSION["error"] == "error") {


				?>


						<div class="alert alert-danger">


                            خطا در سرور لطفا با پشتیبانی تماس بگیرید.


						</div>


				<?php


			}elseif (isset($_SESSION["code_error"])) {


				?>


						<div class="alert alert-danger">


                       		<?php echo $_SESSION["code_error"]; ?>


						</div>


				<?php


			}elseif ($_SESSION["error"] == "error1") {


				?>


						<div class="alert alert-danger">


                       		اطلاعات اشتباه است.


						</div>


				<?php


			}?>


		</div>


		<div class="col-md-4"></div>


</div>


