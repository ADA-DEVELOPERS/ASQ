<?php

define('CT_THEME_IMPORT_CHECK', 1);
define('CT_THEME_IMPORT_CONCEPT_CHECK', 1);
define('CT_THEME_IMPORT_NEED_ACTIVATION', 1);
define('CT_THEME_ENVATO_ID', 21714401);

function cryption_import_title($title) {
	return esc_html__('Cryption Demo Import', 'cryption');
}
add_filter('ct_import_page_title', 'cryption_import_title');
add_filter('ct_import_menu_title', 'cryption_import_title');

function cryption_import_packs($packs) {
	$packs = array(
		'monochrome' => array(
			'title' => 'Monochrome',
			'pics' => array(
				get_template_directory_uri() . '/demo-import/images/1.jpg',
				get_template_directory_uri() . '/demo-import/images/2.jpg',
				get_template_directory_uri() . '/demo-import/images/7.jpg',
				get_template_directory_uri() . '/demo-import/images/8.jpg',
			),
			'options' => get_template_directory() . '/demo-import/files/options.monochrome.json',
			'widgets' => get_template_directory() . '/demo-import/files/widgets.monochrome.json',
			'mailchimp' => get_template_directory() . '/demo-import/files/mailchimp.monochrome.csv',
			'menus' => array(
				'primary' => 'Primary Menu',
				'footer' => 'Footer menu',
			),
			'homepage' => 'ICO Advisory',
		),
		'colored' => array(
			'title' => 'Colored',
			'pics' => array(
				get_template_directory_uri() . '/demo-import/images/3.jpg',
				get_template_directory_uri() . '/demo-import/images/4.jpg',
				get_template_directory_uri() . '/demo-import/images/5.jpg',
				get_template_directory_uri() . '/demo-import/images/6.jpg',
			),
			'options' => get_template_directory() . '/demo-import/files/options.colored.json',
			'widgets' => get_template_directory() . '/demo-import/files/widgets.colored.json',
			'mailchimp' => get_template_directory() . '/demo-import/files/mailchimp.colored.csv',
			'menus' => array(
				'primary' => 'Primary Menu',
				'footer' => 'Footer menu',
			),
			'homepage' => 'ICO Advisory Color',
		),
		'dark' => array(
			'title' => 'Dark',
			'pics' => array(
				get_template_directory_uri() . '/demo-import/images/9.jpg',
			),
			'options' => get_template_directory() . '/demo-import/files/options.dark.json',
			'widgets' => get_template_directory() . '/demo-import/files/widgets.dark.json',
			'menus' => array(
				'primary' => 'One Page Menu',
				'footer' => 'Footer menu',
			),
			'homepage' => 'Cryption Dark',
		),
		'light' => array(
			'title' => 'Light',
			'pics' => array(
				get_template_directory_uri() . '/demo-import/images/10.jpg',
			),
			'options' => get_template_directory() . '/demo-import/files/options.light.json',
			'widgets' => get_template_directory() . '/demo-import/files/widgets.light.json',
			'menus' => array(
				'primary' => 'One Page Menu',
				'footer' => 'Footer menu',
			),
			'homepage' => 'Cryption Light',
		),
	);
	return $packs;
}
add_filter('ct_import_packs', 'cryption_import_packs');

function cryption_import_pack_files_directory($title) {
	return '/ct-import-packs/cryption/';
}
add_filter('ct_import_pack_files_directory', 'cryption_import_pack_files_directory');

function cryption_import_widgets_file($file) {
	return get_template_directory_uri() . '/demo-import/files/mailchimp-forms.csv';
}
add_filter('ct_import_widgets_file', 'cryption_import_widgets_file');

function cryption_import_mailchimp_forms_file($file) {
	return get_template_directory_uri() . '/demo-import/files/mailchimp-forms.csv';
}
add_filter('ct_import_mailchimp_forms_file', 'cryption_import_mailchimp_forms_file');


function cryption_import_sliders($sliders) {
	$sliders = array(
		'ico-advisory' => 'http://democontent.codex-themes.com/ct-import-packs/cryption/sliders/ico-advisory.zip',
		'ico-advisory-colored' => 'http://democontent.codex-themes.com/ct-import-packs/cryption/sliders/ico-advisory-colored.zip',
		'ico-advisory-slider' => 'http://democontent.codex-themes.com/ct-import-packs/cryption/sliders/ico-advisory-slider.zip',
		'ico-advisory-slider-2' => 'http://democontent.codex-themes.com/ct-import-packs/cryption/sliders/ico-advisory-slider-2.zip',
	);
	return $sliders;
}
add_filter('ct_import_sliders', 'cryption_import_sliders');

function cryption_import_replace_packs($packs) {
	$packs = array('cryption', 'cryption-color', 'cryption-dark', 'cryption-light');
	return $packs;
}
add_filter('ct_import_replace_packs', 'cryption_import_replace_packs');

function cryption_import_index_link($link) {
	return 'http://democontent.codex-themes.com/ct-import-packs/cryption/index.php';
}
add_filter('ct_import_index_link', 'cryption_import_index_link');

function cryption_import_replace_array($array, $dir) {
	if($dir === 1) {
		return array(
			'http://democontent.codex-themes.com/themes/cryption/wp-content/uploads/sites/9',
			'http://democontent.codex-themes.com/themes/cryption-color/wp-content/uploads/sites/10',
			'http://democontent.codex-themes.com/themes/cryption-dark/wp-content/uploads/sites/13',
			'http://democontent.codex-themes.com/themes/cryption-light/wp-content/uploads/sites/14',
		);
	}
		return array(
			'http://democontent.codex-themes.com/themes/cryption/wp-content/themes',
			'http://democontent.codex-themes.com/themes/cryption-color/wp-content/themes',
			'http://democontent.codex-themes.com/themes/cryption-dark/wp-content/themes',
			'http://democontent.codex-themes.com/themes/cryption-light/wp-content/themes',
		);
}
add_filter('ct_import_replace_array', 'cryption_import_replace_array', 10, 2);