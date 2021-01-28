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

<p><?php the_field('asic-searial'); ?></p>
<p><?php the_field('asic-status'); ?></p>
<p><?php the_field('asic-maintenance-reason'); ?></p>
<p><?php the_field('asic-ip'); ?></p>
<p><?php the_field('asic-location'); ?></p>
<p><?php the_field('asic-poll'); ?></p>
<p><?php the_field('asic-owner'); ?></p>
<p><?php the_field('asic-install-date'); ?></p>
<p><?php the_field('asic-model'); ?></p>
<p><?php the_field('asic_mode'); ?></p>
<p><?php the_field('Asic_VERSION'); ?></p>
<p><?php the_field('Power_Supply_MODEL'); ?></p>
<p><?php the_field('power_supply-NO'); ?></p>
<p><?php the_field('apower_supply-SN'); ?></p>
<p><?php the_field('ñontrol_unit-MODEL'); ?></p>
<p><?php the_field('ñontrol_unit_sn'); ?></p>
<p><?php the_field('ñontrol_unit_wo'); ?></p>










</div><!-- #main-content -->

<?php
get_footer();
