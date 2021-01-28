<?php
    /*
        Asic theme: Тема для Асиков
		Template Post Type: asic
    */


get_header(); ?>

<div id="main-content" class="main-content">

<?php
	while ( have_posts() ) : the_post();
		get_template_part( 'content', 'page' );
	endwhile;
?>

</div><!-- #main-content -->
<?php echo get_post_meta($post->ID, ' Имя поля ', true); ?>

<?php
get_footer();
