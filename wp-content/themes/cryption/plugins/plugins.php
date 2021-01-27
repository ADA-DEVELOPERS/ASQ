<?php

require_once get_template_directory() . '/plugins/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'cryption_register_required_plugins' );
function cryption_register_required_plugins() {
	$plugins = array(
		array(
			'name' => esc_html__('CodexThemes Elements', 'cryption'),
			'slug' => 'ct-elements',
			'source' => get_template_directory() . '/plugins/pre-packaged/ct-elements.zip',
			'required' => true,
			'version' => '',
			'force_activation' => false,
			'force_deactivation' => false,
			'external_url' => '',
		),
		array(
			'name' => esc_html__('Codex Themes Import', 'cryption'),
			'slug' => 'codex-themes-import',
			'source' => get_template_directory() . '/plugins/pre-packaged/codex-themes-import.zip',
			'required' => false,
			'version' => '',
			'force_activation' => false,
			'force_deactivation' => false,
			'external_url' => '',
		),
		array(
			'name' => esc_html__('Revolution Slider', 'cryption'),
			'slug' => 'revslider',
			'source' => get_template_directory() . '/plugins/pre-packaged/revslider.zip',
			'required' => false,
			'version' => '',
			'force_activation' => false,
			'force_deactivation' => false,
			'external_url' => '',
		),
		array(
			'name' => esc_html__('Wordpress Page Widgets', 'cryption'),
			'slug' => 'wp-page-widget',
			'required' => false,
		),
		array(
			'name' => esc_html__('WPBakery Visual Composer', 'cryption'),
			'slug' => 'js_composer',
			'source' => get_template_directory() . '/plugins/pre-packaged/js_composer.zip',
			'required' => true,
			'version' => '',
			'force_activation' => false,
			'force_deactivation' => false,
			'external_url' => '',
		),
		array(
			'name' => esc_html__('Contact Form 7', 'cryption'),
			'slug' => 'contact-form-7',
			'required' => false,
		),
		array(
			'name' => esc_html__('MailChimp for WordPress', 'cryption'),
			'slug' => 'mailchimp-for-wp',
			'required' => false,
		),
		array(
			'name' => esc_html__('Easy Forms for MailChimp', 'cryption'),
			'slug' => 'yikes-inc-easy-mailchimp-extender',
			'required' => false,
		),
		array(
			'name' => esc_html__('ZillaLikes', 'cryption'),
			'slug' => 'zilla-likes',
			'source' => get_template_directory() . '/plugins/pre-packaged/zilla-likes.zip',
			'required' => false,
			'version' => '1.1.1',
			'force_activation' => false,
			'force_deactivation' => false,
			'external_url' => '',
		),
	);

	$config = array(
		'domain' => 'cryption',
		'default_path' => '',
		'menu' => 'install-required-plugins',
		'has_notices' => true,
		'is_automatic' => true,
		'message' => '',
		'strings' => array(
			'page_title' => esc_html__( 'Install Required Plugins', 'cryption' ),
			'menu_title' => esc_html__( 'Install Plugins', 'cryption' ),
			'installing' => esc_html__( 'Installing Plugin: %s', 'cryption' ),
			'oops' => esc_html__( 'Something went wrong with the plugin API.', 'cryption' ),
			'notice_can_install_required' => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'cryption' ),
			'notice_can_install_recommended' => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'cryption' ),
			'notice_cannot_install' => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'cryption' ),
			'notice_can_activate_required' => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'cryption' ),
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'cryption' ),
			'notice_cannot_activate' => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'cryption' ),
			'notice_ask_to_update' => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'cryption' ),
			'notice_cannot_update' => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'cryption' ),
			'install_link' => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'cryption' ),
			'activate_link' => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'cryption' ),
			'return' => esc_html__( 'Return to Required Plugins Installer', 'cryption' ),
			'plugin_activated' => esc_html__( 'Plugin activated successfully.', 'cryption' ),
			'complete' => esc_html__( 'All plugins installed and activated successfully. %s', 'cryption' ),
			'nag_type' => 'updated'
		)
	);

	tgmpa( $plugins, $config );

}

add_action( 'admin_init', 'cryption_updater_plugin_load' );
function cryption_updater_plugin_load() {
	if ( ! class_exists( 'TGM_Updater' ) ) {
		require get_template_directory() . '/plugins/class-tgm-updater.php';
	}
	if(cryption_is_plugin_active('ct-elements/ct-elements.php')) {
		$plugin_data = get_plugin_data(trailingslashit(WP_PLUGIN_DIR).'ct-elements/ct-elements.php');
		$args = array(
			'plugin_name' => esc_html__('CodexThemes Elements', 'cryption'),
			'plugin_slug' => 'ct-elements',
			'plugin_path' => 'ct-elements/ct-elements.php',
			'plugin_url'  => trailingslashit( WP_PLUGIN_URL ) . 'ct-elements',
			'remote_url'  => esc_url('http://democontent.codex-themes.com/plugins/ct/required/ct-elements.json'),
			'version'	 => $plugin_data['Version'],
			'key'		 => ''
		);
		$tgm_updater = new TGM_Updater( $args );
	}
	if(cryption_is_plugin_active('codex-themes-import/codex-themes-import.php')) {
		$plugin_data = get_plugin_data(trailingslashit(WP_PLUGIN_DIR).'codex-themes-import/codex-themes-import.php');
		$args = array(
			'plugin_name' => esc_html__('CodexThemes Import', 'cryption'),
			'plugin_slug' => 'codex-themes-import',
			'plugin_path' => 'codex-themes-import/codex-themes-import.php',
			'plugin_url'  => trailingslashit( WP_PLUGIN_URL ) . 'codex-themes-import',
			'remote_url'  => esc_url('http://democontent.codex-themes.com/plugins/ct/recommended/codex-themes-import.json'),
			'version'	 => $plugin_data['Version'],
			'key'		 => ''
		);
		$tgm_updater = new TGM_Updater( $args );
	}
	if(cryption_is_plugin_active('revslider/revslider.php')) {
		$plugin_data = get_plugin_data(trailingslashit(WP_PLUGIN_DIR).'revslider/revslider.php');
		$args = array(
			'plugin_name' => esc_html__('Revolution Slider', 'cryption'),
			'plugin_slug' => 'revslider',
			'plugin_path' => 'revslider/revslider.php',
			'plugin_url'  => trailingslashit( WP_PLUGIN_URL ) . 'revslider',
			'remote_url'  => esc_url('http://democontent.codex-themes.com/plugins/ct/recommended/revslider.json'),
			'version'	 => $plugin_data['Version'],
			'key'		 => ''
		);
		$tgm_updater = new TGM_Updater( $args );
	}
	if(cryption_is_plugin_active('js_composer/js_composer.php')) {
		$plugin_data = get_plugin_data(trailingslashit(WP_PLUGIN_DIR).'js_composer/js_composer.php');
		$args = array(
			'plugin_name' => esc_html__('WPBakery Visual Composer', 'cryption'),
			'plugin_slug' => 'js_composer',
			'plugin_path' => 'js_composer/js_composer.php',
			'plugin_url'  => trailingslashit( WP_PLUGIN_URL ) . 'js_composer',
			'remote_url'  => esc_url('http://democontent.codex-themes.com/plugins/ct/required/js_composer.json'),
			'version'	 => $plugin_data['Version'],
			'key'		 => ''
		);
		$tgm_updater = new TGM_Updater( $args );
	}
}

function cryption_get_purchase() {
	$theme_options = get_option('ct_theme_options');
	if($theme_options && isset($theme_options['purchase_code'])) {
		return $theme_options['purchase_code'];
	}
	return false;
}

if(function_exists('vc_set_as_theme')) vc_set_as_theme(true);

function ct_upgrader_pre_download($reply, $package, $upgrader) {
	if(strpos($package, 'democontent.codex-themes.com') !== false) {
		if(!cryption_get_purchase()) {
			return new WP_Error('ct_purchase_empty', sprintf(wp_kses(__('Purchase code verification failed. <a href="%s">Activate Cryption Theme</a>', 'ct'), array('a' => array('href' => array()))),esc_url(admin_url('themes.php?page=options-framework#activation'))));
		}
		$response_p = wp_remote_get(add_query_arg(array('code' => cryption_get_purchase(), 'site_url' => get_site_url()), 'http://democontent.codex-themes.com/av_validate_code.php'), array('timeout' => 20));
		if(is_wp_error($response_p)) {
			return new WP_Error('ct_connection_failed', esc_html__('Some troubles with connecting to Cryption Theme server.', 'ct'));
		}
		$rp_data = json_decode($response_p['body'], true);
		if(!(is_array($rp_data) && isset($rp_data['result']) && $rp_data['result'] && isset($rp_data['item_id']) && $rp_data['item_id'] === '21714401')) {
			return new WP_Error('ct_purchase_error', sprintf(wp_kses(__('Purchase code verification failed. <a href="%s">Activate Cryption Theme</a>', 'ct'), array('a' => array('href' => array()))), esc_url(admin_url('themes.php?page=options-framework#activation'))));
		}
	}
	return $reply;
}
add_filter('upgrader_pre_download', 'ct_upgrader_pre_download', 10, 3);