<?php
$cryption_page_id = is_singular() ? get_the_ID() : 0;
if(is_404() && get_post(cryption_get_option('404_page'))) {
	$cryption_page_id = cryption_get_option('404_page');
}
if((is_post_type_archive('product') || is_tax('product_cat') || is_tax('product_tag')) && function_exists('wc_get_page_id')) {
	$cryption_page_id = wc_get_page_id('shop');
}
$cryption_header_params = cryption_get_sanitize_page_header_data($cryption_page_id);
$cryption_effects_params = cryption_get_sanitize_page_effects_data($cryption_page_id);
$cryption_header_light = $cryption_header_params['header_menu_logo_light'] ? '_light' : '';
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php wp_head(); ?>
</head>

<?php
$cryption_preloader_data = cryption_get_sanitize_page_preloader_data($cryption_page_id);
?>

<body <?php body_class(); ?>>

<!-- <?php do_action('ct_before_page_content'); ?> -->

<?php if ( cryption_get_option('enable_page_preloader') || ( $cryption_preloader_data && !empty($cryption_preloader_data['enable_page_preloader']) ) ) : ?>
	<div id="page-preloader"><div class="page-preloader-spin"></div></div>
	<?php do_action('ct_after_page_preloader'); ?>
<?php endif; ?>

<!-- <div id="page" class="layout-<?php echo esc_attr(cryption_get_option('page_layout_style', 'fullwidth')); ?><?php echo esc_attr(cryption_get_option('header_layout') == 'vertical' ? ' vertical-header' : '') ; ?>"> -->

	<?php if(!cryption_get_option('disable_scroll_top_button')) : ?>
		<a href="#page" class="scroll-top-button"></a>
	<?php endif; ?>

	<?php if(!$cryption_effects_params['effects_hide_header']) : ?>

		<?php if(cryption_get_option('top_area_style') && !$cryption_header_params['header_hide_top_area'] && (cryption_get_option('header_layout') == 'vertical' && cryption_get_option('header_layout') != 'fullwidth_hamburger' || cryption_get_option('top_area_disable_fixed'))) : ?>
			<?php get_template_part('top_area'); ?>
		<?php endif; ?>

		<div id="site-header-wrapper"<?php echo ($cryption_header_params['header_transparent'] ? ' class="site-header-wrapper-transparent"' : ''); ?>>

			<?php if(cryption_get_option('header_layout') == 'fullwidth_hamburger') : ?><div class="hamburger-overlay"></div><?php endif; ?>

			<header id="site-header" class="site-header<?php echo (cryption_get_option('disable_fixed_header') || cryption_get_option('header_layout') == 'vertical' ? '' : ' animated-header'); ?><?php echo cryption_get_option('header_on_slideshow') ? ' header-on-slideshow' : ''; ?>" role="banner">
				<?php if(cryption_get_option('header_layout') == 'vertical') : ?><button class="vertical-toggle"><?php esc_html_e('Primary Menu', 'cryption'); ?><span class="menu-line-1"></span><span class="menu-line-2"></span><span class="menu-line-3"></span></button><?php endif; ?>
				<?php if(cryption_get_option('top_area_style') && !$cryption_header_params['header_hide_top_area'] && !cryption_get_option('top_area_disable_fixed') && cryption_get_option('header_layout') != 'vertical' && cryption_get_option('header_layout') != 'fullwidth_hamburger') : ?>
					<?php if($cryption_header_params['header_transparent']) : ?><div class="transparent-header-background" style="background-color: rgba(<?php echo esc_attr(implode(', ', hex_to_rgb(cryption_get_option('top_area_background_color')))); ?>, <?php echo intval($cryption_header_params['header_opacity'])/100; ?>);"><?php endif; ?>
					<?php get_template_part('top_area'); ?>
					<?php if($cryption_header_params['header_transparent']) : ?></div><?php endif; ?>
				<?php endif; ?>

				<?php if($cryption_header_params['header_transparent']) : ?><div class="transparent-header-background" style="background-color: rgba(<?php echo esc_attr(implode(', ', hex_to_rgb(cryption_get_option('top_background_color')))); ?>, <?php echo intval($cryption_header_params['header_opacity'])/100; ?>);"><?php endif; ?>
					<div class="container<?php echo (cryption_get_option('header_layout') == 'fullwidth' || cryption_get_option('header_layout') == 'fullwidth_hamburger' ? ' container-fullwidth' : ''); ?>">
						<div class="header-main logo-position-<?php echo esc_attr(cryption_get_option('logo_position', 'left')); ?><?php echo ($cryption_header_params['header_menu_logo_light'] ? ' header-colors-light' : ''); ?> header-layout-<?php echo esc_attr(cryption_get_option('header_layout')); ?> header-style-<?php echo esc_attr(cryption_get_option('header_layout') == 'vertical' || cryption_get_option('header_layout') == 'fullwidth_hamburger' ? 'vertical' : cryption_get_option('header_style')); ?>">
							<?php if(cryption_get_option('logo_position', 'left') != 'right') : ?>
								<div class="site-title">
									<?php cryption_print_logo($cryption_header_light); ?>
								</div>
								<?php if(has_nav_menu('primary')) : ?>
									<nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
										<button class="menu-toggle dl-trigger"><?php esc_html_e('Primary Menu', 'cryption'); ?><span class="menu-line-1"></span><span class="menu-line-2"></span><span class="menu-line-3"></span></button>
										<?php if(cryption_get_option('header_layout') == 'fullwidth_hamburger') : ?><button class="hamburger-toggle"><?php esc_html_e('Primary Menu', 'cryption'); ?><span class="menu-line-1"></span><span class="menu-line-2"></span><span class="menu-line-3"></span></button><?php endif; ?>
										<?php wp_nav_menu(array('theme_location' => 'primary', 'menu_id' => 'primary-menu', 'menu_class' => 'nav-menu dl-menu styled no-responsive', 'container' => false, 'walker' => new CT_Mega_Menu_Walker)); ?>
									</nav>
								<?php endif; ?>
							<?php else : ?>
								<?php if(has_nav_menu('primary')) : ?>
									<nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
										<button class="menu-toggle dl-trigger"><?php esc_html_e('Primary Menu', 'cryption'); ?><span class="menu-line-1"></span><span class="menu-line-2"></span><span class="menu-line-3"></span></button>
										<?php if(cryption_get_option('header_layout') == 'fullwidth_hamburger') : ?><button class="hamburger-toggle"><?php esc_html_e('Primary Menu', 'cryption'); ?><span class="menu-line-1"></span><span class="menu-line-2"></span><span class="menu-line-3"></span></button><?php endif; ?>
										<?php wp_nav_menu(array('theme_location' => 'primary', 'menu_id' => 'primary-menu', 'menu_class' => 'nav-menu dl-menu styled no-responsive', 'container' => false, 'walker' => new CT_Mega_Menu_Walker)); ?>
									</nav>
								<?php endif; ?>
								<div class="site-title">
									<?php cryption_print_logo($cryption_header_light); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
					<?php if($cryption_header_params['header_transparent']) : ?></div><?php endif; ?>
			</header><!-- #site-header -->
			<?php if(cryption_get_option('header_layout') == 'vertical') : ?>
				<div class="vertical-menu-item-widgets">
					<?php
					add_filter( 'get_search_form', 'cryption_search_form_vertical_header' );
					get_search_form();
					remove_filter( 'get_search_form', 'cryption_search_form_vertical_header' );
					?>
					<div class="menu-item-socials socials-colored"><?php cryption_print_socials('rounded'); ?></div></div>
			<?php endif; ?>
		</div><!-- #site-header-wrapper -->

	<?php endif; ?>

	<div id="main" class="site-main">
