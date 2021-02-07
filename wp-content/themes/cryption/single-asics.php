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
</div><!-- #main-content -->

<?php
get_footer();
