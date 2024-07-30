<div class="wphex-product-extract-wrapper">
	<div class="xg-product-extract-header">
		<h1 class="title"><?php esc_html_e('Envato Product Extract By Product Id','wphex');?></h1>
		<p><?php esc_html_e('import your envato product information by product id, after extract product information it will store it as a EDD download item with all the details','wphex');?></p>
	</div>
	<?php
	$wphex = wphex();
	$response_status = $wphex->get_flash_message('purchase_status');
	if (!empty($response_status)): ?>
		<div class="xg-notice-area <?php echo $response_status == 200 ? esc_attr('success') : esc_attr('danger');?>">
			<?php
			$extract_message = $wphex->get_flash_message('extract_message');
			printf('<p>&nbsp; %1$s</p>',$extract_message);
			?>
		</div>
	<?php endif;?>
	<form action="<?php echo admin_url('admin-post.php')?>" method="POST">
		<input type="hidden" name="action" value="extract_product_from_envato">
		<?php wp_nonce_field('extract_product_from_envato');?>
		<input type="text" name="item_id" placeholder="<?php esc_html_e('Item Id','wphex');?>">
		<select name="item_type" id="item_type">
			<option value="wordpress"><?php esc_html_e('WordPress Theme','wphex');?></option>
			<option value="react"><?php esc_html_e('React Template','wphex');?></option>
			<option value="html"><?php esc_html_e('HTML Template','wphex');?></option>
			<option value="psd"><?php esc_html_e('PSD Template','wphex');?></option>
			<option value="laravel"><?php esc_html_e('Laravel Script','wphex');?></option>
		</select>
		<button type="submit" class="button button-primary "><?php esc_html_e('Extract','wphex');?></button>
	</form>
</div>