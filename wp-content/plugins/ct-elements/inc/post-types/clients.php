<?php

function ct_clients_post_type_init() {
	if(!in_array('clients', ct_available_post_types())) return ;
	$labels = array(
		'name'               => __('Clients', 'ct'),
		'singular_name'      => __('Client', 'ct'),
		'menu_name'          => __('Clients', 'ct'),
		'name_admin_bar'     => __('Client', 'ct'),
		'add_new'            => __('Add New', 'ct'),
		'add_new_item'       => __('Add New Client', 'ct'),
		'new_item'           => __('New Client', 'ct'),
		'edit_item'          => __('Edit Client', 'ct'),
		'view_item'          => __('View Client', 'ct'),
		'all_items'          => __('All Clients', 'ct'),
		'search_items'       => __('Search Clients', 'ct'),
		'not_found'          => __('No clients found.', 'ct'),
		'not_found_in_trash' => __('No clients found in Trash.', 'ct')
	);

	$args = array(
		'labels'               => $labels,
		'public'               => false,
		'exclude_from_search'  => true,
		'publicly_queryable'   => false,
		'show_ui'              => true,
		'query_var'            => false,
		'hierarchical'         => false,
		'supports'             => array('title', 'thumbnail', 'page-attributes'),
		'register_meta_box_cb' => 'ct_clients_register_meta_box',
		'taxonomies'           => array('ct_clients_sets')
	);

	register_post_type('ct_client', $args);

	$labels = array(
		'name'                       => __('Clients Sets', 'ct'),
		'singular_name'              => __('Clients Set', 'ct'),
		'search_items'               => __('Search Clients Sets', 'ct'),
		'popular_items'              => __('Popular Clients Sets', 'ct'),
		'all_items'                  => __('All Clients Sets', 'ct'),
		'edit_item'                  => __('Edit Clients Set', 'ct'),
		'update_item'                => __('Update Clients Set', 'ct'),
		'add_new_item'               => __('Add New Clients Set', 'ct'),
		'new_item_name'              => __('New Clients Set Name', 'ct'),
		'separate_items_with_commas' => __('Separate Clients Sets with commas', 'ct'),
		'add_or_remove_items'        => __('Add or remove Clients Sets', 'ct'),
		'choose_from_most_used'      => __('Choose from the most used Clients Sets', 'ct'),
		'not_found'                  => __('No clients sets found.', 'ct'),
		'menu_name'                  => __('Clients Sets', 'ct'),
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

	register_taxonomy('ct_clients_sets', 'ct_client', $args);
}
add_action('init', 'ct_clients_post_type_init');

/* CLIENT POST META BOX */

function ct_clients_register_meta_box($post) {
	remove_meta_box('postimagediv', 'ct_client', 'side');
	add_meta_box('postimagediv', __('Client Image', 'ct'), 'post_thumbnail_meta_box', 'ct_client', 'normal', 'high');
	add_meta_box('ct_client_settings', __('Client Settings', 'ct'), 'ct_client_settings_box', 'ct_client', 'normal', 'high');
}

function ct_client_settings_box($post) {
	wp_nonce_field('ct_client_settings_box', 'ct_client_settings_box_nonce');
	$client_data = ct_get_sanitize_client_data($post->ID);
?>
<p class="meta-options">

	<label for="client_link"><?php _e('Link', 'ct'); ?>:</label><br />
	<input name="ct_client_data[link]" type="text" id="client_link" value="<?php echo esc_attr($client_data['link']); ?>" size="60" /><br />
	<br />
	<label for="client_link_target"><?php _e('Link target', 'ct'); ?>:</label><br />
	<?php ct_print_select_input(array('_blank' => 'Blank', '_self' => 'Self'), $client_data['link_target'], 'ct_client_data[link_target]', 'client_link_target'); ?>
</p>
<?php
}

function ct_client_save_meta_box_data($post_id) {
	if(!isset($_POST['ct_client_settings_box_nonce'])) {
		return;
	}
	if(!wp_verify_nonce($_POST['ct_client_settings_box_nonce'], 'ct_client_settings_box')) {
		return;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if(isset($_POST['post_type']) && 'ct_client' == $_POST['post_type']) {
		if(!current_user_can('edit_page', $post_id)) {
			return;
		}
	} else {
		if(!current_user_can('edit_post', $post_id)) {
			return;
		}
	}

	if(!isset($_POST['ct_client_data']) || !is_array($_POST['ct_client_data'])) {
		return;
	}

	$client_data = ct_get_sanitize_client_data(0, $_POST['ct_client_data']);
	update_post_meta($post_id, 'ct_client_data', $client_data);
}
add_action('save_post', 'ct_client_save_meta_box_data');

function ct_get_sanitize_client_data($post_id = 0, $item_data = array()) {
	$client_data = array(
		'description' => '',
		'link' => '',
		'link_target' => ''
	);
	if(is_array($item_data) && !empty($item_data)) {
		$client_data = array_merge($item_data);
	} elseif($post_id != 0) {
		$client_data = ct_get_post_data($client_data, 'client', $post_id);
	}
	$client_data['description'] = sanitize_text_field($client_data['description']);
	$client_data['link'] = esc_url($client_data['link']);
	$client_data['link_target'] = ct_check_array_value(array('_blank', '_self'), $client_data['link_target'], '_blank');
	return $client_data;
}

/* CLIENTS SET OPTIONS */

function ct_clients_sets_add_form_fields_callback() {
?>
	<div class="form-field">
		<label for="clients_set_icon"><?php _e('Icon', 'ct'); ?></label>
		<input class= "icon" type="text" id="clients_set_icon" name="clients_set_icon"/><br/>
		<?php _e('Enter icon code', 'ct'); ?>. <a href="<?php echo ct_user_icons_info_link(); ?>" onclick="tb_show('<?php _e('Icons info', 'ct'); ?>', this.href+'?TB_iframe=true'); return false;"><?php _e('Show Icon Codes', 'ct'); ?></a>
	</div>
<?php
}
add_action('ct_clients_sets_add_form_fields','ct_clients_sets_add_form_fields_callback');

function ct_clients_sets_edit_form_fields_callback() {
?>
	<tr class="form-field">
		<th valign="top" scope="row"><label for="clients_set_icon"><?php _e('Icon', 'ct'); ?></label></th>
		<td>
			<input class= "icon" type="text" id="clients_set_icon" name="clients_set_icon" value="<?php echo esc_attr(get_option('ct_clients_set_' . $_REQUEST['tag_ID'] . '_icon')); ?>"/><br />
			<span class="description"><?php _e('Enter icon code', 'ct'); ?>. <a href="<?php echo ct_user_icons_info_link(); ?>" onclick="tb_show('<?php _e('Icons info', 'ct'); ?>', this.href+'?TB_iframe=true'); return false;"><?php _e('Show Icon Codes', 'ct'); ?></a></span>
		</td>
	</tr>
<?php
}
add_action('ct_clients_sets_edit_form_fields','ct_clients_sets_edit_form_fields_callback');

function ct_clients_sets_create_callback($id) {
	if(isset($_REQUEST['clients_set_icon'])) {
		update_option('ct_clients_set_' . $id . '_icon', $_REQUEST['clients_set_icon']);
	}
}
add_action('create_ct_clients_sets','ct_clients_sets_create_callback');

function ct_clients_sets_update_callback($id) {
	if(isset($_REQUEST['clients_set_icon'])) {
		update_option('ct_clients_set_' . $id . '_icon', $_REQUEST['clients_set_icon']);
	}
}
add_action('edit_ct_clients_sets','ct_clients_sets_update_callback');

function ct_clients_sets_delete_callback($id) {
	delete_option('ct_clients_set_' . $id . '_icon');
}
add_action('delete_ct_clients_sets','ct_clients_sets_delete_callback');