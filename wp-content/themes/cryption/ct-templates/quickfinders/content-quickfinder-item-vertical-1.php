<?php
	$params = empty($params) ? array() : $params;
	$params = array_merge(array(
		'box_border_color' => '',
	), $params);
	$ct_item_data = ct_get_sanitize_qf_item_data(get_the_ID());
		
	$ct_quickfinder_effect = 'quickfinder-item-effect-';
	if($ct_item_data['icon_border_color'] && $ct_item_data['icon_background_color']) {
		$ct_quickfinder_effect .= 'border-reverse border-reverse-with-background';
	} elseif($ct_item_data['icon_border_color']) {
		$ct_quickfinder_effect .= 'border-reverse';
	} elseif($ct_item_data['icon_background_color']) {
		$ct_quickfinder_effect .= 'background-reverse';
	} else {
		$ct_quickfinder_effect .= 'scale';
	}

	if(!$ct_item_data['icon'] && has_post_thumbnail()) {
		$ct_quickfinder_effect = 'quickfinder-item-effect-image-scale';
	}

	$ct_icon_css_style = 'box-shadow: 0 0 0 3px #ffffff, 0 0 0 6px '.$connector_color.';';
	
	$ct_icon_shortcode = ct_build_icon_shortcode(array_merge($ct_item_data, array('css_style' => $ct_icon_css_style)));

	$ct_link_start = '<span class="quickfinder-item-link ' . ($ct_item_data['icon_shape'] == 'circle' ? 'img-circle' : 'rounded-corners') .'">';
	$ct_link_end = '</span>';
	if($ct_link = ct_get_data($ct_item_data, 'link')) {
		$ct_link_start = '<a href="'.esc_url($ct_link).'" class="quickfinder-item-link ' . ($ct_item_data['icon_shape'] == 'circle' ? 'img-circle' : 'rounded-corners') .'" target="'.esc_attr(ct_get_data($ct_item_data, 'link_target')).'">';
		$ct_link_end = '</a>';
	}
	$ct_title_text_color = '';
	if( !empty($ct_item_data['title_text_color'])){
		$ct_title_text_color = 'style="color: '. $ct_item_data['title_text_color'] .';"';	
	}
	$ct_description_text_color = '';
	if( !empty($ct_item_data['description_text_color'])){
		$ct_description_text_color = 'style="color: '. $ct_item_data['description_text_color'] .'
		;"';	
	}
	switch ( $ct_item_data['icon_size'] ) {
		case 'small':
			$ct_border_indent = '26.5px';
			break;
		case 'medium':
			$ct_border_indent = '41.5px';
			break;
		case 'large':
			$ct_border_indent = '81.5px';
			break;
		case 'xlarge':
			$ct_border_indent = '121.5px';
			break;
	}

?>
<div id="post-<?php the_ID(); ?>" <?php if($params['effects_enabled']) echo ' data-ll-finish-delay="200" '; ?> <?php post_class(array( 'quickfinder-item', $quickfinder_item_rotation, $ct_quickfinder_effect, $ct_item_data['icon_size'], $params['effects_enabled'] ? 'lazy-loading' : '')); ?>>
	<?php if($quickfinder_style == 'vertical-1' && $quickfinder_item_rotation == 'odd') : ?>
		<div class="quickfinder-item-info-wrapper">
			<svg class="qf-svg-arrow-right" viewBox="0 0 50 100">
				<use xlink:href="<?php echo esc_url(get_template_directory_uri() . '/css/post-arrow.svg'); ?>#dec-post-arrow"></use>
			</svg>
			<?php if($quickfinder_style == 'vertical-1') : ?>
				<div class="connector-top" style="border-color: <?php echo $connector_color; ?>; right: -<?php echo $ct_border_indent;?>;">
				</div>
				<div class="connector-bot" style="border-color: <?php echo $connector_color; ?>; right: -<?php echo $ct_border_indent;?>;">
				</div>
			<?php endif; ?>
			<div class="quickfinder-item-info <?php if($params['effects_enabled']): ?>lazy-loading-item<?php endif; ?>" <?php if($params['effects_enabled']): ?>data-ll-item-delay="200" data-ll-effect="fading"<?php endif; ?>>
				<div style="display: block; min-height: 250px;">
					<?php the_title('<div class="quickfinder-item-title" '. $ct_title_text_color .'>', '</div>'); ?>
					<?php echo ct_get_data($ct_item_data, 'description', '', '<div class="quickfinder-item-text" '.$ct_description_text_color.'>', '</div>'); ?>
				</div>
			</div>
			<?php if($ct_item_data['link']) : ?>
				<a href="<?php echo esc_url($ct_item_data['link']); ?>" target="<?php echo esc_attr($ct_item_data['link_target']); ?>" class="quickfinder-item-link"></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	
		<div class="quickfinder-item-image">
			<div class="quickfinder-item-image-content<?php if($params['effects_enabled']): ?> lazy-loading-item<?php endif; ?>" <?php if($params['effects_enabled']): ?>data-ll-item-delay="0" data-ll-effect="clip"<?php endif; ?>>
				<?php if($ct_item_data['icon']) : ?>
					<div class="quickfinder-item-image-wrapper">
						<?php echo do_shortcode($ct_icon_shortcode); ?>
						</div>
				<?php else : ?>
					<div class="quickfinder-item-image-wrapper quickfinder-item-picture quickfinder-item-image-shape-<?php echo $ct_item_data['icon_shape'] ?>" style="<?php echo $ct_icon_css_style; ?>">
						<?php ct_post_thumbnail('ct-person', true, ' quickfinder-img-size-'.$ct_item_data['icon_size']); ?>
					</div>
				<?php endif; ?>
				<?php if($ct_item_data['link']) : ?>
					<a href="<?php echo esc_url($ct_item_data['link']); ?>" target="<?php echo esc_attr($ct_item_data['link_target']); ?>" class="quickfinder-item-link"></a>
				<?php endif; ?>
			</div>
		</div>
	
	<?php if($quickfinder_style != 'vertical-1' || $quickfinder_item_rotation == 'even') : ?>
		<div class="quickfinder-item-info-wrapper">
			<svg class="qf-svg-arrow-left" viewBox="0 0 50 100">
				<use xlink:href="<?php echo get_template_directory_uri() . '/css/post-arrow.svg' ?>#dec-post-arrow"></use>
			</svg>
			<?php if($quickfinder_style == 'vertical-1') : ?>
				<div class="connector-top" style="border-color: <?php echo esc_attr($connector_color); ?>; left: -<?php echo $ct_border_indent;?>;">
				</div>
				<div class="connector-bot" style="border-color: <?php echo esc_attr($connector_color); ?>; left: -<?php echo $ct_border_indent;?>;">
				</div>
			<?php endif; ?>
			<div class="quickfinder-item-info <?php if($params['effects_enabled']): ?>lazy-loading-item<?php endif; ?>" <?php if($params['effects_enabled']): ?>data-ll-item-delay="200" data-ll-effect="fading"<?php endif; ?>>
				<div style="display: block; min-height: 250px;">
				<?php the_title('<div class="quickfinder-item-title"  '.$ct_title_text_color.'>', '</div>'); ?>
				<?php echo ct_get_data($ct_item_data, 'description', '', '<div class="quickfinder-item-text" '.$ct_description_text_color.'>', '</div>'); ?>
				</div>
			</div>
			<?php if($ct_item_data['link']) : ?>
				<a href="<?php echo esc_url($ct_item_data['link']); ?>" target="<?php echo esc_attr($ct_item_data['link_target']); ?>" class="quickfinder-item-link"></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>
