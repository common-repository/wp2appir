<?php
//var_dump($_POST['post_type']);
if($_POST){
	update_option('mr2app_post_type',$_POST['post_type']);
}

$post_types = get_option('mr2app_post_type');
if(!is_array($post_types)){
    $post_types = array();
}

?>
<div class="wrap">
	<p  class="">
		<input type="checkbox"  id="select_all" value="" placeholder="عنوان">
		<strong > انتخاب همه   </strong>
	</p>
	<hr>
	<form action="" method="post">

		<?php
		$types = get_post_types();
		foreach ($types as $t){
			?>
			<p class="">
				<input type="checkbox" <?= (in_array($t,$post_types)) ? 'checked': '' ?> name="post_type[]" class="post_type" value="<?= $t ?>" >
				<label > <?= $t?>  </label>
			</p>
			<?php
		}
		?>
		<input name="submit" class="button button-primary" type="submit" value="ذخیره">
	</form>
</div>

<script>
    jQuery('#select_all').change(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
</script>