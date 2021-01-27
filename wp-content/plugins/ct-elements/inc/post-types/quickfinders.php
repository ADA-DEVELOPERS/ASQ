<?php

function ct_quickfinder_item_post_type_init() {
	if(!in_array('quickfinders', ct_available_post_types())) return ;
	$labels = array(
		'name'               => __('Quickfinder Items', 'ct'),
		'singular_name'      => __('Quickfinder Item', 'ct'),
		'menu_name'          => __('Quickfinders', 'ct'),
		'name_admin_bar'     => __('Quickfinder Item', 'ct'),
		'add_new'            => __('Add New', 'ct'),
		'add_new_item'       => __('Add New Quickfinder Item', 'ct'),
		'new_item'           => __('New Quickfinder Item', 'ct'),
		'edit_item'          => __('Edit Quickfinder Item', 'ct'),
		'view_item'          => __('View Quickfinder Item', 'ct'),
		'all_items'          => __('All Quickfinder Items', 'ct'),
		'search_items'       => __('Search Quickfinder Items', 'ct'),
		'not_found'          => __('No quickfinder items found.', 'ct'),
		'not_found_in_trash' => __('No quickfinder items found in Trash.', 'ct')
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
		'register_meta_box_cb' => 'ct_quickfinder_items_register_meta_box',
		'taxonomies'           => array('ct_quickfinders')
	);

	register_post_type('ct_qf_item', $args);

	$labels = array(
		'name'                       => __('Quickfinders', 'ct'),
		'singular_name'              => __('Quickfinder', 'ct'),
		'search_items'               => __('Search Quickfinders', 'ct'),
		'popular_items'              => __('Popular Quickfinders', 'ct'),
		'all_items'                  => __('All Quickfinders', 'ct'),
		'edit_item'                  => __('Edit Quickfinder', 'ct'),
		'update_item'                => __('Update Quickfinder', 'ct'),
		'add_new_item'               => __('Add New Quickfinder', 'ct'),
		'new_item_name'              => __('New Quickfinder Name', 'ct'),
		'separate_items_with_commas' => __('Separate Quickfinders with commas', 'ct'),
		'add_or_remove_items'        => __('Add or remove Quickfinders', 'ct'),
		'choose_from_most_used'      => __('Choose from the most used Quickfinders', 'ct'),
		'not_found'                  => __('No quickfinders found.', 'ct'),
		'menu_name'                  => __('Quickfinders', 'ct'),
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

	register_taxonomy('ct_quickfinders', 'ct_qf_item', $args);
}
add_action('init', 'ct_quickfinder_item_post_type_init', 5);

/* QUICKFINDER ITEM POST META BOX */

function ct_quickfinder_items_register_meta_box($post) {
	add_meta_box('ct_quickfinder_item_settings', __('Quickfinder Item Settings', 'ct'), 'ct_quickfinder_item_settings_box', 'ct_qf_item', 'normal', 'high');
}

function ct_quickfinder_item_settings_box($post) {
	wp_nonce_field('ct_quickfinder_item_settings_box', 'ct_quickfinder_item_settings_box_nonce');
	$quickfinder_item_data = ct_get_sanitize_qf_item_data($post->ID);
	$icon_styles = array('' => __('None', 'ct'), 'angle-45deg-l' => __('45&deg; Left','ct'), 'angle-45deg-r' => __('45&deg; Right','ct'), 'angle-90deg' => __('90&deg;','ct'));
?>
<p class="meta-options">
<div class="ct-title-settings">
	<fieldset>
		<legend><?php _e('Description & Link', 'ct'); ?></legend>
		<table class="settings-box-table" width="100%"><tbody><tr>
			<td>
				<label for="quickfinder_item_description"><?php _e('Description', 'ct'); ?>:</label><br />
				<textarea name="ct_quickfinder_item_data[description]" id="quickfinder_item_description" style="width: 100%;" rows="3"/><?php echo esc_textarea($quickfinder_item_data['description']); ?></textarea><br />
			</td>
			<td>
				<label for="quickfinder_item_link"><?php _e('Link', 'ct'); ?>:</label><br />
				<input name="ct_quickfinder_item_data[link]" type="text" id="quickfinder_item_link" value="<?php echo esc_attr($quickfinder_item_data['link']); ?>" style="width: 100%;" /><br />
				<br />
				<label for="quickfinder_item_link_text"><?php _e('Button text', 'ct'); ?>:</label><br />
				<input name="ct_quickfinder_item_data[link_text]" type="text" id="quickfinder_item_link_text" value="<?php echo esc_attr($quickfinder_item_data['link_text']); ?>" style="width: 100%;" /><br />
				<br />
				<label for="quickfinder_item_link_target"><?php _e('Link target', 'ct'); ?>:</label><br />
				<?php ct_print_select_input(array('_self' => 'Self', '_blank' => 'Blank'), $quickfinder_item_data['link_target'], 'ct_quickfinder_item_data[link_target]', 'quickfinder_item_link_target'); ?><br />
				<br />
			</td>
		</tr></tbody></table>
	</fieldset>
	<fieldset>
		<legend><?php _e('Colors', 'ct'); ?></legend>
		<table class="settings-box-table" width="100%"><tbody><tr>
			<td>
				<label for="quickfinder_item_title_text_color"><?php _e('Title text color', 'ct'); ?>:</label><br />
				<input name="ct_quickfinder_item_data[title_text_color]" type="text" id="quickfinder_item_title_text_color" value="<?php echo esc_attr($quickfinder_item_data['title_text_color']); ?>" class="color-select" /><br />
			</td>
			<td>
				<label for="quickfinder_item_description_text_color"><?php _e('Description text color', 'ct'); ?>:</label><br />
				<input name="ct_quickfinder_item_data[description_text_color]" type="text" id="quickfinder_item_description_text_color" value="<?php echo esc_attr($quickfinder_item_data['description_text_color']); ?>" class="color-select" /><br />
			</td>
		</tr></tbody></table>
	</fieldset>
	<fieldset>
		<legend><?php _e('Icon', 'ct'); ?></legend>
		<table class="settings-box-table" width="100%"><tbody><tr>
			<td>
				<label for="quickfinder_item_icon_pack"><?php _e('Icon Pack', 'ct'); ?>:</label><br />
				<?php ct_print_select_input(ct_icon_packs_select_array(), $quickfinder_item_data['icon_pack'], 'ct_quickfinder_item_data[icon_pack]', 'quickfinder_item_icon_pack'); ?><br /><br />
				<?php
					add_thickbox();
					wp_enqueue_style('icons-elegant');
					wp_enqueue_style('icons-material');
					wp_enqueue_style('icons-fontawesome');
					wp_enqueue_style('icons-userpack');
					wp_enqueue_script('ct-icons-picker');
				?>
				<label for="quickfinder_item_icon"><?php _e('Icon', 'ct'); ?>:</label><br />
				<input name="ct_quickfinder_item_data[icon]" type="text" id="quickfinder_item_icon" value="<?php echo esc_attr($quickfinder_item_data['icon']); ?>" class="icons-picker" /><br />
				<br />
				<label for="quickfinder_item_icon_color"><?php _e('Icon Color', 'ct'); ?>:</label><br />
				<input name="ct_quickfinder_item_data[icon_color]" type="text" id="quickfinder_item_icon_color" value="<?php echo esc_attr($quickfinder_item_data['icon_color']); ?>" class="color-select" /><br />
				<br />
				<label for="quickfinder_item_icon_color_2"><?php _e('Icon Color 2', 'ct'); ?>:</label><br />
				<input name="ct_quickfinder_item_data[icon_color_2]" type="text" id="quickfinder_item_icon_color_2" value="<?php echo esc_attr($quickfinder_item_data['icon_color_2']); ?>" class="color-select" /><br />
				<br />
				<label for="quickfinder_item_icon_style"><?php _e('Icon Style', 'ct'); ?>:</label><br />
				<?php ct_print_select_input($icon_styles, esc_attr($quickfinder_item_data['icon_style']), 'ct_quickfinder_item_data[icon_style]', 'quickfinder_item_icon_styles'); ?>
			</td>
			<td>
				<label for="quickfinder_item_icon_background_color"><?php _e('Icon background color', 'ct'); ?>:</label><br />
				<input name="ct_quickfinder_item_data[icon_background_color]" type="text" id="quickfinder_item_icon_background_color" value="<?php echo esc_attr($quickfinder_item_data['icon_background_color']); ?>" class="color-select" /><br />
				<br />
				<label for="quickfinder_item_icon_border_color"><?php _e('Icon border color', 'ct'); ?>:</label><br />
				<input name="ct_quickfinder_item_data[icon_border_color]" type="text" id="quickfinder_item_icon_border_color" value="<?php echo esc_attr($quickfinder_item_data['icon_border_color']); ?>" class="color-select" /><br />
				<br />
				<label for="quickfinder_item_icon_shape"><?php _e('Icon shape', 'ct'); ?>:</label><br />
				<?php ct_print_select_input(array('circle' => __('Circle', 'ct'), 'square' => __('Square', 'ct'), 'romb' => __('Rhombus', 'ct'), 'hexagon' => __('Hexagon', 'ct')), $quickfinder_item_data['icon_shape'], 'ct_quickfinder_item_data[icon_shape]', 'quickfinder_item_icon_shape'); ?><br />
				<br />
				<label for="quickfinder_item_icon_size"><?php _e('Icon size', 'ct'); ?>:</label><br />
				<?php ct_print_select_input(array('small' => __('Small', 'ct'), 'medium' => __('Medium', 'ct'), 'large' => __('Large', 'ct'), 'xlarge' => __('xLarge', 'ct')), $quickfinder_item_data['icon_size'], 'ct_quickfinder_item_data[icon_size]', 'quickfinder_item_icon_size'); ?><br />
				<br />
			</td>
		</tr></tbody></table>
	</fieldset>
</div>
<script type="text/javascript">
(function($) {
	$(function() {
		$('#quickfinder_item_icon_pack').change(function() {
			$('.ct-icon-info').hide();
			$('.ct-icon-info-' + $(this).val()).show();
			$('#quickfinder_item_icon').data('iconpack', $(this).val());
		}).trigger('change');
	});
})(jQuery);
</script>
</p>
<?php
}

function ct_quickfinder_item_save_meta_box_data($post_id) {
	if(!isset($_POST['ct_quickfinder_item_settings_box_nonce'])) {
		return;
	}
	if(!wp_verify_nonce($_POST['ct_quickfinder_item_settings_box_nonce'], 'ct_quickfinder_item_settings_box')) {
		return;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if(isset($_POST['post_type']) && 'ct_qf_item' == $_POST['post_type']) {
		if(!current_user_can('edit_page', $post_id)) {
			return;
		}
	} else {
		if(!current_user_can('edit_post', $post_id)) {
			return;
		}
	}

	if(!isset($_POST['ct_quickfinder_item_data']) || !is_array($_POST['ct_quickfinder_item_data'])) {
		return;
	}

	$quickfinder_item_data = ct_get_sanitize_qf_item_data(0, $_POST['ct_quickfinder_item_data']);
	update_post_meta($post_id, 'ct_quickfinder_item_data', $quickfinder_item_data);
}
add_action('save_post', 'ct_quickfinder_item_save_meta_box_data');

function ct_get_sanitize_qf_item_data($post_id = 0, $item_data = array()) {
	$quickfinder_item_data = array(
		'description' => '',
		'title_text_color' => '',
		'description_text_color' => '',
		'link' => '',
		'link_text' => '',
		'link_target' => '',
		'icon_color' => '',
		'icon_color_2' => '',
		'icon_background_color' => '',
		'icon_shape' => '',
		'icon_border_color' => '',
		'icon_size' => '',
		'icon_style' => '',
		'icon' => '',
		'icon_pack' => '',
	);
	if(is_array($item_data) && !empty($item_data)) {
		$quickfinder_item_data = array_merge($item_data);
	} elseif($post_id != 0) {
		$quickfinder_item_data = ct_get_post_data($quickfinder_item_data, 'quickfinder_item', $post_id);
	}
	$quickfinder_item_data['description'] = implode("\n", array_map('sanitize_text_field', explode("\n", $quickfinder_item_data['description'])));
	$quickfinder_item_data['link'] = esc_url($quickfinder_item_data['link']);
	$quickfinder_item_data['link_target'] = ct_check_array_value(array('_blank', '_self'), $quickfinder_item_data['link_target'], '_self');
	$quickfinder_item_data['icon_color'] = sanitize_text_field($quickfinder_item_data['icon_color']);
	$quickfinder_item_data['icon_color_2'] = sanitize_text_field($quickfinder_item_data['icon_color_2']);
	$quickfinder_item_data['icon_background_color'] = sanitize_text_field($quickfinder_item_data['icon_background_color']);
	$quickfinder_item_data['icon_border_color'] = sanitize_text_field($quickfinder_item_data['icon_border_color']);
	$quickfinder_item_data['icon_shape'] = ct_check_array_value(array('circle', 'square', 'romb', 'hexagon'), $quickfinder_item_data['icon_shape'], 'circle');
	$quickfinder_item_data['icon_size'] = ct_check_array_value(array('small', 'medium', 'large', 'xlarge'), $quickfinder_item_data['icon_size'], 'large');
	$quickfinder_item_data['icon_style'] = ct_check_array_value(array('', 'angle-45deg-r', 'angle-45deg-l', 'angle-90deg'), $quickfinder_item_data['icon_style'], '');

	$quickfinder_item_data['title_text_color'] = sanitize_text_field($quickfinder_item_data['title_text_color']);
	$quickfinder_item_data['description_text_color'] = sanitize_text_field($quickfinder_item_data['description_text_color']);
	$quickfinder_item_data['link_text'] = sanitize_text_field($quickfinder_item_data['link_text']);
	$quickfinder_item_data['icon_pack'] = ct_check_array_value(array('elegant', 'material', 'fontawesome', 'userpack'), $quickfinder_item_data['icon_pack'], 'elegant');
	$quickfinder_item_data['icon'] = sanitize_text_field($quickfinder_item_data['icon']);

	return $quickfinder_item_data;
}