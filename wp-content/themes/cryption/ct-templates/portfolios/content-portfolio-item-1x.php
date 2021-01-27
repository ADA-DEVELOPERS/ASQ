<?php

$cryption_classes = array('portfolio-item');
$cryption_classes = array_merge($cryption_classes, $slugs);

$cryption_image_classes = array('image');
$cryption_caption_classes = array('caption');

if($params['caption_position'] == 'zigzag') {
	$cryption_caption_position = $eo_marker ? 'left' : 'right';
} else {
	$cryption_caption_position = $params['caption_position'];
}

$cryption_portfolio_item_data = ct_get_sanitize_pf_item_data(get_the_ID());
$cryption_title_data = cryption_get_sanitize_page_title_data(get_the_ID());

if (empty($cryption_portfolio_item_data['types']))
	$cryption_portfolio_item_data['types'] = array();

$cryption_classes = array_merge($cryption_classes, array('col-xs-12'));

if($params['display_titles'] == 'page' && $params['hover'] != 'gradient' && $params['hover'] != 'circular') {
	if($params['layout_version'] == 'fullwidth') {
		$cryption_image_classes = array_merge($cryption_image_classes, array('col-md-8', 'col-xs-12'));
		$cryption_caption_classes = array_merge($cryption_caption_classes, array('col-md-4', 'col-xs-12'));
		if($cryption_caption_position == 'left') {
			$cryption_image_classes = array_merge($cryption_image_classes, array('col-md-push-4'));
			$cryption_caption_classes = array_merge($cryption_caption_classes, array('col-md-pull-8'));
		}
	} else {
		$cryption_image_classes = array_merge($cryption_image_classes, array('col-md-7', 'col-xs-12'));
		$cryption_caption_classes = array_merge($cryption_caption_classes, array('col-md-5', 'col-xs-12'));
		if($cryption_caption_position == 'left') {
			$cryption_image_classes = array_merge($cryption_image_classes, array('col-md-push-5'));
			$cryption_caption_classes = array_merge($cryption_caption_classes, array('col-md-pull-7'));
		}
	}
}

$cryption_size = 'ct-portfolio-1x';
if($params['display_titles'] == 'hover' || $params['hover'] == 'gradient' || $params['hover'] == 'circular') {
	$cryption_size .= '-hover';
} else {
	$cryption_size .= $params['layout_version'] == 'sidebar' ? '-sidebar' : '';
}

$cryption_small_image_url = cryption_generate_thumbnail_src(get_post_thumbnail_id(), $cryption_size);
$cryption_large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
$cryption_self_video = '';

$cryption_bottom_line = false;
$cryption_portfolio_button_link = '';
if($cryption_portfolio_item_data['project_link'] || !$params['disable_socials']) {
	$cryption_bottom_line = true;
}

$cryption_classes[] = 'item-animations-not-inited';

?>

<div <?php post_class($cryption_classes); ?> style="padding: <?php echo intval($gap_size); ?>px;" data-sort-date="<?php echo get_the_date('Y-m-d'); ?>">
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
							$cryption_bottom_line = true;
							$cryption_portfolio_button_link = $cryption_link;
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
										$cryption_bottom_line = true;
										$cryption_portfolio_button_link = $cryption_link;
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
						<?php if($params['display_titles'] == 'hover' || $params['hover'] == 'gradient' || $params['hover'] == 'circular'): ?>
							<div class="caption">
								<div class="title title-h4">
									<?php if($params['hover'] != 'default' && $params['hover'] != 'gradient' && $params['hover'] != 'circular') { echo '<span class="light">'; } ?>
									<?php if(!empty($cryption_portfolio_item_data['overview_title'])) : ?>
										<?php echo esc_html($cryption_portfolio_item_data['overview_title']); ?>
									<?php else : ?>
										<?php the_title(); ?>
									<?php endif; ?>
									<?php if($params['hover'] != 'default') { echo '</span>'; } ?>
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
												<?php echo get_the_date('j F, Y'); ?> <?php if(count($slugs) > 0) { echo esc_html_x('in', 'in categories', 'cryption'); } ?>&nbsp;
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
		<?php if($params['display_titles'] == 'page' && $params['hover'] != 'gradient' && $params['hover'] != 'circular'): ?>
			<div <?php post_class($cryption_caption_classes); ?>>
				<div class="caption-sizable-content<?php echo ($cryption_bottom_line ? ' with-bottom-line' : ''); ?>">
					<div class="title title-h3"><span>
						<?php if(!empty($cryption_portfolio_item_data['overview_title'])) : ?>
							<?php echo esc_html($cryption_portfolio_item_data['overview_title']); ?>
						<?php else : ?>
							<?php the_title(); ?>
						<?php endif; ?>
					</span></div>
					<?php if($params['show_info']): ?>
						<div class="info clearfix">
							<div class="caption-separator-line"><?php echo get_the_date('j F, Y'); ?></div><!--
							<?php if($params['likes'] && $params['likes'] != 'false' && function_exists('zilla_likes') ) { echo '--><div class="caption-separator-line-hover"> <span class="sep"></span> <span class="post-meta-likes">';zilla_likes();echo '</span></div><!--'; } ?>
						--></div>
					<?php endif; ?>
					<?php if(has_excerpt()) : ?>
						<div class="subtitle"><?php the_excerpt(); ?></div>
					<?php elseif($cryption_title_data['title_excerpt']) : ?>
						<div class="subtitle"><?php echo nl2br($cryption_page_data['title_excerpt']); ?></div>
					<?php endif; ?>
					<?php if($params['show_info']): ?>
						<div class="info">
							<?php
								if(count($slugs) > 0) { echo esc_html_x('in', 'in categories', 'cryption'); }
								$cryption_index = 0;
								foreach ($slugs as $cryption_k => $cryption_slug) {
									if (isset($ct_terms_set[$cryption_slug])) {
										echo ($cryption_index > 0 ? '<span class="portfolio-set-comma">,</span> ': '').' <a data-slug="'.$ct_terms_set[$cryption_slug]->slug.'">'.$ct_terms_set[$cryption_slug]->name.'</a>';
										$cryption_index++;
									}
								}
								?>
						</div>
					<?php endif; ?>
				</div>
				<div class="caption-bottom-line">
					<?php if($cryption_portfolio_item_data['project_link']) { cryption_button(array('size' => 'tiny', 'href' => $cryption_portfolio_item_data['project_link'] , 'text' => ($cryption_portfolio_item_data['project_text'] ? $cryption_portfolio_item_data['project_text'] : __('Launch', 'cryption')), 'extra_class' => 'project-button'), 1); } ?>
					<?php if($cryption_portfolio_button_link) { cryption_button(array('text' => __('Details', 'cryption'), 'href' => get_permalink()), 1); } ?>
					<?php if(!$params['disable_socials']): ?>
						<div class="post-footer-sharing"><?php cryption_button(array('icon' => 'share', 'size' => 'tiny'), 1); ?><div class="sharing-popup"><?php do_action('ct_sharing_block'); ?><svg class="sharing-styled-arrow"><use xlink:href="<?php echo esc_url(get_template_directory_uri() . '/css/post-arrow.svg'); ?>#dec-post-arrow"></use></svg></div></div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
