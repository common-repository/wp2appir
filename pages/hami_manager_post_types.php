<?php $current_url="//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>
<?php

if(isset($_GET["tab"]))
	$tab = $_GET["tab"];
else
	$tab = 1;
?>
    <h2 class="nav-tab-wrapper koodak">
        <a href="<?= $current_url.'&tab=1' ?>" class="nav-tab <?php echo (1 == $tab) ? 'nav-tab-active' : ''; ?>">انتخاب دسته بندی ها</a>
        <a href="<?= $current_url.'&tab=2' ?>" class="nav-tab <?php echo (2 == $tab) ? 'nav-tab-active' : ''; ?>">انتخاب انواع مطالب</a>
        <a href="<?= $current_url.'&tab=3' ?>" class="nav-tab <?php echo (3 == $tab) ? 'nav-tab-active' : ''; ?>">انتخاب  زمینه های دلخواه </a>
    </h2>
    <br>
<?php
if($tab == 1) {
	//this is for category
	require_once('get_category_list.php');
}
elseif ($tab == 2) {
	//this is for post types
	require_once('get_post_types_list.php');
}
elseif ($tab == 3) {
	//this is for custom fields
	require_once  "wp2app_post_meta.php";
}
?>