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
				
				<?php if ( get_field('asic-searial') ) { ?>
					<?php the_field('asic-searial'); ?>
				<?php } ?>
				<?php if ( get_field('asic-status') ) { ?>
					<?php the_field('asic-status'); ?>
				<?php } ?>
				<?php if ( get_field('asic-maintenance-reason') ) { ?>
					<?php the_field('asic-maintenance-reason'); ?>
				<?php } ?>
				<?php if ( get_field('asic-ip') ) { ?>
					<?php the_field('asic-ip'); ?>
				<?php } ?>
				<?php if ( get_field('asic-location') ) { ?>
					<?php the_field('asic-location'); ?>
				<?php } ?>
				<?php if ( get_field('asic-poll') ) { ?>
					<?php the_field('asic-poll'); ?>
				<?php } ?>
				<?php if ( get_field('asic-owner') ) { ?>
					<?php the_field('asic-owner'); ?>
				<?php } ?>
				<?php if ( get_field('asic-install-date') ) { ?>
					<?php the_field('asic-install-date'); ?>
				<?php } ?>
				<?php if ( get_field('asic-model') ) { ?>
					<?php the_field('asic-model'); ?>
				<?php } ?>
				<?php if ( get_field('asic_mode') ) { ?>
					<?php the_field('asic_mode'); ?>
				<?php } ?>
				<?php if ( get_field('Asic_VERSION') ) { ?>
					<?php the_field('Asic_VERSION'); ?>
				<?php } ?>
				<?php if ( get_field('Power_Supply_MODEL') ) { ?>
					<?php the_field('Power_Supply_MODEL'); ?>
				<?php } ?>
				<?php if ( get_field('power_supply-NO') ) { ?>
					<?php the_field('power_supply-NO'); ?>
				<?php } ?>
				<?php if ( get_field('power_supply-SN') ) { ?>
					<?php the_field('power_supply-SN'); ?>
				<?php } ?>
				<?php if ( get_field('сontrol_unit-MODEL') ) { ?>
					<?php the_field('сontrol_unit-MODEL'); ?>
				<?php } ?>
				<?php if ( get_field('сontrol_unit_sn') ) { ?>
					<?php the_field('сontrol_unit_sn'); ?>
				<?php } ?>
				<?php if ( get_field('сontrol_unit_wo') ) { ?>
					<?php the_field('сontrol_unit_wo'); ?>
				<?php } ?>
				
				</div>
			</div>
		</div><!-- .container -->
	</div><!-- .block-content -->

<?php endif; ?>

</div><!-- #main-content -->

<?php

get_footer();
