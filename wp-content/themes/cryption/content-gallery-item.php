<?php
	$cryption_item = get_post($attachment_id);

	if (!$cryption_item) {
		return;
	}

	$cryption_highlight = (bool) get_post_meta($cryption_item->ID, 'highlight', true);
	$cryption_highligh_type = get_post_meta($cryption_item->ID, 'highligh_type', true);
	if (!$cryption_highligh_type) {
		$cryption_highligh_type = 'squared';
	}
	$cryption_attachment_link = get_post_meta($cryption_item->ID, 'attachment_link', true);
	$cryption_single_icon = true;

	if (!empty($cryption_attachment_link)) {
		$cryption_single_icon = false;
	}

	if ($params['type'] == 'grid') {
		$cryption_size = 'ct-gallery-justified';
		if ($cryption_highlight) {
			$cryption_size = 'ct-gallery-justified-double';
			if ($params['layout'] == '4x')
				$cryption_size = 'ct-gallery-justified-double-4x';
		}
		if ($params['layout'] == '2x') {
			$cryption_size = 'ct-gallery-justified-double';
		}
		if ($params['style'] == 'masonry')
			if ($cryption_highlight)
				$cryption_size = 'ct-gallery-masonry-double';
			else
				$cryption_size = 'ct-gallery-masonry';

		if ($params['layout'] == '100%')
			$cryption_size .= '-100';

		if ($params['style'] == 'metro')
			$cryption_size = 'ct-gallery-metro';

		if ($cryption_highlight && $params['style'] != 'metro' && $cryption_highligh_type != 'squared') {
			$cryption_size .= '-' . $cryption_highligh_type;
		}
	} else {
		$cryption_size = 'ct-container';
		$cryption_thumb_image_url = wp_get_attachment_image_src($cryption_item->ID, 'ct-post-thumb');
	}

	$cryption_small_image_url = cryption_generate_thumbnail_src($cryption_item->ID, $cryption_size);
	$cryption_full_image_url = wp_get_attachment_image_src($cryption_item->ID, 'full');

	$cryption_classes = array('gallery-item');

	if ($params['type'] == 'grid' && $params['style'] != 'metro' && $params['layout'] == '2x') {
	  $cryption_classes = array_merge($cryption_classes, array('col-lg-6', 'col-md-6', 'col-sm-6', 'col-xs-12'));
	}

	if ($params['type'] == 'grid' && $params['style'] != 'metro' && $params['layout'] == '3x') {
		if ($cryption_highlight && $cryption_highligh_type != 'vertical')
			$cryption_classes = array_merge($cryption_classes, array('col-lg-8', 'col-md-8', 'col-sm-12', 'col-xs-12'));
		else
			$cryption_classes = array_merge($cryption_classes, array('col-lg-4', 'col-md-4', 'col-sm-6', 'col-xs-6'));
	}

	if ($params['type'] == 'grid' && $params['style'] != 'metro' && $params['layout'] == '4x') {
		if ($cryption_highlight && $cryption_highligh_type != 'vertical')
			$cryption_classes = array_merge($cryption_classes, array('col-lg-6', 'col-md-6', 'col-sm-8', 'col-xs-12'));
		else
			$cryption_classes = array_merge($cryption_classes, array('col-lg-3', 'col-md-3', 'col-sm-4', 'col-xs-6'));
	}

	if ($params['type'] == 'grid' && $params['style'] != 'metro' && $cryption_highlight)
		$cryption_classes[] = 'double-item';

	if ($params['type'] == 'grid' && $params['style'] != 'metro' && $cryption_highlight && $cryption_highligh_type != 'squared') {
		$cryption_classes[] = 'double-item-' . $cryption_highligh_type;
	}

	$cryption_wrap_classes = $params['item_style'];

	if ($params['type'] == 'grid')
		$cryption_classes[] = 'item-animations-not-inited';

	$cryption_sources = array();

	if ($params['type'] == 'grid') {
		if ($params['style'] == 'metro') {
			$cryption_sources = array(
				array('media' => '(min-width: 550px) and (max-width: 1100px)', 'srcset' => array('1x' => 'ct-gallery-metro-medium', '2x' => 'ct-gallery-metro-retina'))
			);
		}

		if (!$cryption_highlight) {
			$retina_size = $params['style'] == 'justified' ? $cryption_size : 'ct-gallery-masonry-double';

			if ($params['layout'] == '100%') {
				if ($params['style'] == 'justified' || $params['style'] == 'masonry') {
					switch ($params['fullwidth_columns']) {
						case '4':
							$cryption_sources = array(
								array('media' => '(max-width: 550px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-2x-500', '2x' => $retina_size)),
								array('media' => '(max-width: 992px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-fullwidth-5x', '2x' => $retina_size)),
								array('media' => '(max-width: 1032px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-4x-small', '2x' => $retina_size)),
								array('media' => '(max-width: 1180px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-4x', '2x' => $retina_size)),
								array('media' => '(max-width: 1280px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-5x', '2x' => $retina_size)),
								array('media' => '(max-width: 1495px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-fullwidth-5x', '2x' => $retina_size)),
								array('media' => '(max-width: 1575px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-3x', '2x' => $retina_size)),
								array('media' => '(max-width: 1920px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-fullwidth-4x', '2x' => $retina_size)),
							);
							break;

						case '5':
							$cryption_sources = array(
								array('media' => '(max-width: 550px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-2x-500', '2x' => $retina_size)),
								array('media' => '(min-width: 992px) and (max-width: 1175px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-4x', '2x' => $retina_size)),
								array('media' => '(min-width: 1495px) and (max-width: 1680px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-fullwidth-4x', '2x' => $retina_size)),
								array('media' => '(max-width: 1920px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-fullwidth-5x', '2x' => $retina_size))
							);
							break;
					}
				}
			} else {
				if ($params['style'] == 'justified' || $params['style'] == 'masonry') {
					switch ($params['layout']) {
						case '2x':
							$cryption_sources = array(
								array('media' => '(max-width: 550px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-2x-500', '2x' => $retina_size)),
								array('media' => '(max-width: 1920px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-2x', '2x' => $retina_size))
							);
							break;

						case '3x':
							$cryption_sources = array(
								array('media' => '(max-width: 550px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-2x-500', '2x' => $retina_size)),
								array('media' => '(max-width: 1920px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-3x', '2x' => $retina_size))
							);
							break;

						case '4x':
							$cryption_sources = array(
								array('media' => '(max-width: 550px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-2x-500', '2x' => $retina_size)),
								array('media' => '(max-width: 1100px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-3x', '2x' => $retina_size)),
								array('media' => '(max-width: 1920px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-4x', '2x' => $retina_size))
							);
							break;
					}
				}
			}
		} else {
			$retina_size = $cryption_size;
			if ($params['layout'] == '100%') {
				if ($params['style'] == 'justified' || $params['style'] == 'masonry') {
					switch ($params['fullwidth_columns']) {
						case '4':
							$cryption_sources = array(
								array('media' => '(max-width: 700px),(min-width: 825px) and (max-width: 992px),(min-width: 1095px) and (max-width: 1495px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-double-100-' . $cryption_highligh_type . '-5', '2x' => $retina_size)),
								array('media' => '(min-width: 700px) and (max-width: 825px),(min-width: 992px) and (max-width: 1095px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-double-100-' . $cryption_highligh_type . '-6', '2x' => $retina_size)),
								array('media' => '(max-width: 1920px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-double-100-' . $cryption_highligh_type . '-4', '2x' => $retina_size))
							);
							break;

						case '5':
							$cryption_sources = array(
								array('media' => '(max-width: 700px),(min-width: 825px) and (max-width: 992px),(min-width: 1095px) and (max-width: 1495px),(max-width: 1920px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-double-100-' . $cryption_highligh_type . '-5', '2x' => $retina_size)),
								array('media' => '(min-width: 700px) and (max-width: 825px),(min-width: 992px) and (max-width: 1095px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-double-100-' . $cryption_highligh_type . '-6', '2x' => $retina_size)),
								array('media' => '(max-width: 1680px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-double-100-' . $cryption_highligh_type . '-4', '2x' => $retina_size)),
							);
							break;
					}
				}
			} else {
				if ($params['style'] == 'justified' || $params['style'] == 'masonry') {
					switch ($params['layout']) {
						case '2x':
							$cryption_sources = array(
								array('media' => '(max-width: 550px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-2x-500', '2x' => $retina_size)),
								array('media' => '(max-width: 1920px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-2x', '2x' => $retina_size))
							);
							break;

						case '4x':
							$cryption_sources = array(
								array('media' => '(max-width: 550px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-double-4x', '2x' => $retina_size)),
								array('media' => '(max-width: 1920px)', 'srcset' => array('1x' => 'ct-gallery-' . $params['style'] . '-double-4x-' . $cryption_highligh_type, '2x' => $retina_size))
							);
							break;
					}
				}
			}
		}
	}


?>





<li
	<?php if ($params['gaps_size']): ?>style="padding: <?php echo($params['gaps_size'] / 2);?>px"<?php endif;?>

	<?php post_class($cryption_classes); ?>>
	<div class="wrap <?php if($params['type'] == 'grid' && $params['item_style'] != ''): ?> ct-wrapbox-style-<?php echo esc_attr($cryption_wrap_classes); ?><?php endif; ?>">
		<?php if($params['type'] == 'grid' && $params['item_style'] == '11'): ?>
			<div class="ct-wrapbox-inner"><div class="shadow-wrap">
		<?php endif; ?>
		<div class="overlay-wrap">
			<div class="image-wrap <?php if($params['type'] == 'grid' && $params['item_style'] == '11'): ?>img-circle<?php endif; ?>">
				<?php
					$cryption_attrs = array('alt' => get_post_meta($cryption_item->ID, '_wp_attachment_image_alt', true));
					if ($params['type'] == 'slider') {
						$cryption_attrs['data-thumb-url'] = esc_url($cryption_thumb_image_url[0]);
					}
					cryption_generate_picture($cryption_item->ID, $cryption_size, $cryption_sources, $cryption_attrs);
				?>
			</div>
			<div class="overlay <?php if($params['type'] == 'grid' && $params['item_style'] == '11'): ?>img-circle<?php endif; ?>">
				<div class="overlay-circle"></div>
				<?php if($cryption_single_icon): ?>
					<a href="<?php echo esc_url($cryption_full_image_url[0]); ?>" class="gallery-item-link fancy-gallery" data-fancybox-group="gallery-<?php echo esc_attr($gallery_uid); ?>">
						<span class="slide-info">
							<?php if(!empty($cryption_item->post_excerpt)) : ?>
								<span class="slide-info-title">
									<?php echo wp_kses_post($cryption_item->post_excerpt); ?>
								</span>
								<?php if(!empty($cryption_item->post_content)) : ?>
									<span class="slide-info-summary">
										<?php echo wp_kses_post($cryption_item->post_content); ?>
									</span>
								<?php endif; ?>
							<?php endif; ?>
						</span>
					</a>
				<?php endif; ?>
				<div class="overlay-content">
					<div class="overlay-content-center">
						<div class="overlay-content-inner">
							<a href="<?php echo esc_url($cryption_full_image_url[0]); ?>" class="icon photo <?php if(!$cryption_single_icon): ?>fancy-gallery<?php endif; ?>" <?php if(!$cryption_single_icon): ?>data-fancybox-group="gallery-<?php echo esc_attr($gallery_uid); ?>"<?php endif; ?> >

								<?php if(!$cryption_single_icon): ?>
									<span class="slide-info">
										<?php if(!empty($cryption_item->post_excerpt)) : ?>
											<span class="slide-info-title ">
												<?php echo wp_kses_post($cryption_item->post_excerpt); ?>
											</span>
											<?php if(!empty($cryption_item->post_content)) : ?>
												<span class="slide-info-summary">
													<?php echo wp_kses_post($cryption_item->post_content); ?>
												</span>
											<?php endif; ?>
										<?php endif; ?>
									</span>
								<?php endif; ?>
							</a>

							<?php if (!empty($cryption_attachment_link)): ?>
								<a href="<?php echo esc_url($cryption_attachment_link); ?>" target="_blank" class="icon link"></a>
							<?php endif; ?>
							<div class="overlay-line"></div>
							<?php if(!empty($cryption_item->post_excerpt)) : ?>
								<div class="title">
									<?php echo wp_kses_post($cryption_item->post_excerpt); ?>
								</div>
							<?php endif; ?>
							<?php if(!empty($cryption_item->post_content)) : ?>
								<div class="subtitle">
									<?php echo wp_kses_post($cryption_item->post_content); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php if($params['type'] == 'grid' && $params['item_style'] == '11'): ?>
			</div></div>
		<?php endif; ?>
	</div>
	<?php if ($params['style']  == 'metro' &&  $params['item_style']):?><?php endif;?>
</li>
