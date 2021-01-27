<?php

if(!function_exists('ct_get_image_regenerated_option_key') && ct_check_function_version()) {
function ct_get_image_regenerated_option_key() {
	return 'ct_image_regenerated';
}

function ct_get_attachment_relative_path( $file ) {
	$dirname = dirname( $file );
	$uploads = wp_upload_dir();

	if ( '.' === $dirname ) {
		return '';
	}

	$uploads_additional_dir = '';
	if ( false !== strpos( $uploads['basedir'], 'wp-content/uploads' ) ) {
		$uploads_additional_dir = substr( $uploads['basedir'], strpos( $uploads['basedir'], 'wp-content/uploads' ) + 18 );
	}

	if ( false !== strpos( $dirname, 'wp-content/uploads' ) ) {
		$dirname = substr( $dirname, strpos( $dirname, 'wp-content/uploads' ) + 18 + strlen($uploads_additional_dir) );
		$dirname = ltrim( $dirname, '/' );
	}

	return $dirname;
}
}

if(!function_exists('ct_generate_thumbnail_src')) {

	function ct_generate_thumbnail_src($attachment_id, $size) {
		$data = ct_image_cache_get($attachment_id, $size);
		if ($data) {
			return $data;
		}

		$data = ct_get_thumbnail_src($attachment_id, $size);
		ct_image_cache_set($attachment_id, $size, $data);
		return $data;
	}

	function ct_get_thumbnail_src($attachment_id, $size) {
		$ct_image_sizes = ct_image_sizes();

		if(isset($ct_image_sizes[$size])) {
			$attachment_path = get_attached_file($attachment_id);
			if (!$attachment_path) {
				return null;
			}

			$dummy_image_editor = new CT_Dummy_WP_Image_Editor($attachment_path);
			$attachment_thumb_path = $dummy_image_editor->generate_filename($size);

			if (!file_exists($attachment_thumb_path)) {
				$image_editor = wp_get_image_editor($attachment_path);
				if (!is_wp_error($image_editor) && !is_wp_error($image_editor->resize($ct_image_sizes[$size][0], $ct_image_sizes[$size][1], $ct_image_sizes[$size][2]))) {
					$attachment_resized = $image_editor->save($attachment_thumb_path);
					if (!is_wp_error($attachment_resized) && $attachment_resized) {
						do_action('ct_thumbnail_generated', array('/'._wp_relative_upload_path($attachment_thumb_path)));
						return ct_build_image_result($attachment_resized['path'], $attachment_resized['width'], $attachment_resized['height']);
					} else {
						return ct_build_image_data($attachment_path);
					}
				} else {
					return ct_build_image_data($attachment_path);
				}
			}
			return ct_build_image_data($attachment_thumb_path);
		}
		return wp_get_attachment_image_src($attachment_id, $size);
	}

	function ct_build_image_data($path) {
		$editor = new CT_Dummy_WP_Image_Editor($path);
		$size = $editor->get_size();
		if (!$size) {
			return null;
		}
		return ct_build_image_result($path, $size['width'], $size['height']);
	}

	function ct_image_cache_get($attachment_id, $size) {
		global $ct_image_src_cache, $ct_image_regenerated;

		if (!$ct_image_src_cache) {
			$ct_image_src_cache = array();
		}

		if (isset($ct_image_regenerated[$attachment_id]) &&
				isset($ct_image_src_cache[$attachment_id][$size]['time']) &&
				$ct_image_regenerated[$attachment_id] >= $ct_image_src_cache[$attachment_id][$size]['time']) {
			return false;
		}

		if (!empty($ct_image_src_cache[$attachment_id][$size])) {
			$data = $ct_image_src_cache[$attachment_id][$size];
			unset($data['time']);
			return $data;
		}
		return false;
	}

	function ct_image_cache_set($attachment_id, $size, $data) {
		global $ct_image_src_cache, $ct_image_src_cache_changed;

		if (!$ct_image_src_cache) {
			$ct_image_src_cache = array();
		}

		$data['time'] = time();
		$ct_image_src_cache[$attachment_id][$size] = $data;
		$ct_image_src_cache_changed = true;
	}

	function ct_build_image_result($file, $width, $height) {
		$uploads = wp_upload_dir();
		$url = trailingslashit( $uploads['baseurl'] . '/' . ct_get_attachment_relative_path( $file ) ) . basename( $file );
		return array($url, $width, $height);
	}

	function ct_get_image_cache_option_key_prefix() {
		return 'ct_image_cache_';
	}

	function ct_get_image_cache_option_key($url = '') {
		$url = preg_replace('%\?.*$%', '', empty($url) ? esc_url(add_query_arg('avxtemp', false)) : $url);
		return ct_get_image_cache_option_key_prefix() . sha1($url);
	}

	function ct_image_generator_cache_init() {
		global $ct_image_src_cache, $ct_image_src_cache_changed, $ct_image_regenerated;

		$ct_image_regenerated = get_option(ct_get_image_regenerated_option_key());
		$ct_image_regenerated = !empty($ct_image_regenerated) ? (array) $ct_image_regenerated : array();

		$cache = get_option(ct_get_image_cache_option_key());
		$ct_image_src_cache = !empty($cache) ? (array) $cache : array();

		$uploads = wp_upload_dir();

		foreach ($ct_image_src_cache as $attachment_id => $sizes) {
			if (!is_array($sizes)) {
				continue;
			}
			foreach ($sizes as $size => $size_data) {
				if (!is_array($size_data) || empty($size_data[0])) {
					continue;
				}
				$ct_image_src_cache[$attachment_id][$size][0] = $uploads['baseurl'] . $size_data[0];
			}
		}
		$ct_image_src_cache_changed = false;
	}
	add_action('init', 'ct_image_generator_cache_init');

	function ct_image_generator_cache_save() {
		global $ct_image_src_cache, $ct_image_src_cache_changed;

		if (is_404() || !isset($ct_image_src_cache_changed) || !$ct_image_src_cache_changed) {
			return;
		}

		$uploads = wp_upload_dir();

		foreach ($ct_image_src_cache as $attachment_id => $sizes) {
			if (!is_array($sizes)) {
				continue;
			}
			foreach ($sizes as $size => $size_data) {
				if (!is_array($size_data) || empty($size_data[0])) {
					continue;
				}
				$ct_image_src_cache[$attachment_id][$size][0] = str_replace($uploads['baseurl'], '', $size_data[0]);
			}
		}

		update_option(ct_get_image_cache_option_key(), $ct_image_src_cache, 'no');
	}
	add_action('wp_footer', 'ct_image_generator_cache_save', 9999);

}



	function ct_img_get_image_cache_option_key_prefix() {
		return 'ct_image_cache_';
	}

	function ct_img_get_image_cache_option_key($url = '') {
		$url = preg_replace('%\?.*$%', '', empty($url) ? esc_url(add_query_arg('avxtemp', false)) : $url);
		return ct_img_get_image_cache_option_key_prefix() . sha1($url);
	}

function ct_img_thumbnails_generator_page_row_actions($actions, $post) {
	if ( current_user_can( 'manage_options' ) ) {
		$actions = array_merge( $actions, array(
				'ct_flush_post_thumbnails_cache' => sprintf( '<a href="%s">' . __( 'Purge Thumbnails Cache', 'avxbuilder' ) . '</a>', wp_nonce_url( sprintf( 'themes.php?page=ct-thumbnails&ct_flush_post_thumbnails_cache&post_id=%d', $post->ID ), 'ct-thumbnails-cache-flush' ) )
			) );
	}
	return $actions;
}
add_filter('page_row_actions', 'ct_img_thumbnails_generator_page_row_actions', 0, 2);
add_filter('post_row_actions', 'ct_img_thumbnails_generator_page_row_actions', 0, 2);

function ct_img_theme_add_thumbnails_generator_page() {
	add_theme_page(esc_html__('Theme thumbnails', 'avxbuilder'), esc_html__('Theme thumbnails', 'avxbuilder'), 'manage_options', 'ct-thumbnails', 'ct_img_thumbnails_generator_page');
}
add_action('admin_menu', 'ct_img_theme_add_thumbnails_generator_page',1);

function ct_img_thumbnails_generator_page() {
	global $wpdb;

	if ($_GET['page'] != 'ct-thumbnails') {
		exit;
	}

	if (isset($_GET['ct_flush_post_thumbnails_cache'])) {
		if (!empty($_GET['post_id']) && $url=get_permalink($_GET['post_id'])) {
			if (wp_verify_nonce($_GET['_wpnonce'], 'ct-thumbnails-cache-flush')) {
				$option_key = ct_img_get_image_cache_option_key(str_replace(home_url(), '', $url));
				delete_option($option_key);
				ct_img_thumbnails_generator_redirect(array(
					'ct_note' => 'flush-success'
				));
			} {
				ct_img_thumbnails_generator_redirect(array(
					'ct_note' => 'nonce-error'
				));
			}
		} else {
			ct_img_thumbnails_generator_redirect(array(
				'ct_note' => 'empty-post'
			));
		}
	}
	if (isset($_GET['ct_flush_thumbnails_cache'])) {

		if (wp_verify_nonce($_GET['_wpnonce'], 'ct-thumbnails-cache-flush-all')) {
			$prefix = ct_img_get_image_cache_option_key_prefix();
			$wpdb->query("DELETE FROM `{$wpdb->options}` WHERE `option_name` LIKE '%{$prefix}%'");
			ct_img_thumbnails_generator_redirect(array(
				'ct_note' => 'flush-all-success'
			));
		} else {
			ct_img_thumbnails_generator_redirect(array(
				'ct_note' => 'nonce-error'
			));
		}
	}
}
add_action('load-appearance_page_ct-thumbnails', 'ct_img_thumbnails_generator_page');

function ct_img_admin_bar_thumbnails_generator($wp_admin_bar) {
	if (!is_user_logged_in() || (!is_user_member_of_blog() && !is_super_admin())) {
		return;
	}

	$wp_admin_bar->add_menu(array(
		'id' => 'ct-thumbnails-generator',
		'title' => 'Purge All Thumbnails Cache',
		'href' => esc_url(admin_url(wp_nonce_url('themes.php?page=ct-thumbnails&ct_flush_thumbnails_cache', 'ct-thumbnails-cache-flush-all'))),
	));
}
add_action('admin_bar_menu', 'ct_img_admin_bar_thumbnails_generator', 101);

function ct_img_thumbnails_generator_redirect($params = array()) {
	if (!empty($_SERVER['HTTP_REFERER'])) {
		$url = $_SERVER['HTTP_REFERER'];
	} else {
		$url = '/wp-admin/index.php';
	}
	$url = add_query_arg($params, $url);
	echo $url;
	@header( 'Location: ' . $url );
	exit;
}

function ct_img_thumbnails_generator_notes() {
	$notes = array(
		'flush-success' => array(
			'class' => 'updated',
			'notice' => __( 'Cached post thumbnails have been deleted successfully!', 'avxbuilder' )
		),
		'flush-all-success' => array(
			'class' => 'updated',
			'notice' => __( 'All cached thumbnails have been deleted successfully!', 'avxbuilder' )
		),
		'nonce-error' => array(
			'class' => 'error',
			'notice' => __( 'Nonce verification is faield!', 'avxbuilder' )
		),
		'empty-post' => array(
			'class' => 'error',
			'notice' => __( 'Post not found', 'avxbuilder' )
		)
	);

	if (!empty($_GET['ct_note']) && !empty($notes[$_GET['ct_note']])) {
		?>
		<div class="<?php echo $notes[$_GET['ct_note']]['class']; ?>">
			<p><?php echo $notes[$_GET['ct_note']]['notice']; ?></p>
		</div>
		<?php
	}
}
add_action('admin_notices', 'ct_img_thumbnails_generator_notes');