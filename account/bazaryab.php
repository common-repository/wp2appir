<?php
/**
 * Created by Mr2app.
 * User: Hani
 * Date: 11/18/2018
 * Time: 6:52 PM
 */

$currency = get_woocommerce_currency_symbol();
$current_url="//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(isset($_GET["tab"]))	$tab = $_GET["tab"];
else $tab = 'my_users';
?>

<div class="wrap">
    <h2 class="nav-tab-wrapper">
        <a href="<?= $current_url.'&tab=my_users' ?>" class="nav-tab <?php echo ('my_users' == $tab) ? 'nav-tab-active' : ''; ?>">   لیست معرفی شدگان </a>
        <a href="<?= $current_url.'&tab=tasv' ?>" class="nav-tab <?php echo ('tasv' == $tab) ? 'nav-tab-active' : ''; ?>">   تسویه   </a>
    </h2>
<?php
if($tab == 'my_users'){
?>
<table class="wp-list-table widefat striped" style="margin-top:10px;direction: rtl">
        <tbody>
        <tr valign="top" class="">
            <th scope="row" class="">
                <label > #  </label>
            </th>
            <th scope="row" class="">
                <label > نام کاربری  </label>
            </th>
            <th scope="row" class="">
                <label >  وضعیت تسویه پورسانت  </label>
            </th>
            <th scope="row" class="">
                <label >  زمان  </label>
            </th>
        </tr>
        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . 'wp2app_commission';
        $current_user_id = get_current_user_id();
        $result = $wpdb->get_results("select * from $table_name where marketer_id = $current_user_id order by f_time desc ");
        $i = 0;
        foreach ($result  as $r ){
            $i ++;
            ?>
            <tr class="">
                <td scope="row" class="">
                    <label > <?= $i; ?>  </label>
                </td>
                <td scope="row" class="">
                    <label >
                        <?php
                        $user = get_user_by('ID',$r->user_id);
                        if(!$user) echo 'نا مشخص';
                        else echo   $user->user_login;
                        ?>
                    </label>
                </td>
                <td scope="row" class="">
                    <label >
                        <?php
                        if($r->payed == 1) echo '<span style="color:green">تسویه شده </span>';
                        if($r->payed == 0) echo '<span style="color:red">تسویه نشده  </span>';
                        ?>
                    </label>
                </td>
                <td scope="row" class="">
                    <label >
                        <?php
                        if(function_exists('jdate')){
                            echo jdate('Y/m/d - h:i',$r->f_time);
                        }
                        else echo date('Y/m/d - h:i',$r->f_time);
                        ?>
                    </label>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
<?php
}
elseif($tab == 'tasv'){
    global $wpdb;
    $table_name = $wpdb->prefix . 'wp2app_commission';
    $current_user_id = get_current_user_id();
    $count = $wpdb->get_var("select COUNT(*) as c  from $table_name where (marketer_id = $current_user_id and payed = 0)");
    $tasv = get_option('woo2app_tasv_setting');
    $mablagh_tasv = 0;
    if(isset($tasv['commission'])){
        $mablagh_tasv = (int) $tasv['commission'] * $count;
    }

    if(isset($_POST['submit_tasv']) && $mablagh_tasv > 0 && $count >= (int)$tasv['min_number'] ){
        $marketer_note = $_POST['marketer_note'];
        $table_name = $wpdb->prefix . "wp2app_checkout";
        $r = $wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
            ( user_id , amount , user_count , f_time , f_status , marketer_note , admin_note ) 
            VALUES ( %d, %d, %d, %d , %d , %s , %s )", $current_user_id,$mablagh_tasv, $count ,time(),0 , $marketer_note , '') );
        if($r){
            $wpdb->update( 
                $wpdb->prefix . 'wp2app_commission', 
                array( 
                    'payed' => 1,	// string
                ), 
                array( 'marketer_id' => $current_user_id )
            );
            echo 'ثبت تسویه با موفقیت انجام شد.';
        }
    }
    $count = $wpdb->get_var("select COUNT(*) as c  from $table_name where (marketer_id = $current_user_id and payed = 0)");
    $mablagh_tasv = 0;
    if(isset($tasv['commission'])){
        $mablagh_tasv = (int) $tasv['commission'] * $count;
    }
    ?>
     <form action="" method="post">
        <table class="form-table " style="direction: rtl">
            <tbody>
            <tr valign="top" class="">
                <th scope="row" class="titledesc">
                    <label >  مبلغ تسویه </label>
                </th>
                <td class="forminp">
                    <input type="text" value="<?= $mablagh_tasv.' '.$currency;?>" readonly  name="mablagh_tasv"  placeholder="مبلغ تسویه" >
                </td>
            </tr>

            <tr valign="top" class="el_type" id="title"  >
                <th scope="row" class="titledesc">
                    <label >  توضیحات </label>
                </th>
                <td class="forminp">
                    <textarea name="marketer_note"></textarea>
                </td>
            </tr>
            <tr >
                <th scope="row" class="titledesc">
                </th>
                <td class="forminp">
                    <input type="submit"  value="ثبت تسویه حساب" <?= ($count >= (int)$tasv['min_number'] )? '' : 'disabled' ?> class="button-primary" name="submit_tasv">
                </td>
            </tbody>
        </table>
    </form>
    <table class="wp-list-table widefat striped" style="margin-top:10px;direction: rtl">
        <tbody>
        <tr valign="top" class="">
            <th scope="row" class="">
                <label > #  </label>
            </th>
            <th scope="row" class="">
                <label > تاریخ   </label>
            </th>
            <th scope="row" class="">
                <label >  مبلغ  </label>
            </th>
            <th scope="row" class="">
                <label >  تعداد کاربر  </label>
            </th>
            <th scope="row" class="">
                <label >  وضعیت   </label>
            </th>
            <th scope="row" class="">
                <label >  یادداشت بازاریاب   </label>
            </th>
            <th scope="row" class="">
                <label >  یادداشت مدیر   </label>
            </th>
        </tr>
        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . 'wp2app_checkout';
        $current_user_id = get_current_user_id();
        $result = $wpdb->get_results("select * from $table_name where user_id = $current_user_id order by f_time desc ");
        $i = 0;
        foreach ($result  as $r ){
            $i ++;
            ?>
            <tr class="">
                <td scope="row" class="">
                    <label > <?= $i; ?>  </label>
                </td>
                <td scope="row" class="">
                    <label >
                        <?php
                        if(function_exists('jdate')){
                            echo jdate('Y/m/d - h:i',$r->f_time);
                        }
                        else echo date('Y/m/d - h:i',$r->f_time);
                        ?>
                    </label>
                </td>
                <td scope="row" class="">
                    <label >
                        <?= $r->amount . ' '.$currency ?>
                    </label>
                </td>
                <td scope="row" class="">
                    <label >
                        <?= $r->user_count; ?>
                    </label>
                </td>
                <td scope="row" class="">
                    <label >
                    <?php
                       if($r->f_status == 1) echo '<span style="color:green">انجام شده </span>';
                       if($r->f_status == 0) echo '<span style="color:red">انجام نشده  </span>';
                        ?>
                    </label>
                </td>
                <td scope="row" class="">
                    <p >
                        <?= $r->marketer_note; ?>
                    </p>
                </td>
                <td scope="row" class="">
                    <p >
                        <?= $r->admin_note; ?>
                    </p>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <?php
}
?>
</div>