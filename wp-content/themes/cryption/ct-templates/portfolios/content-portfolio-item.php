<?php

$cryption_classes = array('portfolio-item');
$cryption_classes = array_merge($cryption_classes, $slugs);

$cryption_image_classes = array('image');
$cryption_caption_classes = array('caption', 'shadow-box', 'bordered-box');

$cryption_portfolio_item_data = get_post_meta(get_the_ID(), 'ct_portfolio_item_data', 1);

if (!empty($cryption_portfolio_item_data['highlight_type'])) {
	$cryption_highlight_type = $cryption_portfolio_item_data['highlight_type'];
} else {
	$cryption_highlight_type = 'squared';
}

if (empty($cryption_portfolio_item_data['types']))
	$cryption_portfolio_item_data['types'] = array();

if ($params['style'] != 'metro') {
	if ($params['layout'] == '1x') {
		$cryption_classes = array_merge($cryption_classes, array('col-xs-12'));
		$cryption_image_classes = array_merge($cryption_image_classes, array('col-sm-5', 'col-xs-12'));
		$cryption_caption_classes = array_merge($cryption_caption_classes, array('col-sm-7', 'col-xs-12'));
	}

	if ($params['layout'] == '2x') {
		if (isset($cryption_portfolio_item_data['highlight']) && $cryption_portfolio_item_data['highlight'] && empty($params['is_slider']) && $cryption_highlight_type != 'vertical')
			$cryption_classes = array_merge($cryption_classes, array('col-xs-12'));
		else
			$cryption_classes = array_merge($cryption_classes, array('col-sm-6', 'col-xs-12'));
	}

	if ($params['layout'] == '3x') {
		if (isset($cryption_portfolio_item_data['highlight']) && $cryption_portfolio_item_data['highlight'] && empty($params['is_slider']) && $cryption_highlight_type != 'vertical')
			$cryption_classes = array_merge($cryption_classes, array('col-md-8', 'col-xs-8'));
		else
			$cryption_classes = array_merge($cryption_classes, array('col-md-4', 'col-xs-4'));
	}

	if ($params['layout'] == '4x') {
		if (isset($cryption_portfolio_item_data['highlight']) && $cryption_portfolio_item_data['highlight'] && empty($params['is_slider']) && $cryption_highlight_type != 'vertical')
			$cryption_classes = array_merge($cryption_classes, array('col-md-6', 'col-sm-8', 'col-xs-8'));
		else
			$cryption_classes = array_merge($cryption_classes, array('col-md-3', 'col-sm-4', 'col-xs-4'));
	}
}

if (isset($cryption_portfolio_item_data['highlight']) && $cryption_portfolio_item_data['highlight'] && empty($params['is_slider']))
	$cryption_classes[] = 'double-item';

if (isset($cryption_portfolio_item_data['highlight']) && $cryption_portfolio_item_data['highlight'] && empty($params['is_slider']) && $cryption_highlight_type != 'squared') {
	$cryption_classes[] = 'double-item-' . $cryption_highlight_type;
}

$cryption_size = 'ct-portfolio-justified';
$cryption_sizes = cryption_image_sizes();
if ($params['layout'] != '1x') {
	if ($params['style'] == 'masonry') {
		$cryption_size = 'ct-portfolio-masonry';
		if (isset($cryption_portfolio_item_data['highlight']) && $cryption_portfolio_item_data['highlight'] && empty($params['is_slider']))
			$cryption_size = 'ct-portfolio-masonry-double';
	} elseif ($params['style'] == 'metro') {
		$cryption_size = 'ct-portfolio-metro';
	} else {
		if (isset($cryption_portfolio_item_data['highlight']) && $cryption_portfolio_item_data['highlight'] && empty($params['is_slider'])) {
			$cryption_size = 'ct-portfolio-double-' . str_replace('%', '',$params['layout']);

			if ( ($params['display_titles'] == 'hover' || $params['hover'] == 'gradient' || $params['hover'] == 'circular') && isset($cryption_sizes[$cryption_size.'-hover'])) {
				$cryption_size .= '-hover';
			}

			if(isset($cryption_sizes[$cryption_size.'-gap-'.$params['gaps_size']])) {
				$cryption_size .= '-gap-'.$params['gaps_size'];
			}

		}
	}

	if (isset($cryption_portfolio_item_data['highlight']) && $cryption_portfolio_item_data['highlight'] && $params['style'] != 'metro' && empty($params['is_slider']) && $cryption_highlight_type != 'squared') {
		$cryption_size .= '-' . $cryption_highlight_type;
	}
} else {
	$cryption_size = 'ct-portfolio-1x';
}

$cryption_classes[] = 'item-animations-not-inited';

$cryption_size = apply_filters('portfolio_size_filter', $cryption_size);

$cryption_large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
$cryption_self_video = '';

$cryption_sources = array();

if ($params['style'] == 'metro') {
	$cryption_sources = array(
		array('media' => '(min-width: 550px) and (max-width: 1100px)', 'srcset' => array('1x' => 'ct-portfolio-metro-medium', '2x' => 'ct-portfolio-metro-retina'))
	);
}

if (!isset($cryption_portfolio_item_data['highlight']) || !$cryption_portfolio_item_data['highlight'] || !empty($params['is_slider']) ||
		($params['style'] == 'masonry' && isset($cryption_portfolio_item_data['highlight']) && $cryption_portfolio_item_data['highlight']) && $cryption_highlight_type == 'vertical') {

	$retina_size = $params['style'] == 'justified' ? $cryption_size : 'ct-portfolio-masonry';

	if ($params['layout'] == '100%') {
		if ($params['style'] == 'justified' || $params['style'] == 'masonry') {
			switch ($params['fullwidth_columns']) {
				case '4':
					$cryption_sources = array(
						array('media' => '(max-width: 550px)', 'srcset' => array('1x' => 'ct-portfolio-' . $params['style'] . '-2x-500', '2x' => $retina_size)),
						array('media' => '(min-width: 1280px) and (max-width: 1495px)', 'srcset' => array('1x' => 'ct-portfolio-' . $params['style'] . '-fullwidth-5x', '2x' => $retina_size)),
						array('media' => '(max-width: 1920px)', 'srcset' => array('1x' => 'ct-portfolio-' . $params['style'] . '-fullwidth-4x', '2x' => $retina_size))
					);
					break;

				case '5':
					$cryption_sources = array(
						array('media' => '(max-width: 550px)', 'srcset' => array('1x' => 'ct-portfolio-' . $params['style'] . '-2x-500', '2x' => $retina_size)),
						array('media' => '(min-width: 1495px) and (max-width: 1680px), (min-width: 550px) and (max-width: 1280px)', 'srcset' => array('1x' => 'ct-portfolio-' . $params['style'] . '-fullwidth-4x', '2x' => $retina_size)),
						array('media' => '(min-width: 1680px) and (max-width: 1920px), (min-width: 1280px) and (max-width: 1495px)', 'srcset' => array('1x' => 'ct-portfolio-' . $params['style'] . '-fullwidth-5x', '2x' => $retina_size))
					);
					break;
			}
		}
	} else {
		if ($params['style'] == 'justified' || $params['style'] == 'masonry') {
			switch ($params['layout']) {
				case '2x':
					$cryption_sources = array(
						array('media' => '(max-width: 550px)', 'srcset' => array('1x' => 'ct-portfolio-' . $params['style'] . '-2x-500', '2x' => $retina_size)),
						array('media' => '(max-width: 1920px)', 'srcset' => array('1x' => 'ct-portfolio-' . $params['style'] . '-2x', '2x' => $retina_size))
					);
					break;

				case '3x':
					$cryption_sources = array(
						array('media' => '(max-width: 550px)', 'srcset' => array('1x' => 'ct-portfolio-' . $params['style'] . '-2x-500', '2x' => $retina_size)),
						array('media' => '(max-width: 1920px)', 'srcset' => array('1x' => 'ct-portfolio-' . $params['style'] . '-3x', '2x' => $retina_size))
					);
					break;

				case '4x':
					$cryption_sources = array(
						array('media' => '(max-width: 550px)', 'srcset' => array('1x' => 'ct-portfolio-' . $params['style'] . '-2x-500', '2x' => $retina_size)),
						array('media' => '(max-width: 1100px)', 'srcset' => array('1x' => 'ct-portfolio-' . $params['style'] . '-3x', '2x' => $retina_size)),
						array('media' => '(max-width: 1920px)', 'srcset' => array('1x' => 'ct-portfolio-' . $params['style'] . '-4x', '2x' => $retina_size))
					);
					break;
			}
		}
	}
}

?>

<div <?php post_class($cryption_classes); ?> style="padding: <?php echo intval($gap_size); ?>px;" data-default-sort="<?php echo intval(get_post()->menu_order); ?>" data-sort-date="<?php echo get_the_date('U'); ?>">
	<div class="wrap clearfix">
		<div <?php post_class($cryption_image_classes); ?>>
			<div class="image-inner">
				<?php cryption_post_picture($cryption_size, $cryption_sources, array('alt' => get_the_title())); ?>
			</div>
			<div class="overlay">
				<div class="overlay-circle"></div>
				<?php if (count($cryption_portfolio_item_data['types']) == 1 && $params['disable_socials']): ?>
					<?php
						$cryption_ptype = reset($cryption_portfolio_item_data['types']);
						if($cryption_ptype['type'] == 'full-image') {
							$cryption_link = $cryption_large_image_url[0];
						} elseif($cryption_ptype['type'] == 'self-link') {
							$cryption_link = get_permalink();
						} elseif($cryption_ptype['type'] == 'youtube') {
							$cryption_link = 'http://www.youtube.com/embed/'.$cryption_ptype['link'].'?autoplay=1';
						} elseif($cryption_ptype['type'] == 'vimeo') {
							$cryption_link = 'http://player.vimeo.com/video/'.$cryption_ptype['link'].'?autoplay=1';
						} else {
							$cryption_link = $cryption_ptype['link'];
						}
						if(!$cryption_link) {
							$cryption_link = '#';
						}
						if($cryption_ptype['type'] == 'self_video') {
							$cryption_self_video = $cryption_ptype['link'];
							wp_enqueue_style('wp-mediaelement');
							wp_enqueue_script('ct-mediaelement');
						}

					?>
					<a href="<?php echo esc_url($cryption_link); ?>" target="<?php echo esc_attr($cryption_ptype['link_target']); ?>" class="portolio-item-link <?php echo esc_attr($cryption_ptype['type']); ?> <?php if($cryption_ptype['type'] == 'full-image') echo 'fancy'; ?>"></a>
				<?php endif; ?>
				<div class="links-wrapper">
					<div class="links">
						<div class="portfolio-icons">
							<?php foreach($cryption_portfolio_item_data['types'] as $cryption_ptype): ?>
								<?php
									if($cryption_ptype['type'] == 'full-image') {
										$cryption_link = $cryption_large_image_url[0];
									} elseif($cryption_ptype['type'] == 'self-link') {
										$cryption_link = get_permalink();
									} elseif($cryption_ptype['type'] == 'youtube') {
										$cryption_link = 'http://www.youtube.com/embed/'.$cryption_ptype['link'].'?autoplay=1';
									} elseif($cryption_ptype['type'] == 'vimeo') {
										$cryption_link = 'http://player.vimeo.com/video/'.$cryption_ptype['link'].'?autoplay=1';
									} else {
										$cryption_link = $cryption_ptype['link'];
									}
									if(!$cryption_link) {
										$cryption_link = '#';
									}
									if($cryption_ptype['type'] == 'self_video') {
										$cryption_self_video = $cryption_ptype['link'];
										wp_enqueue_style('wp-mediaelement');
										wp_enqueue_script('ct-mediaelement');
									}
								?>
								<a href="<?php echo esc_url($cryption_link); ?>" target="<?php echo esc_attr($cryption_ptype['link_target']); ?>" class="icon <?php echo esc_attr($cryption_ptype['type']); ?> <?php if($cryption_ptype['type'] == 'full-image' && (count($cryption_portfolio_item_data['types']) > 1 || !$params['disable_socials'])) echo 'fancy'; ?>"></a>
							<?php endforeach; ?>
							<?php if(!$params['disable_socials']): ?>
								<a href="javascript: void(0);" class="icon share"></a>
							<?php endif; ?>

							<div class="overlay-line"></div>
							<?php if(!$params['disable_socials']): ?>
								<div class="portfolio-sharing-pane"><?php do_action('ct_sharing_block'); ?></div>
							<?php endif; ?>
						</div>
						<?php if( ($params['display_titles'] == 'hover' && $params['layout'] != '1x') || $params['hover'] == 'gradient' || $params['hover'] == 'circular'): ?>
							<div class="caption">
								<div class="title title-h4">
									<?php if(!empty($cryption_portfolio_item_data['overview_title'])) : ?>
										<?php echo esc_html($cryption_portfolio_item_data['overview_title']); ?>
									<?php else : ?>
										<?php the_title(); ?>
									<?php endif; ?>
								</div>
								<div class="description">
									<?php if(has_excerpt()) : ?><div class="subtitle"><?php the_excerpt(); ?></div><?php endif; ?>
									<?php if($params['show_info']): ?>
										<div class="info">
											<?php if($params['layout'] == '1x'): ?>
												<?php echo get_the_date('j F, Y'); ?>&nbsp;
												<?php
													foreach ($slugs as $cryption_k => $cryption_slug)
														if (isset($ct_terms_set[$cryption_slug]))
															echo '<a data-slug="'.$ct_terms_set[$cryption_slug]->slug.'">'.$ct_terms_set[$cryption_slug]->name.'</a>';
												?>
											<?php else: ?>
												<?php echo get_the_date('j F, Y'); ?> <?php if(count($slugs) > 0): ?>in<?php endif; ?>&nbsp;
												<?php
													$cryption_index = 0;
													foreach ($slugs as $cryption_k => $cryption_slug)
														if (isset($ct_terms_set[$cryption_slug])) {
															echo ($cryption_index > 0 ? '<span class="portfolio-set-comma">,</span> ': '').'<a data-slug="'.$ct_terms_set[$cryption_slug]->slug.'">'.$ct_terms_set[$cryption_slug]->name.'</a>';
															$cryption_index++;
														}
												?>
											<?php endif; ?>
										</div>
									<?php endif ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php if( ($params['display_titles'] == 'page' || $params['layout'] == '1x') && $params['hover'] != 'gradient' && $params['hover'] != 'circular'): ?>
			<div <?php post_class($cryption_caption_classes); ?>>
				<div class="title">
					<?php if(!empty($cryption_portfolio_item_data['overview_title'])) : ?>
						<?php echo esc_html($cryption_portfolio_item_data['overview_title']); ?>
					<?php else : ?>
						<?php the_title(); ?>
					<?php endif; ?>
				</div>
				<div class="caption-separator"></div>
				<?php if(has_excerpt()) : ?><div class="subtitle"><?php the_excerpt(); ?></div><?php endif; ?>
				<?php if($params['show_info']): ?>
					<div class="info">
						<?php if($params['layout'] == '1x'): ?>
							<?php echo get_the_date('j F, Y'); ?>&nbsp;
							<?php
								foreach ($slugs as $cryption_k => $cryption_slug)
									if (isset($ct_terms_set[$cryption_slug]))
										echo '<span class="separator">|</span><a data-slug="'.$ct_terms_set[$cryption_slug]->slug.'">'.$ct_terms_set[$cryption_slug]->name.'</a>';
							?>
						<?php else: ?>
							<?php echo get_the_date('j F, Y'); ?> <?php if(count($slugs) > 0): ?>in<?php endif; ?>&nbsp;
							<?php
								$cryption_index = 0;
								foreach ($slugs as $cryption_k => $cryption_slug)
									if (isset($ct_terms_set[$cryption_slug])) {
										echo ($cryption_index > 0 ? '<span class="sep"></span> ': '').'<a data-slug="'.$ct_terms_set[$cryption_slug]->slug.'">'.$ct_terms_set[$cryption_slug]->name.'</a>';
										$cryption_index++;
									}
							?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php if($params['likes'] && $params['likes'] != 'false' && function_exists('zilla_likes')) { echo '<div class="portfolio-likes'.($params['show_info'] ? '' : ' visible').'">';zilla_likes();echo '</div>'; } ?>
			</div>
		<?php endif; ?>
	</div>
</div>
