<?php

function ct_footer_post_type_init() {
	if(!in_array('footers', ct_available_post_types())) return ;
	$labels = array(
		'name'               => __('Footers', 'ct'),
		'singular_name'      => __('Footer', 'ct'),
		'menu_name'          => __('Custom Footers', 'ct'),
		'name_admin_bar'     => __('Footer', 'ct'),
		'add_new'            => __('Add New', 'ct'),
		'add_new_item'       => __('Add New Footer', 'ct'),
		'new_item'           => __('New Footer', 'ct'),
		'edit_item'          => __('Edit Footer', 'ct'),
		'view_item'          => __('View Footer', 'ct'),
		'all_items'          => __('All Footers', 'ct'),
		'search_items'       => __('Search Footers', 'ct'),
		'not_found'          => __('No footers found.', 'ct'),
		'not_found_in_trash' => __('No footers found in Trash.', 'ct')
	);

	$args = array(
		'labels'               => $labels,
		'public'               => true,
		'exclude_from_search'  => true,
		'publicly_queryable'   => true,
		'show_ui'              => true,
		'query_var'            => false,
		'hierarchical'         => false,
		'supports'             => array('title', 'editor'),
		'menu_position'        => 39
	);

	register_post_type('ct_footer', $args);
}
add_action('init', 'ct_footer_post_type_init', 5);

function ct_force_type_private($post) {
	if ($post['post_type'] == 'ct_footer' && $post['post_status'] != 'trash') {
		$post['post_status'] = 'private';
	}
	return $post;
}
add_filter('wp_insert_post_data', 'ct_force_type_private');