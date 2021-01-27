<?php

function cryption_get_image_regenerated_option_key() {
	return 'ct_image_regenerated';
}

function cryption_get_attachment_relative_path( $file ) {
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

if(!function_exists('cryption_generate_thumbnail_src')) {

	function cryption_generate_thumbnail_src($attachment_id, $size) {
		$data = cryption_image_cache_get($attachment_id, $size);
		if ($data) {
			return $data;
		}

		$data = cryption_get_thumbnail_src($attachment_id, $size);
		cryption_image_cache_set($attachment_id, $size, $data);
		return $data;
	}

	function cryption_get_thumbnail_src($attachment_id, $size) {
		$cryption_image_sizes = cryption_image_sizes();

		if(isset($cryption_image_sizes[$size])) {
			$attachment_path = get_attached_file($attachment_id);
			if (!$attachment_path) {
				return null;
			}

			$dummy_image_editor = new CT_Dummy_WP_Image_Editor($attachment_path);
			$attachment_thumb_path = $dummy_image_editor->generate_filename($size);

			if (!file_exists($attachment_thumb_path)) {
				$image_editor = wp_get_image_editor($attachment_path);
				if (!is_wp_error($image_editor) && !is_wp_error($image_editor->resize($cryption_image_sizes[$size][0], $cryption_image_sizes[$size][1], $cryption_image_sizes[$size][2]))) {
					$attachment_resized = $image_editor->save($attachment_thumb_path);
					if (!is_wp_error($attachment_resized) && $attachment_resized) {
						do_action('ct_thumbnail_generated', array('/'._wp_relative_upload_path($attachment_thumb_path)));
						return cryption_build_image_result($attachment_resized['path'], $attachment_resized['width'], $attachment_resized['height']);
					} else {
						return cryption_build_image_data($attachment_path);
					}
				} else {
					return cryption_build_image_data($attachment_path);
				}
			}
			return cryption_build_image_data($attachment_thumb_path);
		}
		return wp_get_attachment_image_src($attachment_id, $size);
	}

	function cryption_build_image_data($path) {
		$editor = new CT_Dummy_WP_Image_Editor($path);
		$size = $editor->get_size();
		if (!$size) {
			return null;
		}
		return cryption_build_image_result($path, $size['width'], $size['height']);
	}

	function cryption_image_cache_get($attachment_id, $size) {
		global $cryption_image_src_cache, $cryption_image_regenerated;

		if (!$cryption_image_src_cache) {
			$cryption_image_src_cache = array();
		}

		if (isset($cryption_image_regenerated[$attachment_id]) &&
				isset($cryption_image_src_cache[$attachment_id][$size]['time']) &&
				$cryption_image_regenerated[$attachment_id] >= $cryption_image_src_cache[$attachment_id][$size]['time']) {
			return false;
		}

		if (!empty($cryption_image_src_cache[$attachment_id][$size])) {
			$data = $cryption_image_src_cache[$attachment_id][$size];
			unset($data['time']);
			return $data;
		}
		return false;
	}

	function cryption_image_cache_set($attachment_id, $size, $data) {
		global $cryption_image_src_cache, $cryption_image_src_cache_changed;

		if (!$cryption_image_src_cache) {
			$cryption_image_src_cache = array();
		}

		$data['time'] = time();
		$cryption_image_src_cache[$attachment_id][$size] = $data;
		$cryption_image_src_cache_changed = true;
	}

	function cryption_build_image_result($file, $width, $height) {
		$uploads = wp_upload_dir();
		$url = trailingslashit( $uploads['baseurl'] . '/' . cryption_get_attachment_relative_path( $file ) ) . basename( $file );
		return array($url, $width, $height);
	}

	function cryption_get_image_cache_option_key_prefix() {
		return 'ct_image_cache_';
	}

	function cryption_get_image_cache_option_key($url = '') {
		$url = preg_replace('%\?.*$%', '', empty($url) ? esc_url(add_query_arg('crytemp', false)) : $url);
		return cryption_get_image_cache_option_key_prefix() . sha1($url);
	}

	function cryption_image_generator_cache_init() {
		global $cryption_image_src_cache, $cryption_image_src_cache_changed, $cryption_image_regenerated;

		$cryption_image_regenerated = get_option(cryption_get_image_regenerated_option_key());
		$cryption_image_regenerated = !empty($cryption_image_regenerated) ? (array) $cryption_image_regenerated : array();

		$cache = get_option(cryption_get_image_cache_option_key());
		$cryption_image_src_cache = !empty($cache) ? (array) $cache : array();

		$uploads = wp_upload_dir();

		foreach ($cryption_image_src_cache as $attachment_id => $sizes) {
			if (!is_array($sizes)) {
				continue;
			}
			foreach ($sizes as $size => $size_data) {
				if (!is_array($size_data) || empty($size_data[0])) {
					continue;
				}
				$cryption_image_src_cache[$attachment_id][$size][0] = $uploads['baseurl'] . $size_data[0];
			}
		}
		$cryption_image_src_cache_changed = false;
	}
	add_action('init', 'cryption_image_generator_cache_init');

	function cryption_image_generator_cache_save() {
		global $cryption_image_src_cache, $cryption_image_src_cache_changed;

		if (is_404() || !isset($cryption_image_src_cache_changed) || !$cryption_image_src_cache_changed) {
			return;
		}

		$uploads = wp_upload_dir();

		foreach ($cryption_image_src_cache as $attachment_id => $sizes) {
			if (!is_array($sizes)) {
				continue;
			}
			foreach ($sizes as $size => $size_data) {
				if (!is_array($size_data) || empty($size_data[0])) {
					continue;
				}
				$cryption_image_src_cache[$attachment_id][$size][0] = str_replace($uploads['baseurl'], '', $size_data[0]);
			}
		}

		update_option(cryption_get_image_cache_option_key(), $cryption_image_src_cache, 'no');
	}
	add_action('wp_footer', 'cryption_image_generator_cache_save', 9999);

}