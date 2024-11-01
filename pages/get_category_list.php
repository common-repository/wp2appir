<?php
//var_dump($_POST['category']);
if($_POST){
	//echo 1;
	update_option('mr2app_post_category',$_POST['category']);
}

$categories = get_option('mr2app_post_category');
if(!is_array($categories)) $categories = array();
//var_dump($categories);
?>
<div class="wrap">
	<p  class="">
		<input type="checkbox"  id="select_all" value="" placeholder="عنوان">
		<strong > انتخاب همه   </strong>
	</p>
	<hr>
	<form action="" method="post">
		<?php
		$x = get_taxonomies();
		//var_dump($x);
		foreach ($x as $xx){
			$cats = get_terms($xx , array('hide_empty' => false));
			if(empty($cats)) continue;
			?>
			<strong> <?= $xx; ?> </strong>
			<?php
			foreach ($cats as $c){
				?>
				<p class="">
					<input type="checkbox" <?= (in_array($c->term_id,$categories)) ? 'checked': '' ?> name="category[]" class="category" value="<?= $c->term_id;?>" >
					<label > <?= $c->name?>  </label>
				</p>
				<?php
			}
			echo '<hr>';
		}
		?>
		<input name="submit" class="button button-primary" type="submit" value="ذخیره">
	</form>
</div>

<script>
    jQuery('#select_all').change(function() {
        jQuery('input:checkbox').not(this).prop('checked', this.checked);
    });
</script>