<?php
$post = $wp_query->post;
if ( in_category( 'asics' ) ) { //ñëàã êàòåãîðèè
    include( TEMPLATEPATH.'/single-asics.php' );
} else {
    include( TEMPLATEPATH.'/single-default.php' );
}
?>





<?php
    /*
        Asic theme: Òåìà äëÿ Àñèêîâ
		Template Post Type: asic
    */
get_header(); ?>

<div id="asics" class="main-content">

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
				<?php if ( get_field('Ñontrol_unit-MODEL') ) { ?>
					<?php the_field('Ñontrol_unit-MODEL'); ?>
				<?php } ?>
				<?php if ( get_field('Ñontrol_unit_sn') ) { ?>
					<?php the_field('Ñontrol_unit_sn'); ?>
				<?php } ?>
				<?php if ( get_field('Ñontrol_unit_wo') ) { ?>
					<?php the_field('Ñontrol_unit_wo'); ?>
				<?php } ?>
				








</div><!-- #main-content -->

<?php
get_footer();
