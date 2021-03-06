<?php

	$ct_post_data = ct_get_sanitize_page_title_data(get_the_ID());

	$ct_categories = get_the_category();
	$ct_categories_list = array();
	foreach($ct_categories as $ct_category) {
		$ct_categories_list[] = '<a href="'.esc_url(get_category_link( $ct_category->term_id )).'" title="'.esc_attr( sprintf( __( "View all posts in %s", "cryption" ), $ct_category->name ) ).'">'.$ct_category->cat_name.'</a>';
	}

	$ct_classes = array();

	if(is_sticky() && !is_paged()) {
		$ct_classes = array_merge($ct_classes, array('sticky', 'default-background'));
	}

	$ct_link = get_permalink();
	if (!has_post_thumbnail())
		$ct_classes[] = 'no-image';

	$ct_classes[] = 'item-animations-not-inited';
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class($ct_classes); ?>>
		<div class="item-post-container">
			<div class="post-item clearfix">
				<?php
					if(!is_single() && is_sticky()) {
						echo '<div class="sticky-label">&#xe61a;</div>';
					}
				?>
				<div class="post-info-wrap">
					<div class="post-info">
						<?php if(has_post_thumbnail()): ?>
							<div class="post-img">
								<a href="<?php echo esc_url($ct_link); ?>" class="default"><?php ct_post_thumbnail('ct-post-thumb', true, 'img-responsive'); ?></a>
							</div>
						<?php else: ?>
							<div class="post-img">
								<a href="<?php echo esc_url($ct_link); ?>" class="default"><span class="dummy">&#xe640</span></a>
							</div>
						<?php endif; ?>
						<div class="post-date"><?php echo get_the_date('d F') ?></div>
						<div class="post-time"><?php echo get_the_date('H:i') ?></div>
					</div>
				</div>
				<svg class="wrap-style">
					<use xlink:href="<?php echo esc_url(get_template_directory_uri() . '/css/post-arrow.svg'); ?>#dec-post-arrow"></use>
				</svg>
				<div class="post-text-wrap">
					<div class="post-title">
						<?php the_title('<'.(is_sticky() && !is_paged() ? 'h2' : 'h3').' class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark"><span class="light">', '</span></a></'.(is_sticky() && !is_paged() ? 'h2' : 'h3').'>'); ?>
					</div>
					<div class="post-content">
						<div class="summary">
							<?php if ( !empty( $ct_post_data['title_excerpt'] ) ): ?>
								<?php echo $ct_post_data['title_excerpt']; ?>
							<?php else: ?>
								<?php echo preg_replace('%&#x[a-fA-F0-9]+;%', '', apply_filters('the_excerpt', get_the_excerpt())); ?>
							<?php endif; ?>
						</div>
					</div>
					<div class="post-misc">
						<div class="post-author">
							<span class="post-meta-author"><?php printf( esc_html__( "By %s", "cryption" ), get_the_author_link() ); echo esc_html__( " in", "cryption" ); ?></span>
							<?php if($ct_categories): ?>
								<span class="post-meta-categories"><?php echo implode('<span class="sep"></span>', $ct_categories_list); ?></span>
							<?php endif ?>
						</div>
						<div class="post-soc-info">
							<span class="post-comments">
								<?php if(comments_open()): ?>
									<span class="comments-link"><?php comments_popup_link(0, 1, '%'); ?></span>
								<?php endif; ?>
								<?php if(comments_open() && function_exists('zilla_likes')): ?><span class="sep"></span><?php endif; ?>
							</span>
							<span class="post-likes">
								<?php if( function_exists('zilla_likes') ) { echo '<span class="post-meta-likes">';zilla_likes();echo '</span>'; } ?>
							</span>
						</div>
						<div class="post-links">
							<div class="post-footer-sharing"><?php ct_button(array('icon' => 'share', 'size' => (is_sticky() && !is_paged() ? '' : 'tiny')), 1); ?><div class="sharing-popup"><?php ct_socials_sharing(); ?><svg class="sharing-styled-arrow"><use xlink:href="<?php echo esc_url(get_template_directory_uri() . '/css/post-arrow.svg'); ?>#dec-post-arrow"></use></svg></div></div>
							<div class="post-read-more"><?php ct_button(array('href' => get_the_permalink(), 'style' => 'outline', 'text' => __('Read More', 'cryption'), 'size' => (is_sticky() && !is_paged() ? '' : 'tiny')), 1); ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</article><!-- #post-<?php the_ID(); ?> -->
