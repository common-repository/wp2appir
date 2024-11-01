<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class wp2appir_ajax_appost


{





    function __construct()


    {


        add_action( 'wp_ajax_delete_appost',array($this , 'delete_appost') );


        add_action( 'wp_ajax_save_order', array($this , 'save_order') );


        add_action( 'wp_ajax_menu_appost', array($this , 'menu_appost') );


        add_action( 'wp_ajax_menu_appost_icon_delete', array($this , 'menu_appost_icon_delete') );


        add_action( 'wp_ajax_menu_appost_upload_icon', array($this , 'menu_appost_upload_icon') );


    }





    function delete_appost()
    {
        if ( isset($_REQUEST) ) {


            $id = $_REQUEST['id'];


            global $wpdb;


            $table_name = $wpdb->prefix . 'hami_appost';


            $table_option = $wpdb->prefix . 'options';


            $result = $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %d",$id));


            if($result==1)


            {


                $time = current_time( 'mysql' );


                $r = $wpdb->update( $table_option,


                    array( 'option_value' => $time),


                    array( 'option_name' => 'hrt_lastmf_appost' ) );








                echo 1;


            }


            else{


                echo 2;


            }





        }


        else{


            echo "not value";


        }


        //die();


    }





    function save_order()


    {


        //var_dump($_POST["id"]);


        global $wpdb;


        $table_post = $wpdb->prefix . 'hami_appost';


        $table_option = $wpdb->prefix . 'options';


        $r = "";


        $data = (explode("_",$_POST["id"])) ;


        $i = 1;


        foreach($data as $id)


        {


            $r += $wpdb->update( $table_post,


                array( 'order_post' => $i),


                array( 'id' => $id ), array( '%d' ), array( '%d' ) );


            $i++;


        }


        $time = current_time( 'mysql' );


        $r = $wpdb->update( $table_option,


            array( 'option_value' => $time),


            array( 'option_name' => 'hrt_lastmf_appost' ) );


        echo $r;





        //do_action("order_post_changed");


    }





    function menu_appost(){





        $menu = $_REQUEST['id'] ;


        global $wpdb;


        $posts = $wpdb->prefix . 'posts';


        $table_post = $wpdb->prefix . 'hami_appost';





        $records = $wpdb->get_results("select * from $table_post where menu = $menu ORDER BY order_post ASC");


        ?>


        <?php

        $i = -1;
         $exp_time = get_option('exp_time_WP2APPIR');
	    $exp = 1;
        foreach($records as $record){
        $i++;
           

            $rec = $wpdb->get_results("select post_title from $posts


											where id like '$record->post_id'");





            if(!empty($rec))


            {


                foreach($rec as $r){


                    ?>


                    <li id="selected_post_<?php echo $record->id; ?>" style="<?= ($exp == 1 || $i < 2)?'' : 'opacity:.4;'?>">


                        <div class="alert alert-info class_menu_appost_hover" style="padding-right:2px;height:50px;padding-top:0px;">


                            <div  class="col-md-9  pull-right" style="padding:3px;">


                                <div class="col-md-12" style="padding:0px;margin-top:0px;">


                                    <div class="col-md-11" style="padding:0px;">


                                        <div class="col-md-12" style="padding:0px;">


                                            <div class="col-md-9" style="padding-top:5px;">


                                                <p class="koodak" style="font-weight : 900;font-size:17px;">


                                                    <?php echo $this->character_limiter($r->post_title); ?>


                                                </p>


                                            </div>


                                            <div class="col-md-3">


                                                <?php if( $record->icon != "" || $record->icon != null || !empty($record->icon) ){ ?>





                                                    <img class="preview" style="cursor:pointer;padding-bottom:3px;border-radius:50%;" onclick="img_icon_menu_appost(<?php echo $record->id; ?>)" src="<?php echo $record->icon; ?>" width="45px" height="45px">





                                                <?php } ?>


                                            </div>


                                        </div>


                                    </div>


                                    <div class="col-md-1" style="padding:0px;padding-top:5px;padding-right:5px;">


                                        <!--<button id="upload_image_button_hami" class="btn btn-primary btn-xs" >-->





                                        <label id="upload_image_button_hami" title="انتخاب آیکون برای منو" class="fa fa-2x fa-file-picture-o"></label>


                                        <!--</button>-->


                                        <input type="hidden" value="<?php echo $record->id; ?>">


                                    </div>


                                </div>


                            </div>


                            <div style="margin-top:15px;" class="col-md-3  pull-right">


                                <input type="hidden" name="id[]" value="<?= $record->id; ?>" />


                                <p title="حذف از منو" onclick="del_selected_post(<?php echo $record->id; ?>)" class="fa fa-times" style="float:left;font-size:18px;text-decoration:none;cursor: pointer;"> </p>


                            </div>


                        </div>


                    </li>


                <?php


                }//end foreach


            }else{

                $title = "";


                if($record->type == 3)  $title = "لینک";


                if($record->type == 4)  $title = "تماس";


                if($record->type == 5)  $title = "پیامک";


                if($record->type == 6)  $title = "جست و جو";


                if($record->type == 7)  $title = "خودبلوتوثی";


                if($record->type == 8)  $title = "خروج از اپلیکیشن";


                ?>

                <li id="selected_post_<?php echo $record->id; ?>" style="<?= ($exp == 1 || $i < 2)?'' : 'opacity:.4;'?>">


                    <div class="alert alert-info class_menu_appost_hover" style="padding-right:2px;height:50px;padding-top:0;">


                        <div  class="col-md-9  pull-right" style="padding:3px;">


                            <div class="col-md-12" style="padding:0px;margin-top:0px;">


                                <div class="col-md-11" style="padding:0px;">


                                    <div class="col-md-12" style="padding:0px;">


                                        <div class="col-md-9" style="padding-top:5px;">


                                            <p class="koodak" style="font-weight : 900;font-size:17px;">


                                                <?php if($record->title == null || $record->title == "" || empty($record->title) ) {


                                                    echo $title;


                                                }else {


                                                    echo $this->character_limiter($record->title);


                                                }


                                                ?>


                                            </p>


                                        </div>


                                        <div class="col-md-3">


                                            <?php if( $record->icon != "" || $record->icon != null || !empty($record->icon) ){ ?>





                                                <img  class="preview" style="cursor:pointer;padding-bottom:3px;border-radius:50%;" onclick="img_icon_menu_appost(<?php echo $record->id; ?>)" src="<?php echo $record->icon; ?>" width="45px" height="45px">


                                            <?php } ?>


                                        </div>


                                    </div>


                                </div>


                                <div class="col-md-1" style="padding:0px;padding-top:5px;padding-right:5px;">


                                    <!--<button id="upload_image_button_hami" class="btn btn-primary btn-xs" >-->





                                    <label id="upload_image_button_hami" title="انتخاب آیکون برای منو" class="fa fa-2x fa-file-picture-o"></label>


                                    <!--</button>-->


                                    <input type="hidden" value="<?php echo $record->id; ?>">


                                </div>


                            </div>


                        </div>


                        <div style="margin-top:15px;" class="col-md-3  pull-right">


                            <input type="hidden" name="id[]" value="<?= $record->id; ?>" />


                            <p title="حذف از منو" onclick="del_selected_post(<?php echo $record->id; ?>)" class="fa fa-times" style="float:left;font-size:18px;text-decoration:none;cursor: pointer;"> </p>


                        </div>


                    </div>


                </li>


            <?php


            }


        }


        ?>


    <?php





    }








    function menu_appost_icon_delete(){





        if ( isset($_REQUEST) ) {


            $id = $_REQUEST['id'];


            global $wpdb;


            $table_name = $wpdb->prefix . 'hami_appost';


            $table_option = $wpdb->prefix . 'options';


            echo $result = $wpdb->update( $table_name,


                array( 'icon' => ""),


                array( 'id' => $id ) );


            if($result==1)


            {


                $time = current_time( 'mysql' );


                $r = $wpdb->update( $table_option,


                    array( 'option_value' => $time),


                    array( 'option_name' => 'hrt_lastmf_appost' ) );





                echo 1;


            }else{


                echo 2;


            }





        }


        else{


            echo "not value";


        }


    }








    function menu_appost_upload_icon(){


        $url = $_REQUEST['url'];


        $id = $_REQUEST['id'];


        global $wpdb;


        $table_post = $wpdb->prefix . 'hami_appost';


        $table_option = $wpdb->prefix . 'options';


        $r = $wpdb->update( $table_post,


            array( 'icon' => $url),


            array( 'id' => $id ) );


        if($r){


            $time = current_time( 'mysql' );


            $r = $wpdb->update( $table_option,


                array( 'option_value' => $time),


                array( 'option_name' => 'hrt_lastmf_appost' ) );


            echo $r;


        }


    }








    function character_limiter($str, $n = 30, $end_char = '&#8230;')


    {


        if (strlen($str) < $n)


        {


            return $str;


        }


        $str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));


        if (strlen($str) <= $n)


        {


            return $str;


        }


        $out = "";


        foreach (explode(' ', trim($str)) as $val)


        {


            $out .= $val.' ';


            if (strlen($out) >= $n)


            {


                $out = trim($out);


                return (strlen($out) == strlen($str)) ? $out : $out.$end_char;


            }


        }


    }





}