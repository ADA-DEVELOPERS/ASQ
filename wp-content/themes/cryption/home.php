<?php

get_header();

$cryption_panel_classes = array('panel', 'row');

if(is_active_sidebar('page-sidebar')) {
	$cryption_panel_classes[] = 'panel-sidebar-position-right';
	$cryption_panel_classes[] = 'with-sidebar';
	$cryption_center_classes = 'col-lg-9 col-md-9 col-sm-12';
} else {
	$cryption_center_classes = 'col-xs-12';
}

?>
<div id="main-content" class="main-content">

<?php

if(cryption_get_option('home_content_enabled')) :

	cryption_home_content_builder();

else :

	wp_enqueue_style('ct-blog');
	wp_enqueue_style('ct-additional-blog');
	wp_enqueue_style('ct-blog-timeline-new');
	wp_enqueue_script('ct-scroll-monitor');
	wp_enqueue_script('ct-items-animations');
	wp_enqueue_script('ct-blog');
	wp_enqueue_script('ct-gallery');

?>

	<div class="block-content">
		<div class="container">
			<div class="<?php echo esc_attr(implode(' ', $cryption_panel_classes)); ?>">
				<div class="<?php echo esc_attr($cryption_center_classes); ?>">
				<?php
					if ( have_posts() ) {

						if(!is_singular()) { echo '<div class="blog blog-style-default item-animation-disabled">'; }

						while ( have_posts() ) : the_post();

							get_template_part( 'content', 'blog-item' );

						endwhile;

						if(!is_singular()) { cryption_pagination(); echo '</div>'; }

					} else {
						get_template_part( 'content', 'none' );
					}
				?>
				</div>
				<?php
					if(is_active_sidebar('page-sidebar')) {
						echo '<div class="sidebar col-lg-3 col-md-3 col-sm-12" role="complementary">';
						get_sidebar('page');
						echo '</div><!-- .sidebar -->';
					}
				?>
			</div>
		</div><!-- .container -->
	</div><!-- .block-content -->

<?php endif; ?>

</div><!-- #main-content -->

<?php

get_footer();
