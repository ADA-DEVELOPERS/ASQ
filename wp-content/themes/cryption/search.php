<?php

$cryption_panel_classes = array('panel', 'row');
$cryption_center_classes = 'panel-center col-xs-12';

get_header(); ?>

<div id="main-content" class="main-content">

<?php echo cryption_page_title(); ?>

	<div class="block-content">
		<div class="container">
			<div class="<?php echo esc_attr(implode(' ', $cryption_panel_classes)); ?>">
				<div class="<?php echo esc_attr($cryption_center_classes); ?>">
				<?php
					if ( have_posts() ) {

						if(!is_singular()) {
							$blog_style = '3x';
							$params = array(
								'hide_author' => false,
								'hide_date' => true,
								'hide_comments' => true,
								'hide_likes' => true,
								'color_style' => 'style-1'
							);
							wp_enqueue_style('ct-blog');
							wp_enqueue_style('ct-additional-blog');
							wp_enqueue_style('ct-blog-timeline-new');
							wp_enqueue_style('ct-animations');
							wp_enqueue_script('imagesloaded');
							wp_enqueue_script('isotope-js');
							wp_enqueue_script('ct-items-animations');
							wp_enqueue_script('ct-blog');
							wp_enqueue_script('ct-gallery');
							wp_enqueue_script('ct-scroll-monitor');
							echo '<div class="preloader"><div class="preloader-spin"></div></div>';
							echo '<div class="blog blog-style-3x blog-style-masonry">';
						}

						while ( have_posts() ) : the_post();

							include(locate_template(array('ct-templates/blog/content-blog-item-masonry.php', 'content-blog-item.php')));

						endwhile;

						if(!is_singular()) { echo '</div>'; cryption_pagination(); }

					} else {
						get_template_part( 'content', 'none' );
					}
				?>
				</div>
			</div>
		</div><!-- .container -->
	</div><!-- .block-content -->
</div><!-- #main-content -->

<?php
get_footer();
