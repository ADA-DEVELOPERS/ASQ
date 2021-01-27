<?php

function ct_testimonials_post_type_init() {
	if(!in_array('testimonials', ct_available_post_types())) return ;
	$labels = array(
		'name'               => __('Testimonials', 'ct'),
		'singular_name'      => __('Testimonial', 'ct'),
		'menu_name'          => __('Testimonials', 'ct'),
		'name_admin_bar'     => __('Testimonial', 'ct'),
		'add_new'            => __('Add New', 'ct'),
		'add_new_item'       => __('Add New Testimonial', 'ct'),
		'new_item'           => __('New Testimonial', 'ct'),
		'edit_item'          => __('Edit Testimonial', 'ct'),
		'view_item'          => __('View Testimonial', 'ct'),
		'all_items'          => __('All Testimonials', 'ct'),
		'search_items'       => __('Search Testimonials', 'ct'),
		'not_found'          => __('No testimonials found.', 'ct'),
		'not_found_in_trash' => __('No testimonials found in Trash.', 'ct')
	);

	$args = array(
		'labels'               => $labels,
		'public'               => false,
		'exclude_from_search'  => true,
		'publicly_queryable'   => false,
		'show_ui'              => true,
		'query_var'            => false,
		'hierarchical'         => false,
		'supports'             => array('title', 'editor', 'thumbnail', 'page-attributes'),
		'register_meta_box_cb' => 'ct_testimonials_register_meta_box',
		'taxonomies'           => array('ct_testimonials_sets')
	);

	register_post_type('ct_testimonial', $args);

	$labels = array(
		'name'                       => __('Testimonials Sets', 'ct'),
		'singular_name'              => __('Testimonials Set', 'ct'),
		'search_items'               => __('Search Testimonials Sets', 'ct'),
		'popular_items'              => __('Popular Testimonials Sets', 'ct'),
		'all_items'                  => __('All Testimonials Sets', 'ct'),
		'edit_item'                  => __('Edit Testimonials Set', 'ct'),
		'update_item'                => __('Update Testimonials Set', 'ct'),
		'add_new_item'               => __('Add New Testimonials Set', 'ct'),
		'new_item_name'              => __('New Testimonials Set Name', 'ct'),
		'separate_items_with_commas' => __('Separate Testimonials Sets with commas', 'ct'),
		'add_or_remove_items'        => __('Add or remove Testimonials Sets', 'ct'),
		'choose_from_most_used'      => __('Choose from the most used Testimonials Sets', 'ct'),
		'not_found'                  => __('No testimonials sets found.', 'ct'),
		'menu_name'                  => __('Testimonials Sets', 'ct'),
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

	register_taxonomy('ct_testimonials_sets', 'ct_testimonial', $args);
}
add_action('init', 'ct_testimonials_post_type_init');

/* CLIENT POST META BOX */

function ct_testimonials_register_meta_box($post) {
	add_meta_box('ct_testimonial_settings', __('Testimonial Settings', 'ct'), 'ct_testimonial_settings_box', 'ct_testimonial', 'normal', 'high');
}

function ct_testimonial_settings_box($post) {
	wp_nonce_field('ct_testimonial_settings_box', 'ct_testimonial_settings_box_nonce');
	$testimonial_data = ct_get_sanitize_testimonial_data($post->ID);
?>
<p class="meta-options">
	<label for="testimonial_name"><?php _e('Name', 'ct'); ?>:</label><br />
	<input name="ct_testimonial_data[name]" type="text" id="testimonial_name" value="<?php echo esc_attr($testimonial_data['name']); ?>" size="60" /><br />
	<br />
	<label for="testimonial_company"><?php _e('Company', 'ct'); ?>:</label><br />
	<input name="ct_testimonial_data[company]" type="text" id="testimonial_company" value="<?php echo esc_attr($testimonial_data['company']); ?>" size="60" /><br />
	<br />
	<label for="testimonial_position"><?php _e('Position', 'ct'); ?>:</label><br />
	<input name="ct_testimonial_data[position]" type="text" id="testimonial_position" value="<?php echo esc_attr($testimonial_data['position']); ?>" size="60" /><br />
	<br />
	<?php /*<label for="testimonial_phone"><?php _e('Phone', 'ct'); ?>:</label><br />
	<input name="ct_testimonial_data[phone]" type="text" id="testimonial_phone" value="<?php echo $testimonial_data['phone']; ?>" size="60" /><br />
	<br />*/ ?>
	<label for="testimonial_link"><?php _e('Link', 'ct'); ?>:</label><br />
	<input name="ct_testimonial_data[link]" type="text" id="testimonial_link" value="<?php echo esc_attr($testimonial_data['link']); ?>" size="60" /><br />
	<br />
	<label for="testimonial_link_target"><?php _e('Link target', 'ct'); ?>:</label><br />
	<?php ct_print_select_input(array('_blank' => 'Blank', '_self' => 'Self'), $testimonial_data['link_target'], 'ct_testimonial_data[link_target]', 'testimonial_link_target'); ?>
</p>
<?php
}

function ct_testimonial_save_meta_box_data($post_id) {
	if(!isset($_POST['ct_testimonial_settings_box_nonce'])) {
		return;
	}
	if(!wp_verify_nonce($_POST['ct_testimonial_settings_box_nonce'], 'ct_testimonial_settings_box')) {
		return;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if(isset($_POST['post_type']) && 'ct_testimonial' == $_POST['post_type']) {
		if(!current_user_can('edit_page', $post_id)) {
			return;
		}
	} else {
		if(!current_user_can('edit_post', $post_id)) {
			return;
		}
	}

	if(!isset($_POST['ct_testimonial_data']) || !is_array($_POST['ct_testimonial_data'])) {
		return;
	}

	$testimonial_data = ct_get_sanitize_testimonial_data(0, $_POST['ct_testimonial_data']);
	update_post_meta($post_id, 'ct_testimonial_data', $testimonial_data);
}
add_action('save_post', 'ct_testimonial_save_meta_box_data');

function ct_get_sanitize_testimonial_data($post_id = 0, $item_data = array()) {
	$testimonial_data = array(
		'name' => '',
		'company' => '',
		'position' => '',
		'phone' => '',
		'link' => '',
		'link_target' => ''
	);
	if(is_array($item_data) && !empty($item_data)) {
		$testimonial_data = array_merge($item_data);
	} elseif($post_id != 0) {
		$testimonial_data = ct_get_post_data($testimonial_data, 'testimonial', $post_id);
	}
	$testimonial_data['name'] = sanitize_text_field($testimonial_data['name']);
	$testimonial_data['company'] = sanitize_text_field($testimonial_data['company']);
	$testimonial_data['position'] = sanitize_text_field($testimonial_data['position']);
	$testimonial_data['phone'] = sanitize_text_field($testimonial_data['phone']);
	$testimonial_data['link'] = esc_url($testimonial_data['link']);
	$testimonial_data['link_target'] = ct_check_array_value(array('_blank', '_self'), $testimonial_data['link_target'], '_blank');
	return $testimonial_data;
}