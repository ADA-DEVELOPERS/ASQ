<?php
	$cryption_item_data = ct_get_sanitize_client_data(get_the_ID());
	$cryption_item_data['link'] = $cryption_item_data['link'] ? $cryption_item_data['link'] : '#';
	$cryption_classes = array('ct-client-item');
	if (!empty($params['effects_enabled'])) {
		$cryption_classes[] = 'lazy-loading-item';
	}
?>

<div id="post-<?php the_ID(); ?>" <?php post_class($cryption_classes); ?> <?php if(!$params['widget']) : ?>style="width: <?php echo esc_attr(100/$cols); ?>%;"<?php endif; ?> <?php if(!empty($params['effects_enabled'])): ?>data-ll-effect="drop-bottom"<?php endif; ?>>
	<a href="<?php echo esc_url($cryption_item_data['link']); ?>" target="<?php echo esc_attr($cryption_item_data['link_target']); ?>" class="gscale">
		<?php
			if($params['widget']) {
				$cryption_small_image_url = cryption_generate_thumbnail_src(get_post_thumbnail_id(), 'ct-widget-column-1x');
				$cryption_small_image_url_2x = cryption_generate_thumbnail_src(get_post_thumbnail_id(), 'ct-widget-column-2x');
				echo '<img src="'.esc_url($cryption_small_image_url[0]).'" srcset="'.esc_attr($cryption_small_image_url_2x[0]).' 2x" width="'.esc_attr($cryption_small_image_url[1]).'" alt="'.get_the_title().'" class="img-responsive"/>';
			} else {
				cryption_post_thumbnail('ct-person', true, 'img-responsive');
			}
		?>
	</a>
</div>