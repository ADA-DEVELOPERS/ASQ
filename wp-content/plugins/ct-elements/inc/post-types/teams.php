<?php

function ct_team_person_post_type_init() {
	if(!in_array('teams', ct_available_post_types())) return ;
	$labels = array(
		'name'               => __('Team Persons', 'ct'),
		'singular_name'      => __('Team Person', 'ct'),
		'menu_name'          => __('Teams', 'ct'),
		'name_admin_bar'     => __('Team Person', 'ct'),
		'add_new'            => __('Add New', 'ct'),
		'add_new_item'       => __('Add New Person', 'ct'),
		'new_item'           => __('New Person', 'ct'),
		'edit_item'          => __('Edit Person', 'ct'),
		'view_item'          => __('View Person', 'ct'),
		'all_items'          => __('All Persons', 'ct'),
		'search_items'       => __('Search Persons', 'ct'),
		'not_found'          => __('No persons found.', 'ct'),
		'not_found_in_trash' => __('No persons found in Trash.', 'ct')
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
		'register_meta_box_cb' => 'ct_team_persons_register_meta_box',
		'taxonomies'           => array('ct_teams')
	);

	register_post_type('ct_team_person', $args);

	$labels = array(
		'name'                       => __('Teams', 'ct'),
		'singular_name'              => __('Team', 'ct'),
		'search_items'               => __('Search Teams', 'ct'),
		'popular_items'              => __('Popular Teams', 'ct'),
		'all_items'                  => __('All Teams', 'ct'),
		'edit_item'                  => __('Edit Team', 'ct'),
		'update_item'                => __('Update Team', 'ct'),
		'add_new_item'               => __('Add New Team', 'ct'),
		'new_item_name'              => __('New Team Name', 'ct'),
		'separate_items_with_commas' => __('Separate Teams with commas', 'ct'),
		'add_or_remove_items'        => __('Add or remove Teams', 'ct'),
		'choose_from_most_used'      => __('Choose from the most used Teams', 'ct'),
		'not_found'                  => __('No teams found.', 'ct'),
		'menu_name'                  => __('Teams', 'ct'),
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

	register_taxonomy('ct_teams', 'ct_team_person', $args);
}
add_action('init', 'ct_team_person_post_type_init');

/* PERSON POST META BOX */

function ct_team_persons_register_meta_box($post) {
	add_meta_box('ct_team_person_settings', __('Person Settings', 'ct'), 'ct_team_person_settings_box', 'ct_team_person', 'normal', 'high');
}

function ct_team_person_settings_box($post) {
	wp_nonce_field('ct_team_person_settings_box', 'ct_team_person_settings_box_nonce');
	$person_data = ct_get_sanitize_team_person_data($post->ID);
?>
<p class="meta-options">
<table class="settings-box-table" width="100%"><tbody><tr>
	<td>
		<label for="person_name"><?php _e('Name', 'ct'); ?>:</label><br />
		<input name="ct_team_person_data[name]" type="text" id="person_name" value="<?php echo esc_attr($person_data['name']); ?>" /><br />
		<br />
		<label for="person_position"><?php _e('Position', 'ct'); ?>:</label><br />
		<input name="ct_team_person_data[position]" type="text" id="person_position" value="<?php echo esc_attr($person_data['position']); ?>" /><br />
		<br />
		<label for="person_phone"><?php _e('Phone', 'ct'); ?>:</label><br />
		<input name="ct_team_person_data[phone]" type="text" id="person_phone" value="<?php echo esc_attr($person_data['phone']); ?>" /><br />
		<br />
		<label for="person_email"><?php _e('Email', 'ct'); ?>:</label><br />
		<input name="ct_team_person_data[email]" type="email" id="person_email" value="<?php echo esc_attr($person_data['email']); ?>" /><br />
		<br />
		<input name="ct_team_person_data[hide_email]" type="checkbox" id="person_hide_email" value="1" <?php checked($person_data['hide_email'], 1); ?> />
		<label for="person_hide_email"><?php _e('Hide Email', 'ct'); ?></label><br />
		<br />
		<label for="person_link"><?php _e('Link', 'ct'); ?>:</label><br />
		<input name="ct_team_person_data[link]" type="text" id="person_link" value="<?php echo esc_attr($person_data['link']); ?>" /><br />
		<br />
		<label for="person_link_target"><?php _e('Link target', 'ct'); ?>:</label><br />
		<?php ct_print_select_input(array('_self' => 'Self', '_blank' => 'Blank'), $person_data['link_target'], 'ct_team_person_data[link_target]', 'person_link_target'); ?>
	</td>
	<td>
		<?php foreach(ct_team_person_socials_list() as $key => $value) : ?>
			<label for="person_social_link_<?php echo esc_attr($key); ?>"><?php echo $value; ?>:</label><br />
			<input name="ct_team_person_data[social_link_<?php echo esc_attr($key); ?>]" type="text" id="person_social_link_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($person_data['social_link_'.$key]); ?>" /><br />
		<?php endforeach; ?>
	</td>
</tr></tbody></table>
</p>
<?php
}

function ct_team_person_socials_list() {
	return (array)apply_filters('ct_team_person_socials_list', array(
		'facebook' => __('Facebook'),
		'googleplus' => __('Google Plus'),
		'twitter' => __('Twitter'),
		'linkedin' => __('LinkedIn'),
		'instagram' => __('Instagram'),
		'skype' => __('Skype'),
	));
}

function ct_team_person_save_meta_box_data($post_id) {
	if(!isset($_POST['ct_team_person_settings_box_nonce'])) {
		return;
	}
	if(!wp_verify_nonce($_POST['ct_team_person_settings_box_nonce'], 'ct_team_person_settings_box')) {
		return;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if(isset($_POST['post_type']) && 'ct_team_person' == $_POST['post_type']) {
		if(!current_user_can('edit_page', $post_id)) {
			return;
		}
	} else {
		if(!current_user_can('edit_post', $post_id)) {
			return;
		}
	}

	if(!isset($_POST['ct_team_person_data']) || !is_array($_POST['ct_team_person_data'])) {
		return;
	}

	$person_data = ct_get_sanitize_team_person_data(0, $_POST['ct_team_person_data']);
	$person_data['link_target'] = ct_check_array_value(array('_blank', '_self'), $person_data['link_target'], '_self');

	update_post_meta($post_id, 'ct_team_person_data', $person_data);
}
add_action('save_post', 'ct_team_person_save_meta_box_data');

function ct_get_sanitize_team_person_data($post_id = 0, $item_data = array()) {
	$person_data = array(
		'name' => '',
		'position' => '',
		'phone' => '',
		'email' => '',
		'hide_email' => false,
		'link' => '',
		'link_target' => ''
	);
	foreach(array_keys(ct_team_person_socials_list()) as $social) {
		$person_data['social_link_'.$social] = '';
	}
	if(is_array($item_data) && !empty($item_data)) {
		$person_data = array_merge($item_data);
	} elseif($post_id != 0) {
		$person_data = ct_get_post_data($person_data, 'team_person', $post_id);
	}
	$person_data['name'] = sanitize_text_field($person_data['name']);
	$person_data['position'] = sanitize_text_field($person_data['position']);
	$person_data['phone'] = sanitize_text_field($person_data['phone']);
	$person_data['email'] = sanitize_email($person_data['email']);
	$person_data['hide_email'] = $person_data['hide_email'] ? 1 : 0;
	$person_data['link'] = esc_url($person_data['link']);
	$person_data['link_target'] = ct_check_array_value(array('_blank', '_self'), $person_data['link_target'], '_self');
	foreach(array_keys(ct_team_person_socials_list()) as $social) {
		$person_data['social_link_'.$social] = esc_url($person_data['social_link_'.$social]);
	}
	return $person_data;
}