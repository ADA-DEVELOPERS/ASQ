<?php

function ct_slides_post_type_init() {
	if(!in_array('slideshows', ct_available_post_types())) return ;
	$labels = array(
		'name'               => __('Slides', 'ct'),
		'singular_name'      => __('Slideshow Slide', 'ct'),
		'menu_name'          => __('NivoSlider', 'ct'),
		'name_admin_bar'     => __('Slideshow Slide', 'ct'),
		'add_new'            => __('Add New', 'ct'),
		'add_new_item'       => __('Add New Slide', 'ct'),
		'new_item'           => __('New Slide', 'ct'),
		'edit_item'          => __('Edit Slide', 'ct'),
		'view_item'          => __('View Slide', 'ct'),
		'all_items'          => __('All Slides', 'ct'),
		'search_items'       => __('Search Slides', 'ct'),
		'not_found'          => __('No slides found.', 'ct'),
		'not_found_in_trash' => __('No slides found in Trash.', 'ct')
	);

	$args = array(
		'labels'               => $labels,
		'public'               => false,
		'exclude_from_search'  => true,
		'publicly_queryable'   => false,
		'show_ui'              => true,
		'query_var'            => false,
		'hierarchical'         => false,
		'supports'             => array('title', 'thumbnail', 'excerpt', 'page-attributes'),
		'register_meta_box_cb' => 'ct_slides_register_meta_box',
		'taxonomies'           => array('ct_slideshows')
	);

	register_post_type('ct_slide', $args);

	$labels = array(
		'name'                       => __('Slideshows', 'ct'),
		'singular_name'              => __('Slideshow', 'ct'),
		'search_items'               => __('Search Slideshows', 'ct'),
		'popular_items'              => __('Popular Slideshows', 'ct'),
		'all_items'                  => __('All Slideshows', 'ct'),
		'edit_item'                  => __('Edit Slideshow', 'ct'),
		'update_item'                => __('Update Slideshow', 'ct'),
		'add_new_item'               => __('Add New Slideshow', 'ct'),
		'new_item_name'              => __('New Slideshow Name', 'ct'),
		'separate_items_with_commas' => __('Separate Slideshows with commas', 'ct'),
		'add_or_remove_items'        => __('Add or remove Slideshows', 'ct'),
		'choose_from_most_used'      => __('Choose from the most used Slideshows', 'ct'),
		'not_found'                  => __('No slideshows found.', 'ct'),
		'menu_name'                  => __('Slideshows', 'ct'),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => false,
		'public'                => false,
		'rewrite'               => false,
	);

	register_taxonomy('ct_slideshows', 'ct_slide', $args);
}
add_action('init', 'ct_slides_post_type_init');

/* SLIDE POST META BOX */

function ct_slides_register_meta_box($post) {
	remove_meta_box('postimagediv', 'ct_slide', 'side');
	add_meta_box('postimagediv', __('Slide Image', 'ct'), 'post_thumbnail_meta_box', 'ct_slide', 'normal', 'high');
	add_meta_box('ct_slide_settings', __('Slide Settings', 'ct'), 'ct_slide_settings_box', 'ct_slide', 'normal', 'high');
}

function ct_slide_settings_box($post) {
	wp_nonce_field('ct_slide_settings_box', 'ct_slide_settings_box_nonce');
	$slide_data = ct_get_sanitize_slide_data($post->ID);
	$slide_text_position_options = array('' => __('None', 'ct'), 'left' => __('Left', 'ct'), 'right' => __('Right', 'ct'));
?>
<p class="meta-options">
	<label for="slide_link"><?php _e('Link', 'ct'); ?>:</label><br />
	<input name="ct_slide_data[link]" type="text" id="slide_link" value="<?php echo esc_attr($slide_data['link']); ?>" size="60" /><br />
	<br />
	<label for="slide_link_target"><?php _e('Link target', 'ct'); ?>:</label><br />
	<?php ct_print_select_input(array('_self' => 'Self', '_blank' => 'Blank'), $slide_data['link_target'], 'ct_slide_data[link_target]', 'slide_link_target'); ?><br />
	<br />
	<label for="slide_text_position"><?php _e('Caption position', 'ct'); ?>:</label><br />
	<?php ct_print_select_input($slide_text_position_options, $slide_data['text_position'], 'ct_slide_data[text_position]', 'slide_text_position'); ?>
</p>
<?php
}

function ct_slide_save_meta_box_data($post_id) {
	if(!isset($_POST['ct_slide_settings_box_nonce'])) {
		return;
	}
	if(!wp_verify_nonce($_POST['ct_slide_settings_box_nonce'], 'ct_slide_settings_box')) {
		return;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if(isset($_POST['post_type']) && 'ct_slide' == $_POST['post_type']) {
		if(!current_user_can('edit_page', $post_id)) {
			return;
		}
	} else {
		if(!current_user_can('edit_post', $post_id)) {
			return;
		}
	}

	if(!isset($_POST['ct_slide_data']) || !is_array($_POST['ct_slide_data'])) {
		return;
	}

	$slide_data = ct_get_sanitize_slide_data(0, $_POST['ct_slide_data']);
	update_post_meta($post_id, 'ct_slide_data', $slide_data);
}
add_action('save_post', 'ct_slide_save_meta_box_data');

function ct_get_sanitize_slide_data($post_id = 0, $item_data = array()) {
	$slide_data = array(
		'link' => '',
		'link_target' => '',
		'text_position' => ''
	);
	if(is_array($item_data) && !empty($item_data)) {
		$slide_data = array_merge($item_data);
	} elseif($post_id != 0) {
		$slide_data = ct_get_post_data($slide_data, 'slide', $post_id);
	}
	$slide_data['link'] = esc_url($slide_data['link']);
	$slide_data['link_target'] = ct_check_array_value(array('_blank', '_self'), $slide_data['link_target'], '_self');
	$slide_data['text_position'] = ct_check_array_value(array('', 'left', 'right'), $slide_data['text_position'], '');
	return $slide_data;
}