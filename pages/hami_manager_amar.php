<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wp_register_style( 'bootstrap', WP2APPIR_CSS_URL.'bootstrap.css'  );
wp_enqueue_style('bootstrap');
wp_register_style( 'font-awesome', WP2APPIR_CSS_URL.'font-awesome.css'  );
wp_enqueue_style('font-awesome');
wp_register_style( 'wp2app_fonts', 'http://wp2app.ir/downloads/plugin-asset/wp2app_fonts.css'  );
wp_enqueue_style('wp2app_fonts');
?>
<div class="col-md-12" >

	<div class="col-md-3" >
	<button onclick="get_amar(4)" type="button" class="btn btn-primary btn-lg">آمار جامع</button>
	</div>
	<div class="col-md-3" >
	<button onclick="get_amar(3)" type="button" class="btn btn-primary btn-lg">آمار ماهیانه</button>
	</div>
	<div class="col-md-3" >
	<button onclick="get_amar(2)" type="button" class="btn btn-primary btn-lg">آمار هفتگی</button>
	</div>
	<div class="col-md-3" >
	<button onclick="get_amar(1)" type="button" class="btn btn-primary btn-lg">آمار روزانه</button>
	</div>
</div>
<div class="col-md-12" style="margin-top:15px;">
				<div class="col-md-4" >
                    
				</div>
				<div class="col-md-6">
                    <div class="well well-sm" style="min-height:5px;max-height:auto;">
						<table class="table">
                                    
                                    <tbody>
										<tr>
										<a target="_blank" href="http://wp2app.ir/plugin_statistics/">راهنما <i class="fa fa-1x fa-mortar-board"></i></a>
										</tr>
                                        <tr>
                                            <td>تعداد کل اتصالات</td>
                                            <td id="all_con"></td>
                                            
                                        </tr>
                                        <tr>
                                            <td>تعداد دستگاه های منحصر به فرد</td>
                                            <td id="yekam_all"> </td>
                                            
                                        </tr>
                                        <tr>
                                            <td>تعداد IP های منحصر به فرد</td>
                                            <td id="all_ip"></td>
                                            
                                        </tr>
                                    </tbody>
						</table>
                    </div>
				</div>
				<div class="col-md-2">
                    
				</div>
</div>
		<div class="col-md-12">
			
		</div>		
<?php
		wp_enqueue_script( 'amar.js' , WP2APPIR_JS_URL.'amar.js', array('jquery'));
?>
				