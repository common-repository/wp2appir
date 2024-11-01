<?php
if (!defined( 'ABSPATH' )) exit;

wp_register_style( 'bootstrap', WP2APPIR_CSS_URL.'bootstrap.css'  );
wp_enqueue_style( 'bootstrap' );
wp_register_style( 'bootstrap-select', WP2APPIR_CSS_URL.'bootstrap-select.css'  );
wp_enqueue_style( 'bootstrap-select' );
wp_register_style( 'font-awesome', WP2APPIR_CSS_URL.'font-awesome.css'  );
wp_enqueue_style('font-awesome');

//var_dump(get_tags_wp2app());
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


<div class="col-md-12" style="padding:0;padding-top: 10px;">

    <div class="col-md-5 pull-right">
        <div class="panel panel-primary">
            <div class="panel-heading">
                چینمان اصلی
            </div>
            <div class="panel-body">
                <form name="form_sort" id="form_sort" method="post" action="">
                    <ul id="sortable">

                    </ul>
                </form>
                <div class="col-md-12 text-left" style="margin-top:15px;">
                    <button  id="btn_form_order" class="btn btn-primary btn-sm">
                        مرتب سازی
                    </button>
                </div>
                <div class="col-md-12" style="margin-top:15px;">
                    <div class="alert alert-success hide" id="alert_sort">

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-7 pull-right">
        <div class="panel panel-primary">
            <div class="panel-heading">
                آیتم جدید
            </div>
            <div class="panel-body">
                <div class="col-md-12 pull-right">
                    <div class="col-md-3 pull-right">
                        <p>
                            <input checked="" type="radio" class="form-control" value="1" name="select_item_option" id="banner_item_select">
                            <span>بنر</span>
                        </p>
                    </div>
                    <div class="col-md-3 pull-right">
                        <p>
                            <input  type="radio" class="form-control" value="2" name="select_item_option" id="ver_item_select">
                            <span>لیست افقی</span>
                        </p>
                    </div>
                    <div class="col-md-3 pull-right">
                        <p>
                            <input  type="radio" class="form-control" value="3" name="select_item_option" id="hor_item_select">
                            <span>لیست عمودی</span>
                        </p>
                    </div>
                    <div class="col-md-3 pull-right">
                        <p>
                            <input  type="radio" class="form-control" value="4" name="select_item_option" id="banner4_item_select">
                            <span>بنر4تایی</span>
                        </p>
                    </div>

<!--                    <div class="col-md-3 pull-right">-->
<!--                        <p>-->
<!--                            <input  type="radio" class="form-control" value="7" name="select_item_option" id="banner4_item_select">-->
<!--                            <span> بنر ۳ تایی </span>-->
<!--                        </p>-->
<!--                    </div>-->
<!---->
<!--                    <div class="col-md-3 pull-right">-->
<!--                        <p>-->
<!--                            <input  type="radio" class="form-control" value="8" name="select_item_option" id="banner4_item_select">-->
<!--                            <span> بنر ۳ تایی - خطی</span>-->
<!--                        </p>-->
<!--                    </div>-->
<!--                    <div class="col-md-3 pull-right">-->
<!--                        <p>-->
<!--                            <input  type="radio" class="form-control" value="9" name="select_item_option" id="banner4_item_select">-->
<!--                            <span> بنر ۲ تایی </span>-->
<!--                        </p>-->
<!--                    </div>-->
                </div>

                <div class="div_banner">
                    <div class="col-md-12 pull-right">
                        <p>عنوان آیتم جدید :</p>
                    </div>
                    <div class="col-md-12 pull-right">
                        <input type="text" class="form-control" name="txt_title_banner_item" id="txt_title_banner_item">
                    </div>
                    <div class="col-md-12 pull-right" style="margin-top:10px;">
                        <p>اکشن:</p>

                        <select class="form-control" id="select_action_banner">
                            <option value="1" selected="">پست ها</option>
                            <option value="2">دسته بندی</option>
                            <option value="3">لینک</option>
                        </select>
                        <div class="alert alert-danger hide" style="padding:2px;">
                            لطفا اکشن مورد نظر خود را انتخاب نمایید.
                        </div>
                    </div>

                    <div class="col-md-12 pull-right" id="product_list" style="width:100%;margin-top:10px;">
                        <select name="product" id="value_post_items"  class="js-data-example-ajax form-control"></select>
                    </div>
                    <div class="pull-right hide" id="category_list" style="margin-top:10px;width: 100%">
                        <select id="value_cat_items" class="selectpicker col-md-12" data-live-search="true" title="انتخاب کنید...">
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

                    <div class="col-md-12 pull-right hide" id="link_list" style="margin-top:10px;">
                        <p>
                            در صورتی که میخواهید به یک برگه یا پست لینک ایجاد کند میتوانید
                            <a href="https://mr2app.com/blog/wp-page-link" target="_blank">
                                این آموزش
                            </a>
                            را مطالعه کنید
                        </p>
                        <input id="value_link_items" type="text" class="form-control" placeholder="لینک خود را وارد نمایید">
                    </div>

                    <div id="add_item_hami_div" class="pull-right" style="margin-top: 10px">
                        <div class="">
                            <img id="btn_sel_pic_banner" onclick="cahnge_image(0)" class="banner" style="cursor: pointer;width: 450px;height: 150px" src="http://placehold.it/750x250&text=3x1">
                            <small class="">
                                <hr class="hr_info_image">
                                بهترین نسب تصویر : 3x1
                                <hr class="hr_info_image">
                                رزولوشن پیشنهادی : 1500x500
                                <hr class="hr_info_image">
                                حداکثر حجم پیشنهادی تصویر : 150KB
                                <hr class="hr_info_image">
                                فرمت تصاویر : PNG - JPG - JPEG - GIF
                            </small>
                            <input type="hidden" id="txt_url_item_hami">
                        </div>
                        <div class="col-md-12 pull-right" id="div_image_item_hami" style=""></div>
                    </div>

                </div>

                <div class="div_list_horizontal hide">
                    <div class="col-md-12 pull-right">
                        <p>عنوان آیتم جدید :</p>
                    </div>
                    <div class="col-md-12 pull-right">
                        <input type="text" class="form-control" name="txt_title_hor_item" id="txt_title_hor_item">
                    </div>
                    <div class="form-group col-md-12">
                        <p>اکشن:</p>

                        <select class="form-control" id="select_action_hor_item">
                            <option value="1" selected=""> دسته بندی </option>
                            <option value="2">  لیست پست ها  </option>
                            <option value="3"> تگ ها </option>
                        </select>
                    </div>

                    <div class="from-group horizontal_item" id="hor_category_list" style="width:100%;margin-top:15px;">
                        <select id="value_cat_items_hor" multipl="multiple" class="selectpicker col-md-12" data-live-search="true" title="انتخاب کنید...">
                            <option value="-1" style="text-align:right;"> تمام دسته ها </option>
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

                    <div class="col-md-12 from-group horizontal_item hide" id="hor_post_list" >
                        <select style="width: 100%" id="value_post_items_hor" multiple="multiple"  class="js-data-example-ajax form-control"></select>
                    </div>
                    <div class="col-md-12 from-group horizontal_item hide" id="hor_tag_list" >
                    <select style="width: 100%" id="value_tag_items_hor" data-id="tag" multiple="multiple"  class="js-data-example-ajax form-control"></select>

                    </div>

                    <div class="form-group col-md-12" id="category_list" style="margin-top: 10px">
                        <p> مرتب سازی </p>
                        <select id="select_sort_hor" class="form-control">
                            <option value="newest" style="text-align:right;"> جدیدترین </option>
                            <option value="most_visited" style="text-align:right;"> بازدید </option>
                            <option value="most_liked" style="text-align:right;"> لایک </option>
                        </select>
                    </div>
                </div>

                <div class="div_list_vertical hide">
                    <div class="form-group col-md-12">
                        <p>عنوان آیتم جدید :</p>
                        <input type="text" class="form-control" name="txt_title_ver_item" id="txt_title_ver_item">
                    </div>
                    <div class="form-group col-md-12">
                        <p>اکشن:</p>

                        <select class="form-control" id="select_action_ver_item">
                            <option value="1" selected=""> دسته بندی </option>
                            <option value="2">  لیست پست ها  </option>
                            <option value="3"> تگ ها </option>
                        </select>
                        <div class="alert alert-danger hide" style="padding:2px;">
                            لطفا اکشن مورد نظر خود را انتخاب نمایید.
                        </div>
                    </div>

                    <div class="from-group vertical_item" id="ver_category_list" >
                        <select  id="value_cat_items_ver" multipl="multiple" class="selectpicker col-md-12  " data-live-search="true" title="انتخاب کنید...">
                            <option value="-1" style="text-align:right;"> تمام دسته ها </option>
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
                    <div class="col-md-12 from-group vertical_item hide" id="ver_post_list" >
                        <select style="width: 100%" id="value_post_items_ver" multiple="multiple"  class="js-data-example-ajax form-control"></select>
                    </div>
                    <div class="col-md-12 from-group vertical_item hide" id="ver_tag_list" >
                        <select style="width: 100%" id="value_tag_items_ver" data-id="tag" multiple="multiple"  class="js-data-example-ajax form-control"></select>
                    </div>


                    <div class="form-group col-md-12" id="category_list" style="margin-top: 10px">
                        <p> مرتب سازی </p>
                        <select id="select_sort_ver" class="form-control">
                            <option value="newest" style="text-align:right;"> جدیدترین </option>
                            <option value="most_visited" style="text-align:right;"> بازدید </option>
                            <option value="most_liked" style="text-align:right;"> لایک </option>
                        </select>
                    </div>
                </div>

                <div class="div_4_banner hide">
                    <div class="clearfix"></div>
                    <hr>
                    <div class="form-group  col-md-12" id="div_height">
                        <label>ارتفاع عکس (درصد)</label>
                        <input type="text" class="form-control" id="height"/>
                    </div>
                    <div class="div_banner1 col-md-12" style="border:1px solid #9C5D90;padding:5px;border-radius:3px;">
                        <div class="col-md-12 pull-right">
                            <p>عنوان آیتم جدید (بنر 1):</p>
                        </div>
                        <div class="col-md-12 pull-right">
                            <input type="text" class="form-control" name="txt_title_4banner1_item" id="txt_title_4banner1_item">
                        </div>
                        <div class="col-md-12 pull-right" style="margin-top:5px;">
                            <p>اکشن:</p>

                            <select class="form-control" id="select_action_banner1">
                                <option value="1" selected="">پست ها</option>
                                <option value="2">دسته بندی</option>
                                <option value="3">لینک</option>
                            </select>
                            <div class="alert alert-danger hide" style="padding:2px;">
                                لطفا اکشن مورد نظر خود را انتخاب نمایید.
                            </div>
                        </div>

                        <div class="col-md-12 pull-right" style="margin-top: 10px;" id="product_list1">
                            <select style="width: 100%" id="value_post_items1"  class="js-data-example-ajax form-control"></select>
                        </div>
                        <div class="pull-right hide" id="category_list1" style="width: 100%;margin-top:10px">
                            <select id="value_cat_items1" class="selectpicker col-md-12" data-live-search="true" title="انتخاب کنید...">
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
                        <div class="col-md-12 pull-right hide" id="link_list1" style="margin-top:10px;">
                            <p>
                                در صورتی که میخواهید به یک برگه یا پست لینک ایجاد کند میتوانید
                                <a href="https://mr2app.com/blog/wp-page-link" target="_blank">
                                    این آموزش
                                </a>
                                را مطالعه کنید
                            </p>
                            <input id="value_link_items1" type="text" class="form-control" placeholder="لینک خود را وارد نمایید">
                        </div>
                        <div id="add_item_hami_div1" class="pull-right" style="margin-top: 10px">
                            <div class="">
                                <img id="btn_sel_pic_banner1" onclick="cahnge_image(1)" class="imgbn4 banner"  src="http://placehold.it/250x250&text=1x1">
                                <small class="pull-left">
                                    <hr class="hr_info_image">
                                    بهترین نسب تصویر : 1x1
                                    <hr class="hr_info_image">
                                    رزولوشن پیشنهادی : 512x512
                                    <hr class="hr_info_image">
                                    حداکثر حجم پیشنهادی تصویر : 150KB
                                    <hr class="hr_info_image">
                                    فرمت تصاویر : PNG - JPG - JPEG - GIF
                                </small>
                                <input type="hidden" id="txt_url_item_hami1">
                            </div>
                        </div>
                    </div>
                    <div class="div_banner2 col-md-12" style="border:1px solid #9C5D90;padding:5px;border-radius:3px;">
                        <div class="col-md-12 pull-right">
                            <p>عنوان آیتم جدید (بنر 2):</p>
                        </div>
                        <div class="col-md-12 pull-right">
                            <input type="text" class="form-control" name="txt_title_4banner2_item" id="txt_title_4banner2_item">
                        </div>
                        <div class="col-md-12 pull-right" style="margin-top:5px;">
                            <p>اکشن:</p>

                            <select class="form-control" id="select_action_banner2">
                                <option value="1" selected="">پست ها</option>
                                <option value="2">دسته بندی</option>
                                <option value="3">لینک</option>
                            </select>
                            <div class="alert alert-danger hide" style="padding:2px;">
                                لطفا اکشن مورد نظر خود را انتخاب نمایید.
                            </div>
                        </div>

                        <div class="col-md-12 pull-right" id="product_list2" style="margin-top: 10px">
                            <select style="width: 100%" id="value_post_items2"  class="js-data-example-ajax form-control"></select>
                        </div>
                        <div class="pull-right hide" id="category_list2" style="width: 100%;margin-top: 10px;">
                            <select id="value_cat_items2" class="selectpicker col-md-12" data-live-search="true" title="انتخاب کنید...">
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
                        <div class="col-md-12 pull-right hide" id="link_list2" style="margin-top:10px;">
                            <p>
                                در صورتی که میخواهید به یک برگه یا پست لینک ایجاد کند میتوانید
                                <a href="https://mr2app.com/blog/wp-page-link" target="_blank">
                                    این آموزش
                                </a>
                                را مطالعه کنید
                            </p>
                            <input id="value_link_items2" type="text" class="form-control" placeholder="لینک خود را وارد نمایید">
                        </div>
                        <div id="add_item_hami_div2" class="pull-right" style="margin-top: 10px">
                            <div class="">
                                <img id="btn_sel_pic_banner2" onclick="cahnge_image(2)" class="imgbn4 banner"  src="http://placehold.it/250x250&text=1x1">
                                <small class="pull-left">
                                    <hr class="hr_info_image">
                                    بهترین نسب تصویر : 1x1
                                    <hr class="hr_info_image">
                                    رزولوشن پیشنهادی : 512x512
                                    <hr class="hr_info_image">
                                    حداکثر حجم پیشنهادی تصویر : 150KB
                                    <hr class="hr_info_image">
                                    فرمت تصاویر : PNG - JPG - JPEG - GIF
                                </small>
                                <input type="hidden" id="txt_url_item_hami2">
                            </div>
                        </div>
                    </div>
                    <div class="div_banner3 col-md-12" style="border:1px solid #9C5D90;padding:5px;border-radius:3px;">
                        <div class="col-md-12 pull-right">
                            <p>عنوان آیتم جدید (بنر 3):</p>
                        </div>
                        <div class="col-md-12 pull-right">
                            <input type="text" class="form-control" name="txt_title_4banner3_item" id="txt_title_4banner3_item">
                        </div>
                        <div class="col-md-12 pull-right" style="margin-top:5px;">
                            <p>اکشن:</p>

                            <select class="form-control" id="select_action_banner3">
                                <option value="1" selected="">پست ها</option>
                                <option value="2">دسته بندی</option>
                                <option value="3">لینک</option>
                            </select>
                            <div class="alert alert-danger hide" style="padding:2px;">
                                لطفا اکشن مورد نظر خود را انتخاب نمایید.
                            </div>
                        </div>

                        <div class="col-md-12 pull-right" id="product_list3" style="margin-top: 10px;">
                            <select style="width: 100%" id="value_post_items3"  class="js-data-example-ajax form-control"></select>
                        </div>
                        <div class="pull-right hide" id="category_list3" style="width: 100%;margin-top: 10px">
                            <select id="value_cat_items3" class="selectpicker col-md-12" data-live-search="true" title="انتخاب کنید...">
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
                        <div class="col-md-12 pull-right hide" id="link_list3" style="margin-top:10px;">
                            <p>
                                در صورتی که میخواهید به یک برگه یا پست لینک ایجاد کند میتوانید
                                <a href="https://mr2app.com/blog/wp-page-link" target="_blank">
                                    این آموزش
                                </a>
                                را مطالعه کنید
                            </p>
                            <input id="value_link_items3" type="text" class="form-control" placeholder="لینک خود را وارد نمایید">
                        </div>
                        <div id="add_item_hami_div3" class="pull-right" style="margin-top: 10px">
                            <div class="">
                                <img id="btn_sel_pic_banner3" onclick="cahnge_image(3)" class="imgbn4 banner"  src="http://placehold.it/250x250&text=1x1">
                                <small class="pull-left">
                                    <hr class="hr_info_image">
                                    بهترین نسب تصویر : 1x1
                                    <hr class="hr_info_image">
                                    رزولوشن پیشنهادی : 512x512
                                    <hr class="hr_info_image">
                                    حداکثر حجم پیشنهادی تصویر : 150KB
                                    <hr class="hr_info_image">
                                    فرمت تصاویر : PNG - JPG - JPEG - GIF
                                </small>
                                <input type="hidden" id="txt_url_item_hami3">
                            </div>
                        </div>
                    </div>
                    <div class="div_banner4 col-md-12" style="border:1px solid #9C5D90;padding:5px;border-radius:3px;">
                        <div class="col-md-12 pull-right">
                            <p>عنوان آیتم جدید (بنر 4):</p>
                        </div>
                        <div class="col-md-12 pull-right">
                            <input type="text" class="form-control" name="txt_title_4banner4_item" id="txt_title_4banner4_item">
                        </div>
                        <div class="col-md-12 pull-right" style="margin-top:5px;">
                            <p>اکشن:</p>

                            <select class="form-control" id="select_action_banner4">
                                <option value="1" selected="">پست ها</option>
                                <option value="2">دسته بندی</option>
                                <option value="3">لینک</option>
                            </select>
                            <div class="alert alert-danger hide" style="padding:2px;">
                                لطفا اکشن مورد نظر خود را انتخاب نمایید.
                            </div>
                        </div>

                        <div class="col-md-12 pull-right" id="product_list4" style="margin-top: 10px">
                            <select style="width: 100%" id="value_post_items4"   class="js-data-example-ajax form-control"></select>
                        </div>
                        <div class="pull-right hide" id="category_list4" style="width: 100%;margin-top: 10px">
                            <select id="value_cat_items4" class="selectpicker col-md-12" data-live-search="true" title="انتخاب کنید...">
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
                        <div class="col-md-12 pull-right hide" id="link_list4" style="margin-top:10px;">
                            <p>
                                در صورتی که میخواهید به یک برگه یا پست لینک ایجاد کند میتوانید
                                <a href="https://mr2app.com/blog/wp-page-link" target="_blank">
                                    این آموزش
                                </a>
                                را مطالعه کنید
                            </p>
                            <input id="value_link_items4" type="text" class="form-control" placeholder="لینک خود را وارد نمایید">
                        </div>
                        <div id="add_item_hami_div4" class="pull-right" style="margin-top: 10px">
                            <div class="">
                                <img id="btn_sel_pic_banner4" onclick="cahnge_image(4)" class="imgbn4 banner"  src="http://placehold.it/250x250&text=1x1">
                                <small class="pull-left">
                                    <hr class="hr_info_image">
                                    بهترین نسب تصویر : 1x1
                                    <hr class="hr_info_image">
                                    رزولوشن پیشنهادی : 512x512
                                    <hr class="hr_info_image">
                                    حداکثر حجم پیشنهادی تصویر : 150KB
                                    <hr class="hr_info_image">
                                    فرمت تصاویر : PNG - JPG - JPEG - GIF
                                </small>
                                <input type="hidden" id="txt_url_item_hami4">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 text-left" style="margin-top:15px;">
                    <button onclick ="add_item_mainpage()" type="button" class="btn btn-primary btn-sm">افزودن آیتم</button>
                </div>
                <div class="col-md-12 pull-right" style="margin-top:15px;">
                    <div class="alert alert-danger hide"  id="alert_item">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
wp_enqueue_script( 'jquery-ui.js' , WP2APPIR_JS_URL.'jquery-ui.js', array('jquery'));
wp_enqueue_script( 'sort.js' , WP2APPIR_JS_URL.'sort_mainpage.js', array('jquery') , '2.6.0-c');
wp_enqueue_script( 'loadajax.js' , WP2APPIR_JS_URL.'loadAjaxPosts.js', array('jquery'));
wp_enqueue_media();
wp_enqueue_script( 'upload_item_banner.js' , WP2APPIR_JS_URL.'upload_item_banner.js', array('jquery'));
?><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script><?php
wp_enqueue_script( 'bootstrap-select.js' , WP2APPIR_JS_URL.'bootstrap-select.js', array('jquery'));
?>
