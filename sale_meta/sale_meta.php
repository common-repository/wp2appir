<?php
$current_url = admin_url().'admin.php?page=wp2appir/sale_meta/sale_meta.php';
$tab = "sales";
if (array_key_exists('tab', $_GET)) {
	$tab = $_GET['tab'];
}
?>
<div class="wrap">
    <h2 class="nav-tab-wrapper koodak">
        <a href="<?= $current_url.'&tab=sales' ?>" class="nav-tab <?php echo ('sales' == $tab) ? 'nav-tab-active' : ''; ?>"> جدول فروش </a>
        <a href="<?= $current_url.'&tab=plans' ?>" class="nav-tab <?php echo ('plans' == $tab) ? 'nav-tab-active' : ''; ?>"> پلن های فروش </a>
        <a href="<?= $current_url.'&tab=gateway' ?>" class="nav-tab <?php echo ('gateway' == $tab) ? 'nav-tab-active' : ''; ?>"> درگاه فروش </a>
    </h2>
    <p>
        این بخش نیازمند فعال سازی
        <a target="_blank" href="http://mr2app.com/blog/wp-file-shop">
            ماژول فروش فایل
        </a>
        ، در اپلیکیشن می باشد.
    </p>
	<?php
	if($tab == 'sales'){
		require_once  "sales.php";
	}
    elseif ($tab == 'plans'){
		require_once 'plans.php';
	}
	elseif ($tab == 'gateway'){
		require_once 'gateway.php';
	}
	?>
</div>
