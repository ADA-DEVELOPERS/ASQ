<?php

$cryption_classes = array('portfolio-item');
$cryption_classes = array_merge($cryption_classes, $slugs);

$cryption_image_classes = array('image');
$cryption_caption_classes = array('caption', 'bordered-box', 'shadow-box');

$cryption_portfolio_item_data = get_post_meta(get_the_ID(), 'ct_portfolio_item_data', 1);
$cryption_sizes = cryption_image_sizes();

if (empty($cryption_portfolio_item_data['types']))
	$cryption_portfolio_item_data['types'] = array();

if ($params['style'] != 'metro') {
	if ($params['layout'] == '3x') {

		if (isset($cryption_portfolio_item_data['highlight']) && $cryption_portfolio_item_data['highlight'] && empty($params['is_slider']))
			$cryption_classes = array_merge($cryption_classes, array('col-md-8', 'col-xs-12'));
		else
			$cryption_classes = array_merge($cryption_classes, array('col-md-4', 'col-xs-6'));
	}
}
	if ($params['fullwidth_columns'] == '3') {
		$cryption_size = 'ct-portfolio-carusel-full-3x';
	}
	if ($params['fullwidth_columns'] == '4') {
		$cryption_size = 'ct-portfolio-carusel-4x';
	}
	if ($params['fullwidth_columns'] == '5') {
		$cryption_size = 'ct-portfolio-carusel-5x';
	}
	if ($params['layout'] == '3x') {
		$cryption_size = 'ct-portfolio-carusel-3x';
	}





if (isset($cryption_portfolio_item_data['highlight']) && $cryption_portfolio_item_data['highlight'] && empty($params['is_slider']))
	$cryption_classes[] = 'double-item';



if ($params['effects_enabled'])
	$cryption_classes[] = 'lazy-loading-item';

$cryption_small_image_url = cryption_generate_thumbnail_src(get_post_thumbnail_id(), $cryption_size);
$cryption_large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
$cryption_self_video = '';

?>


<div style="padding: <?php echo intval($gap_size); ?>px;" <?php post_class($cryption_classes); ?> <?php if($params['effects_enabled']): ?>data-ll-effect="move-up"<?php endif; ?> data-sort-date="<?php echo get_the_date('U'); ?>">
	<div class="wrap clearfix">
		<div <?php post_class($cryption_image_classes); ?>>
			<div class="image-inner">
				<img src="<?php echo esc_url($cryption_small_image_url[0]); ?>" width="<?php echo esc_attr($cryption_small_image_url[1]); ?>" height="<?php echo esc_attr($cryption_small_image_url[2]); ?>" alt="<?php the_title(); ?>" />
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
                                    <?php the_excerpt(); ?>
								</div>
								<div class="description">
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
