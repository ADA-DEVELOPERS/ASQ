<?php

require get_template_directory() . '/inc/options.php';
require get_template_directory() . '/inc/content.php';
require get_template_directory() . '/inc/shortcodes.php';
require get_template_directory() . '/inc/post-types/init.php';
require get_template_directory() . '/inc/megamenu/megamenu.class.php';
require get_template_directory() . '/inc/megamenu/megamenu-walker.class.php';
require get_template_directory() . '/inc/image-generator/image-editor.class.php';
require get_template_directory() . '/inc/image-generator/image-generator.php';

require get_template_directory() . '/plugins/plugins.php';

require get_template_directory() . '/demo-import/import.php';

if ( ! isset( $content_width ) ) {
	$content_width = 1170;
}

if(!function_exists('cryption_setup')) :
function cryption_setup() {
	load_theme_textdomain('cryption', get_template_directory() . '/languages');
	add_theme_support('automatic-feed-links');
	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');
	set_post_thumbnail_size(672, 372, true);
	add_image_size('ct-post-thumb', 256, 256, true);
	add_image_size('ct-custom-product-categories', 766, 731, true);
	register_nav_menus(array(
		'primary' => esc_html__('Top primary menu', 'cryption'),
		'footer'  => esc_html__('Footer menu', 'cryption'),
	));
	// add_theme_support('html5', array(
	// 	'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	// ));
	add_theme_support('post-formats', array(
		'image', 'video', 'audio', 'quote', 'gallery',
	));
	add_theme_support('custom-background', apply_filters('cryption_custom_background_args', array(
		'default-color' => 'ffffff',
	)));
	add_theme_support('featured-content', array(
		'featured_content_filter' => 'cryption_get_featured_posts',
		'max_posts' => 6,
	));
	add_filter('use_default_gallery_style', '__return_false');

	function cryption_jpeg_quality() { return 100; }
	add_filter( 'jpeg_quality', 'cryption_jpeg_quality', 10, 2 );

	if(!get_option('ct_theme_options') || cryption_get_option('theme_name') != 'cryption') {
		update_option('ct_theme_options', cryption_first_install_settings());
		delete_option('ct_activation');
	}
	if(!get_option('pw_options')) {
		$pw_options = array(
			'donation' => 'yes',
			'customize_by_default' => 'yes',
			'post_types' => array('post', 'page', 'ct_pf_item', 'ct_news', 'product'),
			'sidebars' => array('page-sidebar', 'footer-widget-area', 'shop-sidebar'),
		);
		update_option('pw_options', $pw_options);
	}
	if(!get_option('shop_catalog_image_size')) {
		update_option('shop_catalog_image_size', array('width' => 522, 'height' => 652, 'crop' => 1));
	}
	if(!get_option('shop_single_image_size')) {
		update_option('shop_single_image_size', array('width' => 564, 'height' => 744, 'crop' => 1));
	}
	if(!get_option('shop_thumbnail_image_size')) {
		update_option('shop_thumbnail_image_size', array('width' => 160, 'height' => 160, 'crop' => 1));
	}
	if(!get_option('wpb_js_content_types')) {
		update_option('wpb_js_content_types', array('post', 'page', 'product', 'ct_news', 'ct_pf_item'));
	}
	update_option('zilla_likes_settings', array_merge(get_option('zilla_likes_settings', array()), array('disable_css' => 1)));
	update_option('layerslider-authorized-site', 1);
	update_option('wpb_js_js_composer_purchase_code', 1);
	update_option('revslider-valid-notice', 'false');
	$megamenu = new CT_Mega_Menu();
	add_filter('attachment_fields_to_edit', 'cryption_attachment_extra_fields', 10, 2);
	add_filter('attachment_fields_to_save', 'cryption_attachment_extra_fields_save', 10, 2);
}
endif;
add_action('after_setup_theme', 'cryption_setup');

function cryption_theme_option_admin_notice() {
	if(isset($_GET['page']) && $_GET['page'] == 'options-framework') {
		$wp_upload_dir = wp_upload_dir();
		$upload_logos_dir = $wp_upload_dir['basedir'] . '/ct-logos';
		if(!wp_mkdir_p($upload_logos_dir)) {
?>
<div class="error">
	<p><?php esc_html_e('Upload directory cannot be created. Check your permissions.', 'cryption'); ?></p>
</div>
<?php
		}
	}
}
add_action('admin_notices', 'cryption_theme_option_admin_notice');

function cryption_attachment_extra_fields($fields, $post) {
	$attachment_link = get_post_meta($post->ID, 'attachment_link', true);
	$fields['attachment_link'] = array(
		'input' => 'html',
		'html' => '<input type="text" id="attachments-' . $post->ID . '-attachment_link" style="width: 500px;" name="attachments[' . $post->ID . '][attachment_link]" value="' . esc_attr( $attachment_link ) . '" />',
		'label' => esc_html__('Link', 'cryption'),
		'value' => $attachment_link
	);

	$highligh = (bool) get_post_meta($post->ID, 'highlight', true);
	$fields['highlight'] = array(
		'input' => 'html',
		'html' => '<input type="checkbox" id="attachments-' . $post->ID . '-highlight" name="attachments[' . $post->ID . '][highlight]" value="1"' . ($highligh ? ' checked="checked"' : '') . ' />',
		'label' => esc_html__('Show as Highlight?', 'cryption'),
		'value' => $highligh
	);

	$highligh_type = get_post_meta($post->ID, 'highligh_type', true);
	if (!$highligh_type) {
		$highligh_type = 'squared';
	}
	$fields['highligh_type'] = array(
		'input' => 'html',
		'html' => '<select id="attachments-' . $post->ID . '-highligh_type" name="attachments[' . $post->ID . '][highligh_type]"><option value="squared" ' . ($highligh_type == 'squared' ? ' selected="selected"' : '') . '>Squared</option><option value="horizontal" ' . ($highligh_type == 'horizontal' ? ' selected="selected"' : '') . '>Horizontal</option><option value="vertical" ' . ($highligh_type == 'vertical' ? ' selected="selected"' : '') . '>Vertical</option></select>',
		'label' => esc_html__('Highlight Type', 'cryption'),
		'value' => $highligh_type
	);

	return $fields;
}

function cryption_attachment_extra_fields_save($post, $attachment) {
	update_post_meta($post['ID'], 'highlight', isset($attachment['highlight']));
	update_post_meta($post['ID'], 'attachment_link', $attachment['attachment_link']);
	update_post_meta($post['ID'], 'highligh_type', $attachment['highligh_type']);
	return $post;
}

/* SIDEBAR & WIDGETS */

function cryption_count_widgets($sidebar_id) {

	global $_wp_sidebars_widgets, $sidebars_widgets;
	if(!is_admin()) {
		if(empty($_wp_sidebars_widgets))
			$_wp_sidebars_widgets = get_option('sidebars_widgets', array());
		$sidebars_widgets = $_wp_sidebars_widgets;
	} else {
		$sidebars_widgets = get_option('sidebars_widgets', array());
	}
	if(is_array($sidebars_widgets) && isset($sidebars_widgets['array_version']))
		unset($sidebars_widgets['array_version']);

	$sidebars_widgets = apply_filters('sidebars_widgets', $sidebars_widgets);

	if(isset($sidebars_widgets[$sidebar_id])) {
		return count($sidebars_widgets[$sidebar_id]);
	}
	return 0;
}

function cryption_dynamic_sidebar_params($params) {
	$footer_widgets_class = 'col-md-4 col-sm-6 col-xs-12';
	if(cryption_count_widgets('footer-widget-area') >= 4) {
		$footer_widgets_class = 'col-md-3 col-sm-6 col-xs-12';
	}
	if(cryption_count_widgets('footer-widget-area') == 2) {
		$footer_widgets_class = 'col-sm-6 col-xs-12';
	}
	if(cryption_count_widgets('footer-widget-area') == 1) {
		$footer_widgets_class = 'col-xs-12';
	}
	$footer_widgets_class .= ' count-'.cryption_count_widgets('footer-widget-area');
	$params[0]['before_widget'] = str_replace('ct__footer-widget-class__ct', esc_attr($footer_widgets_class), $params[0]['before_widget']);
	return $params;
}
add_filter('dynamic_sidebar_params', 'cryption_dynamic_sidebar_params');

function cryption_sidebar_init() {
	register_sidebar(array(
		'name'          => esc_html__('Main Page Sidebar', 'cryption'),
		'id'            => 'page-sidebar',
		'description'   => esc_html__('Main sidebar that appears on the left.', 'cryption'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	));
	register_sidebar(array(
		'name'          => esc_html__('VC Page Sidebar 01', 'cryption'),
		'id'            => 'page-sidebar-1',
		'description'   => esc_html__('Main sidebar that appears on the left.', 'cryption'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	));
	register_sidebar(array(
		'name'          => esc_html__('VC Page Sidebar 02', 'cryption'),
		'id'            => 'page-sidebar-2',
		'description'   => esc_html__('Main sidebar that appears on the left.', 'cryption'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	));
	register_sidebar(array(
		'name'          => esc_html__('Footer Widget Area', 'cryption'),
		'id'            => 'footer-widget-area',
		'description'   => esc_html__('Footer Widget Area.', 'cryption'),
		'before_widget' => '<div id="%1$s" class="widget inline-column ct__footer-widget-class__ct %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
    register_sidebar(array(
        'name'          => esc_html__('Prefooter Widget Area', 'cryption'),
        'id'            => 'pre-footer-widget-area',
        'description'   => esc_html__('Prefooter Widget Area.', 'cryption'),
        'before_widget' => '<div id="%1$s" class="widget inline-column ct__footer-widget-class__ct %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'cryption_sidebar_init');

function cryption_scripts() {
	wp_enqueue_script('ct-fullwidth-optimizer', get_template_directory_uri() . '/js/ct-fullwidth-loader.js', false, false, false);
	wp_enqueue_script( 'html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );
	wp_enqueue_script('jquery-dlmenu', get_template_directory_uri() . '/js/jquery.dlmenu.js', array('jquery'), false, true);
	wp_enqueue_script('ct-menu-init-script', get_template_directory_uri() . '/js/ct-menu_init.js', array('jquery'), false, true);
	wp_localize_script('ct-menu-init-script', 'ct_dlmenu_settings', array(
		'backLabel' => esc_html__('Back', 'cryption'),
		'showCurrentLabel' => esc_html__('Show this page', 'cryption')
	));

	wp_enqueue_style('ct-preloader', get_template_directory_uri() . '/css/ct-preloader.css');

	$icons_loading_css = "
		body:not(.compose-mode) .ct-icon .ct-icon-half-1,
		body:not(.compose-mode) .ct-icon .ct-icon-half-2 {
			opacity: 0 !important;
			}";
	wp_add_inline_style('ct-preloader', $icons_loading_css);

	wp_enqueue_style('ct-reset', get_template_directory_uri() . '/css/ct-reset.css');
	wp_enqueue_style('ct-grid', get_template_directory_uri() . '/css/ct-grid.css');
	if(get_stylesheet() === get_template()) {
		wp_enqueue_style('ct-style', get_stylesheet_uri(), array('ct-reset', 'ct-grid'));
	} else {
		wp_enqueue_style('ct-style', get_template_directory_uri().'/style.css', array('ct-reset', 'ct-grid'));
		wp_enqueue_style('ct-child-style', get_stylesheet_uri(), array('ct-style'));
	}
	wp_enqueue_style('ct-header', get_template_directory_uri() . '/css/ct-header.css');
	wp_enqueue_style('ct-widgets', get_template_directory_uri() . '/css/ct-widgets.css');
	wp_register_style('ct-animations', get_template_directory_uri() . '/css/ct-itemsAnimations.css');
	wp_enqueue_style('ct-new-css', get_template_directory_uri() . '/css/ct-new-css.css');
	wp_enqueue_style('perevazka-css-css', get_template_directory_uri() . '/css/ct-perevazka-css.css');
	if($fonts_url = cryption_google_fonts_url()) {
		wp_enqueue_style( 'ct-google-fonts', $fonts_url);
	}
	if(file_exists(get_stylesheet_directory() . '/css/custom.css')) {
		wp_enqueue_style('ct-custom', get_stylesheet_directory_uri() . '/css/custom.css', array('ct-style'));
	} else {
		wp_enqueue_style('ct-custom', get_template_directory_uri() . '/css/custom.css', array('ct-style'));
	}
	wp_deregister_style('wp-mediaelement');
	wp_register_style('wp-mediaelement', get_template_directory_uri() . '/css/wp-mediaelement.css', array('mediaelement'));

	if(is_rtl()) {
		wp_enqueue_style( 'ct-rtl', get_template_directory_uri() . '/css/rtl.css');
	}

	// if(is_singular() && comments_open() && get_option('thread_comments')) {
	// 	wp_enqueue_script('comment-reply', array(), false, true);
	// }

	$fullwidth_loading_css = "
		.fullwidth-block {
			-webkit-transform: translate3d(0, 0, 0);
			-moz-transform: translate3d(0, 0, 0);
			-ms-transform: translate3d(0, 0, 0);
			transform: translate3d(0, 0, 0);
		}";
	wp_add_inline_style('ct-reset', $fullwidth_loading_css);

	wp_enqueue_style('js_composer_front');
	wp_enqueue_script('svg4everybody', get_template_directory_uri() . '/js/svg4everybody.js', false, false, true);
	wp_enqueue_script('ct-form-elements', get_template_directory_uri() . '/js/ct-form-elements.js', array('jquery'), false, true);
	wp_enqueue_script('jquery-easing', get_template_directory_uri() . '/js/jquery.easing.js', array('jquery'), false, true);

	wp_register_script('ct-mediaelement', get_template_directory_uri() . '/js/ct-mediaelement.js', array('jquery', 'mediaelement'), false, true);
	wp_enqueue_script('ct-header', get_template_directory_uri() . '/js/ct-header.js', array('jquery'), false, true);
	wp_register_script('jquery-touchSwipe', get_template_directory_uri() . '/js/jquery.touchSwipe.min.js', array('jquery'), false, true);
	wp_register_script('jquery-carouFredSel', get_template_directory_uri() . '/js/jquery.carouFredSel.js', array('jquery', 'jquery-touchSwipe'), false, true);
	wp_register_script('ct-gallery', get_template_directory_uri() . '/js/ct-gallery.js', array('jquery', 'jquery-carouFredSel', 'ct-scroll-monitor'), false, true);
	wp_register_style('odometr', get_template_directory_uri() . '/css/odometer-theme-default.css');
	wp_register_script('odometr', get_template_directory_uri() . '/js/odometer.js', array('jquery'), false, true);
	wp_register_script('ct-related-products-carousel', get_template_directory_uri() . '/js/ct-related-products-carousel.js', array('jquery', 'jquery-carouFredSel'), false, true);
	wp_register_script('ct-related-posts-carousel', get_template_directory_uri() . '/js/ct-related-posts-carousel.js', array('jquery', 'jquery-carouFredSel'), false, true);
	wp_register_script('ct-sticky', get_template_directory_uri() . '/js/ct-sticky.js', array('jquery'), false, true);
	wp_register_script('ct-items-animations', get_template_directory_uri() . '/js/ct-itemsAnimations.js', array('jquery'), false, true);
	wp_register_style('ct-blog', get_template_directory_uri() . '/css/ct-blog.css', array('mediaelement', 'wp-mediaelement'));
	wp_register_style('ct-additional-blog', get_template_directory_uri() . '/css/ct-additional-blog.css');
	wp_enqueue_style('ct-additional-blog-1', get_template_directory_uri() . '/css/ct-additional-blog-1.css');
	wp_enqueue_style('ct-hovers', get_template_directory_uri() . '/css/ct-hovers.css');
	wp_register_style('icons-elegant', get_template_directory_uri() . '/css/icons-elegant.css');
	wp_register_style('icons-material', get_template_directory_uri() . '/css/icons-material.css');
	wp_register_style('icons-fontawesome', get_template_directory_uri() . '/css/icons-fontawesome.css');

	if (!cryption_get_option('disable_smooth_scroll')) {
		wp_enqueue_script('SmoothScroll', get_template_directory_uri() . '/js/SmoothScroll.js', array(), false, true);
	}

	/* Lazy Loading */
	wp_enqueue_script('ct-lazy-loading', get_template_directory_uri() . '/js/ct-lazyLoading.js', array(), false, true);
	wp_enqueue_script('jquery-transform', get_template_directory_uri() . '/js/jquery.transform.js', array(), false, true);
	wp_enqueue_script('jquery-effects-drop', array(), false, true);


	wp_enqueue_script('ct-scripts', get_template_directory_uri() . '/js/functions.js', array('jquery', 'ct-form-elements', 'odometr', 'ct-sticky', 'jquery-dlmenu'), false, true);
	if(cryption_get_option('custom_js')) {
		wp_add_inline_script('ct-scripts', stripslashes(cryption_get_option('custom_js')));
	}

	wp_enqueue_script('jquery-mousewheel', get_template_directory_uri() . '/js/fancyBox/jquery.mousewheel.pack.js', array(), false, true);
	wp_enqueue_script('jquery-fancybox', get_template_directory_uri() . '/js/fancyBox/jquery.fancybox.pack.js', array(), false, true);
	wp_enqueue_script('fancybox-init-script', get_template_directory_uri() . '/js/fancyBox/jquery.fancybox-init.js', array('jquery-mousewheel', 'jquery-fancybox'), false, true);
	wp_enqueue_style('jquery-fancybox', get_template_directory_uri() . '/js/fancyBox/jquery.fancybox.css');

	wp_enqueue_script('ct-vc_elements', get_template_directory_uri() . '/js/ct-vc_elements_init.js', array('jquery'), false, true);
	wp_enqueue_style('ct-vc_elements', get_template_directory_uri() . '/css/ct-vc_elements.css');

	wp_register_script('ct-blog', get_template_directory_uri() . '/js/ct-blog.js', array('jquery', 'ct-mediaelement', 'ct-scroll-monitor', 'imagesloaded'), '', true);
	wp_register_script('isotope-js', get_template_directory_uri() . '/js/isotope.min.js', array('jquery'), '', true);
	wp_register_script('ct-scroll-monitor', get_template_directory_uri() . '/js/ct-scrollMonitor.js', array(), '', true);
	wp_register_script('ct-parallax-footer', get_template_directory_uri() . '/js/ct-parallax-footer.js', array('jquery'), false, true);
	if(is_404() && get_post(cryption_get_option('404_page')) && $page_404_inline_style = get_post_meta(cryption_get_option('404_page'), '_wpb_shortcodes_custom_css', true)) {
		wp_add_inline_style('ct-custom', strip_tags($page_404_inline_style));
	}
	if(cryption_is_plugin_active('woocommerce/woocommerce.php')) {
		if(is_shop() && get_post(wc_get_page_id('shop')) && $page_shop_inline_style = get_post_meta(wc_get_page_id('shop'), '_wpb_shortcodes_custom_css', true)) {
			wp_add_inline_style('ct-custom', strip_tags($page_shop_inline_style));
		}
	}
	$custom_footer_post_id = 0;
	if(cryption_get_option('custom_footer') && get_post(cryption_get_option('custom_footer'))) {
		$custom_footer_post_id = cryption_get_option('custom_footer');
	}
	if(get_post($custom_footer_post_id) && $custom_footer_inline_style = get_post_meta($custom_footer_post_id, '_wpb_shortcodes_custom_css', true).get_post_meta($custom_footer_post_id, '_wpb_post_custom_css', true)) {
		wp_add_inline_style('ct-custom', strip_tags($custom_footer_inline_style));
	}
}
add_action('wp_enqueue_scripts', 'cryption_scripts', 5);

function cryption_admin_scripts_init() {
	$jQuery_ui_theme = 'ui-no-theme';
	wp_enqueue_style('jquery-ui-no-theme', get_template_directory_uri() . '/css/jquery-ui/' . $jQuery_ui_theme . '/jquery-ui.css');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
	wp_enqueue_script('media-upload');
	wp_enqueue_style('ct-admin-styles', get_template_directory_uri() . '/css/ct-admin.css');
	wp_enqueue_script('color-picker', get_template_directory_uri() . '/js/colorpicker/js/colorpicker.js');
	wp_enqueue_style('color-picker', get_template_directory_uri() . '/js/colorpicker/css/colorpicker.css');
	wp_enqueue_script('ct-admin-functions', get_template_directory_uri() . '/js/ct-admin_functions.js', array('jquery'));
	wp_enqueue_script('ct_page_settings-script', get_template_directory_uri() . '/js/ct-page_meta_box_settings.js', array('jquery'));
	wp_register_script('ct_js_composer_js_custom_views', get_template_directory_uri() . '/js/ct-composer-custom-views.js', array( 'wpb_js_composer_js_view' ), '', true );
	wp_register_style('icons-elegant', get_template_directory_uri() . '/css/icons-elegant.css');
	wp_register_style('icons-material', get_template_directory_uri() . '/css/icons-material.css');
	wp_register_style('icons-fontawesome', get_template_directory_uri() . '/css/icons-fontawesome.css');
	wp_register_script('ct-icons-picker', get_template_directory_uri() . '/js/ct-icons-picker.js', array('jquery'));
	wp_localize_script('ct-icons-picker', 'ct_iconsPickerData', array(
		'buttonTitle' => esc_html__('Select icon', 'cryption'),
		'ajax_url' => esc_url(admin_url('admin-ajax.php')),
		'ajax_nonce' => wp_create_nonce('ajax_security'),
	));
}
add_action('admin_enqueue_scripts', 'cryption_admin_scripts_init');

/* FONTS */

function cryption_additionals_fonts() {
	$cryption_fonts = apply_filters('ct_additional_fonts', array());
	$user_fonts = get_option('ct_additionals_fonts');
	if(is_array($user_fonts)) {
		return array_merge($user_fonts, $cryption_fonts);
	}

	return $cryption_fonts;
}

add_action('template_redirect', 'cryption_redirect_subpage');
function cryption_redirect_subpage() {
	global $post;

	$effects_params = cryption_get_sanitize_page_effects_data(get_the_ID());
	if ($effects_params['redirect_to_subpage']) {
	    $pagekids = get_pages("child_of=".$post->ID."&sort_column=menu_order");
	    if (count($pagekids) > 0) {
	    	$firstchild = $pagekids[0];
	    	wp_redirect(get_permalink($firstchild->ID));
	    }
	}
}

add_action('init', 'cryption_google_fonts_load_file');
function cryption_google_fonts_load_file() {
	global $cryption_fontsFamilyArray, $cryption_fontsFamilyArrayFull;
	$cryption_fontsFamilyArray = array();
	$cryption_fontsFamilyArrayFull = array();
	$additionals_fonts = cryption_additionals_fonts();
	foreach($additionals_fonts as $additionals_font) {
		$cryption_fontsFamilyArray[$additionals_font['font_name']] = $additionals_font['font_name'];
		$cryption_fontsFamilyArrayFull[$additionals_font['font_name']] = array('family' => $additionals_font['font_name'], 'variants' => array('regular'), 'subsets' => array());
	}
	$cryption_fontsFamilyArray = array_merge($cryption_fontsFamilyArray, array(
		'Arial' => 'Arial',
		'Courier' => 'Courier',
		'Courier New' => 'Courier New',
		'Georgia' => 'Georgia',
		'Helvetica' => 'Helvetica',
		'Palatino' => 'Palatino',
		'Times New Roman' => 'Times New Roman',
		'Trebuchet MS' => 'Trebuchet MS',
		'Verdana' => 'Verdana'
	));
	$cryption_fontsFamilyArrayFull = array_merge($cryption_fontsFamilyArrayFull, array(
		'Arial' => array('family' => 'Arial', 'variants' => array('regular', 'italic', '700', '700italic'), 'subsets' => array()),
		'Courier' => array('family' => 'Courier', 'variants' => array('regular', 'italic', '700', '700italic'), 'subsets' => array()),
		'Courier New' => array('family' => 'Courier New', 'variants' => array('regular', 'italic', '700', '700italic'), 'subsets' => array()),
		'Georgia' => array('family' => 'Georgia', 'variants' => array('regular', 'italic', '700', '700italic'), 'subsets' => array()),
		'Helvetica' => array('family' => 'Helvetica', 'variants' => array('regular', 'italic', '700', '700italic'), 'subsets' => array()),
		'Palatino' => array('family' => 'Palatino', 'variants' => array('regular', 'italic', '700', '700italic'), 'subsets' => array()),
		'Times New Roman' => array('family' => 'Times New Roman', 'variants' => array('regular', 'italic', '700', '700italic'), 'subsets' => array()),
		'Trebuchet MS' => array('family' => 'Trebuchet MS', 'variants' => array('regular', 'italic', '700', '700italic'), 'subsets' => array()),
		'Verdana' => array('family' => 'Verdana', 'variants' => array('regular', 'italic', '700', '700italic'), 'subsets' => array()),
	));
	$fontsList = false;
	$font_json_file = cryption_file_get_contents(get_template_directory() . '/fonts/webfonts.json');
	if($font_json_file !== false) {
		$fontsList = json_decode($font_json_file);
	}
	if(is_object($fontsList) && isset($fontsList->kind) && $fontsList->kind == 'webfonts#webfontList' && isset($fontsList->items) && is_array($fontsList->items)) {
		foreach($fontsList->items as $item) {
			if(is_object($item) && isset($item->kind) && $item->kind == 'webfonts#webfont' && isset($item->family) && is_string($item->family)) {
				$cryption_fontsFamilyArray[$item->family] = $item->family;
				$cryption_fontsFamilyArrayFull[$item->family] = array(
					'family' => $item->family,
					'variants' => $item->variants,
					'subsets' => $item->subsets,
				);
			}
		}
	}
}

function cryption_fonts_list($full = false) {
	global $cryption_fontsFamilyArray, $cryption_fontsFamilyArrayFull;
	if($full) {
		return $cryption_fontsFamilyArrayFull;
	} else {
		return $cryption_fontsFamilyArray;
	}
}

function cryption_google_fonts_url() {
	$options = cryption_get_theme_options();
	$fontsList = cryption_fonts_list(true);
	$fontElements = array_keys($options['fonts']['subcats']);
	$exclude_array = array('Arial', 'Courier', 'Courier New', 'Georgia', 'Helvetica', 'Palatino', 'Times New Roman', 'Trebuchet MS', 'Verdana');
	$additionals_fonts = cryption_additionals_fonts();
	foreach($additionals_fonts as $additionals_font) {
		$exclude_array[] = $additionals_font['font_name'];
	}
	$fonts = array();
	$variants = array();
	$subsets = array();
	foreach($fontElements as $element) {
		if(($font = cryption_get_option($element.'_family')) && !in_array($font, $exclude_array) && isset($fontsList[$font])) {
			$font = $fontsList[$font];
			if(cryption_get_option($element.'_sets')) {
				$font['subsets'] = cryption_get_option($element.'_sets');
			} else {
				$font['subsets'] = implode(',',$font['subsets']);
			}
			if(cryption_get_option($element.'_style')) {
				$font['variants'] = cryption_get_option($element.'_style');
			} else {
				$font['variants'] = 'regular';
			}

			if(!in_array($font['family'], $fonts))
				$fonts[] = $font['family'];

			if(!isset($variants[$font['family']]))
				$variants[$font['family']] = array();

			$tmp = explode(',', $font['variants']);
			foreach ($tmp as $v) {
				if(!in_array($v, $variants[$font['family']]))
					$variants[$font['family']][] = $v;
			}

			$tmp = explode(',', $font['subsets']);
			foreach ($tmp as $v) {
				if(!in_array($v, $subsets))
					$subsets[] = $v;
			}
		}
	}
	if(count($fonts) > 0) {
		$inc_fonts = '';
		foreach ($fonts as $k=>$v) {
			if('off' !== _x( 'on', $v.' font: on or off', 'cryption' )) {
				if($k > 0)
					$inc_fonts .= '|';
				$inc_fonts .= $v;
				if(!empty($variants[$v]))
					$inc_fonts .= ':'.implode(',', $variants[$v]);
			}
		}
		$query_args = array(
		'family' => urlencode($inc_fonts),
		'subset' => urlencode(implode(',', $subsets)),
		);
		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
		return esc_url_raw( $fonts_url );
	}
	return false;
}

function cryption_custom_fonts() {
	$options = cryption_get_theme_options();
	$fontElements = array_keys($options['fonts']['subcats']);
	unset($fontElements[0]);
	$additionals_fonts = cryption_additionals_fonts();
	$fonts_array = array();
	foreach($additionals_fonts as $additionals_font) {
		$fonts_array[] = $additionals_font['font_name'];
		$fonts_arrayFull[$additionals_font['font_name']] = $additionals_font;
	}
	$exclude_array = array();
	foreach($fontElements as $element) {
		if(($font = cryption_get_option($element.'_family')) && in_array($font, $fonts_array) && !in_array($font, $exclude_array)) {
			$exclude_array[] = $font;
?>

@font-face {
	font-family: '<?php echo sanitize_text_field($fonts_arrayFull[$font]['font_name']); ?>';
	src: url('<?php echo esc_url($fonts_arrayFull[$font]['font_url_eot']); ?>');
	src: url('<?php echo esc_url($fonts_arrayFull[$font]['font_url_eot']); ?>?#iefix') format('embedded-opentype'),
		url('<?php echo esc_url($fonts_arrayFull[$font]['font_url_woff']); ?>') format('woff'),
		url('<?php echo esc_url($fonts_arrayFull[$font]['font_url_ttf']); ?>') format('truetype'),
		url('<?php echo esc_url($fonts_arrayFull[$font]['font_url_svg'].'#'.$fonts_arrayFull[$font]['font_svg_id']); ?>') format('svg');
		font-weight: normal;
		font-style: normal;
}

<?php
		}
	}
}

add_action('wp_ajax_ct_get_font_data', 'cryption_get_font_data');
function cryption_get_font_data() {
	if(is_array($_REQUEST['fonts'])) {
		$result = array();
		$fontsList = cryption_fonts_list(true);
		foreach ($_REQUEST['fonts'] as $font)
			if(isset($fontsList[$font]))
				$result[$font] = $fontsList[$font];
		echo json_encode($result);
		exit;
	}
	die(-1);
}

/* META BOXES */

if(!function_exists('cryption_print_select_input')) {
function cryption_print_select_input($values = array(), $value = '', $name = '', $id = '') {
	if(!is_array($values)) {
		$values = array();
	}
?>
	<select name="<?php echo esc_attr($name) ?>" id="<?php echo esc_attr($id); ?>" class="ct-combobox">
		<?php foreach($values as $key => $title) : ?>
			<option value="<?php echo esc_attr($key); ?>" <?php selected($key, $value); ?>><?php echo esc_html($title); ?></option>
		<?php endforeach; ?>
	</select>
<?php
}
}

if(!function_exists('cryption_print_checkboxes')) {
function cryption_print_checkboxes($values = array(), $value = array(), $name = '', $id_prefix = '', $after = '') {
	if(!is_array($values)) {
		$values = array();
	}
	if(!is_array($value)) {
		$value = array();
	}
?>
	<?php foreach($values as $key => $title) : ?>
		<input name="<?php echo esc_attr($name); ?>" type="checkbox" id="<?php echo esc_attr($id_prefix.'-'.$key); ?>" value="<?php echo esc_attr($key); ?>" <?php checked(in_array($key, $value), 1); ?> />
		<label for="<?php echo esc_attr($id_prefix.'-'.$key); ?>"><?php echo esc_html($title); ?></label>
		<?php echo $after; ?>
	<?php endforeach; ?>
<?php
}
}

/* PLUGINS */

if(!function_exists('cryption_is_plugin_active')) {
	function cryption_is_plugin_active($plugin) {
		include_once(ABSPATH . 'wp-admin/includes/plugin.php');
		return is_plugin_active($plugin);
	}
}

/* DROPDOWN MENU */

class cryption_walker_primary_nav_menu extends Walker_Nav_Menu {
	function start_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu dl-submenu styled\">\n";
	}
}

class cryption_walker_footer_nav_menu extends Walker_Nav_Menu {
	function start_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu styled\">\n";
	}
}

function cryption_add_menu_item_classes($classes, $item) {
	$one_pager = false;
	if(is_singular()) {
		$effects_params = cryption_get_sanitize_page_effects_data(get_the_ID());
		$one_pager = $effects_params['effects_one_pager'];
	}
	if((is_post_type_archive('product') || is_tax('product_cat') || is_tax('product_tag')) && function_exists('wc_get_page_id')) {
		$page_id = wc_get_page_id('shop');
		$effects_params = cryption_get_sanitize_page_effects_data($page_id);
		$one_pager = $effects_params['effects_one_pager'];
	}
	if($item->current_item_ancestor || $item->current_item_parent) {
		$classes[] = 'menu-item-current';
	}
	if($item->current && !$one_pager) {
		$classes[] = 'menu-item-active';
	}
	return $classes;
}
add_filter('nav_menu_css_class', 'cryption_add_menu_item_classes', 10, 2);

function cryption_add_menu_parent_class($items) {
	$parents = array();
	foreach($items as $item) {
		if($item->menu_item_parent && $item->menu_item_parent > 0) {
			$parents[] = $item->menu_item_parent;
		}
	}
	foreach($items as $item) {
		if(in_array($item->ID, $parents)) {
			$item->classes[] = 'menu-item-parent';
		}
	}
	return $items;
}
add_filter('wp_nav_menu_objects', 'cryption_add_menu_parent_class');

function cryption_get_data($data = array(), $param = '', $default = '', $prefix = '', $suffix = '') {
	if(is_array($data) && !empty($data[$param])) {
		return $prefix.(nl2br($data[$param])).$suffix;
	}
	if(!empty($default)) {
		return $prefix.$default.$suffix;
	}
	return $default;
}

function cryption_check_array_value($array = array(), $value = '', $default = '') {
	if(in_array($value, $array)) {
		return $value;
	}
	return $default;
}

/* PAGE TITLE */

function cryption_title($sep = '&raquo;', $display = true, $seplocation = '') {
	global $wpdb, $wp_locale;

	$m = get_query_var('m');
	$year = get_query_var('year');
	$monthnum = get_query_var('monthnum');
	$day = get_query_var('day');
	$search = get_query_var('s');
	$title = '';

	$t_sep = '%WP_TITILE_SEP%'; // Temporary separator, for accurate flipping, if necessary

	// If there is a post
	if(is_single() || is_page()) {
		$title = single_post_title('', false);
	}

	// If there's a post type archive
	if(is_post_type_archive()) {
		$post_type = get_query_var('post_type');
		if(is_array($post_type))
			$post_type = reset($post_type);
		$post_type_object = get_post_type_object($post_type);
		if(! $post_type_object->has_archive)
			$title = post_type_archive_title('', false);
	}

	// If there's a category or tag
	if(is_category() || is_tag()) {
		$title = single_term_title('', false);
	}

	// If there's a taxonomy
	if(is_tax()) {
		$term = get_queried_object();
		if($term) {
			$tax = get_taxonomy($term->taxonomy);
			$title = single_term_title('', false);
		}
	}

	// If there's an author
	if(is_author()) {
		$author = get_queried_object();
		if($author)
			$title = $author->display_name;
	}

	// Post type archives with has_archive should override terms.
	if(is_post_type_archive() && $post_type_object->has_archive)
		$title = post_type_archive_title('', false);

	// If there's a month
	if(is_archive() && !empty($m)) {
		$my_year = substr($m, 0, 4);
		$my_month = $wp_locale->get_month(substr($m, 4, 2));
		$my_day = intval(substr($m, 6, 2));
		$title = $my_year . ($my_month ? $t_sep . $my_month : '') . ($my_day ? $t_sep . $my_day : '');
	}

	// If there's a year
	if(is_archive() && !empty($year)) {
		$title = $year;
		if(!empty($monthnum))
			$title .= $t_sep . $wp_locale->get_month($monthnum);
		if(!empty($day))
			$title .= $t_sep . zeroise($day, 2);
	}

	// If it's a search
	if(is_search()) {
		/* translators: 1: separator, 2: search phrase */
		$title = sprintf(wp_kses(__('<span class="light">Search Results</span> <span class="highlight">"%1$s"</span>', 'cryption'), array('span' => array('class' => array()))), strip_tags($search));
	}

	// If it's a 404 page
	if(is_404()) {
		$title = esc_html__('Page not found', 'cryption');
		if(get_post(cryption_get_option('404_page'))) {
			$title = get_the_title(cryption_get_option('404_page'));
		}
	}

	$prefix = '';
	if(!empty($title))
		$prefix = " $sep ";

 	// // Determines position of the separator and direction of the breadcrumb
	// if('right' == $seplocation) { // sep on right, so reverse the order
	// 	$title_array = explode($t_sep, $title);
	// 	$title_array = array_reverse($title_array);
	// 	$title = implode(" $sep ", $title_array) . $prefix;
	// } else {
	// 	$title_array = explode($t_sep, $title);
	// 	$title = $prefix . implode(" $sep ", $title_array);
	// }

	/**
	 * Filter the text of the page title.
	 *
	 * @since 2.0.0
	 *
	 * @param string $title       Page title.
	 * @param string $sep         Title separator.
	 * @param string $seplocation Location of the separator (left or right).
	 */
	$title = apply_filters('cryption_title', $title, $sep, $seplocation);

	// Send it out
	if($display)
		echo $title;
	else
		return $title;
}

function cryption_page_title() {
	$output = '';
	$title_class = '';
	$css_style = '';
	$css_style_title = '';
	$css_title_margin = '';
	$css_style_excerpt = '';
	$video_bg = '';
	$title_style = 1;
	$excerpt = '';
	$hide_excerpt = 0;
	$rich_title = '';
	ob_start();
    cryption_breadcrumbs();
    $breadcrumbs = '<div class="breadcrumbs-container"><div class="container">'.ob_get_clean().'</div></div>';
	$alignment = 'center';
	if(is_singular() || is_post_type_archive('product') || is_tax('product_cat') || is_tax('product_tag') || (is_404() && get_post(cryption_get_option('404_page')))) {
		$post_id = 0;
		if(is_post_type_archive('product') || is_tax('product_cat') || is_tax('product_tag')) {
			$post_id = wc_get_page_id('shop');
		} elseif(is_404() && get_post(cryption_get_option('404_page'))) {
			$post_id = cryption_get_option('404_page');
		} else {
			global $post;
			$post_id = $post->ID;
		}
		$page_data = cryption_get_sanitize_page_title_data($post_id);
		$title_style = $page_data['title_style'];
		if($page_data['title_rich_content'] && $page_data['title_content']) {
			$rich_title = wpautop(do_shortcode(wp_kses_post($page_data['title_content'])));
		}
		if($page_data['title_background_image']) {
			$css_style .= 'background-image: url('.$page_data['title_background_image'].');';
			$title_class = 'has-background-image';
		}
		if($page_data['title_background_color']) {
			$css_style .= 'background-color: '.$page_data['title_background_color'].';';
		}
		if($page_data['title_padding_top'] >= 0) {
			$css_style .= 'padding-top: '.$page_data['title_padding_top'].'px;';
		}
		if($page_data['title_padding_bottom'] >= 0) {
			$css_style .= 'padding-bottom: '.$page_data['title_padding_bottom'].'px;';
		}
		$video_bg = cryption_video_background($page_data['title_video_type'], $page_data['title_video_background'], $page_data['title_video_aspect_ratio'], $page_data['title_menu_on_video'], $page_data['title_video_overlay_color'], $page_data['title_video_overlay_opacity'], $page_data['title_video_poster']);
		if($page_data['title_text_color']) {
			$css_style_title .= 'color: '.$page_data['title_text_color'].';';
		}
		$hide_excerpt = $page_data['title_hide_excerpt'];
		if($page_data['title_title_width'] > 0) {
			$css_style_title .= 'max-width: '.$page_data['title_title_width'].'px;';
		}
		if($page_data['title_excerpt_text_color']) {
			$css_style_excerpt .= 'color: '.$page_data['title_excerpt_text_color'].';';
		}
		if($page_data['title_excerpt_width'] > 0) {
			$css_style_excerpt .= 'max-width: '.$page_data['title_excerpt_width'].'px;';
		}
		if($page_data['title_top_margin']) {
			$css_title_margin .= 'margin-top: '.$page_data['title_top_margin'].'px;';
		}
		if($page_data['title_excerpt_top_margin']) {
			$css_style_excerpt .= 'margin-top: '.$page_data['title_excerpt_top_margin'].'px;';
		}
		if($page_data['title_alignment']) {
			$alignment = $page_data['title_alignment'];
		}
		if($page_data['title_icon']) {
			$icon_data = array();
			foreach($page_data as $key => $val) {
				if(strpos($key, 'title_icon') === 0) {
					$icon_data[str_replace('title_icon', 'icon', $key)] = $val;
				}
			}
			if(function_exists('ct_build_icon_shortcode')) {
				$output .= '<div class="page-title-icon">'.do_shortcode(ct_build_icon_shortcode($icon_data)).'</div>';
			}
		}
		$excerpt = nl2br($page_data['title_excerpt']);
	}
	if(is_search()) {
		$alignment = 'left';
		$icon_data = array(
			'icon_pack' => 'material',
			'icon' => 'f3de',
			'icon_color' => '#ffffff',
			'icon_size' => 'xlarge',
		);
		if(function_exists('ct_build_icon_shortcode')) {
			$output .= '<div class="page-title-icon">'.do_shortcode(ct_build_icon_shortcode($icon_data)).'</div>';
		}
	}

	if(is_tax() || is_category() || is_tag()) {
		$term = get_queried_object();
		$excerpt = $term->description;
	}

	$output .= '<div class="page-title-title" style="'.esc_attr($css_title_margin).'">'.($rich_title ? $rich_title : '<'.($title_style == '2' ? 'h2' : 'h1').' class="title-xlarge light" style="'.esc_attr($css_style_title).'">'.cryption_title('', false).'</'.($title_style == '2' ? 'h2' : 'h1').'>').$breadcrumbs.'</div>';
	if($excerpt && !$hide_excerpt) {
		$output .= '<div class="page-title-excerpt styled-subtitle" style="'.esc_attr($css_style_excerpt).'">'.$excerpt.'</div>';
	}
	if($title_style) {
		return '<div id="page-title" class="page-title-block page-title-alignment-'.esc_attr($alignment).' page-title-style-'.esc_attr($title_style).' '.esc_attr($title_class).'" style="'.esc_attr($css_style).'">'.$video_bg.'<div class="container">'.$output.'</div></div>';
	}
	return false;
}

function cryption_post_type_archive_title($label, $post_type) {
	if($post_type == 'product') {
		$shop_page_id = wc_get_page_id('shop');
		$page_title = get_the_title($shop_page_id);
		return $page_title;
	}
	return $label;
}
add_filter('post_type_archive_title', 'cryption_post_type_archive_title', 10, 2);

add_filter('woocommerce_show_page_title', '__return_false');

/* EXCERPT */

function cryption_excerpt_length($length) {
	return cryption_get_option('excerpt_length') ? intval(cryption_get_option('excerpt_length')) : 20;
}
add_filter('excerpt_length', 'cryption_excerpt_length');

function cryption_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'cryption_excerpt_more');

/* EDITOR */

add_action('admin_init', 'cryption_admin_init');
function cryption_admin_init() {
	add_filter('tiny_mce_before_init', 'cryption_init_editor');
	add_filter('mce_buttons_2', 'cryption_mce_buttons_2');
}

function cryption_mce_buttons_2($buttons) {
	array_unshift($buttons, 'styleselect');
	return $buttons;
}

function cryption_init_editor($settings) {
	$style_formats = array(
		array(
			'title' => esc_html__('Styled Subtitle', 'cryption'),
			'block' => 'div',
			'classes' => 'styled-subtitle'
		),
		array(
			'title' => esc_html__('Title H1', 'cryption'),
			'block' => 'div',
			'classes' => 'title-h1'
		),
		array(
			'title' => esc_html__('Title H2', 'cryption'),
			'block' => 'div',
			'classes' => 'title-h2'
		),
		array(
			'title' => esc_html__('Title H3', 'cryption'),
			'block' => 'div',
			'classes' => 'title-h3'
		),
		array(
			'title' => esc_html__('Title H4', 'cryption'),
			'block' => 'div',
			'classes' => 'title-h4'
		),
		array(
			'title' => esc_html__('Title H5', 'cryption'),
			'block' => 'div',
			'classes' => 'title-h5'
		),
		array(
			'title' => esc_html__('Title H6', 'cryption'),
			'block' => 'div',
			'classes' => 'title-h6'
		),
		array(
			'title' => esc_html__('XLarge Title', 'cryption'),
			'block' => 'div',
			'classes' => 'title-xlarge'
		),
		array(
			'title' => esc_html__('Letter-spacing Title', 'cryption'),
			'inline' => 'span',
			'classes' => 'letter-spacing'
		),
		array(
			'title' => esc_html__('Light Title', 'cryption'),
			'inline' => 'span',
			'classes' => 'light'
		),
		array(
			'title' => esc_html__('Body small', 'cryption'),
			'block' => 'div',
			'classes' => 'small-body'
		),
	);
	$settings['wordpress_adv_hidden'] = false;
	$settings['style_formats'] = json_encode($style_formats);
	return $settings;
}

/* SOCIALS */

function cryption_print_socials($type = '') {
	$socials_icons = array(
		'twitter' => cryption_get_option('twitter_active'),
		'facebook' => cryption_get_option('facebook_active'),
		'linkedin' => cryption_get_option('linkedin_active'),
		'googleplus' => cryption_get_option('googleplus_active'),
		'stumbleupon' => cryption_get_option('stumbleupon_active'),
		'rss' => cryption_get_option('rss_active'),
		'vimeo' => cryption_get_option('vimeo_active'),
		'instagram' => cryption_get_option('instagram_active'),
		'pinterest' => cryption_get_option('pinterest_active'),
		'youtube' => cryption_get_option('youtube_active'),
		'flickr' => cryption_get_option('flickr_active'),
		'telegram' => cryption_get_option('telegram_active'),
		'medium' => cryption_get_option('medium_active'),
		'reddit' => cryption_get_option('reddit_active'),
		'slack' => cryption_get_option('slack_active'),
	);
	if(in_array(1, $socials_icons)) {
?>
	<div class="socials inline-inside">
		<?php foreach($socials_icons as $name => $active) : ?>
			<?php if($active) : ?>
				<a class="socials-item" href="<?php echo esc_url(cryption_get_option($name . '_link')); ?>" target="_blank" title="<?php echo esc_attr($name); ?>"><i class="socials-item-icon <?php echo esc_attr($name); ?> <?php echo ($type ? 'social-item-'.$type : ''); ?>"></i></a>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php do_action('cryption_print_socials'); ?>
	</div>
<?php
	}
}

/* PAGINATION */

function cryption_pagination($query = false, $centered=false) {
	if(!$query) {
		$query = $GLOBALS['wp_query'];
	}
	if($query->max_num_pages < 2) {
		return;
	}

	$paged        = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
	$pagenum_link = html_entity_decode(get_pagenum_link());
	$query_args   = array();
	$url_parts    = explode('?', $pagenum_link);

	if(isset($url_parts[1])) {
		wp_parse_str($url_parts[1], $query_args);
	}

	$pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
	$pagenum_link = trailingslashit($pagenum_link) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit('page/%#%', 'paged') : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links(array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $query->max_num_pages,
		'current'  => $paged,
		'mid_size' => 3,
		'add_args' => array_map('urlencode', $query_args),
		'prev_text' => '',
		'next_text' => '',
	));

	if($links) :

	?>
	<div class="ct-pagination<?php echo ($centered ? ' centered-box' : ''); ?>"><div class="ct-pagination-links">
		<?php echo $links; ?>
	</div></div><!-- .pagination -->
	<?php
	endif;
}

if(!function_exists('hex_to_rgb')) {
	function hex_to_rgb($color) {
		if(strpos($color, '#') === 0) {
			$color = substr($color, 1);
			if(strlen($color) == 3) {
				return array(hexdec($color[0]), hexdec($color[1]), hexdec($color[2]));
			} elseif(strlen($color) == 6) {
				return array(hexdec(substr($color, 0, 2)), hexdec(substr($color, 2, 2)), hexdec(substr($color, 4, 2)));
			}
		}
		return $color;
	}
}

if(!function_exists('cryption_user_icons_info_link')) {
	function cryption_user_icons_info_link($pack = '') {
		return esc_url(apply_filters('ct_user_icons_info_link', get_template_directory_uri().'/fonts/icons-list-'.$pack.'.html', $pack));
	}
}

/* THUMBNAILS */

function cryption_post_thumbnail($size = 'ct-post-thumb', $dummy = true, $class='img-responsive img-circle', $attr = '') {
	if (empty($attr)) {
		$attr = array();
	}
	$attr = array_merge($attr, array('class' => $class));

	if (!empty($attr['srcset']) && is_array($attr['srcset'])) {
		$srcset_condtions = array();
		foreach ($attr['srcset'] as $condition => $condition_size) {
			$condition_size_image = cryption_generate_thumbnail_src(get_post_thumbnail_id(), $condition_size, false);
			if ($condition_size_image) {
				$srcset_condtions[] = esc_url($condition_size_image[0]) . ' ' . $condition;
			}
		}
		$attr['srcset'] = implode(', ', $srcset_condtions);
		//$attr['sizes'] = '100vw';
	}

	if(has_post_thumbnail()) {
		the_post_thumbnail($size, $attr);
	} elseif($dummy) {
		echo '<span class="gem-dummy '.esc_attr($class).'"></span>';
	}
}

function cryption_attachment_url($attachcment, $size = 'full') {
	if((int)$attachcment > 0 && ($image_url = wp_get_attachment_url($attachcment, $size)) !== false) {
		return $image_url;
	}
	return false;
}

function cryption_generate_thumbnail_src_old($attachment_id, $size) {
	if(in_array($size, array_keys(cryption_image_sizes()))) {
		$filepath = get_attached_file($attachment_id);
		$thumbFilepath = $filepath;
		$image = wp_get_image_editor($filepath);
		if(!is_wp_error($image) && $image) {
			$thumbFilepath = $image->generate_filename($size);
			if(!file_exists($thumbFilepath)) {
				$cryption_image_sizes = cryption_image_sizes();
				if(!is_wp_error($image) && isset($cryption_image_sizes[$size])) {
					$image->resize($cryption_image_sizes[$size][0], $cryption_image_sizes[$size][1], $cryption_image_sizes[$size][2]);
					$image = $image->save($image->generate_filename($size));
				} else {
					$thumbFilepath = $filepath;
				}
			}
		}
		$image = wp_get_image_editor($thumbFilepath);
		if(!is_wp_error($image) && $image) {
			$upload_dir = wp_upload_dir();
			$sizes = $image->get_size();
			return array($upload_dir['baseurl'].'/'._wp_relative_upload_path($thumbFilepath), $sizes['width'], $sizes['height']);
		}
	}
	return wp_get_attachment_image_src($attachment_id, $size);
}

function cryption_get_thumbnail_image($attachment_id, $size, $icon = false, $attr = '') {
	$html = '';
	$image = cryption_generate_thumbnail_src($attachment_id, $size, $icon);
	if($image) {
		list($src, $width, $height) = $image;
		$hwstring = image_hwstring($width, $height);
		if(is_array($size))
			$size = join('x', $size);
		$attachment = get_post($attachment_id);
		$default_attr = array(
			'src' => $src,
			'class' => "attachment-$size",
			'alt' => trim(strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true))),
		);
		if(empty($default_attr['alt']))
			$default_attr['alt'] = trim(strip_tags($attachment->post_excerpt));
		if(empty($default_attr['alt']))
			$default_attr['alt'] = trim(strip_tags($attachment->post_title));

		$attr = wp_parse_args($attr, $default_attr);
		$attr = apply_filters('wp_get_attachment_image_attributes', $attr, $attachment);
		$attr = array_map('esc_attr', $attr);
		$html = rtrim("<img $hwstring");
		foreach ($attr as $name => $value) {
			$html .= " $name=" . '"' . $value . '"';
		}
		$html .= ' />';
	}

	return $html;
}

function cryption_get_the_post_thumbnail($html, $post_id, $post_thumbnail_id, $size, $attr) {
	if(in_array($size, array_keys(cryption_image_sizes()))) {
		if($post_thumbnail_id) {
			do_action('begin_fetch_post_thumbnail_html', $post_id, $post_thumbnail_id, $size);
			if(in_the_loop())
				update_post_thumbnail_cache();
			$html = cryption_get_thumbnail_image($post_thumbnail_id, $size, false, $attr);
			do_action('end_fetch_post_thumbnail_html', $post_id, $post_thumbnail_id, $size);
		} else {
			$html = '';
		}
	}
	return $html;
}
add_filter('post_thumbnail_html', 'cryption_get_the_post_thumbnail', 10, 5);

function cryption_image_sizes() {
	return apply_filters('cryption_image_sizes', array(
		'ct-post-thumb-large' => array(256, 256, true),
		'ct-post-thumb-medium' => array(128, 128, true),
		'ct-post-thumb-small' => array(80, 80, true),

		'ct-portfolio-justified' => array(844, 767, true),

		'ct-portfolio-justified-2x' => array(644, 585, true),
		'ct-portfolio-justified-2x-500' => array(605, 550, true),
		'ct-portfolio-justified-3x' => array(429, 390, true),
		'ct-portfolio-justified-4x' => array(321, 292, true),
		'ct-portfolio-justified-fullwidth-4x' => array(509, 463, true),
		'ct-portfolio-justified-fullwidth-5x' => array(407, 370, true),

		'ct-portfolio-masonry-2x' => array(644, 0, true),
		'ct-portfolio-masonry-2x-500' => array(605, 0, true),
		'ct-portfolio-masonry-3x' => array(429, 0, true),
		'ct-portfolio-masonry-4x' => array(321, 0, true),
		'ct-portfolio-masonry-fullwidth-4x' => array(509, 0, true),
		'ct-portfolio-masonry-fullwidth-5x' => array(407, 0, true),

		'ct-gallery-justified-2x' => array(644, 585, true),
		'ct-gallery-justified-2x-500' => array(605, 550, true),
		'ct-gallery-justified-3x' => array(429, 390, true),
		'ct-gallery-justified-4x' => array(321, 292, true),
		'ct-gallery-justified-5x' => array(347, 316, true),
		'ct-gallery-justified-4x-small' => array(279, 254, true),
		'ct-gallery-justified-fullwidth-4x' => array(509, 463, true),
		'ct-gallery-justified-fullwidth-5x' => array(407, 370, true),
		'ct-gallery-justified-double-4x-set' => array(671, 610, true),
		'ct-gallery-justified-double-4x-set-horizontal' => array(671, 305, true),
		'ct-gallery-justified-double-4x-set-vertical' => array(336, 671, true),

		'ct-gallery-masonry-2x' => array(644, 0, true),
		'ct-gallery-masonry-2x-500' => array(605, 0, true),
		'ct-gallery-masonry-3x' => array(429, 0, true),
		'ct-gallery-masonry-4x' => array(321, 0, true),
		'ct-gallery-masonry-5x' => array(347, 0, true),
		'ct-gallery-masonry-4x-small' => array(279, 0, true),
		'ct-gallery-masonry-fullwidth-4x' => array(509, 0, true),
		'ct-gallery-masonry-fullwidth-5x' => array(407, 0, true),

		'ct-blog-masonry-3x' => array(360, 0, true),
		'ct-blog-masonry-3x-450' => array(450, 0, true),
		'ct-blog-masonry-3x-600' => array(600, 0, true),

		'ct-blog-default-large' => array(1170, 540, true),
		'ct-blog-default-medium' => array(780, 360, true),
		'ct-blog-default-small' => array(520, 240, true),
		'ct-blog-timeline' => array(440, 0, true),
		'ct-blog-timeline-small' => array(370, 0, true),
		'ct-blog-timeline-large' => array(720, 0, true),
		'ct-blog-default' => array(1170, 540, true),
		'ct-blog-justified' => array(640, 480, true),
		'ct-blog-justified-3x' => array(360, 270, true),
		'ct-blog-justified-3x-small' => array(320, 240, true),
		'ct-blog-justified-4x' => array(220, 165, true),
		'ct-blog-justified-sticky' => array(1280, 960, true),
		'ct-blog-masonry-100' => array(380, 0, true),
		'ct-blog-masonry-100-medium' => array(450, 0, true),
		'ct-blog-masonry-100-small' => array(230, 0, true),
		'ct-blog-masonry' => array(640, 0, true),
		'ct-blog-masonry-4x' => array(258, 0, true),
		'ct-blog-masonry-sticky' => array(1280, 0, true),
		'ct-blog-compact' => array(366, 296, true),
		'`' => array(1170, 525, true),
		'ct-blog-slider-halfwidth' => array(564, 524, true),

		'ct-portfolio-double-2x' => array(1287, 1170, true),

		'ct-portfolio-double-3x' => array(843, 934, true),
		'ct-portfolio-double-3x-gap-0' => array(858, 948, true),
		'ct-portfolio-double-3x-gap-18' => array(851, 942, true),
		'ct-portfolio-double-3x-hover' => array(843, 766, true),
		'ct-portfolio-double-3x-hover-gap-0' => array(858, 780, true),
		'ct-portfolio-double-3x-hover-gap-18' => array(851, 774, true),

		'ct-portfolio-double-4x' => array(620, 732, true),
		'ct-portfolio-double-4x-gap-0' => array(644, 753, true),
		'ct-portfolio-double-4x-gap-18' => array(634, 744, true),
		'ct-portfolio-double-4x-hover' => array(620, 563 , true),
		'ct-portfolio-double-4x-hover-gap-0' => array(643, 584, true),
		'ct-portfolio-double-4x-hover-gap-18' => array(634, 575, true),

		'ct-portfolio-double-100' => array(1056, 960, true),


		'ct-portfolio-double-100-horizontal' => array(1056, 585, true),

		'ct-portfolio-double-2x-horizontal' => array(1287, 585, true),

		'ct-portfolio-double-3x-horizontal' => array(843, 362, true),
		'ct-portfolio-double-3x-gap-0-horizontal' => array(843, 390, true),
		'ct-portfolio-double-3x-gap-18-horizontal' => array(843, 378, true),
		'ct-portfolio-double-3x-hover-horizontal' => array(843, 362, true),
		'ct-portfolio-double-3x-hover-gap-0-horizontal' => array(843, 390, true),
		'ct-portfolio-double-3x-hover-gap-18-horizontal' => array(843, 378, true),

		'ct-portfolio-double-4x-horizontal' => array(868, 366, true),
		'ct-portfolio-double-4x-gap-0-horizontal' => array(868, 409, true),
		'ct-portfolio-double-4x-gap-18-horizontal' => array(868, 391, true),
		'ct-portfolio-double-4x-hover-horizontal' => array(868, 366, true),
		'ct-portfolio-double-4x-hover-gap-0-horizontal' => array(868, 409, true),
		'ct-portfolio-double-4x-hover-gap-18-horizontal' => array(868, 391, true),

		'ct-portfolio-double-100-vertical' => array(602, 1500, true),

		'ct-portfolio-double-2x-vertical' => array(1287, 585, true),

		'ct-portfolio-double-3x-vertical' => array(518, 1212, true),
		'ct-portfolio-double-3x-gap-0-vertical' => array(558, 1229, true),
		'ct-portfolio-double-3x-gap-18-vertical' => array(540, 1222, true),
		'ct-portfolio-double-3x-hover-vertical' => array(518, 995, true),
		'ct-portfolio-double-3x-hover-gap-0-vertical' => array(558, 1013, true),
		'ct-portfolio-double-3x-hover-gap-18-vertical' => array(540, 1005, true),

		'ct-portfolio-double-4x-vertical' => array(373, 952, true),
		'ct-portfolio-double-4x-gap-0-vertical' => array(380, 983, true),
		'ct-portfolio-double-4x-gap-18-vertical' => array(399, 965, true),
		'ct-portfolio-double-4x-hover-vertical' => array(373, 952, true),
		'ct-portfolio-double-4x-hover-gap-0-vertical' => array(418, 760, true),
		'ct-portfolio-double-4x-hover-gap-18-vertical' => array(399, 748, true),

		'ct-portfolio-1x' => array(858, 420, true),
		'ct-portfolio-1x-sidebar' => array(751, 500, true),
		'ct-portfolio-1x-hover' => array(1287, 567, true),

		'ct-portfolio-metro' => array(0, 500, false),
		'ct-portfolio-metro-medium' => array(0, 300, false),
		'ct-portfolio-metro-retina' => array(0, 1000, false),

		'ct-portfolio-masonry' => array(754, 0, false),
		'ct-portfolio-masonry-double' => array(1508, 0, false),

		'ct-portfolio-masonry-double-horizontal' => array(1508, 0, false),
		'ct-portfolio-masonry-double-vertical' => array(754, 0, false),

		'ct-gallery-justified' => array(660, 600, true),
		'ct-gallery-justified-double' => array(880, 800, true),
		'ct-gallery-justified-double-horizontal' => array(880, 400, true),
		'ct-gallery-justified-double-vertical' => array(440, 870, true),

		'ct-gallery-justified-100' => array(660, 600, true),
		'ct-gallery-justified-double-100' => array(1320, 1200, true),
		'ct-gallery-justified-double-100-horizontal' => array(1320, 600, true),
		'ct-gallery-justified-double-100-vertical' => array(660, 1200, true),

		'ct-gallery-justified-double-100-horizontal-4' => array(1019, 464, true),
		'ct-gallery-justified-double-100-horizontal-5' => array(814, 371, true),
		'ct-gallery-justified-double-100-horizontal-6' => array(594, 271, true),
		'ct-gallery-justified-double-100-squared-4' => array(1019, 927, true),
		'ct-gallery-justified-double-100-squared-5' => array(814, 741, true),
		'ct-gallery-justified-double-100-squared-6' => array(594, 541, true),
		'ct-gallery-justified-double-100-vertical-4' => array(510, 928, true),
		'ct-gallery-justified-double-100-vertical-5' => array(407, 742, true),
		'ct-gallery-justified-double-100-vertical-6' => array(297, 542, true),

		'ct-gallery-masonry-double-100-horizontal-4' => array(1019, 0, true),
		'ct-gallery-masonry-double-100-horizontal-5' => array(814, 0, true),
		'ct-gallery-masonry-double-100-horizontal-6' => array(594, 0, true),
		'ct-gallery-masonry-double-100-squared-4' => array(1019, 0, true),
		'ct-gallery-masonry-double-100-squared-5' => array(814, 0, true),
		'ct-gallery-masonry-double-100-squared-6' => array(594, 0, true),
		'ct-gallery-masonry-double-100-vertical-4' => array(510, 0, true),
		'ct-gallery-masonry-double-100-vertical-5' => array(407, 0, true),
		'ct-gallery-masonry-double-100-vertical-6' => array(297, 0, true),

		'ct-gallery-justified-double-4x' => array(766, 697, true),
		'ct-gallery-justified-double-4x-squared' => array(766, 697, true),
		'ct-gallery-justified-double-4x-horizontal' => array(766, 349, true),
		'ct-gallery-justified-double-4x-vertical' => array(383, 697, true),

		'ct-gallery-masonry-double-4x-squared' => array(766, 0, true),
		'ct-gallery-masonry-double-4x-horizontal' => array(766, 0, true),
		'ct-gallery-masonry-double-4x-vertical' => array(383, 0, true),

		'ct-gallery-masonry' => array(660, 0, false),
		'ct-gallery-masonry-double' => array(880, 0, false),
		'ct-gallery-masonry-double-4x' => array(766, 0, true),
		'ct-gallery-masonry-double-horizontal' => array(880, 0, false),
		'ct-gallery-masonry-double-vertical' => array(440, 0, false),

		'ct-gallery-masonry-100' => array(660, 0, false),
		'ct-gallery-masonry-double-100' => array(1320, 0, false),
		'ct-gallery-masonry-double-100-horizontal' => array(1320, 0, false),
		'ct-gallery-masonry-double-100-vertical' => array(660, 0, false),

		'ct-gallery-metro' => array(0, 500, false),
		'ct-gallery-metro-medium' => array(0, 300, false),
		'ct-gallery-metro-retina' => array(0, 1000, false),
		'ct-gallery-fullwidth' => array(1170, 540, true),
		'ct-gallery-sidebar' => array(867, 540, true),
		'ct-gallery-simple' => array(522, 700, true),
		'ct-gallery-simple-1x' => array(261, 350, true),
		'ct-person' => array(400, 400, true),
		'ct-person-50' => array(50, 50, true),
		'ct-person-80' => array(80, 80, true),
		'ct-person-100' => array(100, 100, true),
		'ct-person-160' => array(160, 160, true),
		'ct-person-240' => array(240, 240, true),
		'ct-person-800' => array(800, 800, true),
		'ct-testimonial' => array(400, 400, true),
		'ct-news-carousel' => array(144, 144, true),
		'ct-portfolio-carusel-3x' => array(473, 290, true),
		'ct-portfolio-carusel-4x' => array(580, 370, true),
		'ct-portfolio-carusel-5x' => array(465, 298, true),
		'ct-portfolio-carusel-full-3x' => array(704, 450, true),
		'ct-widget-column-1x' => array(80, 80, true),
		'ct-widget-column-2x' => array(160, 160, true),
	));
}

function ct_image_sizes() {
	return cryption_image_sizes();
}

function cryption_remove_generate_thumbnails($metadata, $attachment_id) {
	foreach(cryption_image_sizes() as $key => $val) {
		$filepath = get_attached_file($attachment_id);
		$image = wp_get_image_editor($filepath);
		if(!is_wp_error($image) && $image) {
			$thumbFilepath = $image->generate_filename($key);
			if(file_exists($thumbFilepath)) {
				unlink($thumbFilepath);
			}
		}
	}
	return $metadata;
}
add_filter('wp_generate_attachment_metadata', 'cryption_remove_generate_thumbnails', 10, 2);

/* FOOTER */

function cryption_print_head_script() {
	$effects_disabled = false;
	if(is_home()) {
		$effects_disabled = cryption_get_option('home_effects_disabled', false);
	} else {
		global $post;
		if(is_object($post)) {
			$cryption_page_data = get_post_meta($post->ID, 'ct_page_data', true);
		} elseif((is_post_type_archive('product') || is_tax('product_cat') || is_tax('product_tag')) && function_exists('wc_get_page_id')) {
			$cryption_page_data = get_post_meta(wc_get_page_id('shop'), 'ct_page_data', true);
		} else {
			$cryption_page_data = null;
		}

		if($cryption_page_data) {
			$effects_disabled = isset($cryption_page_data['effects_disabled']) ? (bool) $cryption_page_data['effects_disabled'] : false;
					}
				}

	if ($effects_disabled) {
		wp_enqueue_style('ct-effects-disabled', get_template_directory_uri() . '/css/ct-effects-disabled.css');
	}

	wp_enqueue_script('ct-settings-init', get_template_directory_uri() . '/js/ct-settings-init.js', false, false, false);
	wp_localize_script('ct-settings-init', 'ctSettings', array(
		'isTouch' => false,
		'forcedLasyDisabled' => $effects_disabled,
		'tabletPortrait' => cryption_get_option('menu_appearance_tablet_portrait') == 'responsive',
		'tabletLandscape' => cryption_get_option('menu_appearance_tablet_landscape') == 'responsive',
		'topAreaMobileDisable' => cryption_get_option('top_area_disable_mobile') == 'responsive',
		'parallaxDisabled' => false,
		'fillTopArea' => false,
		'themePath' => get_template_directory_uri(),
		'rootUrl' => get_site_url(),
		'mobileEffectsEnabled' => cryption_get_option('enable_mobile_lazy_loading') == 1,
		'isRTL' => is_rtl()
	));
}
add_action('wp_enqueue_scripts', 'cryption_print_head_script', 1);


/* FONTS MANAGER */

/* Create fonts manager page */
// add_action( 'admin_menu', 'cryption_fonts_manager_add_page');
// function cryption_fonts_manager_add_page() {
// 	$page = add_theme_page(esc_html__('Fonts Manager', 'cryption'), esc_html__('Fonts Manager', 'cryption'), 'edit_theme_options', 'fonts-manager', 'cryption_fonts_manager_page');
// 	add_action('load-' . $page, 'cryption_fonts_manager_page_prepend');
// }

/* Admin theme page scripts & css */
function cryption_fonts_manager_page_prepend() {
	wp_enqueue_media();
	wp_enqueue_script('ct-file-selector', get_template_directory_uri() . '/js/ct-file-selector.js');
	wp_enqueue_script('ct-font-manager', get_template_directory_uri() . '/js/ct-font-manager.js');
}

/* Build admin theme page form */
function cryption_fonts_manager_page(){
	$additionals_fonts = get_option('ct_additionals_fonts');
?>
<div class="wrap">

	<h2><?php esc_html_e('Fonts Manager', 'cryption'); ?></h2>

	<form id="fonts-manager-form" method="POST" enctype="multipart/form-data">
		<div class="font-pane empty" style="display: none;">
			<div class="remove"><a href="javascript:void(0);"><?php esc_html_e('Remove', 'cryption'); ?></a></div>
			<div class="field">
				<div class="label"><label for=""><?php esc_html_e('Font name', 'cryption'); ?></label></div>
				<div class="input"><input type="text" name="fonts[font_name][]" value="" /></div>
			</div>
			<div class="field">
				<div class="label"><label for=""><?php esc_html_e('Font file EOT url', 'cryption'); ?></label></div>
				<div class="file_url"><input type="text" name="fonts[font_url_eot][]" value="" data-type="font/eot" /></div>
			</div>
			<div class="field">
				<div class="label"><label for=""><?php esc_html_e('Font file SVG url', 'cryption'); ?></label></div>
				<div class="file_url"><input type="text" name="fonts[font_url_svg][]" value="" data-type="font/svg" /></div>
			</div>
			<div class="field">
				<div class="label"><label for=""><?php esc_html_e('ID inside SVG', 'cryption'); ?></label></div>
				<div class="input"><input type="text" name="fonts[font_svg_id][]" value="" /></div>
			</div>
			<div class="field">
				<div class="label"><label for=""><?php esc_html_e('Font file TTF url', 'cryption'); ?></label></div>
				<div class="file_url"><input type="text" name="fonts[font_url_ttf][]" value="" data-type="font/ttf" /></div>
			</div>
			<div class="field">
				<div class="label"><label for=""><?php esc_html_e('Font file WOFF url', 'cryption'); ?></label></div>
				<div class="file_url"><input type="text" name="fonts[font_url_woff][]" value="" data-type="font/woff" /></div>
			</div>
		</div>
		<?php if(is_array($additionals_fonts)) : ?>
			<?php foreach($additionals_fonts as $additionals_font) : ?>
				<div class="font-pane">
					<div class="remove"><a href="javascript:void(0);"><?php esc_html_e('Remove', 'cryption'); ?></a></div>
					<div class="field">
						<div class="label"><label for=""><?php esc_html_e('Font name', 'cryption'); ?></label></div>
						<div class="input"><input type="text" name="fonts[font_name][]" value="<?php echo esc_attr($additionals_font['font_name']); ?>" /></div>
					</div>
					<div class="field">
						<div class="label"><label for=""><?php esc_html_e('Font file EOT url', 'cryption'); ?></label></div>
						<div class="file_url"><input type="text" name="fonts[font_url_eot][]" value="<?php echo esc_attr($additionals_font['font_url_eot']); ?>" data-type="font/eot" /></div>
					</div>
					<div class="field">
						<div class="label"><label for=""><?php esc_html_e('Font file SVG url', 'cryption'); ?></label></div>
						<div class="file_url"><input type="text" name="fonts[font_url_svg][]" value="<?php echo esc_attr($additionals_font['font_url_svg']); ?>" data-type="font/svg" /></div>
					</div>
					<div class="field">
						<div class="label"><label for=""><?php esc_html_e('ID inside SVG', 'cryption'); ?></label></div>
						<div class="input"><input type="text" name="fonts[font_svg_id][]" value="<?php echo esc_attr($additionals_font['font_svg_id']); ?>" /></div>
					</div>
					<div class="field">
						<div class="label"><label for=""><?php esc_html_e('Font file TTF url', 'cryption'); ?></label></div>
						<div class="file_url"><input type="text" name="fonts[font_url_ttf][]" value="<?php echo esc_attr($additionals_font['font_url_ttf']); ?>" data-type="font/ttf" /></div>
					</div>
					<div class="field">
						<div class="label"><label for=""><?php esc_html_e('Font file WOFF url', 'cryption'); ?></label></div>
						<div class="file_url"><input type="text" name="fonts[font_url_woff][]" value="<?php echo esc_attr($additionals_font['font_url_woff']); ?>" data-type="font/woff" /></div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
		<div class="add-new"><a href="javascript:void(0);"><?php esc_html_e('+ Add new', 'cryption'); ?></a></div>
		<div class="submit"><button name="action" value="save"><?php esc_html_e('Save', 'cryption'); ?></button></div>
	</form>
</div>

<?php
}

/* Update fonts manager */
add_action('admin_menu', 'cryption_fonts_manager_update');
function cryption_fonts_manager_update() {
	if(isset($_GET['page']) && $_GET['page'] == 'fonts-manager') {
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'save') {
			if(isset($_REQUEST['fonts']) && is_array($_REQUEST['fonts'])) {
				$fonts = array();
				foreach($_REQUEST['fonts'] as $font_param => $list) {
					foreach($list as $key => $item) {
						$fonts[$key][$font_param] = $_REQUEST['fonts'][$font_param][$key];
					}
				}
				foreach($fonts as $key => $font) {
					if(!$font['font_name']) {
						unset($fonts[$key]);
					}
				}
				update_option('ct_additionals_fonts', $fonts);
			}
			wp_redirect(esc_url(admin_url('themes.php?page=fonts-manager')));
		}
	}
}

/* LAYERSLIDER SKIN */

if(cryption_is_plugin_active('LayerSlider/layerslider.php') && class_exists('LS_Sources')) {
	LS_Sources::addSkins(get_template_directory().'/ls_skin/');
}

/* JS Composer colums new grid */

function cryption_vc_base_register_front_css() {
	wp_register_style('ct_js_composer_front', get_template_directory_uri() . '/css/ct-js_composer_columns.css', array('js_composer_front'));
	add_action('wp_enqueue_scripts', 'cryption_vc_enqueueStyle_columns');
}
add_action('vc_base_register_front_css', 'cryption_vc_base_register_front_css');

function cryption_vc_enqueueStyle_columns() {
	$post = get_post();
	if(is_404() && get_post(cryption_get_option('404_page'))) {
		$post = get_post(cryption_get_option('404_page'));
	}
	if($post && preg_match( '/vc_row/', $post->post_content)) {
		wp_enqueue_style('ct_js_composer_front');
	}
}

/* JS Composer scripts */

function cryption_additional_js_composer_backend_scripts() {
	wp_register_script('ct-vc-backend-js', get_template_directory_uri() . '/js/ct-js-composer-backend.js', array('vc-backend-actions-js'), '', true);
}
add_action( 'add_meta_boxes', 'cryption_additional_js_composer_backend_scripts', 6);

function cryption_vc_backend_editor_enqueue_js_css() {
	wp_enqueue_script('ct-vc-backend-js');
}
add_action( 'vc_backend_editor_enqueue_js_css', 'cryption_vc_backend_editor_enqueue_js_css');

function check_add_breadcrumbs_woocommerce_shop() {
	if(  function_exists ( "is_woocommerce" ) && is_woocommerce()){
			return true;
	}
    $woocommerce_keys   =   array ( "woocommerce_shop_page_id" ,
                                    "woocommerce_terms_page_id" ,
                                    "woocommerce_cart_page_id" ,
                                    "woocommerce_checkout_page_id" ,
                                    "woocommerce_pay_page_id" ,
                                    "woocommerce_thanks_page_id" ,
                                    "woocommerce_myaccount_page_id" ,
                                    "woocommerce_edit_address_page_id" ,
                                    "woocommerce_view_order_page_id" ,
                                    "woocommerce_change_password_page_id" ,
                                    "woocommerce_logout_page_id" ,
                                    "woocommerce_lost_password_page_id" ) ;
    foreach ( $woocommerce_keys as $wc_page_id ) {
        if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
                return true ;
        }
    }
    return false;
}




function cryption_default_avatar ($avatar_defaults) {
	$myavatar = get_template_directory_uri() . '/images/default-avatar.png';
	$avatar_defaults[$myavatar] = esc_html__('CT Avatar', 'cryption');
	$myavatar2 = get_template_directory_uri() . '/images/avatar-1.jpg';
	$avatar_defaults[$myavatar2] = esc_html__('CT Avatar 2', 'cryption');
	return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'cryption_default_avatar' );


/* VC NEWS & BLOG, VC POST GRID SHORTCODES LOAD MORE BUTTON */
function cryption_vc_btn($a, $b){
	return cryption_button(array('extra_class' => 'vc_btn3', 'text' => esc_html__('Load more...', 'cryption'), 'background_color' => '#00bcd4', 'separator' => 'soft-double', 'size' => 'medium'));
}
add_filter('vc_gitem_template_attribute_vc_btn', 'cryption_vc_btn', 11, 2);

/* ADDITIONL MENU ITEMS */
function cryption_menu_item_search($items, $args){
	if($args->theme_location == 'primary' && !cryption_get_option('hide_search_icon')){
		$items .= '<li class="menu-item menu-item-search"><a href="#"></a><div class="minisearch"><form role="search" id="menu-searchform" class="sf" action="'. esc_url( home_url( '/' ) ) .'" method="GET"><input id="searchform-input" class="sf-input" type="text" placeholder="Search..." name="s"><span class="sf-submit-icon"></span><input id="searchform-submit" class="sf-submit" type="submit" value=""></form></div></li>';
	}
	return $items;
}
add_filter('wp_nav_menu_items', 'cryption_menu_item_search', 10, 2);

function cryption_menu_item_hamburger_widget($items, $args){
	if($args->theme_location == 'primary' && cryption_get_option('header_layout') == 'fullwidth_hamburger'){

		ob_start();
		cryption_print_socials('rounded');
		$socials = ob_get_clean();

		$items .= '<li class="menu-item menu-item-widgets"><div class="vertical-minisearch"><form role="search" id="menu-searchform" class="sf" action="'. esc_url( home_url( '/' ) ) .'" method="GET"><input id="searchform-input" class="sf-input" type="text" placeholder="Search..." name="s"><span class="sf-submit-icon"></span><input id="searchform-submit" class="sf-submit" type="submit" value=""></form></div><div class="menu-item-socials socials-colored">'. $socials .'</div></li>';
	}
	return $items;
}
add_filter('wp_nav_menu_items', 'cryption_menu_item_hamburger_widget', 100, 2);

/* PRINT LOGO */

function cryption_print_logo($header_light = '', $echo = true) {
	ob_start();
?>
<div class="site-logo">
	<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
		<?php if(cryption_get_option('logo')) : ?>
			<span class="logo"><?php cryption_get_logo_img(esc_url(cryption_get_option('logo'.$header_light)), intval(cryption_get_option('logo_width')), 'default') ?><?php if(cryption_get_option('small_logo_light') && $header_light) : ?><?php cryption_get_logo_img(esc_url(cryption_get_option('small_logo_light')), intval(cryption_get_option('small_logo_width')), 'small light') ?><?php endif; ?><?php if(cryption_get_option('small_logo')) : ?><?php cryption_get_logo_img(esc_url(cryption_get_option('small_logo')), intval(cryption_get_option('small_logo_width')), 'small') ?><?php endif; ?></span>
		<?php else : ?>
			<?php bloginfo('name'); ?>
		<?php endif; ?>
	</a>
</div>
<?php
	$output = ob_get_clean();
	if($echo) {
		echo $output;
	}
	return $output;
}

function cryption_get_logo_img($url, $width, $class = '', $echo = 1) {
	$logo = '<img src="'.esc_url(cryption_get_logo_url($url, $width, 1)).'" srcset="'.esc_url(cryption_get_logo_url($url, $width, 1)).' 1x,'.esc_url(cryption_get_logo_url($url, $width, 2)).' 2x,'.esc_url(cryption_get_logo_url($url, $width, 3)).' 3x" alt="" style="width:'.esc_attr($width).'px;"'.($class ? ' class="'.esc_attr($class).'"' : '').'/>';
	$logo = apply_filters('cryption_get_logo_img', $logo, $url, $width, $class);
	if($echo) {
		echo $logo;
	}
	return $logo;
}

function cryption_get_logo_url($url, $width, $ratio = 1) {
	$logo_url = $url;
	$logo_url = apply_filters('cryption_get_logo_url', $url, $width, $ratio);
	if($logo_url != $url) {
		return $logo_url;
	}
	$wp_upload_dir = wp_upload_dir();
	$upload_logos_dir = $wp_upload_dir['basedir'] . '/ct-logos';
	$upload_logos_url = $wp_upload_dir['baseurl'] . '/ct-logos';
	$file = explode('.', $url);
	$extention = $file[count($file)-1];
	$logo_filename = 'logo_'.md5($url).'_'.$ratio.'x.'.$extention;
	$logo_filepath = $upload_logos_dir.'/'.$logo_filename;
	if(file_exists($logo_filepath)) {
		return $upload_logos_url.'/'.$logo_filename;
	}

	if(!wp_mkdir_p($upload_logos_dir)) {
		return $logo_url;
	}

	$local_file = false;
	$temp_file = '';
	if(strpos($url, home_url('/')) === 0) {
		$temp_file = ABSPATH . str_replace(home_url('/'), '', $url);
		if(file_exists($temp_file)) {
			$local_file = true;
		}
	}
	if(!$local_file) {
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		$temp_file = download_url($url);
		if(is_wp_error($temp_file)) {
			return $logo_url;
		}
	}
	$temp_logo_filepath = $upload_logos_dir.'/temp_logo_file.'.$extention;
	$move_new_file = @copy($temp_file, $temp_logo_filepath);
	if(!$local_file) {
		unlink($temp_file);
	}
	if($move_new_file === false) {
		return $logo_url;
	}
	$image = wp_get_image_editor($temp_logo_filepath);
	if(!is_wp_error($image) && $image) {
		$image->resize($width*$ratio, 0, false);
		$image->set_quality(100);
		$image->save($logo_filepath);
		unlink($temp_logo_filepath);
		return $upload_logos_url.'/'.$logo_filename;
	}
	return $logo_url;
}

/* Hamburger fix */

function cryption_vertical_fix_logo_position($value) {
	if(($value == 'menu_center' || $value == 'center') && (cryption_get_option('header_layout') == 'fullwidth_hamburger' || cryption_get_option('header_layout') == 'vertical')) {
		return 'left';
	}
	return $value;
}
add_filter('ct_option_logo_position', 'cryption_vertical_fix_logo_position');

/* Boxed fix */

function cryption_vertical_fix_page_layout_style($value) {
	if($value == 'boxed' && (cryption_get_option('header_layout') == 'fullwidth_hamburger' || cryption_get_option('header_layout') == 'vertical')) {
		return 'fullwidth';
	}
	return $value;
}
add_filter('ct_option_page_layout_style', 'cryption_vertical_fix_page_layout_style');


/* 404 Sidebar fix */

function cryption_fix_404_pw_filter_widgets($sidebars_widgets) {
	if(is_404() && get_post(cryption_get_option('404_page'))) {
		$post = get_post(cryption_get_option('404_page'));
		if (isset($post->ID)) {
			$enable_customize = get_post_meta($post->ID, '_customize_sidebars', true);
			$_sidebars_widgets = get_post_meta($post->ID, '_sidebars_widgets', true);
		}
		if (isset($enable_customize) && $enable_customize == 'yes' && !empty($_sidebars_widgets)) {
			if (is_array($_sidebars_widgets) && isset($_sidebars_widgets['array_version']))
				unset($_sidebars_widgets['array_version']);
			$sidebars_widgets = wp_parse_args($_sidebars_widgets, $sidebars_widgets);
		}
	}
	return $sidebars_widgets;
}
add_filter('sidebars_widgets', 'cryption_fix_404_pw_filter_widgets');

/* USER ICON PACK */

if(!function_exists('cryption_icon_userpack_enabled')) {
function cryption_icon_userpack_enabled() {
	return apply_filters('ct_icon_userpack_enabled', false);
}
}

if(!function_exists('cryption_icon_packs_select_array')) {
function cryption_icon_packs_select_array() {
	$packs = array('elegant' => esc_html__('Elegant', 'cryption'), 'material' => esc_html__('Material Design', 'cryption'), 'fontawesome' => esc_html__('FontAwesome', 'cryption'));
	if(cryption_icon_userpack_enabled()) {
		$packs['userpack'] = esc_html__('UserPack', 'cryption');
	}
	return $packs;
}
}

if(!function_exists('cryption_icon_packs_infos')) {
function cryption_icon_packs_infos() {
	ob_start();
?>
<?php esc_html_e('Enter icon code', 'cryption'); ?>.
<a class="ct-icon-info ct-icon-info-elegant" href="<?php echo esc_url(cryption_user_icons_info_link('elegant')); ?>" onclick="tb_show('<?php esc_attr_e('Icons info', 'cryption'); ?>', this.href+'?TB_iframe=true'); return false;"><?php esc_html_e('Show Elegant Icon Codes', 'cryption'); ?></a>
<a class="ct-icon-info ct-icon-info-material" href="<?php echo esc_url(cryption_user_icons_info_link('material')); ?>" onclick="tb_show('<?php esc_attr_e('Icons info', 'cryption'); ?>', this.href+'?TB_iframe=true'); return false;"><?php esc_html_e('Show Material Design Icon Codes', 'cryption'); ?></a>
<a class="ct-icon-info ct-icon-info-fontawesome" href="<?php echo esc_url(cryption_user_icons_info_link('fontawesome')); ?>" onclick="tb_show('<?php esc_attr_e('Icons info', 'cryption'); ?>', this.href+'?TB_iframe=true'); return false;"><?php esc_html_e('Show FontAwesome Icon Codes', 'cryption'); ?></a>
<?php if(cryption_icon_userpack_enabled()) : ?>
<a class="ct-icon-info ct-icon-info-userpack" href="<?php echo esc_url(cryption_user_icons_info_link('userpack')); ?>" onclick="tb_show('<?php esc_attr_e('Icons info', 'cryption'); ?>', this.href+'?TB_iframe=true'); return false;"><?php esc_html_e('Show UserPack Icon Codes', 'cryption'); ?></a>
<?php endif; ?>
<?php
	return ob_get_clean();
}
}


/* BODY CLASS */

function cryption_body_class($classes) {
	$page_id = is_singular() ? get_the_ID() : 0;
	if(is_404() && get_post(cryption_get_option('404_page'))) {
		$page_id = cryption_get_option('404_page');
	}
	if((is_post_type_archive('product') || is_tax('product_cat') || is_tax('product_tag')) && function_exists('wc_get_page_id')) {
		$page_id = wc_get_page_id('shop');
	}
	$effects_params = cryption_get_sanitize_page_effects_data($page_id);
	$body_classes = array();
	if(is_home() && cryption_get_option('home_content_enabled')) {
		$body_classes[] = 'home-constructor';
	}
	if($effects_params['effects_one_pager']) {
		$body_classes[] = 'one-pager';
	}
	return array_merge($classes, $body_classes);
}
add_filter('body_class', 'cryption_body_class');


/* SEACRH FORMS */

function cryption_search_form_vertical_header($form){
	return '<div class="vertical-minisearch"><form role="search" id="searchform" class="sf" action="'.esc_url( home_url( '/' ) ) .'" method="GET"><input id="searchform-input" class="sf-input" type="text" placeholder="Search..." name="s"><span class="sf-submit-icon"></span><input id="searchform-submit" class="sf-submit" type="submit" value=""></form></div>';
}

function cryption_search_form_nothing_found($form){
	ob_start();
?>
<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<table><tr>
		<td><input type="text" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php esc_html_e('Search...', 'cryption'); ?>" /></td>
		<td><?php cryption_button(array(
			'tag' => 'button',
			'text' => esc_html__('Search', 'cryption'),
			'size' => 'medium',
			'corner' => 3,
			'extra_class' => 'searchform-submit',
			'attributes' => array('type' => 'submit', 'value' => esc_html__('Search', 'cryption')),
		), 1); ?></td>
	</tr></table>
</form>
<?php
	$form = ob_get_clean();
	return $form;
}


/* MEJS SETTINGS */

function cryption_mejs_settings($mejs_settings) {
	$mejs_settings['hideVideoControlsOnLoad'] = true;
	$mejs_settings['audioVolume'] = 'vertical';
	return $mejs_settings;
}
add_filter('mejs_settings', 'cryption_mejs_settings');

/* template-tags */
if ( ! function_exists( 'cryption_posted_on' ) ) :
function cryption_posted_on() {
	printf( '<span class="entry-date">%1$s</span>', esc_html(get_the_date()));
}
endif;

function cryption_category_transient_flusher() {
	delete_transient( 'ct_category_count' );
}
add_action( 'edit_category', 'cryption_category_transient_flusher' );
add_action( 'save_post',     'cryption_category_transient_flusher' );


function cryption_file_get_contents($file) {
	include_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php');
	include_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php');
	$filesystem = new WP_Filesystem_Direct('');
	$var = $filesystem->get_contents($file);
	return $var;
}

/*breadcrumbs*/

function cryption_breadcrumbs() {
    // $text['home'] = esc_html__('Home', 'cryption');
    // $text['category'] = esc_html__('Blog Category', 'cryption');
    $text['search'] =  esc_html__('Search Results', 'cryption');
    // $text['tag'] = esc_html__('Tag', 'cryption');
    // $text['author'] = esc_html__('Posts by', 'cryption');
    // $text['404'] = esc_html__('Posts by', 'cryption');
    // $text['page'] = '%s';
    // $text['cpage'] = esc_html__('Comment %s', 'cryption');

    $delimiter = '<span class="bc-devider"></span>';
    $delim_before = '<span class="divider">';
    $delim_after = '</span>';
    $show_home_link = 1;
    $show_on_home = 0;
    $show_title = 1;
    $show_current = 1;
    $before = '<span class="current">';
    $after = '</span>';


    global $post;
    $home_link = home_url('/');
    $link_before = '<span>';
    $link_after = '</span>';
    $link_attr = ' itemprop="url"';
    $link_in_before = '<span itemprop="title">';
    $link_in_after = '</span>';
    $link = $link_before . '<a href="%1$s"' . $link_attr . '>' . $link_in_before . '%2$s' . $link_in_after . '</a>' . $link_after;
    $frontpage_id = get_option('page_on_front');
    $thisPostID = get_the_ID();
    $parent_id = wp_get_post_parent_id( $thisPostID );
    $delimiter = ' ' . $delim_before . $delimiter . $delim_after . ' ';

    if (is_home() || is_front_page()) {

        if ($show_on_home == 1) echo '<div class="breadcrumbs"><a href="' . esc_url($home_link) . '">' . $text['home'] . '</a></div>';

    } else {

        echo '<div class="breadcrumbs">';
        if ($show_home_link == 1) echo sprintf($link, esc_url($home_link), $text['home']);

        if ( is_category() ) {
            $cat = get_category(get_query_var('cat'), false);

            if ($cat->parent != 0) {
                $cats = get_category_parents($cat->parent, TRUE, $delimiter);
                $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                if ($show_home_link == 1) echo $delimiter;
                echo $cats;
            }

            if ( get_query_var('paged') ) {
                $cat = $cat->cat_ID;
                echo $delimiter . sprintf($link, get_category_link($cat), get_cat_name($cat)) . $delimiter . $before . sprintf($text['page'], get_query_var('paged')) . $after;
            } else {
                if ($show_current == 1) echo $delimiter . $before . sprintf($text['category'], single_cat_title('', false)) . $after;
            }

        } elseif ( is_search() ) {
            if ($show_home_link == 1) echo $delimiter;
            echo $before . sprintf($text['search'], get_search_query()) . $after;
        } elseif ( is_day() ) {
            if ($show_home_link == 1) echo $delimiter;
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . $delimiter;
            echo $before . get_the_time('d') . $after;

        } elseif ( is_month() ) {
            if ($show_home_link == 1) echo $delimiter;
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo $before . get_the_time('F') . $after;

        } elseif ( is_year() ) {
            if ($show_home_link == 1) echo $delimiter;
            echo $before . get_the_time('Y') . $after;

        }


        elseif ( is_single() && !is_attachment() ) {
            if ($show_home_link == 1) echo $delimiter;
            if ( get_post_type() != 'post' ) {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                $post_type = get_post_type_object(get_post_type());
                if (get_post_type() ==  'product')
                {
                    echo sprintf($link, get_permalink(get_option ('woocommerce_shop_page_id' , 0 )), esc_html__('Shop', 'cryption'));
                }
                else {
                    $slug = $post_type->rewrite;
                    printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
                }
                if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
            } else {
                $cat = get_the_category(); $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, $delimiter);
                if ($show_current == 0 || get_query_var('cpage')) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                echo $cats;
                if ( get_query_var('cpage') ) {
                    echo $delimiter . sprintf($link, get_permalink(), get_the_title()) . $delimiter . $before . sprintf($text['cpage'], get_query_var('cpage')) . $after;
                } else {
                    if ($show_current == 1) echo $before . get_the_title() . $after;
                }

            }



// custom post type

        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
            $post_type = get_post_type_object(get_post_type());
            if ( get_query_var('paged') ) {
                echo $delimiter . sprintf($link, get_post_type_archive_link($post_type->name), $post_type->label) . $delimiter . $before . sprintf($text['page'], get_query_var('paged')) . $after;
            } else {

                if ($show_current == 1) echo $delimiter . $before . $post_type->label . $after;
            }
        } elseif ( is_attachment() ) {
            if ($show_home_link == 1) echo $delimiter;
            $parent = get_post($parent_id);
            $cat = get_the_category($parent->ID); $cat = $cat[0];
            if ($cat) {
                $cats = get_category_parents($cat, TRUE, $delimiter);
                $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                echo $cats;
            }
            printf($link, get_permalink($parent), $parent->post_title);
            if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

        } elseif ( is_page() && !$parent_id ) {
            if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

        } elseif ( is_page() && $parent_id ) {
            if ($show_home_link == 1) echo $delimiter;
            if ($parent_id != $frontpage_id) {
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    if ($parent_id != $frontpage_id) {
                        $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                    }
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    echo $breadcrumbs[$i];
                    if ($i != count($breadcrumbs)-1) echo $delimiter;
                }
            }
            if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

        } elseif ( is_tag() ) {
            if ($show_current == 1) echo $delimiter . $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

        } elseif ( is_author() ) {
            if ($show_home_link == 1) echo $delimiter;
            global $author;
            $author = get_userdata($author);
            echo $before . sprintf($text['author'], $author->display_name) . $after;

        } elseif ( is_404() ) {
            if ($show_home_link == 1) echo $delimiter;
            echo $before . $text['404'] . $after;
        } elseif ( has_post_format() && !is_singular() ) {
            if ($show_home_link == 1) echo $delimiter;
            echo get_post_format_string( get_post_format() );
        }

        echo '</div><!-- .breadcrumbs -->';

    }
}

function cryption_get_footers_list() {
	$footers = array('' => __('Default', 'cryption'));
	$footers_list = get_posts(array(
		'post_type' => 'ct_footer',
		'numberposts' => -1,
		'post_status' => 'any'
	));
	foreach ($footers_list as $footer) {
		$footers[$footer->ID] = $footer->post_title . ' (ID = ' . $footer->ID . ')';
	}
	return $footers;
}

/*function cryption_menu_item_button($items, $args)
{
	if ($args->theme_location == 'primary' && cryption_get_option('header_layout') !== 'overlay') {
		$items .= '<li class="menu-item-button"><button class="gem-button">test</button></li>';
	}
	return $items;
}
add_filter('wp_nav_menu_items', 'cryption_menu_item_button', 50, 2);*/
function cptui_register_my_cpts() {

	/**
	 * Post Type: ASIC's.
	 */

	$labels = [
		"name" => __( "ASIC's", "custom-post-type-ui" ),
		"singular_name" => __( "ASIC", "custom-post-type-ui" ),
		"all_items" => __( "Все АСИКи", "custom-post-type-ui" ),
		"add_new" => __( "Добавить АСИК", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "ASIC's", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "asics", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-table-col-delete",
		"supports" => [ "title" ],
	];

	register_post_type( "asics", $args );

	/**
	 * Post Type: Ремонт.
	 */

	$labels = [
		"name" => __( "Ремонт", "custom-post-type-ui" ),
		"singular_name" => __( "Ремонт", "custom-post-type-ui" ),
		"all_items" => __( "Лог ремонта", "custom-post-type-ui" ),
		"add_new" => __( "Новый ремонт", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Ремонт", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "repair", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-admin-tools",
		"supports" => [ "title", "editor", "thumbnail" ],
	];

	register_post_type( "repair", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );
function cptui_register_my_cpts_asics() {

	/**
	 * Post Type: ASIC's.
	 */

	$labels = [
		"name" => __( "ASIC's", "custom-post-type-ui" ),
		"singular_name" => __( "ASIC", "custom-post-type-ui" ),
		"all_items" => __( "Все АСИКи", "custom-post-type-ui" ),
		"add_new" => __( "Добавить АСИК", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "ASIC's", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "asics", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-table-col-delete",
		"supports" => [ "title" ],
	];

	register_post_type( "asics", $args );
}

add_action( 'init', 'cptui_register_my_cpts_asics' );
function cptui_register_my_cpts_repair() {

	/**
	 * Post Type: Ремонт.
	 */

	$labels = [
		"name" => __( "Ремонт", "custom-post-type-ui" ),
		"singular_name" => __( "Ремонт", "custom-post-type-ui" ),
		"all_items" => __( "Лог ремонта", "custom-post-type-ui" ),
		"add_new" => __( "Новый ремонт", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Ремонт", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "repair", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-admin-tools",
		"supports" => [ "title", "editor", "thumbnail" ],
	];

	register_post_type( "repair", $args );
}

add_action( 'init', 'cptui_register_my_cpts_repair' );
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_600fe0113fc90',
	'title' => 'Информация об ASIC',
	'fields' => array(
		array(
			'key' => 'field_600fe179f0bb8',
			'label' => 'Порядковый номер',
			'name' => 'asic-searial',
			'type' => 'text',
			'instructions' => 'Например: 678968757-7656568',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_600fe53e997ed',
			'label' => 'Статус',
			'name' => 'asic-status',
			'type' => 'radio',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'Включен' => 'Включен',
				'Выключен' => 'Выключен',
				'На обслуживании' => 'На обслуживании',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'default_value' => '',
			'layout' => 'horizontal',
			'return_format' => 'array',
			'save_other_choice' => 0,
		),
		array(
			'key' => 'field_600fe648379d2',
			'label' => 'Обслуживание',
			'name' => 'asic-maintenance-reason',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_600fe53e997ed',
						'operator' => '==',
						'value' => 'На обслуживании',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'repair',
			),
			'taxonomy' => '',
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'object',
			'ui' => 1,
		),
		array(
			'key' => 'field_600fe0342a7ca',
			'label' => 'IP',
			'name' => 'asic-ip',
			'type' => 'url',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
		),
		array(
			'key' => 'field_600fe0fe5a021',
			'label' => 'Локация',
			'name' => 'asic-location',
			'type' => 'text',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_600fe14f053c8',
			'label' => 'Poll',
			'name' => 'asic-poll',
			'type' => 'text',
			'instructions' => 'Например: 0-98-0970867',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_600fe1ddf9fcf',
			'label' => 'Владелец',
			'name' => 'asic-owner',
			'type' => 'text',
			'instructions' => 'Например: ТОО "Рога и Копыта"',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_600fe24029a65',
			'label' => 'Дата установки',
			'name' => 'asic-install-date',
			'type' => 'date_time_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'd.m.Y H:i:s',
			'return_format' => 'd.m.Y H:i:s',
			'first_day' => 1,
		),
		array(
			'key' => 'field_600fe20b00f70',
			'label' => 'Модель',
			'name' => 'asic-model',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_601246c4b6daf',
			'label' => 'Asic MODEL',
			'name' => 'asic_mode',
			'type' => 'text',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'WHATSMINER M21S',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_6012476c5e18b',
			'label' => 'Asic VERSION',
			'name' => 'Asic_VERSION',
			'type' => 'text',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_601247915e18c',
			'label' => 'Power Supply MODEL',
			'name' => 'Power_Supply_MODEL',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_601247e85e18d',
			'label' => 'Power Supply ORDER NO',
			'name' => 'power_supply-NO',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_601247f55e18e',
			'label' => 'Power Supply SN',
			'name' => 'power_supply-SN',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_6012481b5e18f',
			'label' => 'Сontrol unit MODEL',
			'name' => 'сontrol_unit-MODEL',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_601248a25e190',
			'label' => 'Сontrol unit SN',
			'name' => 'сontrol_unit_sn',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_601248b75e191',
			'label' => 'Сontrol unit W/O',
			'name' => 'сontrol_unit_wo',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'asics',
			),
		),
		array(
			array(
				'param' => 'post_taxonomy',
				'operator' => '==',
				'value' => 'category:container-1',
			),
		),
		array(
			array(
				'param' => 'post',
				'operator' => '==',
				'value' => '130',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'field',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_60128df6bcfcf',
	'title' => 'Ремонт Асиков',
	'fields' => array(
		array(
			'key' => 'field_601290159cd1e',
			'label' => 'Номер АСИКА',
			'name' => 'asq-NO',
			'type' => 'text',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_60128dfa854b1',
			'label' => 'Причина ремонта',
			'name' => 'repair-reason',
			'type' => 'text',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_60128edb854b8',
			'label' => 'Выявлена неисправность',
			'name' => 'Malfunction_detected',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_60128e31854b2',
			'label' => 'Дата выявления поломки',
			'name' => 'Breakage_detection_date',
			'type' => 'date_picker',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'F j, Y',
			'return_format' => 'F j, Y',
			'first_day' => 1,
		),
		array(
			'key' => 'field_60128eae854b7',
			'label' => 'Дата устранения поломки',
			'name' => 'Date_of_breakdown_elimination',
			'type' => 'date_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'F j, Y',
			'return_format' => 'F j, Y',
			'first_day' => 1,
		),
		array(
			'key' => 'field_60128f42854b9',
			'label' => 'Какие неисправности были устранены',
			'name' => 'What_malfunctions_were_eliminated',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_6016836acce3e',
			'label' => 'Выполнил ремонт',
			'name' => 'repair-creat',
			'type' => 'text',
			'instructions' => 'Введите свои данные. Например: Ф.И.О или бейдж номер',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Косов Виктор',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => 70,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'repair',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'left',
	'instruction_placement' => 'field',
	'hide_on_screen' => array(
		0 => 'permalink',
		1 => 'the_content',
		2 => 'excerpt',
		3 => 'discussion',
		4 => 'comments',
		5 => 'revisions',
		6 => 'slug',
		7 => 'author',
		8 => 'format',
		9 => 'page_attributes',
		10 => 'featured_image',
		11 => 'tags',
		12 => 'send-trackbacks',
	),
	'active' => true,
	'description' => '',
));

endif;