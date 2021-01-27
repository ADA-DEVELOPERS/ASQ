<?php


function ct_news_post_type_init() {
	if(!in_array('news', ct_available_post_types())) return ;
	$labels = array(
		'name'               => __('News', 'ct'),
		'singular_name'      => __('News', 'ct'),
		'menu_name'          => __('News', 'ct'),
		'name_admin_bar'     => __('News', 'ct'),
		'add_new'            => __('Add New', 'ct'),
		'add_new_item'       => __('Add New News', 'ct'),
		'new_item'           => __('New News', 'ct'),
		'edit_item'          => __('Edit News', 'ct'),
		'view_item'          => __('View News', 'ct'),
		'all_items'          => __('All News', 'ct'),
		'search_items'       => __('Search News', 'ct'),
		'not_found'          => __('No news found.', 'ct'),
		'not_found_in_trash' => __('No news found in Trash.', 'ct')
	);


	$args = array(
		'labels'               => $labels,
		'public'               => true,
		'publicly_queryable'   => true,
		'show_ui'              => true,
		'query_var'            => true,
		'hierarchical'         => false,
		'register_meta_box_cb' => 'ct_post_items_register_meta_box',
		'taxonomies'           => array('ct_news_sets'),
		'rewrite' => array('slug' => 'news', 'with_front' => false),
		'capability_type' => 'post',
		'supports'             => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'comments', 'post-formats'),
	);

	register_post_type('ct_news', $args);

	$labels = array(
		'name'                       => __('News Sets', 'ct'),
		'singular_name'              => __('News Set', 'ct'),
		'search_items'               => __('Search News Sets', 'ct'),
		'popular_items'              => __('Popular News Sets', 'ct'),
		'all_items'                  => __('All News Sets', 'ct'),
		'edit_item'                  => __('Edit News Set', 'ct'),
		'update_item'                => __('Update News Set', 'ct'),
		'add_new_item'               => __('Add New News Set', 'ct'),
		'new_item_name'              => __('New News Set Name', 'ct'),
		'separate_items_with_commas' => __('Separate News Sets with commas', 'ct'),
		'add_or_remove_items'        => __('Add or remove News Sets', 'ct'),
		'choose_from_most_used'      => __('Choose from the most used News Sets', 'ct'),
		'not_found'                  => __('No news sets found.', 'ct'),
		'menu_name'                  => __('News Sets', 'ct'),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array('slug' => 'news_sets'),
	);

	register_taxonomy('ct_news_sets', 'ct_news', $args);
}
add_action('init', 'ct_news_post_type_init', 5);

function ct_post_items_register_meta_box($post) {
	add_meta_box('ct_news_item_settings', __('News Item Settings', 'ct'), 'ct_post_item_settings_box', 'ct_news', 'normal', 'high');
}

add_action('wp_ajax_blog_load_more', 'blog_load_more_callback');
add_action('wp_ajax_nopriv_blog_load_more', 'blog_load_more_callback');
function blog_load_more_callback() {
	$response = array();
	if ( !isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'blog_ajax-nonce' ) ) {
		$response = array('status' => 'error', 'message' => 'Error verify nonce');
		$response = json_encode($response);
		header( "Content-Type: application/json" );
		echo $response;
		exit;
	}
	$data = isset($_POST['data']) ? $_POST['data'] : array();
	$data['is_ajax'] = true;
	$response = array('status' => 'success');
	ob_start();
	ct_blog($data);
	$response['html'] = trim(preg_replace('/\s\s+/', ' ', ob_get_clean()));
	$response = json_encode($response);
	header( "Content-Type: application/json" );
	echo $response;
	exit;
}
