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
				function cptui_register_my_cpts_asics() {

	/**
	 * Post Type: ASIC's.
	 */

	$labels = [
		"name" => __( "ASIC's", "ct" ),
		"singular_name" => __( "ASIC", "ct" ),
		"all_items" => __( "Все АСИКи", "ct" ),
		"add_new" => __( "Добавить АСИК", "ct" ),
	];

	$args = [
		"label" => __( "ASIC's", "ct" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "asics", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-align-pull-right",
		"supports" => [ "title" ],
	];

	register_post_type( "asics", $args );
}

add_action( 'init', 'cptui_register_my_cpts_asics' );?>">

				</div>
			</div>
		</div><!-- .container -->
	</div><!-- .block-content -->
</div><!-- #main-content -->

<?php
get_footer();
