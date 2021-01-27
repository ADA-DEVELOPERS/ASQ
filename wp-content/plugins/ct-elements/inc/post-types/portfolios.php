<?php

$PORTFOLIO_TYPE_OPTIONS = array('self-link' => __('Portfolio Page', 'ct'), 'inner-link' => __('Internal Link', 'ct'), 'outer-link' => __('External Link', 'ct'), 'full-image' => __('Full-Size Image', 'ct'), 'youtube' => __('YouTube Video', 'ct'), 'vimeo' => __('Vimeo Video', 'ct'), 'self_video' => __('Self-Hosted Video', 'ct'));

function ct_portfolio_item_post_type_init() {
	if(!in_array('portfolios', ct_available_post_types())) return ;
	$labels = array(
		'name'               => __('Portfolio Items', 'ct'),
		'singular_name'      => __('Portfolio Item', 'ct'),
		'menu_name'          => __('Portfolios', 'ct'),
		'name_admin_bar'     => __('Portfolio Item', 'ct'),
		'add_new'            => __('Add New', 'ct'),
		'add_new_item'       => __('Add New Portfolio Item', 'ct'),
		'new_item'           => __('New Portfolio Item', 'ct'),
		'edit_item'          => __('Edit Portfolio Item', 'ct'),
		'view_item'          => __('View Portfolio Item', 'ct'),
		'all_items'          => __('All Portfolio Items', 'ct'),
		'search_items'       => __('Search Portfolio Items', 'ct'),
		'not_found'          => __('No portfolio items found.', 'ct'),
		'not_found_in_trash' => __('No portfolio items found in Trash.', 'ct')
	);

	$args = array(
		'labels'               => $labels,
		'public'               => true,
		'publicly_queryable'   => true,
		'show_ui'              => true,
		'query_var'            => true,
		'hierarchical'         => false,
		'register_meta_box_cb' => 'ct_portfolio_items_register_meta_box',
		'taxonomies'           => array('ct_portfolios'),
		'rewrite' => array('slug' => 'portfolios', 'with_front' => false),
		'capability_type' => 'page',
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'comments'),
	);

	register_post_type('ct_pf_item', $args);

	$labels = array(
		'name'                       => __('Portfolios', 'ct'),
		'singular_name'              => __('Portfolio', 'ct'),
		'search_items'               => __('Search Portfolios', 'ct'),
		'popular_items'              => __('Popular Portfolios', 'ct'),
		'all_items'                  => __('All Portfolios', 'ct'),
		'edit_item'                  => __('Edit Portfolio', 'ct'),
		'update_item'                => __('Update Portfolio', 'ct'),
		'add_new_item'               => __('Add New Portfolio', 'ct'),
		'new_item_name'              => __('New Portfolio Name', 'ct'),
		'separate_items_with_commas' => __('Separate Portfolios with commas', 'ct'),
		'add_or_remove_items'        => __('Add or remove Portfolios', 'ct'),
		'choose_from_most_used'      => __('Choose from the most used Portfolios', 'ct'),
		'not_found'                  => __('No portfolios found.', 'ct'),
		'menu_name'                  => __('Portfolios', 'ct'),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => false,
		'public'                => false,
		'rewrite'               => false,
	);

	register_taxonomy('ct_portfolios', 'ct_pf_item', $args);
}
add_action('init', 'ct_portfolio_item_post_type_init', 5);

/* PORTFOLIO ITEM POST META BOX */

function ct_portfolio_items_register_meta_box($post) {
	add_meta_box('ct_portfolio_item_settings', __('Portfolio Item Settings', 'ct'), 'ct_portfolio_item_settings_box', 'ct_pf_item', 'normal', 'high');
}

function print_portfolio_more_type($item_type, $types_index) {
	global $PORTFOLIO_TYPE_OPTIONS;
?>
	<div class="portfolio_item_element_<?php echo $types_index; ?>" id="portfolio_item_type_<?php echo $types_index; ?>_wrapper">
		<label for="portfolio_item_type_<?php echo $types_index; ?>"><?php _e('Type of portfolio item', 'ct'); ?>:</label><br />
		<?php ct_print_select_input($PORTFOLIO_TYPE_OPTIONS, $item_type['type'], 'ct_portfolio_item_data[types]['.$types_index.'][type]', 'portfolio_item_type_'.$types_index); ?>
	</div>

	<div class="portfolio_item_element_<?php echo $types_index; ?>" id="portfolio_item_link_target_<?php echo $types_index; ?>_wrapper">
		<label for="portfolio_item_link_target_<?php echo $types_index; ?>"><?php _e('Link target', 'ct'); ?>:</label><br />
		<?php ct_print_select_input(array('_self' => 'Self', '_blank' => 'Blank'), $item_type['link_target'], 'ct_portfolio_item_data[types]['.$types_index.'][link_target]', 'portfolio_item_link_target_'.$types_index); ?>
	</div>

	<div class="portfolio_item_element_<?php echo $types_index; ?>" id="portfolio_item_link_<?php echo $types_index; ?>_wrapper">
		<label for="portfolio_item_link_<?php echo $types_index; ?>"><?php _e('Link to another page or video ID (for YouTube or Vimeo):', 'ct'); ?>:</label><br />
		<input name="ct_portfolio_item_data[types][<?php echo esc_attr($types_index); ?>][link]" type="text" id="portfolio_item_link_<?php echo esc_attr($types_index); ?>" value="<?php echo esc_attr($item_type['link']); ?>" size="60" />
	</div>

	<div class="portfolio_item_element_<?php echo $types_index; ?>" id="portfolio_item_remove_button_<?php echo $types_index; ?>_wrapper">
		<a href="#" onclick="return portfolio_remove_item_type(this);">Remove type</a>
	</div>
	<div class="portfolio_item_element_<?php echo $types_index; ?>"><br /></div>
<?php
}

function ct_portfolio_item_settings_box($post) {
	global $PORTFOLIO_TYPE_OPTIONS;

	wp_nonce_field('ct_portfolio_item_settings_box', 'ct_portfolio_item_settings_box_nonce');
	$portfolio_item_data = ct_get_sanitize_pf_item_data($post->ID);
	$default_portfolio_type = array('link' => '', 'link_target' => '_self', 'type' => 'self-link');
	if (empty($portfolio_item_data['types']))
		$portfolio_item_data['types'] = array(0 => $default_portfolio_type);
	$types_index = 0;
?>
<p class="meta-options">
	<input name="ct_portfolio_item_data[fullwidth]" type="checkbox" id="portfolio_item_fullwidth" value="1" <?php checked($portfolio_item_data['fullwidth'], 1); ?> />
	<label for="portfolio_item_fullwidth"><?php _e('100% page layout', 'ct'); ?></label>
	<br /><br />

	<input name="ct_portfolio_item_data[highlight]" type="checkbox" id="portfolio_item_highlight" value="1" <?php checked($portfolio_item_data['highlight'], 1); ?> />
	<label for="portfolio_item_highlight"><?php _e('Show as Highlight?', 'ct'); ?></label>
	<br /><br />

	<label for="portfolio_item_highlight_type"><?php _e('Highlight Type', 'ct'); ?>:</label><br />
	<?php ct_print_select_input(array('squared' => 'Squared', 'horizontal' => 'Horizontal', 'vertical' => 'Vertical'), $portfolio_item_data['highlight_type'], 'ct_portfolio_item_data[highlight_type]', 'portfolio_item_data_highlight_type'); ?>
	<br /><br />

	<label for="portfolio_item_overview_title"><?php _e('Overview title', 'ct'); ?>:</label><br />
	<input name="ct_portfolio_item_data[overview_title]" type="text" id="portfolio_item_overview_title" value="<?php echo esc_attr($portfolio_item_data['overview_title']); ?>" size="60" />
	<br /><br />

	<?php if(apply_filters('ct_portfolio_project_button_available', false)) : ?>
		<label for="portfolio_item_project_link"><?php _e('Project Preview Button Link', 'ct'); ?>:</label><br />
		<input name="ct_portfolio_item_data[project_link]" type="text" id="portfolio_item_project_link" value="<?php echo esc_attr($portfolio_item_data['project_link']); ?>" size="60" />
		<br /><br />

		<label for="portfolio_item_project_text"><?php _e('Project Preview Button Text', 'ct'); ?>:</label><br />
		<input name="ct_portfolio_item_data[project_text]" type="text" id="portfolio_item_project_text" value="<?php echo esc_attr($portfolio_item_data['project_text']); ?>" size="60" />
		<br /><br />

		<label for="portfolio_item_back_url"><?php _e('Back to overview URL', 'ct'); ?>:</label><br />
		<input name="ct_portfolio_item_data[back_url]" type="text" id="portfolio_item_project_text" value="<?php echo esc_attr($portfolio_item_data['back_url']); ?>" size="60" />
		<br /><br />
	<?php endif; ?>

	<div id="add_portfolio_item_type_template" style="display: none;">
		<?php print_portfolio_more_type($default_portfolio_type, '%INDEX%'); ?>
	</div>

	<div class="portfolio-types">
		<?php
			foreach($portfolio_item_data['types'] as $item_type) {
				print_portfolio_more_type($item_type, $types_index);
				$types_index++;
			}
		?>
	</div>
	<a href="#" onclick="return portfolio_add_item_type(this);">Add one more type</a>
	<script type='text/javascript'>
		init_portfolio_settings();
	</script>
</p>
<?php
}

function ct_portfolio_item_save_meta_box_data($post_id) {
	if(!isset($_POST['ct_portfolio_item_settings_box_nonce'])) {
		return;
	}
	if(!wp_verify_nonce($_POST['ct_portfolio_item_settings_box_nonce'], 'ct_portfolio_item_settings_box')) {
		return;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if(isset($_POST['post_type']) && 'ct_pf_item' == $_POST['post_type']) {
		if(!current_user_can('edit_page', $post_id)) {
			return;
		}
	} else {
		if(!current_user_can('edit_post', $post_id)) {
			return;
		}
	}

	if(!isset($_POST['ct_portfolio_item_data']) || !is_array($_POST['ct_portfolio_item_data'])) {
		return;
	}

	$portfolio_item_data = ct_get_sanitize_pf_item_data(0, $_POST['ct_portfolio_item_data']);
	update_post_meta($post_id, 'ct_portfolio_item_data', $portfolio_item_data);
}
add_action('save_post', 'ct_portfolio_item_save_meta_box_data');

function ct_get_sanitize_pf_item_data($post_id = 0, $item_data = array()) {
	global $PORTFOLIO_TYPE_OPTIONS;

	$portfolio_item_data = array(
		'fullwidth' => 0,
		'highlight' => 0,
		'highlight_type' => '',
		'overview_title' => '',
		'project_link' => '',
		'project_text' => '',
		'back_url' => '',
		'types' => array()
	);
	if(is_array($item_data) && !empty($item_data)) {
		$portfolio_item_data = array_merge($item_data);
	} elseif($post_id != 0) {
		$portfolio_item_data = ct_get_post_data($portfolio_item_data, 'portfolio_item', $post_id);
	}
	$portfolio_item_data['fullwidth'] = $portfolio_item_data['fullwidth'] ? 1 : 0;
	$portfolio_item_data['highlight'] = $portfolio_item_data['highlight'] ? 1 : 0;
	$portfolio_item_data['highlight_type'] = ct_check_array_value(array('squared', 'horizontal', 'vertical'), $portfolio_item_data['highlight_type'], 'squared');
	$portfolio_item_data['overview_title'] = sanitize_text_field($portfolio_item_data['overview_title']);
	$portfolio_item_data['project_link'] = esc_url($portfolio_item_data['project_link']);
	$portfolio_item_data['project_text'] = sanitize_text_field($portfolio_item_data['project_text']);
	$portfolio_item_data['back_url'] = esc_url($portfolio_item_data['back_url']);
	if (isset($portfolio_item_data['types']['%INDEX%']))
		unset($portfolio_item_data['types']['%INDEX%']);
	
	$portfolio_item_data_types = array();
	foreach ($portfolio_item_data['types'] as $k => $v) {
		$v['link_target'] = ct_check_array_value(array('_blank', '_self'), $v['link_target'], '_self');
		$portfolio_type_options = array_keys($PORTFOLIO_TYPE_OPTIONS);
		$v['type'] = ct_check_array_value($portfolio_type_options, $v['type'], 'self-link');
		if (!in_array($v['type'], array('youtube', 'vimeo')))
			$v['link'] = esc_url($v['link']);

		$portfolio_item_data_types[] = $v;
	}
	$portfolio_item_data['types'] = array_slice($portfolio_item_data_types, 0, 4);
	
	return $portfolio_item_data;
}

add_action('ct_portfolios_edit_form','ct_portfolios_form');
add_action('ct_portfolios_add_form','ct_portfolios_form');

function ct_portfolios_form() {
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
}

function ct_portfolios_edit_form_fields() {
?>
	<tr class="form-field">
		<th valign="top" scope="row"><label for="portfoliosets_icon_pack"><?php _e('Icon Pack', 'ct'); ?></label></th>
		<td>
			<?php ct_print_select_input(ct_icon_packs_select_array(), esc_attr(get_option('portfoliosets_' . $_REQUEST['tag_ID'] . '_icon_pack')), 'portfoliosets_icon_pack', 'portfoliosets_icon_pack'); ?><br />
		</td>
	</tr>
	<tr class="form-field">
		<th valign="top" scope="row"><label for="portfoliosets_icon"><?php _e('Icon', 'ct'); ?></label></th>
		<td>
			<input class= "icon" type="text" id="portfoliosets_icon" name="portfoliosets_icon" value="<?php echo esc_attr(get_option('portfoliosets_' . $_REQUEST['tag_ID'] . '_icon')); ?>"/><br />
			<span class="description"><?php echo ct_icon_packs_infos(); ?></span>
		</td>
	</tr>
	<tr class="form-field">
		<th valign="top" scope="row"><label for="portfoliosets_order"><?php _e('Order', 'ct'); ?></label></th>
		<td>
			<input type="text" id="portfoliosets_order" name="portfoliosets_order" value="<?php echo esc_attr(get_option('portfoliosets_' . $_REQUEST['tag_ID'] . '_order', 0)); ?>"/><br />
		</td>
	</tr>
<?php
}
add_action('ct_portfolios_edit_form_fields','ct_portfolios_edit_form_fields');

function ct_portfolios_add_form_fields() {
?>
	<div class="form-field">
		<label for="portfoliosets_icon"><?php _e('Icon Pack', 'ct'); ?></label>
		<?php ct_print_select_input(ct_icon_packs_select_array(), 'elegant', 'portfoliosets_icon_pack', 'portfoliosets_icon_pack'); ?><br />
	</div>
	<div class="form-field">
		<label for="portfoliosets_icon"><?php _e('Icon', 'ct'); ?></label>
		<input class= "icon" type="text" id="portfoliosets_icon" name="portfoliosets_icon"/><br/>
		<?php echo ct_icon_packs_infos(); ?>
	</div>
	<div class="form-field">
		<label for="portfoliosets_order"><?php _e('Order', 'ct'); ?></label>
		<input class= "icon" type="text" id="portfoliosets_order" name="portfoliosets_order" value="0"/><br/>
	</div>
<?php
}
add_action('ct_portfolios_add_form_fields','ct_portfolios_add_form_fields');

function ct_portfolios_create($id) {
	if(isset($_REQUEST['portfoliosets_icon_pack'])) {
		update_option( 'portfoliosets_' . $id . '_icon_pack', $_REQUEST['portfoliosets_icon_pack'] );
	}
	if(isset($_REQUEST['portfoliosets_icon'])) {
		update_option( 'portfoliosets_' . $id . '_icon', $_REQUEST['portfoliosets_icon'] );
	}
	$order = isset($_REQUEST['portfoliosets_order']) ? intval($_REQUEST['portfoliosets_order']) : 0;
	update_option( 'portfoliosets_' . $id . '_order', $order );
}
add_action('create_ct_portfolios','ct_portfolios_create');

function ct_portfolios_update($id) {
	if(isset($_REQUEST['portfoliosets_icon_pack'])) {
		update_option( 'portfoliosets_' . $id . '_icon_pack', $_REQUEST['portfoliosets_icon_pack'] );
	}
	if(isset($_REQUEST['portfoliosets_icon'])) {
		update_option( 'portfoliosets_' . $id . '_icon', $_REQUEST['portfoliosets_icon'] );
	}
	$order = isset($_REQUEST['portfoliosets_order']) ? intval($_REQUEST['portfoliosets_order']) : 0;
	update_option( 'portfoliosets_' . $id . '_order', $order );
}
add_action('edit_ct_portfolios','ct_portfolios_update');

function ct_portfolios_delete($id) {
	delete_option( 'portfoliosets_' . $id . '_icon_pack' );
	delete_option( 'portfoliosets_' . $id . '_icon' );
	delete_option( 'portfoliosets_' . $id . '_order' );
}
add_action('delete_ct_portfolios','ct_portfolios_delete');

function portfolio_load_more_callback() {
	$response = array();
	if ( !isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'portfolio_ajax-nonce' ) ) {
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
	ct_portfolio($data);
	$response['html'] = trim(preg_replace('/\s\s+/', '', ob_get_clean()));
	$response = json_encode($response);
	header( "Content-Type: application/json" );
	echo $response;
	exit;
}
add_action('wp_ajax_portfolio_load_more', 'portfolio_load_more_callback');
add_action('wp_ajax_nopriv_portfolio_load_more', 'portfolio_load_more_callback');
