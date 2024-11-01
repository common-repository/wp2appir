<?php
if (!defined( 'ABSPATH' )) exit;
wp_register_style( 'bootstrap', WP2APPIR_CSS_URL.'bootstrap.css'  );
wp_enqueue_style( 'bootstrap' );
wp_register_style( 'bootstrap-select', WP2APPIR_CSS_URL.'bootstrap-select.css'  );
wp_enqueue_style( 'bootstrap-select' );
?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <div class="col-md-12" id="custom_slider" style="padding:0px;margin-top:10px;">
        <div id="add_slider_hami_div" class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    افزودن اسلایدر جدید
                </div>
                <div class="panel-body">
                    <input type="hidden" name="woo2app-ajax-nonce" id="woo2app-ajax-nonce" value="<?php echo wp_create_nonce( 'woo2app-ajax-nonce' ); ?>" />
                    <div class="col-md-12" style="margin-bottom:5px;">
                        <label>عنوان اسلایدر را وارد نمایید:</label>
                        <br>
                        <input id="txt_title_hami_slider_shop" type="text" class="regular-text">
                        <div class="alert alert-danger hide" style="padding:2px;">
                            لطفا عنوان را وارد نمایید.
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-bottom:5px;">
                        <label>اکشن:</label>
                        <br>
                        <select class="regular-text" id="select_action_slider">
                            <option value="1" selected="">پست ها</option>
                            <option value="2">دسته بندی</option>
                            <option value="3">لینک</option>
                        </select>
                        <div class="alert alert-danger hide" style="padding:2px;">
                            لطفا اکشن مورد نظر خود را انتخاب نمایید.
                        </div>
                    </div>

                    <div class="col-md-12"  id="get_all_post_for_type">
                        <select style="width: 100%" id="value_post_slider"  class="js-data-example-ajax regular-text"></select>
                        <div class="alert alert-danger hide" style="padding:2px;">
                            لطفا پست خود را انتخاب کنید.
                        </div>
                    </div>
                    <div class="hide" id="get_all_cat_for_type">
                        <select id="value_cat_slider" class="selectpicker col-md-12 regular-text" data-live-search="true" title="انتخاب کنید...">
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
                        <div class="alert alert-danger hide" style="padding:2px;">
                            لطفا دسته خود را انتخاب کنید.
                        </div>
                    </div>

                    <div class="col-md-12 col-md-div_image_slider_hami12 hide" id="get_link_for_type">
                        <p>
                            در صورتی که میخواهید به یک برگه یا پست لینک ایجاد کند میتوانید
                            <a href="https://mr2app.com/blog/wp-page-link" target="_blank">
                                این آموزش
                            </a>
                            را مطالعه کنید
                        </p>
                        <input id="value_link_slider" type="text" class="form-control" placeholder="لینک خود را وارد نمایید">
                    </div>

                    <div id="add_item_hami_div" class="pull-right" style="margin-top: 10px">
                        <div class="">
                            <img id="btn_url_slider_hami" class="banner imgslider" src="http://placehold.it/1024x512&text=2x1">
                            <small class="">
                                <hr class="hr_info_image">
                                بهترین نسب تصویر : 2x1
                                <hr class="hr_info_image">
                                رزولوشن پیشنهادی : 1024x512
                                <hr class="hr_info_image">
                                حداکثر حجم پیشنهادی تصویر : 150KB
                                <hr class="hr_info_image">
                                فرمت تصاویر : PNG - JPG - JPEG - GIF
                            </small>
                        </div>
                        <div class="col-md-12 pull-right" id="div_image_item_hami" style=""></div>
                    </div>
                    <div class="col-md-12" style="margin-bottom:5px;">
                        <input id="txt_url_slider_hami" type="hidden" class="form-control">
                        <div class="alert alert-danger hide pull-right" style="padding:2px;">
                            لطفا تصویر خود را انتخاب کنید.
                        </div>
                    </div>
                    <div id="div_image_slider_hami" class="col-md-12 hide" style="height:100px;">
                    </div>

                    <div class="col-md-12" style="margin-top:10px;">
                        <div class="col-md-8 " >
                            <button onclick="add_slider_hami_wp2app()" type="button" class="btn btn-primary btn-sm pull-left">افزودن اسلایدر</button>
                        </div>
                        <div class="col-md-4 ">
                            <img style="width:50px;height:50px;" id="img_load" class="hide" src="<?php echo WP2APPIR_JS_URL.'../img/page-loader.gif' ?>">
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top:15px;">
                        <div id="alert_all_slider_add" class="alert alert-danger hide" style="padding:2px;">
                            خطا در سرور لطفا دوباره امتحان کنید.
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    لیست اسلایدر ها
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th style="text-align:right;">#</th>
                                <th style="text-align:right;">نام اسلایدر</th>
                                <th style="text-align:right;">عملیات</th>
                            </tr>
                            </thead>
                            <tbody id="contain_rows_slider_hami">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
wp_enqueue_media();
wp_enqueue_script( 'upload_slider.js' , WP2APPIR_JS_URL.'upload_slider.js', array('jquery'));
wp_enqueue_script( 'oprate_setting_hami.js' , WP2APPIR_JS_URL.'oprate_setting_hami.js', array('jquery'));
wp_enqueue_script( 'loadajax.js' , WP2APPIR_JS_URL.'loadAjaxPosts.js', array('jquery'));
?><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script><?php
wp_enqueue_script( 'bootstrap-select.js' , WP2APPIR_JS_URL.'bootstrap-select.js', array('jquery'));
?>
