<div class="wphex-product-extract-wrapper">
	<div class="xg-product-extract-header">
		<h1 class="title"><?php esc_html_e('Envato Purchase Verify By Purchase Code','wphex');?></h1>
		<p><?php esc_html_e('verify your envato customer using their purchase code','wphex');?></p>
	</div>
	<?php
		$wphex = wphex();
		$response_status = $wphex->get_flash_message('purchase_status');
	if (!empty($response_status)): ?>
    <div class="xg-notice-area <?php echo $response_status == 200 ? esc_attr('success') : 'danger'?>">
	    <?php
	    $purchase_verify_info = [
		    'purchase_message',
		    'buyer',
		    'license',
		    'sold_at',
		    'purchase_count',
		    'supported_until' ,
		    'item_name'
	    ];
	    foreach ($purchase_verify_info as $key){
	    	$message = wphex()->get_flash_message($key);
	    	if (!empty($message)){
	    		$title = str_replace('_',' ',$key);
		        printf('<p><strong>%1$s :</strong>&nbsp; %2$s</p>',$title, $message);
		    }
	    }
	    ?>
    </div>
	<?php endif;?>
	<form action="<?php echo admin_url('admin-post.php')?>" method="POST">
		<input type="hidden" name="action" value="envato_purchase_verify">
		<?php wp_nonce_field('envato_purchase_verify');?>
		<input type="text" name="purchase_code" placeholder="<?php esc_html_e('Purchase Code','wphex');?>">
		<button type="submit" class="button button-primary "><?php esc_html_e('Purchase Verify','wphex');?></button>
	</form>
</div>