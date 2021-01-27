<?php
/**
 * The template used for displaying page content on home page
 */

	$cryption_page_data = array(
		'title' => cryption_get_sanitize_page_title_data(get_the_ID()),
		'effects' => cryption_get_sanitize_page_effects_data(get_the_ID()),
		'slideshow' => cryption_get_sanitize_page_slideshow_data(get_the_ID()),
		'sidebar' => cryption_get_sanitize_page_sidebar_data(get_the_ID())
	);
	$cryption_no_margins_block = '';
	if($cryption_page_data['effects']['effects_no_bottom_margin']) {
		$cryption_no_margins_block .= ' no-bottom-margin';
	}
	if($cryption_page_data['effects']['effects_no_top_margin']) {
		$cryption_no_margins_block .= ' no-top-margin';
	}

	$cryption_panel_classes = array('panel', 'row');
	$cryption_center_classes = 'panel-center';
	$cryption_sidebar_classes = '';
	if(is_active_sidebar('page-sidebar') && $cryption_page_data['sidebar']['sidebar_position']) {
		$cryption_panel_classes[] = 'panel-sidebar-position-'.$cryption_page_data['sidebar']['sidebar_position'];
		$cryption_panel_classes[] = 'with-sidebar';
		$cryption_center_classes .= ' col-lg-9 col-md-9 col-sm-12';
		if($cryption_page_data['sidebar']['sidebar_position'] == 'left') {
			$cryption_center_classes .= ' col-md-push-3 col-sm-push-0';
			$cryption_sidebar_classes .= ' col-md-pull-9 col-sm-pull-0';
		}
	} else {
		$cryption_center_classes .= ' col-xs-12';
	}
	if($cryption_page_data['sidebar']['sidebar_sticky']) {
		$cryption_panel_classes[] = 'panel-sidebar-sticky';
	}
	$cryption_pf_data = array();
	if(get_post_type() == 'ct_pf_item') {
		$cryption_pf_data = ct_get_sanitize_pf_item_data(get_the_ID());
	}
	if(function_exists('ct_slideshow_block') && $cryption_page_data['slideshow']['slideshow_type']) {
		ct_slideshow_block(array('slideshow_type' => $cryption_page_data['slideshow']['slideshow_type'], 'slideshow' => $cryption_page_data['slideshow']['slideshow_slideshow'], 'slider' => $cryption_page_data['slideshow']['slideshow_layerslider'], 'slider' => $cryption_page_data['slideshow']['slideshow_revslider']));
	}
	echo cryption_page_title();
?>

<div class="block-content<?php echo esc_attr($cryption_no_margins_block); ?>">
	<div class="container<?php if(get_post_type() == 'ct_pf_item' && $cryption_pf_data['fullwidth']) { echo '-fullwidth'; } ?>">
		<div class="<?php echo esc_attr(implode(' ', $cryption_panel_classes)); ?>">

			<div class="<?php echo esc_attr($cryption_center_classes); ?>">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry-content post-content clearfix">
						<?php
							if((get_post_type() == 'post' || get_post_type() == 'ct_news') && $cryption_featured_content = cryption_get_post_featured_content(get_the_ID(), 'ct-blog-default', true)) {
								echo '<div class="blog-post-image centered-box">';
								echo $cryption_featured_content;
								echo '</div>';
							}
						?>
						<?php if(get_post_type() == 'post'):
							$cryption_categories = get_the_category();
							$cryption_categories_list = array();
							foreach($cryption_categories as $cryption_category) {
								$cryption_categories_list[] = '<a href="'.esc_url(get_category_link( $cryption_category->term_id )).'" title="'.esc_attr( sprintf( esc_html__( "View all posts in %s", "cryption" ), $cryption_category->name ) ).'">'.$cryption_category->cat_name.'</a>';
							}
						?>
							<div class="post-meta date-color">
								<div class="entry-meta single-post-meta clearfix ct-post-date">
									<div class="post-meta-right">
										<?php if(comments_open()): ?>
											<span class="comments-link"><?php comments_popup_link(0, 1, '%'); ?></span>
										<?php endif; ?>
										<?php if(comments_open() && function_exists('zilla_likes')): ?><span class="sep"></span><?php endif; ?>
										<?php if( function_exists('zilla_likes') ) { echo '<span class="post-meta-likes">';zilla_likes();echo '</span>'; } ?>
										<span class="post-meta-navigation">
											<?php previous_post_link('<span class="post-meta-navigation-prev" title="'.esc_attr__('Previous post', 'cryption').'">%link</span>', '&#xe636;'); ?>
											<?php if(!empty($cryption_categories[0])) : ?><span class="post-meta-category-link"><a href="<?php echo esc_url(get_category_link($cryption_categories[0]->term_id)); ?>">&#xe620;</a></span><?php endif; ?>
											<?php next_post_link('<span class="post-meta-navigation-next" title="'.esc_attr__('Next post', 'cryption').'">%link</span>', '&#xe634;'); ?>
										</span>
									</div>
									<div class="post-meta-left">
										<span class="post-meta-date"><?php the_date(); ?></span>
										<span class="post-meta-author">
											<span><?php printf( esc_html__( 'By', 'cryption' ));?></span>
											<span class="post-meta-author-link"><?php echo get_the_author_link(); ?></span>
										</span>
									</div>
								</div><!-- .entry-meta -->
							</div>
						<?php endif ?>

						<?php
							the_content();
							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'cryption' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
							) );
						?>
					</div><!-- .entry-content -->

					<?php if (get_post_type() == 'post') {
						echo get_the_tag_list('<div class="post-tags-list date-color">', '', '</div>');
						do_action('ct_sharing_block');
					} ?>

					<?php if (get_post_type() == 'post') { cryption_author_info(get_the_ID(), true); } ?>

					<?php if (get_post_type() == 'post') { cryption_related_posts(); } ?>

					<?php
						if ( comments_open() || get_comments_number() ) {
						comments_template();
						}
					?>

				</article><!-- #post-## -->

			</div>

			<?php
				if(is_active_sidebar('page-sidebar') && $cryption_page_data['sidebar']['sidebar_position']) {
					echo '<div class="sidebar col-lg-3 col-md-3 col-sm-12'.esc_attr($cryption_sidebar_classes).'" role="complementary">';
					get_sidebar('page');
					echo '</div><!-- .sidebar -->';
				}
			?>

		</div>

	</div>
</div><!-- .block-content -->