<?php

function ct_galleries_post_type_init() {
	if(!in_array('galleries', ct_available_post_types())) return ;
	$labels = array(
		'name'               => __('Galleries', 'ct'),
		'singular_name'      => __('Gallery', 'ct'),
		'menu_name'          => __('Galleries', 'ct'),
		'name_admin_bar'     => __('Gallery', 'ct'),
		'add_new'            => __('Add New', 'ct'),
		'add_new_item'       => __('Add New Gallery', 'ct'),
		'new_item'           => __('New Gallery', 'ct'),
		'edit_item'          => __('Edit Gallery', 'ct'),
		'view_item'          => __('View Gallery', 'ct'),
		'all_items'          => __('All Galleries', 'ct'),
		'search_items'       => __('Search Galleries', 'ct'),
		'not_found'          => __('No galleries found.', 'ct'),
		'not_found_in_trash' => __('No galleries found in Trash.', 'ct')
	);

	$args = array(
		'labels'               => $labels,
		'public'               => false,
		'exclude_from_search'  => true,
		'publicly_queryable'   => false,
		'show_ui'              => true,
		'query_var'            => false,
		'public'               => false,
		'hierarchical'         => false,
		'supports'             => array('title'),
		'register_meta_box_cb' => 'ct_galleries_register_meta_box',
	);

	register_post_type('ct_gallery', $args);
}
add_action('init', 'ct_galleries_post_type_init');

/* GALLERY POST META BOX */

function ct_galleries_register_meta_box($post) {
	add_meta_box('ct_gallery_settings', sprintf(__('Gallery Manager (ID = %s)', 'ct'), (isset($post->ID) ? $post->ID : 0)), 'ct_gallery_settings_box', 'ct_gallery', 'normal', 'high');
}

function ct_gallery_settings_box($post) {
	wp_nonce_field('ct_gallery_settings_box', 'ct_gallery_settings_box_nonce');
	if(metadata_exists('post', $post->ID, 'ct_gallery_images')) {
		$ct_gallery_images_ids = get_post_meta($post->ID, 'ct_gallery_images', true);
	} else {
		$attachments_ids = get_posts('post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids');
		$ct_gallery_images_ids = implode(',', $attachments_ids);
	}
	$attachments_ids = array_filter(explode(',', $ct_gallery_images_ids));

	echo '<div id="gallery_manager">';
	echo '<input type="hidden" id="ct_gallery_images" name="ct_gallery_images" value="' . esc_attr($ct_gallery_images_ids) . '" />';
	echo '<a id="upload_button" class="button" href="javascript:void(0);" style="font-size: 16px;">' . __('Add images','ct') . '</a>';

	echo '<ul class="gallery-images">';
	if($attachments_ids) {
		foreach($attachments_ids as $attachment_id) {
			echo '<li class="image" data-attachment_id="' . esc_attr($attachment_id) . '"><a target="_blank" href="' . get_edit_post_link($attachment_id) . '" class="edit">' .wp_get_attachment_image($attachment_id, 'thumbnail') . '</a><a href="javascript:void(0);" class="remove">x</a></li>';
		}
	}
	echo '</ul><br class="clear" />';

	echo '</div>';
?>

<?php
}

function ct_gallery_save_meta_box_data($post_id) {
	if(!isset($_POST['ct_gallery_settings_box_nonce'])) {
		return;
	}
	if(!wp_verify_nonce($_POST['ct_gallery_settings_box_nonce'], 'ct_gallery_settings_box')) {
		return;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if(isset($_POST['post_type']) && 'ct_gallery' == $_POST['post_type']) {
		if(!current_user_can('edit_page', $post_id)) {
			return;
		}
	} else {
		if(!current_user_can('edit_post', $post_id)) {
			return;
		}
	}

	if(!isset($_POST['ct_gallery_images'])) {
		return;
	}

	update_post_meta($post_id, 'ct_gallery_images', $_POST['ct_gallery_images']);
}
add_action('save_post', 'ct_gallery_save_meta_box_data');

function ct_galleries_array() {
	$galleries_posts = get_posts(array(
		'post_type' => 'ct_gallery',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
	));
	$galleries = array();
	foreach($galleries_posts as $gallery) {
		$galleries[$gallery->ID] = $gallery->post_title.' (ID='.$gallery->ID.')';
	}
	return $galleries;
}