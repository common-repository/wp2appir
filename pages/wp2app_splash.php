<style>
    .banner:hover{
        border:2px solid #555;
    }
</style>
<?php
$wp2app_setting = get_option('wp2app_splash');
if(!is_array($wp2app_setting)){
    $wp2app_setting = array();
    $wp2app_setting['URL_SPLASH_PIC'] = '';
    update_option('wp2app_splash' , $wp2app_setting);
}

if(isset($_POST['submit_banner'])){
    $wp2app_setting['URL_SPLASH_PIC'] = $_POST['src_val'];
    update_option('wp2app_splash' , $wp2app_setting);
}
?>

<p>
    صفحه اسپلش اولین صفحه ای هست که بعد از هر بار اجرا شدن اپلیکیشن نمایش داده میشود ٬ در این صفحه کاربر باید تا لود شدن تنظیمات اپلیکیشن صبر کند
</p>
<form action="" method="post">
    <table class="form-table" style="direction: rtl">
        <tbody>
        <tr >
            <th scope="row" class="titledesc">
                <label dir="rtl">انتخاب اسپلش</label>
                <br><br>
                <small>
                    رزولوشن پیشنهادی : 750x1334
                    <hr>
                    حداکثر حجم پیشنهادی تصویر : 150KB
                    <hr>
                    فرمت تصاویر : PNG - JPG - JPEG - GIF
                </small>
            </th>
            <td class="forminp">
                <input type="hidden" id="txt_url_item_hami" value="<?= $wp2app_setting['URL_SPLASH_PIC']?>" name="src_val">
                <img id="div_image_item_hami" class="banner" style="cursor: pointer;width: 187.5px;height: 333.5px" src="<?= $wp2app_setting['URL_SPLASH_PIC'] ? $wp2app_setting['URL_SPLASH_PIC'] : 'http://placehold.it/1334x750'?> ">
            </td>
        </tr>
        <tr >
            <th scope="row" class="titledesc">
            </th>
            <td class="forminp">
                <input type="hidden" name="submit_banner" value="1">
                <input type="submit"  class="button button-primary" value="ذخیره"  name="submit_banner">
                <input type="button"  onclick="submit_cancel()" class="button button-default" value="پاک"   />
            </td>
        </tbody>
    </table>
</form>
<?php wp_enqueue_media();?>
<script>
    var custom_uploader_hami;
    jQuery('#div_image_item_hami').click(function (e) {
        e.preventDefault();
        custom_uploader_hami = wp.media.frames.custom_uploader_hami = wp.media({
            title: 'انتخاب تصویر',
            library: {type: 'image'},
            button: {text: 'انتخاب'},
            multiple: false
        });
        custom_uploader_hami.on('select', function() {
            attachment = custom_uploader_hami.state().get('selection').first().toJSON();
            jQuery('#txt_url_item_hami').val(attachment.url);
            url_image = attachment.url;
            jQuery('#div_image_item_hami').attr("src",url_image);
        });
        custom_uploader_hami.open();
    })
    function submit_cancel() {
        if(confirm("مطمئن به حذف اسپلش هستید ؟")){
            jQuery("#txt_url_item_hami").val('');
            jQuery("#div_image_item_hami").attr('src','http://placehold.it/1334x750');
            jQuery("#delay_splash").val(0)
            jQuery("form").submit()
        }
    }
</script>