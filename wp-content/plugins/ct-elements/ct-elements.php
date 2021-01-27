<?php
/*
Plugin Name: CodexThemes Elements
Author: Codex Themes
Version: 1.0.4
TextDomain: ct
DomainPath: /languages
*/

add_action( 'plugins_loaded', 'ct_load_textdomain' );
function ct_load_textdomain() {
	load_plugin_textdomain( 'ct', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

if(!function_exists('ct_is_plugin_active')) {
	function ct_is_plugin_active($plugin) {
		include_once(ABSPATH . 'wp-admin/includes/plugin.php');
		return is_plugin_active($plugin);
	}
}

if(!function_exists('ct_user_icons_info_link')) {
function ct_user_icons_info_link($pack = '') {
	return esc_url(apply_filters('ct_user_icons_info_link', get_template_directory_uri().'/fonts/icons-list-'.$pack.'.html', $pack));
}
}

/* Get theme option*/
if(!function_exists('ct_get_option')) {
function ct_get_option($name, $default = false, $ml_full = false) {
	$options = get_option('ct_theme_options');
	if(isset($options[$name])) {
		$ml_options = array('home_content', 'footer_html');
		if(in_array($name, $ml_options) && is_array($options[$name]) && !$ml_full) {
			if(defined('ICL_LANGUAGE_CODE')) {
				global $sitepress;
				if(isset($options[$name][ICL_LANGUAGE_CODE])) {
					$options[$name] = $options[$name][ICL_LANGUAGE_CODE];
				} elseif($sitepress->get_default_language() && isset($options[$name][$sitepress->get_default_language()])) {
					$options[$name] = $options[$name][$sitepress->get_default_language()];
				} else {
					$options[$name] = '';
				}
			}else {
				$options[$name] = reset($options[$name]);
			}
		}
		return apply_filters('ct_option_'.$name, $options[$name]);
	}
	return apply_filters('ct_option_'.$name, $default);
}
}

/* USER ICON PACK */

if(!function_exists('ct_icon_userpack_enabled')) {
function ct_icon_userpack_enabled() {
	return apply_filters('ct_icon_userpack_enabled', false);
}
}

if(!function_exists('ct_icon_packs_select_array')) {
function ct_icon_packs_select_array() {
	$packs = array('elegant' => __('Elegant', 'ct'), 'material' => __('Material Design', 'ct'), 'fontawesome' => __('FontAwesome', 'ct'));
	if(ct_icon_userpack_enabled()) {
		$packs['userpack'] = __('UserPack', 'ct');
	}
	return $packs;
}
}

if(!function_exists('ct_icon_packs_infos')) {
function ct_icon_packs_infos() {
	ob_start();
?>
<?php _e('Enter icon code', 'ct'); ?>.
<a class="ct-icon-info ct-icon-info-elegant" href="<?php echo ct_user_icons_info_link('elegant'); ?>" onclick="tb_show('<?php _e('Icons info', 'ct'); ?>', this.href+'?TB_iframe=true'); return false;"><?php _e('Show Elegant Icon Codes', 'ct'); ?></a>
<a class="ct-icon-info ct-icon-info-material" href="<?php echo ct_user_icons_info_link('material'); ?>" onclick="tb_show('<?php _e('Icons info', 'ct'); ?>', this.href+'?TB_iframe=true'); return false;"><?php _e('Show Material Design Icon Codes', 'ct'); ?></a>
<a class="ct-icon-info ct-icon-info-fontawesome" href="<?php echo ct_user_icons_info_link('fontawesome'); ?>" onclick="tb_show('<?php _e('Icons info', 'ct'); ?>', this.href+'?TB_iframe=true'); return false;"><?php _e('Show FontAwesome Icon Codes', 'ct'); ?></a>
<?php if(ct_icon_userpack_enabled()) : ?>
<a class="ct-icon-info ct-icon-info-userpack" href="<?php echo ct_user_icons_info_link('userpack'); ?>" onclick="tb_show('<?php _e('Icons info', 'ct'); ?>', this.href+'?TB_iframe=true'); return false;"><?php _e('Show UserPack Icon Codes', 'ct'); ?></a>
<?php endif; ?>
<?php
	return ob_get_clean();
}
}


/* META BOXES */

if(!function_exists('ct_print_select_input')) {
function ct_print_select_input($values = array(), $value = '', $name = '', $id = '') {
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

if(!function_exists('ct_print_checkboxes')) {
function ct_print_checkboxes($values = array(), $value = array(), $name = '', $id_prefix = '', $after = '') {
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


if(!function_exists('ct_add_srcset_rule')) {
	function ct_add_srcset_rule(&$srcset, $condition, $size, $id=false) {
		if (!$id) {
			$id = get_post_thumbnail_id();
		}
		$im = ct_generate_thumbnail_src($id, $size);
		$srcset[$condition] = $im[0];
	}
}

if(!function_exists('ct_srcset_list_to_string')) {
	function ct_srcset_list_to_string($srcset) {
		if (count($srcset) == 0) {
			return '';
		}
		$srcset_condtions = array();
		foreach ($srcset as $condition => $url) {
			$srcset_condtions[] = $url . ' ' . $condition;
		}
		return implode(', ', $srcset_condtions);
	}
}

if(!function_exists('ct_quickfinder_srcset')) {
	function ct_quickfinder_srcset($ct_item_data) {
		$attr = array('srcset' => array());

		switch ($ct_item_data['icon_size']) {
			case 'small':
			case 'medium':
				$attr['srcset']['1x'] = 'ct-person-80';
				$attr['srcset']['2x'] = 'ct-person-160';
				break;

			case 'large':
				$attr['srcset']['1x'] = 'ct-person-160';
				$attr['srcset']['2x'] = 'ct-person';
				break;

			case 'xlarge':
				$attr['srcset']['1x'] = 'ct-person-240';
				$attr['srcset']['2x'] = 'ct-person';
				break;
		}

		return $attr;
	}
}

if(!function_exists('ct_post_picture')) {
	function ct_post_picture($default_size, $sources=array(), $attrs=array(), $dummy = true) {
		if (has_post_thumbnail()) {
			ct_generate_picture(get_post_thumbnail_id(), $default_size, $sources, $attrs);
		} elseif ($dummy) {
			if (empty($attrs['class'])) {
				$attrs['class'] = 'gem-dummy';
			} else {
				$attrs['class'] .= ' gem-dummy';
			}
			echo '<span class="' . esc_attr($attrs['class']) . '"></span>';
		}
	}
}

if(!function_exists('ct_generate_picture')) {
	function ct_generate_picture($attachment_id, $default_size, $sources=array(), $attrs=array()) {
		if (!in_array($default_size, array_keys(ct_image_sizes()))) {
			return '';
		}
		$default_image = ct_generate_thumbnail_src($attachment_id, $default_size);
		if (!$default_image) {
			return '';
		}
		list($src, $width, $height) = $default_image;
		$hwstring = image_hwstring($width, $height);

		$default_attrs = array('class' => "attachment-$default_size");
		if (empty($attrs['alt'])) {
			$attachment = get_post($attachment_id);
			$attrs['alt'] = trim(strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true)));
			if(empty($default_attr['alt']))
				$attrs['alt'] = trim(strip_tags($attachment->post_excerpt));
			if(empty($default_attr['alt']))
				$attrs['alt'] = trim(strip_tags($attachment->post_title));
		}

		$attrs = wp_parse_args($attrs, $default_attrs);
		$attrs = array_map('esc_attr', $attrs);
		$attrs_set = array();
		foreach ($attrs as $attr_key => $attr_value) {
			$attrs_set[] = $attr_key . '="' . $attr_value . '"';
		}
		?>
		<picture>
			<?php ct_generate_picture_sources($attachment_id, $sources); ?>
			<img src="<?php echo $src; ?>" <?php echo $hwstring; ?> <?php echo implode(' ', $attrs_set); ?> />
		</picture>
		<?php
	}
}

if(!function_exists('ct_generate_picture_sources')) {
	function ct_generate_picture_sources($attachment_id, $sources) {
		if (!$sources) {
			return '';
		}
		?>
		<?php foreach ($sources as $source): ?>
			<?php
				$srcset = ct_srcset_generate_urls($attachment_id, $source['srcset']);
				if (!$srcset) {
					continue;
				}
			?>
			<source srcset="<?php echo ct_srcset_list_to_string($srcset); ?>" <?php if(!empty($source['media'])): ?>media="<?php echo esc_attr($source['media']); ?>"<?php endif; ?> <?php if(!empty($source['type'])): ?>type="<?php echo esc_attr($source['type']); ?>"<?php endif; ?><?php echo !empty($source['sizes']) ? ' sizes="'.esc_attr($source['sizes']).'"' : ''; ?>>
		<?php endforeach; ?>
		<?php
	}
}

if(!function_exists('ct_srcset_generate_urls')) {
	function ct_srcset_generate_urls($attachment_id, $srcset) {
		$result = array();
		$ct_sizes = array_keys(ct_image_sizes());
		foreach ($srcset as $condition => $size) {
			if (!in_array($size, $ct_sizes)) {
				continue;
			}
			$im = ct_generate_thumbnail_src($attachment_id, $size);
			$result[$condition] = esc_url($im[0]);
		}
		return $result;
	}
}

if(!function_exists('ct_attachment_url') && ct_check_function_version()) {
	function ct_attachment_url($attachcment, $size = 'full') {
		if((int)$attachcment > 0 && ($image_url = wp_get_attachment_url($attachcment, $size)) !== false) {
			return $image_url;
		}
		return false;
	}
}

if(!function_exists('ct_check_array_value') && ct_check_function_version()) {
	function ct_check_array_value($array = array(), $value = '', $default = '') {
		if(in_array($value, $array)) {
			return $value;
		}
		return $default;
	}
}

if(!function_exists('ct_get_post_data') && ct_check_function_version()) {
	function ct_get_post_data($default = array(), $post_data_name = '', $post_id = 0) {
		$post_data = get_post_meta($post_id, 'ct_'.$post_data_name.'_data', true);
		if(!is_array($default)) {
			return apply_filters('ct_get_post_data', array(), $post_id, $post_data_name);;
		}
		if(!is_array($post_data)) {
			return apply_filters('ct_get_post_data', $default, $post_id, $post_data_name);
		}
		return apply_filters('ct_get_post_data', array_merge($default, $post_data), $post_id, $post_data_name);
	}
}

if(!function_exists('ct_get_data') && ct_check_function_version()) {
	function ct_get_data($data = array(), $param = '', $default = '', $prefix = '', $suffix = '') {
		if(is_array($data) && !empty($data[$param])) {
			return $prefix.(nl2br($data[$param])).$suffix;
		}
		if(!empty($default)) {
			return $prefix.$default.$suffix;
		}
		return $default;
	}
}

if(!function_exists('ct_post_thumbnail') && ct_check_function_version()) {
function ct_post_thumbnail($size = 'ct-post-thumb', $dummy = true, $class='img-responsive img-circle', $attr = '') {
	if (empty($attr)) {
		$attr = array();
	}
	$attr = array_merge($attr, array('class' => $class));

	if (!empty($attr['srcset']) && is_array($attr['srcset'])) {
		$srcset_condtions = array();
		foreach ($attr['srcset'] as $condition => $condition_size) {
			$condition_size_image = ct_generate_thumbnail_src(get_post_thumbnail_id(), $condition_size, false);
			if ($condition_size_image) {
				$srcset_condtions[] = esc_url($condition_size_image[0]) . ' ' . $condition;
			}
		}
		$attr['srcset'] = implode(', ', $srcset_condtions);
		$attr['sizes'] = '100vw';
	}

	if(has_post_thumbnail()) {
		the_post_thumbnail($size, $attr);
	} elseif($dummy) {
		echo '<span class="gem-dummy '.esc_attr($class).'"></span>';
	}
}
}

/* FONTS MANAGER */

function ct_fonts_allowed_mime_types( $existing_mimes = array() ) {
	$existing_mimes['ttf'] = 'font/ttf';
	$existing_mimes['eot'] = 'font/eot';
	$existing_mimes['woff'] = 'font/woff';
	$existing_mimes['svg'] = 'font/svg';
	$existing_mimes['json'] = 'application/json';
	return $existing_mimes;
}
add_filter('upload_mimes', 'ct_fonts_allowed_mime_types');

function ct_modify_post_mime_types( $post_mime_types ) {
	$post_mime_types['font/ttf'] = array(esc_html__('TTF Font', 'ct'), esc_html__( 'Manage TTFs', 'ct' ), _n_noop( 'TTF <span class="count">(%s)</span>', 'TTFs <span class="count">(%s)</span>', 'ct' ) );
	$post_mime_types['font/eot'] = array(esc_html__('EOT Font', 'ct'), esc_html__( 'Manage EOTs', 'ct' ), _n_noop( 'EOT <span class="count">(%s)</span>', 'EOTs <span class="count">(%s)</span>', 'ct' ) );
	$post_mime_types['font/woff'] = array(esc_html__('WOFF Font', 'ct'), esc_html__( 'Manage WOFFs', 'ct' ), _n_noop( 'WOFF <span class="count">(%s)</span>', 'WOFFs <span class="count">(%s)</span>', 'ct' ) );
	$post_mime_types['font/svg'] = array(esc_html__('SVG Font', 'ct'), esc_html__( 'Manage SVGs', 'ct' ), _n_noop( 'SVG <span class="count">(%s)</span>', 'SVGs <span class="count">(%s)</span>', 'ct' ) );
	return $post_mime_types;
}
add_filter('post_mime_types', 'ct_modify_post_mime_types');

/* SCRTIPTs & STYLES */

function ct_elements_scripts() {
	wp_register_style('ct-portfolio', get_template_directory_uri() . '/css/portfolio.css');
	wp_register_style('ct-gallery', get_template_directory_uri() . '/css/gallery.css');
	wp_register_script('ct-diagram-line', get_template_directory_uri() . '/js/diagram_line.js', array('jquery', 'jquery-easing'), false, true);
	wp_register_script('raphael', get_template_directory_uri() . '/js/raphael.js', array('jquery'), false, true);
	wp_register_script('ct-diagram-circle', get_template_directory_uri() . '/js/diagram_circle.js', array('jquery', 'raphael'), false, true);
	wp_register_script('ct-news-carousel', get_template_directory_uri() . '/js/news-carousel.js', array('jquery', 'jquery-carouFredSel'), false, true);
	wp_register_script('ct-clients-grid-carousel', get_template_directory_uri() . '/js/clients-grid-carousel.js', array('jquery', 'jquery-carouFredSel'), false, true);
	wp_register_script('ct-portfolio-grid-carousel', get_template_directory_uri() . '/js/portfolio-grid-carousel.js', array('jquery', 'jquery-carouFredSel'), false, true);
	wp_register_script('ct-testimonials-carousel', get_template_directory_uri() . '/js/testimonials-carousel.js', array('jquery', 'jquery-carouFredSel'), false, true);
	wp_register_script('ct-widgets', get_template_directory_uri() . '/js/widgets.js', array('jquery', 'jquery-carouFredSel', 'jquery-effects-core'), false, true);
	wp_register_script('jquery-restable', get_template_directory_uri() . '/js/jquery.restable.js', array('jquery'), false, true);
	wp_register_script('ct-quickfinders-effects', get_template_directory_uri() . '/js/quickfinders-effects.js', array('jquery'), false, true);
	wp_register_script('ct-counters-effects', get_template_directory_uri() . '/js/counters-effects.js', array('jquery'), false, true);
	wp_register_script('ct-parallax-vertical', get_template_directory_uri() . '/js/jquery.parallaxVertical.js', array('jquery'), false, true);
	wp_register_script('ct-parallax-horizontal', get_template_directory_uri() . '/js/jquery.parallaxHorizontal.js', array('jquery'), false, true);
	wp_register_style('nivo-slider', get_template_directory_uri() . '/css/nivo-slider.css', array());
	wp_register_script('jquery-nivoslider', get_template_directory_uri() . '/js/jquery.nivo.slider.pack.js', array('jquery'));
	wp_register_script('ct-nivoslider-init-script', get_template_directory_uri() . '/js/nivoslider-init.js', array('jquery', 'jquery-nivoslider'));
	wp_localize_script('ct-nivoslider-init-script', 'ct_nivoslider_options', array(
		'effect' => ct_get_option('slider_effect') ? ct_get_option('slider_effect') : 'random',
		'slices' => ct_get_option('slider_slices') ? ct_get_option('slider_slices') : 15,
		'boxCols' => ct_get_option('slider_boxCols') ? ct_get_option('slider_boxCols') : 8,
		'boxRows' => ct_get_option('slider_boxRows') ? ct_get_option('slider_boxRows') : 4,
		'animSpeed' => ct_get_option('slider_animSpeed') ? ct_get_option('slider_animSpeed')*100 : 500,
		'pauseTime' => ct_get_option('slider_pauseTime') ? ct_get_option('slider_pauseTime')*1000 : 3000,
		'directionNav' => ct_get_option('slider_directionNav') ? true : false,
		'controlNav' => ct_get_option('slider_controlNav') ? true : false,
	));
	wp_register_script('ct-isotope-metro', get_template_directory_uri() . '/js/isotope_layout_metro.js', array('isotope-js'), '', true);
	wp_register_script('ct-isotope-masonry-custom', get_template_directory_uri() . '/js/isotope-masonry-custom.js', array('jquery'), '', true);
	wp_register_script('ct-juraSlider', get_template_directory_uri() . '/js/jquery.juraSlider.js', array('jquery'), '', true);
	wp_register_script('ct-portfolio', get_template_directory_uri() . '/js/portfolio.js', array('jquery', 'jquery-dlmenu', 'ct-scroll-monitor'), '', true);
	wp_register_script('ct-removewhitespace', get_template_directory_uri() . '/js/jquery.removeWhitespace.min.js', array('jquery'), '', true);
	wp_register_script('jquery-collagePlus', get_template_directory_uri() . '/js/jquery.collagePlus.min.js', array('jquery'), '', true);
	wp_register_script('ct-countdown', get_template_directory_uri() . '/js/ct-countdown.js', array( 'jquery', 'raphael', 'odometr' ) );
	wp_register_style('ct-countdown', get_template_directory_uri() . '/css/ct-countdown.css');
}
add_action('wp_enqueue_scripts', 'ct_elements_scripts', 6);


add_action('admin_menu', 'ct_import_submenu_page');
function ct_import_submenu_page() {
	if(ct_is_plugin_active('one-click-demo-import/one-click-demo-import.php')) {
		add_menu_page( apply_filters('ct_ocdi_import_page_title', 'Demo Import'), apply_filters('ct_ocdi_import_menu_title', 'Demo Import'), 'manage_options', 'ct-ocdi-import-submenu-page', 'ct_ocdi_import_page', '', 81 );
		if(isset($_GET['page']) && $_GET['page'] === 'ct-ocdi-import-submenu-page') {
			wp_redirect(admin_url('themes.php?page=pt-one-click-demo-import'));
		}
	}
}

function ct_admin_bar_theme_options($wp_admin_bar) {
	if(! is_user_logged_in())
		return;
	if(! is_user_member_of_blog() && ! is_super_admin())
		return;

	$wp_admin_bar->add_menu(array(
		'id'    => 'ct-theme-options',
		'title' => 'Theme Options',
		'href'  => esc_url(admin_url('themes.php?page=options-framework')),
	));
}
add_action('admin_bar_menu', 'ct_admin_bar_theme_options', 100);

function ct_check_function_version() {
	$theme = wp_get_theme();
	if($theme->parent()) {
		$theme = $theme->parent();
	}
	if($theme->get_template() == 'magna' && version_compare($theme->Version, '1.0.3') < 0) {
		return false;
	}
	return true;
}

require_once(plugin_dir_path( __FILE__ ) . 'inc/content.php');
require_once(plugin_dir_path( __FILE__ ) . 'inc/remote_media_upload.php');
require_once(plugin_dir_path( __FILE__ ) . 'inc/diagram.php');
require_once(plugin_dir_path( __FILE__ ) . 'inc/additional.php');
require_once(plugin_dir_path( __FILE__ ) . 'inc/post-types/init.php');
require_once(plugin_dir_path( __FILE__ ) . 'inc/shortcodes/init.php');
require_once(plugin_dir_path( __FILE__ ) . 'inc/widgets/init.php');
require_once(plugin_dir_path( __FILE__ ) . 'inc/add_vc_icon_fonts.php');
require_once(plugin_dir_path( __FILE__ ) . 'inc/image-generator.php');