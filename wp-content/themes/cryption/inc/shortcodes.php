<?php

function cryption_theme_shortcodes_init($available_shortcodes) {
	$available_shortcodes = array(
		'ct_fullwidth',
		'ct_divider',
		'ct_image',
		'ct_icon_with_title',
		'ct_textbox',
		'ct_youtube',
		'ct_vimeo',
		'ct_dropcap',
		'ct_quote',
		'ct_video',
		'ct_list',
		'ct_table',
		'ct_icon_with_text',
		'ct_alert_box',
		'ct_clients',
		'ct_diagram',
		'ct_skill',
		'ct_gallery',
		'ct_news',
		'ct_team',
		'ct_pricing_table',
		'ct_pricing_column',
		'ct_pricing_price',
		'ct_pricing_row',
		'ct_pricing_row_title',
		'ct_pricing_footer',
		'ct_icon',
		'ct_button',
		'ct_testimonials',
		'ct_map_with_text',
		'ct_counter',
		'ct_counter_box',
		'ct_portfolio_slider',
		'ct_portfolio',
		'ct_link',
		'ct_socials',
		'ct_countdown',
        'ct_quickfinder',
	);
	return $available_shortcodes;
}
add_filter('ct_available_shortcodes', 'cryption_theme_shortcodes_init');


function cryption_do_shortcode_tag($output, $tag, $attr, $m) {
	$func_name = 'cryption_change_'.$tag.'_shortcode_output';
	if(function_exists($func_name)) {
		$output = $func_name($attr);
	}
	return $output;
}
add_filter( 'do_shortcode_tag', 'cryption_do_shortcode_tag', 10, 4);


function cryption_quickfinder_shortcode_output($atts) {
    ob_start();
    cryption_quickfinder_shortcode_output($atts);
    $return_html = trim(preg_replace('/\s\s+/', ' ', ob_get_clean()));
    return $return_html;
}

function cryption_change_ct_pricing_price_shortcode_output($atts) {
	extract(shortcode_atts(array(
		'title' => '',
		'subtitle' => '',
		'currency' => '',
		'price' => '',
		'time' => '',
		'font_size' => '',
		'color' => '',
		'use_style' => '',
		'background' => '',
		'backgroundcolor' => '',
		'font_size' => '',
		'price_color' => '',
		'title_color' => '',
		'subtitle_color' => '',
		'time_color' => '',
		'font_size_time' => ''

	), $atts, 'ct_pricing_price'));

	$svg_fill= '';
	$bottom_html = '';
	$title_bottom_html = '';
	if ($backgroundcolor) { $svg_fill = 'style="fill:'.$backgroundcolor.'"';}
	if($use_style == 7) {
		$pattern_id = 'pattern-'.time().'-'.rand(0, 10000);
		$title_bottom_html = '<svg ' .esc_attr($svg_fill). ' width="100%" height="54"><defs><pattern id="'.esc_attr($pattern_id).'-p" x="0" y="0" width="54" height="54" patternUnits="userSpaceOnUse" ><path d="M22.033,44.131c-0.26,0,0.015,0.016,0.065,0.023L22.033,44.131z M53.988,54V33.953c-1.703,0.01-3.555,0.287-5.598,0.916 c-6.479,1.994-14.029,14.057-26.286,9.287l-0.104,0.004v0.006c-7.734-2.945-12.697-10.543-21.99-10.193V54H53.988z" /></pattern><filter id="'.esc_attr($pattern_id).'-f" x="0" y="0" width="100%" height="100%"><feOffset result="offOut" in="SourceGraphic" dx="0" dy="-4" /><feColorMatrix result="matrixOut" in="offOut" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0" /><feGaussianBlur result="blurOut" in="matrixOut" stdDeviation="0" /><feBlend in="SourceGraphic" in2="blurOut" mode="normal" /></filter></defs><rect x="0" y="0" width="100%" height="54" style="fill: url(#'.esc_attr($pattern_id).'-p);" filter="url(#'.esc_attr($pattern_id).'-f)" /></svg>';
	}
	$background = cryption_attachment_url($background);
	$return_html = '<div class="pricing-price-row '.esc_attr($background ? 'pricing-price-row-width-background' : '').' "  style="'.esc_attr($background ? ' background-image: url('.$background.');' : '') . esc_attr($backgroundcolor ? ' background-color: '.$backgroundcolor.'; ' : '') . esc_attr($price_color ? 'color:'.$price_color.'; ' : '') .'">'
		.($title ? '<div class="pricing-price-title-wrapper">'.
		'<div '.($title_color ? 'style="color:'.esc_attr($title_color).'"' : '').' class="pricing-price-title">'.$title.'</div>'.
		'<div '.($subtitle_color ? 'style="color:'.$subtitle_color.'"' : '').' class="pricing-price-subtitle">'.$subtitle.'</div>'.$title_bottom_html.'</div>' : '').
		($use_style == 5 ? '<div class="pricing-price-top-border-left"></div><div class="pricing-price-circle"></div><div class="pricing-price-top-border-right"></div>' : '').
		'<div class="pricing-price-wrapper"><div class="pricing-price'.esc_attr($background ? ' pricing-price-row-background' : '').'" style="'.esc_attr($background ? ' background-image: url('.$background.');' : '') . esc_attr($backgroundcolor ? ' background-color: '.$backgroundcolor.' !important; ' : '') .'">'.
		'<div style=" '.esc_attr($price_color ? 'color:'.$price_color.'; ' : '') .esc_attr($font_size != '' ? 'font-size: '.$font_size.'px;' : '').'" class="pricing-cost">'.$currency.$price.'</div>'.($time != '' ? '<div  class="time" style= ' .'display:inline-block;'  . esc_attr($time_color ? 'color:'.$time_color.';' : '') . esc_attr($font_size_time ? 'font-size:'.$font_size_time.'px; ' : '') .'>'.$time.'</div>' : '').
		'</div></div>'
		.$bottom_html.
		'</div>';

	return $return_html;
}

function cryption_change_ct_testimonials_shortcode_output($atts) {
	extract(shortcode_atts(array(
		'set' => '',
		'fullwidth' => '',
		'layout' => 'slider',
		'columns' => '1',
		'autoscroll' => 0,
		'style' => 'style1',
	), $atts, 'ct_testimonials'));
	ob_start();

	if($layout === 'slider') {
		cryption_testimonials_slider_output(array('testimonials_set' => $set, 'style' => $style, 'fullwidth' => $fullwidth, 'autoscroll' => $autoscroll));
	} else {
		cryption_testimonials_columns_output(array('testimonials_set' => $set, 'style' => $style, 'columns' => $columns));
	}
	$return_html = trim(preg_replace('/\s\s+/', ' ', ob_get_clean()));
	return $return_html;
}

function cryption_testimonials_slider_output($params) {
	$params = array_merge(array('testimonials_set' => '', 'fullwidth' => '', 'style' => 'style1', 'autoscroll' => 0), $params);
	$args = array(
		'post_type' => 'ct_testimonial',
		'orderby' => 'menu_order ID',
		'order' => 'ASC',
		'posts_per_page' => -1,
	);
	if($params['testimonials_set'] != '') {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'ct_testimonials_sets',
				'field' => 'slug',
				'terms' => explode(',', $params['testimonials_set'])
			)
		);
	}
	$testimonials_items = new WP_Query($args);

	if($testimonials_items->have_posts()) {
		wp_enqueue_script('ct-testimonials-carousel');
		echo '<div class="preloader"><div class="preloader-spin"></div></div>';
		echo '<div class="'.esc_attr($params['style']).' ct-testimonials'.esc_attr( $params['fullwidth'] ? ' fullwidth-block' : '' ).'"'.( intval($params['autoscroll']) ? ' data-autoscroll="'.esc_attr(intval($params['autoscroll'])).'"' : '' ).'>';
		while($testimonials_items->have_posts()) {
			$testimonials_items->the_post();
			include(locate_template(array('ct-templates/testimonials/content-testimonials-carousel-item.php')));
		}

		echo '</div>';
	}
	wp_reset_postdata();
}

function cryption_testimonials_columns_output($params) {
	$params = array_merge(array('testimonials_set' => '', 'style' => 'style1', 'columns' => '1'), $params);
	$args = array(
		'post_type' => 'ct_testimonial',
		'orderby' => 'menu_order ID',
		'order' => 'ASC',
		'posts_per_page' => -1,
	);
	if($params['testimonials_set'] != '') {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'ct_testimonials_sets',
				'field' => 'slug',
				'terms' => explode(',', $params['testimonials_set'])
			)
		);
	}
	$testimonials_items = new WP_Query($args);

	if($testimonials_items->have_posts()) {
		echo '<div class="ct-testimonials-grid"><div class="row">';
		while($testimonials_items->have_posts()) {
			$testimonials_items->the_post();
			include(locate_template(array('ct-templates/testimonials/content-testimonials-grid-item.php')));
		}
		echo '</div></div>';
	}
	wp_reset_postdata();
}

add_filter('ct_shortcodes_array', 'cryption_update_shortcodes_array');
function cryption_update_shortcodes_array($shortcodes) {
	$shortcodes['ct_image']['params'] = array_merge(array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Width', 'cryption'),
				'param_name' => 'width',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Height', 'cryption'),
				'param_name' => 'height',
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Src', 'cryption'),
				'param_name' => 'src',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Alt text', 'cryption'),
				'param_name' => 'alt',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Border Style', 'cryption'),
				'param_name' => 'style',
				'value' => array(
					esc_html__('no border', 'cryption') => 'default',
					esc_html__('1px & border', 'cryption') => '1',
					esc_html__('16px & border', 'cryption') => '2',
					esc_html__('8px outlined border', 'cryption') => '3',
					esc_html__('20px outlined border', 'cryption') => '4',
					esc_html__('20px border with shadow', 'cryption') => '5',
					esc_html__('With shadow', 'cryption') => '6',
					esc_html__('20px border radius', 'cryption') => '7',
					esc_html__('55px border radius', 'cryption') => '8',
					esc_html__('Solid inside', 'cryption') => '9',
					esc_html__('Dashed outside', 'cryption') => '10',
					esc_html__('Rounded with border', 'cryption') => '11'
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Position', 'cryption'),
				'param_name' => 'position',
				'value' => array(esc_html__('below', 'cryption') => 'below', esc_html__('centered', 'cryption') => 'centered', esc_html__('left', 'cryption') => 'left', esc_html__('right', 'cryption') => 'right')
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__('Disable lightbox', 'cryption'),
				'param_name' => 'disable_lightbox',
				'value' => array(esc_html__('Yes', 'cryption') => '1')
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__('Lazy loading enabled', 'cryption'),
				'param_name' => 'effects_enabled',
				'value' => array(esc_html__('Yes', 'cryption') => '1')
			),
		)
	);

	$shortcodes['ct_fullwidth']['params'] = array_merge(array(
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Color', 'cryption'),
				'param_name' => 'color',
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Background Color', 'cryption'),
				'param_name' => 'background_color',
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Use Gradient Backgound', 'cryption'),
				'param_name' => 'gradient_backgound',
				'value' => array(__('Yes', 'cryption') => '1')
			),

			array(
				'type' => 'colorpicker',
				'heading' => __('From', 'cryption'),
				'param_name' => 'gradient_backgound_from',
				'dependency' => array(
					'element' => 'gradient_backgound',
					'value' => array('1')
				)
			),
			array(
				'type' => 'colorpicker',
				'heading' => __('To', 'cryption'),
				'param_name' => 'gradient_backgound_to',

				'dependency' => array(
					'element' => 'gradient_backgound',
					'value' => array('1')
				)
			),
			array(
				"type" => "dropdown",
				'heading' => __('Style', 'cryption'),
				'param_name' => 'gradient_backgound_style',
				"edit_field_class" => "vc_col-sm-4 vc_column",
				"value" => array(
					__('Linear', "cryption") => "linear",
					__('Radial', "cryption") => "radial",
				) ,
				"std" => 'linear',
				'dependency' => array(
					'element' => 'gradient_backgound',
					'value' => array('1')
				)
			),
			array(
				"type" => "dropdown",
				'heading' => __('Gradient Position', 'cryption'),
				'param_name' => 'gradient_radial_backgound_position',
				"edit_field_class" => "vc_col-sm-4 vc_column",
				"value" => array(
					__('Top', "cryption") => "at top",
					__('Bottom', "cryption") => "at bottom",
					__('Right', "cryption") => "at right",
					__('Left', "cryption") => "at left",
					__('Center', "cryption") => "at center",

				) ,
				'dependency' => array(
					'element' => 'gradient_backgound_style',
					'value' => array(
						'radial',
					)
				)
			),
			array(
				"type" => "dropdown",
				'heading' => __('Custom Angle', 'cryption'),
				'param_name' => 'gradient_backgound_angle',
				"edit_field_class" => "vc_col-sm-4 vc_column",
				"value" => array(
					__('Vertical to bottom ↓', "cryption") => "to bottom",
					__('Vertical to top ↑', "cryption") => "to top",
					__('Horizontal to left  →', "cryption") => "to right",
					__('Horizontal to right ←', "cryption") => "to left",
					__('Diagonal from left to bottom ↘', "cryption") => "to bottom right",
					__('Diagonal from left to top ↗', "cryption") => "to top right",
					__('Diagonal from right to bottom ↙', "cryption") => "to bottom left",
					__('Diagonal from right to top ↖', "cryption") => "to top left",
					__('Custom', "cryption") => "cusotom_deg",

				) ,
				'dependency' => array(
					'element' => 'gradient_backgound_style',
					'value' => array(
						'linear',
					)
				)
			),
			array(
				"type" => "textfield",
				'heading' => __('Angle', 'cryption'),
				'param_name' => 'gradient_backgound_cusotom_deg',
				"edit_field_class" => "vc_col-sm-4 vc_column",
				'description' => __('Set value in DG 0-360', 'cryption'),
				'dependency' => array(
					'element' => 'gradient_backgound_angle',
					'value' => array(
						'cusotom_deg',
					)
				)
			),

			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Background image', 'cryption'),
				'param_name' => 'background_image',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Background style', 'cryption'),
				'param_name' => 'background_style',
				'value' => array(
					esc_html__('Default', 'cryption') => '',
					esc_html__('Cover', 'cryption') => 'cover',
					esc_html__('Contain', 'cryption') => 'contain',
					esc_html__('No Repeat', 'cryption') => 'no-repeat',
					esc_html__('Repeat', 'cryption') => 'repeat'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Background horizontal position', 'cryption'),
				'param_name' => 'background_position_horizontal',
				'value' => array(
					esc_html__('Center', 'cryption') => 'center',
					esc_html__('Left', 'cryption') => 'left',
					esc_html__('Right', 'cryption') => 'right'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Background vertical position', 'cryption'),
				'param_name' => 'background_position_vertical',
				'value' => array(
					esc_html__('Top', 'cryption') => 'top',
					esc_html__('Center', 'cryption') => 'center',
					esc_html__('Bottom', 'cryption') => 'bottom'
				)
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__('Parallax', 'cryption'),
				'param_name' => 'background_parallax',
				'value' => array(esc_html__('Yes', 'cryption') => '1')
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__('Enable Parallax on Mobiles', 'cryption'),
				'param_name' => 'background_parallax_mobile',
				'value' => array(esc_html__('Yes', 'cryption') => '1'),
				'dependency' => array(
					'element' => 'background_parallax',
					'value' => array('1')
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Parallax type', 'cryption'),
				'param_name' => 'background_parallax_type',
				'value' => array(
					esc_html__('Vertical', 'cryption') => 'vertical',
					esc_html__('Horizontal', 'cryption') => 'horizontal',
					esc_html__('Fixed', 'cryption') => 'fixed'
				),
				'dependency' => array(
					'element' => 'background_parallax',
					'value' => array('1')
				)
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Parallax overlay color', 'cryption'),
				'param_name' => 'background_parallax_overlay_color',
				'dependency' => array(
					'element' => 'background_parallax',
					'value' => array('1')
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Background video type', 'cryption'),
				'param_name' => 'video_background_type',
				'value' => array(
					esc_html__('None', 'cryption') => '',
					esc_html__('YouTube', 'cryption') => 'youtube',
					esc_html__('Vimeo', 'cryption') => 'vimeo',
					esc_html__('Self', 'cryption') => 'self'
				)
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Video id (YouTube or Vimeo) or src', 'cryption'),
				'param_name' => 'video_background_src',
				'value' => ''
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Video Aspect ratio (16:9, 16:10, 4:3...)', 'cryption'),
				'param_name' => 'video_background_acpect_ratio',
				'value' => '16:9'
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Background video overlay color', 'cryption'),
				'param_name' => 'video_background_overlay_color',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Background video overlay opacity (0 - 1)', 'cryption'),
				'param_name' => 'video_background_overlay_opacity',
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Video Poster', 'cryption'),
				'param_name' => 'video_background_poster',
				'dependency' => array(
					'element' => 'video_background_type',
					'value' => array('self')
				)
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Padding top', 'cryption'),
				'param_name' => 'padding_top',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Padding bottom', 'cryption'),
				'param_name' => 'padding_bottom',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Padding left', 'cryption'),
				'param_name' => 'padding_left',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Padding right', 'cryption'),
				'param_name' => 'padding_right',
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__('Container', 'cryption'),
				'param_name' => 'container',
				'value' => array(esc_html__('Yes', 'cryption') => '1')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Z-Index', 'cryption'),
				'param_name' => 'z_index',
				'value' => array('auto',0,1,2,3,4,5,6,7,8,9,10)
			),
		)
	);
	$shortcodes['ct_alert_box']['params'] = array_merge(array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Icon pack', 'cryption'),
			'param_name' => 'icon_pack',
			'value' => array_merge(array(esc_html__('Elegant', 'cryption') => 'elegant', esc_html__('Material Design', 'cryption') => 'material', esc_html__('FontAwesome', 'cryption') => 'fontawesome'), ct_userpack_to_dropdown(), array(esc_html__('Image', 'cryption') => 'image')),
		),
		array(
			'type' => 'ct_icon',
			'heading' => esc_html__('Icon', 'cryption'),
			'param_name' => 'icon_elegant',
			'icon_pack' => 'elegant',
			'dependency' => array(
				'element' => 'icon_pack',
				'value' => array('elegant')
			),
		),
		array(
			'type' => 'ct_icon',
			'heading' => esc_html__('Icon', 'cryption'),
			'param_name' => 'icon_material',
			'icon_pack' => 'material',
			'dependency' => array(
				'element' => 'icon_pack',
				'value' => array('material')
			),
		),
		array(
			'type' => 'ct_icon',
			'heading' => esc_html__('Icon', 'cryption'),
			'param_name' => 'icon_fontawesome',
			'icon_pack' => 'fontawesome',
			'dependency' => array(
				'element' => 'icon_pack',
				'value' => array('fontawesome')
			),
		),
	),
		ct_userpack_to_shortcode(array(
			array(
				'type' => 'ct_icon',
				'heading' => esc_html__('Icon', 'cryption'),
				'param_name' => 'icon_userpack',
				'icon_pack' => 'userpack',
				'dependency' => array(
					'element' => 'icon_pack',
					'value' => array('userpack')
				),
			),
		)),
		array(
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Image', 'cryption'),
				'param_name' => 'image',
				'dependency' => array(
					'element' => 'icon_pack',
					'value' => array('image')
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Icon Shape', 'cryption'),
				'param_name' => 'icon_shape',
				'value' => array(esc_html__('Square', 'cryption') => 'square', esc_html__('Circle', 'cryption') => 'circle', esc_html__('Rhombus', 'cryption') => 'romb', esc_html__('Hexagon', 'cryption') => 'hexagon'),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Icon Style', 'cryption'),
				'param_name' => 'icon_style',
				'value' => array(esc_html__('Default', 'cryption') => '', esc_html__('45 degree Right', 'cryption') => 'angle-45deg-r', esc_html__('45 degree Left', 'cryption') => 'angle-45deg-l', esc_html__('90 degree', 'cryption') => 'angle-90deg'),
				'dependency' => array(
					'element' => 'icon_pack',
					'value' => array('elegant', 'material', 'fontawesome', 'userpack')
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Color', 'cryption'),
				'param_name' => 'icon_color',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency' => array(
					'element' => 'icon_pack',
					'value' => array('elegant', 'material', 'fontawesome', 'userpack')
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Color 2', 'cryption'),
				'param_name' => 'icon_color_2',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency' => array(
					'element' => 'icon_pack',
					'value' => array('elegant', 'material', 'fontawesome', 'userpack')
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Background Color', 'cryption'),
				'param_name' => 'icon_background_color',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency' => array(
					'element' => 'icon_pack',
					'value' => array('elegant', 'material', 'fontawesome', 'userpack')
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Border Color', 'cryption'),
				'param_name' => 'icon_border_color',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency' => array(
					'element' => 'icon_pack',
					'value' => array('elegant', 'material', 'fontawesome', 'userpack')
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Icon Size', 'cryption'),
				'param_name' => 'icon_size',
				'value' => array(esc_html__('Small', 'cryption') => 'small', esc_html__('Medium', 'cryption') => 'medium', esc_html__('Large', 'cryption') => 'large', esc_html__('Extra Large', 'cryption') => 'xlarge'),
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Text Color', 'cryption'),
				'param_name' => 'content_text_color',
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Background Color', 'cryption'),
				'param_name' => 'content_background_color',
				'std' => '#f4f6f7'
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Use Gradient Backgound', 'cryption'),
				'param_name' => 'gradient_backgound',
				'value' => array(__('Yes', 'cryption') => '1')
			),

			array(
				'type' => 'colorpicker',
				'heading' => __('From', 'cryption'),
				'param_name' => 'gradient_backgound_from',
				'dependency' => array(
					'element' => 'gradient_backgound',
					'value' => array('1')
				)
			),
			array(
				'type' => 'colorpicker',
				'heading' => __('To', 'cryption'),
				'param_name' => 'gradient_backgound_to',

				'dependency' => array(
					'element' => 'gradient_backgound',
					'value' => array('1')
				)
			),
			array(
				"type" => "dropdown",
				'heading' => __('Style', 'cryption'),
				'param_name' => 'gradient_backgound_style',
				"edit_field_class" => "vc_col-sm-4 vc_column",
				"value" => array(
					__('Linear', "cryption") => "linear",
					__('Radial', "cryption") => "radial",
				) ,
				"std" => 'linear',
				'dependency' => array(
					'element' => 'gradient_backgound',
					'value' => array('1')
				)
			),
			array(
				"type" => "dropdown",
				'heading' => __('Gradient Position', 'cryption'),
				'param_name' => 'gradient_radial_backgound_position',
				"edit_field_class" => "vc_col-sm-4 vc_column",
				"value" => array(
					__('Top', "cryption") => "at top",
					__('Bottom', "cryption") => "at bottom",
					__('Right', "cryption") => "at right",
					__('Left', "cryption") => "at left",
					__('Center', "cryption") => "at center",

				) ,
				'dependency' => array(
					'element' => 'gradient_backgound_style',
					'value' => array(
						'radial',
					)
				)
			),
			array(
				"type" => "dropdown",
				'heading' => __('Custom Angle', 'cryption'),
				'param_name' => 'gradient_backgound_angle',
				"edit_field_class" => "vc_col-sm-4 vc_column",
				"value" => array(
					__('Vertical to bottom ↓', "cryption") => "to bottom",
					__('Vertical to top ↑', "cryption") => "to top",
					__('Horizontal to left  →', "cryption") => "to right",
					__('Horizontal to right ←', "cryption") => "to left",
					__('Diagonal from left to bottom ↘', "cryption") => "to bottom right",
					__('Diagonal from left to top ↗', "cryption") => "to top right",
					__('Diagonal from right to bottom ↙', "cryption") => "to bottom left",
					__('Diagonal from right to top ↖', "cryption") => "to top left",
					__('Custom', "cryption") => "cusotom_deg",

				) ,
				'dependency' => array(
					'element' => 'gradient_backgound_style',
					'value' => array(
						'linear',
					)
				)
			),
			array(
				"type" => "textfield",
				'heading' => __('Angle', 'cryption'),
				'param_name' => 'gradient_backgound_cusotom_deg',
				"edit_field_class" => "vc_col-sm-4 vc_column",
				'description' => __('Set value in DG 0-360', 'cryption'),
				'dependency' => array(
					'element' => 'gradient_backgound_angle',
					'value' => array(
						'cusotom_deg',
					)
				)
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Background Image', 'cryption'),
				'param_name' => 'content_background_image',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Background style', 'cryption'),
				'param_name' => 'content_background_style',
				'value' => array(
					esc_html__('Default', 'cryption') => '',
					esc_html__('Cover', 'cryption') => 'cover',
					esc_html__('Contain', 'cryption') => 'contain',
					esc_html__('No Repeat', 'cryption') => 'no-repeat',
					esc_html__('Repeat', 'cryption') => 'repeat'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Background horizontal position', 'cryption'),
				'param_name' => 'content_background_position_horizontal',
				'value' => array(
					esc_html__('Center', 'cryption') => 'center',
					esc_html__('Left', 'cryption') => 'left',
					esc_html__('Right', 'cryption') => 'right'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Background vertical position', 'cryption'),
				'param_name' => 'content_background_position_vertical',
				'value' => array(
					esc_html__('Top', 'cryption') => 'top',
					esc_html__('Center', 'cryption') => 'center',
					esc_html__('Bottom', 'cryption') => 'bottom'
				)
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Border Color', 'cryption'),
				'param_name' => 'border_color',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Border Width (px)', 'cryption'),
				'param_name' => 'border_width',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Border Radius (px)', 'cryption'),
				'param_name' => 'border_radius',
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__('Rectangle Corner', 'cryption'),
				'param_name' => 'rectangle_corner',
				'value' => array(
					esc_html__('Left Top', 'cryption') => 'lt',
					esc_html__('Right Top', 'cryption') => 'rt',
					esc_html__('Right Bottom', 'cryption') => 'rb',
					esc_html__('Left Bottom', 'cryption') => 'lb'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Top Area Style', 'cryption'),
				'param_name' => 'top_style',
				'value' => array(
					esc_html__('Default', 'cryption') => 'default',
					esc_html__('Flag', 'cryption') => 'flag',
					esc_html__('Shield', 'cryption') => 'shield',
					esc_html__('Ticket', 'cryption') => 'ticket',
					esc_html__('Sentence', 'cryption') => 'sentence',
					esc_html__('Note 1', 'cryption') => 'note-1',
					esc_html__('Note 2', 'cryption') => 'note-2',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Bottom Area Style', 'cryption'),
				'param_name' => 'bottom_style',
				'value' => array(
					esc_html__('Default', 'cryption') => 'default',
					esc_html__('Flag', 'cryption') => 'flag',
					esc_html__('Shield', 'cryption') => 'shield',
					esc_html__('Ticket', 'cryption') => 'ticket',
					esc_html__('Sentence', 'cryption') => 'sentence',
					esc_html__('Note 1', 'cryption') => 'note-1',
					esc_html__('Note 2', 'cryption') => 'note-2',
				),
			),

			array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Text', 'cryption'),
				'param_name' => 'button_1_text',
				'group' => esc_html__('Button 1', 'cryption'),
			),
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'URL (Link)', 'cryption' ),
				'param_name' => 'button_1_link',
				'description' => esc_html__( 'Add link to button.', 'cryption' ),
				'group' => esc_html__('Button 1', 'cryption')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Style', 'cryption'),
				'param_name' => 'button_1_style',
				'value' => array(esc_html__('Flat', 'cryption') => 'flat', esc_html__('Outline', 'cryption') => 'outline'),
				'group' => esc_html__('Button 1', 'cryption')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Size', 'cryption'),
				'param_name' => 'button_1_size',
				'value' => array(esc_html__('Tiny', 'cryption') => 'tiny', esc_html__('Small', 'cryption') => 'small', esc_html__('Medium', 'cryption') => 'medium', esc_html__('Large', 'cryption') => 'large', esc_html__('Giant', 'cryption') => 'giant'),
				'std' => 'small',
				'group' => esc_html__('Button 1', 'cryption')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Text weight', 'cryption'),
				'param_name' => 'button_1_text_weight',
				'value' => array(esc_html__('Normal', 'cryption') => 'normal', esc_html__('Thin', 'cryption') => 'thin'),
				'group' => esc_html__('Button 1', 'cryption')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Border radius', 'cryption'),
				'param_name' => 'button_1_corner',
				'value' => 3,
				'group' => esc_html__('Button 1', 'cryption')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Border width', 'cryption'),
				'param_name' => 'button_1_border',
				'value' => array(1, 2, 3, 4, 5, 6),
				'std' => 2,
				'dependency' => array(
					'element' => 'button_1_style',
					'value' => array('outline')
				),
				'group' => esc_html__('Button 1', 'cryption')
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Text color', 'cryption'),
				'param_name' => 'button_1_text_color',
				'group' => esc_html__('Button 1', 'cryption')
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Hover text color', 'cryption'),
				'param_name' => 'button_1_hover_text_color',
				'group' => esc_html__('Button 1', 'cryption')
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Background color', 'cryption'),
				'param_name' => 'button_1_background_color',
				'dependency' => array(
					'element' => 'button_1_style',
					'value' => array('flat')
				),
				'group' => esc_html__('Button 1', 'cryption')
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Hover background color', 'cryption'),
				'param_name' => 'button_1_hover_background_color',
				'group' => esc_html__('Button 1', 'cryption')
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Border color', 'cryption'),
				'param_name' => 'button_1_border_color',
				'dependency' => array(
					'element' => 'button_1_style',
					'value' => array('outline')
				),
				'group' => esc_html__('Button 1', 'cryption')
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Hover border color', 'cryption'),
				'param_name' => 'button_1_hover_border_color',
				'dependency' => array(
					'element' => 'button_1_style',
					'value' => array('outline')
				),
				'group' => esc_html__('Button 1', 'cryption')
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Use Gradient Backgound Colors', 'cryption'),
				'param_name' => 'button_1_gradient_backgound',
				'value' => array(__('Yes', 'cryption') => '1'),
				'group' => __('Button 1', 'cryption'),

			),
			array(
				'type' => 'colorpicker',
				'heading' => __('Background From', 'cryption'),
				"edit_field_class" => "vc_col-sm-5 vc_column",
				'group' => __('Button 1', 'cryption'),
				'param_name' => 'button_1_gradient_backgound_from',
				'dependency' => array(
					'element' => 'button_1_gradient_backgound',
					'value' => array('1')
				)
			),
			array(
				'type' => 'colorpicker',
				'heading' => __('Background To', 'cryption'),
				"edit_field_class" => "vc_col-sm-5 vc_column",
				'group' => __('Button 1', 'cryption'),
				'param_name' => 'button_1_gradient_backgound_to',
				'dependency' => array(
					'element' => 'button_1_gradient_backgound',
					'value' => array('1')
				)
			),
			array(
				'type' => 'colorpicker',
				'heading' => __('Hover Background From', 'cryption'),
				"edit_field_class" => "vc_col-sm-5 vc_column",
				'param_name' => 'button_1_gradient_backgound_hover_from',
				'group' => __('Button 1', 'cryption'),
				'dependency' => array(
					'element' => 'button_1_gradient_backgound',
					'value' => array('1')
				)
			),
			array(
				'type' => 'colorpicker',
				'heading' => __('Hover Background To', 'cryption'),
				"edit_field_class" => "vc_col-sm-5 vc_column",
				'param_name' => 'button_1_gradient_backgound_hover_to',
				'group' => __('Button 1', 'cryption'),
				'dependency' => array(
					'element' => 'button_1_gradient_backgound',
					'value' => array('1')
				)
			),
			array(
				"type" => "dropdown",
				'heading' => __('Style', 'cryption'),
				'param_name' => 'button_1_gradient_backgound_style',
				"edit_field_class" => "vc_col-sm-4 vc_column",
				'group' => __('Button 1', 'cryption'),
				"value" => array(
					__('Linear', "cryption") => "linear",
					__('Radial', "cryption") => "radial",
				) ,
				"std" => 'linear',
				'dependency' => array(
					'element' => 'button_1_gradient_backgound',
					'value' => array('1')
				)
			),
			array(
				"type" => "dropdown",
				'heading' => __('Gradient Position', 'cryption'),
				'param_name' => 'button_1_gradient_radial_backgound_position',
				"edit_field_class" => "vc_col-sm-4 vc_column",
				'group' => __('Button 1', 'cryption'),
				"value" => array(
					__('Top', "cryption") => "at top",
					__('Bottom', "cryption") => "at bottom",
					__('Right', "cryption") => "at right",
					__('Left', "cryption") => "at left",
					__('Center', "cryption") => "at center",

				) ,
				'dependency' => array(
					'element' => 'button_1_gradient_backgound_style',
					'value' => array(
						'radial',
					)
				)
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Swap Colors', 'cryption'),
				'param_name' => 'button_1_gradient_radial_swap_colors',
				"edit_field_class" => "vc_col-sm-4 vc_column",
				'group' => __('Button 1', 'cryption'),
				'value' => array(__('Yes', 'cryption') => '1'),
				'dependency' => array(
					'element' => 'button_1_gradient_backgound_style',
					'value' => array(
						'radial',
					)
				)
			),


			array(
				"type" => "dropdown",
				'heading' => __('Custom Angle', 'cryption'),
				'param_name' => 'button_1_gradient_backgound_angle',
				'group' => __('Button 1', 'cryption'),
				"edit_field_class" => "vc_col-sm-4 vc_column",
				"value" => array(
					__('Vertical to bottom ↓', "cryption") => "to bottom",
					__('Vertical to top ↑', "cryption") => "to top",
					__('Horizontal to left  →', "cryption") => "to right",
					__('Horizontal to right ←', "cryption") => "to left",
					__('Diagonal from left to bottom ↘', "cryption") => "to bottom right",
					__('Diagonal from left to top ↗', "cryption") => "to top right",
					__('Diagonal from right to bottom ↙', "cryption") => "to bottom left",
					__('Diagonal from right to top ↖', "cryption") => "to top left",
					__('Custom', "cryption") => "cusotom_deg",

				) ,
				'dependency' => array(
					'element' => 'button_1_gradient_backgound_style',
					'value' => array(
						'linear',
					)
				)
			),
			array(
				"type" => "textfield",
				'heading' => __('Angle', 'cryption'),
				'param_name' => 'button_1_gradient_backgound_cusotom_deg',
				'group' => __('Button 1', 'cryption'),
				"edit_field_class" => "vc_col-sm-4 vc_column",
				'description' => __('Set value in DG 0-360', 'cryption'),
				'dependency' => array(
					'element' => 'button_1_gradient_backgound_angle',
					'value' => array(
						'cusotom_deg',
					)
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Icon pack', 'cryption'),
				'param_name' => 'button_1_icon_pack',
				'value' => array_merge(array(esc_html__('Elegant', 'cryption') => 'elegant', esc_html__('Material Design', 'cryption') => 'material', esc_html__('FontAwesome', 'cryption') => 'fontawesome'), ct_userpack_to_dropdown()),
				'std' => 2,
				'group' => esc_html__('Button 1', 'cryption')
			),
			array(
				'type' => 'ct_icon',
				'heading' => esc_html__('Icon', 'cryption'),
				'param_name' => 'button_1_icon_elegant',
				'icon_pack' => 'elegant',
				'dependency' => array(
					'element' => 'button_1_icon_pack',
					'value' => array('elegant')
				),
				'group' => esc_html__('Button 1', 'cryption')
			),
			array(
				'type' => 'ct_icon',
				'heading' => esc_html__('Icon', 'cryption'),
				'param_name' => 'button_1_icon_material',
				'icon_pack' => 'material',
				'dependency' => array(
					'element' => 'button_1_icon_pack',
					'value' => array('material')
				),
				'group' => esc_html__('Button 1', 'cryption')
			),
			array(
				'type' => 'ct_icon',
				'heading' => esc_html__('Icon', 'cryption'),
				'param_name' => 'button_1_icon_fontawesome',
				'icon_pack' => 'fontawesome',
				'dependency' => array(
					'element' => 'button_1_icon_pack',
					'value' => array('fontawesome')
				),
				'group' => esc_html__('Button 1', 'cryption')
			),
		),
		ct_userpack_to_shortcode(array(
			array(
				'type' => 'ct_icon',
				'heading' => esc_html__('Icon', 'cryption'),
				'param_name' => 'button_1_icon_userpack',
				'icon_pack' => 'userpack',
				'dependency' => array(
					'element' => 'button_1_icon_pack',
					'value' => array('userpack')
				),
			),
		)),
		array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon position', 'cryption' ),
				'param_name' => 'button_1_icon_position',
				'value' => array(esc_html__( 'Left', 'cryption' ) => 'left', esc_html__( 'Right', 'cryption' ) => 'right'),
				'group' => esc_html__('Button 1', 'cryption')
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__('Activate Button', 'cryption'),
				'param_name' => 'button_2_activate',
				'value' => array(esc_html__('Yes', 'cryption') => '1'),
				'group' => esc_html__('Button 2', 'cryption')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Text', 'cryption'),
				'param_name' => 'button_2_text',
				'group' => esc_html__('Button 2', 'cryption'),
				'dependency' => array(
					'element' => 'button_2_activate',
					'not_empty' => true
				),
			),
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'URL (Link)', 'cryption' ),
				'param_name' => 'button_2_link',
				'description' => esc_html__( 'Add link to button.', 'cryption' ),
				'dependency' => array(
					'element' => 'button_2_activate',
					'not_empty' => true
				),
				'group' => esc_html__('Button 2', 'cryption')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Style', 'cryption'),
				'param_name' => 'button_2_style',
				'value' => array(esc_html__('Flat', 'cryption') => 'flat', esc_html__('Outline', 'cryption') => 'outline'),
				'dependency' => array(
					'element' => 'button_2_activate',
					'not_empty' => true
				),
				'group' => esc_html__('Button 2', 'cryption')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Size', 'cryption'),
				'param_name' => 'button_2_size',
				'value' => array(esc_html__('Tiny', 'cryption') => 'tiny', esc_html__('Small', 'cryption') => 'small', esc_html__('Medium', 'cryption') => 'medium', esc_html__('Large', 'cryption') => 'large', esc_html__('Giant', 'cryption') => 'giant'),
				'std' => 'small',
				'dependency' => array(
					'element' => 'button_2_activate',
					'not_empty' => true
				),
				'group' => esc_html__('Button 2', 'cryption')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Text weight', 'cryption'),
				'param_name' => 'button_2_text_weight',
				'value' => array(esc_html__('Normal', 'cryption') => 'normal', esc_html__('Thin', 'cryption') => 'thin'),
				'dependency' => array(
					'element' => 'button_2_activate',
					'not_empty' => true
				),
				'group' => esc_html__('Button 2', 'cryption')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Border radius', 'cryption'),
				'param_name' => 'button_2_corner',
				'value' => 3,
				'dependency' => array(
					'element' => 'button_2_activate',
					'not_empty' => true
				),
				'group' => esc_html__('Button 2', 'cryption')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Border width', 'cryption'),
				'param_name' => 'button_2_border',
				'value' => array(1, 2, 3, 4, 5, 6),
				'std' => 2,
				'dependency' => array(
					'element' => 'button_2_style',
					'value' => array('outline')
				),
				'group' => esc_html__('Button 2', 'cryption')
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Text color', 'cryption'),
				'param_name' => 'button_2_text_color',
				'dependency' => array(
					'element' => 'button_2_activate',
					'not_empty' => true
				),
				'group' => esc_html__('Button 2', 'cryption')
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Hover text color', 'cryption'),
				'param_name' => 'button_2_hover_text_color',
				'dependency' => array(
					'element' => 'button_2_activate',
					'not_empty' => true
				),
				'group' => esc_html__('Button 2', 'cryption')
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Background color', 'cryption'),
				'param_name' => 'button_2_background_color',
				'dependency' => array(
					'element' => 'button_2_style',
					'value' => array('flat')
				),
				'group' => esc_html__('Button 2', 'cryption')
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Hover background color', 'cryption'),
				'param_name' => 'button_2_hover_background_color',
				'dependency' => array(
					'element' => 'button_2_activate',
					'not_empty' => true
				),
				'group' => esc_html__('Button 2', 'cryption')
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Border color', 'cryption'),
				'param_name' => 'button_2_border_color',
				'dependency' => array(
					'element' => 'button_2_style',
					'value' => array('outline')
				),
				'group' => esc_html__('Button 2', 'cryption')
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Hover border color', 'cryption'),
				'param_name' => 'button_2_hover_border_color',
				'dependency' => array(
					'element' => 'button_2_style',
					'value' => array('outline')
				),
				'group' => esc_html__('Button 2', 'cryption')
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Use Gradient Backgound Colors', 'cryption'),
				'param_name' => 'button_2_gradient_backgound',
				'value' => array(__('Yes', 'cryption') => '1'),
				'group' => __('Button 2', 'cryption'),
				'dependency' => array(
					'element' => 'button_2_activate',
					'not_empty' => true
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __('Background From', 'cryption'),
				"edit_field_class" => "vc_col-sm-5 vc_column",
				'group' => __('Button 2', 'cryption'),
				'param_name' => 'button_2_gradient_backgound_from',
				'dependency' => array(
					'element' => 'button_2_gradient_backgound',
					'value' => array('1')
				)
			),
			array(
				'type' => 'colorpicker',
				'heading' => __('Background To', 'cryption'),
				"edit_field_class" => "vc_col-sm-5 vc_column",
				'group' => __('Button 2', 'cryption'),
				'param_name' => 'button_2_gradient_backgound_to',
				'dependency' => array(
					'element' => 'button_2_gradient_backgound',
					'value' => array('1')
				)
			),
			array(
				'type' => 'colorpicker',
				'heading' => __('Hover Background From', 'cryption'),
				"edit_field_class" => "vc_col-sm-5 vc_column",
				'param_name' => 'button_2_gradient_backgound_hover_from',
				'group' => __('Button 2', 'cryption'),
				'dependency' => array(
					'element' => 'button_2_gradient_backgound',
					'value' => array('1')
				)
			),
			array(
				'type' => 'colorpicker',
				'heading' => __('Hover Background To', 'cryption'),
				"edit_field_class" => "vc_col-sm-5 vc_column",
				'param_name' => 'button_2_gradient_backgound_hover_to',
				'group' => __('Button 2', 'cryption'),
				'dependency' => array(
					'element' => 'button_2_gradient_backgound',
					'value' => array('1')
				)
			),
			array(
				"type" => "dropdown",
				'heading' => __('Style', 'cryption'),
				'param_name' => 'button_2_gradient_backgound_style',
				"edit_field_class" => "vc_col-sm-4 vc_column",
				'group' => __('Button 2', 'cryption'),
				"value" => array(
					__('Linear', "cryption") => "linear",
					__('Radial', "cryption") => "radial",
				) ,
				"std" => 'linear',
				'dependency' => array(
					'element' => 'button_2_gradient_backgound',
					'value' => array('1')
				)
			),
			array(
				"type" => "dropdown",
				'heading' => __('Gradient Position', 'cryption'),
				'param_name' => 'button_2_gradient_radial_backgound_position',
				"edit_field_class" => "vc_col-sm-4 vc_column",
				'group' => __('Button 2', 'cryption'),
				"value" => array(
					__('Top', "cryption") => "at top",
					__('Bottom', "cryption") => "at bottom",
					__('Right', "cryption") => "at right",
					__('Left', "cryption") => "at left",
					__('Center', "cryption") => "at center",

				) ,
				'dependency' => array(
					'element' => 'button_2_gradient_backgound_style',
					'value' => array(
						'radial',
					)
				)
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Swap Colors', 'cryption'),
				'param_name' => 'button_2_gradient_radial_swap_colors',
				"edit_field_class" => "vc_col-sm-4 vc_column",
				'group' => __('Button 2', 'cryption'),
				'value' => array(__('Yes', 'cryption') => '1'),
				'dependency' => array(
					'element' => 'button_2_gradient_backgound_style',
					'value' => array(
						'radial',
					)
				)
			),
			array(
				"type" => "dropdown",
				'heading' => __('Custom Angle', 'cryption'),
				'param_name' => 'button_2_gradient_backgound_angle',
				'group' => __('Button 2', 'cryption'),
				"edit_field_class" => "vc_col-sm-4 vc_column",
				"value" => array(
					__('Vertical to bottom ↓', "cryption") => "to bottom",
					__('Vertical to top ↑', "cryption") => "to top",
					__('Horizontal to left  →', "cryption") => "to right",
					__('Horizontal to right ←', "cryption") => "to left",
					__('Diagonal from left to bottom ↘', "cryption") => "to bottom right",
					__('Diagonal from left to top ↗', "cryption") => "to top right",
					__('Diagonal from right to bottom ↙', "cryption") => "to bottom left",
					__('Diagonal from right to top ↖', "cryption") => "to top left",
					__('Custom', "cryption") => "cusotom_deg",

				) ,
				'dependency' => array(
					'element' => 'button_2_gradient_backgound_style',
					'value' => array(
						'linear',
					)
				)
			),
			array(
				"type" => "textfield",
				'heading' => __('Angle', 'cryption'),
				'param_name' => 'button_2_gradient_backgound_cusotom_deg',
				'group' => __('Button 2', 'cryption'),
				"edit_field_class" => "vc_col-sm-4 vc_column",
				'description' => __('Set value in DG 0-360', 'cryption'),
				'dependency' => array(
					'element' => 'button_2_gradient_backgound_angle',
					'value' => array(
						'cusotom_deg',
					)
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Icon pack', 'cryption'),
				'param_name' => 'button_2_icon_pack',
				'value' => array_merge(array(esc_html__('Elegant', 'cryption') => 'elegant', esc_html__('Material Design', 'cryption') => 'material', esc_html__('FontAwesome', 'cryption') => 'fontawesome'), ct_userpack_to_dropdown()),
				'std' => 2,
				'dependency' => array(
					'element' => 'button_2_activate',
					'not_empty' => true
				),
				'group' => esc_html__('Button 2', 'cryption')
			),
			array(
				'type' => 'ct_icon',
				'heading' => esc_html__('Icon', 'cryption'),
				'param_name' => 'button_2_icon_elegant',
				'icon_pack' => 'elegant',
				'dependency' => array(
					'element' => 'button_2_icon_pack',
					'value' => array('elegant')
				),
				'group' => esc_html__('Button 2', 'cryption')
			),
			array(
				'type' => 'ct_icon',
				'heading' => esc_html__('Icon', 'cryption'),
				'param_name' => 'button_2_icon_material',
				'icon_pack' => 'material',
				'dependency' => array(
					'element' => 'button_2_icon_pack',
					'value' => array('material')
				),
				'group' => esc_html__('Button 2', 'cryption')
			),
			array(
				'type' => 'ct_icon',
				'heading' => esc_html__('Icon', 'cryption'),
				'param_name' => 'button_2_icon_fontawesome',
				'icon_pack' => 'fontawesome',
				'dependency' => array(
					'element' => 'button_2_icon_pack',
					'value' => array('fontawesome')
				),
				'group' => esc_html__('Button 2', 'cryption')
			),
		),
		ct_userpack_to_shortcode(array(
			array(
				'type' => 'ct_icon',
				'heading' => esc_html__('Icon', 'cryption'),
				'param_name' => 'button_2_icon_userpack',
				'icon_pack' => 'userpack',
				'dependency' => array(
					'element' => 'button_2_icon_pack',
					'value' => array('userpack')
				),
			),
		)),
		array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon position', 'cryption' ),
				'param_name' => 'button_2_icon_position',
				'value' => array(esc_html__( 'Left', 'cryption' ) => 'left', esc_html__( 'Right', 'cryption' ) => 'right'),
				'dependency' => array(
					'element' => 'button_2_activate',
					'not_empty' => true
				),
				'group' => esc_html__('Button 2', 'cryption')
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__('Centered', 'cryption'),
				'param_name' => 'centered',
				'value' => array(esc_html__('Yes', 'cryption') => '1')
			),
		)
	);


	$shortcodes['ct_button']['params'] = array_merge(array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Button Text', 'cryption'),
			'param_name' => 'text',
		),
		array(
			'type' => 'vc_link',
			'heading' => esc_html__( 'URL (Link)', 'cryption' ),
			'param_name' => 'link',
			'description' => esc_html__( 'Add link to button.', 'cryption' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Position', 'cryption'),
			'param_name' => 'position',
			'value' => array(esc_html__('Inline', 'cryption') => 'inline', esc_html__('Left', 'cryption') => 'left', esc_html__('Right', 'cryption') => 'right', esc_html__('Center', 'cryption') => 'center', esc_html__('Fullwidth', 'cryption') => 'fullwidth')
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Style', 'cryption'),
			'param_name' => 'style',
			'value' => array(esc_html__('Flat', 'cryption') => 'flat', esc_html__('Outline', 'cryption') => 'outline')
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Size', 'cryption'),
			'param_name' => 'size',
			'value' => array(esc_html__('Tiny', 'cryption') => 'tiny', esc_html__('Small', 'cryption') => 'small', esc_html__('Medium', 'cryption') => 'medium', esc_html__('Large', 'cryption') => 'large', esc_html__('Giant', 'cryption') => 'giant'),
			'std' => 'small'
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Text weight', 'cryption'),
			'param_name' => 'text_weight',
			'value' => array(esc_html__('Normal', 'cryption') => 'normal', esc_html__('Thin', 'cryption') => 'thin'),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Border radius', 'cryption'),
			'param_name' => 'corner',
			'value' => 3,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Border width', 'cryption'),
			'param_name' => 'border',
			'value' => array(1, 2, 3, 4, 5, 6),
			'std' => 2,
			'dependency' => array(
				'element' => 'style',
				'value' => array('outline')
			),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Text color', 'cryption'),
			'param_name' => 'text_color',
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Hover text color', 'cryption'),
			'param_name' => 'hover_text_color',
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Background color', 'cryption'),
			'param_name' => 'background_color',
			'dependency' => array(
				'element' => 'style',
				'value' => array('flat')
			),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Hover background color', 'cryption'),
			'param_name' => 'hover_background_color',
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Border color', 'cryption'),
			'param_name' => 'border_color',
			'dependency' => array(
				'element' => 'style',
				'value' => array('outline')
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => __('Use Gradient Backgound Colors', 'cryption'),
			'param_name' => 'gradient_backgound',
			'value' => array(__('Yes', 'cryption') => '1')
		),

		array(
			'type' => 'colorpicker',
			'heading' => __('Background From', 'cryption'),
			"edit_field_class" => "vc_col-sm-5 vc_column",
			'param_name' => 'gradient_backgound_from',
			'dependency' => array(
				'element' => 'gradient_backgound',
				'value' => array('1')
			)
		),
		array(
			'type' => 'colorpicker',
			'heading' => __('Background To', 'cryption'),
			"edit_field_class" => "vc_col-sm-5 vc_column",
			'param_name' => 'gradient_backgound_to',
			'dependency' => array(
				'element' => 'gradient_backgound',
				'value' => array('1')
			)
		),
		array(
			'type' => 'colorpicker',
			'heading' => __('Hover Background From', 'cryption'),
			"edit_field_class" => "vc_col-sm-5 vc_column",
			'param_name' => 'gradient_backgound_hover_from',
			'dependency' => array(
				'element' => 'gradient_backgound',
				'value' => array('1')
			)
		),
		array(
			'type' => 'colorpicker',
			'heading' => __('Hover Background To', 'cryption'),
			"edit_field_class" => "vc_col-sm-5 vc_column",
			'param_name' => 'gradient_backgound_hover_to',
			'dependency' => array(
				'element' => 'gradient_backgound',
				'value' => array('1')
			)
		),
		array(
			"type" => "dropdown",
			'heading' => __('Style', 'cryption'),
			'param_name' => 'gradient_backgound_style',
			"edit_field_class" => "vc_col-sm-4 vc_column",
			"value" => array(
				__('Linear', "cryption") => "linear",
				__('Radial', "cryption") => "radial",
			) ,
			"std" => 'linear',
			'dependency' => array(
				'element' => 'gradient_backgound',
				'value' => array('1')
			)
		),
		array(
			"type" => "dropdown",
			'heading' => __('Gradient Position', 'cryption'),
			'param_name' => 'gradient_radial_backgound_position',
			"edit_field_class" => "vc_col-sm-4 vc_column",
			"value" => array(
				__('Top', "cryption") => "at top",
				__('Bottom', "cryption") => "at bottom",
				__('Right', "cryption") => "at right",
				__('Left', "cryption") => "at left",
				__('Center', "cryption") => "at center",

			) ,
			'dependency' => array(
				'element' => 'gradient_backgound_style',
				'value' => array(
					'radial',
				)
			)
		),
		array(
			'type' => 'checkbox',
			'heading' => __('Swap Colors', 'cryption'),
			'param_name' => 'gradient_radial_swap_colors',
			"edit_field_class" => "vc_col-sm-4 vc_column",
			'value' => array(__('Yes', 'cryption') => '1'),
			'dependency' => array(
				'element' => 'gradient_backgound_style',
				'value' => array(
					'radial',
				)
			)
		),


		array(
			"type" => "dropdown",
			'heading' => __('Custom Angle', 'cryption'),
			'param_name' => 'gradient_backgound_angle',
			"edit_field_class" => "vc_col-sm-4 vc_column",
			"value" => array(
				__('Vertical to bottom ↓', "cryption") => "to bottom",
				__('Vertical to top ↑', "cryption") => "to top",
				__('Horizontal to left  →', "cryption") => "to right",
				__('Horizontal to right ←', "cryption") => "to left",
				__('Diagonal from left to bottom ↘', "cryption") => "to bottom right",
				__('Diagonal from left to top ↗', "cryption") => "to top right",
				__('Diagonal from right to bottom ↙', "cryption") => "to bottom left",
				__('Diagonal from right to top ↖', "cryption") => "to top left",
				__('Custom', "cryption") => "cusotom_deg",

			) ,
			'dependency' => array(
				'element' => 'gradient_backgound_style',
				'value' => array(
					'linear',
				)
			)
		),
		array(
			"type" => "textfield",
			'heading' => __('Angle', 'cryption'),
			'param_name' => 'gradient_backgound_cusotom_deg',
			"edit_field_class" => "vc_col-sm-4 vc_column",
			'description' => __('Set value in DG 0-360', 'cryption'),
			'dependency' => array(
				'element' => 'gradient_backgound_angle',
				'value' => array(
					'cusotom_deg',
				)
			)
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Hover border color', 'cryption'),
			'param_name' => 'hover_border_color',
			'dependency' => array(
				'element' => 'style',
				'value' => array('outline')
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Separatot Style', 'cryption'),
			'param_name' => 'separator',
			'value' => array(
				esc_html__('None', 'cryption') => '',
				esc_html__('Single', 'cryption') => 'single',
				esc_html__('Square', 'cryption') => 'square',
				esc_html__('Soft Double', 'cryption') => 'soft-double',
				esc_html__('Strong Double', 'cryption') => 'strong-double'
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'cryption' ),
			'param_name' => 'extra_class',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Icon pack', 'cryption'),
			'param_name' => 'icon_pack',
			'value' => array_merge(array(esc_html__('Elegant', 'cryption') => 'elegant', esc_html__('Material Design', 'cryption') => 'material', esc_html__('FontAwesome', 'cryption') => 'fontawesome'), ct_userpack_to_dropdown()),
			'std' => 2,
		),
		array(
			'type' => 'ct_icon',
			'heading' => esc_html__('Icon', 'cryption'),
			'param_name' => 'icon_elegant',
			'icon_pack' => 'elegant',
			'dependency' => array(
				'element' => 'icon_pack',
				'value' => array('elegant')
			),
		),
		array(
			'type' => 'ct_icon',
			'heading' => esc_html__('Icon', 'cryption'),
			'param_name' => 'icon_material',
			'icon_pack' => 'material',
			'dependency' => array(
				'element' => 'icon_pack',
				'value' => array('material')
			),
		),
		array(
			'type' => 'ct_icon',
			'heading' => esc_html__('Icon', 'cryption'),
			'param_name' => 'icon_fontawesome',
			'icon_pack' => 'fontawesome',
			'dependency' => array(
				'element' => 'icon_pack',
				'value' => array('fontawesome')
			),
		),
	),
		ct_userpack_to_shortcode(array(
			array(
				'type' => 'ct_icon',
				'heading' => esc_html__('Icon', 'cryption'),
				'param_name' => 'icon_userpack',
				'icon_pack' => 'userpack',
				'dependency' => array(
					'element' => 'icon_pack',
					'value' => array('userpack')
				),
			),
		)),
		array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon position', 'cryption' ),
				'param_name' => 'icon_position',
				'value' => array(esc_html__( 'Left', 'cryption' ) => 'left', esc_html__( 'Right', 'cryption' ) => 'right'),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__('Lazy loading enabled', 'cryption'),
				'param_name' => 'effects_enabled',
				'value' => array(esc_html__('Yes', 'cryption') => '1')
			),
		)
	);


	$shortcodes['ct_gallery']['params'] = array_merge(array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Gallery', 'cryption'),
			'param_name' => 'gallery_gallery',
			'value' => ct_vc_get_galleries(),
			'save_always' => true,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Gallery Type', 'cryption'),
			'param_name' => 'gallery_type',
			'description' => esc_html__('Choose gallery type', 'cryption'),
			'value' => array(esc_html__('Slider', 'cryption') => 'slider', esc_html__('Grid', 'cryption') => 'grid')
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Layout', 'cryption'),
			'param_name' => 'gallery_slider_layout',
			'value' => array(esc_html__('fullwidth', 'cryption') => 'fullwidth', esc_html__('Sidebar', 'cryption') => 'sidebar'),
			'dependency' => array(
				'element' => 'gallery_type',
				'value' => array('slider')
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Disable thumbnails bar', 'cryption'),
			'param_name' => 'no_thumbs',
			'value' => array(esc_html__('Yes', 'cryption') => '1'),
			'dependency' => array(
				'element' => 'gallery_type',
				'value' => array('slider')
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Pagination', 'cryption'),
			'param_name' => 'pagination',
			'value' => array(esc_html__('Yes', 'cryption') => '1'),
			'dependency' => array(
				'element' => 'no_thumbs',
				'not_empty' => true
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Autoscroll', 'cryption'),
			'param_name' => 'autoscroll',
			'dependency' => array(
				'element' => 'gallery_type',
				'value' => array('slider')
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Layout', 'cryption'),
			'param_name' => 'gallery_layout',
			'description' => esc_html__('Choose gallery layout', 'cryption'),
			'value' => array(esc_html__('2x columns', 'cryption') => '2x', esc_html__('3x columns', 'cryption') => '3x', esc_html__('4x columns', 'cryption') => '4x', esc_html__('100% width', 'cryption') => '100%'),
			'dependency' => array(
				'element' => 'gallery_type',
				'value' => array('grid')
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Style', 'cryption'),
			'param_name' => 'gallery_style',
			'description' => esc_html__('Choose gallery style', 'cryption'),
			'value' => array(esc_html__('Justified Grid', 'cryption') => 'justified', esc_html__('Masonry Grid', 'cryption') => 'masonry', esc_html__('Metro Style', 'cryption') => 'metro'),
			'dependency' => array(
				'element' => 'gallery_type',
				'value' => array('grid')
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Columns 100% Width (1920x Screen)', 'cryption'),
			'param_name' => 'gallery_fullwidth_columns',
			'value' => array(esc_html__('4 Columns', 'cryption') => '4', esc_html__('5 Columns', 'cryption') => '5'),
			'dependency' => array(
				'element' => 'gallery_layout',
				'value' => array('100%')
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Gaps size (px)', 'cryption'),
			'param_name' => 'gaps_size',
			'dependency' => array(
				'element' => 'gallery_type',
				'value' => array('grid')
			),
			'std' => 42,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Hover Type', 'cryption'),
			'param_name' => 'gallery_hover',
			'value' => array(esc_html__('Green', 'cryption') => 'default', esc_html__('White', 'cryption') => 'zooming-blur', esc_html__('Dark', 'cryption') => 'circular')
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Border Style', 'cryption'),
			'param_name' => 'gallery_item_style',
			'value' => array(
				esc_html__('no border', 'cryption') => 'default',
				esc_html__('1px & border', 'cryption') => '1',
				esc_html__('16px & border', 'cryption') => '2',
				esc_html__('8px outlined border', 'cryption') => '3',
				esc_html__('20px outlined border', 'cryption') => '4',
				esc_html__('20px border with shadow', 'cryption') => '5',
				esc_html__('With shadow', 'cryption') => '6',
				esc_html__('20px border radius', 'cryption') => '7',
				esc_html__('55px border radius', 'cryption') => '8',
				esc_html__('Solid inside', 'cryption') => '9',
				esc_html__('Dashed outside', 'cryption') => '10',
				esc_html__('Rounded with border', 'cryption') => '11'
			),
			'dependency' => array(
				'element' => 'gallery_type',
				'value' => array('grid')
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Title', 'cryption'),
			'param_name' => 'gallery_title',
			'dependency' => array(
				'element' => 'gallery_type',
				'value' => array('grid')
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Loading animation', 'cryption'),
			'param_name' => 'loading_animation',
			'std' => 'move-up',
			'value' => array(esc_html__('Disabled', 'cryption') => 'disabled', esc_html__('Bounce', 'cryption') => 'bounce', esc_html__('Move Up', 'cryption') => 'move-up', esc_html__('Fade In', 'cryption') => 'fade-in', esc_html__('Fall Perspective', 'cryption') => 'fall-perspective', esc_html__('Scale', 'cryption') => 'scale', esc_html__('Flip', 'cryption') => 'flip'),
			'dependency' => array(
				'element' => 'gallery_type',
				'value' => array('grid')
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Max. row\'s height in grid (px)', 'cryption'),
			'param_name' => 'metro_max_row_height',
			'dependency' => array(
				'callback' => 'metro_max_row_height_callback'
			),
			'std' => 380,
		),
	));
	$shortcodes['ct_testimonials']['params'] = array_merge(array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Layout', 'cryption'),
			'param_name' => 'layout',
			'value' => array(
				esc_html__('Slider', 'cryption') => 'slider',
				esc_html__('Grid', 'cryption') => 'grid'
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Columns', 'cryption'),
			'param_name' => 'columns',
			'value' => array(1, 2, 3, 4),
			'dependency' => array(
				'element' => 'layout',
				'value' => array('grid')
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Testimonials Sets', 'cryption'),
			'param_name' => 'set',
			'value' => ct_vc_get_terms('ct_testimonials_sets'),
			'group' =>__('Select Testimonials Sets', 'cryption'),
			'edit_field_class' => 'ct-terms-checkboxes'
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Fullwidth', 'cryption'),
			'param_name' => 'fullwidth',
			'value' => array(esc_html__('Yes', 'cryption') => '1'),
			'dependency' => array(
				'element' => 'layout',
				'value' => array('slider')
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Style', 'cryption'),
			'param_name' => 'style',
			'value' => array(
				esc_html__('Style 1', 'cryption') => 'style1',
				esc_html__('Style 2', 'cryption') => 'style2'
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Autoscroll', 'cryption'),
			'param_name' => 'autoscroll',
			'dependency' => array(
				'element' => 'layout',
				'value' => array('slider')
			),
		),
	));

	$shortcodes['ct_news']['params'] = array_merge(array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Style', 'cryption'),
			'param_name' => 'style',
			'value' => array(
				esc_html__('Default', 'cryption') => 'default',
				esc_html__('Justified 3x', 'cryption') => 'justified-3x',
				esc_html__('Justified 4x', 'cryption') => 'justified-4x',
                esc_html__('Compact List', 'cryption') => 'compact',
                esc_html__('Slider', 'cryption') => 'slider',
			)
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Categories', 'cryption'),
			'param_name' => 'categories',
			'value' => ct_vc_get_blog_categories(),
			'group' =>__('Select Categories', 'cryption'),
			'edit_field_class' => 'ct-terms-checkboxes'
		),
        array(
            'type' => 'dropdown',
            'heading' => __('Slider Style', 'cryption'),
            'param_name' => 'slider_style',
            'value' => array(
                __('Fullwidth', 'cryption') => 'fullwidth',
                __('Halfwidth', 'cryption') => 'halfwidth',
            ),
            'dependency' => array(
                'element' => 'style',
                'value' => array('slider'),
            )
        ),
        array(
            'type' => 'textfield',
            'heading' => __('Autoscroll', 'cryption'),
            'param_name' => 'slider_autoscroll',
            'dependency' => array(
                'element' => 'style',
                'value' => array('slider'),
            )
        ),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Post per page', 'cryption'),
			'param_name' => 'post_per_page',
			'value' => '5'
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Pagination', 'cryption'),
			'param_name' => 'post_pagination',
			'value' => array(
				esc_html__('Normal', 'cryption') => 'normal',
				esc_html__('Load More', 'cryption') => 'more',
				esc_html__('Infinite Scroll', 'cryption') => 'scroll',
				esc_html__('Disable pagination', 'cryption') => 'disable',
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Loading animation', 'cryption'),
			'param_name' => 'loading_animation',
			'std' => 'move-up',
			'value' => array(esc_html__('Disabled', 'cryption') => 'disabled', esc_html__('Bounce', 'cryption') => 'bounce', esc_html__('Move Up', 'cryption') => 'move-up', esc_html__('Fade In', 'cryption') => 'fade-in', esc_html__('Fall Perspective', 'cryption') => 'fall-perspective', esc_html__('Scale', 'cryption') => 'scale', esc_html__('Flip', 'cryption') => 'flip'),
			'dependency' => array(
				'element' => 'style',
				'value' => array('default', 'timeline', 'timeline_new', '3x', '4x', '100%', 'justified-3x', 'justified-4x', 'styled_list1', 'styled_list2', 'multi-author', 'compact')
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Ignore Sticky Posts', 'cryption'),
			'param_name' => 'ignore_sticky',
			'value' => array(esc_html__('Yes', 'cryption') => '1')
		),
        array(
            'type' => 'checkbox',
            'heading' => __('Hide date in title', 'cryption'),
            'param_name' => 'hide_date',
            'value' => array(__('Yes', 'cryption') => '1'),
        ),
        array(
            'type' => 'checkbox',
            'heading' => __('Hide comments', 'cryption'),
            'param_name' => 'hide_comments',
            'value' => array(__('Yes', 'cryption') => '1')
        ),
        array(
            'type' => 'checkbox',
            'heading' => __('Hide likes', 'cryption'),
            'param_name' => 'hide_likes',
            'value' => array(__('Yes', 'cryption') => '1')
        ),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Hide author', 'cryption'),
			'param_name' => 'hide_author',
			'value' => array(esc_html__('Yes', 'cryption') => '1')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Button Text', 'cryption'),
			'param_name' => 'button_text',
			'group' => esc_html__('Load More Button', 'cryption'),
			'std' => esc_html__('Load More', 'cryption'),
			'dependency' => array(
				'element' => 'post_pagination',
				'value' => array('more')
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Style', 'cryption'),
			'param_name' => 'button_style',
			'value' => array(esc_html__('Flat', 'cryption') => 'flat', esc_html__('Outline', 'cryption') => 'outline'),
			'group' => esc_html__('Load More Button', 'cryption'),
			'dependency' => array(
				'element' => 'post_pagination',
				'value' => array('more')
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Size', 'cryption'),
			'param_name' => 'button_size',
			'value' => array(esc_html__('Tiny', 'cryption') => 'tiny', esc_html__('Small', 'cryption') => 'small', esc_html__('Medium', 'cryption') => 'medium', esc_html__('Large', 'cryption') => 'large', esc_html__('Giant', 'cryption') => 'giant'),
			'std' => 'medium',
			'group' => esc_html__('Load More Button', 'cryption'),
			'dependency' => array(
				'element' => 'post_pagination',
				'value' => array('more')
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Text weight', 'cryption'),
			'param_name' => 'button_text_weight',
			'value' => array(esc_html__('Normal', 'cryption') => 'normal', esc_html__('Thin', 'cryption') => 'thin'),
			'group' => esc_html__('Load More Button', 'cryption'),
			'dependency' => array(
				'element' => 'post_pagination',
				'value' => array('more')
			),
		),

		array(
			'type' => 'textfield',
			'heading' => esc_html__('Border radius', 'cryption'),
			'param_name' => 'button_corner',
			'std' => 25,
			'group' => esc_html__('Load More Button', 'cryption'),
			'dependency' => array(
				'element' => 'post_pagination',
				'value' => array('more')
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Border width', 'cryption'),
			'param_name' => 'button_border',
			'value' => array(1, 2, 3, 4, 5, 6),
			'std' => 2,
			'dependency' => array(
				'element' => 'button_style',
				'value' => array('outline')
			),
			'group' => esc_html__('Load More Button', 'cryption'),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Text color', 'cryption'),
			'param_name' => 'button_text_color',
			'group' => esc_html__('Load More Button', 'cryption'),
			'dependency' => array(
				'element' => 'post_pagination',
				'value' => array('more')
			),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Hover text color', 'cryption'),
			'param_name' => 'button_hover_text_color',
			'group' => esc_html__('Load More Button', 'cryption'),
			'dependency' => array(
				'element' => 'post_pagination',
				'value' => array('more')
			),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Background color', 'cryption'),
			'param_name' => 'button_background_color',
			'dependency' => array(
				'element' => 'button_style',
				'value' => array('flat')
			),
			'std' => '#e8668a',
			'group' => esc_html__('Load More Button', 'cryption'),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Hover background color', 'cryption'),
			'param_name' => 'button_hover_background_color',
			'group' => esc_html__('Load More Button', 'cryption'),
			'dependency' => array(
				'element' => 'post_pagination',
				'value' => array('more')
			),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Border color', 'cryption'),
			'param_name' => 'button_border_color',
			'dependency' => array(
				'element' => 'button_style',
				'value' => array('outline')
			),
			'group' => esc_html__('Load More Button', 'cryption'),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Hover border color', 'cryption'),
			'param_name' => 'button_hover_border_color',
			'dependency' => array(
				'element' => 'button_style',
				'value' => array('outline')
			),
			'group' => esc_html__('Load More Button', 'cryption'),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Icon pack', 'cryption'),
			'param_name' => 'button_icon_pack',
			'value' => array_merge(array(esc_html__('Elegant', 'cryption') => 'elegant', esc_html__('Material Design', 'cryption') => 'material', esc_html__('FontAwesome', 'cryption') => 'fontawesome'), ct_userpack_to_dropdown()),
			'std' => 2,
			'group' => esc_html__('Load More Button', 'cryption'),
			'dependency' => array(
				'element' => 'post_pagination',
				'value' => array('more')
			),
		),
		array(
			'type' => 'ct_icon',
			'heading' => esc_html__('Icon', 'cryption'),
			'param_name' => 'button_icon_elegant',
			'icon_pack' => 'elegant',
			'dependency' => array(
				'element' => 'button_icon_pack',
				'value' => array('elegant')
			),
			'group' => esc_html__('Load More Button', 'cryption'),
		),
		array(
			'type' => 'ct_icon',
			'heading' => esc_html__('Icon', 'cryption'),
			'param_name' => 'button_icon_material',
			'icon_pack' => 'material',
			'dependency' => array(
				'element' => 'button_icon_pack',
				'value' => array('material')
			),
			'group' => esc_html__('Load More Button', 'cryption'),
		),
		array(
			'type' => 'ct_icon',
			'heading' => esc_html__('Icon', 'cryption'),
			'param_name' => 'button_icon_fontawesome',
			'icon_pack' => 'fontawesome',
			'dependency' => array(
				'element' => 'button_icon_pack',
				'value' => array('fontawesome')
			),
			'group' => esc_html__('Load More Button', 'cryption'),
		),
	));

    $shortcodes['ct_quickfinder']['params'] = array_merge(array(

        array(
            'type' => 'dropdown',
            'heading' => __('Style', 'cryption'),
            'param_name' => 'style',
            'value' => array(
                __('Default Style', 'cryption') => 'default',
                __('Vertical Style 1', 'cryption') => 'vertical-1',
                __('Vertical Style 2', 'cryption') => 'vertical-3',
            )
        ),
        /*array(
            'type' => 'dropdown',
            'heading' => __('Number Of Columns', 'cryption'),
            'param_name' => 'columns',
            'value' => array(1, 2, 3, 4, 6),
            'std' => 3,
            'dependency' => array(
                'element' => 'style',
                'value' => array('classic', 'iconed', 'binded', 'binded-iconed', 'tag')
            ),
        ),*/
        /*array(
            'type' => 'dropdown',
            'heading' => __('Box Style', 'cryption'),
            'param_name' => 'box_style',
            'value' => array(
                __('Solid', 'cryption') => 'solid',
                __('Soft Outlined', 'cryption') => 'soft-outlined',
                __('Strong Outlined', 'cryption') => 'strong-outlined',
            ),
            'dependency' => array(
                'element' => 'style',
                'value' => array('classic', 'iconed', 'binded', 'binded-iconed', 'tag')
            ),
        ),*/
        /*array(
            'type' => 'colorpicker',
            'heading' => __('Box Background Color', 'cryption'),
            'param_name' => 'box_background_color',
            'dependency' => array(
                'element' => 'style',
                'value' => array('classic', 'iconed', 'binded', 'binded-iconed', 'tag')
            ),
        ),*/
        /*array(
            'type' => 'colorpicker',
            'heading' => __('Box Border Color', 'cryption'),
            'param_name' => 'box_border_color',
            'dependency' => array(
                'element' => 'box_style',
                'value' => array('soft-outlined', 'strong-outlined')
            ),
        ),*/
        array(
            'type' => 'dropdown',
            'heading' => __('Alignment', 'cryption'),
            'param_name' => 'alignment',
            'value' => array(
                __('Centered', 'cryption') => 'center',
                __('Left', 'cryption') => 'left',
                __('Right', 'cryption') => 'right',
            ),
            'dependency' => array(
                'element' => 'style',
                'value' => 'vertical-3'
            ),
        ),
        /*array(
            'type' => 'dropdown',
            'heading' => __('Icon Position', 'cryption'),
            'param_name' => 'icon_position',
            'value' => array(
                __('Top', 'cryption') => 'top',
                __('Bottom', 'cryption') => 'bottom',
                __('Top float', 'cryption') => 'top-float',
                __('Center float', 'cryption') => 'center-float',
            ),
            'dependency' => array(
                'element' => 'style',
                'value' => array('classic', 'iconed', 'binded', 'binded-iconed', 'tag')
            ),
        ),*/
        array(
            'type' => 'dropdown',
            'heading' => __('Title Weight', 'cryption'),
            'param_name' => 'title_weight',
            'value' => array(
                __('Bold', 'cryption') => 'bold',
                __('Thin', 'cryption') => 'thin',
            ),
        ),
        /*array(
            'type' => 'checkbox',
            'heading' => __('Activate Button', 'cryption'),
            'param_name' => 'activate_button',
            'value' => array(__('Yes', 'cryption') => '1'),
            'dependency' => array(
                'element' => 'style',
                'value' => array('classic', 'iconed', 'binded', 'binded-iconed', 'tag')
            ),
        ),*/
        /*array(
            'type' => 'dropdown',
            'heading' => __('Button Style', 'cryption'),
            'param_name' => 'button_style',
            'value' => array(__('Flat', 'cryption') => 'flat', __('Outline', 'cryption') => 'outline'),
            'dependency' => array(
                'element' => 'activate_button',
                'not_empty' => true
            ),
        ),*/
        /*array(
            'type' => 'dropdown',
            'heading' => __('Button Text weight', 'cryption'),
            'param_name' => 'button_text_weight',
            'value' => array(__('Normal', 'cryption') => 'normal', __('Thin', 'cryption') => 'thin'),
            'dependency' => array(
                'element' => 'activate_button',
                'not_empty' => true
            ),
        ),*/
       /* array(
            'type' => 'textfield',
            'heading' => __('Button Border radius', 'cryption'),
            'param_name' => 'button_corner',
            'value' => 3,
            'dependency' => array(
                'element' => 'activate_button',
                'not_empty' => true
            ),
        ),*/
        /*array(
            'type' => 'colorpicker',
            'heading' => __('Button Text color', 'cryption'),
            'param_name' => 'button_text_color',
            'dependency' => array(
                'element' => 'activate_button',
                'not_empty' => true
            ),
        ),*/
        /*array(
            'type' => 'colorpicker',
            'heading' => __('Button Background color', 'cryption'),
            'param_name' => 'button_background_color',
            'dependency' => array(
                'element' => 'button_style',
                'value' => array('flat')
            ),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __('Button Border color', 'cryption'),
            'param_name' => 'button_border_color',
            'dependency' => array(
                'element' => 'button_style',
                'value' => array('outline')
            ),
        ),*/
        array(
            'type' => 'colorpicker',
            'heading' => __('Hover Icon Color', 'cryption'),
            'param_name' => 'hover_icon_color',
            'group' => __('Hovers', 'cryption'),
        ),
       /* array(
            'type' => 'colorpicker',
            'heading' => __('Hover Box Color', 'cryption'),
            'param_name' => 'hover_box_color',
            'group' => __('Hovers', 'cryption'),
            'dependency' => array(
                'element' => 'style',
                'value' => array('classic', 'iconed', 'binded', 'binded-iconed', 'tag')
            ),
        ),*/
       /* array(
            'type' => 'colorpicker',
            'heading' => __('Hover Border Color', 'cryption'),
            'param_name' => 'hover_border_color',
            'group' => __('Hovers', 'cryption'),
            'dependency' => array(
                'element' => 'box_style',
                'value' => array('soft-outlined', 'strong-outlined')
            ),
        ),*/
        array(
            'type' => 'colorpicker',
            'heading' => __('Hover Title Color', 'cryption'),
            'param_name' => 'hover_title_color',
            'group' => __('Hovers', 'cryption'),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __('Hover Description Color', 'cryption'),
            'param_name' => 'hover_description_color',
            'group' => __('Hovers', 'cryption'),
        ),
        /*array(
            'type' => 'colorpicker',
            'heading' => __('Hover Button Text Color', 'cryption'),
            'param_name' => 'hover_button_text_color',
            'group' => __('Hovers', 'cryption'),
            'dependency' => array(
                'element' => 'activate_button',
                'not_empty' => true
            ),
        ),*/
        /*array(
            'type' => 'colorpicker',
            'heading' => __('Hover Button Background Color', 'cryption'),
            'param_name' => 'hover_button_background_color',
            'group' => __('Hovers', 'cryption'),
            'dependency' => array(
                'element' => 'activate_button',
                'not_empty' => true
            ),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __('Hover Button Border Color', 'cryption'),
            'param_name' => 'hover_button_border_color',
            'group' => __('Hovers', 'cryption'),
            'dependency' => array(
                'element' => 'button_style',
                'value' => array('outline')
            ),
        ),*/
        array(
            'type' => 'colorpicker',
            'heading' => __('Connector Color', 'cryption'),
            'param_name' => 'connector_color',
            'dependency' => array(
                'element' => 'style',
                'value' => array('vertical-1', 'vertical-2', 'vertical-3', 'vertical-4')
            ),
        ),
        array(
            'type' => 'checkbox',
            'heading' => __('Lazy loading enabled', 'cryption'),
            'param_name' => 'effects_enabled',
            'value' => array(__('Yes', 'cryption') => '1')
        ),
        array(
            'type' => 'checkbox',
            'heading' => __('Quickfinders', 'cryption'),
            'param_name' => 'quickfinders',
            'value' => ct_vc_get_terms('ct_quickfinders'),
            'group' => __('Select Quickfinders', 'cryption'),
            'edit_field_class' => 'ct-terms-checkboxes'
        ),
    ));

	$shortcodes['ct_counter_box']['params'] = array_merge(array(
        array(
            'type' => 'dropdown',
            'heading' => __('Style', 'cryption'),
            'param_name' => 'style',
            'value' => array(__('Style 1', 'cryption') => '1', __('Vertical', 'cryption') => 'vertical')
        ),
        array(
            'type' => 'dropdown',
            'heading' => __('Columns', 'cryption'),
            'param_name' => 'columns',
            'value' => array(1,2,3,4),
            'std' => 4,
            'dependency' => array(
                'element' => 'style',
                'value' => array('1', '2')
            ),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __('Connector color', 'cryption'),
            'param_name' => 'connector_color',
            'dependency' => array(
                'element' => 'style',
                'value' => array('vertical')
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __('Team Person', 'cryption'),
            'param_name' => 'team_person',
            'value' => ct_vc_get_team_persons(),
            'dependency' => array(
                'element' => 'style',
                'value' => array('vertical')
            ),
        ),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Lazy loading enabled', 'cryption'),
			'param_name' => 'effects_enabled',
			'value' => array(esc_html__('Yes', 'cryption') => '1')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Number format', 'cryption'),
			'param_name' => 'number_format',
			'std' => '(ddd).ddd',
			'description' => esc_html__('Example: (ddd).ddd -> 9999.99, ( ddd).ddd -> 9 999.99, (,ddd).ddd -> 9,999.99', 'cryption')
		),
	));

	$shortcodes['ct_diagram']['params'] = array_merge(array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__('title', 'cryption'),
			'param_name' => 'title',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('summary', 'cryption'),
			'param_name' => 'summary',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('type', 'cryption'),
			'param_name' => 'type',
			'value' => array(esc_html__('circle', 'cryption') => 'circle', esc_html__('line', 'cryption') => 'line')
		),
		array(
			'type' => 'textarea',
			'heading' => esc_html__('Content', 'cryption'),
			'param_name' => 'content',
			'value' => '[ct_skill title="Skill1" amount="70" color="#ff0000"]'."\n".
				'[ct_skill title="Skill2" amount="70" color="#ffff00"]'."\n".
				'[ct_skill title="Skill3" amount="70" color="#ff00ff"]'."\n".
				'[ct_skill title="Skill4" amount="70" color="#f0f0f0"]'
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Lazy loading enabled', 'cryption'),
			'param_name' => 'effects_enabled',
			'value' => array(esc_html__('Yes', 'cryption') => '1')
		),
        array(
            'type' => 'dropdown',
            'heading' => __('Style', 'cryption'),
            'param_name' => 'style',
            'value' => array(
                __('style-1', 'cryption') => 'style-1',
                __('style-2', 'cryption') => 'style-3'
            )
        ),
	));

	$shortcodes['ct_portfolio']['params'] = array_merge(array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Layout', 'cryption'),
			'param_name' => 'portfolio_layout',
			'value' => array(esc_html__('2x columns', 'cryption') => '2x', esc_html__('3x columns', 'cryption') => '3x', esc_html__('100% width', 'cryption') => '100%')
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Columns 100% Width (1920x Screen)', 'cryption'),
			'param_name' => 'portfolio_fullwidth_columns',
			'value' => array(esc_html__('4 Columns', 'cryption') => '4', esc_html__('5 Columns', 'cryption') => '5'),
			'dependency' => array(
				'element' => 'portfolio_layout',
				'value' => array('100%')
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Gaps Size', 'cryption'),
			'param_name' => 'portfolio_gaps_size',
			'std' => 42,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Display Titles', 'cryption'),
			'param_name' => 'portfolio_display_titles',
			'value' => array(esc_html__('On Page', 'cryption') => 'page', esc_html__('On Hover', 'cryption') => 'hover')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Items per page', 'cryption'),
			'param_name' => 'portfolio_items_per_page',
			'std' => '8'
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Show Date & Sets', 'cryption'),
			'param_name' => 'portfolio_show_info',
			'value' => array(esc_html__('Yes', 'cryption') => '1')
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Disable sharing buttons', 'cryption'),
			'param_name' => 'portfolio_disable_socials',
			'value' => array(esc_html__('Yes', 'cryption') => '1')
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Activate Filter', 'cryption'),
			'param_name' => 'portfolio_with_filter',
			'value' => array(esc_html__('Yes', 'cryption') => '1')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Title', 'cryption'),
			'param_name' => 'portfolio_title'
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Activate Sorting', 'cryption'),
			'param_name' => 'portfolio_sorting',
			'value' => array(esc_html__('Yes', 'cryption') => '1')
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Portfolios', 'cryption'),
			'param_name' => 'portfolios',
			'value' => ct_vc_get_terms('ct_portfolios'),
			'group' =>__('Select Portfolios', 'cryption'),
			'edit_field_class' => 'ct-terms-checkboxes'
		),
    ));

	$shortcodes['ct_portfolio_slider']['params'] = array_merge(array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Title', 'cryption'),
			'param_name' => 'portfolio_title',
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Portfolios', 'cryption'),
			'param_name' => 'portfolios',
			'value' => ct_vc_get_terms('ct_portfolios'),
			'group' =>__('Select Portfolios', 'cryption'),
			'edit_field_class' => 'ct-terms-checkboxes'
		),
		/*array(
			'type' => 'dropdown',
			'heading' => esc_html__('Layout', 'cryption'),
			'param_name' => 'portfolio_layout',
			'value' => array(esc_html__('3x columns', 'cryption') => '3x', esc_html__('100% width', 'cryption') => '100%')
		),*/
		/*array(
			'type' => 'dropdown',
			'heading' => esc_html__('Columns 100% Width (1920x Screen)', 'cryption'),
			'param_name' => 'portfolio_fullwidth_columns',
			'value' => array(esc_html__('3 Columns', 'cryption') => '3', esc_html__('4 Columns', 'cryption') => '4', esc_html__('5 Columns', 'cryption') => '5'),
			'std' => '4',
		),*/
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Gaps Size', 'cryption'),
			'param_name' => 'portfolio_gaps_size',
			'std' => 42,
		),
		/*array(
			'type' => 'dropdown',
			'heading' => esc_html__('Display Titles', 'cryption'),
			'param_name' => 'portfolio_display_titles',
			'value' => array(esc_html__('On Page', 'cryption') => 'page', esc_html__('On Hover', 'cryption') => 'hover')
		),*/
		/*array(
			'type' => 'dropdown',
			'heading' => esc_html__('Hover Type', 'cryption'),
			'param_name' => 'portfolio_hover',
			'value' => array(esc_html__('Grey', 'cryption') => 'default', esc_html__('Zooming White', 'cryption') => 'zooming-blur', esc_html__('Yellow', 'cryption') => 'vertical-sliding')
		),*/
		/*array(
			'type' => 'dropdown',
			'heading' => esc_html__('Background Style', 'cryption'),
			'param_name' => 'portfolio_background_style',
			'value' => array(esc_html__('White', 'cryption') => 'white', esc_html__('Grey', 'cryption') => 'gray', esc_html__('Dark', 'cryption') => 'dark'),
			'dependency' => array(
				'element' => 'portfolio_display_titles',
				'value' => array('page')
			),
		),*/
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Show Date & Sets', 'cryption'),
			'param_name' => 'portfolio_show_info',
			'value' => array(esc_html__('Yes', 'cryption') => '1')
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Disable sharing buttons', 'cryption'),
			'param_name' => 'portfolio_disable_socials',
			'value' => array(esc_html__('Yes', 'cryption') => '1')
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Lazy loading enabled', 'cryption'),
			'param_name' => 'effects_enabled',
			'value' => array(esc_html__('Yes', 'cryption') => '1')
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Activate Likes', 'cryption'),
			'param_name' => 'portfolio_likes',
			'value' => array(esc_html__('Yes', 'cryption') => '1')
		),
		/*array(
			'type' => 'dropdown',
			'heading' => esc_html__('Arrow', 'cryption'),
			'param_name' => 'portfolio_slider_arrow',
			'value' => array(esc_html__('Big', 'cryption') => 'portfolio_slider_arrow_big', esc_html__('Small', 'cryption') => 'portfolio_slider_arrow_small')
		),*/
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Autoscroll', 'cryption'),
			'param_name' => 'portfolio_autoscroll',
		),
	));

	$shortcodes['ct_pricing_table']['params'] = array_merge(array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Style', 'cryption'),
			'param_name' => 'style',
			'value' => array(esc_html__('Style 1', 'cryption') => '1', esc_html__('Style 2', 'cryption') => '5', esc_html__('Style 3', 'cryption') => '7')
		),
	));



	$shortcodes['ct_quote']['params'] = array_merge(array(
		array(
			'type' => 'textarea_html',
			'heading' => esc_html__('Content', 'cryption'),
			'param_name' => 'content',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Style', 'cryption'),
			'param_name' => 'style',
			'value' => array(
				esc_html__('Default', 'cryption') => 'default',
				esc_html__('Style 1', 'cryption') => '1',
			)
		),
	));

	$shortcodes['ct_team']['params'] = array_merge(array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Style', 'cryption'),
			'param_name' => 'style',
			'value' => array(
				esc_html__('Style 1', 'cryption') => '1',
				esc_html__('Style 2', 'cryption') => '2',
				esc_html__('Style 3', 'cryption') => '6',
			)
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Teams', 'cryption'),
			'param_name' => 'team',
			'value' => ct_vc_get_terms('ct_teams'),
			'group' =>__('Select Teams', 'cryption'),
			'edit_field_class' => 'ct-terms-checkboxes'
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Columns', 'cryption'),
			'param_name' => 'columns',
			'value' => array(1, 2, 3, 4),
			'std' => 3
		),
	));


	$shortcodes['ct_socials']['params'] = array_merge(array(
		array(
			'type' => 'dropdown',
			'heading' => __('Style', 'cryption'),
			'param_name' => 'style',
			'value' => array(
				__('Default', 'cryption') => 'default',
				__('Rounded', 'cryption') => 'rounded',
				__('Square', 'cryption') => 'square',
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => __('Icons color', 'cryption'),
			'param_name' => 'colored',
			'value' => array(
				__('Default', 'cryption') => 'default',
				__('Custom', 'cryption') => 'custom',
			)
		),
		array(
			'type' => 'colorpicker',
			'heading' => __('Custom color', 'cryption'),
			'param_name' => 'color',
			'dependency' => array(
				'element' => 'colored',
				'value' => 'custom'
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => __('Alignment', 'cryption'),
			'param_name' => 'alignment',
			'value' => array(
				__('Left', 'cryption') => 'left',
				__('Right', 'cryption') => 'right',
				__('Center', 'cryption') => 'center',
			)
		),
		array(
			'type' => 'textfield',
			'heading' => __('Icons size', 'cryption'),
			'param_name' => 'icons_size',
			'std' => 16
		),
		array(
			'type' => 'param_group',
			'heading' => __( 'Socials', 'cryption' ),
			'param_name' => 'socials',
			'value' => urlencode(json_encode(array(
				array(
					'social' => 'facebook',
					'url' => '#',
				),
				array(
					'social' => 'twitter',
					'url' => '#',
				),
				array(
					'social' => 'googleplus',
					'url' => '#',
				),
			))),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __( 'Social', 'cryption' ),
					'param_name' => 'social',
					'value' => array(
						__('Facebook', 'cryption') => 'facebook',
						__('Twitter', 'cryption') => 'twitter',
						__('Pinterest', 'cryption') => 'pinterest',
						__('Google Plus', 'cryption') => 'googleplus',
						__('Tumblr', 'cryption') => 'tumblr',
						__('StumbleUpon', 'cryption') => 'stumbleupon',
						__('Wordpress', 'cryption') => 'wordpress',
						__('Instagram', 'cryption') => 'instagram',
						__('Dribbble', 'cryption') => 'dribbble',
						__('Vimeo', 'cryption') => 'vimeo',
						__('Linkedin', 'cryption') => 'linkedin',
						__('RSS', 'cryption') => 'rss',
						__('DeviantArt', 'cryption') => 'deviantart',
						__('Share', 'cryption') => 'share',
						__('MySpace', 'cryption') => 'myspace',
						__('Skype', 'cryption') => 'skype',
						__('Youtube', 'cryption') => 'youtube',
						__('Picassa', 'cryption') => 'picassa',
						__('Google Drive', 'cryption') => 'googledrive',
						__('Flickr', 'cryption') => 'flickr',
						__('Blogger', 'cryption') => 'blogger',
						__('Spotify', 'cryption') => 'spotify',
						__('Delicious', 'cryption') => 'delicious',
						__('Telegram', 'cryption') => 'telegram',
						__('Medium', 'cryption') => 'medium',
						__('Reddit', 'cryption') => 'reddit',
						__('Slack', 'cryption') => 'slack',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Url', 'cryption'),
					'param_name' => 'url',
					'std' => '#'
				),
			)),
		),
	));



	return $shortcodes;
}

function cryption_change_ct_portfolio_slider_shortcode_output($atts) {
    extract(shortcode_atts(array(
        'portfolios' => '',
        'portfolio_title' => '',
        'portfolio_layout' => '3x',
        'portfolio_no_gaps' => '',
        'portfolio_display_titles' => 'hover',
        'portfolio_hover' => 'gradient',
        'portfolio_background_style' => 'white',
        'portfolio_show_info' => '',
        'portfolio_disable_socials' => '',
        'portfolio_fullwidth_columns' => '3',
        'effects_enabled' => false,
        'portfolio_likes' => false,
        'portfolio_gaps_size' => 42,
        'portfolio_slider_arrow' => 'portfolio_slider_arrow_big',
        'portfolio_autoscroll' => false,
    ), $atts, 'ct_portfolio_slider'));
    if(ct_is_plugin_active('js_composer/js_composer.php')) {
        global $vc_manager;
        if($vc_manager->mode() == 'admin_frontend_editor' || $vc_manager->mode() == 'admin_page' || $vc_manager->mode() == 'page_editable') {
            return '<div class="portfolio-slider-shortcode-dummy"></div>';
        }
    }
    ob_start();
    ct_portfolio_slider(array(
            'portfolio' => $portfolios,
            'title' => $portfolio_title,
            'layout' => $portfolio_layout,
            'no_gaps' => $portfolio_no_gaps,
            'display_titles' => $portfolio_display_titles,
            'hover' => $portfolio_hover,
            'background_style' => $portfolio_background_style,
            'show_info' => $portfolio_show_info,
            'disable_socials' => $portfolio_disable_socials,
            'fullwidth_columns' => $portfolio_fullwidth_columns,
            'effects_enabled' => $effects_enabled,
            'likes' => $portfolio_likes,
            'gaps_size' => $portfolio_gaps_size,
            'portfolio_arrow' => $portfolio_slider_arrow,
            'autoscroll' => $portfolio_autoscroll,
        )
    );
    $return_html = trim(preg_replace('/\s\s+/', ' ', ob_get_clean()));
    return $return_html;
}

function cryption_change_ct_portfolio_shortcode_output($atts) {
    extract(shortcode_atts(array(
        'portfolios' => '',
        'portfolio_layout' => '2x',
        'portfolio_style' => 'justified',
        'portfolio_layout_version' => 'fullwidth',
        'portfolio_caption_position' => 'right',
        'portfolio_gaps_size' => 42,
        'portfolio_display_titles' => 'page',
        'portfolio_background_style' => 'white',
        'portfolio_hover' => 'zooming-blur',
        'portfolio_pagination' => 'scroll',
        'loading_animation' => 'move-up',
        'portfolio_items_per_page' => 4,
        'portfolio_show_info' => '',
        'portfolio_with_filter' => '',
        'portfolio_title' => '',
        'portfolio_disable_socials' => '',
        'portfolio_fullwidth_columns' => '4',
        'portfolio_likes' => false,
        'portfolio_sorting' => false,
        'metro_max_row_height' => 380
    ), $atts, 'ct_portfolio'));
    if(cryption_is_plugin_active('js_composer/js_composer.php')) {
        global $vc_manager;
        if($vc_manager->mode() == 'admin_frontend_editor' || $vc_manager->mode() == 'admin_page' || $vc_manager->mode() == 'page_editable') {
            return '<div class="portfolio-shortcode-dummy"></div>';
        }
    }
    $button_params = array();
    foreach($atts as $key => $value) {
        if(substr($key, 0, 7) == 'button_') {
            $button_params[substr($key, 7)] = $value;
        }
    }
    ob_start();
    ct_portfolio(array(
        'portfolio' => $portfolios,
        'title' => $portfolio_title,
        'layout' => $portfolio_layout,
        'layout_version' => $portfolio_layout_version,
        'caption_position' => $portfolio_caption_position,
        'style' => $portfolio_style,
        'gaps_size' => $portfolio_gaps_size,
        'display_titles' => $portfolio_display_titles,
        'background_style' => $portfolio_background_style,
        'hover' => $portfolio_hover,
        'pagination' => $portfolio_pagination,
        'loading_animation' => $loading_animation,
        'items_per_page' => $portfolio_items_per_page,
        'with_filter' => $portfolio_with_filter,
        'show_info' => $portfolio_show_info,
        'disable_socials' => $portfolio_disable_socials,
        'fullwidth_columns' => $portfolio_fullwidth_columns,
        'likes' => $portfolio_likes,
        'sorting' => $portfolio_sorting,
        'button' => $button_params,
        'metro_max_row_height' => $metro_max_row_height
    ));
    $return_html = trim(preg_replace('/\s\s+/', ' ', ob_get_clean()));

    return $return_html;
}


function cryption_change_ct_counter_shortcode_output($atts) {
	extract(shortcode_atts(array(
		'from' => '0',
		'to' => '100',
		'text' => '',
		'icon_pack' => 'elegant',
		'icon_shape' => '',
		'icon_style' => '',
		'icon_elegant' => '',
		'icon_material' => '',
		'icon_fontawesome' => '',
		'icon_userpack' => '',
		'icon_color' => '',
		'icon_color_2' => '',
		'icon_background_color' => '',
		'icon_border_color' => '',
		'icon_size' => 'small',
		'icon_opacity' => '1',
		'background_color' => '',
		'numbers_color' => '',
		'text_color' => '',
		'suffix' => '',
		'use_style' =>'',
		'columns' => 4,
		'connector_color' => '',
		'link' => '',
		'hover_icon_color' => '',
		'hover_background_color' => '',
		'hover_numbers_color' => '',
		'hover_text_color' => '',
	), $atts, 'ct_counter'));

	if(cryption_is_plugin_active('js_composer/js_composer.php')) {
		global $vc_manager;
		if($vc_manager->mode() == 'admin_frontend_editor' || $vc_manager->mode() == 'admin_page' || $vc_manager->mode() == 'page_editable') {
			return '<div class="counter-shortcode-dummy"></div>';
		}
	}
	$return_html = '';
	$circle_border = '';

	$link = ( '||' === $link ) ? '' : $link;
	$link = vc_build_link( $link );
	$a_href = $link['url'];
	$a_title = $link['title'];
	$a_target = strlen( $link['target'] ) > 0 ? trim($link['target']) : '_self';

	$hover_data = '';
	$link_html = '';
	if($a_href) {
		$link_html = '<a class="ct-counter-link" href="'.esc_url($a_href).'"'.($a_title ? ' title="'.esc_attr($a_title).'"' : '').($a_target ? ' target="'.esc_attr($a_target).'"' : '').'></a>';
		if($hover_icon_color) {
			$hover_data .= ' data-hover-icon-color="'.esc_attr($hover_icon_color).'"';
		}
		if($hover_background_color) {
			$hover_data .= ' data-hover-background-color="'.esc_attr($hover_background_color).'"';
		}
		if($hover_numbers_color) {
			$hover_data .= ' data-hover-numbers-color="'.esc_attr($hover_numbers_color).'"';
		}
		if($hover_text_color) {
			$hover_data .= ' data-hover-text-color="'.esc_attr($hover_text_color).'"';
		}
	}

	$counter_effect = 'ct-counter-effect-';
	if(!empty($atts['icon_background_color'])) {
		$counter_effect .= 'background-reverse';
	} elseif(!empty($atts['icon_border_color'])) {
		$counter_effect .= 'border-reverse';
	} else {
		$counter_effect .= 'simple';
	}

	if(($icon_pack =='elegant' && $icon_elegant) || ($icon_pack =='material' && $icon_material) || ($icon_pack =='fontawesome' && $icon_fontawesome) || ($icon_pack =='userpack' && $icon_userpack)) {
		$icon_html = do_shortcode(ct_build_icon_shortcode($atts));
		$return_html .= '<div class="ct-counter-icon"><div class="ct-counter-icon-circle-1">'.$icon_html.'</div></div>';
	}
	$return_html .= '<div class="ct-counter-number"'.($numbers_color ? ' style="color: '.esc_attr($numbers_color).'"' : '').'><div class="ct-counter-odometer" data-to="'.esc_attr($to).'">'.$from.'</div>'.($suffix ? '<span class="ct-counter-suffix">'.$suffix.'</span>' : '').'</div>';
	if($text) {
		$return_html .= '<div class="ct-counter-sep default-sep"></div><div class="ct-counter-text styled-subtitle"'.($text_color ? ' style="color: '.esc_attr($text_color).'"' : '').'>'.$text.'</div>';
	}

	$counter_bottom = '';

    if($use_style == 'vertical') {
        $icon_size = ct_check_array_value(array('small', 'medium', 'large', 'xlarge'), $icon_size, 'small');
        return '<div class="ct-counter ct-counter-size-'.esc_attr($icon_size).' '.$counter_effect.'"'.$hover_data.'><div class="ct-counter-connector"'.($connector_color ? ' style="background-color: '.esc_attr($connector_color).'"' : '').'></div><div class="ct-counter-inner"'.($background_color ? ' style="background-color: '.esc_attr($background_color).'"' : '').'>'.$return_html.'</div>'.$link_html.'</div>';
    } else {
        $columns_class = 'col-md-3 col-sm-4 col-xs-6';
        if($columns == 1) {
            $columns_class = 'col-xs-12';
        } elseif($columns == 2) {
            $columns_class = 'col-sm-6 col-xs-12';
        } elseif($columns == 3) {
            $columns_class = 'col-md-4 col-sm-6 col-xs-12';
        }
        return '<div class="ct-counter '.$columns_class.' inline-column '.$counter_effect.'"'.$hover_data.'><div class="ct-counter-inner"'.($background_color ? ' style="background-color: '.esc_attr($background_color).'"' : '').'>'.$return_html.$counter_bottom.$link_html.'</div></div>';
    }
}

function cryption_change_ct_news_shortcode_output($atts) {
	extract(shortcode_atts(array(
		'post_types' => 'post',
		'color_style' => '',
		'slider_style' => '',
		'slider_autoscroll' => 0,
		'style' => '',
		'categories' => '',
		'post_per_page' => '',
		'post_pagination' => '',
		'ignore_sticky' => '',
		'effects_enabled' => 0,
		'hide_date' => 0,
		'hide_author' => 0,
		'hide_comments' => 0,
		'hide_likes' => 0,
		'loading_animation' => 'move-up',
	), $atts, 'ct_news'));

	$button_params = array();
	foreach((array)$atts as $key => $value) {
		if(substr($key, 0, 7) == 'button_') {
			$button_params[substr($key, 7)] = $value;
		}
	}

	ob_start();
	cryption_blog(array(
		'blog_post_types' => $post_types ? explode(',', $post_types) : array('post'),
		'blog_style' => $style,
		'color_style' => $color_style,
		'slider_style' => $slider_style,
		'slider_autoscroll' => $slider_autoscroll,
		'blog_categories' => $categories,
		'blog_post_per_page' => $post_per_page,
		'blog_pagination' => $post_pagination,
		'blog_ignore_sticky' => $ignore_sticky,
		'effects_enabled' => $effects_enabled,
		'hide_date' => $hide_date,
		'hide_author' => $hide_author,
		'hide_likes' => $hide_likes,
		'hide_comments' => $hide_comments,
		'loading_animation' => $loading_animation,
		'button' => $button_params
	));
	$return_html = trim(preg_replace('/\s\s+/', ' ', ob_get_clean()));
	return $return_html;
}

function cryption_portfolio_load_more_button_default_color_change($button) {
	$button['background_color'] = '#e8668a';
	return $button;
}
add_filter('ct_portfolio_load_more_button_defaults', 'cryption_portfolio_load_more_button_default_color_change');
