<?php 
$current_url="//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

wp_register_style( 'wp2app_style', WP2APPIR_CSS_URL.'wp2app_style.css'  );
wp_enqueue_style('wp2app_style');

if(isset($_GET["tab"]))
	$tab = $_GET["tab"];
else
	$tab = 1;
?>
<h2 class="nav-tab-wrapper koodak">
    <a href="<?= $current_url.'&tab=1' ?>" class="koodak nav-tab <?php echo (1 == $tab) ? 'nav-tab-active' : ''; ?>">چیدمان صفحه اصلی</a>
    <a href="<?= $current_url.'&tab=2' ?>" class="koodak nav-tab <?php echo (2 == $tab) ? 'nav-tab-active' : ''; ?>">اسلایدر</a>
    <a href="<?= $current_url.'&tab=3' ?>" class="koodak nav-tab <?php echo (3 == $tab) ? 'nav-tab-active' : ''; ?>">تنظیمات نمایش</a>
    <a href="<?= $current_url.'&tab=4' ?>" class="koo   dak nav-tab <?php echo (4 == $tab) ? 'nav-tab-active' : ''; ?>">اسپلش</a>
</h2>
<?php

switch ($tab) {
	case 1:
		require_once('wp2app_mainpage.php');
		break;
	case 2:
		require_once('wp2app_slider.php');
		break;
	case 3:
		require_once('hami_manager_setting_new.php');
		break;
	case 4:
		require_once('wp2app_splash.php');
		break;
	default:
		require_once('wp2app_mainpage.php');
		break;
}