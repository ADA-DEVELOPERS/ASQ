<?php

function cryption_get_theme_options() {

	$options = array(
		'general' => array(
			'title' => esc_html__('General', 'cryption'),
			'subcats' => array(
				'theme_layout' => array(
					'title' => esc_html__('Theme Layout', 'cryption'),
					'options' => array(
						'page_layout_style' => array(
							'title' => esc_html__('Page Layout Style', 'cryption'),
							'type' => 'select',
							'items' => array(
								'fullwidth' => esc_html__('Fullwidth Layout', 'cryption'),
								'boxed' => esc_html__('Boxed Layout', 'cryption'),
							),
							'default' => 'fullwidth',
							'description' => esc_html__('Select theme layout style', 'cryption'),
						),
						'disable_scroll_top_button' => array(
							'title' => esc_html__('Disable "Scroll To Top" Button', 'cryption'),
							'description' => esc_html__('Disable on-scroll "to the top" button', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'disable_smooth_scroll' => array(
							'title' => esc_html__('Disable "Smooth Scroll"', 'cryption'),
							'description' => esc_html__('Disable "Smooth Scroll"', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'enable_page_preloader' => array(
							'title' => esc_html__('Enable Page Preloader', 'cryption'),
							'description' => esc_html__('Enable Page Preloader', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
					),
				),
				'identity' => array(
					'title' => esc_html__('Identity', 'cryption'),
					'options' => array(
						'logo_width' => array(
							'title' => esc_html__('Desktop Logo Width For Non-Retina Screens', 'cryption'),
							'type' => 'fixed-number',
							'min' => 0,
							'max' => 1200,
							'default' => 100,
							'description' => esc_html__('On our demo website we use 164 pix. logo', 'cryption'),
						),
						'small_logo_width' => array(
							'title' => esc_html__('Mobile Logo Width For Non-Retina Screens', 'cryption'),
							'type' => 'fixed-number',
							'min' => 0,
							'max' => 1200,
							'default' => 100,
							'description' => esc_html__('On our demo website we use 132 pix. logo', 'cryption'),
						),
						'logo' => array(
							'title' => esc_html__('Desktop Logo', 'cryption'),
							'type' => 'image',
							'default' => get_template_directory_uri() . '/images/default-logo.png',
							'description' => esc_html__('Upload your logo for desktop screens here. Pls note: if you wish to achieve best quality on retina screens, your logo size should be 3 times larger as the size you have set in "Desktop Logo Width For Non-Retina Screens". On our demo website we use 164 x 3 = 492 pix', 'cryption'),
						),
						'small_logo' => array(
							'title' => esc_html__('Mobile Logo', 'cryption'),
							'type' => 'image',
							'default' => get_template_directory_uri() . '/images/default-logo-small.png',
							'description' => esc_html__('Upload your logo for mobile screens here. Pls note: if you wish to achieve best quality on retina mobile screens, your logo size should be 3 times larger as the size you have set in "Mobile Logo Width For Non-Retina Screens". On our demo website we use 132 x 3 = 396 pix', 'cryption'),
						),
						'logo_light' => array(
							'title' => esc_html__('Light Desktop Logo', 'cryption'),
							'type' => 'image',
							'default' => get_template_directory_uri() . '/images/default-logo-light.png',
							'description' => esc_html__('Here you can upload a light version of your desktop logo to be used on dark header backgrounds. Pls note: if you wish to achieve best quality on retina screens, your logo size should be 3 times larger as the size you have set in "Desktop Logo Width For Non-Retina Screens". On our demo website we use 164 x 3 = 492 pix', 'cryption'),
						),
						'small_logo_light' => array(
							'title' => esc_html__('Light Mobile Logo', 'cryption'),
							'type' => 'image',
							'default' => get_template_directory_uri() . '/images/default-logo.png',
							'description' => esc_html__('Here you can upload a light version of your mobile logo to be used on dark header backgrounds. Pls note: if you wish to achieve best quality on retina screens, your logo size should be 3 times larger as the size you have set in "Mobile Logo Width For Non-Retina Screens". On our demo website we use 132 x 3 = 396 pix', 'cryption'),
						),
					),
				),
				'advanced' => array(
					'title' => esc_html__('Advanced', 'cryption'),
					'options' => array(
						'preloader_style' => array(
							'title' => esc_html__('Preloader Style', 'cryption'),
							'type' => 'select',
							'items' => array(
								'preloader-1' => esc_html__('Preloader 1', 'cryption'),
								'preloader-2' => esc_html__('Preloader 2', 'cryption'),
								'preloader-3' => esc_html__('Preloader 3', 'cryption'),
								'preloader-4' => esc_html__('Preloader 4', 'cryption'),
							),
							'default' => 'preloader-1',
							'description' => esc_html__('Choose preloader you wish to use on your website', 'cryption'),
						),
						'custom_css' => array(
							'title' => esc_html__('Custom CSS', 'cryption'),
							'type' => 'textarea',
							'description' => esc_html__('Type your custom css here, which you would like to add to theme\'s css (or overwrite it)', 'cryption'),
						),
						'custom_js' => array(
							'title' => esc_html__('Custom JS', 'cryption'),
							'type' => 'textarea',
							'description' => esc_html__('Type your custom javascript here, which you would like to add to theme\'s js', 'cryption'),
						),
					),
				),
				'additional' => array(
					'title' => esc_html__('Additional Settings', 'cryption'),
					'options' => array(
						'404_page' => array(
							'title' => esc_html__('Custom 404 Page', 'cryption'),
							'type' => 'select',
							'items' => cryption_get_pages_list(),
							'default' => '',
						),
						'enable_mobile_lazy_loading' => array(
							'title' => esc_html__('Enabe Lazy Loading Animations On Mobiles', 'cryption'),
							'description' => esc_html__('Enabe Lazy Loading Animations On Mobiles', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
					),
				),
			),
		),

		'header' => array(
			'title' => esc_html__('Header', 'cryption'),
			'subcats' => array(
				'general' => array(
					'title' => esc_html__('Main Menu &amp; Header Area', 'cryption'),
					'options' => array(
						'disable_fixed_header' => array(
							'title' => esc_html__('Disable Fixed Header', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'hide_search_icon' => array(
							'title' => __('Hide Search Icon', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'header_layout' => array(
							'title' => esc_html__('Main Menu & Header Layout ', 'cryption'),
							'type' => 'select',
							'items' => array(
								'default' => esc_html__('Horizontal', 'cryption'),
								'fullwidth' => esc_html__('100% Width', 'cryption'),
							),
							'description' => esc_html__('Choose the layout for displaying your main menu and website header.', 'cryption'),
						),
						'logo_position' => array(
							'title' => esc_html__('Logo Alignment', 'cryption'),
							'type' => 'select',
							'items' => array(
								'left' => esc_html__('Left', 'cryption'),
								'right' => esc_html__('Right', 'cryption'),
								'center' => esc_html__('Centered Above Main Menu', 'cryption'),
								'menu_center' => esc_html__('Centered In Main Menu', 'cryption'),
							),
							'default' => 'left',
							'description' => esc_html__('Select position of your logo in website header', 'cryption'),
						),
						'menu_appearance_tablet_portrait' => array(
							'title' => esc_html__('Menu appearance on tablets (portrait orientation)', 'cryption'),
							'type' => 'select',
							'items' => array(
								'responsive' => esc_html__('Responsive', 'cryption'),
								'centered' => esc_html__('Centered', 'cryption'),
								'default' => esc_html__('Default', 'cryption'),
							),
							'default' => 'responsive',
							'description' => esc_html__('Select the menu appearance style on tablet screens in portrait orientation', 'cryption'),
						),
						'menu_appearance_tablet_landscape' => array(
							'title' => esc_html__('Menu appearance on tablets (landscape orientation)', 'cryption'),
							'type' => 'select',
							'items' => array(
								'responsive' => esc_html__('Responsive', 'cryption'),
								'centered' => esc_html__('Centered', 'cryption'),
								'default' => esc_html__('Default', 'cryption'),
							),
							'default' => 'default',
							'description' => esc_html__('Select the menu appearance style on tablet screens in landscape orientation', 'cryption'),
						),
					),
				),
				'top_area' => array(
					'title' => __('Top Area', 'cryption'),
					'options' => array(
						'top_area_style' => array(
							'title' => __('Top Area Style', 'cryption'),
							'type' => 'select',
							'items' => array(
								'0' => __('Disabled', 'cryption'),
								'1' => __('Light Background', 'cryption'),
								'2' => __('Dark Background', 'cryption'),
								'3' => __('Anthracite Background', 'cryption'),
							),
							'description' => __('Select the style of top area (contacts & socials bar above main menu and logo) or disable it', 'cryption'),
						),
						'top_area_alignment' => array(
							'title' => __('Top Area Alignment', 'cryption'),
							'type' => 'select',
							'items' => array(
								'left' => __('Left', 'cryption'),
								'right' => __('Right', 'cryption'),
								'center' => __('Centered', 'cryption'),
								'justified' => __('Justified', 'cryption'),
							),
							'description' => __('Select content alignment in the top area of your website', 'cryption'),
						),
						'top_area_contacts' => array(
							'title' => __('Show Contacts', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
							'description' => __('By activating this option your contact data will be displayed in top area of your website. You can edit your contact data in "Contacts & Socials" section of Theme Options', 'cryption'),
						),
						'top_area_socials' => array(
							'title' => __('Show Socials', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
							'description' => __('By activating this option the links to your social profiles will be displayed in top area of your website. You can edit your social profiles in "Contacts & Socials" section of Theme Options', 'cryption'),
						),
						'top_area_button_text' => array(
							'title' => __('Top Area Button Text', 'cryption'),
							'type' => 'input',
							'default' => '',
							'description' => __('Here you can activate and name the button to be displayed in top area. Leave blank if you don\'t wish to use a button in top area.', 'cryption'),
						),
						'top_area_button_link' => array(
							'title' => __('Top Area Button Link', 'cryption'),
							'type' => 'input',
							'default' => '',
							'description' => __('Here you can enter the link for your top area button.', 'cryption'),
						),
						'top_area_disable_fixed' => array(
							'title' => __('Disable Fixed Top Area', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'top_area_disable_mobile' => array(
							'title' => __('Disable Top Area For Mobiles', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
					),
				),
			),
		),

		'fonts' => array(
			'title' => esc_html__('Fonts', 'cryption'),
			'subcats' => array(
				'main_menu_font' => array(
					'title' => esc_html__('Main Menu Font', 'cryption'),
					'options' => array(
						'main_menu_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'main_menu_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'main_menu_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'main_menu_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 18,
						),
						'main_menu_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'submenu_font' => array(
					'title' => esc_html__('Submenu Font', 'cryption'),
					'options' => array(
						'submenu_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'submenu_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'submenu_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'submenu_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 12,
						),
						'submenu_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'styled_subtitle_font' => array(
					'title' => esc_html__('Styled Subtitle Font', 'cryption'),
					'options' => array(
						'styled_subtitle_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'styled_subtitle_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'styled_subtitle_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'styled_subtitle_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 29,
						),
						'styled_subtitle_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'h1_font' => array(
					'title' => esc_html__('H1 Font', 'cryption'),
					'options' => array(
						'h1_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'h1_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'h1_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'h1_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 29,
						),
						'h1_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'h2_font' => array(
					'title' => esc_html__('H2 Font', 'cryption'),
					'options' => array(
						'h2_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'h2_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'h2_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'h2_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 25,
						),
						'h2_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'h3_font' => array(
					'title' => esc_html__('H3 Font', 'cryption'),
					'options' => array(
						'h3_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'h3_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'h3_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'h3_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 23,
						),
						'h3_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'h4_font' => array(
					'title' => esc_html__('H4 Font', 'cryption'),
					'options' => array(
						'h4_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'h4_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'h4_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'h4_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 21,
						),
						'h4_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'h5_font' => array(
					'title' => esc_html__('H5 Font', 'cryption'),
					'options' => array(
						'h5_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'h5_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'h5_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'h5_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 19,
						),
						'h5_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'h6_font' => array(
					'title' => esc_html__('H6 Font', 'cryption'),
					'options' => array(
						'h6_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'h6_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'h6_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'h6_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 17,
						),
						'h6_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'xlarge_title_font' => array(
					'title' => esc_html__('XLarge Title Font', 'cryption'),
					'options' => array(
						'xlarge_title_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'xlarge_title_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'xlarge_title_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'xlarge_title_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 17,
						),
						'xlarge_title_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'light_title_font' => array(
					'title' => esc_html__('Light Title Font', 'cryption'),
					'options' => array(
						'light_title_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'light_title_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'light_title_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
					),
				),
				'body_font' => array(
					'title' => esc_html__('Body Font', 'cryption'),
					'options' => array(
						'body_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'body_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'body_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'body_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 14,
						),
						'body_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'widget_title_font' => array(
					'title' => esc_html__('Widget Title Font', 'cryption'),
					'options' => array(
						'widget_title_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'widget_title_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'widget_title_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'widget_title_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 14,
						),
						'widget_title_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'button_font' => array(
					'title' => esc_html__('Button Font', 'cryption'),
					'options' => array(
						'button_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'button_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'button_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
					),
				),
				'button_thin_font' => array(
					'title' => esc_html__('Button Thin Font', 'cryption'),
					'options' => array(
						'button_thin_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'button_thin_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'button_thin_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
					),
				),
				'portfolio_title_font' => array(
					'title' => esc_html__('Portfolio Title Font', 'cryption'),
					'options' => array(
						'portfolio_title_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'portfolio_title_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'portfolio_title_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'portfolio_title_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 16,
						),
						'portfolio_title_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'portfolio_description_font' => array(
					'title' => esc_html__('Portfolio Description Font', 'cryption'),
					'options' => array(
						'portfolio_description_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'portfolio_description_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'portfolio_description_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'portfolio_description_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 16,
						),
						'portfolio_description_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'gallery_title_font' => array(
					'title' => esc_html__('Gallery Title Font', 'cryption'),
					'options' => array(
						'gallery_title_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'gallery_title_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'gallery_title_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'gallery_title_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 16,
						),
						'gallery_title_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'gallery_title_bold_font' => array(
					'title' => esc_html__('Gallery Title Font (Bold Style)', 'cryption'),
					'options' => array(
						'gallery_title_bold_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'gallery_title_bold_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'gallery_title_bold_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'gallery_title_bold_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 16,
						),
						'gallery_title_bold_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'gallery_description_font' => array(
					'title' => esc_html__('Gallery Description Font', 'cryption'),
					'options' => array(
						'gallery_description_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'gallery_description_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'gallery_description_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'gallery_description_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 16,
						),
						'gallery_description_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'testimonial_font' => array(
					'title' => esc_html__('Testimonials Quoted Text', 'cryption'),
					'options' => array(
						'testimonial_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'testimonial_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'testimonial_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'testimonial_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 16,
						),
						'testimonial_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'counter_font' => array(
					'title' => esc_html__('Counter Numbers', 'cryption'),
					'options' => array(
						'counter_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'counter_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'counter_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'counter_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 16,
						),
						'counter_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'slideshow_title_font' => array(
					'title' => esc_html__('NivoSlider Title Font', 'cryption'),
					'options' => array(
						'slideshow_title_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'slideshow_title_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'slideshow_title_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'slideshow_title_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 16,
						),
						'slideshow_title_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
				'slideshow_description_font' => array(
					'title' => esc_html__('NivoSlider Description Font', 'cryption'),
					'options' => array(
						'slideshow_description_font_family' => array(
							'title' => esc_html__('Font Family', 'cryption'),
							'type' => 'font-select',
							'description' => esc_html__('Select font family you would like to use. On the top of the fonts list you\'ll find web safe fonts', 'cryption'),
						),
						'slideshow_description_font_style' => array(
							'title' => esc_html__('Font Style', 'cryption'),
							'type' => 'font-style',
							'description' => esc_html__('Select font style for your font', 'cryption'),
						),
						'slideshow_description_font_sets' => array(
							'title' => esc_html__('Font Sets', 'cryption'),
							'type' => 'font-sets',
							'description' => esc_html__('Type in or load additional font sets which you would like to use with your chosen google font (latin-ext is loaded by default)', 'cryption'),
							'default' => 'latin,latin-ext'
						),
						'slideshow_description_font_size' => array(
							'title' => esc_html__('Font Size', 'cryption'),
							'description' => esc_html__('Select the font size', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 100,
							'default' => 16,
						),
						'slideshow_description_line_height' => array(
							'title' => esc_html__('Line Height', 'cryption'),
							'description' => esc_html__('Select the line height', 'cryption'),
							'type' => 'fixed-number',
							'min' => 10,
							'max' => 150,
							'default' => 18,
						),
					),
				),
			),
		),

		'colors' => array(
			'title' => esc_html__('Colors', 'cryption'),
			'subcats' => array(
				'background_main_colors' => array(
					'title' => esc_html__('Background And Main Colors', 'cryption'),
					'options' => array(
						'basic_outer_background_color' => array(
							'title' => esc_html__('Background Color For Boxed Layout', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Select website\'s backround color in boxed layout', 'cryption'),
						),
						'top_background_color' => array(
							'title' => esc_html__('Main Menu & Header Area Background', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Background color for the website\'s header area with main menu and logo', 'cryption'),
						),
						'main_background_color' => array(
							'title' => esc_html__('Main Content Background Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Main background color for pages, blog posts, portfolio & shop items. It is also used as background for certain blog list styles, portfolio overviews, team items and tables. Additionally this color is used as text font color for text elements published on dark backgrounds, like footer on our demo website.', 'cryption'),
						),
						'footer_widget_area_background_color' => array(
							'title' => esc_html__('Footer Widgetised Area Background Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Background color for widgetised area in footer', 'cryption'),
						),
						'footer_background_color' => array(
							'title' => esc_html__('Footer Background Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Background color of the footer area with copyrights and socials at the bottom of the website.', 'cryption'),
						),
						'styled_elements_background_color' => array(
							'title' => esc_html__('Styled Element Background Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('After the main content background color this is a second most important background color for the website. It is used as background for following widgets: submenu, diagrams, project info, recent posts & comments, testimonials & teams. Also it is used as item\'s background color in grid overviews of blog posts and portfolio items; in testimonial, team and tables shortcodes as well as in background of sticky posts.', 'cryption'),
						),
						'styled_elements_color_1' => array(
							'title' => esc_html__('Styled Element Color 1', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('This color is used mainly as font text color of some widget elements, some elements like teams, testimonials, blog items. It is also used as background color for the label of sticky post in blogs', 'cryption'),
						),
						'styled_elements_color_2' => array(
							'title' => esc_html__('Styled Element Color 2', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Background color for a few widget elements.', 'cryption'),
						),
						'styled_elements_color_3' => array(
							'title' => esc_html__('Styled Element Color 3', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('This color is used for following elements: likes icon and markers in widget headings ', 'cryption'),
						),
						'divider_default_color' => array(
							'title' => esc_html__('Divider Default Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Default color for dividers used in theme: content dividers, widget dividers, blog & news posts dividers etc.', 'cryption'),
						),
						'box_border_color' => array(
							'title' => esc_html__('Box Border & Sharing Icons In Blog Posts', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Color used as default border color in box elements in main content and sidebar widgets. Also this color is used as font color for social sharing icons in blog posts.', 'cryption'),
						),
					),
				),
				'menu_colors' => array(
					'title' => esc_html__('Menu Colors', 'cryption'),
					'options' => array(
						'main_menu_level1_color' => array(
							'title' => esc_html__('Level 1 Text Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level1_background_color' => array(
							'title' => esc_html__('Level 1 Background Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level1_hover_color' => array(
							'title' => esc_html__('Level 1 Hover Text Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level1_hover_background_color' => array(
							'title' => esc_html__('Level 1 Hover Background Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level1_active_color' => array(
							'title' => esc_html__('Level 1 Active Text Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level1_active_background_color' => array(
							'title' => esc_html__('Level 1 Active Background Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level2_color' => array(
							'title' => esc_html__('Level 2 Text Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level2_background_color' => array(
							'title' => esc_html__('Level 2 Background Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level2_hover_color' => array(
							'title' => esc_html__('Level 2 Hover Text Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level2_hover_background_color' => array(
							'title' => esc_html__('Level 2 Hover Background Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level2_active_color' => array(
							'title' => esc_html__('Level 2 Active Text Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level2_active_background_color' => array(
							'title' => esc_html__('Level 2 Active Background Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_mega_column_title_color' => array(
							'title' => esc_html__('Mega Menu Column Titles Text Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_mega_column_title_hover_color' => array(
							'title' => esc_html__('Mega Menu Column Titles Hover Text Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_mega_column_title_active_color' => array(
							'title' => esc_html__('Mega Menu Column Titles Active Text Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level3_color' => array(
							'title' => esc_html__('Level 3+ Text Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level3_background_color' => array(
							'title' => esc_html__('Level 3+ Background Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level3_hover_color' => array(
							'title' => esc_html__('Level 3+ Hover Text Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level3_hover_background_color' => array(
							'title' => esc_html__('Level 3+ Hover Background Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level3_active_color' => array(
							'title' => esc_html__('Level 3+ Active Text Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level3_active_background_color' => array(
							'title' => esc_html__('Level 3+ Active Background Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level1_light_color' => array(
							'title' => esc_html__('Level 1 Light Text Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level1_light_hover_color' => array(
							'title' => esc_html__('Level 1 Hover Light Text Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level1_light_active_color' => array(
							'title' => esc_html__('Level 1 Active Light Text Color', 'cryption'),
							'type' => 'color',
						),
						'main_menu_level2_border_color' => array(
							'title' => esc_html__('Level 2+ Border Color', 'cryption'),
							'type' => 'color',
						),
						'mega_menu_icons_color' => array(
							'title' => esc_html__('Mega Menu Icons Color', 'cryption'),
							'type' => 'color',
						),
					),
				),
				'top_area_colors' => array(
					'title' => __('Top Area Colors', 'cryption'),
					'options' => array(
						'top_area_background_color' => array(
							'title' => __('Top Area Background Color', 'cryption'),
							'type' => 'color',
							'description' => __('Background color for the selected style of top area (contacts & socials bar above main menu and logo). You can select from different top area styles in "Header -> Top Area"', 'cryption'),
						),
						'top_area_text_color' => array(
							'title' => __('Top Area Text Color', 'cryption'),
							'type' => 'color',
							'description' => __('Main font color for text used in top area', 'cryption'),
						),
						'top_area_link_color' => array(
							'title' => __('Top Area Link Text Color', 'cryption'),
							'type' => 'color',
							'description' => __('Color of the links used in top area', 'cryption'),
						),
						'top_area_link_hover_color' => array(
							'title' => __('Top Area Link Hover Text Color', 'cryption'),
							'type' => 'color',
							'description' => __('Color for links hovers used in top area', 'cryption'),
						),
						'top_area_button_text_color' => array(
							'title' => __('Top Area Button Text Color', 'cryption'),
							'type' => 'color',
							'description' => __('Font color for the button in top area (if used)', 'cryption'),
						),
						'top_area_button_background_color' => array(
							'title' => __('Top Area Button Background Color', 'cryption'),
							'type' => 'color',
							'description' => __('Background color for the button in top area (if used)', 'cryption'),
						),
						'top_area_button_hover_text_color' => array(
							'title' => __('Top Area Button Hover Text Color', 'cryption'),
							'type' => 'color',
							'description' => __('Font hover color for the button in top area (if used)', 'cryption'),
						),
						'top_area_button_hover_background_color' => array(
							'title' => __('Top Area Button Hover Background Color', 'cryption'),
							'type' => 'color',
							'description' => __('Background hover color for the button in top area (if used)', 'cryption'),
						),
					),
				),
				'text_colors' => array(
					'title' => esc_html__('Text Colors', 'cryption'),
					'options' => array(
						'body_color' => array(
							'title' => esc_html__('Body Color', 'cryption'),
							'type' => 'color',
						),
						'h1_color' => array(
							'title' => esc_html__('H1 Color', 'cryption'),
							'type' => 'color',
						),
						'h2_color' => array(
							'title' => esc_html__('H2 Color', 'cryption'),
							'type' => 'color',
						),
						'h3_color' => array(
							'title' => esc_html__('H3 Color', 'cryption'),
							'type' => 'color',
						),
						'h4_color' => array(
							'title' => esc_html__('H4 Color', 'cryption'),
							'type' => 'color',
						),
						'h5_color' => array(
							'title' => esc_html__('H5 Color', 'cryption'),
							'type' => 'color',
						),
						'h6_color' => array(
							'title' => esc_html__('H6 Color', 'cryption'),
							'type' => 'color',
						),
						'link_color' => array(
							'title' => esc_html__('Link Color', 'cryption'),
							'type' => 'color',
						),
						'hover_link_color' => array(
							'title' => esc_html__('Hover Link Color', 'cryption'),
							'type' => 'color',
						),
						'active_link_color' => array(
							'title' => esc_html__('Active Link Color', 'cryption'),
							'type' => 'color',
						),
						'footer_text_color' => array(
							'title' => esc_html__('Footer Text Color', 'cryption'),
							'type' => 'color',
						),
						'copyright_text_color' => array(
							'title' => esc_html__('Copyright Text Color', 'cryption'),
							'type' => 'color',
						),
						'copyright_link_color' => array(
							'title' => esc_html__('Copyright Link Color', 'cryption'),
							'type' => 'color',
						),
						'title_bar_background_color' => array(
							'title' => esc_html__('Title Bar Default Background', 'cryption'),
							'type' => 'color',
						),
						'title_bar_text_color' => array(
							'title' => esc_html__('Title Bar Default Font', 'cryption'),
							'type' => 'color',
						),
						'date_filter_subtitle_color' => array(
							'title' => esc_html__('Date, Filter & Team Subtitle Color', 'cryption'),
							'type' => 'color',
						),
						'system_icons_font' => array(
							'title' => esc_html__('System Icons Font', 'cryption'),
							'type' => 'color',
						),
						'system_icons_font_2' => array(
							'title' => esc_html__('System Icons Font 2', 'cryption'),
							'type' => 'color',
						),
					),
				),
				'button_colors' => array(
					'title' => esc_html__('Button Colors', 'cryption'),
					'options' => array(
						'button_text_basic_color' => array(
							'title' => esc_html__('Basic Text Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Font color for the text used in default flat buttons. Note: you can freely customise your buttons inside your content using "Button" shortcode in Visual Composer', 'cryption'),
						),
						'button_text_hover_color' => array(
							'title' => esc_html__('Hover Text Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Hover font color for the text used in default flat buttons. Note: you can freely customise your buttons inside your content using "Button" shortcode in Visual Composer', 'cryption'),
						),
						'button_background_basic_color' => array(
							'title' => esc_html__('Basic Background Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Background color for default flat buttons. Note: you can freely customise your buttons inside your content using "Button" shortcode in Visual Composer', 'cryption'),
						),
						'button_background_hover_color' => array(
							'title' => esc_html__('Hover Background Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Hover background color for default flat buttons. Note: you can freely customise your buttons inside your content using "Button" shortcode in Visual Composer', 'cryption'),
						),
						'button_outline_text_basic_color' => array(
							'title' => esc_html__('Basic Outline Text Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Font color for the text used in default outlined buttons. Note: you can freely customise your buttons inside your content using "Button" shortcode in Visual Composer', 'cryption'),
						),
						'button_outline_text_hover_color' => array(
							'title' => esc_html__('Hover Outline Text Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Hover font color for the text used in default outlined buttons. Note: you can freely customise your buttons inside your content using "Button" shortcode in Visual Composer', 'cryption'),
						),
						'button_outline_border_basic_color' => array(
							'title' => esc_html__('Basic Outline Border Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Border color used in default outlined buttons. Note: you can freely customise your buttons inside your content using "Button" shortcode in Visual Composer', 'cryption'),
						),
					),
				),
				'widgets_colors' => array(
					'title' => esc_html__('Widgets Colors', 'cryption'),
					'options' => array(
						'widget_title_color' => array(
							'title' => esc_html__('Widget Title Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Font color of widget titles used in sidebars', 'cryption'),
						),
						'widget_link_color' => array(
							'title' => esc_html__('Widget Link Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Font color of links in widgets used in sidebars', 'cryption'),
						),
						'widget_hover_link_color' => array(
							'title' => esc_html__('Widget Hover Link Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Hover color for links used in sidebar widgets', 'cryption'),
						),
						'widget_active_link_color' => array(
							'title' => esc_html__('Widget Active Link Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Color for active links used in sidebar widgets', 'cryption'),
						),
						'footer_widget_title_color' => array(
							'title' => esc_html__('Footer Widget Title Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Font color of widget titles used in footer widgetised area', 'cryption'),
						),
						'footer_widget_text_color' => array(
							'title' => esc_html__('Footer Widget Text Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Font color of text used in widgets in footer widgetised area', 'cryption'),
						),
						'footer_widget_link_color' => array(
							'title' => esc_html__('Footer Widget Link Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Font color of links in widgets used in footer widgetised area', 'cryption'),
						),
						'footer_widget_hover_link_color' => array(
							'title' => esc_html__('Footer Widget Hover Link Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Hover color for links used in widgets in footer widgetised area', 'cryption'),
						),
						'footer_widget_active_link_color' => array(
							'title' => esc_html__('Footer Widget Active Link Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Color for active links used in widgets in footer widgetised area', 'cryption'),
						),
					),
				),
				'portfolio_colors' => array(
					'title' => esc_html__('Portfolio Colors', 'cryption'),
					'options' => array(
						'portfolio_title_color' => array(
							'title' => esc_html__('Portfolio Overview Title Text', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Select portfolio item\'s title color for grid-style portfolio overviews', 'cryption'),
						),
						'portfolio_description_color' => array(
							'title' => esc_html__('Portfolio Overview Description Text', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Choose portfolio item\'s description color for grid-style portfolio overviews', 'cryption'),
						),
						'portfolio_date_color' => array(
							'title' => esc_html__('Portfolio Date Color', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Font color for showing the date in portfolio overviews', 'cryption'),
						),
					),
				),
				'gallery_colors' => array(
					'title' => esc_html__('Slideshow, Gallery And Image Box Colors', 'cryption'),
					'options' => array(
						'gallery_caption_background_color' => array(
							'title' => esc_html__('Gallery Lightbox Caption Background', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Select background color for image description in image lightbox (zoomed view)', 'cryption'),
						),
						'gallery_title_color' => array(
							'title' => esc_html__('Gallery Lightbox Title Text', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Choose title color for image description in gallery in image lightbox (zoomed view)', 'cryption'),
						),
						'gallery_description_color' => array(
							'title' => esc_html__('Gallery Lightbox Description Text', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Select text color for image description in image lightbox (zoomed view)', 'cryption'),
						),
						'slideshow_arrow_background' => array(
							'title' => esc_html__('Slideshow Arrow Background', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Background color for the arrows in Layerslider, Revolution & Nivo Slider slideshows', 'cryption'),
						),
						'slideshow_arrow_hover_background' => array(
							'title' => esc_html__('Slideshow Arrow Hover Background', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Hover background color for the arrows in Layerslider, Revolution & Nivo Slider slideshows', 'cryption'),
						),
						'slideshow_arrow_color' => array(
							'title' => esc_html__('Slideshow Arrow Font', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Font color for the arrows in Layerslider, Revolution & Nivo Slider slideshows', 'cryption'),
						),
						'sliders_arrow_color' => array(
							'title' => esc_html__('Sliders Arrow Font', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Font color for the arrows in content sliders (not in Layeslider, Revolution or Nivo Sliders)', 'cryption'),
						),
						'sliders_arrow_background_color' => array(
							'title' => esc_html__('Sliders Arrow Background', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Backround color for the arrows in content sliders (not in Layeslider, Revolution or Nivo Sliders)', 'cryption'),
						),
						'sliders_arrow_hover_color' => array(
							'title' => esc_html__('Sliders Arrow Hover Font', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Hover font color for the arrows in content sliders (not in Layeslider, Revolution or Nivo Sliders)', 'cryption'),
						),
						'sliders_arrow_background_hover_color' => array(
							'title' => esc_html__('Sliders Arrow Hover Background', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Hover background color for the arrows in content sliders (not in Layeslider, Revolution or Nivo Sliders)', 'cryption'),
						),
						/*'hover_effect_default_color' => array(
							'title' => esc_html__('"Cyan Breeze" Hover Color', 'cryption'),
							'type' => 'color',
						),
						'hover_effect_zooming_blur_color' => array(
							'title' => esc_html__('"Zooming White" Hover Color', 'cryption'),
							'type' => 'color',
						),
						'hover_effect_horizontal_sliding_color' => array(
							'title' => esc_html__('"Horizontal Sliding" Hover Color', 'cryption'),
							'type' => 'color',
						),
						*/
					),
				),
				'bullets_pager_colors' => array(
					'title' => esc_html__('Bullets, Icons, Dropcaps & Pagination', 'cryption'),
					'options' => array(
						'bullets_symbol_color' => array(
							'title' => esc_html__('Bullets Symbol', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('This color is used in bullets in navigation & menu widgets as well as as font color for icons in contact widget', 'cryption'),
						),
						'icons_symbol_color' => array(
							'title' => esc_html__('Icons Font', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Default font color for icons. Note: using icons shortcodes in Visual Composer you can freely customise your icons as you wish', 'cryption'),
						),
						'pagination_basic_color' => array(
							'title' => esc_html__('Pagination Basic', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Font color for numbers in classic pagination', 'cryption'),
						),
						'pagination_basic_background_color' => array(
							'title' => esc_html__('Pagination Basic Background', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Background color for numbers in classic pagination', 'cryption'),
						),
						'pagination_basic_border_color' => array(
							'title' => esc_html__('Pagination Basic Border', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Border color for numbers in classic pagination', 'cryption'),
						),
						'pagination_hover_color' => array(
							'title' => esc_html__('Pagination Hover', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Hover color for classic pagination', 'cryption'),
						),
						'pagination_active_color' => array(
							'title' => esc_html__('Pagination Active', 'cryption'),
							'type' => 'color',
							'description' => esc_html__('Active color  for classic pagination', 'cryption'),
						),
						'mini_pagination_color' => array(
							'title' => esc_html__('Slider Mini-Pagination (Not Active)', 'cryption'),
							'type' => 'color',
						),
						'mini_pagination_active_color' => array(
							'title' => esc_html__('Slider Mini-Pagination (Active)', 'cryption'),
							'type' => 'color',
						),
					),
				),
				'form_colors' => array(
					'title' => esc_html__('Form', 'cryption'),
					'options' => array(
						'form_elements_background_color' => array(
							'title' => esc_html__('Background', 'cryption'),
							'type' => 'color',
						),
						'form_elements_text_color' => array(
							'title' => esc_html__('Font', 'cryption'),
							'type' => 'color',
						),
						'form_elements_border_color' => array(
							'title' => esc_html__('Border', 'cryption'),
							'type' => 'color',
						),
					),
				),
			),
		),

		'backgrounds' => array(
			'title' => esc_html__('Backgrounds', 'cryption'),
			'subcats' => array(
				'backgrounds_images' => array(
					'title' => esc_html__('Background Images', 'cryption'),
					'options' => array(
						'basic_outer_background_image' => array(
							'title' => esc_html__('Background for Boxed Layout', 'cryption'),
							'type' => 'image',
							'description' => esc_html__('Select or upload image file for website\'s backround in boxed layout', 'cryption'),
						),
						'basic_outer_background_image_select' => array(
							'title' => esc_html__('Background Patterns for Boxed Layout', 'cryption'),
							'type' => 'image-select',
							'target' => 'basic_outer_background_image',
							'items' => array(
								0 => 'low_contrast_linen',
								1 => 'mochaGrunge',
								2 => 'bedge_grunge',
								3 => 'solid',
								4 => 'concrete_wall',
								5 => 'dark_circles',
								6 => 'debut_dark',
							),
						),
						'top_background_image' => array(
							'title' => esc_html__('Main Menu & Header Area Background', 'cryption'),
							'type' => 'image',
							'description' => __('Select or upload background image file for the website\'s header area with main menu and logo', 'cryption'),
						),
						'top_area_background_image' => array(
							'title' => __('Top Area Background', 'cryption'),
							'type' => 'image',
							'description' => __('Select or upload background image file for the selected style of top area (contacts & socials bar above main menu and logo). You can select from different top area styles in "Header -> Top Area"', 'cryption'),
						),
						'main_background_image' => array(
							'title' => esc_html__('Main Content Background', 'cryption'),
							'type' => 'image',
							'description' => esc_html__('Select or upload image file for website\'s main content background', 'cryption'),
						),
						'footer_background_image' => array(
							'title' => esc_html__('Footer Background', 'cryption'),
							'type' => 'image',
							'description' => esc_html__('Select or upload background image file for the footer area with copyrights and socials at the bottom of the website.', 'cryption'),
						),
						'footer_widget_area_background_image' => array(
							'title' => esc_html__(' Footer Widgetised Area Background Image', 'cryption'),
							'type' => 'image',
							'description' => esc_html__('Select or upload background image file for widgetised area in footer', 'cryption'),
						),
					),
				),
			),
		),

		'slideshow' => array(
			'title' => esc_html__('NivoSlider Options', 'cryption'),
			'subcats' => array(
				'slideshow_options' => array(
					'title' => esc_html__('NivoSlider Options', 'cryption'),
					'options' => array(
						'slider_effect' => array(
							'title' => esc_html__('Effect', 'cryption'),
							'type' => 'select',
							'items' => array(
								'random' => 'random',
								'fold' => 'fold',
								'fade' => 'fade',
								'sliceDown' => 'sliceDown',
								'sliceDownRight' => 'sliceDownRight',
								'sliceDownLeft' => 'sliceDownLeft',
								'sliceUpRight' => 'sliceUpRight',
								'sliceUpLeft' => 'sliceUpLeft',
								'sliceUpDown' => 'sliceUpDown',
								'sliceUpDownLeft' => 'sliceUpDownLeft',
								'fold' => 'fold',
								'fade' => 'fade',
								'boxRandom' => 'boxRandom',
								'boxRain' => 'boxRain',
								'boxRainReverse' => 'boxRainReverse',
								'boxRainGrow' => 'boxRainGrow',
								'boxRainGrowReverse' => 'boxRainGrowReverse',
							),
						),
						'slider_slices' => array(
							'title' => esc_html__('Slices', 'cryption'),
							'type' => 'fixed-number',
							'min' => 1,
							'max' => 20,
							'default' => 15,
						),
						'slider_boxCols' => array(
							'title' => esc_html__('Box Cols', 'cryption'),
							'type' => 'fixed-number',
							'min' => 1,
							'max' => 10,
							'default' => 8,
						),
						'slider_boxRows' => array(
							'title' => esc_html__('Box Rows', 'cryption'),
							'type' => 'fixed-number',
							'min' => 1,
							'max' => 10,
							'default' => 4,
						),
						'slider_animSpeed' => array(
							'title' => esc_html__('Animation Speed ( x 100 milliseconds )', 'cryption'),
							'type' => 'fixed-number',
							'min' => 1,
							'max' => 50,
							'default' => 5,
						),
						'slider_pauseTime' => array(
							'title' => esc_html__('Pause Time ( x 1000 milliseconds )', 'cryption'),
							'type' => 'fixed-number',
							'min' => 1,
							'max' => 20,
							'default' => 3,
						),
						'slider_directionNav' => array(
							'title' => esc_html__('Direction Navigation', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'slider_controlNav' => array(
							'title' => esc_html__('Control Navigation', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
					),
				),
			),
		),

		'blog' => array(
			'title' => esc_html__('Blog & News', 'cryption'),
			'subcats' => array(
				'blog_options' => array(
					'title' => esc_html__('Blog & News Options', 'cryption'),
					'options' => array(
						'show_author' => array(
							'title' => esc_html__('Show author', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'excerpt_length' => array(
							'title' => esc_html__('Excerpt lenght', 'cryption'),
							'type' => 'fixed-number',
							'min' => 1,
							'max' => 150,
							'default' => 20,
						),
					),
				),
			),
		),

		'footer' => array(
			'title' => esc_html__('Footer', 'cryption'),
			'subcats' => array(
				'footer_options' => array(
					'title' => esc_html__('Footer Options', 'cryption'),
					'options' => array(
						'footer_active' => array(
							'title' => esc_html__('Activate footer', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'footer_html' => array(
							'title' => esc_html__('Footer Text', 'cryption'),
							'type' => 'textarea',
						),
						'custom_footer' => array(
							'title' => __('Custom Footer', 'cryption'),
							'type' => 'select',
							'items' => cryption_get_footers_list(),
							'default' => '',
						),
					),
				),
			),
		),

		'socials' => array(
			'title' => esc_html__('Contacts & Socials', 'cryption'),
			'subcats' => array(
				'contacts' => array(
					'title' => esc_html__('Contacts', 'cryption'),
					'options' => array(
						'contacts_address' => array(
							'title' => esc_html__('Address', 'cryption'),
							'type' => 'input',
							'default' => '',
						),
						'contacts_phone' => array(
							'title' => esc_html__('Phone', 'cryption'),
							'type' => 'input',
							'default' => '',
						),
						'contacts_fax' => array(
							'title' => esc_html__('Fax', 'cryption'),
							'type' => 'input',
							'default' => '',
						),
						'contacts_email' => array(
							'title' => esc_html__('Email', 'cryption'),
							'type' => 'input',
							'default' => '',
						),
						'contacts_website' => array(
							'title' => esc_html__('Website', 'cryption'),
							'type' => 'input',
							'default' => '',
						),
					),
				),
				'top_area_contacts' => array(
					'title' => __('Top Area Contacts', 'cryption'),
					'options' => array(
						'top_area_contacts_address' => array(
							'title' => __('Address', 'cryption'),
							'type' => 'input',
							'default' => '',
						),
						'top_area_contacts_phone' => array(
							'title' => __('Phone', 'cryption'),
							'type' => 'input',
							'default' => '',
						),
						'top_area_contacts_fax' => array(
							'title' => __('Fax', 'cryption'),
							'type' => 'input',
							'default' => '',
						),
						'top_area_contacts_email' => array(
							'title' => __('Email', 'cryption'),
							'type' => 'input',
							'default' => '',
						),
						'top_area_contacts_website' => array(
							'title' => __('Website', 'cryption'),
							'type' => 'input',
							'default' => '',
						),
					),
				),
				'socials_options' => array(
					'title' => esc_html__('Socials', 'cryption'),
					'options' => array(
						'twitter_active' => array(
							'title' => esc_html__('Activate Twitter Icon', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'facebook_active' => array(
							'title' => esc_html__('Activate Facebook Icon', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'linkedin_active' => array(
							'title' => esc_html__('Activate LinkedIn Icon', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'googleplus_active' => array(
							'title' => esc_html__('Activate Google Plus Icon', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'stumbleupon_active' => array(
							'title' => esc_html__('Activate StumbleUpon Icon', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
						),
						'rss_active' => array(
							'title' => esc_html__('Activate RSS Icon', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'vimeo_active' => array(
							'title' => esc_html__('Activate Vimeo Icon', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'instagram_active' => array(
							'title' => esc_html__('Activate Instagram Icon', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'pinterest_active' => array(
							'title' => esc_html__('Activate Pinterest Icon', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'youtube_active' => array(
							'title' => esc_html__('Activate YouTube Icon', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'flickr_active' => array(
							'title' => esc_html__('Activate Flickr Icon', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'telegram_active' => array(
							'title' => esc_html__('Activate Telegram Icon', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'medium_active' => array(
							'title' => esc_html__('Activate Medium Icon', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'reddit_active' => array(
							'title' => esc_html__('Activate Reddit Icon', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'slack_active' => array(
							'title' => esc_html__('Activate Slack Icon', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
						'twitter_link' => array(
							'title' => esc_html__('Twitter Profile Link', 'cryption'),
							'type' => 'input',
							'default' => '#',
							'description' => esc_html__('Enter URL to your twitter profile', 'cryption'),
						),
						'facebook_link' => array(
							'title' => esc_html__('Facebook Profile Link', 'cryption'),
							'type' => 'input',
							'default' => '#',
							'description' => esc_html__('Enter URL to your facebook profile', 'cryption'),
						),
						'linkedin_link' => array(
							'title' => esc_html__('LinkedIn Profile Link', 'cryption'),
							'type' => 'input',
							'default' => '#',
							'description' => esc_html__('Enter URL to your linkedin profile', 'cryption'),
						),
						'googleplus_link' => array(
							'title' => esc_html__('Google Plus Profile Link', 'cryption'),
							'type' => 'input',
							'default' => '#',
							'description' => esc_html__('Enter URL to your google+ profile', 'cryption'),
						),
						'stumbleupon_link' => array(
							'title' => esc_html__('StumbleUpon Profile Link', 'cryption'),
							'type' => 'input',
							'default' => '#',
							'description' => esc_html__('Enter URL to your stumbleupon profile', 'cryption'),
						),
						'rss_link' => array(
							'title' => esc_html__('RSS Link', 'cryption'),
							'type' => 'input',
							'default' => '#',
						),
						'vimeo_link' => array(
							'title' => esc_html__('Vimeo Link', 'cryption'),
							'type' => 'input',
							'default' => '#',
						),
						'instagram_link' => array(
							'title' => esc_html__('Instagram Link', 'cryption'),
							'type' => 'input',
							'default' => '#',
						),
						'pinterest_link' => array(
							'title' => esc_html__('Pinterest Link', 'cryption'),
							'type' => 'input',
							'default' => '#',
						),
						'youtube_link' => array(
							'title' => esc_html__('Youtube Link', 'cryption'),
							'type' => 'input',
							'default' => '#',
						),
						'flickr_link' => array(
							'title' => esc_html__('Flickr Link', 'cryption'),
							'type' => 'input',
							'default' => '#',
						),
						'telegram_link' => array(
							'title' => esc_html__('Telegram Link', 'cryption'),
							'type' => 'input',
							'default' => '#',
						),
						'medium_link' => array(
							'title' => esc_html__('Medium Link', 'cryption'),
							'type' => 'input',
							'default' => '#',
						),
						'reddit_link' => array(
							'title' => esc_html__('Reddit Link', 'cryption'),
							'type' => 'input',
							'default' => '#',
						),
						'slack_link' => array(
							'title' => esc_html__('Slack Link', 'cryption'),
							'type' => 'input',
							'default' => '#',
						),
						'show_social_icons' => array(
							'title' => esc_html__('Display Links For Sharing Posts On Social Networks', 'cryption'),
							'type' => 'checkbox',
							'value' => 1,
							'default' => 0,
						),
					),
				),
			),
		),
	);

	return $options;
}

function cryption_get_option_element($oname = '', $option = array(), $default = NULL) {
	if($default !== NULL) {
		$option['default'] = $default;
	}

	if(!isset($option['default'])) {
		$option['default'] = '';
	}

	$ml_options = array('footer_html');
	if(in_array($oname, $ml_options) && is_array($option['default'])) {
		if(defined('ICL_LANGUAGE_CODE')) {
			global $sitepress;
			if(isset($option['default'][ICL_LANGUAGE_CODE])) {
				$option['default'] = $option['default'][ICL_LANGUAGE_CODE];
			} elseif($sitepress->get_default_language() && isset($option['default'][$sitepress->get_default_language()])) {
				$option['default'] = $option['default'][$sitepress->get_default_language()];
			} else {
				$option['default'] = '';
			}
		}else {
			$option['default'] = reset($option['default']);
		}
	}

	$option['default'] = stripslashes($option['default']);

	$output = '<div class="'.esc_attr('option '.$oname.'_field').'">';

	if(isset($option['type'])) {

		if(isset($option['description'])) {
			$output .= '<div class="description">'.esc_html($option['description']).'</div>';
		}

		$output .= '<div class="label"><label for="'.esc_attr($oname).'">'.esc_html($option['title']).'</label></div><div class="'.esc_attr($option['type']).'">';
		switch ($option['type']) {

		case 'input':
			$output .= '<input id="'.esc_attr($oname).'" name="theme_options['.esc_attr($oname).']"';
			if(isset($option['default'])) {
				$output .= ' value="'.esc_attr($option['default']).'"';
			}
			$output .= '/>';
			break;

		case 'image':
			$output .= '<input id="'.esc_attr($oname).'" name="theme_options['.esc_attr($oname).']"';
			if(isset($option['default'])) {
				$output .= ' value="'.esc_attr($option['default']).'"';
			}
			$output .= '/>';
			break;

		case 'image-select':
			$skins = array('light', 'dark');
			foreach($skins as $skin) {
				foreach($option['items'] as $item) {
					$output .= '<a data-target="'.esc_attr($option['target']).'" href="'.esc_url(get_template_directory_uri().'/images/backgrounds/patterns/'.$skin.'/'.$item.'.jpg').'"><img alt="#" src="'.esc_url(get_template_directory_uri().'/images/backgrounds/patterns/'.$skin.'/'.$item.'-thumb.jpg').'"/></a>';
				}
				$output .= '<span class="clear"></span>';
			}
			break;

		case 'file':
			$output .= '<input id="'.esc_attr($oname).'" name="theme_options['.esc_attr($oname).']"';
			if(isset($option['default'])) {
				$output .= ' value="'.esc_attr($option['default']).'"';
			}
			$output .= '/>';
			break;

		case 'font-select':
			$selected = isset($option['default']) ? $option['default'] : '';
			$fontsList = cryption_fonts_list();
			$output .= '<select id="'.esc_attr($oname).'" name="theme_options['.esc_attr($oname).']">';
			foreach($fontsList as $val => $item) {
				$output .= '<option value="'.esc_attr($val).'"';
				if($val == $selected) {
					$output .= ' selected';
				}
				$output .= '>'.esc_html($item).'</option>';
			}
			$output .= '</select>';
			break;

		case 'font-style':
			$selected = isset($option['default']) ? $option['default'] : '';
			$output .= '<select id="'.esc_attr($oname).'" name="theme_options['.esc_attr($oname).']" data-value="'.esc_attr($selected).'"></select>';
			break;

		case 'font-sets':
			$output .= '<input id="'.esc_attr($oname).'" name="theme_options['.esc_attr($oname).']"';
			if(isset($option['default'])) {
				$output .= ' data-value="'.esc_attr($option['default']).'"';
			}
			$output .= '/>';
			break;

		case 'fixed-number':
			$min = isset($option['min']) ? $option['min'] : 1;
			$max = isset($option['max']) ? $option['max'] : $min+1;
			$default = isset($option['default']) ? $option['default'] : $min;
			$output .= '<input id="'.esc_attr($oname).'" name="theme_options['.esc_attr($oname).']" value="'.esc_attr($default).'" data-min-value="'.esc_attr($min).'" data-max-value="'.esc_attr($max).'"/>';
			break;

		case 'color':
			$output .= '<input id="'.esc_attr($oname).'" name="theme_options['.esc_attr($oname).']"';
			if(isset($option['default'])) {
				$output .= ' value="'.esc_attr($option['default']).'"';
			}
			$output .= ' class="color-select"/>';
			break;

		case 'textarea':
			$output .= '<textarea id="'.esc_attr($oname).'" name="theme_options['.esc_attr($oname).']" cols="100" rows="15">';
			if(isset($option['default'])) {
				$output .= esc_textarea($option['default']);
			}
			$output .= '</textarea>';
			break;

		case 'select':
			$selected = isset($option['default']) ? $option['default'] : '';
			$output .= '<select id="'.esc_attr($oname).'" name="theme_options['.esc_attr($oname).']">';
			foreach($option['items'] as $val => $item) {
				$output .= '<option value="'.$val.'"';
				if($val == $selected) {
					$output .= ' selected';
				}
				$output .= '>'.$item.'</option>';
			}
			$output .= '</select>';
			break;

		default:
			$output .= '<input id="'.esc_attr($oname).'" name="theme_options['.esc_attr($oname).']"';
			if(isset($option['default'])) {
				$output .= ' value="'.esc_attr($option['default']).'"';
			}
			$output .= '/>';
		}

		$output .= '</div>';

		if($option['type'] == 'checkbox') {
			$output = '<div class="option '.esc_attr($oname).'_field"><div class="checkbox"><input id="'.esc_attr($oname).'" name="theme_options['.esc_attr($oname).']" type="checkbox" value="'.esc_attr($option['value']).'"';
			if($option['default'] == $option['value']) {
				$output .= ' checked';
			}
			$output .= '> <label for="'.esc_attr($oname).'">'.esc_html($option['title']).'</label></div>';
		}

		$output .= '<div class="clear"></div></div>';
	}

	return $output;
}

function cryption_get_pages_list() {
	$pages = array('' => esc_html__('Default', 'cryption'));
	$pages_list = get_pages();
	foreach ($pages_list as $page) {
		$pages[$page->ID] = $page->post_title . ' (ID = ' . $page->ID . ')';
	}
	return $pages;
}

function cryption_color_skin_defaults($skin = 'light') {
	$skin_defaults = apply_filters('cryption_default_skins_options', array(
		'light' => array(
			'main_menu_font_family' => 'Montserrat',
			'main_menu_font_style' => '500',
			'main_menu_font_sets' => 'latin,latin-ext,vietnamese',
			'main_menu_font_size' => '17',
			'main_menu_line_height' => '27',
			'submenu_font_family' => 'Montserrat',
			'submenu_font_style' => 'regular',
			'submenu_font_sets' => 'latin,latin-ext,vietnamese',
			'submenu_font_size' => '15',
			'submenu_line_height' => '22',
			'styled_subtitle_font_family' => 'Montserrat',
			'styled_subtitle_font_style' => '300',
			'styled_subtitle_font_sets' => 'latin-ext,latin',
			'styled_subtitle_font_size' => '24',
			'styled_subtitle_line_height' => '36',
			'h1_font_family' => 'Montserrat',
			'h1_font_style' => '700',
			'h1_font_sets' => 'latin',
			'h1_font_size' => '50',
			'h1_line_height' => '69',
			'h2_font_family' => 'Montserrat',
			'h2_font_style' => '700',
			'h2_font_sets' => 'latin',
			'h2_font_size' => '40',
			'h2_line_height' => '54',
			'h3_font_family' => 'Montserrat',
			'h3_font_style' => '700',
			'h3_font_sets' => 'latin',
			'h3_font_size' => '30',
			'h3_line_height' => '40',
			'h4_font_family' => 'Montserrat',
			'h4_font_style' => '700',
			'h4_font_sets' => 'latin',
			'h4_font_size' => '24',
			'h4_line_height' => '32',
			'h5_font_family' => 'Montserrat',
			'h5_font_style' => '700',
			'h5_font_sets' => 'latin',
			'h5_font_size' => '19',
			'h5_line_height' => '26',
			'h6_font_family' => 'Montserrat',
			'h6_font_style' => '700',
			'h6_font_sets' => 'latin',
			'h6_font_size' => '15',
			'h6_line_height' => '24',
			'xlarge_title_font_family' => 'Montserrat',
			'xlarge_title_font_style' => '700',
			'xlarge_title_font_sets' => 'latin,latin-ext',
			'xlarge_title_font_size' => '80',
			'xlarge_title_line_height' => '90',
			'light_title_font_family' => 'Montserrat',
			'light_title_font_style' => '200',
			'light_title_font_sets' => 'latin',
			'body_font_family' => 'Montserrat',
			'body_font_style' => 'regular',
			'body_font_sets' => 'vietnamese,cyrillic-ext,cyrillic,latin-ext,greek,latin,greek-ext',
			'body_font_size' => '15',
			'body_line_height' => '27',
			'widget_title_font_family' => 'Montserrat',
			'widget_title_font_style' => '700',
			'widget_title_font_sets' => 'latin,latin-ext,vietnamese',
			'widget_title_font_size' => '19',
			'widget_title_line_height' => '22',
			'button_font_family' => 'Montserrat',
			'button_font_style' => '700',
			'button_font_sets' => 'latin',
			'button_thin_font_family' => 'Montserrat',
			'button_thin_font_style' => '200',
			'button_thin_font_sets' => '',
			'portfolio_title_font_family' => 'Montserrat',
			'portfolio_title_font_style' => '700',
			'portfolio_title_font_sets' => 'latin,latin-ext,vietnamese',
			'portfolio_title_font_size' => '19',
			'portfolio_title_line_height' => '24',
			'portfolio_description_font_family' => 'Montserrat',
			'portfolio_description_font_style' => 'regular',
			'portfolio_description_font_sets' => 'latin,latin-ext,vietnamese',
			'portfolio_description_font_size' => '15',
			'portfolio_description_line_height' => '24',
			'gallery_title_font_family' => 'Montserrat',
			'gallery_title_font_style' => 'regular',
			'gallery_title_font_sets' => 'latin,latin-ext,vietnamese',
			'gallery_title_font_size' => '19',
			'gallery_title_line_height' => '24',
			'gallery_title_bold_font_family' => 'Montserrat',
			'gallery_title_bold_font_style' => '700',
			'gallery_title_bold_font_sets' => 'latin,latin-ext,vietnamese',
			'gallery_title_bold_font_size' => '19',
			'gallery_title_bold_line_height' => '24',
			'gallery_description_font_family' => 'Montserrat',
			'gallery_description_font_style' => 'regular',
			'gallery_description_font_sets' => 'latin,latin-ext,vietnamese',
			'gallery_description_font_size' => '15',
			'gallery_description_line_height' => '24',
			'testimonial_font_family' => 'Open Sans',
			'testimonial_font_style' => '300',
			'testimonial_font_sets' => 'latin-ext,latin',
			'testimonial_font_size' => '15',
			'testimonial_line_height' => '25',
			'counter_font_family' => 'Montserrat',
			'counter_font_style' => '700',
			'counter_font_sets' => 'latin,latin-ext,vietnamese',
			'counter_font_size' => '50',
			'counter_line_height' => '59',
			'slideshow_title_font_family' => 'Open Sans',
			'slideshow_title_font_style' => '700',
			'slideshow_title_font_sets' => '',
			'slideshow_title_font_size' => '50',
			'slideshow_title_line_height' => '69',
			'slideshow_description_font_family' => 'Montserrat',
			'slideshow_description_font_style' => 'regular',
			'slideshow_description_font_sets' => 'latin,latin-ext,vietnamese',
			'slideshow_description_font_size' => '16',
			'slideshow_description_line_height' => '25',
			'basic_outer_background_color' => '#f0f4f7',
			'top_background_color' => '#ffffff',
			'main_background_color' => '#ffffff',
			'footer_widget_area_background_color' => '#202f39',
			'footer_background_color' => '#12232f',
			'styled_elements_background_color' => '#f0f4f7',
			'styled_elements_color_1' => '#12232f',
			'styled_elements_color_2' => '#00d58b',
			'styled_elements_color_3' => '#00bbb3',
			'divider_default_color' => '#dfe5e8',
			'box_border_color' => '#dfe5e8',
			'main_menu_level1_color' => '#12232f',
			'main_menu_level1_background_color' => '',
			'main_menu_level1_hover_color' => '#00c38c',
			'main_menu_level1_hover_background_color' => '',
			'main_menu_level1_active_color' => '#00c38c',
			'main_menu_level1_active_background_color' => '',
			'main_menu_level2_color' => '#12232f',
			'main_menu_level2_background_color' => '#f0f4f7',
			'main_menu_level2_hover_color' => '#00c38c',
			'main_menu_level2_hover_background_color' => '#ffffff',
			'main_menu_level2_active_color' => '#00c38c',
			'main_menu_level2_active_background_color' => '#ffffff',
			'main_menu_mega_column_title_color' => '#12232f',
			'main_menu_mega_column_title_hover_color' => '#00c38c',
			'main_menu_mega_column_title_active_color' => '#00c38c',
			'main_menu_level3_color' => '#12232f',
			'main_menu_level3_background_color' => '#ffffff',
			'main_menu_level3_hover_color' => '#12232f',
			'main_menu_level3_hover_background_color' => '#ffffff',
			'main_menu_level3_active_color' => '#12232f',
			'main_menu_level3_active_background_color' => '#ffffff',
			'main_menu_level1_light_color' => '#ffffff',
			'main_menu_level1_light_hover_color' => '#00c38c',
			'main_menu_level1_light_active_color' => '#00c38c',
			'main_menu_level2_border_color' => '',
			'mega_menu_icons_color' => '#00c38c',
			'top_area_background_color' => '#12232f',
			'top_area_text_color' => '#8fa5a2',
			'top_area_link_color' => '#8fa5a2',
			'top_area_link_hover_color' => '#18d685',
			'top_area_button_text_color' => '#ffffff',
			'top_area_button_background_color' => '#18d685',
			'top_area_button_hover_text_color' => '#ffffff',
			'top_area_button_hover_background_color' => '#00c2ba',
			'body_color' => '#697671',
			'h1_color' => '#191f25',
			'h2_color' => '#191f25',
			'h3_color' => '#191f25',
			'h4_color' => '#191f25',
			'h5_color' => '#191f25',
			'h6_color' => '#191f25',
			'link_color' => '#0df0a3',
			'hover_link_color' => '#191f25',
			'active_link_color' => '#191f25',
			'footer_text_color' => '#8fa5a2',
			'copyright_text_color' => '#8fa5a2',
			'copyright_link_color' => '#0df0a3',
			'title_bar_background_color' => '#2b2b2b',
			'title_bar_text_color' => '#ffffff',
			'date_filter_subtitle_color' => '#b7b7b7',
			'system_icons_font' => '#191f25',
			'system_icons_font_2' => '#191f25',
			'button_text_basic_color' => '#ffffff',
			'button_text_hover_color' => '#ffffff',
			'button_background_basic_color' => '#00d58b',
			'button_background_hover_color' => '#00bbb3',
			'button_outline_text_basic_color' => '#00d58b',
			'button_outline_text_hover_color' => '#ffffff',
			'button_outline_border_basic_color' => '#00d58b',
			'widget_title_color' => '#22323d',
			'widget_link_color' => '#12232f',
			'widget_hover_link_color' => '#0acc95',
			'widget_active_link_color' => '#0acc95',
			'footer_widget_title_color' => '#ffffff',
			'footer_widget_text_color' => '#ffffff',
			'footer_widget_link_color' => '#ffffff',
			'footer_widget_hover_link_color' => '#0acc95',
			'footer_widget_active_link_color' => '#0acc95',
			'portfolio_title_color' => '#12232f',
			'portfolio_description_color' => '#697671',
			'portfolio_date_color' => '#202f39',
			'gallery_caption_background_color' => '#202f39',
			'gallery_title_color' => '#ffffff',
			'gallery_description_color' => '#ffffff',
			'slideshow_arrow_background' => '#18d685',
			'slideshow_arrow_hover_background' => '#00bbb3',
			'slideshow_arrow_color' => '#ffffff',
			'sliders_arrow_color' => '#ffffff',
			'sliders_arrow_background_color' => '',
			'sliders_arrow_hover_color' => '#ffffff',
			'sliders_arrow_background_hover_color' => '#18d685',
			'bullets_symbol_color' => '#d8e1e3',
			'icons_symbol_color' => '#18d685',
			'pagination_basic_color' => '#12232f',
			'pagination_basic_background_color' => '#f0f4f7',
			'pagination_basic_border_color' => '#dfe5e8',
			'pagination_hover_color' => '#18d685',
			'pagination_active_color' => '#18d685',
			'mini_pagination_color' => '#d8e1e3',
			'mini_pagination_active_color' => '#18d685',
			'form_elements_background_color' => '#ffffff',
			'form_elements_text_color' => '#697671',
			'form_elements_border_color' => '',
			'basic_outer_background_image' => '',
			'top_background_image' => '',
			'top_area_background_image' => '',
			'main_background_image' => '',
			'footer_background_image' => '',
			'footer_widget_area_background_image' => '',
		)
	));
	if($skin) {
		return $skin_defaults[$skin];
	}
	return $skin_defaults;
}

function cryption_first_install_settings() {
	return apply_filters('cryption_default_theme_options', array(
		'theme_name' => 'cryption',
		'page_layout_style' => 'fullwidth',
		'disable_smooth_scroll' => '1',
		'logo_width' => '210',
		'small_logo_width' => '140',
		'logo' => get_template_directory_uri() . '/images/default-logo.png',
		'small_logo' => get_template_directory_uri() . '/images/default-logo-small.png',
		'logo_light' => get_template_directory_uri() . '/images/default-logo-light.png',
		'small_logo_light' => get_template_directory_uri() . '/images/default-logo-small-light.png',
		'preloader_style' => 'preloader-4',
		'custom_css' => '',
		'custom_js' => '',
		'404_page' => '',
		'header_layout' => 'default',
		'logo_position' => 'left',
		'menu_appearance_tablet_portrait' => 'responsive',
		'menu_appearance_tablet_landscape' => 'responsive',
		'top_area_style' => '2',
		'top_area_alignment' => 'left',
		'top_area_contacts' => '1',
		'top_area_socials' => '1',
		'top_area_button_text' => '',
		'top_area_button_link' => '',
		'top_area_disable_fixed' => '1',
		'top_area_disable_mobile' => '1',
		'main_menu_font_family' => 'Montserrat',
		'main_menu_font_style' => '500',
		'main_menu_font_sets' => 'latin,latin-ext,vietnamese',
		'main_menu_font_size' => '17',
		'main_menu_line_height' => '27',
		'submenu_font_family' => 'Montserrat',
		'submenu_font_style' => 'regular',
		'submenu_font_sets' => 'latin,latin-ext,vietnamese',
		'submenu_font_size' => '15',
		'submenu_line_height' => '22',
		'styled_subtitle_font_family' => 'Montserrat',
		'styled_subtitle_font_style' => '300',
		'styled_subtitle_font_sets' => 'latin-ext,latin',
		'styled_subtitle_font_size' => '24',
		'styled_subtitle_line_height' => '36',
		'h1_font_family' => 'Montserrat',
		'h1_font_style' => '700',
		'h1_font_sets' => 'latin',
		'h1_font_size' => '50',
		'h1_line_height' => '69',
		'h2_font_family' => 'Montserrat',
		'h2_font_style' => '700',
		'h2_font_sets' => 'latin',
		'h2_font_size' => '40',
		'h2_line_height' => '54',
		'h3_font_family' => 'Montserrat',
		'h3_font_style' => '700',
		'h3_font_sets' => 'latin',
		'h3_font_size' => '30',
		'h3_line_height' => '40',
		'h4_font_family' => 'Montserrat',
		'h4_font_style' => '700',
		'h4_font_sets' => 'latin',
		'h4_font_size' => '24',
		'h4_line_height' => '32',
		'h5_font_family' => 'Montserrat',
		'h5_font_style' => '700',
		'h5_font_sets' => 'latin',
		'h5_font_size' => '19',
		'h5_line_height' => '26',
		'h6_font_family' => 'Montserrat',
		'h6_font_style' => '700',
		'h6_font_sets' => 'latin',
		'h6_font_size' => '15',
		'h6_line_height' => '24',
		'xlarge_title_font_family' => 'Montserrat',
		'xlarge_title_font_style' => '700',
		'xlarge_title_font_sets' => 'latin,latin-ext',
		'xlarge_title_font_size' => '80',
		'xlarge_title_line_height' => '90',
		'light_title_font_family' => 'Montserrat',
		'light_title_font_style' => '200',
		'light_title_font_sets' => 'latin',
		'body_font_family' => 'Montserrat',
		'body_font_style' => 'regular',
		'body_font_sets' => 'vietnamese,cyrillic-ext,cyrillic,latin-ext,greek,latin,greek-ext',
		'body_font_size' => '15',
		'body_line_height' => '27',
		'widget_title_font_family' => 'Montserrat',
		'widget_title_font_style' => '700',
		'widget_title_font_sets' => 'latin,latin-ext,vietnamese',
		'widget_title_font_size' => '19',
		'widget_title_line_height' => '22',
		'button_font_family' => 'Montserrat',
		'button_font_style' => '700',
		'button_font_sets' => 'latin',
		'button_thin_font_family' => 'Montserrat',
		'button_thin_font_style' => '200',
		'button_thin_font_sets' => '',
		'portfolio_title_font_family' => 'Montserrat',
		'portfolio_title_font_style' => '700',
		'portfolio_title_font_sets' => 'latin,latin-ext,vietnamese',
		'portfolio_title_font_size' => '19',
		'portfolio_title_line_height' => '24',
		'portfolio_description_font_family' => 'Montserrat',
		'portfolio_description_font_style' => 'regular',
		'portfolio_description_font_sets' => 'latin,latin-ext,vietnamese',
		'portfolio_description_font_size' => '15',
		'portfolio_description_line_height' => '24',
		'gallery_title_font_family' => 'Montserrat',
		'gallery_title_font_style' => 'regular',
		'gallery_title_font_sets' => 'latin,latin-ext,vietnamese',
		'gallery_title_font_size' => '19',
		'gallery_title_line_height' => '24',
		'gallery_title_bold_font_family' => 'Montserrat',
		'gallery_title_bold_font_style' => '700',
		'gallery_title_bold_font_sets' => 'latin,latin-ext,vietnamese',
		'gallery_title_bold_font_size' => '19',
		'gallery_title_bold_line_height' => '24',
		'gallery_description_font_family' => 'Montserrat',
		'gallery_description_font_style' => 'regular',
		'gallery_description_font_sets' => 'latin,latin-ext,vietnamese',
		'gallery_description_font_size' => '15',
		'gallery_description_line_height' => '24',
		'testimonial_font_family' => 'Open Sans',
		'testimonial_font_style' => '300',
		'testimonial_font_sets' => 'latin-ext,latin',
		'testimonial_font_size' => '15',
		'testimonial_line_height' => '25',
		'counter_font_family' => 'Montserrat',
		'counter_font_style' => '700',
		'counter_font_sets' => 'latin,latin-ext,vietnamese',
		'counter_font_size' => '50',
		'counter_line_height' => '59',
		'slideshow_title_font_family' => 'Open Sans',
		'slideshow_title_font_style' => '700',
		'slideshow_title_font_sets' => '',
		'slideshow_title_font_size' => '50',
		'slideshow_title_line_height' => '69',
		'slideshow_description_font_family' => 'Montserrat',
		'slideshow_description_font_style' => 'regular',
		'slideshow_description_font_sets' => 'latin,latin-ext,vietnamese',
		'slideshow_description_font_size' => '16',
		'slideshow_description_line_height' => '25',
		'basic_outer_background_color' => '#f0f4f7',
		'top_background_color' => '#ffffff',
		'main_background_color' => '#ffffff',
		'footer_widget_area_background_color' => '#202f39',
		'footer_background_color' => '#12232f',
		'styled_elements_background_color' => '#f0f4f7',
		'styled_elements_color_1' => '#12232f',
		'styled_elements_color_2' => '#00d58b',
		'styled_elements_color_3' => '#00bbb3',
		'divider_default_color' => '#dfe5e8',
		'box_border_color' => '#dfe5e8',
		'main_menu_level1_color' => '#12232f',
		'main_menu_level1_background_color' => '',
		'main_menu_level1_hover_color' => '#00c38c',
		'main_menu_level1_hover_background_color' => '',
		'main_menu_level1_active_color' => '#00c38c',
		'main_menu_level1_active_background_color' => '',
		'main_menu_level2_color' => '#12232f',
		'main_menu_level2_background_color' => '#f0f4f7',
		'main_menu_level2_hover_color' => '#00c38c',
		'main_menu_level2_hover_background_color' => '#ffffff',
		'main_menu_level2_active_color' => '#00c38c',
		'main_menu_level2_active_background_color' => '#ffffff',
		'main_menu_mega_column_title_color' => '#12232f',
		'main_menu_mega_column_title_hover_color' => '#00c38c',
		'main_menu_mega_column_title_active_color' => '#00c38c',
		'main_menu_level3_color' => '#12232f',
		'main_menu_level3_background_color' => '#ffffff',
		'main_menu_level3_hover_color' => '#12232f',
		'main_menu_level3_hover_background_color' => '#ffffff',
		'main_menu_level3_active_color' => '#12232f',
		'main_menu_level3_active_background_color' => '#ffffff',
		'main_menu_level1_light_color' => '#ffffff',
		'main_menu_level1_light_hover_color' => '#00c38c',
		'main_menu_level1_light_active_color' => '#00c38c',
		'main_menu_level2_border_color' => '',
		'mega_menu_icons_color' => '#00c38c',
		'top_area_background_color' => '#12232f',
		'top_area_text_color' => '#8fa5a2',
		'top_area_link_color' => '#8fa5a2',
		'top_area_link_hover_color' => '#18d685',
		'top_area_button_text_color' => '#ffffff',
		'top_area_button_background_color' => '#18d685',
		'top_area_button_hover_text_color' => '#ffffff',
		'top_area_button_hover_background_color' => '#00c2ba',
		'body_color' => '#697671',
		'h1_color' => '#191f25',
		'h2_color' => '#191f25',
		'h3_color' => '#191f25',
		'h4_color' => '#191f25',
		'h5_color' => '#191f25',
		'h6_color' => '#191f25',
		'link_color' => '#0df0a3',
		'hover_link_color' => '#191f25',
		'active_link_color' => '#191f25',
		'footer_text_color' => '#8fa5a2',
		'copyright_text_color' => '#8fa5a2',
		'copyright_link_color' => '#0df0a3',
		'title_bar_background_color' => '#2b2b2b',
		'title_bar_text_color' => '#ffffff',
		'date_filter_subtitle_color' => '#b7b7b7',
		'system_icons_font' => '#191f25',
		'system_icons_font_2' => '#191f25',
		'button_text_basic_color' => '#ffffff',
		'button_text_hover_color' => '#ffffff',
		'button_background_basic_color' => '#00d58b',
		'button_background_hover_color' => '#00bbb3',
		'button_outline_text_basic_color' => '#00d58b',
		'button_outline_text_hover_color' => '#ffffff',
		'button_outline_border_basic_color' => '#00d58b',
		'widget_title_color' => '#22323d',
		'widget_link_color' => '#12232f',
		'widget_hover_link_color' => '#0acc95',
		'widget_active_link_color' => '#0acc95',
		'footer_widget_title_color' => '#ffffff',
		'footer_widget_text_color' => '#ffffff',
		'footer_widget_link_color' => '#ffffff',
		'footer_widget_hover_link_color' => '#0acc95',
		'footer_widget_active_link_color' => '#0acc95',
		'portfolio_title_color' => '#12232f',
		'portfolio_description_color' => '#697671',
		'portfolio_date_color' => '#202f39',
		'gallery_caption_background_color' => '#202f39',
		'gallery_title_color' => '#ffffff',
		'gallery_description_color' => '#ffffff',
		'slideshow_arrow_background' => '#18d685',
		'slideshow_arrow_hover_background' => '#00bbb3',
		'slideshow_arrow_color' => '#ffffff',
		'sliders_arrow_color' => '#ffffff',
		'sliders_arrow_background_color' => '',
		'sliders_arrow_hover_color' => '#ffffff',
		'sliders_arrow_background_hover_color' => '#18d685',
		'bullets_symbol_color' => '#d8e1e3',
		'icons_symbol_color' => '#18d685',
		'pagination_basic_color' => '#12232f',
		'pagination_basic_background_color' => '#f0f4f7',
		'pagination_basic_border_color' => '#dfe5e8',
		'pagination_hover_color' => '#18d685',
		'pagination_active_color' => '#18d685',
		'mini_pagination_color' => '#d8e1e3',
		'mini_pagination_active_color' => '#18d685',
		'form_elements_background_color' => '#ffffff',
		'form_elements_text_color' => '#697671',
		'form_elements_border_color' => '',
		'basic_outer_background_image' => '',
		'top_background_image' => '',
		'top_area_background_image' => '',
		'main_background_image' => '',
		'footer_background_image' => '',
		'footer_widget_area_background_image' => '',
		'slider_effect' => 'random',
		'slider_slices' => '15',
		'slider_boxCols' => '8',
		'slider_boxRows' => '4',
		'slider_animSpeed' => '5',
		'slider_pauseTime' => '20',
		'slider_directionNav' => '1',
		'slider_controlNav' => '1',
		'show_author' => '1',
		'excerpt_length' => '20',
		'footer_active' => '1',
		'footer_html' => 'Copyright &copy; Cription 2018. All rights reserved.',
		'custom_footer' => '1743',
		'contacts_address' => '',
		'contacts_phone' => '',
		'contacts_fax' => '',
		'contacts_email' => '',
		'contacts_website' => '',
		'top_area_contacts_address' => '',
		'top_area_contacts_phone' => '',
		'top_area_contacts_fax' => '',
		'top_area_contacts_email' => '',
		'top_area_contacts_website' => '',
		'twitter_active' => '',
		'facebook_active' => '',
		'linkedin_active' => '',
		'googleplus_active' => '',
		'instagram_active' => '',
		'youtube_active' => '',
		'telegram_active' => '',
		'medium_active' => '',
		'reddit_active' => '',
		'slack_active' => '',
		'twitter_link' => '#',
		'facebook_link' => '#',
		'linkedin_link' => '#',
		'googleplus_link' => '#',
		'stumbleupon_link' => '#',
		'rss_link' => '#',
		'vimeo_link' => '#',
		'instagram_link' => '#',
		'pinterest_link' => '#',
		'youtube_link' => '#',
		'flickr_link' => '#',
		'telegram_link' => '#',
		'medium_link' => '#',
		'reddit_link' => '#',
		'slack_link' => '#',
		'show_social_icons' => '1',
		'purchase_code' => '',
	));
}

/* Create admin theme page */
function cryption_theme_add_page() {
	$page = add_theme_page(esc_html__('Theme options', 'cryption'), esc_html__('Theme options', 'cryption'), 'edit_theme_options', 'options-framework', 'cryption_theme_options_page');
}
add_action( 'admin_menu', 'cryption_theme_add_page');

function cryption_activation_google_fonts() {
	$fonts_url = '';
	$fonts = array();
	$subsets = 'latin,latin-ext';
	if ( 'off' !== _x( 'on', 'Maven Pro font: on or off', 'cryption' ) ) {
		$fonts[] = 'Maven Pro:500,600,700';
	}
	if ( 'off' !== _x( 'on', 'Oxygen font: on or off', 'cryption' ) ) {
		$fonts[] = 'Oxygen:300,400';
	}
	if ( 'off' !== _x( 'on', 'Poppins font: on or off', 'cryption' ) ) {
		$fonts[] = 'Poppins:500';
	}
	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

function cryption_theme_options_admin_enqueue_scripts($hook) {
	if($hook != 'appearance_page_options-framework') return;
	wp_enqueue_media();
	wp_enqueue_style('ct-activation-google-fonts', cryption_activation_google_fonts());
	wp_enqueue_script('ct-form-elements', get_template_directory_uri() . '/js/ct-form-elements.js', array('jquery'), false, true);
	wp_enqueue_script('ct-image-selector', get_template_directory_uri() . '/js/ct-image-selector.js', array('jquery'));
	wp_enqueue_script('ct-file-selector', get_template_directory_uri() . '/js/ct-file-selector.js', array('jquery'));
	wp_enqueue_script('ct-font-options', get_template_directory_uri() . '/js/ct-font-options.js', array('jquery'));
	wp_enqueue_script('ct-theme-options', get_template_directory_uri() . '/js/ct-theme_options.js', array('jquery-ui-position', 'jquery-ui-tabs', 'jquery-ui-slider', 'jquery-ui-accordion', 'jquery-ui-draggable', 'jquery-ui-droppable', 'jquery-ui-sortable'));
	wp_localize_script('ct-theme-options', 'theme_options_object',array(
		'ajax_url' => esc_url(admin_url( 'admin-ajax.php' )),
		'security' => wp_create_nonce('ajax_security'),
		'text1' => esc_html__('Get all from font.', 'cryption'),
		'ct_color_skin_defaults' => json_encode(cryption_color_skin_defaults()),
		'text2' => esc_html__('et colors, backgrounds and fonts options to default?', 'cryption'),
		'text3' => esc_html__('Update backup data?', 'cryption'),
		'text4' => esc_html__('Restore settings from backup data?', 'cryption'),
		'text5' => esc_html__('Import settings?', 'cryption'),
	));
}
add_action('admin_enqueue_scripts', 'cryption_theme_options_admin_enqueue_scripts');

/* Build admin theme page form */
function cryption_theme_options_page(){
	if(isset($_REQUEST['action']) && isset($_REQUEST['theme_options'])) {
		cryption_theme_update_options();
	}
	if(isset($_REQUEST['action']) && in_array($_REQUEST['action'], array('save', 'reset', 'restore', 'import'))) {
		if(cryption_generate_custom_css() === 'generate_css_continue') {
			return ;
		}
	}
	$jQuery_ui_theme = 'ui-no-theme';
	$options = cryption_get_theme_options();
	$options_values = get_option('ct_theme_options');
?>
<div class="wrap">
	<div class="theme-title">
		<img class="right-part" src="<?php echo esc_url(get_template_directory_uri().'/images/admin-images/theme-options-title-right.png'); ?>" alt="Codex Tuner" />
		<img class="left-part" src="<?php echo esc_url(get_template_directory_uri().'/images/admin-images/theme-options-title-left.png'); ?>" alt="Theme Options. ct Business." />
		<div style="clear: both;"></div>
	</div>
	<form id="theme-options-form" method="POST">
		<?php wp_nonce_field('ct-theme-options'); ?>
		<input type="hidden" name="theme_options[theme_name]" value="cryption" />
		<div class="option-wrap <?php echo esc_attr($jQuery_ui_theme); ?>">
			<div class="submit_buttons"><button name="action" value="save"><?php esc_html_e( 'Save Changes', 'cryption' ); ?></button></div>
			<div id="categories">
				<?php if(count($options) > 0) : ?>
					<ul class="styled">
						<?php foreach($options as $name => $category) : ?>
							<?php if(isset($category['subcats']) && count($category['subcats']) > 0) : ?>
								<li><a href="<?php echo esc_url('#'.$name); ?>" style="background-image: url('<?php echo esc_url(get_template_directory_uri().'/images/admin-images/'.$name.'_icon.png'); ?>');"><?php print esc_html($category['title']); ?></a></li>
							<?php endif; ?>
						<?php endforeach; ?>
						<li><a href="#backup" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/admin-images/backup_icon.png');"><?php esc_html_e('Backup', 'cryption'); ?></a></li>
						<li><a href="#activation" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/admin-images/activation_icon.png');"><?php esc_html_e('Theme activation', 'cryption'); ?></a></li>
					</ul>
				<?php endif; ?>

				<?php if(count($options) > 0) : ?>
					<?php foreach($options as $name => $category) : ?>
						<?php if(isset($category['subcats']) && count($category['subcats']) > 0) : ?>
							<div id="<?php echo esc_attr($name); ?>">
								<div class="subcategories">

									<?php foreach($category['subcats'] as $sname => $subcat) : ?>
										<div id="<?php echo esc_attr($sname); ?>">
											<h3><?php echo esc_html($subcat['title']); ?></h3>
											<div class="inside">
												<?php foreach($subcat['options'] as $oname => $option) : ?>
													<?php echo cryption_get_option_element($oname, $option, isset($options_values[$oname]) ? $options_values[$oname] : NULL); ?>
												<?php endforeach; ?>
											</div>
										</div>
									<?php endforeach; ?>

								</div>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>

					<div id="backup">
						<div class="subcategories">
								<div id="backup_theme_options">
									<h3><?php esc_html_e('Backup and Restore Theme Settings', 'cryption'); ?></h3>
									<div class="inside">
										<div class="option backup_restore_settings">
											<p><?php esc_html_e('If you would like to experiment with the settings of your theme and don\'t want to loose your previous settings, use the "Backup Settings"-button to backup your current theme options. You can restore these options later using the button "Restore Settings".', 'cryption'); ?></p>
											<?php if($backup = get_option('ct_theme_options_backup')) : ?>
												<p><b><?php esc_html_e('Last backup', 'cryption'); ?>: <?php echo date('Y-m-d H:i', $backup['date']) ?></b></p>
											<?php else : ?>
												<p><b><?php esc_html_e('Last backup', 'cryption'); ?>: <?php esc_html_e('No backups yet', 'cryption'); ?></b></p>
											<?php endif; ?>
											<div class="backups-buttons">
												<button name="action" value="backup"><?php esc_html_e( 'Backup Settings', 'cryption' ); ?></button>
												<button name="action" value="restore"><?php esc_html_e( 'Restore Settings', 'cryption' ); ?></button>
											</div>
										</div>
										<div class="option import_settings">
											<p><?php esc_html_e('In order to apply the settings of another ct theme used in a different install just copy and paste the settings in the text box and click on "Import Settings".', 'cryption'); ?></p>
											<div class="textarea">
												<textarea name="import_settings" cols="100" rows="8"><?php if($settings = get_option('ct_theme_options')) { echo json_encode($settings); } ?></textarea>
											</div>
											<p>&nbsp;</p>
											<div class="backups-buttons">
												<button name="action" value="import"><?php esc_html_e( 'Import Settings', 'cryption' ); ?></button>
											</div>
										</div>
									</div>
								</div>
						</div>
					</div>

					<div id="activation">
						<div class="activation-header">
							<img src="<?php echo get_template_directory_uri(); ?>/images/admin-images/activation-title.png" alt="CT"/>
							<h4><?php esc_html_e( 'Welcome to Cryption - ICO and Cryptocurrency WordPress Theme ', 'cryption' ); ?></h4>
						</div>
						<div class="activation-container">
							<p class="styled-subtitle"><?php esc_html_e( 'Thank you for purchasing Cryption! Would you like to import our awesome demos and take advantage of our amazing features? Please activate your copy of Cryption:', 'cryption' ); ?></p>
							<div class="activation-field">
								<table><tr>
									<td><input type="text" class="activation-input" name="theme_options[purchase_code]" placeholder="<?php esc_html_e( 'Enter purchase code, e.g. cb0e057f-a05d-4758-b314-024db98eff85', 'cryption' ); ?>" value="<?php echo esc_attr(cryption_get_option('purchase_code')); ?>" /></td>
									<td><button class="activation-submit" name="action" value="activation"><?php esc_html_e( 'Activate', 'cryption' ); ?></button></td>
								</tr></table>
								<?php if(get_option('ct_activation')) : ?>
									<p class="activation-result activation-result-success"><?php esc_html_e('Thank you, your purchase code is valid. Cryption has been activated.', 'cryption'); ?></p>
								<?php else : ?>
									<p class="activation-result activation-result-hidden"></p>
								<?php endif; ?>
								<script type="text/javascript">
									(function($) {
										$('#activation .activation-submit').click(function(e) {
											e.preventDefault();
											$.ajax({
												url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
												data: { action: 'ct_submit_activation', purchase_code: $('#activation .activation-input').val()},
												method: 'POST',
												timeout: 30000
											}).done(function(msg) {
												$('#activation .activation-result').html('');
												$('#activation .activation-result').removeClass('activation-result-hidden activation-result-success activation-result-failure');
												msg = jQuery.parseJSON(msg);
												if(msg.status) {
													$('#activation .activation-result').addClass('activation-result-success');
												} else {
													$('#activation .activation-result').addClass('activation-result-failure');
												}
												$('#activation .activation-result').text(msg.message);
											}).fail(function() {
												$('#activation .activation-result').html('');
												$('#activation .activation-result').removeClass('activation-result-hidden');
												$('#activation .activation-result').addClass('activation-result-failure');
												$('#activation .activation-result').text('<?php esc_html_e('Ajax error. Try again...', 'cryption'); ?>');
											});
										});
										$('#activation .activation-input').keydown(function(e) {
											if (e.keyCode == 13) {
												$('#activation .activation-submit').trigger('click');
												e.preventDefault();
											}
										});
									})(jQuery);
								</script>
							</div>
							<div class="activation-purchase-image">
								<a href="https://themeforest.net/downloads"><img src="<?php echo get_template_directory_uri(); ?>/images/admin-images/activation-purchase-image.jpg" alt="CT"/></a>
							</div>
<!-- 							<div class="activation-help-links">
								<a href="http://codex-themes.com/themes/documentation/cryption/"><img src="<?php echo get_template_directory_uri(); ?>/images/admin-images/activation-help-doc.jpg"></a>
								<a href="http://codexthemes.ticksy.com/"><img src="<?php echo get_template_directory_uri(); ?>/images/admin-images/activation-help-support.jpg"></a>
								<a href="http://codex-themes.com/themes/documentation/cryption/"><img src="<?php echo get_template_directory_uri(); ?>/images/admin-images/activation-help-video.jpg"></a>
							</div> -->
							<div class="activation-rate-block">
								<h4><?php esc_html_e( 'RATE Cryption', 'cryption' ); ?></h4>
								<p><?php printf(wp_kses(__( 'Please don’t forget to rate Cryption and leave a nice review, it means a lot for us and our theme.<br />Simply log in into your Themeforest, go to <a href="%s">Downloads section</a> and click 5 stars next to the Cryption WordPress theme as shown on screenshot below:', 'cryption' ), array('br' => array(), 'a' => array('href' => array()))), esc_url('https://themeforest.net/downloads')); ?></p>
								<div class="activation-rate-image">
									<a href="https://themeforest.net/downloads"><img src="<?php echo get_template_directory_uri(); ?>/images/admin-images/activation-rate-image.jpg" alt="CT"/></a>
								</div>
							</div>
						</div>
					</div>

				<?php endif; ?>

			</div>
			<div class="submit_buttons"><button name="action" value="reset"><?php esc_html_e( 'Reset Style Settings', 'cryption' ); ?></button><button name="action" value="save"><?php esc_html_e( 'Save Changes', 'cryption' ); ?></button></div>
		</div>
	</form>
</div>
<?php
}

/* Update theme options */
function cryption_theme_update_options() {
	if(check_admin_referer('ct-theme-options')) {
		if(isset($_REQUEST['action']) && isset($_REQUEST['theme_options'])) {
			$theme_options = $_REQUEST['theme_options'];
			if($_REQUEST['action'] == 'save') {
				if(defined('ICL_LANGUAGE_CODE')) {
					$ml_options = array('footer_html');
					foreach ($ml_options as $ml_option) {
						$value = cryption_get_option($ml_option, false, true);
						if(!is_array($value)) {
							global $sitepress;
							if($sitepress->get_default_language()) {
								$value = array($sitepress->get_default_language() => $value);
							}
						}
						$value[ICL_LANGUAGE_CODE] = $theme_options[$ml_option];
						$theme_options[$ml_option] = $value;
					}
				}
				ct_check_activation($theme_options);
				update_option('ct_theme_options', $theme_options);
			} elseif($_REQUEST['action'] == 'reset') {
				if($options = get_option('ct_theme_options')) {
					$defaults = cryption_color_skin_defaults();
					if(!($skin = cryption_get_option('page_color_style'))) {
						$skin = 'light';
					}
					$newOptions = array();
					foreach($defaults[$skin] as $key => $val) {
						$newOptions[$key] = $val;
					}
					$options = array_merge($options, $newOptions);
					ct_check_activation($theme_options);
					update_option('ct_theme_options', $options);
				}

			} elseif($_REQUEST['action'] == 'backup') {
				if($settings = get_option('ct_theme_options')) {
					update_option('ct_theme_options_backup', array('date' => time(), 'settings' => json_encode($settings)));
				}
			} elseif($_REQUEST['action'] == 'restore') {
				if($settings = get_option('ct_theme_options_backup')) {
					ct_check_activation($theme_options);
					update_option('ct_theme_options', json_decode($settings['settings'], true));
				}
			} elseif($_REQUEST['action'] == 'import') {
				ct_check_activation($theme_options);
				update_option('ct_theme_options', json_decode(stripslashes($_REQUEST['import_settings']), true));
			} elseif($_REQUEST['action'] == 'activation' && isset($_REQUEST['theme_options']['purchase_code'])) {
				$theme_options = get_option('ct_theme_options');
				$theme_options['purchase_code'] = $_REQUEST['theme_options']['purchase_code'];
				ct_check_activation($theme_options);
				update_option('ct_theme_options', $theme_options);
			}
		}
	}
}

/* Get theme option*/
if(!function_exists('cryption_get_option')) {
function cryption_get_option($name, $default = false, $ml_full = false) {
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

function cryption_generate_custom_css() {
	ob_start();
	cryption_custom_fonts();
	require get_template_directory() . '/inc/custom-css.php';
	if(file_exists(get_stylesheet_directory() . '/inc/custom-css.php') && get_stylesheet_directory() != get_template_directory()) {
		require get_stylesheet_directory() . '/inc/custom-css.php';
	}
	$custom_css = ob_get_clean();
	$action = array('action');
	$url = wp_nonce_url('themes.php?page=options-framework','ct-theme-options');
	if (false === ($creds = request_filesystem_credentials($url, '', false, get_stylesheet_directory() . '/css/', $action) ) ) {
		return 'generate_css_continue';
	}
	if(!WP_Filesystem($creds)) {
		request_filesystem_credentials($url, '', true, get_stylesheet_directory() . '/css/', $action);
		return 'generate_css_continue';
	}
	global $wp_filesystem;
	if(!$wp_filesystem->put_contents($wp_filesystem->find_folder(get_stylesheet_directory()) . 'css/custom.css', $custom_css)) {
		update_option('ct_genearte_css_error', '1');
?>
	<div class="error">
		<p><?php printf(esc_html__('CT\'s styles cannot be customized because file "%s" cannot be modified. Please check your server\'s settings. Then click "Save Changes" button.', 'cryption'), get_stylesheet_directory() . '/css/custom.css'); ?></p>
	</div>
<?php
	} else {
		delete_option('ct_genearte_css_error');
	}
}

function cryption_genearte_css_error() {
	if(isset($_GET['page']) && $_GET['page'] == 'options-framework' && get_option('ct_genearte_css_error')) {
?>
	<div class="error">
		<p><?php printf(esc_html__('CT\'s styles cannot be customized because file "%s" cannot be modified. Please check your server\'s settings. Then click "Save Changes" button.', 'cryption'), get_stylesheet_directory() . '/css/custom.css'); ?></p>
	</div>
<?php
	}
}
add_action('admin_notices', 'cryption_genearte_css_error');

function ct_activate() {
	global $pagenow;
	if(is_admin() && 'themes.php' == $pagenow && isset($_GET['activated'])) {
		wp_redirect(admin_url('themes.php?page=options-framework#activation'));
		exit;
	}
}
add_action('after_setup_theme', 'ct_activate', 11);

add_action('wp_ajax_ct_submit_activation', 'ct_submit_activation');
function ct_submit_activation() {
	delete_option('ct_activation');
	if(!empty($_REQUEST['purchase_code'])) {
		$theme_options = get_option('ct_theme_options');
		$theme_options['purchase_code'] = $_REQUEST['purchase_code'];
		update_option('ct_theme_options', $theme_options);
		$response_p = wp_remote_get(add_query_arg(array('code' => $_REQUEST['purchase_code'], 'site_url' => get_site_url()), esc_url('http://democontent.codex-themes.com/av_validate_code.php')), array('timeout' => 20));
		if(is_wp_error($response_p)) {
			echo json_encode(array('status' => 0, 'message' => esc_html__('Some troubles with connecting to Codex Themes server.', 'cryption')));
		} else {
			$rp_data = json_decode($response_p['body'], true);
			if(is_array($rp_data) && isset($rp_data['result']) && $rp_data['result'] && isset($rp_data['item_id']) && $rp_data['item_id'] === '21714401') {
				echo json_encode(array('status' => 1, 'message' => esc_html__('Thank you, your purchase code is valid. Cryption Theme has been activated.', 'cryption')));
				update_option('ct_activation', 1);
			} else {
				echo json_encode(array('status' => 0, 'message' => esc_html__('The purchase code you have entered is not valid. Cryption Theme has not been activated.', 'cryption')));
			}
		}
	} else {
		echo json_encode(array('status' => 0, 'message' => esc_html__('Purchase code is empty.', 'cryption')));
	}
	die(-1);
}

function ct_check_activation($theme_options) {
	if(get_option('ct_activation')) {
		if(empty($theme_options['purchase_code'])) {
			delete_option('ct_activation');
		} elseif($theme_options['purchase_code'] !== cryption_get_option('purchase_code')) {
			delete_option('ct_activation');
			$response_p = wp_remote_get(add_query_arg(array('code' => $theme_options['purchase_code'], 'site_url' => get_site_url()), esc_url('http://democontent.codex-themes.com/av_validate_code.php')), array('timeout' => 20));
			if(!is_wp_error($response_p)) {
				$rp_data = json_decode($response_p['body'], true);
				if(is_array($rp_data) && isset($rp_data['result']) && $rp_data['result'] && isset($rp_data['item_id']) && $rp_data['item_id'] === '21714401') {
					update_option('ct_activation', 1);
				}
			}
		}
	} elseif(!empty($theme_options['purchase_code'])) {
		$response_p = wp_remote_get(add_query_arg(array('code' => $theme_options['purchase_code'], 'site_url' => get_site_url()), esc_url('http://democontent.codex-themes.com/av_validate_code.php')), array('timeout' => 20));
		if(!is_wp_error($response_p)) {
			$rp_data = json_decode($response_p['body'], true);
			if(is_array($rp_data) && isset($rp_data['result']) && $rp_data['result'] && isset($rp_data['item_id']) && $rp_data['item_id'] === '21714401') {
				update_option('ct_activation', 1);
			}
		}
	}
}

function ct_activation_notice() {
	if(get_option('ct_activation') || !empty( $_COOKIE['ct_activation'] )) {
		return ;
	}
?>
<style>
	.ct_license-activation-notice {
		position: relative;
	}
</style>
<script type="text/javascript">
(function ( $ ) {
	var setCookie = function ( c_name, value, exdays ) {
		var exdate = new Date();
		exdate.setDate( exdate.getDate() + exdays );
		var c_value = encodeURIComponent( value ) + ((null === exdays) ? "" : "; expires=" + exdate.toUTCString());
		document.cookie = c_name + "=" + c_value;
	};
	$( document ).on( 'click.ct-notice-dismiss', '.ct-notice-dismiss', function ( e ) {
		e.preventDefault();
		var $el = $( this ).closest('#ct_license-activation-notice' );
		$el.fadeTo( 100, 0, function () {
			$el.slideUp( 100, function () {
				$el.remove();
			} );
		} );
		setCookie( 'ct_activation', '1', 30 );
	} );
})( window.jQuery );
</script>
<?php
	echo '<div class="updated ct_license-activation-notice" id="ct_license-activation-notice"><p>' . sprintf( wp_kses(__( 'Welcome to Cryption Theme! Would you like to import our awesome demos and take advantage of our amazing features? Please <a href="%s">activate</a> your copy of Cryption Theme.', 'cryption' ), array('a' => array('href' => array()))), esc_url(admin_url('themes.php?page=options-framework#activation')) ) . '</p>' . '<button type="button" class="notice-dismiss ct-notice-dismiss"><span class="screen-reader-text">' . __( 'Dismiss this notice.', 'default' ) . '</span></button></div>';
}
add_action('admin_notices', 'ct_activation_notice');