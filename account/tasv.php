<?php
/**
 * Created by Mr2app.
 * User: Hani
 * Date: 11/18/2018
 * Time: 6:52 PM
 */

$currency = get_woocommerce_currency_symbol();
$current_url = admin_url().'admin.php?page=wp2appir/account/tasv.php';
if(isset($_GET["tab"]))	$tab = $_GET["tab"];
else $tab = 'checkout';
?>

<div class="wrap">
    <h2 class="nav-tab-wrapper koodak">
        <a href="<?= $current_url.'&tab=checkout' ?>" class="nav-tab <?php echo ('checkout' == $tab) ? 'nav-tab-active' : ''; ?>"> مدیریت تسویه حساب ها  </a>
        <a href="<?= $current_url.'&tab=setting' ?>" class="nav-tab <?php echo ('setting' == $tab) ? 'nav-tab-active' : ''; ?>">  تنظیمات تسویه حساب </a>
    </h2>

    <?php
    if($tab == 'setting'){
        $setting = array();
        $setting = get_option('woo2app_tasv_setting');
        if(!is_array($setting)){
            $setting = array();
            $setting['commission'] = 0 ;
            $setting['min_number'] = 0 ;
            update_option('woo2app_tasv_setting' , $setting);
        }

        if(isset($_POST['submit_update'])){
            $setting['commission'] = (int) $_POST['commission'];
            $setting['min_number'] = (int) $_POST['min_number'];
            update_option('woo2app_tasv_setting' , $setting);
        }

        ?>
        <h1>
            تنظیم تسویه حساب
        </h1>

        <form method="post">

            <table class="form-table " style="direction: rtl">
                <tbody>
                <tr valign="top" class="" >
                    <th scope="row" class="titledesc">
                        <label for="commission" > مبلغ پورسانت به ازای معرفی کاربر  </label>
                    </th>
                    <td class="forminp">
                        <input type="number"  class="regular-text" name="commission" value="<?= $setting['commission']?>" />
                    </td>
                </tr>
                <tr valign="top" class="" >
                    <th scope="row" class="titledesc">
                        <label> حداقل تعداد معرفی برای تسویه حساب </label>
                    </th>
                    <td class="forminp">
                        <input type="number" class="regular-text" name="min_number" value="<?= $setting['min_number']?>" />
                    </td>
                </tr>
                </tbody>
            </table>

            <input name="submit_update"  class="button button-primary" value="ذخیره‌" type="submit">

        </form>
        <?php
    }
    else{
        global $wpdb;
        $table_name = $wpdb->prefix . "wp2app_checkout";
        if(isset($_GET['for_edit']) && $_GET['for_edit'] != ""){
            $id = $_GET['for_edit'];
            if(isset($_POST['submit_edit_tasv'])){
                $status = $_POST['f_status'];
                $admin_note = $_POST['admin_note'];
                $u = $wpdb->update(
                    $table_name,
                    array(
                        'f_status' => $status,
                        'admin_note' => $admin_note
                    ),
                    array( 'id' => $id )
                );
                if($u) echo 'ویرایش به درستی انجام شد.';
            }
            $rec = $wpdb->get_row("select * from $table_name where id = $id");

            ?>
            <form action="" method="post">
                <table class="form-table " style="direction: rtl">
                    <tbody>
                    <tr valign="top" class="">
                        <th scope="row" class="titledesc">
                            <label > تاریخ </label>
                        </th>
                        <td class="forminp">
                            <label>
                                <?php
                                if(function_exists('jdate')){
                                    echo jdate('Y/m/d - h:i',$rec->f_time);
                                }
                                else echo date('Y/m/d - h:i',$rec->f_time);
                                ?>
                            </label>
                        </td>
                    </tr>
                    <tr valign="top" class="">
                        <th scope="row" class="titledesc">
                            <label > مبلغ </label>
                        </th>
                        <td class="forminp">
                            <label> <?= $rec->amount . ' ' . $currency;?> </label>
                        </td>
                    </tr>
                    <tr valign="top" class="">
                        <th scope="row" class="titledesc">
                            <label > تعداد کاربر </label>
                        </th>
                        <td class="forminp">
                            <label> <?= $rec->user_count;?> </label>
                        </td>
                    </tr>
                    <tr valign="top" class="">
                        <th scope="row" class="titledesc">
                            <label > یادداشت بازاریاب </label>
                        </th>
                        <td class="forminp">
                            <label> <?= $rec->marketer_note;?> </label>
                        </td>
                    </tr>
                    <tr valign="top" class="">
                        <th scope="row" class="titledesc">
                            <label >  وضعیت  </label>
                        </th>
                        <td class="forminp">
                            <select class="form-control"  name="f_status" required="required">
                                <option <?= selected($rec->f_status,'0')?> value="0"> تسویه نشده </option>
                                <option <?= selected($rec->f_status,'1')?> value="1" > تسویه شده </option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top" class="">
                        <th scope="row" class="titledesc">
                            <label >  توضیحات مدیر  </label>
                        </th>
                        <td class="forminp">
                            <textarea name="admin_note"><?= $rec->admin_note?></textarea>
                        </td>
                    </tr>
                    <tr >
                        <th scope="row" class="titledesc">
                        </th>
                        <td class="forminp">
                            <input type="submit"  value="ویرایش" class="button button-primary" name="submit_edit_tasv">
                        </td>
                    </tbody>
                </table>
            </form>
            <?php
        }
        else{
            ?>
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
                $result = $wpdb->get_results("select * from $table_name order by f_time desc ");
                $i = 0;
                foreach ($result  as $r ){
                    $i ++;
                    ?>
                    <tr id="row-<?= $r->id;?>" class="">
                        <td scope="row" class="">
                            <a href="">
                                <label > <?= $i; ?>  </label>
                            </a>
                        </td>
                        <td scope="row" class="">
                            <a href="<?= $current_url.'&for_edit='.$r->id?>">
                                <label >
                                    <?php
                                    if(function_exists('jdate')){
                                        echo jdate('Y/m/d - h:i',$r->f_time);
                                    }
                                    else echo date('Y/m/d - h:i',$r->f_time);
                                    ?>
                                </label>
                            </a>
                        </td>
                        <td scope="row" class="">
                            <a href="">
                                <label >
                                    <?= $r->amount . ' '.$currency ?>
                                </label>
                            </a>
                        </td>
                        <td scope="row" class="">
                            <a href="">
                                <label >
                                    <?= $r->user_count; ?>
                                </label>
                            </a>
                        </td>
                        <td scope="row" class="">
                            <a href="">
                                <label >
                                    <?php
                                    if($r->f_status == 1) echo '<span style="color:green">انجام شده </span>';
                                    if($r->f_status == 0) echo '<span style="color:red">انجام نشده  </span>';
                                    ?>
                                </label>
                            </a>
                        </td>
                        <td scope="row" class="">
                            <a href="">
                                <label >
                                    <?= $r->marketer_note; ?>
                                </label>
                            </a>
                        </td>
                        <td scope="row" class="">
                            <a href="">
                                <label>
                                    <?php
                                    if($r->admin_note != '') echo $r->admin_note;
                                    else{
                                        echo '---------';
                                    }
                                    ?>
                                </label>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <?php
        }
    }
    ?>
</div>
