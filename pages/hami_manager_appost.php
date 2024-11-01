<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wp_register_style( 'bootstrap', WP2APPIR_CSS_URL.'bootstrap.css'  );
wp_enqueue_style( 'bootstrap' );

wp_register_style( 'font-awesome', WP2APPIR_CSS_URL.'font-awesome.css'  );
wp_enqueue_style('font-awesome');
wp_register_style( 'paging', WP2APPIR_CSS_URL.'paging.css'  );
wp_enqueue_style('paging');

wp_register_style( 'bootstrap-select', WP2APPIR_CSS_URL.'bootstrap-select.css'  );
wp_enqueue_style( 'bootstrap-select' );

global $wpdb;
$table_name = $wpdb->prefix . 'hami_set';
$posts = $wpdb->prefix . 'posts';

$table_option = $wpdb->prefix . 'options';
$table_post = $wpdb->prefix . 'hami_appost';
?>
    <style>
        td{
            font-size :12px;
        }
        th{
            font-size :12px;
        }
    </style>
    <div  class="col-md-12  text-right" style="margin-top:10px;">

        <div  class="col-md-6  pull-right">
            <div class="panel panel-default">
                <div class="panel-heading yekan" style="font-size:15px;font-weight:700;">
                    پست های انتشار داده شده
                    <div class="col-md-4 text-left" style="padding:0px;">
                        <a target="_blank" href="http://wp2app.ir/plugin_edit_menu/">راهنما <i class="fa fa-1x fa-mortar-board"></i></a>
                    </div>
                </div>

                <div class="panel-heading yekan" style="font-size:15px;font-weight:700;">
                    <?php
                    //global $wp;
                    //$current_url = home_url(add_query_arg(array(),$wp->request));
                    $current_url = get_admin_url();
                    $targetpage = $current_url."admin.php?page=wp2appir/pages/hami_manager_appost.php";
                    ?>

                    <form  action="<?php echo $targetpage; ?>" method="POST">
                        <label>جستجو براساس عنوان :</label>
                        <div class="form-group input-group" >
                            <input type="text" class="form-control koodak" name="key" style="border-top-left-radius : 0px;border-bottom-left-radius : 0px;
																								   border-top-right-radius : 4px;border-bottom-right-radius : 4px">
                            <span class="input-group-btn" >
		                                                <button type="submit" class="btn btn-default" style="border-top-right-radius : 0px;border-bottom-right-radius : 0px;
																								   border-top-left-radius : 4px;border-bottom-left-radius : 4px">
                                                            <i class="fa fa-search"></i>
                                                        </button>
		                                            </span>
                        </div>
                    </form>

                </div>
                <!-- /.panel-heading -->
                <?php
                //-------------------------------------------------------------------------------------------------
                global $wp;
                $current_url = get_admin_url();
                $targetpage = $current_url."admin.php?page=wp2appir/pages/hami_manager_appost.php";
                $limit = 10;
                if (isset($_POST["key"])) {
                    echo $search = $_POST["key"];
                }elseif (isset($_GET["search"])) {
                    $search = $_GET["search"];
                }
                if(isset($_POST["key"]) || isset($_GET['search']) )
                {
                    $pages =  $wpdb->get_results("select * from  $posts where (post_type = 'page') and (post_status like 'publish' or post_status like 'draft') and (post_title like '%$search%')");
                }else{
                    $pages =  $wpdb->get_results("select * from  $posts where (post_type = 'page') and (post_status like 'publish' or post_status like 'draft') ");
                }
                ?>
                <div class="panel-body">
                    <div  class="table-responsive">
                        <form id="table_all_posts"  method="post">
                            <table style="direction:rtl;" class="table table-hover">
                                <thead class="yekan" style="font-weight:700;font-size:14px;">
                                <tr>
                                    <th class="text-right">#</th>
                                    <th class="text-right">عنوان پست</th>
                                    <th class="text-right">تاریخ انتشار</th>

                                    <th class="text-right">وضعیت</th>

                                    <th class="text-right">نوع پست</th>
                                    <th class="text-right">انتخاب</th>
                                </tr>
                                </thead>
                                <tbody class="koodak" style="font-size:25px;">
                                <?php
                                $i = 1 ;
                                foreach($pages as $record)
                                {
                                    ?>
                                    <tr>

                                        <td  style="font-size:13px;"><?= $i++; ?></td>
                                        <td  style="font-size:13px;"><?= $record->post_title; ?></td>
                                        <td style="font-size:13px;"><?= get_the_date( 'Y/m/d-H:i:s', $record->ID )/*$record->post_date*/; ?></td>

                                        <td style="font-size:13px;"><?php if($record->post_status == "publish") echo "منتشر شده" ;
                                            else if($record->post_status == "auto-draft") echo "پیش نویس خودکار";
                                            else if($record->post_status == "draft") echo "پیش نویس";
                                            else if($record->post_status == "trash") echo "زباله دان";			?></td>

                                        <td style="font-size:13px;"><?php if($record->post_type == "post") echo "پست"; else echo "برگه"; ?></td>
                                        <td style="font-size:13px;"><input type="checkbox" name="vehicle[]" value="<?php echo $record->ID; ?>"></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary pull-left">
                                اضافه کردن به اپلیکیشن
                                <label class="fa fa-2x fa-arrow-circle-left"></label>
                            </button>
                        </form>
                    </div>
                    <!-- /.table-responsive -->
                </div>

                <!-- /.panel-body -->

            </div>
            <!-- /.panel -->
        </div>
        <div  class="col-md-6  pull-right">
            <div class="panel panel-default">
                <div class="panel-heading yekan" style="font-size:15px;font-weight:700;">
                    گزینه های منو
                    <div style="float:left;">
                        <a href="http://wp2app.ir/plugin_menu_options/" target="_blank"> راهنما
                            <i class="fa fa-1x fa-mortar-board"></i>
                        </a>
                    </div>
                    <div style="float:left;margin-left : 15px;">
                        <select id="select_menu_appost" name="menu_app" class="form-control koodak"  style="font-size:14px;"	<?php if($type == 3) echo "disabled"; ?>>
                            <?php if($_POST["menu_app"] == 2 || $_POST['menu_app_hami_planning'] == 2 ) { ?>
                                <option value="1" >منو شماره یک</option>
                                <option value="2" selected>منو شماره دو</option>
                            <?php }else {?>
                                <option value="1"  selected>منو شماره یک</option>
                                <option value="2" >منو شماره دو</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div style="float:left;margin-left:10px;padding-top:5px;">
                        <label>انتخاب منو :</label>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <?php
                    if(!empty($_POST["vehicle"]))
                    {
                        $i = 1 ;
                        $order = $wpdb->get_results("SELECT MAX(order_post) as max_post FROM $table_post;");
                        if(!empty($order))
                        { foreach($order as $r) $i = (int) $r->max_post + 1;  }

                        $menu = $_POST["menu_app"];
                        echo $req_login = $_POST['req_login'] == 'on' ? 1 : 0;
                        foreach($_POST["vehicle"] as $post)
                        {
                            $rec = $wpdb->get_results("select * from $table_post where post_id = $post and menu = $menu");
                            if(empty($rec))
                            {
                                $type_post =  $wpdb->get_results("select post_type from  $posts where ID = $post ");
                                $t_p = "";
                                foreach ($type_post as $key) {
                                    if($key->post_type == 'post') $t_p = 1;
                                    elseif ($key->post_type == 'page') $t_p = 2;
                                }
                                $r = $wpdb->query( $wpdb->prepare("INSERT INTO $table_post
													(  post_id, type ,order_post,menu ,req_login) 
													VALUES ( %d , %d , %d , %d , %d)", $post , $t_p , $i , 1,$req_login) );

                                if($r)
                                {
                                    $time = current_time( 'mysql' );
                                    $r = $wpdb->update( $table_option,
                                        array( 'option_value' => $time),
                                        array( 'option_name' => 'hrt_lastmf_appost' ) );
                                }
                            }
                            $i++;
                        }
                        $_SESSION["alert_menu"] = "error";
                    }
                    if(isset($_POST["select_type_planning"]))
                    {
                        $id = -1;
                        $i = 1 ;
                        $menu = $_POST["menu_app_hami_planning"];
                        $req_login = (isset($_POST['req_login']) && $_POST['req_login'] == 'on') ? 1 : 0;

                        $order = $wpdb->get_results("SELECT MAX(order_post) as max_post FROM $table_post;");
                        if(!empty($order))
                        { foreach($order as $r) $i = (int) $r->max_post + 1;  }
                        if (empty($_POST["txt_title_planning"])) {
                            $_SESSION["alert_menu_planning"] = "error_txt";
                        }elseif($_POST["select_type_planning"] == 3 ||
                            $_POST["select_type_planning"] == 4 ||
                            $_POST["select_type_planning"] == 5){
                            if ( !empty( $_POST["txt_metadata_planning"] ) ){
                                $r = $wpdb->query( $wpdb->prepare("INSERT INTO $table_post
													(  post_id, type ,title, Metadata ,order_post,menu,req_login ) 
													VALUES ( %d , %d , %s , %s , %d , %d, %d)", $id , $_POST["select_type_planning"] , $_POST["txt_title_planning"] , $_POST["txt_metadata_planning"] , $i , $menu , $req_login) );
                                if($r)
                                {
                                    $time = current_time( 'mysql' );
                                    $r = $wpdb->update( $table_option,
                                        array( 'option_value' => $time),
                                        array( 'option_name' => 'hrt_lastmf_appost' ) );
                                }
                            }else{
                                $_SESSION["alert_menu_planning"] = "error_txt";
                            }
                        }elseif($_POST["select_type_planning"] == 6 ||
                            $_POST["select_type_planning"] == 7 ||
                            $_POST["select_type_planning"] == 10 ||
                            $_POST["select_type_planning"] == 11 ||
                            $_POST["select_type_planning"] == 12 ||
                            $_POST["select_type_planning"] == 13 ||
                            $_POST["select_type_planning"] == 14 ||
                            $_POST["select_type_planning"] == 8){
                            $r = $wpdb->query( $wpdb->prepare("INSERT INTO $table_post
												(  post_id, type ,title,order_post,menu,req_login ) 
												VALUES ( %d , %d , %s , %d , %d, %d)", $id , $_POST["select_type_planning"] , $_POST["txt_title_planning"] , $i , $menu,$req_login) );
                            if($r)
                            {
                                $time = current_time( 'mysql' );
                                $r = $wpdb->update( $table_option,
                                    array( 'option_value' => $time),
                                    array( 'option_name' => 'hrt_lastmf_appost' ) );
                            }
                        }else{

                            $r = $wpdb->query( $wpdb->prepare("INSERT INTO $table_post
												(  post_id, type , title , Metadata ,order_post , menu ,req_login) 
												VALUES ( %d , %d , %s , %s , %d , %d, %d)", $id , $_POST["select_type_planning"] , $_POST["txt_title_planning"] , $_POST["value_cat_items"] , $i , $menu,$req_login) );
                            if($r)
                            {
                                $time = current_time( 'mysql' );
                                $r = $wpdb->update( $table_option,
                                    array( 'option_value' => $time),
                                    array( 'option_name' => 'hrt_lastmf_appost' ) );
                            }
                        }
                        /*}//end if
                        else{
                            $_SESSION["alert_menu_planning"] = "error__exist";
                        }*/
                    }
                    //if(!empty($_POST["menu_app"])) $menu = $_POST["menu_app"] ;
                    //else $menu = 1;

                    ?>

                    <form name="form_sort" id="form_sort" method="post" action="">
                        <ul id="sortable">

                        </ul>
                    </form>
                    <button  id="btn_form_order" class="btn btn-primary koodak">
                        مرتب سازی
                        <label class="fa fa-2x fa-save"></label>
                    </button>
                    <div style="direction:rtl;margin-top:10px;" id="order_sucess" class="alert alert-success hide text-right koodak"></div>
                    <div style="direction:rtl;margin-top:10px;" id="del_sucess" class="alert alert-danger hide text-right koodak"></div>
                    <?php

                    ?>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
            <!-- this is new update section for plugin -->
            <form method="post">
                <div class="panel panel-default">
                    <div class="panel-heading yekan" style="font-size:15px;font-weight:700;">
                        اضافه کردن گزینه قابل برنامه ریزی
                        <div class="col-md-3 text-left">
                            <a href="http://wp2app.ir/plugin_custom_options/" target="_blank"> راهنما
                                <i class="fa fa-1x fa-mortar-board"></i>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <select id="select_type_planning" name="select_type_planning" class="form-control koodak">
                            <option value="3">لینک</option>
                            <option value="4">تماس</option>
                            <option value="5">پیامک</option>
                            <option value="6">جست و جو</option>
                            <option value="7">خود بلوتوثی</option>
                            <option value="8">خروج از اپلیکیشن</option>
                            <option value="9">دسته بندی</option>
                            <option value="10">دانلود منیجر داخلی </option>
                            <option value="11">پلیر داخلی </option>
                            <option value="12"> مدیریت خرید ها </option>
                            <option value="13"> علاقه مندی ها </option>
                            <option value="14"> لیست دسته بندی </option>
                            <option value="15">  اینباکس </option>
                        </select>
                        <input id="txt_title_planning" name="txt_title_planning" style="margin-top : 15px;" class="form-control text-right koodak" placeholder="عنوان را وارد نمایید.">
                        <input id="txt_metadata_planning" name="txt_metadata_planning" style="margin-top : 15px;direction:ltr;" class="form-control text-left koodak" placeholder="[http || https]://mysite.com">
                        <p id="txt_metadata_planning_p">
                            در صورتی که میخواهید به یک برگه یا پست لینک ایجاد کند میتوانید
                            <a href="https://mr2app.com/blog/wp-page-link" target="_blank">
                                این آموزش
                            </a>
                            را مطالعه کنید
                        </p>
                        <div class="col-md-12 hide" id="div_cat_action" style="margin-top : 15px;">
                            <select name="value_cat_items" id="value_cat_items" class="selectpicker col-md-12" data-live-search="true" title="انتخاب کنید..." >
                                <option value="0" style="text-align:right;">دسته خود را انتخاب کنید</option>
                                <?php
                                $cats = get_cat_wp2app();
                                foreach ($cats as $cat) {
                                    ?>
                                    <option style="text-align:right;" value="<?= $cat->term_id; ?>"><?= $cat->name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12"  style="direction:rtl;margin-top : 5px;">
                            <input type="checkbox" name="req_login">
                            عضویت اجباری
                            <small>
                                (در صورت فعال بودن ، فقط برای کاربرانی که در اپ لاگین شده باشند ، قابل مشاهده است. - نیازمند ماژول
                                <a href="http://mr2app.com/blog/prof-register/" target="_blank">
                                    ثبت نام
                                </a>
                                )
                            </small>
                        </div>
                        <input type="hidden" id="menu_app_hami_planning" name="menu_app_hami_planning"
                               value="<?php if( isset($_POST['menu_app_hami_planning']) && $_POST['menu_app_hami_planning'] == 2 ) echo 2; else echo 1; ?>">

                        <button type="submit" style="margin-top:15px;" class="btn btn-primary koodak">
                            اضافه
                            <label class="fa fa-arrow-circle-up fa-2x"></label>
                        </button>
                    </div>
                    <div style="" class="col-md-12">
                        <div id="menu_alert_planning" class="hide alert alert-success koodak">
                            <p style="color:red">
                                لطفا فیلد ها را پر کنید.
                            </p>
                        </div>
                    </div>
                    <div style="" class="col-md-12">
                        <div id="menu_exist_planning" class="hide alert alert-success">
                            <p style="color:red">
                                شما این گزینه را در این منو قبلا انتخاب کرده اید.
                            </p>
                        </div>
                    </div>

                </div>
            </form>
            <!-- this is new update section for plugin -->
        </div>
    </div>
<?php
if(isset($_SESSION["alert_menu"]) && $_SESSION["alert_menu"] == "error" ){
    ?>
    <script type="text/javascript">
        /*jQuery("#menu_alert").fadeIn("slow", function() {
         jQuery('#menu_alert').removeClass('hide');
         jQuery('#menu_alert').fadeOut(10000);
         });*/
    </script>
    <?php
}
if(isset($_SESSION["alert_menu_planning"]) && $_SESSION["alert_menu_planning"] == "error_txt")
{
    ?>
    <script type="text/javascript">
        jQuery("#menu_alert_planning").fadeIn("slow", function() {
            jQuery('#menu_alert_planning').removeClass('hide');
            jQuery('#menu_alert_planning').fadeOut(10000);
        });
    </script>
    <?php
}

if (isset($_SESSION["alert_menu_planning"]) && $_SESSION["alert_menu_planning"] == "error__exist") {
    ?>
    <script type="text/javascript">
        jQuery("#menu_exist_planning").fadeIn("slow", function() {
            jQuery('#menu_exist_planning').removeClass('hide');
            jQuery('#menu_exist_planning').fadeOut(10000);
        });
    </script>
    <?php
}
wp_enqueue_script( 'bootstrap.min.js' , WP2APPIR_JS_URL.'bootstrap.min.js', array('jquery'));
wp_enqueue_script( 'jquery-ui.js' , WP2APPIR_JS_URL.'jquery-ui.js', array('jquery'));
wp_enqueue_script( 'sort.js' , WP2APPIR_JS_URL.'sort.js', array('jquery'));
wp_enqueue_script( 'opration_appost.js' , WP2APPIR_JS_URL.'opration.js', array('jquery'));
wp_enqueue_media();
wp_register_script('upload_new_appost.js', WP2APPIR_JS_URL.'upload_new_appost.js', array('jquery'));
wp_enqueue_script('upload_new_appost.js');
wp_enqueue_script( 'bootstrap-select.js' , WP2APPIR_JS_URL.'bootstrap-select.js', array('jquery'));
?>

    <!-- Modal -->
    <button id="btn_alert_wp2appir" class="hide btn btn-primary btn-lg" data-toggle="modal" data-target="#alert_wp2appir_menu">
    </button>
    <div class="modal fade" id="alert_wp2appir_menu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel" style="color:green;">توجه توجه !!!</h4>
                </div>
                <div class="modal-body text-center">
                	<span style="color:green;">
                	کاربر گرامی تغییرات شما اعمال شد .</br>
                        لطفا جهت مشاهده تغییرات اپلیکیشن را بسته و مجدداٌ اجرا کنید.
                	</span>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


<?php
//********************************************************************


//*****************************************************************************************


?>