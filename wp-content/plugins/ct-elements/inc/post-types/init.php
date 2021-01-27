<?php

function ct_available_post_types() {
	$available_post_types = apply_filters('ct_available_post_types', array(
		'clients', 'galleries', 'news', 'portfolios', 'quickfinders', 'teams', 'testimonials', 'slideshows', 'footers'
	));
	return $available_post_types;
}

require_once(plugin_dir_path( __FILE__ ) . 'clients.php');
require_once(plugin_dir_path( __FILE__ ) . 'galleries.php');
require_once(plugin_dir_path( __FILE__ ) . 'news.php');
require_once(plugin_dir_path( __FILE__ ) . 'portfolios.php');
require_once(plugin_dir_path( __FILE__ ) . 'quickfinders.php');
require_once(plugin_dir_path( __FILE__ ) . 'teams.php');
require_once(plugin_dir_path( __FILE__ ) . 'testimonials.php');
require_once(plugin_dir_path( __FILE__ ) . 'slideshows.php');
require_once(plugin_dir_path( __FILE__ ) . 'footers.php');

function ct_rewrite_flush() {
	ct_news_post_type_init();
	ct_portfolio_item_post_type_init();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'ct_rewrite_flush' );

add_action( 'after_switch_theme', 'flush_rewrite_rules' );