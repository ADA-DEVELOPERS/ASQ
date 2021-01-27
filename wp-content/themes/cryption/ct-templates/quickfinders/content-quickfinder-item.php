<?php
	$params = empty($params) ? array() : $params;
	$params = array_merge(array(
		'columns' => 4,
		'alignment' => 'center',
		'icon_position' => 'top',
		'activate_button' => 0,
		'effects_enabled' => ''
	), $params);
	$ct_item_data = ct_get_sanitize_qf_item_data(get_the_ID());
	$ct_icon_shortcode = ct_build_icon_shortcode($ct_item_data);
	$ct_quickfinder_effect = 'quickfinder-item-effect-';
	if($ct_item_data['icon_border_color'] && $ct_item_data['icon_background_color']) {
		$ct_quickfinder_effect .= 'border-reverse border-reverse-with-background';
	} elseif($ct_item_data['icon_border_color']) {
		$ct_quickfinder_effect .= 'border-reverse';
	} elseif($ct_item_data['icon_background_color']) {
		$ct_quickfinder_effect .= 'background-reverse';
	} else {
		$ct_quickfinder_effect .= 'simple';
	}
	if(!$ct_item_data['icon'] && has_post_thumbnail()) {
		$ct_quickfinder_effect = 'quickfinder-item-effect-image-scale';
	}
	$ct_title_text_color = '';
	if(!empty($ct_item_data['title_text_color'])){
		$ct_title_text_color = ' style="color: '. $ct_item_data['title_text_color'] .';"';
	}
	$ct_description_text_color = '';
	if(!empty($ct_item_data['description_text_color'])){
		$ct_description_text_color = ' style="color: '. $ct_item_data['description_text_color'] .';"';
	}
	$ct_columns_class = 'col-md-3 col-xs-6';
	switch ($params['columns']) {
		case 1:
			$ct_columns_class = 'col-md-12 col-sm-12 col-xs-12'; break;
		case 2:
			$ct_columns_class = 'col-md-6 col-sm-6 col-xs-12'; break;
		case 3:
			$ct_columns_class = 'col-md-4 col-sm-6 col-xs-12'; break;
		case 6:
			$ct_columns_class = 'col-md-2 col-sm-3 col-xs-4'; break;
		default:
			$ct_columns_class = 'col-md-3 col-xs-6';
	}

	$ct_button = $params['activate_button'] && $ct_item_data['link'] ? ct_button(array(
		'text' => $ct_item_data['link_text'] ? $ct_item_data['link_text'] : __('Read more', 'cryption'),
		'style' => $params['button_style'],
		'text_weight' => $params['button_text_weight'],
		'corner' => $params['button_corner'],
		'position' => 'inline',
		'text_color' => $params['button_text_color'],
		'background_color' => $params['button_background_color'],
		'border_color' => $params['button_border_color'],
		'extra_class' => 'quickfinder-button',
	)) : '';
?>
<div id="post-<?php the_ID(); ?>" <?php if($params['effects_enabled']) echo ' data-ll-finish-delay="200" '; ?> <?php post_class(array('quickfinder-item', 'inline-column', $ct_columns_class, $ct_quickfinder_effect, 'icon-size-'.$ct_item_data['icon_size'], $params['effects_enabled'] ? 'lazy-loading' : '')); ?>>
	<?php if($params['icon_position'] == 'top-float' || $params['icon_position'] == 'center-float') : ?><div class="quickfinder-item-table"><?php endif; ?>
	<div class="quickfinder-item-inner">
		<?php if($params['icon_position'] == 'top' || ($params['icon_position'] != 'bottom' && $params['alignment'] != 'right')) : ?>
			<div class="quickfinder-item-image">
					<div class="quickfinder-item-image-content <?php if($params['effects_enabled']): ?>lazy-loading-item<?php endif; ?>" <?php if($params['effects_enabled']): ?>data-ll-item-delay="0" data-ll-effect="clip"<?php endif; ?>>
						<?php if($ct_item_data['icon']) : ?>
							<div class="quickfinder-item-image-wrapper">
								<?php echo do_shortcode($ct_icon_shortcode); ?>
							</div>
						<?php else : ?>
							<div class="quickfinder-item-image-wrapper quickfinder-item-picture quickfinder-item-image-shape-<?php echo $ct_item_data['icon_shape'] ?>">
								<?php ct_post_thumbnail('ct-person', true, ' quickfinder-img-size-'.$ct_item_data['icon_size']); ?>
							</div>
						<?php endif; ?>
					</div>
			</div>
		<?php endif; ?>
		<div class="quickfinder-item-info-wrapper">
			<div class="quickfinder-item-info <?php if($params['effects_enabled']): ?>lazy-loading-item<?php endif; ?>" <?php if($params['effects_enabled']): ?>data-ll-item-delay="200" data-ll-effect="fading"<?php endif; ?>>
				<?php the_title('<div class="quickfinder-item-title" '.$ct_title_text_color.'>', '</div>'); ?>
				<?php echo ct_get_data($ct_item_data, 'description', '', '<div class="quickfinder-item-text" '.$ct_description_text_color.'>', '</div>'); ?>
				<?php echo $ct_button; ?>
			</div>
		</div>
		<?php if($params['icon_position'] == 'bottom' || ($params['icon_position'] != 'top' && $params['alignment'] == 'right')) : ?>
			<div class="quickfinder-item-image">
					<div class="quickfinder-item-image-content<?php if($params['effects_enabled']): ?> lazy-loading-item<?php endif; ?>" <?php if($params['effects_enabled']): ?>data-ll-item-delay="0" data-ll-effect="clip"<?php endif; ?>>
						<?php if($ct_item_data['icon']) : ?>
							<div class="quickfinder-item-image-wrapper">
								<?php echo do_shortcode($ct_icon_shortcode); ?>
							</div>
						<?php else : ?>
							<div class="quickfinder-item-image-wrapper quickfinder-item-picture quickfinder-item-image-shape-<?php echo $ct_item_data['icon_shape'] ?>">
								<?php ct_post_thumbnail('ct-person', true, ' quickfinder-img-size-'.$ct_item_data['icon_size']); ?>
							</div>
						<?php endif; ?>
					</div>
			</div>
		<?php endif; ?>
	</div>
	<?php if($params['icon_position'] == 'top-float' || $params['icon_position'] == 'center-float') : ?></div><?php endif; ?>
	<?php if($ct_item_data['link']) : ?>
		<a href="<?php echo esc_url($ct_item_data['link']); ?>" target="<?php echo esc_attr($ct_item_data['link_target']); ?>" class="quickfinder-item-link"></a>
	<?php endif; ?>
</div>
