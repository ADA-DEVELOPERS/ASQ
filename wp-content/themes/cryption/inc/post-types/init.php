<?php

function cryption_get_post_data($default = array(), $post_data_name = '', $post_id = 0) {
	$post_data = get_post_meta($post_id, 'ct_'.$post_data_name.'_data', true);
	if(!is_array($default)) {
		return apply_filters('ct_get_post_data', array(), $post_id, $post_data_name);;
	}
	if(!is_array($post_data)) {
		return apply_filters('ct_get_post_data', $default, $post_id, $post_data_name);
	}
	return apply_filters('ct_get_post_data', array_merge($default, $post_data), $post_id, $post_data_name);
}

/* PAGE OPTIONS */

/* Additional page options */
add_action('add_meta_boxes', 'cryption_add_page_settings_boxes');
function cryption_add_page_settings_boxes() {
	$post_types = array('post', 'page', 'ct_pf_item', 'ct_news');
	foreach($post_types as $post_type) {
		add_meta_box('cryption_page_title', esc_html__('Page Title', 'cryption'), 'cryption_page_title_settings_box', $post_type, 'normal', 'high');
		add_meta_box('cryption_page_header', esc_html__('Page Header', 'cryption'), 'cryption_page_header_settings_box', $post_type, 'normal', 'high');
		add_meta_box('cryption_page_sidebar', esc_html__('Page Sidebar', 'cryption'), 'cryption_page_sidebar_settings_box', $post_type, 'normal', 'high');
		if(cryption_is_plugin_active('ct-elements/ct-elements.php')) {
			add_meta_box('cryption_page_slideshow', esc_html__('Page Slideshow', 'cryption'), 'cryption_page_slideshow_settings_box', $post_type, 'normal', 'high');
		}
		add_meta_box('cryption_page_effects', esc_html__('Additional Options', 'cryption'), 'cryption_page_effects_settings_box', $post_type, 'normal', 'high');
		add_meta_box('cryption_page_preloader', esc_html__('Page Preloader', 'cryption'), 'cryption_page_preloader_settings_box', $post_type, 'normal', 'high');
	}
	add_meta_box('cryption_page_title', esc_html__('Page Title', 'cryption'), 'cryption_page_title_settings_box', 'product', 'normal', 'high');
	add_meta_box('cryption_page_sidebar', esc_html__('Page Sidebar', 'cryption'), 'cryption_page_sidebar_settings_box', 'product', 'normal', 'high');\
	add_meta_box('cryption_page_sidebar', esc_html__('Additional Options', 'cryption'), 'cryption_page_effects_settings_box', 'product', 'normal', 'high');
	add_meta_box('cryption_product_size_guide', esc_html__('Size Guide', 'cryption'), 'cryption_product_size_guide_settings_box', 'product', 'normal', 'high');
	add_meta_box('cryption_post_item_settings', esc_html__('Blog Item Settings', 'cryption'), 'cryption_post_item_settings_box', 'post', 'normal', 'high');
}

/* Title box */
function cryption_page_title_settings_box($post) {
	wp_nonce_field('cryption_page_title_settings_box', 'cryption_page_title_settings_box_nonce');
	$page_data = cryption_get_sanitize_page_title_data($post->ID);
	$video_background_types = array('' => esc_html__('None', 'cryption'), 'youtube' => esc_html__('YouTube', 'cryption'), 'vimeo' => esc_html__('Vimeo', 'cryption'), 'self' => esc_html__('Self-Hosted Video', 'cryption'));
	$title_styles = array('1' => esc_html__('Enable', 'cryption'), '' => esc_html__('Disable', 'cryption'));
	$icon_styles = array('' => esc_html__('None', 'cryption'), 'angle-45deg-l' => esc_html__('45&deg; Left', 'cryption'), 'angle-45deg-r' => esc_html__('45&deg; Right', 'cryption'), 'angle-90deg' => esc_html__('90&deg;', 'cryption'));
	$title_background_image_items = array('1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg');
?>
<div class="ct-title-settings">
<fieldset>
	<legend><?php esc_html_e('Style &amp; Alignment', 'cryption'); ?></legend>
	<table class="settings-box-table" width="100%"><tbody><tr>
		<td>
			<label for="page_title_style"><?php esc_html_e('Enable Page Title', 'cryption'); ?>:</label><br />
			<?php cryption_print_select_input($title_styles, $page_data['title_style'], 'ct_page_data[title_style]', 'page_title_style'); ?><br />
			<br />
			<label for="page_title_alignment"><?php esc_html_e('Alignment', 'cryption'); ?>:</label><br />
			<?php cryption_print_select_input(array('center' => esc_html__('Center', 'cryption'), 'left' => esc_html__('Left', 'cryption'), 'right' => esc_html__('Right', 'cryption')), $page_data['title_alignment'], 'ct_page_data[title_alignment]', 'page_title_alignment'); ?>
		</td>
		<td>
			<label for="page_title_padding_top"><?php esc_html_e('Padding Top', 'cryption'); ?>:</label><br />
			<input type="number" name="ct_page_data[title_padding_top]" id="page_title_padding_top" value="<?php echo esc_attr($page_data['title_padding_top']); ?>" min="0" /><br />
			<br />
			<label for="page_title_padding_bottom"><?php esc_html_e('Padding Bottom', 'cryption'); ?>:</label><br />
			<input type="number" name="ct_page_data[title_padding_bottom]" id="page_title_title_padding_bottom" value="<?php echo esc_attr($page_data['title_padding_bottom']); ?>" min="0" />		</td>
	</tr></tbody></table>
</fieldset>
<fieldset>
	<legend><?php esc_html_e('Rich Content Title', 'cryption'); ?></legend>
	<table class="settings-box-table" width="100%"><tbody><tr>
		<td>
			<input name="ct_page_data[title_rich_content]" type="checkbox" id="page_title_rich_content" value="1" <?php checked($page_data['title_rich_content'], 1); ?> />
			<label for="page_title_rich_content"><?php esc_html_e('Use rich content title', 'cryption'); ?></label><br /><br />
			<?php wp_editor(htmlspecialchars_decode($page_data['title_content']), 'page_title_content', array(
				'textarea_name' => 'ct_page_data[title_content]',
				'quicktags' => array('buttons' => 'em,strong,link'),
				'editor_height' => '100',
				'tinymce' => array(
					'theme_advanced_buttons1' => 'bold,italic,strikethrough,separator,bullist,numlist,separator,blockquote,separator,justifyleft,justifycenter,justifyright,separator,link,unlink,separator,undo,redo,separator',
					'theme_advanced_buttons2' => '',
				),
				'editor_css' => '<style>#wp-excerpt-editor-container .wp-editor-area{height:175px; width:100%;}</style>'
			)); ?>
		</td>
	</tr></tbody></table>
</fieldset>
<fieldset>
	<legend><?php esc_html_e('Title &amp; Excerpt', 'cryption'); ?></legend>
	<table class="settings-box-table" width="100%"><tbody><tr>
		<td>
			<label for="page_title_text_color"><?php esc_html_e('Title Text Color', 'cryption'); ?>:</label><br />
			<input type="text" name="ct_page_data[title_text_color]" id="page_title_text_color" value="<?php echo esc_attr($page_data['title_text_color']); ?>" class="color-select" /><br />
			<br />
			<input name="ct_page_data[title_hide_excerpt]" type="checkbox" id="page_title_hide_excerpt" value="1" <?php checked($page_data['title_hide_excerpt'], 1); ?> />
			<label for="page_title_hide_excerpt"><?php esc_html_e('Hide Excerpt', 'cryption'); ?></label><br />
			<br />
			<label for="page_title_excerpt_text_color"><?php esc_html_e('Excerpt Color', 'cryption'); ?>:</label><br />
			<input type="text" name="ct_page_data[title_excerpt_text_color]" id="page_title_excerpt_text_color" value="<?php echo esc_attr($page_data['title_excerpt_text_color']); ?>" class="color-select" /><br />
			<br />
			<label for="page_title_excerpt"><?php esc_html_e('Excerpt', 'cryption'); ?>:</label><br />
			<textarea name="ct_page_data[title_excerpt]" id="page_title_excerpt" style="width: 100%;" rows="3"><?php echo esc_textarea($page_data['title_excerpt']); ?></textarea><br />
			<br />
		</td>
		<td>
			<label for="page_title_title_width"><?php esc_html_e('Title Max Width', 'cryption'); ?>:</label><br />
			<input type="number" name="ct_page_data[title_title_width]" id="page_title_title_width" value="<?php echo esc_attr($page_data['title_title_width']); ?>" min="0" /><br />
			<br />
			<label for="page_title_excerpt_width"><?php esc_html_e('Excerpt Max Width', 'cryption'); ?>:</label><br />
			<input type="number" name="ct_page_data[title_excerpt_width]" id="page_title_excerpt_width" value="<?php echo esc_attr($page_data['title_excerpt_width']); ?>" min="0" /><br />
			<br />
			<label for="page_title_top_margin"><?php esc_html_e('Title Top Margin', 'cryption'); ?>:</label><br />
			<input type="number" name="ct_page_data[title_top_margin]" id="page_title_top_margin" value="<?php echo esc_attr($page_data['title_top_margin']); ?>" /><br />
			<br />
			<label for="page_title_excerpt_top_margin"><?php esc_html_e('Excerpt Top Margin', 'cryption'); ?>:</label><br />
			<input type="number" name="ct_page_data[title_excerpt_top_margin]" id="page_title_title_excerpt_top_margin" value="<?php echo esc_attr($page_data['title_excerpt_top_margin']); ?>" />
		</td>
	</tr></tbody></table>
</fieldset>
<fieldset>
	<legend><?php esc_html_e('Background', 'cryption'); ?></legend>
	<table class="settings-box-table" width="100%"><tbody><tr>
		<td>
			<label for="page_title_background_image"><?php esc_html_e('Background Image', 'cryption'); ?>:</label><br />
			<input type="text" name="ct_page_data[title_background_image]" id="page_title_background_image" value="<?php echo esc_attr($page_data['title_background_image']); ?>" class="picture-select" /><br />
			<span id="page_title_background_image_select" style="display: block;">
				<?php foreach($title_background_image_items as $item) : ?>
					<a href="<?php echo esc_url(get_template_directory_uri() . '/images/backgrounds/title/' . $item); ?>" style="background-image: url('<?php echo esc_url(get_template_directory_uri() . '/images/backgrounds/title/' . $item); ?>')"></a>
				<?php endforeach; ?>
			</span>
			<br />
			<label for="page_title_background_color"><?php esc_html_e('Background Color', 'cryption'); ?>:</label><br />
			<input type="text" name="ct_page_data[title_background_color]" id="page_title_background_color" value="<?php echo esc_attr($page_data['title_background_color']); ?>" class="color-select" />
		</td>
	</tr></tbody></table>
</fieldset>
<?php if(cryption_is_plugin_active('ct-elements/ct-elements.php')) : ?>
<fieldset>
	<legend><?php esc_html_e('Icon', 'cryption'); ?></legend>
	<table class="settings-box-table" width="100%"><tbody><tr>
		<td>
			<label for="page_title_icon_pack"><?php esc_html_e('Icon Pack', 'cryption'); ?>:</label><br />
			<?php cryption_print_select_input(cryption_icon_packs_select_array(), $page_data['title_icon_pack'], 'ct_page_data[title_icon_pack]', 'page_title_icon_pack'); ?><br />
			<br />
			<?php
				add_thickbox();
				wp_enqueue_style('icons-elegant');
				wp_enqueue_style('icons-material');
				wp_enqueue_style('icons-fontawesome');
				wp_enqueue_style('icons-userpack');
				wp_enqueue_script('ct-icons-picker');
			?>
			<label for="page_title_icon"><?php esc_html_e('Icon', 'cryption'); ?>:</label><br />
			<input name="ct_page_data[title_icon]" type="text" id="page_title_icon" value="<?php echo esc_attr($page_data['title_icon']); ?>" class="icons-picker" /><br />
			<br />
			<label for="page_title_icon_color"><?php esc_html_e('Icon Color', 'cryption'); ?>:</label><br />
			<input name="ct_page_data[title_icon_color]" type="text" id="page_title_icon_color" value="<?php echo esc_attr($page_data['title_icon_color']); ?>" class="color-select" /><br />
			<br />
			<label for="page_title_icon_color_2"><?php esc_html_e('Icon Color 2', 'cryption'); ?>:</label><br />
			<input name="ct_page_data[title_icon_color_2]" type="text" id="page_title_icon_color_2" value="<?php echo esc_attr($page_data['title_icon_color_2']); ?>" class="color-select" /><br />
			<br />
			<label for="page_title_icon_style"><?php esc_html_e('Icon Style', 'cryption'); ?>:</label><br />
			<?php cryption_print_select_input($icon_styles, esc_attr($page_data['title_icon_style']), 'ct_page_data[title_icon_style]', 'page_title_icon_style'); ?>
		</td>
		<td>
			<label for="page_title_icon_background_color"><?php esc_html_e('Icon Background Color', 'cryption'); ?>:</label><br />
			<input name="ct_page_data[title_icon_background_color]" type="text" id="page_title_icon_background_color" value="<?php echo esc_attr($page_data['title_icon_background_color']); ?>" class="color-select" /><br />
			<br />
			<label for="page_title_icon_border_color"><?php esc_html_e('Icon Border Color', 'cryption'); ?>:</label><br />
			<input name="ct_page_data[title_icon_border_color]" type="text" id="page_title_icon_border_color" value="<?php echo esc_attr($page_data['title_icon_border_color']); ?>" class="color-select" /><br />
			<br />
			<label for="page_title_icon_shape"><?php esc_html_e('Icon Shape', 'cryption'); ?>:</label><br />
			<?php cryption_print_select_input(array('circle' => esc_html__('Circle', 'cryption'), 'square' => esc_html__('Square', 'cryption'), 'romb' => esc_html__('Rhombus', 'cryption'), 'hexagon' => esc_html__('Hexagon', 'cryption')), $page_data['title_icon_shape'], 'ct_page_data[title_icon_shape]', 'page_title_icon_shape'); ?><br />
			<br />
			<label for="page_title_icon_size"><?php esc_html_e('Icon Size', 'cryption'); ?>:</label><br />
			<?php cryption_print_select_input(array('small' => esc_html__('Small', 'cryption'), 'medium' => esc_html__('Medium', 'cryption'), 'large' => esc_html__('Large', 'cryption'), 'xlarge' => esc_html__('Extra Large', 'cryption')), $page_data['title_icon_size'], 'ct_page_data[title_icon_size]', 'page_title_icon_size'); ?>
		</td>
	</tr></tbody></table>
</fieldset>
<?php endif; ?>
<fieldset>
	<legend><?php esc_html_e('Video Background', 'cryption'); ?></legend>
	<table class="settings-box-table" width="100%"><tbody><tr>
		<td>
			<label for="page_title_video_type"><?php esc_html_e('Video Background Type', 'cryption'); ?>:</label><br />
			<?php cryption_print_select_input($video_background_types, esc_attr($page_data['title_video_type']), 'ct_page_data[title_video_type]', 'page_title_video_type'); ?><br />
			<br />
			<label for="page_title_video"><?php esc_html_e('Link to video or video ID (for YouTube or Vimeo)', 'cryption'); ?>:</label><br />
			<input type="text" name="ct_page_data[title_video_background]" id="page_title_video_background" value="<?php echo esc_attr($page_data['title_video_background']); ?>" class="video-select" /><br />
			<br />
			<label for="page_title_video_aspect_ratio"><?php esc_html_e('Video Background Aspect Ratio (16:9, 16:10, 4:3...)', 'cryption'); ?>:</label><br />
			<input type="text" name="ct_page_data[title_video_aspect_ratio]" id="page_title_video_aspect_ratio" value="<?php echo esc_attr($page_data['title_video_aspect_ratio']); ?>" />
			</td>
			<td>
			<label for="page_title_video_overlay_color"><?php esc_html_e('Video Overlay Color', 'cryption'); ?>:</label><br />
			<input type="text" name="ct_page_data[title_video_overlay_color]" id="page_title_video_overlay_color" value="<?php echo esc_attr($page_data['title_video_overlay_color']); ?>" class="color-select" /><br />
			<br />
			<label for="page_title_video_overlay_opacity"><?php esc_html_e('Video Overlay Opacity (0 - 1)', 'cryption'); ?>:</label><br />
			<input type="text" name="ct_page_data[title_video_overlay_opacity]" id="page_title_video_overlay_opacity" value="<?php echo esc_attr($page_data['title_video_overlay_opacity']); ?>" /><br />
			<br />
			<label for="page_title_video_poster"><?php esc_html_e('Video Poster', 'cryption'); ?>:</label><br />
			<input type="text" name="ct_page_data[title_video_poster]" id="page_title_video_poster" value="<?php echo esc_attr($page_data['title_video_poster']); ?>" class="picture-select" />
		</td>
	</tr></tbody></table>
</fieldset>
</div>
<?php
}

function cryption_page_header_settings_box($post) {
	wp_nonce_field('cryption_page_header_settings_box', 'cryption_page_header_settings_box_nonce');
	$page_data = cryption_get_sanitize_page_header_data($post->ID);
?>
<table class="settings-box-table" width="100%"><tbody><tr>
	<td>
		<input name="ct_page_data[header_transparent]" type="checkbox" id="page_header_transparent" value="1" <?php checked($page_data['header_transparent'], 1); ?> />
		<label for="page_header_transparent"><?php esc_html_e('Transparent Menu On Header', 'cryption'); ?></label><br /><br />
		<label for="page_header_opacity"><?php esc_html_e('Header Opacity (0-100%)', 'cryption'); ?>:</label><br />
		<input type="text" name="ct_page_data[header_opacity]" id="page_header_opacity" value="<?php echo esc_attr($page_data['header_opacity']); ?>" /><br /><br />
		<input name="ct_page_data[header_menu_logo_light]" type="checkbox" id="page_header_menu_logo_light" value="1" <?php checked($page_data['header_menu_logo_light'], 1); ?> />
		<label for="page_header_menu_logo_light"><?php esc_html_e('Use Light Menu &amp; Logo', 'cryption'); ?></label><br />
		<br />
		<input name="ct_page_data[header_hide_top_area]" type="checkbox" id="page_header_hide_top_area" value="1" <?php checked($page_data['header_hide_top_area'], 1); ?> />
		<label for="page_header_hide_top_area"><?php esc_html_e('Hide Top Area', 'cryption'); ?></label>
	</td>
</tr></tbody></table>
<?php
}

/* Effects box */
function cryption_page_effects_settings_box($post) {
	wp_nonce_field('cryption_page_effects_settings_box', 'cryption_page_effects_settings_box_nonce');
	$page_data = cryption_get_sanitize_page_effects_data($post->ID);
	$is_woo_shop = false;
	if(function_exists('wc_get_page_id') && wc_get_page_id('shop') === $post->ID) {
		$is_woo_shop = true;
	}
?>
<table class="settings-box-table"><tbody><tr>
	<td>
		<input name="ct_page_data[effects_one_pager]" type="checkbox" id="page_effects_one_pager" value="1" <?php checked($page_data['effects_one_pager'], 1); ?> />
		<label for="page_effects_one_pager"><?php esc_html_e('Page as One-Pager', 'cryption'); ?></label>
		<br /><br />
		<input name="ct_page_data[effects_parallax_footer]" type="checkbox" id="page_effects_parallax_footer" value="1" <?php checked($page_data['effects_parallax_footer'], 1); ?> />
		<label for="page_effects_parallax_footer"><?php esc_html_e('Parallax Footer', 'cryption'); ?></label>
	</td>
	<td>
		<input name="ct_page_data[effects_no_top_margin]" type="checkbox" id="page_effects_no_top_margin" value="1" <?php checked($page_data['effects_no_top_margin'], 1); ?> />
		<label for="page_effects_no_top_margin"><?php esc_html_e('Disable top margin', 'cryption'); ?></label><br /><br />
		<input name="ct_page_data[effects_no_bottom_margin]" type="checkbox" id="page_effects_no_bottom_margin" value="1" <?php checked($page_data['effects_no_bottom_margin'], 1); ?> />
		<label for="page_effects_no_bottom_margin"><?php esc_html_e('Disable bottom margin', 'cryption'); ?></label>
	</td>
	<td>
		<input name="ct_page_data[effects_disabled]" type="checkbox" id="page_effects_disabled" value="1" <?php checked($page_data['effects_disabled'], 1); ?> />
		<label for="page_effects_disabled"><?php esc_html_e('Lazy loading disabled', 'cryption'); ?></label><br /><br />
		<input name="ct_page_data[redirect_to_subpage]" type="checkbox" id="page_redirect_to_subpage" value="1" <?php checked($page_data['redirect_to_subpage'], 1); ?> />
		<label for="page_redirect_to_subpage"><?php esc_html_e('Redirect to subpage', 'cryption'); ?></label>
	</td>
	<td>
		<input name="ct_page_data[effects_hide_header]" type="checkbox" id="page_effects_hide_header" value="1" <?php checked($page_data['effects_hide_header'], 1); ?> />
		<label for="page_effects_hide_header"><?php esc_html_e('Hide Header', 'cryption'); ?></label><br /><br />
		<input name="ct_page_data[effects_hide_footer]" type="checkbox" id="page_effects_hide_footer" value="1" <?php checked($page_data['effects_hide_footer'], 1); ?> />
		<label for="page_effects_hide_footer"><?php esc_html_e('Hide Footer', 'cryption'); ?></label>
	</td>
</tr></tbody></table>
<?php
}

/* Page Preloader box */
function cryption_page_preloader_settings_box($post) {
	wp_nonce_field('cryption_page_preloader_settings_box', 'cryption_page_preloader_settings_box_nonce');
	$page_data = cryption_get_sanitize_page_preloader_data($post->ID);
?>
<input name="ct_page_data[enable_page_preloader]" type="checkbox" id="enable_page_preloader" value="1" <?php checked($page_data['enable_page_preloader'], 1); ?> />
<label for="enable_page_preloader"><?php esc_html_e('Enable Page Preloader', 'cryption'); ?></label>
<?php
}

/* Slideshows box */
function cryption_page_slideshow_settings_box($post) {
	wp_nonce_field('cryption_page_slideshow_settings_box', 'cryption_page_slideshow_settings_box_nonce');
	$page_data = cryption_get_sanitize_page_slideshow_data($post->ID);
	$slideshow_types = array('' => esc_html__('None', 'cryption'), 'NivoSlider' => 'NivoSlider');
	$slideshows_terms = get_terms('ct_slideshows', array('hide_empty' => false));
	$slideshows = array('' => esc_html__('All Slides', 'cryption'));
	foreach($slideshows_terms as $term) {
		$slideshows[$term->slug] = $term->name;
	}
	$layersliders = array();
	if(cryption_is_plugin_active('LayerSlider/layerslider.php')) {
		$slideshow_types['LayerSlider'] = 'LayerSlider';
		global $wpdb;
		$table_name = $wpdb->prefix . "layerslider";
		$query_results = $wpdb->get_results($wpdb->prepare("SELECT * FROM %s WHERE flag_hidden = '0' AND flag_deleted = '0' ORDER BY id ASC", $table_name));
		foreach($query_results as $query_result) {
			$layersliders[$query_result->id] = $query_result->name;
		}
	}
	$revsliders = array();
	if(cryption_is_plugin_active('revslider/revslider.php')) {
		$slideshow_types['revslider'] = 'Revolution Slider';
		$slider = new RevSlider();
		$arrSliders = $slider->getArrSliders();
		foreach($arrSliders as $arrSlider) {
			$revsliders[$arrSlider->getAlias()] = $arrSlider->getTitle();
		}
	}
?>
<table class="settings-box-table"><tbody><tr>
	<td>
		<label for="page_slideshow_type"><?php esc_html_e('Slideshow Type', 'cryption'); ?>:</label><br />
		<?php cryption_print_select_input($slideshow_types, $page_data['slideshow_type'], 'ct_page_data[slideshow_type]', 'page_slideshow_type'); ?><br />
		<br />
		<div class="slideshow-select NivoSlider">
			<label for="page_slideshow_slideshow"><?php esc_html_e('Select Slideshow', 'cryption'); ?>:</label><br />
			<?php cryption_print_select_input($slideshows, $page_data['slideshow_slideshow'], 'ct_page_data[slideshow_slideshow]', 'page_slideshow_slideshow'); ?><br />
		</div>
		<?php if(cryption_is_plugin_active('LayerSlider/layerslider.php')) : ?>
			<div class="slideshow-select LayerSlider">
				<label for="page_slideshow_layerslider"><?php esc_html_e('Select LayerSlider', 'cryption'); ?>:</label><br />
				<?php cryption_print_select_input($layersliders, $page_data['slideshow_layerslider'], 'ct_page_data[slideshow_layerslider]', 'page_slideshow_layerslider'); ?><br />
			</div>
		<?php endif; ?>
		<?php if(cryption_is_plugin_active('revslider/revslider.php')) : ?>
			<div class="slideshow-select revslider">
				<label for="page_slideshow_revslider"><?php esc_html_e('Select Revolution Slider', 'cryption'); ?>:</label><br />
				<?php cryption_print_select_input($revsliders, $page_data['slideshow_revslider'], 'ct_page_data[slideshow_revslider]', 'page_slideshow_revslider'); ?><br />
			</div>
		<?php endif; ?>
	</td>
</tr></tbody></table>
<?php
}

/* Sidebar box */
function cryption_page_sidebar_settings_box($post) {
	wp_nonce_field('cryption_page_sidebar_settings_box', 'cryption_page_sidebar_settings_box_nonce');
	$page_data = cryption_get_sanitize_page_sidebar_data($post->ID);
	$sidebar_positions = array('' => esc_html__('None', 'cryption'), 'left' => esc_html__('Left', 'cryption'), 'right' => esc_html__('Right', 'cryption'));
?>
<table class="settings-box-table"><tbody><tr>
	<td>
		<label for="page_sidebar_position"><?php esc_html_e('Sidebar Position', 'cryption'); ?>:</label><br />
		<?php cryption_print_select_input($sidebar_positions, $page_data['sidebar_position'], 'ct_page_data[sidebar_position]', 'page_sidebar_position'); ?><br />
	</td>
	<td>
		<input name="ct_page_data[sidebar_sticky]" type="checkbox" id="page_sidebar_sticky" value="1" <?php checked($page_data['sidebar_sticky'], 1); ?> />
		<label for="page_sidebar_sticky"><?php esc_html_e('Sticky sidebar', 'cryption'); ?></label>
	</td>
</tr></tbody></table>
<?php
}

function cryption_post_item_settings_box($post) {
	wp_nonce_field('cryption_post_item_settings_box', 'cryption_post_item_settings_box_nonce');
	$post_item_data = cryption_get_sanitize_post_data($post->ID);
	$video_background_types = array('youtube' => esc_html__('YouTube', 'cryption'), 'vimeo' => esc_html__('Vimeo', 'cryption'), 'self' => esc_html__('Self-Hosted Video', 'cryption'));
?>
<div class="ct-title-settings">
<fieldset>
	<legend><?php esc_html_e('Featured Image', 'cryption'); ?></legend>
	<table class="settings-box-table"><tbody><tr>
		<td>
			<input name="ct_post_item_data[show_featured_content]" type="checkbox" id="post_item_show_featured_content" value="1" <?php checked($post_item_data['show_featured_content'], 1); ?> />
			<label for="post_item_show_featured_content"><?php esc_html_e('Show Featured Content', 'cryption'); ?></label>
		</td>
	</tr></tbody></table>
</fieldset>
<fieldset>
	<legend><?php esc_html_e('For Video Post', 'cryption'); ?></legend>
	<table class="settings-box-table" width="100%"><tbody><tr>
		<td>
			<label for="post_item_video_type"><?php esc_html_e('Video Type', 'cryption'); ?>:</label><br />
			<?php cryption_print_select_input($video_background_types, esc_attr($post_item_data['video_type']), 'ct_post_item_data[video_type]', 'post_item_video_type'); ?><br />
			<br />
			<label for="post_item_video"><?php esc_html_e('Link to video or video ID (for YouTube or Vimeo)', 'cryption'); ?>:</label><br />
			<input type="text" name="ct_post_item_data[video]" id="post_item_video" value="<?php echo esc_attr($post_item_data['video']); ?>" class="video-select" /><br />
			<br />
			<label for="post_item_video_aspect_ratio"><?php esc_html_e('Video Background Aspect Ratio (16:9, 16:10, 4:3...)', 'cryption'); ?>:</label><br />
			<input type="text" name="ct_post_item_data[video_aspect_ratio]" id="post_item_video_aspect_ratio" value="<?php echo esc_attr($post_item_data['video_aspect_ratio']); ?>" />
		</td>
	</tr></tbody></table>
</fieldset>
<fieldset>
	<legend><?php esc_html_e('For Quote Post', 'cryption'); ?></legend>
	<table class="settings-box-table" width="100%"><tbody><tr>
		<td>
			<label for="post_item_quote_text"><?php esc_html_e('Quote Text', 'cryption'); ?>:</label><br />
			<?php wp_editor($post_item_data['quote_text'], 'post_item_quote_text', array('textarea_name' => 'ct_post_item_data[quote_text]')); ?><br />
			<br />
			<label for="post_item_quote_author"><?php esc_html_e('Quote Author', 'cryption'); ?>:</label><br />
			<input type="text" name="ct_post_item_data[quote_author]" id="post_item_quote_author" value="<?php echo esc_attr($post_item_data['quote_author']); ?>" /><br />
			<br />
			<label for="post_item_video_quote_background"><?php esc_html_e('Background Color', 'cryption'); ?>:</label><br />
			<input type="text" name="ct_post_item_data[quote_background]" id="post_item_quote_background" value="<?php echo esc_attr($post_item_data['quote_background']); ?>" class="color-select" /><br />
			<br />
			<label for="post_item_video_quote_author_color"><?php esc_html_e('Author &amp; Link Color', 'cryption'); ?>:</label><br />
			<input type="text" name="ct_post_item_data[quote_author_color]" id="post_item_quote_author_color" value="<?php echo esc_attr($post_item_data['quote_author_color']); ?>" class="color-select" />
		</td>
	</tr></tbody></table>
</fieldset>
<fieldset>
	<legend><?php esc_html_e('For Audio Post', 'cryption'); ?></legend>
	<table class="settings-box-table" width="100%"><tbody><tr>
		<td>
			<label for="post_item_audio"><?php esc_html_e('Audio', 'cryption'); ?>:</label><br />
			<input type="text" name="ct_post_item_data[audio]" id="post_item_audio" value="<?php echo esc_attr($post_item_data['audio']); ?>" class="audio-select" />
		</td>
	</tr></tbody></table>
</fieldset>
<?php if(cryption_is_plugin_active('ct-elements/ct-elements.php')) : ?>
<fieldset>
	<legend><?php esc_html_e('For Gallery Post', 'cryption'); ?></legend>
	<table class="settings-box-table" width="100%"><tbody><tr>
		<td>
			<label for="post_item_gallery"><?php esc_html_e('Gallery', 'cryption'); ?>:</label><br />
			<?php cryption_print_select_input(ct_galleries_array(), esc_attr($post_item_data['gallery']), 'ct_post_item_data[gallery]', 'post_item_gallery'); ?><br />
			<br />
			<label for="post_item_gallery_autoscroll"><?php esc_html_e('Autoscroll (msec)', 'cryption'); ?>:</label><br />
			<input type="text" name="ct_post_item_data[gallery_autoscroll]" id="post_item_gallery_autoscroll" value="<?php echo esc_attr($post_item_data['gallery_autoscroll']); ?>" />
		</td>
	</tr></tbody></table>
</fieldset>
<?php endif; ?>
</div>
<?php
}

function cryption_save_page_data($post_id) {
	if(
		!isset($_POST['cryption_page_title_settings_box_nonce']) ||
		!isset($_POST['cryption_page_header_settings_box_nonce']) ||
		!isset($_POST['cryption_page_effects_settings_box_nonce']) ||
		(!isset($_POST['cryption_page_slideshow_settings_box_nonce']) && cryption_is_plugin_active('ct-elements/ct-elements.php')) ||
		!isset($_POST['cryption_page_sidebar_settings_box_nonce'])
	) {
		return;
	}
	if(
		!wp_verify_nonce($_POST['cryption_page_title_settings_box_nonce'], 'cryption_page_title_settings_box') ||
		!wp_verify_nonce($_POST['cryption_page_header_settings_box_nonce'], 'cryption_page_header_settings_box') ||
		!wp_verify_nonce($_POST['cryption_page_effects_settings_box_nonce'], 'cryption_page_effects_settings_box') ||
		(!wp_verify_nonce($_POST['cryption_page_slideshow_settings_box_nonce'], 'cryption_page_slideshow_settings_box') && cryption_is_plugin_active('ct-elements/ct-elements.php')) ||
		!wp_verify_nonce($_POST['cryption_page_sidebar_settings_box_nonce'], 'cryption_page_sidebar_settings_box')
	) {
		return;
	}

	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if(isset($_POST['post_type']) && in_array($_POST['post_type'], array('post', 'page', 'ct_pf_item', 'ct_news'))) {
		if(!current_user_can('edit_page', $post_id)) {
			return;
		}
	} else {
		if(!current_user_can('edit_post', $post_id)) {
			return;
		}
	}

	if(!isset($_POST['ct_page_data']) || !is_array($_POST['ct_page_data'])) {
		return;
	}

	$page_data = array_merge(
		cryption_get_sanitize_page_title_data(0, $_POST['ct_page_data']),
		cryption_get_sanitize_page_header_data(0, $_POST['ct_page_data']),
		cryption_get_sanitize_page_effects_data(0, $_POST['ct_page_data']),
		cryption_get_sanitize_page_preloader_data(0, $_POST['ct_page_data']),
		cryption_get_sanitize_page_slideshow_data(0, $_POST['ct_page_data']),
		cryption_get_sanitize_page_sidebar_data(0, $_POST['ct_page_data'])
	);
	update_post_meta($post_id, 'ct_page_data', $page_data);
}
add_action('save_post', 'cryption_save_page_data');

function cryption_get_sanitize_page_title_data($post_id = 0, $item_data = array()) {
	$page_data = apply_filters('ct_page_title_data_defaults', array(
		'title_style' => '1',
		'title_rich_content' => '',
		'title_content' => '',
		'title_background_image' => '',
		'title_background_color' => '',
		'title_video_type' => '',
		'title_video_background' => '',
		'title_video_aspect_ratio' => '',
		'title_video_overlay_color' => '',
		'title_video_overlay_opacity' => '',
		'title_video_poster' => '',
		'title_menu_on_video' => '',
		'title_text_color' => '',
		'title_hide_excerpt' => '',
		'title_excerpt_text_color' => '',
		'title_excerpt' => '',
		'title_title_width' => '',
		'title_excerpt_width' => '',
		'title_padding_top' => '80',
		'title_padding_bottom' => '80',
		'title_top_margin' => 0,
		'title_excerpt_top_margin' => 18,
		'title_alignment' => '',
		'title_icon_pack' => '',
		'title_icon' => '',
		'title_icon_color' => '',
		'title_icon_color_2' => '',
		'title_icon_background_color' => '',
		'title_icon_shape' => '',
		'title_icon_border_color' => '',
		'title_icon_size' => '',
		'title_icon_style' => '',
		'title_icon_opacity' => '',
	));
	if(is_array($item_data) && !empty($item_data)) {
		$page_data = array_merge($page_data, $item_data);
	} elseif($post_id != 0) {
		$page_data = cryption_get_post_data($page_data, 'page', $post_id);
	}
	$page_data['title_rich_content'] = $page_data['title_rich_content'] ? 1 : 0;
	$page_data['title_style'] = cryption_check_array_value(array('', '1', '2'), $page_data['title_style'], '1');
	$page_data['title_background_image'] = esc_url($page_data['title_background_image']);
	$page_data['title_background_color'] = sanitize_text_field($page_data['title_background_color']);
	$page_data['title_video_type'] = cryption_check_array_value(array('', 'youtube', 'vimeo', 'self'), $page_data['title_video_type'], '');
	$page_data['title_video_background'] = sanitize_text_field($page_data['title_video_background']);
	$page_data['title_video_aspect_ratio'] = sanitize_text_field($page_data['title_video_aspect_ratio']);
	$page_data['title_video_overlay_color'] = sanitize_text_field($page_data['title_video_overlay_color']);
	$page_data['title_video_overlay_opacity'] = sanitize_text_field($page_data['title_video_overlay_opacity']);
	$page_data['title_video_poster'] = esc_url($page_data['title_video_poster']);
	$page_data['title_text_color'] = sanitize_text_field($page_data['title_text_color']);
	$page_data['title_hide_excerpt'] = $page_data['title_hide_excerpt'] ? 1 : 0;
	$page_data['title_excerpt_text_color'] = sanitize_text_field($page_data['title_excerpt_text_color']);
	$page_data['title_excerpt'] = implode("\n", array_map('sanitize_text_field', explode("\n", $page_data['title_excerpt'])));
	$page_data['title_title_width'] = intval($page_data['title_title_width']) > 0 ? intval($page_data['title_title_width']) : 0;
	$page_data['title_excerpt_width'] = intval($page_data['title_excerpt_width']) > 0 ? intval($page_data['title_excerpt_width']) : 0;
	$page_data['title_top_margin'] = intval($page_data['title_top_margin']);
	$page_data['title_excerpt_top_margin'] = intval($page_data['title_excerpt_top_margin']);
	$page_data['title_padding_top'] = intval($page_data['title_padding_top']) >= 0 ? intval($page_data['title_padding_top']) : 0;
	$page_data['title_padding_bottom'] = intval($page_data['title_padding_bottom']) >= 0 ? intval($page_data['title_padding_bottom']) : 0;
	$page_data['title_icon_pack'] = cryption_check_array_value(array('elegant', 'material', 'fontawesome', 'userpack'), $page_data['title_icon_pack'], 'elegant');
	$page_data['title_icon'] = sanitize_text_field($page_data['title_icon']);
	$page_data['title_alignment'] = cryption_check_array_value(array('center', 'left', 'right'), $page_data['title_alignment'], 'center');
	$page_data['title_icon_color'] = sanitize_text_field($page_data['title_icon_color']);
	$page_data['title_icon_color_2'] = sanitize_text_field($page_data['title_icon_color_2']);
	$page_data['title_icon_background_color'] = sanitize_text_field($page_data['title_icon_background_color']);
	$page_data['title_icon_border_color'] = sanitize_text_field($page_data['title_icon_border_color']);
	$page_data['title_icon_shape'] = cryption_check_array_value(array('circle', 'square', 'romb', 'hexagon'), $page_data['title_icon_shape'], 'circle');
	$page_data['title_icon_size'] = cryption_check_array_value(array('small', 'medium', 'large', 'xlarge'), $page_data['title_icon_size'], 'large');
	$page_data['title_icon_style'] = cryption_check_array_value(array('', 'angle-45deg-r', 'angle-45deg-l', 'angle-90deg'), $page_data['title_icon_style'], '');
	$page_data['title_icon_opacity'] = floatval($page_data['title_icon_opacity']) >= 0 && floatval($page_data['title_icon_opacity']) <= 1 ? floatval($page_data['title_icon_opacity']) : 0;

	return $page_data;
}

function cryption_get_sanitize_page_header_data($post_id = 0, $item_data = array()) {
	$page_data = array(
		'header_transparent' => '',
		'header_opacity' => '',
		'header_menu_logo_light' => '',
		'header_hide_top_area' => '',
	);
	if(is_array($item_data) && !empty($item_data)) {
		$page_data = array_merge($page_data, $item_data);
	} elseif($post_id != 0) {
		$page_data = cryption_get_post_data($page_data, 'page', $post_id);
	}
	$page_data['header_transparent'] = $page_data['header_transparent'] ? 1 : 0;
	$page_data['header_opacity'] = intval($page_data['header_opacity']) >= 0 && intval($page_data['header_opacity']) <= 100 ? intval($page_data['header_opacity']) : 0;
	$page_data['header_menu_logo_light'] = $page_data['header_menu_logo_light'] ? 1 : 0;
	$page_data['header_hide_top_area'] = $page_data['header_hide_top_area'] ? 1 : 0;
	return $page_data;
}

function cryption_get_sanitize_page_effects_data($post_id = 0, $item_data = array()) {
	$page_data = array(
		'effects_disabled' => false,
		'effects_one_pager' => false,
		'effects_parallax_footer' => false,
		'effects_no_bottom_margin' => false,
		'effects_no_top_margin' => false,
		'redirect_to_subpage' => false,
		'effects_hide_header' => false,
		'effects_hide_footer' => false,
	);
	if(is_array($item_data) && !empty($item_data)) {
		$page_data = array_merge($page_data, $item_data);
	} elseif($post_id != 0) {
		$page_data = cryption_get_post_data($page_data, 'page', $post_id);
	}
	$page_data['effects_disabled'] = $page_data['effects_disabled'] ? 1 : 0;
	$page_data['effects_one_pager'] = $page_data['effects_one_pager'] ? 1 : 0;
	$page_data['effects_parallax_footer'] = $page_data['effects_parallax_footer'] ? 1 : 0;
	$page_data['effects_no_bottom_margin'] = $page_data['effects_no_bottom_margin'] ? 1 : 0;
	$page_data['effects_no_top_margin'] = $page_data['effects_no_top_margin'] ? 1 : 0;
	$page_data['redirect_to_subpage'] = $page_data['redirect_to_subpage'] ? 1 : 0;
	$page_data['effects_hide_header'] = $page_data['effects_hide_header'] ? 1 : 0;
	$page_data['effects_hide_footer'] = $page_data['effects_hide_footer'] ? 1 : 0;
	return $page_data;
}

function cryption_get_sanitize_page_preloader_data($post_id = 0, $item_data = array()) {
	$page_data = array(
		'enable_page_preloader' => false,
	);
	if(is_array($item_data) && !empty($item_data)) {
		$page_data = array_merge($page_data, $item_data);
	} elseif($post_id != 0) {
		$page_data = cryption_get_post_data($page_data, 'page', $post_id);
	}
	$page_data['enable_page_preloader'] = $page_data['enable_page_preloader'] ? 1 : 0;
	return $page_data;
}

function cryption_get_sanitize_page_slideshow_data($post_id = 0, $item_data = array()) {
	$page_data = array(
		'slideshow_type' => '',
		'slideshow_slideshow' => '',
		'slideshow_layerslider' => '',
		'slideshow_revslider' => '',
	);
	if(is_array($item_data) && !empty($item_data)) {
		$page_data = array_merge($page_data, $item_data);
	} elseif($post_id != 0) {
		$page_data = cryption_get_post_data($page_data, 'page', $post_id);
	}
	$page_data['slideshow_type'] = cryption_check_array_value(array('', 'NivoSlider', 'LayerSlider', 'revslider'), $page_data['slideshow_type'], '');
	$page_data['slideshow_slideshow'] = sanitize_text_field($page_data['slideshow_slideshow']);
	$page_data['slideshow_layerslider'] = sanitize_text_field($page_data['slideshow_layerslider']);
	$page_data['slideshow_revslider'] = sanitize_text_field($page_data['slideshow_revslider']);
	return $page_data;
}

function cryption_get_sanitize_page_sidebar_data($post_id = 0, $item_data = array()) {
	$page_data = array(
		'sidebar_position' => '',
		'sidebar_sticky' => '',
	);
	if(is_array($item_data) && !empty($item_data)) {
		$page_data = array_merge($page_data, $item_data);
	} elseif($post_id != 0) {
		$page_data = cryption_get_post_data($page_data, 'page', $post_id);
	}
	$page_data['sidebar_position'] = cryption_check_array_value(array('', 'left', 'right'), $page_data['sidebar_position'], '');
	$page_data['sidebar_sticky'] = $page_data['sidebar_sticky'] ? 1 : 0;
	return $page_data;
}

function cryption_post_item_save_meta_box_data($post_id) {
	if(!isset($_POST['cryption_post_item_settings_box_nonce'])) {
		return;
	}
	if(!wp_verify_nonce($_POST['cryption_post_item_settings_box_nonce'], 'cryption_post_item_settings_box')) {
		return;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if(isset($_POST['post_type']) && ('ct_news' == $_POST['post_type'] || 'post' == $_POST['post_type'])) {
		if(!current_user_can('edit_page', $post_id)) {
			return;
		}
	} else {
		if(!current_user_can('edit_post', $post_id)) {
			return;
		}
	}

	if(!isset($_POST['ct_post_item_data']) || !is_array($_POST['ct_post_item_data'])) {
		return;
	}

	$post_item_data = cryption_get_sanitize_post_data(0, $_POST['ct_post_item_data']);
	update_post_meta($post_id, 'ct_post_general_item_data', $post_item_data);
}
add_action('save_post', 'cryption_post_item_save_meta_box_data');

function cryption_get_sanitize_post_data($post_id = 0, $item_data = array()) {
	$post_item_data = array(
		'show_featured_content' => 0,
		'video_type' => 'youtube',
		'video' => '',
		'video_aspect_ratio' => '',
		'quote_text' => '',
		'quote_author' => '',
		'quote_background' => '',
		'quote_author_color' => '',
		'audio' => '',
		'gallery' => '',
		'gallery_autoscroll' => '',
	);
	if(is_array($item_data) && !empty($item_data)) {
		$post_item_data = array_merge($post_item_data, $item_data);
	} elseif($post_id != 0) {
		$post_item_data = cryption_get_post_data($post_item_data, 'post_general_item', $post_id);
	}

	$post_item_data['show_featured_content'] = $post_item_data['show_featured_content'] ? 1 : 0;
	$post_item_data['video_type'] = cryption_check_array_value(array('youtube', 'vimeo', 'self'), $post_item_data['video_type'], 'youtube');
	$post_item_data['video'] = sanitize_text_field($post_item_data['video']);
	$post_item_data['video_aspect_ratio'] = sanitize_text_field($post_item_data['video_aspect_ratio']);
	$post_item_data['quote_author'] = sanitize_text_field($post_item_data['quote_author']);
	$post_item_data['quote_background'] = sanitize_text_field($post_item_data['quote_background']);
	$post_item_data['quote_author_color'] = sanitize_text_field($post_item_data['quote_author_color']);
	$post_item_data['audio'] = sanitize_text_field($post_item_data['audio']);
	$post_item_data['gallery'] = intval($post_item_data['gallery']);
	$post_item_data['gallery_autoscroll'] = intval($post_item_data['gallery_autoscroll']);

	return $post_item_data;
}

function cryption_product_size_guide_settings_box($post) {
	wp_nonce_field('cryption_product_size_guide_settings_box', 'cryption_product_size_guide_settings_box_nonce');
	$product_size_guide_data = cryption_get_sanitize_product_size_guide_data($post->ID);
?>
<table class="settings-box-table" width="100%"><tbody><tr>
	<td>
		<input name="ct_product_size_guide_data[disable]" type="checkbox" id="product_size_guide_disable" value="1" <?php checked($product_size_guide_data['disable'], 1); ?> />
		<label for="product_size_guide_disable"><?php esc_html_e('Disable size guide', 'cryption'); ?></label><br /><br />
		<input name="ct_product_size_guide_data[custom]" type="checkbox" id="product_size_guide_custom" value="1" <?php checked($product_size_guide_data['custom'], 1); ?> />
		<label for="product_size_guide_custom"><?php esc_html_e('Use custom size guide', 'cryption'); ?></label><br /><br />
		<label for="product_size_guide_custom_image"><?php esc_html_e('Size guide custom image', 'cryption'); ?>:</label><br />
		<input type="text" name="ct_product_size_guide_data[custom_image]" id="product_size_guide_custom_image" value="<?php echo esc_attr($product_size_guide_data['custom_image']); ?>" class="picture-select" />
	</td>
</tr></tbody></table>
<?php
}

function cryption_product_size_guide_save_meta_box_data($post_id) {
	if(!isset($_POST['cryption_product_size_guide_settings_box_nonce'])) {
		return;
	}
	if(!wp_verify_nonce($_POST['cryption_product_size_guide_settings_box_nonce'], 'cryption_product_size_guide_settings_box')) {
		return;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if(isset($_POST['post_type']) && ('product' == $_POST['post_type'])) {
		if(!current_user_can('edit_page', $post_id)) {
			return;
		}
	} else {
		if(!current_user_can('edit_post', $post_id)) {
			return;
		}
	}

	if(!isset($_POST['ct_product_size_guide_data']) || !is_array($_POST['ct_product_size_guide_data'])) {
		return;
	}

	$product_size_guide_data = cryption_get_sanitize_post_data(0, $_POST['ct_product_size_guide_data']);
	update_post_meta($post_id, 'ct_product_size_guide_data', $product_size_guide_data);
}
add_action('save_post', 'cryption_product_size_guide_save_meta_box_data');

function cryption_get_sanitize_product_size_guide_data($post_id = 0, $item_data = array()) {
	$post_item_data = array(
		'disable' => 0,
		'custom' => 0,
		'custom_image' => '',
	);
	if(is_array($item_data) && !empty($item_data)) {
		$post_item_data = array_merge($post_item_data, $item_data);
	} elseif($post_id != 0) {
		$post_item_data = cryption_get_post_data($post_item_data, 'product_size_guide', $post_id);
	}

	$post_item_data['disable'] = $post_item_data['disable'] ? 1 : 0;
	$post_item_data['custom'] = $post_item_data['custom'] ? 1 : 0;
	$post_item_data['custom_image'] = esc_url($post_item_data['custom_image']);

	return $post_item_data;
}

add_action('wp_ajax_ct_icon_list', 'cryption_icon_list_info');
function cryption_icon_list_info() {
	if(!empty($_REQUEST['iconpack']) && in_array($_REQUEST['iconpack'], array('elegant', 'material', 'fontawesome', 'userpack'))) {
		$svg_links = array(
			'elegant' => get_template_directory_uri() . '/fonts/elegant/ElegantIcons.svg',
			'material' => get_template_directory_uri() . '/fonts/material/materialdesignicons.svg',
			'fontawesome' => get_template_directory_uri() . '/fonts/fontawesome/fontawesome-webfont.svg',
			'userpack' => get_stylesheet_directory_uri() . '/fonts/UserPack/UserPack.svg',
		);
		$css_links = array(
			'elegant' => get_template_directory_uri() . '/css/icons-elegant.css',
			'material' => get_template_directory_uri() . '/css/icons-material.css',
			'fontawesome' => get_template_directory_uri() . '/css/icons-fontawesome.css',
			'userpack' => get_stylesheet_directory_uri() . '/css/icons-userpack.css',
		);
		echo '<ul class="icons-list icons-'.esc_attr($_REQUEST['iconpack']).' styled"></ul>';
?>
	<script type="text/javascript">
	(function($) {
		$(function() {
			$.ajax({
				url: '<?php echo esc_url($svg_links[$_REQUEST['iconpack']]); ?>'
			}).done(function(data) {
				var $glyphs = $('glyph', data);
				$('.icons-list').html('');
				$glyphs.each(function() {
					var code = $(this).attr('unicode').charCodeAt(0).toString(16);
					if($(this).attr('d')) {
						$('<li><span class="icon">'+$(this).attr('unicode')+'</span><span class="code">'+code+'</span></li>').appendTo($('.icons-list'));
					}
				});
			});
		});
	})(jQuery);
	</script>
<?php
		exit;
	}
	die(-1);
}

function cryption_admin_page_settings_scripts() {
	$script1=<<<EOT
(function($) {
	$(function() {
		$('#page_title_background_image_select a[href="'+$('#page_title_background_image').val()+'"]').addClass('active');
		$('#page_title_background_image_select a').click(function(e) {
			$('#page_title_background_image_select a.active').removeClass('active');
			e.preventDefault();
			$('#page_title_background_image').val($(this).attr('href'));
			$(this).addClass('active');
		});
		$('#page_title_icon_pack').change(function() {
			$('.ct-icon-info').hide();
			$('.ct-icon-info-' + $(this).val()).show();
			$('#page_title_icon').data('iconpack', $(this).val());
		}).trigger('change');
		$('#page_title_rich_content').change(function() {
			if($(this).is(':checked')) {
				$('#wp-page_title_content-wrap').show();
			} else {
				$('#wp-page_title_content-wrap').hide();
			}
		}).trigger('change');
	});
})(jQuery);
EOT;
	$script2=<<<EOT
(function($) {
	$(function() {
		$('.slideshow-select').hide();
		if($('#page_slideshow_type').val() != '') {
			$('.slideshow-select.'+$('#page_slideshow_type').val()).show();
		}
		$('#page_slideshow_type').change(function() {
			if($('#page_slideshow_type').val() != '') {
				$('.slideshow-select:not(.'+$('#page_slideshow_type').val()+')').slideUp();
			} else {
				$('.slideshow-select').slideUp();
			}
			if($('#page_slideshow_type').val() != '') {
				$('.slideshow-select.'+$('#page_slideshow_type').val()).slideDown();
			}
		});
	});
})(jQuery);
EOT;
	wp_add_inline_script('ct-admin-functions', $script1);
	wp_add_inline_script('ct-admin-functions', $script2);
}
add_action('admin_enqueue_scripts', 'cryption_admin_page_settings_scripts', 11);
