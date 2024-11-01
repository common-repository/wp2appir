jQuery(function() {
    jQuery( "#sortable" ).sortable();
    jQuery( "#sortable" ).disableSelection();
});
jQuery(document).ready(function(){

});
jQuery(document).ready(function(){
    jQuery('#select_action_ver_item').change(
        function(){
            if (this.value == '1') {
                jQuery(".vertical_item").addClass("hide");
                jQuery("#ver_category_list").removeClass("hide");
            }else if (this.value == '2') {
                jQuery(".vertical_item").addClass("hide");
                jQuery("#ver_post_list").removeClass("hide");
            } else if (this.value == '3') {
                jQuery(".vertical_item").addClass("hide");
                jQuery("#ver_tag_list").removeClass("hide");
            }
        });
    jQuery('#select_action_hor_item').change(
        function(){
            if (this.value == '1') {
                jQuery(".horizontal_item").addClass("hide");
                jQuery("#hor_category_list").removeClass("hide");
            }else if (this.value == '2') {
                jQuery(".horizontal_item").addClass("hide");
                jQuery("#hor_post_list").removeClass("hide");
            } else if (this.value == '3') {
                jQuery(".horizontal_item").addClass("hide");
                jQuery("#hor_tag_list").removeClass("hide");
            }
        });
    jQuery('#select_action_banner').change(
        function(){
            if (this.value == '1') {
                jQuery("#product_list").addClass("hide");
                jQuery("#category_list").addClass("hide");
                jQuery("#link_list").addClass("hide");
                jQuery("#product_list").removeClass("hide");
            }else if (this.value == '2') {
                jQuery("#product_list").addClass("hide");
                jQuery("#category_list").addClass("hide");
                jQuery("#link_list").addClass("hide");
                jQuery("#category_list").removeClass("hide");
            } else if (this.value == '3') {
                jQuery("#product_list").addClass("hide");
                jQuery("#category_list").addClass("hide");
                jQuery("#link_list").addClass("hide");
                jQuery("#link_list").removeClass("hide");
            }
        });
    jQuery('#select_action_banner1').change(
        function(){
            if (this.value == '1') {
                jQuery("#product_list1").addClass("hide");
                jQuery("#category_list1").addClass("hide");
                jQuery("#link_list1").addClass("hide");
                jQuery("#product_list1").removeClass("hide");
            }else if ( this.value == '2') {
                jQuery("#product_list1").addClass("hide");
                jQuery("#category_list1").addClass("hide");
                jQuery("#link_list1").addClass("hide");
                jQuery("#category_list1").removeClass("hide");
            }else if (this.value == '3') {
                jQuery("#product_list1").addClass("hide");
                jQuery("#category_list1").addClass("hide");
                jQuery("#link_list1").addClass("hide");
                jQuery("#link_list1").removeClass("hide");
            }
        });
    jQuery('#select_action_banner2').change(
        function(){
            if ( this.value == '1') {
                jQuery("#product_list2").addClass("hide");
                jQuery("#category_list2").addClass("hide");
                jQuery("#link_list2").addClass("hide");
                jQuery("#product_list2").removeClass("hide");
            }else if ( this.value == '2') {
                jQuery("#product_list2").addClass("hide");
                jQuery("#category_list2").addClass("hide");
                jQuery("#link_list2").addClass("hide");
                jQuery("#category_list2").removeClass("hide");
            } else if (this.value == '3') {
                jQuery("#product_list2").addClass("hide");
                jQuery("#category_list2").addClass("hide");
                jQuery("#link_list2").addClass("hide");
                jQuery("#link_list2").removeClass("hide");
            }
        });
    jQuery('#select_action_banner3').change(
        function(){
            if (this.value == '1') {
                jQuery("#product_list3").addClass("hide");
                jQuery("#category_list3").addClass("hide");
                jQuery("#link_list3").addClass("hide");
                jQuery("#product_list3").removeClass("hide");
            }else if (this.value == '2') {
                jQuery("#product_list3").addClass("hide");
                jQuery("#category_list3").addClass("hide");
                jQuery("#link_list3").addClass("hide");
                jQuery("#category_list3").removeClass("hide");
            } else if (this.value == '3') {
                jQuery("#product_list3").addClass("hide");
                jQuery("#category_list3").addClass("hide");
                jQuery("#link_list3").addClass("hide");
                jQuery("#link_list3").removeClass("hide");
            }
        });
    jQuery('#select_action_banner4').change(
        function(){
            if (this.value == '1') {
                jQuery("#product_list4").addClass("hide");
                jQuery("#category_list4").addClass("hide");
                jQuery("#link_list4").addClass("hide");
                jQuery("#product_list4").removeClass("hide");
            }else if (this.value == '2') {
                jQuery("#product_list4").addClass("hide");
                jQuery("#category_list4").addClass("hide");
                jQuery("#link_list4").addClass("hide");
                jQuery("#category_list4").removeClass("hide");
            } else if (this.value == '3') {
                jQuery("#product_list4").addClass("hide");
                jQuery("#category_list4").addClass("hide");
                jQuery("#link_list4").addClass("hide");
                jQuery("#link_list4").removeClass("hide");
            }
        });
    jQuery('input:radio[name="select_item_option"]').change(
        function(){
            jQuery("#alert_item").html("");
            jQuery("#alert_item").html("");
            jQuery("#alert_item").html("");
            jQuery("#alert_item").removeClass("hide");
            jQuery("#alert_item").removeClass("alert-danger");
            jQuery("#alert_item").removeClass("alert-success");
            if (this.checked && this.value == '1') {
                jQuery(".div_banner").addClass("hide");
                jQuery(".div_list_vertical").addClass("hide");
                jQuery(".div_list_horizontal").addClass("hide");
                jQuery(".div_4_banner").addClass("hide");
                jQuery(".div_banner").removeClass("hide");

            }else if (this.checked && this.value == '2') {
                jQuery(".div_banner").addClass("hide");
                jQuery(".div_list_vertical").addClass("hide");
                jQuery(".div_list_horizontal").addClass("hide");
                jQuery(".div_4_banner").addClass("hide");
                jQuery(".div_list_vertical").removeClass("hide");

            }else if (this.checked && this.value == '3') {
                jQuery(".div_banner").addClass("hide");
                jQuery(".div_list_vertical").addClass("hide");
                jQuery(".div_list_horizontal").addClass("hide");
                jQuery(".div_4_banner").addClass("hide");
                jQuery(".div_list_horizontal").removeClass("hide");

            }else if (this.checked && this.value == '4') {
                jQuery(".div_banner").addClass("hide");
                jQuery(".div_list_vertical").addClass("hide");
                jQuery(".div_list_horizontal").addClass("hide");
                jQuery(".div_4_banner").addClass("hide");
                jQuery(".div_4_banner").removeClass("hide");
                //
                jQuery(".div_banner1").removeClass("hide");
                jQuery(".div_banner2").removeClass("hide");
                jQuery(".div_banner3").removeClass("hide");
                jQuery(".div_banner4").removeClass("hide");
                jQuery("#div_height").addClass('hide');

            }
            else if (this.checked && (this.value == '7' || this.value == '8')) {
                jQuery(".div_banner").addClass("hide");
                jQuery(".div_list_vertical").addClass("hide");
                jQuery(".div_list_horizontal").addClass("hide");
                jQuery(".div_4_banner").removeClass("hide");
                //
                jQuery(".div_banner1").removeClass("hide");
                jQuery(".div_banner2").removeClass("hide");
                jQuery(".div_banner3").removeClass("hide");
                jQuery(".div_banner4").addClass("hide");
                jQuery("#div_height").removeClass('hide');

            }
            else if (this.checked && this.value == '9') {
                jQuery(".div_banner").addClass("hide");
                jQuery(".div_list_vertical").addClass("hide");
                jQuery(".div_list_horizontal").addClass("hide");
                jQuery(".div_4_banner").removeClass("hide");
                //
                jQuery(".div_banner1").removeClass("hide");
                jQuery(".div_banner2").removeClass("hide");
                jQuery(".div_banner3").addClass("hide");
                jQuery(".div_banner4").addClass("hide");
                jQuery("#div_height").removeClass('hide');

            }
        });
    jQuery.ajax({
        url: ajaxurl,
        data: {
            action: "load_item_hami_wp2app"
        },
        success:function(data) {
            data = data.substring(0,data.length -1);
            jQuery("#sortable").html(data);
        }
    });
    jQuery("#btn_form_order").click(function(){
        var r ="";

        var x = jQuery("#form_sort").serializeArray();
        jQuery.each(x, function(i, field){
            r += (field.value + "_");
        });
        jQuery.ajax({
            url: ajaxurl,
            data:{
                action:'save_order_wp2app_item',
                id : r
            } ,
            type : "post" ,
            success:function(data) {
                data = data.substring(0,data.length -1);
                if(data == 1){
                    jQuery("#alert_sort").removeClass("hide");
                    jQuery("#alert_sort").removeClass("alert-danger");
                    jQuery("#alert_sort").removeClass("alert-success");
                    jQuery("#alert_sort").addClass("alert-success");
                    jQuery("#alert_sort").html("مرتب سازی انجام شد.");
                }
            }
        });
    });
    jQuery("#check_list_cat_mainpage").change(function(){
        var r = 0;
        if (this.checked) {
            r=1;
        }else{
            r=0;
        }
        jQuery.ajax({
            url: ajaxurl,
            data:{
                action:'change_show_btn_catlst',
                id : r
            } ,
            type : "post" ,
            success:function(data) {
            }
        });

    });
    //-------------slash set------------------------------------------
    jQuery("#btn_form_splash").click(function(){
        var delay_splash = jQuery("#delay_splash").val();
        var url_splash = jQuery("#txt_url_item_hami1").val();
        if(delay_splash.length <= 0 || url_splash.length <= 0 ) return false;

        jQuery.ajax({
            url: ajaxurl,
            data:{
                action:'woo2app_setsplash',
                delay_splash : delay_splash,
                url_splash : url_splash
            } ,
            type : "post" ,
            success:function(data) {
                data = data.substring(0,data.length -1);
                if(data == 1){
                    jQuery("#alert_splash").removeClass("hide");
                    jQuery("#alert_splash").removeClass("alert-success");
                    jQuery("#alert_splash").removeClass("alert-danger");
                    jQuery("#alert_splash").addClass("alert-success");
                    jQuery("#alert_splash").html("تنظیمات شما ذخیره شد.");
                }else{
                    jQuery("#alert_splash").removeClass("hide");
                    jQuery("#alert_splash").removeClass("alert-success");
                    jQuery("#alert_splash").removeClass("alert-danger");
                    jQuery("#alert_splash").addClass("alert-danger");
                    jQuery("#alert_splash").html("خطا در ذخیره اطلاعات.");
                }
            }
        });
    });
    //----------------------------------------------------------------
});
function add_item_mainpage(){

    var opt = jQuery("input[name=select_item_option]:checked").val();
    //alert(opt);
    if (opt == 1) {
        var showtype = 1;
        var title = jQuery("#txt_title_banner_item").val();
        var pic = jQuery("#txt_url_item_hami").val();
        var type = jQuery("#select_action_banner").val();
        var value = "";
        var flag = 0;
        if(type == 2){
            value = jQuery('#value_cat_items').val();
        }else if (type == 1) {
            value = jQuery('#value_post_items').val();
        }else if (type == 3) {
            value = jQuery('#value_link_items').val();
        }
        // if(title.trim() == ""){
        // 	flag = 1;
        // }
        if (pic == "") {
            flag = 2;
        }
        if (value == "" || value == null || value == 0) {
            flag = 3;
        }
        if(flag == 0){
            jQuery.ajax({
                url: ajaxurl,
                data: {
                    action: "add_item_hami_wp2app",
                    "title": title , "type" : type ,   "value" : value , "showtype" : showtype , "pic" : pic
                },
                success:function(data) {
                    if(data == 10){
                        jQuery("#alert_item").removeClass("hide");
                        jQuery("#alert_item").removeClass("alert-danger");
                        jQuery("#alert_item").removeClass("alert-success");
                        jQuery("#alert_item").addClass("alert-success");
                        jQuery("#alert_item").html("ایتم شما ثبت شد.");
                        jQuery("#txt_title_banner_item").val("");
                        jQuery("#txt_url_item_hami").val("");
                        jQuery("#div_image_item_hami").css({"height" : "5px","background-image" : ""});
                        jQuery.ajax({
                            url: ajaxurl,
                            data: {
                                action: "load_item_hami_wp2app"
                            },
                            success:function(data) {
                                data = data.substring(0,data.length -1);
                                jQuery("#sortable").html(data);
                            }
                        });
                    }
                }
            });
        }else{
            jQuery("#alert_item").removeClass("hide");
            jQuery("#alert_item").removeClass("alert-danger");
            jQuery("#alert_item").removeClass("alert-success");
            jQuery("#alert_item").addClass("alert-danger");
            if(flag ==1) jQuery("#alert_item").html("عنوان را وارد نمایید.");
            if(flag ==2) jQuery("#alert_item").html("تصویر بنر را انتخاب نمایید.");
            if(flag ==3) jQuery("#alert_item").html("از لیست یک موضوع را انتخاب نمایید.");
        }
    }
    else if (opt == 2) {
        var  value = ""
        var  pic = ""
        var obj = {};
        obj['filter'] = {}
        obj['sort'] = {}
        obj['page'] = 1;
        //obj['count'] = 15;
        flag = 1;
        if( jQuery("#select_action_ver_item").val() == 1){
            //cats
            value = 1;
            flag = 0;
            if(jQuery("#value_cat_items_ver").val() != -1){
                obj['filter']['cat_id'] = jQuery("#value_cat_items_ver").val();
            }
        }
        else if( jQuery("#select_action_ver_item").val() == 2){
            // posts
            value = 1;
            flag = 0;
            obj['filter']['post_id'] = jQuery("#value_post_items_ver").val();
        }
        else if( jQuery("#select_action_ver_item").val() == 3){
            //tags
            value = 1;
            flag = 0;
            obj['filter']['tag'] = jQuery("#value_tag_items_ver").val();
        }

        showtype = 5;
        var sort = jQuery('#select_sort_ver').val();
        title = jQuery("#txt_title_ver_item").val();
        type = -1;
        obj['sort'] = jQuery('#select_sort_ver').val();
        value = JSON.stringify(obj);




        if (value == "" || value == null || value == 0) {
            flag = 3;
        }
        if(flag == 0){
            jQuery.ajax({
                url: ajaxurl,
                data: {
                    action: "add_item_hami_wp2app",
                    "title": title , "type" : type ,   "value" : value , "showtype" : showtype , "pic" : pic
                },
                success:function(data) {
                    console.log(data);
                    if(data == 10){
                        jQuery("#alert_item").removeClass("hide");
                        jQuery("#alert_item").removeClass("alert-danger");
                        jQuery("#alert_item").removeClass("alert-success");
                        jQuery("#alert_item").addClass("alert-success");
                        jQuery("#alert_item").html("ایتم شما ثبت شد.");
                        jQuery("#txt_title_ver_item").val("");
                        jQuery.ajax({
                            url: ajaxurl,
                            data: {
                                action: "load_item_hami_wp2app"
                            },
                            success:function(data) {
                                data = data.substring(0,data.length -1);
                                jQuery("#sortable").html(data);
                            }
                        });
                    }
                }
            });
        }
        else{
            jQuery("#alert_item").removeClass("hide");
            jQuery("#alert_item").removeClass("alert-danger");
            jQuery("#alert_item").removeClass("alert-success");
            jQuery("#alert_item").addClass("alert-danger");
            if(flag ==1) jQuery("#alert_item").html("عنوان را وارد نمایید.");
            if(flag ==2) jQuery("#alert_item").html("تصویر بنر را انتخاب نمایید.");
            if(flag ==3) jQuery("#alert_item").html("از لیست یک موضوع را انتخاب نمایید.");
        }
    }
    else if (opt == 3) {

        var  value = ""
        var  pic = ""
        var obj = {};
        obj['filter'] = {}
        obj['sort'] = {}
        obj['page'] = 1;
        //obj['count'] = 15;
        flag = 1;
        if(jQuery("#select_action_hor_item").val() == 1){
            //cats
            value = 1;
            flag = 0;
            if(jQuery("#value_cat_items_hor").val() != -1){
                obj['filter']['cat_id'] = jQuery("#value_cat_items_hor").val();
            }
        }
        else if( jQuery("#select_action_hor_item").val() == 2){
            // posts
            value = 1;
            flag = 0;
            obj['filter']['post_id'] = jQuery("#value_post_items_hor").val();
        }
        else if( jQuery("#select_action_hor_item").val() == 3){
            //tags
            value = 1;
            flag = 0;
            obj['filter']['tag'] = jQuery("#value_tag_items_hor").val();
        }

        showtype = 6;
        sort = jQuery('#select_sort_ver').val();
        title = jQuery("#txt_title_hor_item").val();
        type = -1;
        obj['sort'] = jQuery('#select_sort_hor').val();
        value = JSON.stringify(obj);

        console.log(value)

        if (value == "" || value == null || value == 0) {
            flag = 3;
        }

        if(flag == 0){
            jQuery.ajax({
                url: ajaxurl,
                data: {
                    action: "add_item_hami_wp2app",
                    "title": title , "type" : type ,   "value" : value , "showtype" : showtype , "pic" : pic
                },
                success:function(data) {
                    //console.log(data);
                    if(data == 10){
                        jQuery("#alert_item").removeClass("hide");
                        jQuery("#alert_item").removeClass("alert-danger");
                        jQuery("#alert_item").removeClass("alert-success");
                        jQuery("#alert_item").addClass("alert-success");
                        jQuery("#alert_item").html("ایتم شما ثبت شد.");
                        jQuery("#txt_title_hor_item").val("");
                        jQuery.ajax({
                            url: ajaxurl,
                            data: {
                                action: "load_item_hami_wp2app"
                            },
                            success:function(data) {
                                data = data.substring(0,data.length -1);
                                jQuery("#sortable").html(data);
                            }
                        });
                    }
                }
            });
        }else{
            jQuery("#alert_item").removeClass("hide");
            jQuery("#alert_item").removeClass("alert-danger");
            jQuery("#alert_item").removeClass("alert-success");
            jQuery("#alert_item").addClass("alert-danger");
            if(flag ==1) jQuery("#alert_item").html("عنوان را وارد نمایید.");
            if(flag ==2) jQuery("#alert_item").html("تصویر بنر را انتخاب نمایید.");
            if(flag ==3) jQuery("#alert_item").html("از لیست یک موضوع را انتخاب نمایید.");
        }
    }
    else if (opt == 4) {
        showtype = 4;
        title1 = jQuery("#txt_title_4banner1_item").val();
        title2 = jQuery("#txt_title_4banner2_item").val();
        title3 = jQuery("#txt_title_4banner3_item").val();
        title4 = jQuery("#txt_title_4banner4_item").val();
        pic1 = jQuery("#txt_url_item_hami1").val();
        pic2 = jQuery("#txt_url_item_hami2").val();
        pic3 = jQuery("#txt_url_item_hami3").val();
        pic4 = jQuery("#txt_url_item_hami4").val();
        type1 = jQuery("#select_action_banner1").val();
        type2 = jQuery("#select_action_banner2").val();
        type3 = jQuery("#select_action_banner3").val();
        type4 = jQuery("#select_action_banner4").val();
        value1 = "";
        value2 = "";
        value3 = "";
        value4 = "";

        if(type1 == 2){
            value1 = jQuery('#value_cat_items1').val();
        }else if (type1 == 1) {
            value1 = jQuery('#value_post_items1').val();
        }else if (type1 == 3) {
            value1 = jQuery('#value_link_items1').val();
        }
        if(type2 == 2){
            value2 = jQuery('#value_cat_items2').val();
        }else if (type2 == 1) {
            value2 = jQuery('#value_post_items2').val();
        }else if (type2 == 3) {
            value2 = jQuery('#value_link_items2').val();
        }
        if(type3 == 2){
            value3 = jQuery('#value_cat_items3').val();
        }else if (type3 == 1) {
            value3 = jQuery('#value_post_items3').val();
        }else if (type3 == 3) {
            value3 = jQuery('#value_link_items3').val();
        }
        if(type4 == 2){
            value4 = jQuery('#value_cat_items4').val();
        }else if (type4 == 1) {
            value4 = jQuery('#value_post_items4').val();
        }else if (type4 == 3) {
            value4 = jQuery('#value_link_items4').val();
        }
        flag = 0;
        // if(title1.trim() == "" || title2.trim() == "" || title3.trim() == "" || title4.trim() == ""){
        // 	flag = 1;
        // }
        if (pic1 == "" || pic2 == "" || pic3 == "" || pic4 == "") {
            flag = 2;
        }
        if (value1 == "" || value1 == null || value1 == 0 ||
            value2 == "" || value2 == null || value2 == 0 ||
            value3 == "" || value3 == null || value3 == 0 ||
            value4 == "" || value4 == null || value4 == 0 ) {
            flag = 3;
        }
        if(flag == 0){
            var b0 = '{ "banner4" : [';
            var b1 =  '{ "title"  : "' + title1 + '" , "type" :"' + type1 +'" , "value" : "' + value1 + '" , "pic" : "' + pic1 + '"},';
            var b2 =  '{ "title"  : "' + title2 + '" , "type" :"' + type2 +'" , "value" : "' + value2 + '" , "pic" : "' + pic2 + '"},';
            var b3 =  '{ "title"  : "' + title3 + '" , "type" :"' + type3 +'" , "value" : "' + value3 + '" , "pic" : "' + pic3 + '"},';
            var b4 =  '{ "title"  : "' + title4 + '" , "type" :"' + type4 +'" , "value" : "' + value4 + '" , "pic" : "' + pic4 + '"}]}';
            jQuery.ajax({
                url: ajaxurl,
                data: {
                    action: "add_item_hami_wp2app",
                    "title": "بنر 4تایی" , "type" : "" ,   "b0" : b0,"b1" : b1,"b2" : b2,"b3" : b3,"b4" : b4 , "showtype" : showtype , "pic" : ""
                },
                success:function(data) {
                    if(data == 10){
                        jQuery("#alert_item").removeClass("hide");
                        jQuery("#alert_item").removeClass("alert-danger");
                        jQuery("#alert_item").removeClass("alert-success");
                        jQuery("#alert_item").addClass("alert-success");
                        jQuery("#alert_item").html("ایتم شما ثبت شد.");

                        jQuery("#txt_title_4banner1_item").val("");
                        jQuery("#txt_title_4banner2_item").val("");
                        jQuery("#txt_title_4banner3_item").val("");
                        jQuery("#txt_title_4banner4_item").val("");
                        jQuery("#txt_url_item_hami1").val("");
                        jQuery("#txt_url_item_hami2").val("");
                        jQuery("#txt_url_item_hami3").val("");
                        jQuery("#txt_url_item_hami4").val("");
                        jQuery("#div_image_item_hami1").css({"height" : "5px","background-image" : ""});
                        jQuery("#div_image_item_hami2").css({"height" : "5px","background-image" : ""});
                        jQuery("#div_image_item_hami3").css({"height" : "5px","background-image" : ""});
                        jQuery("#div_image_item_hami4").css({"height" : "5px","background-image" : ""});
                        jQuery.ajax({
                            url: ajaxurl,
                            data: {
                                action: "load_item_hami_wp2app"
                            },
                            success:function(data) {
                                data = data.substring(0,data.length -1);
                                jQuery("#sortable").html(data);
                            }
                        });
                    }
                }
            });
        }else{
            jQuery("#alert_item").removeClass("hide");
            jQuery("#alert_item").removeClass("alert-danger");
            jQuery("#alert_item").removeClass("alert-success");
            jQuery("#alert_item").addClass("alert-danger");
            if(flag ==1) jQuery("#alert_item").html("عنوان ها را وارد نمایید.");
            if(flag ==2) jQuery("#alert_item").html("تصویر ها بنر را انتخاب نمایید.");
            if(flag ==3) jQuery("#alert_item").html("از لیست ها یک موضوع را انتخاب نمایید.");
        }
    }
    else if (opt == 7 || opt == 8) {
        showtype = opt;
        title1 = jQuery("#txt_title_4banner1_item").val();
        title2 = jQuery("#txt_title_4banner2_item").val();
        title3 = jQuery("#txt_title_4banner3_item").val();
        pic1 = jQuery("#txt_url_item_hami1").val();
        pic2 = jQuery("#txt_url_item_hami2").val();
        pic3 = jQuery("#txt_url_item_hami3").val();
        type1 = jQuery("#select_action_banner1").val();
        type2 = jQuery("#select_action_banner2").val();
        type3 = jQuery("#select_action_banner3").val();
        value1 = "";
        value2 = "";
        value3 = "";

        if(type1 == 2){
            value1 = jQuery('#value_cat_items1').val();
        }else if (type1 == 1) {
            value1 = jQuery('#value_post_items1').val();
        }else if (type1 == 3) {
            value1 = jQuery('#value_link_items1').val();
        }
        if(type2 == 2){
            value2 = jQuery('#value_cat_items2').val();
        }else if (type2 == 1) {
            value2 = jQuery('#value_post_items2').val();
        }else if (type2 == 3) {
            value2 = jQuery('#value_link_items2').val();
        }
        if(type3 == 2){
            value3 = jQuery('#value_cat_items3').val();
        }else if (type3 == 1) {
            value3 = jQuery('#value_post_items3').val();
        }else if (type3 == 3) {
            value3 = jQuery('#value_link_items3').val();
        }

        flag = 0;
        // if(title1.trim() == "" || title2.trim() == "" || title3.trim() == "" || title4.trim() == ""){
        // 	flag = 1;
        // }
        if (pic1 == "" || pic2 == "" || pic3 == "") {
            flag = 2;
        }
        if (value1 == "" || value1 == null || value1 == 0 ||
            value2 == "" || value2 == null || value2 == 0 ||
            value3 == "" || value3 == null || value3 == 0  ) {
            flag = 3;
        }
        if(flag == 0){
            var b0 = '{ "banner4" : [';
            var b1 =  '{ "title"  : "' + title1 + '" , "type" :"' + type1 +'" , "value" : "' + value1 + '" , "pic" : "' + pic1 + '"},';
            var b2 =  '{ "title"  : "' + title2 + '" , "type" :"' + type2 +'" , "value" : "' + value2 + '" , "pic" : "' + pic2 + '"},';
            var b3 =  '{ "title"  : "' + title3 + '" , "type" :"' + type3 +'" , "value" : "' + value3 + '" , "pic" : "' + pic3 + '"}';
            var b4 =  ']}';
            jQuery.ajax({
                url: ajaxurl,
                data: {
                    action: "add_item_hami_wp2app",
                    "title": "بنر  3 تایی" , "type" : "" ,
                    "b0" : b0,"b1" : b1,"b2" : b2,"b3" : b3,"b4" : b4 ,
                    "showtype" : showtype , "pic" : jQuery("#height").val()
                },
                success:function(data) {
                    if(data == 10){
                        jQuery("#alert_item").removeClass("hide");
                        jQuery("#alert_item").removeClass("alert-danger");
                        jQuery("#alert_item").removeClass("alert-success");
                        jQuery("#alert_item").addClass("alert-success");
                        jQuery("#alert_item").html("ایتم شما ثبت شد.");

                        jQuery("#txt_title_4banner1_item").val("");
                        jQuery("#txt_title_4banner2_item").val("");
                        jQuery("#txt_title_4banner3_item").val("");
                        jQuery("#txt_title_4banner4_item").val("");
                        jQuery("#txt_url_item_hami1").val("");
                        jQuery("#txt_url_item_hami2").val("");
                        jQuery("#txt_url_item_hami3").val("");
                        jQuery("#txt_url_item_hami4").val("");
                        jQuery("#div_image_item_hami1").css({"height" : "5px","background-image" : ""});
                        jQuery("#div_image_item_hami2").css({"height" : "5px","background-image" : ""});
                        jQuery("#div_image_item_hami3").css({"height" : "5px","background-image" : ""});
                        jQuery("#div_image_item_hami4").css({"height" : "5px","background-image" : ""});
                        jQuery.ajax({
                            url: ajaxurl,
                            data: {
                                action: "load_item_hami_wp2app"
                            },
                            success:function(data) {
                                data = data.substring(0,data.length -1);
                                jQuery("#sortable").html(data);
                            }
                        });
                    }
                }
            });
        }else{
            jQuery("#alert_item").removeClass("hide");
            jQuery("#alert_item").removeClass("alert-danger");
            jQuery("#alert_item").removeClass("alert-success");
            jQuery("#alert_item").addClass("alert-danger");
            if(flag ==1) jQuery("#alert_item").html("عنوان ها را وارد نمایید.");
            if(flag ==2) jQuery("#alert_item").html("تصویر ها بنر را انتخاب نمایید.");
            if(flag ==3) jQuery("#alert_item").html("از لیست ها یک موضوع را انتخاب نمایید.");
        }
    }
    else if (opt == 9) {
        showtype = opt;
        title1 = jQuery("#txt_title_4banner1_item").val();
        title2 = jQuery("#txt_title_4banner2_item").val();
        pic1 = jQuery("#txt_url_item_hami1").val();
        pic2 = jQuery("#txt_url_item_hami2").val();
        type1 = jQuery("#select_action_banner1").val();
        type2 = jQuery("#select_action_banner2").val();
        value1 = "";
        value2 = "";

        if(type1 == 2){
            value1 = jQuery('#value_cat_items1').val();
        }else if (type1 == 1) {
            value1 = jQuery('#value_post_items1').val();
        }else if (type1 == 3) {
            value1 = jQuery('#value_link_items1').val();
        }
        if(type2 == 2){
            value2 = jQuery('#value_cat_items2').val();
        }else if (type2 == 1) {
            value2 = jQuery('#value_post_items2').val();
        }else if (type2 == 3) {
            value2 = jQuery('#value_link_items2').val();
        }

        flag = 0;
        // if(title1.trim() == "" || title2.trim() == "" || title3.trim() == "" || title4.trim() == ""){
        // 	flag = 1;
        // }
        if (pic1 == "" || pic2 == "") {
            flag = 2;
        }
        if (value1 == "" || value1 == null || value1 == 0 ||
            value2 == "" || value2 == null || value2 == 0 ) {
            flag = 3;
        }
        if(flag == 0){
            var b0 = '{ "banner4" : [';
            var b1 =  '{ "title"  : "' + title1 + '" , "type" :"' + type1 +'" , "value" : "' + value1 + '" , "pic" : "' + pic1 + '"},';
            var b2 =  '{ "title"  : "' + title2 + '" , "type" :"' + type2 +'" , "value" : "' + value2 + '" , "pic" : "' + pic2 + '"}';
            var b3 =  '';
            var b4 =  ']}';
            jQuery.ajax({
                url: ajaxurl,
                data: {
                    action: "add_item_hami_wp2app",
                    "title": "بنر  2 تایی" , "type" : "" ,
                    "b0" : b0,"b1" : b1,"b2" : b2,"b3" : b3,"b4" : b4 ,
                    "showtype" : showtype , "pic" : jQuery("#height").val()
                },
                success:function(data) {
                    if(data == 10){
                        jQuery("#alert_item").removeClass("hide");
                        jQuery("#alert_item").removeClass("alert-danger");
                        jQuery("#alert_item").removeClass("alert-success");
                        jQuery("#alert_item").addClass("alert-success");
                        jQuery("#alert_item").html("ایتم شما ثبت شد.");

                        jQuery("#txt_title_4banner1_item").val("");
                        jQuery("#txt_title_4banner2_item").val("");
                        jQuery("#txt_title_4banner3_item").val("");
                        jQuery("#txt_title_4banner4_item").val("");
                        jQuery("#txt_url_item_hami1").val("");
                        jQuery("#txt_url_item_hami2").val("");
                        jQuery("#txt_url_item_hami3").val("");
                        jQuery("#txt_url_item_hami4").val("");
                        jQuery("#div_image_item_hami1").css({"height" : "5px","background-image" : ""});
                        jQuery("#div_image_item_hami2").css({"height" : "5px","background-image" : ""});
                        jQuery("#div_image_item_hami3").css({"height" : "5px","background-image" : ""});
                        jQuery("#div_image_item_hami4").css({"height" : "5px","background-image" : ""});
                        jQuery.ajax({
                            url: ajaxurl,
                            data: {
                                action: "load_item_hami_wp2app"
                            },
                            success:function(data) {
                                data = data.substring(0,data.length -1);
                                jQuery("#sortable").html(data);
                            }
                        });
                    }
                }
            });
        }else{
            jQuery("#alert_item").removeClass("hide");
            jQuery("#alert_item").removeClass("alert-danger");
            jQuery("#alert_item").removeClass("alert-success");
            jQuery("#alert_item").addClass("alert-danger");
            if(flag ==1) jQuery("#alert_item").html("عنوان ها را وارد نمایید.");
            if(flag ==2) jQuery("#alert_item").html("تصویر ها بنر را انتخاب نمایید.");
            if(flag ==3) jQuery("#alert_item").html("از لیست ها یک موضوع را انتخاب نمایید.");
        }
    }





}
//----------------------------------------------------------------
function delete_item_mainepage_wp2app(id){
    jQuery.ajax({
        url: ajaxurl,
        data: {
            action: "delete_item_mainepage_wp2app",
            id : id
        },
        success:function(data) {
            data = data.substring(0,data.length -1);
            if(data == 1){
                jQuery("#record" + id).remove();
            }
        }
    });
}