<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class wp2appir_ajax
{
	
	function __construct()
	{
		add_action( 'wp_ajax_set_frame_options',array($this , 'set_frame_options') );
		add_action( 'wp_ajax_set_pages', array($this , 'set_pages') );
	}

	function set_frame_options()
	{ 
		global $wpdb;
		$table_name = $wpdb->prefix . 'hami_set';
		$result = $wpdb->get_results("select * from $table_name");
		foreach($result as $r)
		{
			if($r->name == 'TXT_ACTT')  $title_app = $r->value; //onvane action bar
			if($r->name == 'CLR_MBG')   $primery_background = $r->value; //rang pishzanine asli
			if($r->name == 'CLR_ACTBG') $actionbar_background = $r->value;  //rang pish zamine action bar
			if($r->name == 'CLR_ACTTX') $actionbar_color = $r->value; //rang matn action bar
			if($r->name == 'TXT_MNRTI') $title_right_menu = $r->value; //onvane menu rast
			if($r->name == 'TXT_MNLTI') $title_left_menu = $r->value; //onvane menu chap
			if($r->name == 'TXT_MNRIC') $icon_right_menu = $r->value; //icone meno rast
			if($r->name == 'TXT_MNLIC') $icon_left_menu = $r->value;//icone meno chap
			if($r->name == 'CLR_LISTSBG') $list_background = $r->value;//pishzamine list
			if($r->name == 'CLR_LISTHBG') $list_title_background = $r->value;//pishzamine header list
			if($r->name == 'CLR_LISTHTX') $list_title_color = $r->value;//rang matn header list
			if($r->name == 'CLR_LISTSTX') $list_text_color = $r->value;//rang matn kholase matlab list
			if($r->name == 'CLR_LISTFBG') $list_footer_background = $r->value;//rang mackground footer list
			if($r->name == 'CLR_LISTFTX') $list_footer_color = $r->value;//rang matn kholase matlab list
			if($r->name == 'NUM_LVT') $select_theme = $r->value;//select theme list
			if($r->name == 'NUM_SRCHP') $select_location_search = $r->value;//select makane jostojo
			if($r->name == 'NUM_SRCHIC') $select_icon_search = $r->value;//icon jostojo
			if($r->name == 'CLR_SRCHIC') $select_color_search = $r->value;//rang jostojo
			
		}
		
		$icon_right_menu = explode ("__",$icon_right_menu);
		$icon_left_menu = explode ("__",$icon_left_menu);
		$select_icon_search = explode ("__",$select_icon_search);
		
		echo $primery_background."__".$actionbar_background."__".$actionbar_color."__".$title_app."__".$title_right_menu."__".$title_left_menu
			 ."__".$icon_right_menu[0]."__".$icon_left_menu[0]."__".$list_background ."__".$list_title_background
			 ."__".$list_title_color."__".$list_text_color."__".$list_footer_background."__".$list_footer_color."__".$select_theme
			 ."__".$select_location_search."__".$select_icon_search[0]."__".$select_color_search;	
	}
	function set_pages(){
		$id = $_REQUEST['id'] ;
		global $wpdb;
		$table_name = $wpdb->prefix . 'hami_set';
		$table_option = $wpdb->prefix . 'options';
		$res = $wpdb->get_results("select * from $table_name  ");
		foreach($res as $r){
			if( $r->name == 'TXT_SPLASHPL' ){ $spurl = $r->value; }
			
			if( $r->name == 'NUM_SPLASHT' ){ $sptime = $r->value; }
		}
		$types = $wpdb->get_results("select * from $table_option where option_name = 'PLAN_TYPE'");
		$type = "";
		foreach ($types as $key) { $type = $key->option_value;	}
		 //----------splash-------------------
		 if($id==0){
				?>
				<div class="col-md-12" >
					<div class="col-md-2" >
						
					</div>
					<div class="col-md-10" style="padding:0px;">
						<div class="panel panel-default">
	                        <div class="panel-heading">
	                            تنظیمات اسپلش
								<div class="col-md-4 text-left" style="padding:0px;">
										<a target="_blank" href="http://wp2app.ir/plugin_splash/">راهنما <i class="fa fa-1x fa-mortar-board"></i></a>
								</div>
	                        </div>
	                        <div class="panel-body">
								<div class="col-md-12" style="margin-bottom:5px;">
									<div class="col-md-8" style="">
										<input type="hidden" id="page_id"  value="<?= $id; ?>"  />
										<?php if($spurl==""||empty($spurl)){
											?>
											<input type="hidden" id="upload_image"  name="ad_image" 
											value="<?= plugins_url(plugin_basename(dirname(__FILE__))).'/../assets/img/defult_splash.jpg'; ?>" size="40" />
											<?php
										} ?>
										<input type="hidden" id="upload_image"  name="ad_image" value="<?= $spurl; ?>" size="40" />
										<button id="upload_image_button_hami" class="btn btn-primary pull-right" >
										آپلود عکس
										<label class="fa fa-2x fa-file-picture-o"></label>
										</button>
										<!--
										<input style="float:right;" type="button" class="onetarek-upload-button button" value="آپلود عکس" />
										-->
									</div>
									<div class="col-md-4 text-right" style="padding:0px;">
										<label>
											آپلود عکس :
										</label>
									</div>
								</div>

								<div class="col-md-12" style="margin-bottom:5px;">
									<div class="col-md-8">
										<button  class="btn btn-primary pull-right" onclick="insert_setting_splash(<?php echo $type; ?>)">
										ذخیره تغییرات
										<label class="fa fa-2x fa-save"></label>
										</button>
										<!--
										 <input type="button" onclick="insert_setting_splash()" class="button pull-right" value="ذخیره تغییرات" />
										 -->
									</div>
								</div>
								<div class="col-md-12">
									<div id="splash_alert" class="hide alert alert-success">
										
									</div>
									<div id="splash_alert_danger" class="hide alert alert-danger">
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			
		 }
		 if($id==1){
			
				?>
				<div class="col-md-12" >
					<div class="col-md-2" >
						
					</div>
					<div class="col-md-10" style="padding:0px;">
						<div class="panel panel-default">
	                        <div class="panel-heading">
	                            تنظیمات اسپلش
								<div class="col-md-4 text-left" style="padding:0px;">
										<a target="_blank" href="http://wp2app.ir/plugin_splash/">راهنما <i class="fa fa-1x fa-mortar-board"></i></a>
								</div>
	                        </div>
	                        <div class="panel-body">
								<div class="col-md-12" style="margin-bottom:5px;">
									<div class="col-md-8" style="">
										<input type="hidden" id="page_id"  value="<?= $id; ?>"  />
										<?php if($spurl==""||empty($spurl)){
											?>
											<input type="hidden" id="upload_image"  name="ad_image" 
											value="<?= plugins_url(plugin_basename(dirname(__FILE__))).'/../assets/img/defult_splash.jpg'; ?>" size="40" />
											<?php
										} ?>
										<input type="hidden" id="upload_image"  name="ad_image" value="<?= $spurl; ?>" size="40" />
										<button id="upload_image_button_hami" class="btn btn-primary pull-right" >
										آپلود عکس
										<label class="fa fa-2x fa-file-picture-o"></label>
										</button>
										<!--
										<input style="float:right;" type="button" class="onetarek-upload-button button" value="آپلود عکس" />
										-->
									</div>
									<div class="col-md-4 text-right" style="padding:0px;">
										<label>
											آپلود عکس :
										</label>
									</div>
								</div>
								
								<div class="col-md-12" style="margin-bottom:5px;">
									<div class="col-md-8">
										<button  class="btn btn-primary pull-right" onclick="insert_setting_splash(<?php echo $type; ?>)">
										ذخیره تغییرات
										<label class="fa fa-2x fa-save"></label>
										</button>
										<!--
										 <input type="button" onclick="insert_setting_splash()" class="button pull-right" value="ذخیره تغییرات" />
										 -->
									</div>
								</div>
								
								<div class="col-md-12">
									<div id="splash_alert" class="hide alert alert-success">
										
									</div>
									<div id="splash_alert_danger" class="hide alert alert-danger">
										
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
				<?php
		 }
		 //---------------primery setting---------------------
		 if($id==2)
		 {
			 ?>
				<div class="col-md-12">
					<div class="col-md-2"></div>
					<div class="col-md-10">
						<div class="panel panel-default">
	                        <div class="panel-heading">
	                            تنظیمات اپلیکیشن
								<div class="col-md-4 text-left" style="padding:0px;">
										<a target="_blank" href="http://wp2app.ir/plugin_main_page/">راهنما <i class="fa fa-1x fa-mortar-board"></i></a>
								</div>
	                        </div>
	                        <div class="panel-body">
	                            
								<div class="col-md-12">
						<div class="col-md-6">
						<select id = "select_show_items" onchange="selected_list(event)" class="form-control">
							<?php foreach($res as $r){ 
										if($r->name=="NUM_LVT"){
											if($r->value==1){
							?>
											<option value="1" selected>پیش فرض</option>
											<option value="2">تصویر راست</option>
											<option value="3">تصویر چپ</option>
											<option value="4">گالری</option>
											<option value="5">تصویر وسط</option>
											<option value="6">سلولی</option>
											<option value="7">درهم</option>
											<option value="8">کاتالوگ</option>
											<?php }else if($r->value==2){ ?>
											<option value="1">پیش فرض</option>
											<option value="2" selected>تصویر راست</option>
											<option value="3">تصویر چپ</option>
											<option value="4">گالری</option>
											<option value="5">تصویر وسط</option>
											<option value="6">سلولی</option>
											<option value="7">درهم</option>
											<option value="8">کاتالوگ</option>
											<?php }else if($r->value==3){?>
											<option value="1">پیش فرض</option>
											<option value="2" >تصویر راست</option>
											<option value="3" selected>تصویر چپ</option>
											<option value="4">گالری</option>
											<option value="5">تصویر وسط</option>
											<option value="6">سلولی</option>
											<option value="7">درهم</option>
											<option value="8">کاتالوگ</option>
											<?php }else if($r->value==4){?>
											<option value="1">پیش فرض</option>
											<option value="2" >تصویر راست</option>
											<option value="3" >تصویر چپ</option>
											<option value="4" selected>گالری</option>
											<option value="5">تصویر وسط</option>
											<option value="6">سلولی</option>
											<option value="7">درهم</option>
											<option value="8">کاتالوگ</option>
											<?php }else if($r->value==5){ ?>
											<option value="1">پیش فرض</option>
											<option value="2" >تصویر راست</option>
											<option value="3" >تصویر چپ</option>
											<option value="4" >گالری</option>
											<option value="5" selected>تصویر وسط</option>
											<option value="6">سلولی</option>
											<option value="7">درهم</option>
											<option value="8">کاتالوگ</option>
											<?php }elseif($r->value==6){?>
											<option value="1">پیش فرض</option>
											<option value="2" >تصویر راست</option>
											<option value="3" >تصویر چپ</option>
											<option value="4" >گالری</option>
											<option value="5" >تصویر وسط</option>
											<option value="6" selected>سلولی</option>
											<option value="7">درهم</option>
											<option value="8">کاتالوگ</option>
											<?php }elseif ($r->value == 7) {?>
											<option value="1">پیش فرض</option>
											<option value="2" >تصویر راست</option>
											<option value="3" >تصویر چپ</option>
											<option value="4" >گالری</option>
											<option value="5" >تصویر وسط</option>
											<option value="6">سلولی</option>
											<option value="7" selected>درهم</option>
											<option value="8">کاتالوگ</option>
											<?php }elseif ($r->value == 8) {?>
											<option value="1">پیش فرض</option>
											<option value="2" >تصویر راست</option>
											<option value="3" >تصویر چپ</option>
											<option value="4" >گالری</option>
											<option value="5" >تصویر وسط</option>
											<option value="6">سلولی</option>
											<option value="7">درهم</option>
											<option value="8" selected>کاتالوگ</option>
											<?php } ?>
							<?php }/*end if*/} ?>
						</select>
						</div>
						<div class="col-md-6">نحوه نمایش لیست :</div>
					</div>
					
					<div class="col-md-12" style="padding-bottom:5px;margin-top:5px;border-bottom:1px solid #e5e5e5;">
						<div class="col-md-6">
						<?php foreach($res as $r){ 
								if($r->name=="TXT_ACTT"){
						?>
						<input id="title_app" maxlength="15" onkeyup="myFunction_title_app()" value="<?= $r->value; ?>" type="text" class="form-control" placeholder="عنوان برنامه">
						<?php }} ?>
						</div>
						<div class="col-md-6">عنوان برنامه :</div>
					</div>
					<div class="col-md-12" style="margin-top:5px;">
						<p>
							جهت تغییر آیکون و نام برنامه به 
						<a href="http://panel.wp2app.ir" target="_blank">
									panel.wp2app.ir
						</a>
						مراجعه کنید.
						</p>
					</div>
					<div class="col-md-12" style="margin-top:10px;padding:0px;">
						<div class="alert alert-info" style="padding:3px;">
						رنگ ها
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="col-md-6">
							<select id="select_theme_app" onclick="select_theme_app()" class="form-control">
							<?php
							 $colors = $wpdb->get_results("select * from $table_name where name IN 
									('CLR_MBG','CLR_ACTBG','CLR_ACTTX','CLR_LISTHBG',
									'CLR_LISTHTX','CLR_LISTSBG','CLR_LISTFBG','CLR_LISTFTX','CLR_LISTSTX','CLR_SRCHIC') ");
							 $theme_1 = 0;$theme_2="";$theme_3=0;$theme_4="";
							 foreach ($colors as $color) {
							 	if($color->name == 'CLR_MBG' && $color->value == '#d4d4d4')     $theme_1++; 
							 	if($color->name == 'CLR_ACTBG' && $color->value == '#0061b0')   $theme_1++;
							 	if($color->name == 'CLR_ACTTX' && $color->value == '#ffffff')   $theme_1++;
							 	if($color->name == 'CLR_LISTHBG' && $color->value == '#820002') $theme_1++;
							 	if($color->name == 'CLR_LISTHTX' && $color->value == '#f7f7f7') $theme_1++;
							 	if($color->name == 'CLR_LISTSBG' && $color->value == '#ffffff') $theme_1++;
							 	if($color->name == 'CLR_LISTFBG' && $color->value == '#f0f0f0') $theme_1++;
							 	if($color->name == 'CLR_LISTFTX' && $color->value == '#404040') $theme_1++;
							 	if($color->name == 'CLR_LISTSTX' && $color->value == '#000000') $theme_1++;
							 	if($color->name == 'CLR_SRCHIC' && $color->value == '#ffffff')  $theme_1++;
							 	//---------------------------------------------------------------------------
							 	if($color->name == 'CLR_MBG' && $color->value == '#d4d4d4')     $theme_2++;
						 		if($color->name == 'CLR_ACTBG' && $color->value == '#960000')   $theme_2++;
						 		if($color->name == 'CLR_ACTTX' && $color->value == '#f2f2f2')   $theme_2++;
						 		if($color->name == 'CLR_LISTHBG' && $color->value == '#ffffff') $theme_2++;
						 		if($color->name == 'CLR_LISTHTX' && $color->value == '#000000') $theme_2++;
						 		if($color->name == 'CLR_LISTSBG' && $color->value == '#ffffff') $theme_2++;
						 		if($color->name == 'CLR_LISTFBG' && $color->value == '#524952') $theme_2++;
						 		if($color->name == 'CLR_LISTFTX' && $color->value == '#ffffff') $theme_2++;
						 		if($color->name == 'CLR_LISTSTX' && $color->value == '#3b3b3b') $theme_2++;
						 		if($color->name == 'CLR_SRCHIC' && $color->value == '#ffffff')  $theme_2++;
						 		//--------------------------------------------------------------------------
						 		if($color->name == 'CLR_MBG' && $color->value == '#c5d1cc')     $theme_3++;
					 			if($color->name == 'CLR_ACTBG' && $color->value == '#ebebeb')   $theme_3++;
						 		if($color->name == 'CLR_ACTTX' && $color->value == '#030003')   $theme_3++;
						 		if($color->name == 'CLR_LISTHBG' && $color->value == '#ebebeb') $theme_3++;
						 		if($color->name == 'CLR_LISTHTX' && $color->value == '#000000') $theme_3++;
						 		if($color->name == 'CLR_LISTSBG' && $color->value == '#2e2e2e') $theme_3++;
						 		if($color->name == 'CLR_LISTFBG' && $color->value == '#ffffff') $theme_3++;
						 		if($color->name == 'CLR_LISTFTX' && $color->value == '#696969') $theme_3++;
						 		if($color->name == 'CLR_LISTSTX' && $color->value == '#ffffff') $theme_3++;
						 		if($color->name == 'CLR_SRCHIC' && $color->value == '#ffffff')  $theme_3++;
						 		//--------------------------------------------------------------------------
						 		if($color->name == 'CLR_MBG' && $color->value == '#006475')     $theme_4++;
					 			if($color->name == 'CLR_ACTBG' && $color->value == '#d8e8da')   $theme_4++;
						 		if($color->name == 'CLR_ACTTX' && $color->value == '#030003')   $theme_4++;
						 		if($color->name == 'CLR_LISTHBG' && $color->value == '#ffffff') $theme_4++;
						 		if($color->name == 'CLR_LISTHTX' && $color->value == '#737373') $theme_4++;
						 		if($color->name == 'CLR_LISTSBG' && $color->value == '#ffffff') $theme_4++;
						 		if($color->name == 'CLR_LISTFBG' && $color->value == '#d9d9d9') $theme_4++;
						 		if($color->name == 'CLR_LISTFTX' && $color->value == '#696969') $theme_4++;
						 		if($color->name == 'CLR_LISTSTX' && $color->value == '#000000') $theme_4++;
						 		if($color->name == 'CLR_SRCHIC' && $color->value == '#ffffff')  $theme_4++;
							 }//end foreach color
							 echo $theme_4;
							 	if ($theme_1 == 10) {
						 		?>
									<option value="0">انتخاب تم</option>
									<option value="1" selected>تم یک</option>
									<option value="2">تم دو</option>
									<option value="3">تم سه</option>
									<option value="4">تم چهار</option>
								<?php	
							 	}elseif ($theme_2 == 10) {
						 		?>
									<option value="0">انتخاب تم</option>
									<option value="1">تم یک</option>
									<option value="2" selected>تم دو</option>
									<option value="3">تم سه</option>
									<option value="4">تم چهار</option>
								<?php
							 	}elseif ($theme_3 == 10) {
						 		?>
									<option value="0">انتخاب تم</option>
									<option value="1">تم یک</option>
									<option value="2">تم دو</option>
									<option value="3"selected>تم سه</option>
									<option value="4">تم چهار</option>
								<?php
							 	}elseif ($theme_4 == 10) {
						 		?>
									<option value="0">انتخاب تم</option>
									<option value="1">تم یک</option>
									<option value="2">تم دو</option>
									<option value="3">تم سه</option>
									<option value="4" selected>تم چهار</option>
								<?php
							 	}else{
					 			?>
									<option value="0" selected>انتخاب تم</option>
									<option value="1">تم یک</option>
									<option value="2">تم دو</option>
									<option value="3">تم سه</option>
									<option value="4">تم چهار</option>
								<?php
							 	}
							?>
							</select>
						</div>
						<div class="col-md-6">تم ها :</div>
					</div>
					
					<?php 
					$i = 1;
					$g = 1;
						$result = $wpdb->get_results("select * from $table_name where name IN 
									('CLR_MBG','CLR_ACTBG','CLR_ACTTX','CLR_LISTHBG',
									'CLR_LISTHTX','CLR_LISTSBG','CLR_LISTFBG','CLR_LISTFTX','CLR_LISTSTX','CLR_SRCHIC') ");
						foreach($result as $r){ 
					?>
							<div class="col-md-12" style="margin-top:5px;" >
								<div class="col-md-6">
									<span id="div_color_change" class="icon-eraser"></span>
									<?php $color = trim(str_replace('#','',$r->value)); ?>
									<div id="picker<?php echo $t=$i++; ?>" class="col-md-6 picker" onclick=" get_picker_color(<?php echo $t; ?>) " 
									style="border:1px solid #e5e5e5;height:30px;background-color:<?php echo $r->value; ?>;color:<?php echo $r->value; ?>;">
									<?php echo trim(str_replace("#","",$r->value)); ?>
									</div>
									<input value="<?= str_replace("#","",$r->value); ?>" class="form-control picker" onclick="" id="picker<?php ?>" name="app<?php echo $r->name; ?>" type="hidden" style="font-weight:bold;" placeholder="انتخاب رنگ" >
								</div>
								<div class="col-md-6" id="<?php echo 'desc'.$r->name; ?>"><?= $r->description; ?></div>
							</div>						
					<?php 
					} 
					?>
					
					<div class="col-md-12" style="margin-top:5px;">
						<div class="alert alert-info" style="padding:3px;">
						منوی راست
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="col-md-6">
							<select id="select_right_menu_app" class="form-control">
								<?php foreach($res as $r){ 
										if($r->name=="NUM_MNRTYPE" ){
											if($r->value==1){
							?>
											<option value="1" selected >منوی یک</option>
											<option value="2" >منوی دو</option>
											<option value="3">دسته بندی ها</option>
											<option value="4">جستجو</option>
											<option value="5">خروج</option>
											<option value="6">عدم نمایش</option>
											<option value="7">خود بلوتوثی</option>
											<?php }else if($r->value==2){ ?>
											<option value="1">منوی یک</option>
											<option value="2" selected>منوی دو</option>
											<option value="3">دسته بندی ها</option>
											<option value="4">جستجو</option>
											<option value="5">خروج</option>
											<option value="6">عدم نمایش</option>
											<option value="7">خود بلوتوثی</option>
											<?php }else if($r->value==3){?>
											<option value="1">منوی یک</option>
											<option value="2">منوی دو</option>
											<option value="3" selected>دسته بندی ها</option>
											<option value="4">جستجو</option>
											<option value="5">خروج</option>
											<option value="6">عدم نمایش</option>
											<option value="7">خود بلوتوثی</option>
											<?php }else if($r->value==4){?>
											<option value="1">منوی یک</option>
											<option value="2">منوی دو</option>
											<option value="3">دسته بندی ها</option>
											<option value="4" selected>جستجو</option>
											<option value="5" >خروج</option>
											<option value="6">عدم نمایش</option>
											<option value="7">خود بلوتوثی</option>
											<?php }else if($r->value==5){ ?>
											<option value="1">منوی یک</option>
											<option value="2">منوی دو</option>
											<option value="3">دسته بندی ها</option>
											<option value="4">جستجو</option>
											<option value="5" selected>خروج</option>
											<option value="6">عدم نمایش</option>
											<option value="7">خود بلوتوثی</option>
											<?php }else if($r->value == 6){?>
											<option value="1">منوی یک</option>
											<option value="2">منوی دو</option>
											<option value="3">دسته بندی ها</option>
											<option value="4">جستجو</option>
											<option value="5">خروج</option>
											<option value="6" selected>عدم نمایش</option>
											<option value="7">خود بلوتوثی</option>
											<?php }else if($r->value == 7){?>
											<option value="1">منوی یک</option>
											<option value="2">منوی دو</option>
											<option value="3">دسته بندی ها</option>
											<option value="4">جستجو</option>
											<option value="5">خروج</option>
											<option value="6">عدم نمایش</option>
											<option value="7" selected>خود بلوتوثی</option>
											<?php } ?>
							<?php 
							}/*end if*/	} ?>
								
							</select>
						</div>
						<div class="col-md-6">نوع :</div>
					</div>
					<div class="col-md-12" style="margin-top:5px;">
						<div class="col-md-6">
						<?php foreach($res as $r){ 
									if($r->name=="TXT_MNRTI"){
							?>
							<input value="<?= $r->value; ?>" maxlength="10" onkeyup="change_title_menu_right()" id="title_right_menu_app" type="text" placeholder="عنوان" class="form-control">
						<?php }/*end if*/}?>
						</div>
						<div class="col-md-6">عنوان :</div>
					</div>
					
					<div class="col-md-12" style="margin-top:5px;padding:0px;">
						<div class="col-md-6" style="">
						<?php foreach($res as $r){ 
								if($r->name=="TXT_MNRIC"){
									 $right = explode ("__",$r->value);
						?>
								<i style="padding-top:5px;" id="icon_right" class="fa fa-fw fa-3x <?= $right[0]; ?>"></i>
								<input id="txt_menu_right" type="hidden" value="<?= $r->value; ?>">
						<?php }/*end if*/} ?>
							<div class="col-md-6" style="padding-left:5px;padding-top:5px;">
								<button  id="btn_right_menu" onclick="set_menu_app(1)" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
								  انتخاب آیکون
								</button>
							</div>
						</div>
						<div class="col-md-6" style="padding-top:10px;">آیکون :</div>
					</div>
					
					<div class="col-md-12" style="margin-top:5px;">
						<div class="alert alert-info" style="padding:3px;">
						منوی چپ
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="col-md-6">
							<select id ="select_left_menu_app" class="form-control">
								<?php foreach($res as $r){ 
										if($r->name=="NUM_MNLTYPE"){
											if($r->value==1){
							?>
											<option value="1" selected>منوی یکی</option>
											<option value="2" >منوی دو</option>
											<option value="3">دسته بندی ها</option>
											<option value="4">جستجو</option>
											<option value="5">خروج</option>
											<option value="6">عدم نمایش</option>
											<option value="7">خود بلوتوثی</option>
											<?php }else if($r->value==2){ ?>
											<option value="1" >منوی یک</option>
											<option value="2" selected >منوی دو</option>
											<option value="3">دسته بندی ها</option>
											<option value="4">جستجو</option>
											<option value="5">خروج</option>
											<option value="6">عدم نمایش</option>
											<option value="7">خود بلوتوثی</option>
											<?php }else if($r->value==3){?>
											<option value="1" >منوی یک</option>
											<option value="2" >منوی دو</option>
											<option value="3" selected>دسته بندی ها</option>
											<option value="4">جستجو</option>
											<option value="5">خروج</option>
											<option value="6">عدم نمایش</option>
											<option value="7">خود بلوتوثی</option>
											<?php }else if($r->value==4){?>
											<option value="1" >منوی یک</option>
											<option value="2" >منوی دو</option>
											<option value="3">دسته بندی ها</option>
											<option value="4" selected>جستجو</option>
											<option value="5" >خروج</option>
											<option value="6">عدم نمایش</option>
											<option value="7">خود بلوتوثی</option>
											<?php }else if($r->value==5){ ?>
											<option value="1" >منوی یک</option>
											<option value="2" >منوی دو</option>
											<option value="3">دسته بندی ها</option>
											<option value="4">جستجو</option>
											<option value="5" selected>خروج</option>
											<option value="6" >عدم نمایش</option>
											<option value="7">خود بلوتوثی</option>
											<?php }else if($r->value == 6){?>
											<option value="1" >منوی یک</option>
											<option value="2" >منوی دو</option>
											<option value="3">دسته بندی ها</option>
											<option value="4" >جستجو</option>
											<option value="5">خروج</option>
											<option value="6" selected>عدم نمایش</option>
											<option value="7">خود بلوتوثی</option>
											<?php }else if($r->value == 7){?>
											<option value="1" >منوی یک</option>
											<option value="2" >منوی دو</option>
											<option value="3">دسته بندی ها</option>
											<option value="4">جستجو</option>
											<option value="5">خروج</option>
											<option value="6">عدم نمایش</option>
											<option value="7" selected>خود بلوتوثی</option>
											<?php } ?>
							<?php 
							 }/*end if*/ } ?>
							</select>
						</div>
						<div class="col-md-6">نوع :</div>
					</div>
					
					<div class="col-md-12" style="margin-top:5px;">
						<div class="col-md-6">
							<?php foreach($res as $r){ 
									if($r->name=="TXT_MNLTI"){
							?>
							<input value="<?= $r->value; ?>" maxlength="10" onkeyup="change_title_menu_left()" id="title_left_menu_app" type="text" placeholder="عنوان" class="form-control">
							<?php }/*end if*/}?>
						</div>
						<div class="col-md-6">عنوان :</div>
					</div>
					<div class="col-md-12">
						<div class="col-md-6" style="margin-top:5px;">
						<?php foreach($res as $r){ 
								if($r->name=="TXT_MNLIC"){
									 $right = explode ("__",$r->value);
						?>
								<i style="padding-top:5px;" id="icon_left" class="fa fa-fw fa-3x <?= $right[0]; ?>"></i>
								<input id="txt_menu_left" type="hidden" value="<?= $r->value; ?>">
						<?php }/*end if*/} ?>
						<div class="col-md-6" style="padding-left:5px;padding-top:5px;">
							<button class="btn btn-primary" onclick="set_menu_app(2)" data-toggle="modal" data-target="#myModal">
							  انتخاب آیکون
							</button>
						</div>
						</div>
						<div class="col-md-6" style="padding-top:10px;">آیکون :</div>
					</div>
					
					<div class="col-md-12" style="margin-top:5px;">
						<div class="alert alert-info" style="padding:3px;">
						منوی شناور
						</div>
					</div>
					
					<!-- ************************************************** -->
					<div class="col-md-12">
						<div class="col-md-6">
							<select id ="select_float_menu_app" class="form-control">
								<?php foreach($res as $r){ 
										if($r->name=="NUM_MNFTYPE"){
											if($r->value==1){
							?>
											<option value="1" selected>منوی یکی</option>
											<option value="2" >منوی دو</option>
											<option value="3">دسته بندی ها</option>
											<option value="4">جستجو</option>
											<option value="5">خروج</option>
											<option value="6">عدم نمایش</option>
											<option value="7">خود بلوتوثی</option>
											<?php }else if($r->value==2){ ?>
											<option value="1" >منوی یک</option>
											<option value="2" selected >منوی دو</option>
											<option value="3">دسته بندی ها</option>
											<option value="4">جستجو</option>
											<option value="5">خروج</option>
											<option value="6">عدم نمایش</option>
											<option value="7">خود بلوتوثی</option>
											<?php }else if($r->value==3){?>
											<option value="1" >منوی یک</option>
											<option value="2" >منوی دو</option>
											<option value="3" selected>دسته بندی ها</option>
											<option value="4">جستجو</option>
											<option value="5">خروج</option>
											<option value="6">عدم نمایش</option>
											<option value="7">خود بلوتوثی</option>
											<?php }else if($r->value==4){?>
											<option value="1" >منوی یک</option>
											<option value="2" >منوی دو</option>
											<option value="3">دسته بندی ها</option>
											<option value="4" selected>جستجو</option>
											<option value="5" >خروج</option>
											<option value="6">عدم نمایش</option>
											<option value="7">خود بلوتوثی</option>
											<?php }else if($r->value==5){ ?>
											<option value="1" >منوی یک</option>
											<option value="2" >منوی دو</option>
											<option value="3">دسته بندی ها</option>
											<option value="4">جستجو</option>
											<option value="5" selected>خروج</option>
											<option value="6" >عدم نمایش</option>
											<option value="7">خود بلوتوثی</option>
											<?php }else if($r->value == 6){?>
											<option value="1" >منوی یک</option>
											<option value="2" >منوی دو</option>
											<option value="3">دسته بندی ها</option>
											<option value="4" >جستجو</option>
											<option value="5">خروج</option>
											<option value="6" selected>عدم نمایش</option>
											<option value="7">خود بلوتوثی</option>
											<?php }else if($r->value == 7){?>
											<option value="1" >منوی یک</option>
											<option value="2" >منوی دو</option>
											<option value="3">دسته بندی ها</option>
											<option value="4">جستجو</option>
											<option value="5">خروج</option>
											<option value="6">عدم نمایش</option>
											<option value="7" selected>خود بلوتوثی</option>
											<?php } ?>
							<?php 
							 }/*end if*/ } ?>
							</select>
						</div>
						<div class="col-md-6">نوع :</div>
					</div>
					<div class="col-md-12" style="margin-top:5px;">
						<div class="col-md-6">
							<?php foreach($res as $r){ 
									if($r->name=="TXT_MNFTI"){
							?>
							<input value="<?= $r->value; ?>" maxlength="10" onkeyup="change_title_menu_float()" id="title_float_menu_app" type="text" placeholder="عنوان" class="form-control">
							<?php }/*end if*/}?>
						</div>
						<div class="col-md-6">عنوان :</div>
					</div>
					<div class="col-md-12" style="margin-top:5px;">
						<div class="col-md-6">
							<select id ="select_search_menu_app" onchange="select_search_position(event)" class="form-control">
								<?php foreach($res as $r){ 
										if($r->name=="NUM_SRCHP"){
											if($r->value==1){
							?>
											<option value="1" selected>پایین چپ</option>
											<option value="2">پایین راست</option>
											<option value="3">بالا چپ</option>
											<option value="4">بالا راست</option>
											<option value="5">عدم نمایش</option>
											<?php }else if($r->value==2){ ?>
											<option value="1">پایین چپ</option>
											<option value="2" selected>پایین راست</option>
											<option value="3">بالا چپ</option>
											<option value="4">بالا راست</option>
											<option value="5">عدم نمایش</option>
											<?php }else if($r->value==3){?>
											<option value="1">پایین چپ</option>
											<option value="2" >پایین راست</option>
											<option value="3" selected>بالا چپ</option>
											<option value="4">بالا راست</option>
											<option value="5">عدم نمایش</option>
											<?php }else if($r->value==4){?>
											<option value="1">پایین چپ</option>
											<option value="2" >پایین راست</option>
											<option value="3" >بالا چپ</option>
											<option value="4" selected>بالا راست</option>
											<option value="5">عدم نمایش</option>
											<?php }else if($r->value==5){ ?>
											<option value="1">پایین چپ</option>
											<option value="2" >پایین راست</option>
											<option value="3" >بالا چپ</option>
											<option value="4" >بالا راست</option>
											<option value="5" selected>عدم نمایش</option>
											<?php } ?>
											
							<?php }/*end if*/} ?>
							</select>
						</div>
						<div class="col-md-6">مکان نمایش :</div>
					</div>
					
					<div class="col-md-12">
						<div class="col-md-6" style="margin-top:5px;">
						<?php foreach($res as $r){ 
								if($r->name=="NUM_SRCHIC"){
									 $right = explode ("__",$r->value);
						?>
								<i style="padding-top:5px;" id="icon_search" class="fa fa-fw fa-3x <?= $right[0]; ?>"></i>
								<input id="txt_menu_search" type="hidden" value="<?= $r->value; ?>">
						<?php }/*end if*/} ?>
						<div class="col-md-6" style="padding-left:5px;padding-top:5px;">
							<button  class="btn btn-primary" onclick="set_menu_app(3)" data-toggle="modal" data-target="#myModal">
							  انتخاب آیکون
							</button>
						</div>
						</div>
						<div class="col-md-6" style="padding-top:10px;">آیکون :</div>
					</div>
					<!-- *********************************************************************************** -->
					
					<div class="col-md-12" style="margin-top:10px;">
						<div class="col-md-4" >
								<button type="button" id="btn_set_app" onclick="save_setting_app(<?php echo $type; ?>)" class="btn btn-primary">
								ذخیره تغییرات
								<label class="fa fa-2x fa-save"><label>
								</button>
						</div>
					</div>
					
					<div class="col-md-12 "  style="margin-top:5px;">
						<div id="alert_save" class="alert alert-success hide">
						تنظیمات شما ذخیره شد.
						</div>
					</div>
					<div>
								
	                        </div>
	                    </div>
					</div>
				</div>
			<?php		
		 }
		 //---------------end primery setting---------------------
		 
	}
}
//-------------------------------------------------------------------------------
add_action( 'wp_ajax_mishagetposts', 'rudr_get_posts_ajax_callback1' ); // wp_ajax_{action}
function rudr_get_posts_ajax_callback1(){

	// we will pass post IDs and titles to this array

	$return = array();

	// you can use WP_Query, query_posts() or get_posts() here - it doesn't matter
	$post_type = get_option('mr2app_post_type');
	if(!is_array($post_type)) $post_type = array('post');
	$search_results = new WP_Query( array(
		's'=> $_GET['q'], // the search query
		'post_status' => 'publish', // if you don't want drafts to be returned
		'ignore_sticky_posts' => 1,
		'posts_per_page' => -1 ,// how much to show at once
		'post_type' =>  $post_type,
	));

	if( $search_results->have_posts() ) :
		while( $search_results->have_posts() ) : $search_results->the_post();
			// shorten the title a little
			$title = ( mb_strlen( $search_results->post->post_title ) > 50 ) ? mb_substr( $search_results->post->post_title, 0, 49 ) . '...' : $search_results->post->post_title;
			$return[] = array( $search_results->post->ID, $title ); // array( Post ID, Post Title )
		endwhile;
	endif;
	echo  json_encode($return) ;
	die;
}
add_action( 'wp_ajax_mishagettags', 'rudr_get_tags_ajax_callback1' ); // wp_ajax_{action}
function rudr_get_tags_ajax_callback1(){

	// we will pass post IDs and titles to this array

	 $args = array();
	 $return = array();

	$args = array('post_tag');
	 $post_types = get_option('mr2app_post_type');
	 if(!is_array($post_types)) $args = array('post_tag');
	 //$post_types = array( 'product');
// 	 foreach ( $post_types as $t ){
// 	 	$args[] = $t.'_tag';
// 	 }
	 //echo $args;
	 $cats = get_terms($args , array('search' => $_GET['q']));
	foreach ($cats as $cat) {
            $title = $cat->name;
			$return[] = array( $cat->slug, $title ); // array( Post ID, Post Title )
	}
	echo  json_encode($return) ;
	//echo $t;
	die;
}

add_action( 'wp_ajax_load_item_hami_wp2app','load_item_hami_wp2app' );
function load_item_hami_wp2app(){

	global $wpdb;
    $exp = 1;
	$table_name = $wpdb->prefix . "hami_mainpage";
	$res = $wpdb->get_results("select * from $table_name order by mp_order");
    $i = -1;
	foreach ($res as $key) {
        $i++;
	?>
		<li  id="record<?= $key->mp_id; ?>">

		  	<div class="alert alert-info class_menu_appost_hover" style="<?= ($exp == 1 || $i < 2 )? '' : 'opacity:0.4';?>;padding-right:2px;height:40px;padding-top:5px;background-color:#337AB7;border-color:#337AB7;">
		  		<div class="col-md-8 pull-right text-right " style="color:white;">
		  			<?php
		  				if($key->mp_showtype == 1) echo 'بنر :';
		  				elseif($key->mp_showtype == 2) echo 'لیست افقی :';
		  				elseif($key->mp_showtype == 3) echo 'لیست عمودی :';

		  				if($key->mp_title == "") echo '[بدون عنوان]';
		  				else{
		  					echo esc_html($key->mp_title); 
		  				}
		  			?>
		  			<input type="hidden" name="id[]" value="<?php echo $key->mp_id; ?>">
		  		</div>
		  		<div class="col-md-4 pull-right text-left">
		  			<button onclick="delete_item_mainepage_wp2app(<?php echo $key->mp_id; ?>)" type="button" class="btn btn-danger btn-xs" >حذف</button>
		  		</div>
		  	</div>
	  	</li>
	<?php
	}
}
//----------------------------------------------------------------------------------------
add_action( 'wp_ajax_save_order_wp2app_item','save_order_wp2app_item' );
function save_order_wp2app_item(){
	global $wpdb;
	$table_name = $wpdb->prefix . 'hami_mainpage';
	$r = "";	
	$data = (explode("_",$_POST["id"])) ;
	$i = 1;
	foreach($data as $id){
		$r += $wpdb->update( $table_name, 
		array( 'mp_order' => $i),
		array( 'mp_id' => $id ), array( '%d' ), array( '%d' ) );
		$i++;
	}
	do_action( 'myplugin_after_form_settings' );
	if($r) echo 1;
}
//---------------------------------------------------------------
add_action( 'wp_ajax_add_item_hami_wp2app','add_item_hami_wp2app' );
function add_item_hami_wp2app(){
	$title = sanitize_text_field($_REQUEST["title"]);
	$type = sanitize_text_field($_REQUEST["type"]);
	$showtype = sanitize_text_field($_REQUEST["showtype"]);
	if(in_array($showtype , array(4,7,8,9))){
		$value = sanitize_text_field($_REQUEST['b0']).sanitize_text_field($_REQUEST['b1']).sanitize_text_field($_REQUEST['b2']).sanitize_text_field($_REQUEST['b3']).sanitize_text_field($_REQUEST['b4']);
	}
	else{
		$value = $_REQUEST["value"];
	}
	$pic = sanitize_text_field($_REQUEST["pic"]);
	global $wpdb;
	$table_name = $wpdb->prefix . "hami_mainpage";
	$res = $wpdb->get_results("select MAX(mp_order) AS max_order from $table_name");
 
	if(!is_null($res[0]->max_order)){
		foreach ($res as $key) {
			$max = $key->max_order + 1;
		}
	}else{
		$max = 1;
	}
	
	$r = $wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
		( mp_title , mp_type , mp_value , mp_showtype , mp_pic , mp_order ) 
		VALUES ( %s, %d, %s, %d, %s, %d )", $title,$type,$value,$showtype,$pic,$max) );
	if($r){
		do_action( 'myplugin_after_form_settings' );
		echo 1;
	}
}
//-------------------------------------------------------------------
add_action( 'wp_ajax_delete_item_mainepage_wp2app','delete_item_mainepage_wp2app' );
function delete_item_mainepage_wp2app(){
	$id = sanitize_text_field($_REQUEST["id"]);
	global $wpdb;
	$table_name = $wpdb->prefix . "hami_mainpage";
	$r = $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE mp_id = %d" , $id));
	if($r){
		do_action( 'myplugin_after_form_settings' );
		echo "1";
	}else{
		echo "2";
	}
}



add_action( 'wp_ajax_load_all_post','load_all_post' );
function load_all_post(){
	$s = $_REQUEST["search_product"];
	$post_type = get_option('mr2app_post_type');
	if(!is_array($post_type)) $post_type = array('post');
	$args = array(
		'numberposts' => 50,
		'post_type' =>  $post_type,
         's' => $s
	);
	$posts = get_posts($args);
	foreach ($posts as $post) {
	    ?>
       <option style="text-align:right;" value="<?= $post->ID; ?>"><?= $post->post_title; ?></option>
        <?php
         }
}
//-------------------------------------------------------
add_action( 'wp_ajax_load_list_slider_wp2app','load_list_slider_wp2app' );
function load_list_slider_wp2app(){
	global $wpdb;
	$table_name = $wpdb->prefix . "hami_slider";
	$sliders = $wpdb->get_results("select * from $table_name");
   $exp = 1;
    $i = -1;
	foreach ($sliders as $slider) {
        $i++;
	?>
	 	<tr id="row_slider_<?= $slider->sl_id; ?>" style="<?= ($exp == 1 || $i < 2 )? '' : 'opacity:0.4';?>;">
	        <td><?= esc_html($slider->sl_title);  ?></td>
	        <td>
	        <img height="30px;" src="<?= $slider->sl_pic;  ?>">
	        </td>
	        <td>
	        	<button onclick="delete_slider_wp2app(<?= $slider->sl_id; ?>)" type="button" class="btn btn-danger btn-xs">حذف</button>
	        </td>
        </tr> 
	<?php
	}
}
//-----------------------------------------------------------------------
add_action( 'wp_ajax_delete_item_slider_wp2app','delete_item_slider_wp2app' );
function delete_item_slider_wp2app(){
	$id = sanitize_text_field($_REQUEST["id"]);
	global $wpdb;
	$table_name = $wpdb->prefix . "hami_slider";
	$r = $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE sl_id = %d" , $id));
	if($r){
		do_action( 'myplugin_after_form_settings' );
		echo "1";
	}else{
		echo "2";
	}
}
//---------------------------------------------------------------
add_action( 'wp_ajax_add_slider_hami_wp2app','add_slider_hami_wp2app' );
function add_slider_hami_wp2app(){
	$title = sanitize_text_field($_REQUEST["title"]);
	$pic = sanitize_text_field($_REQUEST["pic"]);
	$type = sanitize_text_field($_REQUEST["type"]);
	$value = sanitize_text_field($_REQUEST["value"]);
	global $wpdb;
	$table_name = $wpdb->prefix . "hami_slider";
	$r = $wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
		( sl_title , sl_type , sl_value , sl_pic ) 
		VALUES ( %s, %d, %s, %s )", $title,$type,$value,$pic) );
	if($r){
		do_action( 'myplugin_after_form_settings' );
		echo 1;
	}else{
		echo 2;
	}
}
//-------------------------------------------------------------------------------
add_action( 'wp_ajax_load_all_product_wp2appir','load_all_product_wp2appir' );
function load_all_product_wp2appir(){
	$s = $_REQUEST["search_product"];
                        $args = array(
                            'numberposts'       => -1,
                            'orderby'          => 'ID',
                            'order'            => 'DESC',
                            'post_type'        => 'POST',
                            'post_status'      => 'publish',
                            'suppress_filters' => true ,
                            's' => $s
                        );
                        $posts = get_posts($args);
                        foreach ($posts as $post) {
                        ?>
                            <option style="text-align:right;" value="<?= $post->ID; ?>"><?= $post->post_title; ?></option>
                        <?php   
                        }
}
add_action( 'wp_ajax_wp2app_update_post_meta', 'wp2app_update_post_meta' ); // wp_ajax_{action}
function wp2app_update_post_meta(){
	$post_id = $_REQUEST['post_id'];
	$meta_key = $_REQUEST['meta_key'];
	$active = $_REQUEST['active'] ;
	echo update_post_meta($post_id,$meta_key,$active);
}