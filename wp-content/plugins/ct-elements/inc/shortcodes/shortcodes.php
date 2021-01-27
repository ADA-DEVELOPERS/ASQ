<?php

function ct_available_shortcodes() {
	$available_shortcodes = apply_filters('ct_available_shortcodes', array(
		'ct_fullwidth',
		'ct_custom_header',
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
		'ct_quickfinder',
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
		'ct_project_info',
		'ct_socials',
		'ct_search_form',
		'ct_countdown',
	));
	return $available_shortcodes;
}

function ct_shortcode_init() {
	foreach(ct_available_shortcodes() as $available_shortcode) {
		add_shortcode($available_shortcode, $available_shortcode.'_shortcode');
	}
}
add_action('init', 'ct_shortcode_init');

function ct_project_info_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'style' => '',
		'title' => '',
		'pack' => '',
		'decription' => '',
		'icon_color' => '',
		'icon_elegant' => '',
		'icon_material' => '',
		'icon_fontawesome' => '',
		'icon_userpack' => ''
	), $atts, 'ct_project_info'));
	$values = vc_param_group_parse_atts($atts['values']);
	$graph_lines_data = array();
	foreach ( $values as $data ) {
			$new_line['title'] = isset($data['title']) ? ($data['title']) : '';
			$new_line['decription'] = isset($data['decription']) ? ($data['decription']) : '';
			$new_line['pack'] = isset($data['pack']) ? ($data['pack']) : '';
			$new_line['icon_material'] = isset($data['icon_material']) ? ($data['icon_material']) : '';
			$new_line['icon_elegant'] = isset($data['icon_elegant']) ? ($data['icon_elegant']) : '';
			$new_line['icon_fontawesome'] = isset($data['icon_fontawesome']) ? ($data['icon_fontawesome']) : '';
			$new_line['icon_userpack'] = isset($data['icon_userpack']) ? ($data['icon_userpack']) : '';

		$new_line['icon_color'] = isset($data['icon_color']) ? ($data['icon_color']) : '';
			$graph_lines_data[] = $new_line;
		if ($new_line['pack'] == 'elegant') {wp_enqueue_style( 'icons-elegant');}
		if ($new_line['pack'] == 'material') {wp_enqueue_style( 'icons-material');}
		if ($new_line['pack'] == 'fontawesome') {wp_enqueue_style( 'icons-fontawesome');}
		if ($new_line['pack'] == 'userpack') {wp_enqueue_style( 'icons-userpack');}

	}



	$output = '';
	foreach ( $graph_lines_data as $line ) {
			$color= 'background-color:'.$line['icon_color'].'; color:'.$line['icon_color'].';';
			$output .=   '<div class="project-info-shortcode-item">';
			if ($line['pack'] == 'elegant') {$icon =  ($line['icon_elegant']);}
			elseif ($line['pack'] == 'material') {$icon =  ($line['icon_material']);}
			elseif ($line['pack'] == 'userpack') {$icon =  ($line['icon_userpack']);}
			else {$icon =  ($line['icon_fontawesome']);}
			$output .= '<div style="'.$color.'" class="icon ' .$line['pack'].'">&#x'.$icon.'</div>';
			$output .= '<div class="title">'. $line['title'] .'</div>';
			if (!empty($line['decription'])){
			$output .= '<div class="decription">' .$line['decription'].'</div>';
			}
			$output .= '</div>';
	}
	if ($style == 2) {
		$calsses = 'project-info-shortcode project-info-shortcode-style-2';
	}
	else {
		$calsses = 'project-info-shortcode project-info-shortcode-style-default';
	}

	$return_html = "<div class='$calsses'>" .$output. "</div>";
	return $return_html;
}


function ct_custom_header_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'background_image' => '',
		'background_style' => '',
		'ch_background_color' => '',
		'video_background_type' => '',
		'video_background_src' => '',
		'video_background_acpect_ratio' => '',
		'video_background_overlay_color' => '',
		'video_background_overlay_opacity' => '',
		'video_background_poster' => '',
		'container' => '',
		'icon' => '',
		'shape' => 'none',
		'style' => '',
		'color' => '',
		'color_2' => '',
		'background_color' => '',
		'border_color' => '',
		'size' => 'small',
		'centered' => '',
		'icon_position'=> 'ct-custom-header-icon-position-left',
		'subtitle' => '',
		'subtitle_width' => '900',
		'title_width' => '900',
		'subtitle_color' => '#4c5867',
		'opacity' => '1',
		'pack' => '',
		'icon_elegant' => '',
		'icon_material' => '',
		'icon_fontawesome' => '',
		'icon_userpack' => '',
		'breadcrumbs' => '',
		'breadcrumbs_color' => '',
		'padding_bottom' => '90',
		'padding_top' => '',
		'icon_top_margin' => '',
		'icon_bottom_margin' => '',
		'title_top_margin' => '',
		'centreed_breadcrumbs' =>  '',
		'title_bottom_margin' => '',

	), $atts, 'ct_custom_header'));

	$shape = ct_check_array_value(array('circle', 'square', 'romb', 'hexagon'), $shape, 'none');
	$style = ct_check_array_value(array('', 'angle-45deg-r', 'angle-45deg-l', 'angle-90deg'), $style, '');
	$size = ct_check_array_value(array('small', 'medium', 'large', 'xlarge'), $size, 'small');
	$css_style_icon = '';
	$css_style_icon_1 = '';
	$css_style_icon_2 = '';
	$title_styles ='';
	$css_style_icon_background = '';
	if($background_color) {
		$css_style_icon_background .= 'background-color: '.$background_color.';';
		if(!$border_color) {
			$css_style_icon .= 'border-color: '.$background_color.';';
		}
	}
	if($title_top_margin) {
		$title_styles .= 'margin-top:' .$title_top_margin. 'px;';
	}
	if($title_bottom_margin) {
		$title_styles .= 'margin-bottom:' .$title_bottom_margin. 'px;';
	}

	if($opacity) {
	$css_style_icon .= 'opacity:'.$opacity.';';
	}
	if($border_color) {
	$css_style_icon .= 'border-color: '.$border_color.';';
	}
	if($icon_top_margin) {
		$css_style_icon .= 'margin-top: '.$icon_top_margin.'px;';
	}
	if($icon_bottom_margin) {
		$css_style_icon .= 'margin-bottom: '.$icon_bottom_margin.'px;';
	}
	$simple_icon = '';
	if(!($background_color || $border_color)) {
	$simple_icon = ' ct-simple-icon';
	}
	if($color = $color) {
	$css_style_icon_1 = 'color: '.$color.';';
	if(($color_2 = $color_2) && $style) {
	$css_style_icon_2 = 'color: '.$color_2.';';
	}
	else {
	$css_style_icon_2 = 'color: '.$color.';';
	}
	}
	$css_style = '';
	if($background_image = ct_attachment_url($background_image)) {
	$css_style .= 'background-image: url('.$background_image.');';
	}
	if($ch_background_color) {
	$css_style .= 'background-color: '.$ch_background_color.';';
	}
	if($background_style == 'cover') {
	$css_style .= 'background-repeat: no-repeat; background-size: cover;';
	}
	if($background_style == 'contain') {
	$css_style .= 'background-repeat: no-repeat; background-size: contain;';
	}
	if($background_style == 'repeat') {
	$css_style .= 'background-repeat: repeat;';
	}
	if($padding_top) {
		$css_style .= 'padding-top: '.$padding_top.'px;';
	}

	if($background_style == 'no-repeat') {
	$css_style .= 'background-repeat: no-repeat;';
	}
	if($container == '') {
	$css_style .= 'padding-left: 21px; padding-right: 21px;';
	}
	if($pack =='elegant' && empty($icon) && $icon_elegant) {
		$icon = $icon_elegant;
	}
	if($pack =='material' && empty($icon) && $icon_material) {
		$icon = $icon_material;
	}
	if($pack =='fontawesome' && empty($icon) && $icon_fontawesome) {
		$icon = $icon_fontawesome;
	}
	if($pack =='userpack' && empty($icon) && $icon_userpack) {
		$icon = $icon_userpack;
	}
	wp_enqueue_style('icons-'.$pack);
	$custom_header_uid = uniqid();

	$html_js = '<script type="text/javascript">if (typeof(ct_fix_fullwidth_position) == "function") { ct_fix_fullwidth_position(document.getElementById("custom-header-' . $custom_header_uid . '")); }</script>';

	$video = ct_video_background($video_background_type, $video_background_src, $video_background_acpect_ratio, false, $video_background_overlay_color, $video_background_overlay_opacity, ct_attachment_url($video_background_poster));
		$return_html =
		'<div id="custom-header-' . $custom_header_uid . '" class="custom-header '.$icon_position.'  ' .($centreed_breadcrumbs ? 'centreed_breadcrumbs' : '') . ' fullwidth-block clearfix'.'" style="'.$css_style. '">'.$html_js.$video.($container ? '<div class="container">' : '').
				'<div class="ct-icon ct-icon-pack-'.$pack.' ct-icon-size-'.$size.' '.$style.' ct-icon-shape-'.$shape.$simple_icon.'" style="'.$css_style_icon.'">'.
					($shape == 'hexagon' ? '<div class="ct-icon-shape-hexagon-back"><div class="ct-icon-shape-hexagon-back-inner"><div class="ct-icon-shape-hexagon-back-inner-before" style="background-color: '.($border_color ? $border_color : $background_color).'"></div></div></div><div class="ct-icon-shape-hexagon-top"><div class="ct-icon-shape-hexagon-top-inner"><div class="ct-icon-shape-hexagon-top-inner-before" style="'.$css_style_icon_background.'"></div></div></div>' : '').
						'<div class="ct-icon-inner" style="'.$css_style_icon_background.'">'.
						($shape == 'romb' ? '<div class="romb-icon-conteiner">' : '').
						'<span class="ct-icon-half-1" style="'.$css_style_icon_1.'"><span class="back-angle">&#x'.$icon.';</span></span>'.
						'<span class="ct-icon-half-2" style="'.$css_style_icon_2.'"><span class="back-angle">&#x'.$icon.';</span></span>'.
						($shape == 'romb' ? '</div>' : '').
					'</div>'.
				'</div>
			<div class="ct-custom-header-conteiner">'.
			'<div style="'.$title_styles.'" class="custom-header-title"><span style=" max-width:'.$title_width.'px;">' .do_shortcode($content). '</span></div>'.
		'<div class="custom-header-subtitle styled-subtitle" style="padding-bottom:'.$padding_bottom.'px;"><span class="light" style="max-width:'.$subtitle_width.'px; color:'.$subtitle_color.'; ">'.$subtitle.'</span></div>';
			if($breadcrumbs) {
				ob_start();
					ct_breadcrumbs();
				$return_html .= ob_get_clean();
			}
		$return_html .=
		($container ? '</div>' : '').'</div></div>';

	return $return_html;
}



function ct_fullwidth_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'color' => '',
		'background_color' => '',
		'background_image' => '',
		'background_style' => '',
		'background_position_horizontal' => 'center',
		'background_position_vertical' => 'top',
		'background_parallax' => '',
		'background_parallax_mobile' => '',
		'background_parallax_type' => '',
		'background_parallax_overlay_color' => '',
		'video_background_type' => '',
		'video_background_src' => '',
		'video_background_acpect_ratio' => '16:9',
		'video_background_overlay_color' => '',
		'video_background_overlay_opacity' => '',
		'video_background_poster' => '',
		'padding_top' => '',
		'padding_bottom' => '',
		'padding_left' => '',
		'padding_right' => '',
		'container' => '',
		'styled_marker_top_style' => '',
		'styled_marker_top_direction' => 'inside',
		'styled_marker_bottom_style' => '',
		'styled_marker_bottom_direction' => 'inside',
		'z_index' => '',
		'gradient_backgound' => '',
		'gradient_backgound_from' => '#fff',
		'gradient_backgound_to' => '#000',
		'gradient_backgound_style' => 'linear',
		'gradient_backgound_angle' => 'to bottom',
		'gradient_backgound_cusotom_deg' => '180',
		'gradient_radial_backgound_position' => 'at top',
	), $atts, 'ct_fullwidth'));
	$styled_marker_top_style = ct_check_array_value(array('', 'triangle', 'figure', 'wave'), $styled_marker_top_style, '');
	$styled_marker_bottom_style = ct_check_array_value(array('', 'triangle', 'figure', 'wave'), $styled_marker_bottom_style, '');
	$styled_marker_top_direction = ct_check_array_value(array('inside', 'outside'), $styled_marker_top_direction, 'inside');
	$styled_marker_bottom_direction = ct_check_array_value(array('inside', 'outside'), $styled_marker_bottom_direction, 'inside');
	$background_parallax_type = ct_check_array_value(array('vertical', 'horizontal', 'fixed'), $background_parallax_type, 'vertical');
	$css_style = '';
	if($color) {
		$css_style .= 'color: '.$color.';';
	}
	if($background_color) {
		$css_style .= 'background-color: '.$background_color.';';
	}
	if ($gradient_backgound_angle == 'cusotom_deg') {
		$gradient_backgound_angle = $gradient_backgound_cusotom_deg.'deg';
	}
	if($gradient_backgound and $gradient_backgound_style == 'linear') {
		$css_style .= 'background: linear-gradient('.$gradient_backgound_angle.', '.$gradient_backgound_from.', '.$gradient_backgound_to.');';
	}
	if($gradient_backgound and $gradient_backgound_style == 'radial') {
		$css_style .= 'background: radial-gradient('.$gradient_radial_backgound_position.', '.$gradient_backgound_from.', '.$gradient_backgound_to.');';
	}
	$background_image_style = '';
	if($background_image = ct_attachment_url($background_image)) {
		$background_image_style .= 'background-image: url('.$background_image.');';

	if($background_style == 'cover') {
			$background_image_style .= 'background-repeat: no-repeat; background-size: cover;';
	}
	if($background_style == 'contain') {
			$background_image_style .= 'background-repeat: no-repeat; background-size: contain;';
	}
	if($background_style == 'repeat') {
			$background_image_style .= 'background-repeat: repeat;';
	}
	if($background_style == 'no-repeat') {
			$background_image_style .= 'background-repeat: no-repeat;';
	}
		$background_image_style .= 'background-position: '.$background_position_horizontal.' '.$background_position_vertical.';';
	}

	$video = ct_video_background($video_background_type, $video_background_src, $video_background_acpect_ratio, false, $video_background_overlay_color, $video_background_overlay_opacity, ct_attachment_url($video_background_poster));
	if($padding_top) {
		$css_style .= 'padding-top: '.$padding_top.'px;';
	}
	if($padding_bottom) {
		$css_style .= 'padding-bottom: '.$padding_bottom.'px;';
	}
	if($padding_left) {
		$css_style .= 'padding-left: '.$padding_left.'px;';
	}
	if($padding_right) {
		$css_style .= 'padding-right: '.$padding_right.'px;';
	}
	if(intval($z_index)) {
		$css_style .= 'z-index: '.$z_index.';';
	}
	$top_marker = '';
	$bottom_marker = '';
	if($styled_marker_top_style == 'triangle') {
		if($styled_marker_top_direction == 'inside') {
			$top_marker = '<div class="fullwidth-top-marker marker-direction-inside"><svg width="140" height="70"><path d="M 0,0 70,70 140,0" /></svg></div>';
		} elseif($styled_marker_top_direction == 'outside' && $background_color) {
			$top_marker = '<div class="fullwidth-top-marker marker-direction-outside"><svg width="140" height="70" style="fill: '.$background_color.'"><path d="M 0,71 70,0 140,71" /></svg></div>';
		}
	} elseif($styled_marker_top_style == 'figure') {
		if($styled_marker_top_direction == 'inside') {
			$top_marker = '<div class="fullwidth-top-marker marker-direction-inside"><svg width="140" height="70"><path d="M 0,0 Q 65,5 70,70 Q 75,5 140,0" /></svg></div>';
		} elseif($styled_marker_top_direction == 'outside' && $background_color) {
			$top_marker = '<div class="fullwidth-top-marker marker-direction-outside"><svg width="140" height="70" style="fill: '.$background_color.'"><path d="M 0,71 Q 65,65 70,0 Q 75,65 140,71" /></svg></div>';
		}
	} elseif($styled_marker_top_style == 'wave') {
		$pattern_id = 'pattern-'.time().'-'.rand(0, 100);
		$top_marker = '<div class="fullwidth-top-marker marker-wave"><svg width="100%" height="54" style="fill: '.$background_color.';"><defs><pattern id="'.$pattern_id.'-p" x="0" y="0" width="54" height="54" patternUnits="userSpaceOnUse" ><path d="M22.033,44.131c-0.26,0,0.015,0.016,0.065,0.023L22.033,44.131z M53.988,54V33.953c-1.703,0.01-3.555,0.287-5.598,0.916 c-6.479,1.994-14.029,14.057-26.286,9.287l-0.104,0.004v0.006c-7.734-2.945-12.697-10.543-21.99-10.193V54H53.988z" /></pattern><filter id="'.$pattern_id.'-f" x="0" y="0" width="100%" height="100%"><feOffset result="offOut" in="SourceGraphic" dx="0" dy="-4" /><feColorMatrix result="matrixOut" in="offOut" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0" /><feGaussianBlur result="blurOut" in="matrixOut" stdDeviation="0" /><feBlend in="SourceGraphic" in2="blurOut" mode="normal" /></filter></defs><rect x="0" y="0" width="100%" height="54" style="fill: url(#'.$pattern_id.'-p);" filter="url(#'.$pattern_id.'-f)" /></svg></div>';
	}
	if($styled_marker_bottom_style == 'triangle') {
		if($styled_marker_bottom_direction == 'inside') {
			$bottom_marker = '<div class="fullwidth-bottom-marker marker-direction-inside"><svg width="140" height="70"><path d="M 0,71 70,0 140,71" /></svg></div>';
		} elseif($styled_marker_bottom_direction == 'outside' && $background_color) {
			$bottom_marker = '<div class="fullwidth-bottom-marker marker-direction-outside"><svg width="140" height="70" style="fill: '.$background_color.'"><path d="M 0,0 70,70 140,0" /></svg></div>';
		}
	} elseif($styled_marker_bottom_style == 'figure') {
		if($styled_marker_bottom_direction == 'inside') {
			$bottom_marker= '<div class="fullwidth-bottom-marker marker-direction-inside"><svg width="140" height="70"><path d="M 0,71 Q 65,65 70,0 Q 75,65 140,71" /></svg></div>';
		} elseif($styled_marker_bottom_direction == 'outside' && $background_color) {
			$bottom_marker = '<div class="fullwidth-bottom-marker marker-direction-outside"><svg width="140" height="70" style="fill: '.$background_color.'"><path d="M 0,0 Q 65,5 70,70 Q 75,5 140,0" /></svg></div>';
		}
	} elseif($styled_marker_bottom_style == 'wave') {
		$pattern_id = 'pattern-'.time().'-'.rand(0, 100);
		$bottom_marker = '<div class="fullwidth-bottom-marker marker-wave"><svg width="100%" height="54" style="fill: '.$background_color.';"><defs><pattern id="'.$pattern_id.'-p" x="0" y="0" width="54" height="54" patternUnits="userSpaceOnUse" ><path d="M31.967,9.869c0.26,0-0.015-0.016-0.064-0.023L31.967,9.869z M0.011,0v20.047c1.704-0.01,3.555-0.287,5.598-0.915 c6.48-1.994,14.031-14.058,26.286-9.288l0.104-0.004V9.834c7.733,2.945,12.696,10.543,21.989,10.193V0H0.011z" /></pattern><filter id="'.$pattern_id.'-f" x="0" y="0" width="100%" height="100%"><feOffset result="offOut" in="SourceGraphic" dx="0" dy="4" /><feColorMatrix result="matrixOut" in="offOut" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0" /><feGaussianBlur result="blurOut" in="matrixOut" stdDeviation="0" /><feBlend in="SourceGraphic" in2="blurOut" mode="normal" /></filter></defs><rect x="0" y="0" width="100%" height="54" style="fill: url(#'.$pattern_id.'-p);"  filter="url(#'.$pattern_id.'-f)" /></svg></div>';
	}

	if ($background_parallax && in_array($background_parallax_type, array('vertical', 'horizontal'))) {
		wp_enqueue_script('ct-parallax-' . $background_parallax_type);
	}

	$fullwidth_uid = uniqid();

	$html_js = '<script type="text/javascript">if (typeof(ct_fix_fullwidth_position) == "function") { ct_fix_fullwidth_position(document.getElementById("fullwidth-block-' . $fullwidth_uid . '")); }</script>';

	$return_html = '<div id="fullwidth-block-' . $fullwidth_uid . '" class="fullwidth-block' . ($background_parallax ? ' fullwidth-block-parallax-' . $background_parallax_type : '') . ' clearfix" ' . ($background_parallax ? 'data-mobile-parallax-enable="' . ($background_parallax_mobile ? '1' : '0') . '"' : '') . ' style="'.$css_style.'">' .$html_js. ($background_image_style != '' ? '<div class="fullwidth-block-background" style="'.$background_image_style.'"></div>' : '') . ($background_parallax && $background_parallax_overlay_color ? '<div class="fullwidth-block-parallax-overlay" style="background-color: ' . $background_parallax_overlay_color . ';"></div>' : '') .$video. '<div class="fullwidth-block-inner">'.($container ? '<div class="container">' : '').do_shortcode($content).($container ? '</div>' : '').'</div>'.$bottom_marker.'</div>';
	return $return_html;
}

function ct_divider_shortcode($atts) {
	extract(shortcode_atts(array(
		'style' => '',
		'color' => '',
		'margin_top' => '',
		'margin_bottom' => '',
		'fullwidth' => '',
		'class_name' => '',
		'width' => ''
	), $atts, 'ct_divider'));
	$css_style = '';
	if($margin_top) {
		$css_style .= 'margin-top: '.$margin_top.'px;';
	}
	if($margin_bottom) {
		$css_style .= 'margin-bottom: '.$margin_bottom.'px;';
	}
	if($color) {
		$css_style .= 'border-color: '.$color.';';
	}
	if(intval($width) > 0) {
		$css_style .= 'width: '.intval($width).'px;';
	}
	$svg = '';
	if($style == 1) {
		$svg = '<svg width="100%" height="1px"><line x1="0" x2="100%" y1="0" y2="0" stroke="'.$color.'" stroke-width="2" stroke-linecap="black" stroke-dasharray="4, 4"/></svg>';
	}
	if($style == 4) {
		$svg = '<svg width="100%" height="8px"><line x1="4" x2="100%" y1="4" y2="4" stroke="'.$color.'" stroke-width="6" stroke-linecap="round" stroke-dasharray="1, 13"/></svg>';
	}
	if($style == 5) {
		$svg = '<svg width="100%" height="6px"><line x1="3" x2="100%" y1="3" y2="3" stroke="'.$color.'" stroke-width="6" stroke-linecap="square" stroke-dasharray="9, 13"/></svg>';
	}
	$return_html = '<div class="clearboth"></div><div class="ct-divider '.($class_name ? $class_name : '') .  ($style ? ' ct-divider-style-'.$style : '').($fullwidth ? ' fullwidth-block' : '').'" style="'.$css_style.'">'.$svg.'</div>';
	return $return_html;
}

function ct_image_shortcode($atts) {
	extract(shortcode_atts(array(
		'width' => '',
		'height' => '',
		'src' => '',
		'alt' => '',
		'style' => 'default',
		'position' => 'left',
		'disable_lightbox'=>'',
		'effects_enabled' => false
	), $atts, 'ct_image'));
	$css_style = '';
	$classes = $style;
	if(substr($width, -1) != "%") {
		$width = intval($width).'px';
	}
	if(substr($height, -1) != "%") {
		$height = intval($height).'px';
	}
	if($width && $width > 0) {
		$css_style .= 'width: '.$width.';';
	}
	if($height && $height > 0) {
		$css_style .= 'height: '.$height.';';
	}
	if($style == '11') {
		$height = $width;
	}
	$return_html = '<div class="ct-image ct-wrapbox ct-wrapbox-style-'.$classes.($position ? ' ct-wrapbox-position-'.$position : '') . ($effects_enabled ? ' lazy-loading' : '') .'" style="'.$css_style.'">'.
		'<div class="ct-wrapbox-inner ' . ($effects_enabled ? ' lazy-loading-item' : '') . '" ' . ($effects_enabled ? ' data-ll-effect="move-up"' : '') . '>'.
		($style == '12' ? '<div class="shadow-wrap">' : '').
		(!$disable_lightbox ? '<a href="'.ct_attachment_url($src).'" class="fancybox">' : '').
		'<img class="ct-wrapbox-element img-responsive'.($style == '11' ? ' img-circle' : '').'" src="'.ct_attachment_url($src).'" alt="'.$alt.'"/>'.
		(!$disable_lightbox ? '</a>' : '').
		($style == '12' ? '</div>' : '').
		'</div>'.
		'</div>';
	if($position == 'centered') {
		$return_html = '<div class="centered-box ct-image-centered-box">'.$return_html.'</div>';
	}
	return $return_html;
}

function ct_youtube_shortcode($atts) {
	extract(shortcode_atts(array(
		'width' => '100%',
		'height' => '300',
		'video_id' => '',
		'style' => 'no-style',
		'position' => 'below',
		'aspect_ratio' => ''
	), $atts, 'ct_youtube'));
	$css_style = '';
	$classes = $style;
	if($style != 11 && $style != 12) {
		$classes .= ' rounded-corners';
	}
	if(in_array($style, array(1, 5, 7))) {
		$classes .= ' shadow-box';
	}
	if(substr($width, -1) != "%") {
		$width = intval($width).'px';
	}
	if(substr($height, -1) != "%") {
		$height = intval($height).'px';
	}
	if($width && $width > 0) {
		$css_style .= 'width: '.$width.';';
	}
	$ratio_style = '';
	if($aspect_percents = ct_aspect_ratio_to_percents($aspect_ratio)) {
		$ratio_style = 'padding-top: '.$aspect_percents.'%';
	} else {
		if($height && $height > 0) {
			$css_style .= 'height: '.$height.';';
		}
	}
	$return_html = '<div class="ct-youtube ct-wrapbox ct-wrapbox-style-'.$classes.($position ? ' ct-wrapbox-position-'.$position : '').'" style="'.$css_style.'">'.
		'<div class="ct-wrapbox-inner'.($ratio_style ? ' ct-ratio-style' : '').'"'.($ratio_style ? ' style="'.$ratio_style.'"' : '').'>'.
		($style == '12' ? '<div class="shadow-wrap">' : '').
		'<iframe class="ct-wrapbox-element img-responsive" width="'.$width.'" height="'.intval($height).'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="//www.youtube.com/embed/'.$video_id.'?rel=0&amp;wmode=opaque"></iframe>'.
		($style == '12' ? '</div>' : '').
		'</div>'.
		'</div>';
	return $return_html;
}

function ct_vimeo_shortcode($atts) {
	extract(shortcode_atts(array(
		'width' => '100%',
		'height' => '300',
		'video_id' => '',
		'style' => 'no-style',
		'position' => 'below',
		'aspect_ratio' => ''
	), $atts, 'ct_vimeo'));
	$css_style = '';
	$classes = $style;
	if($style != 11 && $style != 12) {
		$classes .= ' rounded-corners';
	}
	if(in_array($style, array(1, 5, 7))) {
		$classes .= ' shadow-box';
	}
	if(substr($width, -1) != "%") {
		$width = intval($width).'px';
	}
	if(substr($height, -1) != "%") {
		$height = intval($height).'px';
	}
	if($width && $width > 0) {
		$css_style .= 'width: '.$width.';';
	}
	$ratio_style = '';
	if($aspect_percents = ct_aspect_ratio_to_percents($aspect_ratio)) {
		$ratio_style = 'padding-top: '.$aspect_percents.'%';
	} else {
		if($height && $height > 0) {
			$css_style .= 'height: '.$height.';';
		}
	}
	$return_html = '<div class="ct-vimeo ct-wrapbox ct-wrapbox-style-'.$classes.($position ? ' ct-wrapbox-position-'.$position : '').'" style="'.$css_style.'">'.
		'<div class="ct-wrapbox-inner'.($ratio_style ? ' ct-ratio-style' : '').'"'.($ratio_style ? ' style="'.$ratio_style.'"' : '').'>'.
		($style == '12' ? '<div class="shadow-wrap">' : '').
		'<iframe class="ct-wrapbox-element img-responsive" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="//player.vimeo.com/video/'.$video_id.'?title=0&amp;byline=0&amp;portrait=0"></iframe>'.
		($style == '12' ? '</div>' : '').
		'</div>'.
		'</div>';
	return $return_html;
}

function ct_video_shortcode($atts) {
	extract(shortcode_atts(array(
		'width' => '100%',
		'height' => '300',
		'video_src' => '',
		'image_src' => '',
		'style' => 'no-style',
		'position' => 'below',
		'aspect_ratio' => ''
	), $atts, 'ct_video'));
	$css_style = '';
	$classes = $style;
	if($style != 11 && $style != 12) {
		$classes .= ' rounded-corners';
	}
	if(in_array($style, array(1, 5, 7))) {
		$classes .= ' shadow-box';
	}
	if(substr($width, -1) != "%") {
		$width = intval($width).'px';
	}
	if(substr($height, -1) != "%") {
		$height = intval($height).'px';
	}
	if($width && $width > 0) {
		$css_style .= 'width: '.$width.';';
	}
	$ratio_style = '';
	if($aspect_percents = ct_aspect_ratio_to_percents($aspect_ratio)) {
		$ratio_style = 'padding-top: '.$aspect_percents.'%';
	} else {
		if($height && $height > 0) {
			$css_style .= 'height: '.$height.';';
		}
	}
	$image_src = ct_attachment_url($image_src);
	wp_enqueue_style('wp-mediaelement');
	wp_enqueue_script('ct-mediaelement');
	$return_html = '<div class="ct-video ct-wrapbox ct-wrapbox-style-'.$classes.($position ? ' ct-wrapbox-position-'.$position : '').'" style="'.$css_style.'">'.
		'<div class="ct-wrapbox-inner video-block'.($ratio_style ? ' ct-ratio-style' : '').'"'.($ratio_style ? ' style="'.$ratio_style.'"' : '').'>'.
		($style == '12' ? '<div class="shadow-wrap video-block">' : '').
		'<video style="width: 100%; height: 100%;" controls="controls" src="'.$video_src.'" '.($image_src ? ' poster="'.$image_src.'"' : '').' preload="none"></video>'.
		($style == '12' ? '</div>' : '').
		'</div>'.
		'</div>';
	return $return_html;
}

function ct_textbox_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'style' => 'default',
		'content_text_color' => '',
		'content_background_color' => '#f4f6f7',
		'content_background_image' => '',
		'content_background_style' => '',
		'content_background_position_horizontal' => 'center',
		'content_background_position_vertical' => 'top',
		'padding_top' => '',
		'padding_bottom' => '',
		'padding_left' => '',
		'padding_right' => '',
		'border_width' => '0',
		'border_color' => '',
		'border_radius' => '0',
		'rectangle_corner' => '',
		'top_style' => 'default',
		'bottom_style' => 'default',
		'icon_pack' => 'elegant',
		'icon_shape' => 'square',
		'icon_style' => '',
		'icon_elegant' => '',
		'icon_material' => '',
		'icon_fontawesome' => '',
		'icon_userpack' => '',
		'icon_border_css' =>'',
		'icon_color' => '',
		'icon_color_2' => '',
		'icon_background_color' => '',
		'icon_border_color' => '',
		'icon_size' => 'small',
		'icon_opacity' => '1',
		'title_content' => '',
		'title_text_color' => '',
		'title_background_color' => '',
		'title_padding_top' => '',
		'title_padding_bottom' => '',
		'picture' => '',
		'picture_position' => 'top',
		'disable_lightbox' => false,
		'centered' => '',
		'effects_enabled' => false,
		'gradient_backgound' => '',
		'gradient_backgound_from' => '#fff',
		'gradient_backgound_to' => '#000',
		'gradient_backgound_style' => 'linear',
		'gradient_backgound_angle' => 'to bottom',
		'gradient_backgound_cusotom_deg' => '180',
		'gradient_radial_backgound_position' => 'at top',
	), $atts, 'ct_textbox'));
	$return_html = '';
	$title_html = '';
	$content_html = '';
	$top_html = '';
	$bottom_html = '';
	$css_style = '';
	$css_content_style = '';
	$css_main_style = '';
	$rectangle_corner = explode(',', $rectangle_corner);
	$border_radius = intval($border_radius);
	$border_width = intval($border_width);
	$svg_top_color = '';
	$svg_bottom_color = '';

	if($style == 'title') {
		$css_title_style = '';
		if($title_text_color) {
			$css_title_style .= 'color: '.$title_text_color.';';
		}
		if($title_background_color) {
			$css_title_style .= 'background-color: '.$title_background_color.';';
			$svg_top_color = $title_background_color;
		}
		if(intval($title_padding_top) >= 0 && $title_padding_top !== '') {
			$css_title_style .= 'padding-top: '.intval($title_padding_top).'px;';
		}
		if(intval($title_padding_bottom) >= 0 && $title_padding_bottom !== '') {
			$css_title_style .= 'padding-bottom: '.intval($title_padding_bottom).'px;';
		}
		if(intval($padding_left) >= 0 && $padding_left !== '') {
			$css_title_style .= 'padding-left: '.intval($padding_left).'px;';
		}
		if(intval($padding_right) >= 0 && $padding_right !== '') {
			$css_title_style .= 'padding-right: '.intval($padding_right).'px;';
		}
		$title_html .= '<div class="ct-textbox-title" style="'.$css_title_style.'">';
		if(($icon_pack =='elegant' && $icon_elegant) || ($icon_pack =='material' && $icon_material) || ($icon_pack =='fontawesome' && $icon_fontawesome) || ($icon_pack =='userpack' && $icon_userpack)) {
			$title_html .= '<div class="ct-textbox-title-icon">'.do_shortcode(ct_build_icon_shortcode($atts)).'</div>';
		}
		if($title_content) {
			$title_html .= '<div class="ct-textbox-title-text">'.(rawurldecode(base64_decode($title_content))).'</div>';
		}
		$title_html .= '</div>';
	}
	if($style == 'picturebox' && $picture) {
		$title_html .= '<div class="ct-textbox-picture centered-box">';
		if($disable_lightbox) {
			$title_html .= '<img src="'.ct_attachment_url($picture).'" alt="#" class="img-responsive" />';
		} else {
			$title_html .= '<a href="'.ct_attachment_url($picture).'" class="fancy"><img src="'.ct_attachment_url($picture).'" alt="#" class="img-responsive" /></a>';
		}
		$title_html .= '</div>';
	}
	if($style == 'iconedbox') {
		$icon_sizes = array(
			'small' => 50,
			'medium' => 80,
			'large' => 160,
			'xlarge' => 240,
		);
		$bw = 0;
		$borders_style_l = '';
		$borders_style_r = '';
		$borders_style_r = '';
		$icon_border_style = '';
		$css_iconbox_style = '';
		if(intval($border_width) > 0 && $border_color) {
			$bw = intval($border_width);
			$borders_style_l .= 'border-top: '.$border_width.'px solid '.$border_color.';';
			$borders_style_r .= 'border-top: '.$border_width.'px solid '.$border_color.';';
			$borders_style_l .= 'margin-right: '.(intval(($icon_sizes[$icon_size])/2+15-$bw)).'px;';
			$borders_style_r .= 'margin-left: '.(intval(($icon_sizes[$icon_size])/2+15-$bw)).'px;';
			$icon_border_css = 'border: '.$border_width.'px solid '.$border_color.';';
			$css_iconbox_style = 'margin-bottom: -'.(intval(($icon_sizes[$icon_size] +15+$bw)/2)).'px;';
		}
		$css_title_style = '';
		$css_title_title_style = '';
		if($title_text_color) {
			$css_title_style .= 'color: '.$title_text_color.';';
		}
		$title_icon_css = '';
		if($title_background_color) {
			$css_title_style .= 'background-color: '.$title_background_color.';';
			$svg_top_color = $title_background_color;
			$title_icon_css = 'background-color: '.$title_background_color.';';
		}
		if(intval($title_padding_top) >= 0 && $title_padding_top !== '') {
			$css_title_title_style .= 'padding-top: '.intval($title_padding_top).'px;';
		}
		if(intval($title_padding_bottom) >= 0 && $title_padding_bottom !== '') {
			$css_title_style .= 'padding-bottom: '.intval($title_padding_bottom).'px;';
		}
		if(intval($padding_left) >= 0 && $padding_left !== '') {
			$css_title_style .= 'padding-left: '.intval($padding_left).'px;';
		}
		if(intval($padding_right) >= 0 && $padding_right !== '') {
			$css_title_style .= 'padding-right: '.intval($padding_right).'px;';
		}
		$title_html .= '<div class="ct-textbox-title ct-textbox-iconed centered-box" style="'.$css_title_style.'">';
		$title_html .= '<div class="ct-textbox-title-iconbox" style="'.$css_iconbox_style.'"><div class="ct-textbox-title-left-border"><div class="ct-textbox-title-left-border-inner" style="'.$borders_style_l.'"></div></div>';
		if(($icon_pack =='elegant' && $icon_elegant) || ($icon_pack =='material' && $icon_material) || ($icon_pack =='fontawesome' && $icon_fontawesome) || ($icon_pack =='userpack' && $icon_userpack)) {
			$title_html .= '<div class="ct-textbox-title-icon" style="'.$title_icon_css.'"><div class="ct-textbox-title-icon-border-wrapper"><div class="ct-textbox-title-icon-border" style="'.$icon_border_css.'"></div></div>'.do_shortcode(ct_build_icon_shortcode($atts)).'</div>';
		}
		$title_html .= '<div class="ct-textbox-title-right-border"><div class="ct-textbox-title-right-border-inner" style="'.$borders_style_r.'"></div></div></div>';
		if($title_content) {
			$title_html .= '<div class="ct-textbox-title-text" style="'.$css_title_title_style.'">'.(rawurldecode(base64_decode($title_content))).'</div>';
		}
		$title_html .= '</div>';
		$css_main_style = 'padding-top: '.(intval(($icon_sizes[$icon_size] +15+$bw)/2)).'px;';
	}

	if($content_text_color) {
		$css_content_style .= 'color: '.$content_text_color.';';
	}
	if($content_background_color) {
		$css_content_style .= 'background-color: '.$content_background_color.';';
		$svg_top_color = $svg_top_color ? $svg_top_color : $content_background_color;
		$svg_bottom_color = $content_background_color;
	}
	if ($gradient_backgound_angle == 'cusotom_deg') {
		$gradient_backgound_angle = $gradient_backgound_cusotom_deg.'deg';
	}
	if($gradient_backgound and $gradient_backgound_style == 'linear') {
		$css_content_style .= 'background: linear-gradient('.$gradient_backgound_angle.', '.$gradient_backgound_from.', '.$gradient_backgound_to.');';
	}
	if($gradient_backgound and $gradient_backgound_style == 'radial') {
		$css_content_style .= 'background: radial-gradient('.$gradient_radial_backgound_position.', '.$gradient_backgound_from.', '.$gradient_backgound_to.');';
	}


	if($content_background_image = ct_attachment_url($content_background_image)) {
		$css_content_style .= 'background-image: url('.$content_background_image.');';
	}
	if($content_background_style == 'cover') {
		$css_content_style .= 'background-repeat: no-repeat; background-size: cover;';
	}
	if($content_background_style == 'contain') {
		$css_content_style .= 'background-repeat: no-repeat; background-size: contain;';
	}
	if($content_background_style == 'repeat') {
		$css_content_style .= 'background-repeat: repeat;';
	}
	if($content_background_style == 'no-repeat') {
		$css_content_style .= 'background-repeat: no-repeat;';
	}
	$css_content_style .= 'background-position: '.$content_background_position_horizontal.' '.$content_background_position_vertical.';';

	if(intval($padding_top) >= 0 && $padding_top !== '') {
		$css_content_style .= 'padding-top: '.intval($padding_top).'px;';
	}
	if(intval($padding_bottom) >= 0 && $padding_bottom !== '') {
		$css_content_style .= 'padding-bottom: '.intval($padding_bottom).'px;';
	}
	if(intval($padding_left) >= 0 && $padding_left !== '') {
		$css_content_style .= 'padding-left: '.intval($padding_left).'px;';
	}
	if(intval($padding_right) >= 0 && $padding_right !== '') {
		$css_content_style .= 'padding-right: '.intval($padding_right).'px;';
	}

	$content_html .= '<div class="ct-textbox-content" style="'.$css_content_style.'">'.do_shortcode($content).'</div>';

	if($border_width && $border_color) {
		$css_style .= 'border: '.$border_width.'px solid '.$border_color.';';
		if($style == 'iconedbox') {
			$css_style .= 'border-top: 0 none;';
		}
		$svg_top_color = $border_color;
		$svg_bottom_color = $border_color;
	}

	if($top_style == 'flag') {
		$rectangle_corner = array_merge($rectangle_corner, array('lt', 'rt'));
		$top_html = '<div class="ct-textbox-top ct-textbox-top-flag"><svg viewBox="0 0 1000 20" preserveAspectRatio="none" width="100%" height="20" style="fill: '.$svg_top_color.';"><path d="M 0,20.5 0,0 500,20.5 1000,0 1000,20.5" /></svg></div>';
	}
	if($top_style == 'shield') {
		$rectangle_corner = array_merge($rectangle_corner, array('lt', 'rt'));
		$top_html = '<div class="ct-textbox-top ct-textbox-top-shield"><svg viewBox="0 0 1000 50" preserveAspectRatio="none" width="100%" height="50" style="fill: '.$svg_top_color.';"><path d="M 0,50.5 500,0 1000,50.5" /></svg></div>';
	}
	if($top_style == 'ticket') {
		$rectangle_corner = array_merge($rectangle_corner, array('lt', 'rt'));
		$pattern_id = 'pattern-'.time().'-'.rand(0, 100);
		$top_html = '<div class="ct-textbox-top ct-textbox-top-ticket"><svg width="100%" height="14" style="fill: '.$svg_top_color.';"><defs><pattern id="'.$pattern_id.'" x="16" y="0" width="32" height="16" patternUnits="userSpaceOnUse" ><path d="M 0,14.5 16,-0.5 32,14.5" /></pattern></defs><rect x="0" y="0" width="100%" height="14" style="fill: url(#'.$pattern_id.');" /></svg></div>';
	}
	if($top_style == 'sentence') {
		$top_html = '<div class="ct-textbox-top ct-textbox-top-sentence"><svg width="100" height="50" style="fill: '.$svg_top_color.';"><path d="M 0,51 Q 45,45 50,0 Q 55,45 100,51" /></svg></div>';
	}
	if($top_style == 'note-1') {
		$rectangle_corner = array_merge($rectangle_corner, array('lt', 'rt'));
		$pattern_id = 'pattern-'.time().'-'.rand(0, 100);
		$top_html = '<div class="ct-textbox-top ct-textbox-top-note-1"><svg width="100%" height="31" style="fill: '.$svg_top_color.';"><defs><pattern id="'.$pattern_id.'" x="11" y="0" width="23" height="32" patternUnits="userSpaceOnUse" ><path d="M20,9h3V0H0v9h3c2.209,0,4,1.791,4,4v6c0,2.209-1.791,4-4,4H0v9h23v-9h-3c-2.209,0-4-1.791-4-4v-6C16,10.791,17.791,9,20,9z" /></pattern></defs><rect x="0" y="0" width="100%" height="32" style="fill: url(#'.$pattern_id.');" /></svg></div>';
	}
	if($top_style == 'note-2') {
		$rectangle_corner = array_merge($rectangle_corner, array('lt', 'rt'));
		$pattern_id = 'pattern-'.time().'-'.rand(0, 100);
		$top_html = '<div class="ct-textbox-top ct-textbox-top-note-1"><svg width="100%" height="27" style="fill: '.$svg_top_color.';"><defs><pattern id="'.$pattern_id.'" x="10" y="0" width="20" height="28" patternUnits="userSpaceOnUse" ><path d="M20,8V0H0v8c3.314,0,6,2.687,6,6c0,3.313-2.686,6-6,6v8h20v-8c-3.313,0-6-2.687-6-6C14,10.687,16.687,8,20,8z" /></pattern></defs><rect x="0" y="0" width="100%" height="28" style="fill: url(#'.$pattern_id.');" /></svg></div>';
	}
	if($bottom_style == 'flag') {
		$rectangle_corner = array_merge($rectangle_corner, array('lb', 'rb'));
		$bottom_html = '<div class="ct-textbox-bottom ct-textbox-bottom-flag"><svg viewBox="0 0 1000 20" preserveAspectRatio="none" width="100%" height="20" style="fill: '.$svg_bottom_color.';"><path d="M 0,-0.5 0,20 500,0 1000,20 1000,-0.5" /></svg></div>';
	}
	if($bottom_style == 'shield') {
		$rectangle_corner = array_merge($rectangle_corner, array('lb', 'rb'));
		$bottom_html = '<div class="ct-textbox-bottom ct-textbox-bottom-shield"><svg viewBox="0 0 1000 50" preserveAspectRatio="none" width="100%" height="50" style="fill: '.$svg_bottom_color.';"><path d="M 0,-0.5 500,50 1000,-0.5" /></svg></div>';
	}
	if($bottom_style == 'ticket') {
		$rectangle_corner = array_merge($rectangle_corner, array('lb', 'rb'));
		$pattern_id = 'pattern-'.time().'-'.rand(0, 100);
		$bottom_html = '<div class="ct-textbox-bottom ct-textbox-bottom-ticket"><svg width="100%" height="14" style="fill: '.$svg_bottom_color.';"><defs><pattern id="'.$pattern_id.'" x="16" y="-1" width="32" height="16" patternUnits="userSpaceOnUse" ><path d="M 0,-0.5 16,14.5 32,-0.5" /></pattern></defs><rect x="0" y="-1" width="100%" height="14" style="fill: url(#'.$pattern_id.');" /></svg></div>';
	}
	if($bottom_style == 'sentence') {
		$bottom_html = '<div class="ct-textbox-bottom ct-textbox-bottom-sentence"><svg width="100" height="50" style="fill: '.$svg_bottom_color.';"><path d="M 0,-1 Q 45,5 50,50 Q 55,5 100,-1" /></svg></div>';
	}
	if($bottom_style == 'note-1') {
		$rectangle_corner = array_merge($rectangle_corner, array('lb', 'rb'));
		$pattern_id = 'pattern-'.time().'-'.rand(0, 100);
		$bottom_html = '<div class="ct-textbox-bottom ct-textbox-bottom-note-1"><svg width="100%" height="32" style="fill: '.$svg_bottom_color.';"><defs><pattern id="'.$pattern_id.'" x="11" y="-1" width="23" height="32" patternUnits="userSpaceOnUse" ><path d="M20,9h3V0H0v9h3c2.209,0,4,1.791,4,4v6c0,2.209-1.791,4-4,4H0v9h23v-9h-3c-2.209,0-4-1.791-4-4v-6C16,10.791,17.791,9,20,9z" /></pattern></defs><rect x="0" y="-1" width="100%" height="32" style="fill: url(#'.$pattern_id.');" /></svg></div>';
	}
	if($bottom_style == 'note-2') {
		$rectangle_corner = array_merge($rectangle_corner, array('lb', 'rb'));
		$pattern_id = 'pattern-'.time().'-'.rand(0, 100);
		$bottom_html = '<div class="ct-textbox-bottom ct-textbox-bottom-note-2"><svg width="100%" height="28" style="fill: '.$svg_bottom_color.';"><defs><pattern id="'.$pattern_id.'" x="10" y="-1" width="20" height="28" patternUnits="userSpaceOnUse" ><path d="M20,8V0H0v8c3.314,0,6,2.687,6,6c0,3.313-2.686,6-6,6v8h20v-8c-3.313,0-6-2.687-6-6C14,10.687,16.687,8,20,8z" /></pattern></defs><rect x="0" y="-1" width="100%" height="28" style="fill: url(#'.$pattern_id.');" /></svg></div>';
	}

	if($border_radius) {
		if(!in_array('lt', $rectangle_corner)) {
			$css_style .= 'border-top-left-radius: '.$border_radius.'px;';
		}
		if(!in_array('rt', $rectangle_corner)) {
			$css_style .= 'border-top-right-radius: '.$border_radius.'px;';
		}
		if(!in_array('rb', $rectangle_corner)) {
			$css_style .= 'border-bottom-right-radius: '.$border_radius.'px;';
		}
		if(!in_array('lb', $rectangle_corner)) {
			$css_style .= 'border-bottom-left-radius: '.$border_radius.'px;';
		}
	}

	if($style == 'picturebox' && $picture) {
		if($picture_position == 'top') {
			$return_html = ($effects_enabled ? '<div class="lazy-loading" data-ll-item-delay="0">' : '').'<div class="ct-textbox'.($effects_enabled ? ' lazy-loading-item' : '').($centered ? ' centered-box' : '').'" '.($effects_enabled ? ' data-ll-effect="move-up"' : '').'>'.$top_html.$title_html.'<div class="ct-textbox-inner ct-textbox-after-image" style="'.$css_style.'">'.$content_html.'</div>'.$bottom_html.'</div>'.($effects_enabled ? '</div>' : '');
		}
		if($picture_position == 'bottom') {
			$return_html = ($effects_enabled ? '<div class="lazy-loading" data-ll-item-delay="0">' : '').'<div class="ct-textbox'.($effects_enabled ? ' lazy-loading-item' : '').($centered ? ' centered-box' : '').'" '.($effects_enabled ? ' data-ll-effect="move-up"' : '').'>'.$top_html.'<div class="ct-textbox-inner ct-textbox-before-image" style="'.$css_style.'">'.$content_html.'</div>'.$title_html.$bottom_html.'</div>'.($effects_enabled ? '</div>' : '');
		}
	} else {
		$return_html = ($effects_enabled ? '<div class="lazy-loading" data-ll-item-delay="0">' : '').'<div class="ct-textbox'.($effects_enabled ? ' lazy-loading-item' : '').($style == 'iconedbox' ? ' icon-size-'.$icon_size : '').($centered ? ' centered-box' : '').'" '.($effects_enabled ? ' data-ll-effect="move-up"' : '').' style="'.$css_main_style.'">'.$top_html.'<div class="ct-textbox-inner" style="'.$css_style.'">'.$title_html.$content_html.'</div>'.$bottom_html.'</div>'.($effects_enabled ? '</div>' : '');
	}

	return $return_html;
}

function ct_quote_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'style' => 'default',
		'no_paddings' => ''
	), $atts, 'ct_quote'));
	$return_html = '<div class="ct-quote'.($style ? ' ct-quote-style-'.$style : '').($no_paddings ? ' ct-quote-no-paddings' : '').'"><blockquote>'.do_shortcode($content).'</blockquote></div>';
	return $return_html;
}

function ct_list_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'type' => '',
		'color' => '',
		'effects_enabled' => false
	), $atts, 'ct_list'));
	$return_html = '<div class="ct-list' . ($effects_enabled ? ' lazy-loading' : '') .($type ? ' ct-list-type-'.$type : '').($color ? ' ct-list-color-'.$color : '').'">'.do_shortcode($content).'</div>';
	return $return_html;
}

function ct_table_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'style' => '1',
		'row_headers' => ''
	), $atts, 'ct_table'));
	wp_enqueue_script('jquery-restable');
	$return_html = '<div class="ct-table ct-table-responsive'.($style ? ' ct-table-style-'.$style : '').($row_headers ? ' row-headers' : '').'">'.do_shortcode($content).'</div>';
	return $return_html;
}

function ct_quickfinder_shortcode($atts) {
	ob_start();
	ct_quickfinder($atts);
	$return_html = trim(preg_replace('/\s\s+/', ' ', ob_get_clean()));
	return $return_html;
}

function ct_team_shortcode($atts) {
	extract(shortcode_atts(array(
		'team' => '',
		'style' => '1',
		'columns' => '3'
	), $atts, 'ct_team'));
	$style = ct_check_array_value(array(1,2,3,4,5,6), $style, 1);
	$columns = ct_check_array_value(array('1', '2', '3', '4'), $columns, '3');
	ob_start();
	ct_team(array('team' => $team, 'style' => 'style-'.$style, 'columns' => $columns));
	$return_html = trim(preg_replace('/\s\s+/', ' ', ob_get_clean()));
	return $return_html;
}

function ct_gallery_shortcode($atts) {
	extract(shortcode_atts(array(
		'gallery_gallery' => '',
		'gallery_type' => 'slider',
		'gallery_slider_layout' => 'fullwidth',
		'gallery_layout' => '2x',
		'no_thumbs' => 0,
		'pagination' => 0,
		'autoscroll' => 0,
		'gallery_style' => 'justified',
		'gallery_fullwidth_columns' => '4',
		// 'gallery_no_gaps' => '',
		'gallery_hover' => 'default',
		'gallery_item_style' => 'default',
		'gallery_title' => '',
		'gaps_size' => '',
		'loading_animation' => 'move-up',
		'gallery_effects_enabled' => '',
		'metro_max_row_height' => 380
	), $atts, 'ct_gallery'));
	ob_start();
	if($gallery_type == 'slider') {
		ct_gallery(array(
			'gallery' => $gallery_gallery,
			'hover' => $gallery_hover,
			'layout' => $gallery_slider_layout,
			'no_thumbs' => $no_thumbs,
			'pagination' => $pagination,
			'autoscroll' => $autoscroll,
		));
	} else {
		ct_gallery_block(array(
			'gallery' => $gallery_gallery,
			'type' => $gallery_type,
			'layout' => $gallery_layout,
			'style' => $gallery_style,
			// 'no_gaps' => $gallery_no_gaps,
			'hover' => $gallery_hover,
			'item_style' => $gallery_item_style,
			'title' => $gallery_title,
			'gaps_size' => $gaps_size,
			'loading_animation' => $loading_animation,
			'effects_enabled' => $gallery_effects_enabled,
			'metro_max_row_height' => $metro_max_row_height,
			'fullwidth_columns' => $gallery_fullwidth_columns
		));
	}
	$return_html = trim(preg_replace('/\s\s+/', ' ', ob_get_clean()));
	return $return_html;
}

function ct_vc_get_galleries() {
	$galleries_posts = get_posts(array(
		'post_type' => 'ct_gallery',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
	));
	$galleries = array();
	foreach($galleries_posts as $gallery) {
		$galleries[$gallery->post_title.' (ID='.$gallery->ID.')'] = $gallery->ID;
	}
	return $galleries;
}

function ct_pricing_table_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'style' => '1',
		'button_icon' => 'default',
	), $atts, 'ct_pricing_table'));
	$style = ct_check_array_value(array(1, 2, 3, 4, 5, 6, 7, 8) ,$style, 1);
	$content = str_replace('[ct_pricing_price', '[ct_pricing_price use_style="'.$style.'" ',$content);

	$return_html = '<div class="pricing-table row inline-row inline-row-center pricing-table-style-'.$style.' button-icon-'.$button_icon.'">';
	$return_html.= do_shortcode($content);
	$return_html.= '</div>';

	return $return_html;
}

function ct_pricing_column_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'highlighted' => '0',
		'top_choice' => '',
		'top_choice_color' => '',
		'top_choice_background_color' => '',
		'label_top_corner' => 0,
		'cols' => 3,
	), $atts, 'ct_pricing_column'));
	$path = get_template_directory_uri().'/images/star.svg#star';
	$fill_svg_color ='';
	if ($top_choice_background_color) {
		 $fill_svg_color =  "style=fill:$top_choice_background_color;";
	}
	$fill_svg = '<svg class="svg_pricing" '.$fill_svg_color.'><use xlink:href='.$path.' /></svg>';
	$return_html = '
	<div class="pricing-column-wrapper ' .($cols == 4  ? 'col-md-3 col-sm-4 col-xs-6 ' : ''). ($cols == 3  ? 'col-md-4 col-sm-4 col-xs-6 ' : ''). ' inline-column'.($highlighted == '1' ? ' highlighted' : '').'">'
		.($top_choice ?
			'<div ' .($top_choice_background_color ? 'style=background-color:'.$top_choice_background_color.'' : ''). '  class="pricing-column-top-choice">'.$fill_svg.'
		<div ' .($top_choice_color ? 'style=color:'.$top_choice_color.'' : ''). ' class="pricing-column-top-choice-text">'.$top_choice.'</div></div>' : '').
	'<div class="pricing-column'.($label_top_corner == '1' ? ' label-top-corner' : '').'">';
	$return_html.= do_shortcode($content);
	$return_html.= '</div></div>';
	return $return_html;
}

function ct_pricing_price_shortcode($atts) {
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
	if ($backgroundcolor) { $svg_fill = "style='fill:$backgroundcolor'";}
	$url = get_template_directory_uri() . '/css/post-arrow.svg#dec-post-arrow';
	$bottom_html = '<svg ' .$svg_fill. ' class="wrap-style"><use xlink:href='.$url.' /></svg>';
	$background = ct_attachment_url($background);
	$return_html = '
	 <div class="pricing-price-row '.($background ? 'pricing-price-row-width-background' : '').' "  style="'.($background ? ' background-image: url('.$background.');' : '') . ($backgroundcolor ? ' background-color: '.$backgroundcolor.'; ' : '') . ($price_color ? 'color:'.$price_color.'; ' : '') .'">

		'.($title ? '<div class="pricing-price-title-wrapper">
		<div '.($title_color ? 'style=color:'.$title_color.'' : '').'  class="pricing-price-title">'.$title.'</div>
		<div '.($subtitle_color ? 'style=color:'.$subtitle_color.'' : '').' class="pricing-price-subtitle">'.$subtitle.'</div>
		</div>' : '').'

		<div class="pricing-price-wrapper"><div class="pricing-price'.($background ? ' pricing-price-row-background' : '').'" style="'.($background ? ' background-image: url('.$background.');' : '') . ($backgroundcolor ? ' background-color: '.$backgroundcolor.'; ' : '') .'">'.
			'<div style=" '.($price_color ? 'color:'.$price_color.'; ' : '') .($font_size != '' ? 'font-size: '.$font_size.'px;' : '').'" class="pricing-cost">'.$currency.$price.'</div>'.($time != '' ? '<div  class="time" style= ' .'display:inline-block;'  . ($time_color ? 'color:'.$time_color.';' : '') . ($font_size_time ? 'font-size:'.$font_size_time.'px; ' : '') .'>'.$time.'</div>' : '').
		'</div></div>'
		.$bottom_html.
	'</div>';

	return $return_html;
}

function ct_pricing_row_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'strike' => '',
	), $atts, 'ct_pricing_row'));

	$return_html = '<figure class="pricing-row'.($strike == '1' ? ' strike' : '').'">'.$content.'</figure><!-- '.print_r($content, 1).' -->';
	return $return_html;
}
function ct_pricing_row_title_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'subtitle' => '',
		'title_color' => '',
		'subtitle_color' => '',
	), $atts, 'ct_pricing_row_title'));
	$return_html = '<div class="pricing-row pricing-row-title"><div '.($title_color ? "style='color: $title_color'" :'').' class="pricing_row_title">'.$content.'</div>'.($subtitle ? '<div '.($subtitle_color ? "style='color: $subtitle_color'" :'').'  class="pricing_row_subtitle">'.$subtitle.'</div>' : ''). '</div>';
	return $return_html;
}

function ct_pricing_footer_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'href' => '#',
		'button_1_text' => '',
		'button_1_link' => '',
		'button_1_style' => 'center',
		'button_1_size' => 'small',
		'button_1_text_weight' => 'normal',
		'button_1_no_uppercase' => 0,
		'button_1_corner' => 3,
		'button_1_border' => 2,
		'button_1_position' => 'center',
		'button_1_text_color' => '',
		'button_1_background_color' => '',
		'button_1_border_color' => '',
		'button_1_hover_text_color' => '',
		'button_1_hover_background_color' => '',
		'button_1_hover_border_color' => '',
		'button_1_icon_pack' => 'elegant',
		'button_1_icon_elegant' => '',
		'button_1_icon_material' => '',
		'button_1_icon_fontawesome' => '',
		'button_1_icon_userpack' => '',
		'button_1_icon_position' => 'left',
		'button_1_separator' => '',
		'button_1_extra_class' => '',
	), $atts, 'ct_pricing_footer'));
	$button1 = array();
	foreach($atts as $key => $value) {
		if(substr($key, 0, 9) == 'button_1_') {
			$button1[substr($key, 9)] = $value;
		}
	}
		$button1['position'] = 'center';
	$return_html = '<div class="pricing-footer">'.ct_button_shortcode($button1).'</div>';
	return $return_html;
}

function ct_icon_shortcode($atts) {
	extract(shortcode_atts(array(
		'pack' => '',
		'icon' => '',
		'icon_elegant' => '',
		'icon_material' => '',
		'icon_fontawesome' => '',
		'icon_userpack' => '',
		'shape' => 'square',
		'style' => '',
		'color' => '',
		'color_2' => '',
		'background_color' => '',
		'border_color' => '',
		'size' => 'small',
		'icon_opacity' => '1',
		'link' => '',
		'link_target' => '_self',
		'centered' => '',
		'icon_top_margin' => '0',
		'icon_bottom_margin' => '0',
		'css_style' => ''
	), $atts, 'ct_icon'));
	if($pack =='elegant' && empty($icon) && $icon_elegant) {
		$icon = $icon_elegant;
	}
	if($pack =='material' && empty($icon) && $icon_material) {
		$icon = $icon_material;
	}
	if($pack =='fontawesome' && empty($icon) && $icon_fontawesome) {
		$icon = $icon_fontawesome;
	}
	if($pack =='userpack' && empty($icon) && $icon_userpack) {
		$icon = $icon_userpack;
	}
	wp_enqueue_style('icons-'.$pack);
	$shape = ct_check_array_value(array('circle', 'square', 'romb', 'hexagon'), $shape, 'square');
	$style = ct_check_array_value(array('', 'angle-45deg-r', 'angle-45deg-l', 'angle-90deg'), $style, '');
	$size = ct_check_array_value(array('small', 'medium', 'large', 'xlarge'), $size, 'small');
	$link = esc_url($link);
	$link_target = ct_check_array_value(array('_self', '_blank'), $link_target, '_self');
	$css_style_icon = '';
	$css_style_icon_background = '';
	$css_style_icon_1 = '';
	$css_style_icon_2 = '';
	if($css_style) {
		$css_style_icon .= esc_attr($css_style);
	}
	if($background_color) {
		$css_style_icon_background .= 'background-color: '.$background_color.';';
		if(!$border_color) {
			$css_style_icon .= 'border-color: '.$background_color.';';
		}
	}
	if(intval($icon_top_margin)) {
		$css_style_icon .= 'margin-top: '.intval($icon_top_margin).'px;';
	}
	if(intval($icon_bottom_margin)) {
		$css_style_icon .= 'margin-bottom: '.intval($icon_bottom_margin).'px;';
	}
	if($border_color) {
		$css_style_icon .= 'border-color: '.$border_color.';';
	}
	if($icon_opacity) {
		$css_style_icon .= 'opacity: '.$icon_opacity.';';
	}
	$simple_icon = '';
	if(!($background_color || $border_color)) {
		$simple_icon = ' ct-simple-icon';
	}
	if($color = $color) {
		$css_style_icon_1 = 'color: '.$color.';';
		if(($color_2 = $color_2) && $style) {
			$css_style_icon_2 = 'color: '.$color_2.';';
		} else {
			$css_style_icon_2 = 'color: '.$color.';';
		}
	}
	if($shape == "romb") {'';}
	if($shape == "romb") {'</div> ';}


	$return_html = '<div class="ct-icon ct-icon-pack-'.$pack.' ct-icon-size-'.$size.' '.$style.' ct-icon-shape-'.$shape.$simple_icon.'" style="'.$css_style_icon.'">'.

		($shape == 'hexagon' ? '<div class="ct-icon-shape-hexagon-back"><div class="ct-icon-shape-hexagon-back-inner"><div class="ct-icon-shape-hexagon-back-inner-before" style="background-color: '.($border_color ? $border_color : $background_color).'"></div></div></div><div class="ct-icon-shape-hexagon-top"><div class="ct-icon-shape-hexagon-top-inner"><div class="ct-icon-shape-hexagon-top-inner-before" style="'.$css_style_icon_background.'"></div></div></div>' : '').
		'<div class="ct-icon-inner" style="'.$css_style_icon_background.'">'.
		($shape == 'romb' ? '<div class="romb-icon-conteiner">' : '').
		($link ? '<a href="'.$link.'" target="'.$link_target.'">' : '').
		'<span class="ct-icon-half-1" style="'.$css_style_icon_1.'"><span class="back-angle">&#x'.$icon.';</span></span>'.
		'<span class="ct-icon-half-2" style="'.$css_style_icon_2.'"><span class="back-angle">&#x'.$icon.';</span></span>'.
		($link ? '</a>' : '').
		($shape == 'romb' ? '</div>' : '').
		'</div>'.
		'</div>';
	return ($centered ? '<div class="centered-box">' : '').$return_html.($centered ? '</div>' : '');
}

function ct_build_icon_shortcode($atts) {
	extract(shortcode_atts(array(
		'icon_pack' => 'elegant',
		'icon' => '',
		'icon_shape' => 'square',
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
		'icon_link' => '',
		'icon_link_target' => '_self',
		'css_style' => ''
	), $atts, 'ct_icon'));
	if($icon_pack =='elegant'  && $icon_elegant) {
		$icon = $icon_elegant;
	}
	if($icon_pack =='material' && $icon_material) {
		$icon = $icon_material;
	}
	if($icon_pack =='fontawesome' && $icon_fontawesome) {
		$icon = $icon_fontawesome;
	}
	if($icon_pack =='userpack' && $icon_userpack) {
		$icon = $icon_userpack;
	}
	$icon_shortcode = '[ct_icon pack="'.$icon_pack.
		'" icon="'.$icon.
		'" shape="'.$icon_shape.
		'" style="'.$icon_style.
		'" color="'.$icon_color.
		'" color_2="'.$icon_color_2.
		'" background_color="'.$icon_background_color.
		'" border_color="'.$icon_border_color.
		'" size="'.$icon_size.
		'" opacity="'.$icon_opacity.
		'" link="'.$icon_link.
		'" link_target="'.$icon_link_target.
		'" css_style="'.$css_style.'"]';
	return $icon_shortcode;
}

function ct_build_icon_with_title_shortcode($atts) {
	extract(shortcode_atts(array(
		'icon_pack' => '',
		'icon' => '',
		'icon_elegant' => '',
		'icon_material' => '',
		'icon_fontawesome' => '',
		'icon_userpack' => '',
		'icon_shape' => 'circle',
		'icon_style' => '',
		'icon_color' => '',
		'icon_color_2' => '',
		'icon_background_color' => '',
		'icon_border_color' => '',
		'icon_size' => 'small',
		'title' => '',
		'level' => 'h6',
		'title_color' => '',

	), $atts, 'ct_icon'));
	$icon_shortcode = '[ct_icon pack="'.$icon_pack.
		'" icon="'.$icon.
		'" shape="'.$icon_shape.
		'" style="'.$icon_style.
		'" color="'.$icon_color.
		'" color_2="'.$icon_color_2.
		'" background_color="'.$icon_background_color.
		'" border_color="'.$icon_border_color.
		'" size="'.$icon_size;
	return $icon_shortcode;
}

function ct_icon_with_title_shortcode($atts) {
	extract(shortcode_atts(array(
		'icon_pack' => '',
		'icon' => '',
		'icon_elegant' => '',
		'icon_material' => '',
		'icon_fontawesome' => '',
		'icon_userpack' => '',
		'icon_shape' => 'circle',
		'icon_style' => '',
		'icon_color' => '',
		'icon_color_2' => '',
		'icon_background_color' => '',
		'icon_border_color' => '',
		'icon_size' => 'small',
		'title' => '',
		'level' => 'h1',
		'title_color' => '',

	), $atts, 'ct_icon_with_title'));

	$level = ct_check_array_value(array('h1','h2','h3','h4','h5','h6'), $level, 'h1');
	$icon_size = ct_check_array_value(array('small', 'medium', 'large', 'xlarge'), $icon_size, 'small');
	$css_style = '';
	if($title_color) {
		$css_style = 'color: '.$title_color.';';
	}
	$return_html = '<div class="ct-icon-with-title-icon">'.do_shortcode(ct_build_icon_shortcode($atts)).'</div>';
	$return_html .= '<div class="ct-iconed-title"><'.$level.' style="'.$css_style.'">'.$title.'</'.$level.'></div>';
	$return_html = '<div class=" ct-icon-with-title  ct-icon-with-title-icon-size-'.$icon_size.'">'.$return_html.'</div>';
	return $return_html;
}

function ct_icon_with_text_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'pack' => '',
		'icon' => '',
		'icon_shape' => 'square',
		'icon_style' => '',
		'icon_color' => '',
		'icon_color_2' => '',
		'icon_background_color' => '',
		'icon_border_color' => '',
		'icon_size' => 'small',
		'title' => '',
		'level' => 'h6',
		'flow' => '',
		'centered' => '',
		'title_color' => '',
		'icon_bottom_margin' => '0',
		'icon_top_margin' => '0',
		'icon_top_side_padding' => '0',
		'icon_right_side_padding' => '0',
		'icon_bottom_side_padding' => '0',
		'icon_left_side_padding'=> '0',
		'float_right' => ''

	), $atts, 'ct_icon_with_text'));
	if($title_color) {
		$css_style = 'color: '.$title_color.';';
	}
	$css_style_padding= "";
	if($icon_top_side_padding) {
		$css_style_padding .= 'padding-top: '.$icon_top_side_padding.'px;';
	}
	if($icon_right_side_padding) {
		$css_style_padding .= 'padding-right: '.$icon_right_side_padding.'px;';
	}
	if($icon_bottom_side_padding) {
		$css_style_padding .= 'padding-bottom: '.$icon_bottom_side_padding.'px;';
	}
	if($icon_left_side_padding) {
		$css_style_padding .= 'padding-left: '.$icon_left_side_padding.'px;';
	}


	$icon_size = ct_check_array_value(array('small', 'medium', 'large', 'xlarge'), $icon_size, 'small');
	$return_html = '<div style="margin-bottom:' .$icon_bottom_margin. 'px;' .$css_style_padding. 'margin-top:' .$icon_top_margin. 'px; " class="ct-icon-with-text-icon">' .do_shortcode(ct_build_icon_shortcode($atts)). '</div>';
	$return_html .= '<div class="ct-icon-with-text-content" >';
	if($title) {
		$return_html .= '<div class="ct-icon-with-text-empty"></div>';
	}
	$return_html .= '<div class="ct-icon-with-text-text">'.do_shortcode($content).'</div></div>';
	$return_html = '<div class="ct-icon-with-text ct-icon-with-text-icon-size-'.$icon_size.($centered ? ' centered-box' : '').($float_right ? ' ct-icon-with-text-float-right' : '').($flow ? ' ct-icon-with-text-flow' : '').'">'.$return_html.'<div class="clearboth"></div></div>';
	return $return_html;
}

function ct_alert_box_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'content_text_color' => '',
		'content_background_color' => '#f4f6f7',
		'content_background_image' => '',
		'content_background_style' => '',
		'content_background_position_horizontal' => 'center',
		'content_background_position_vertical' => 'top',
		'border_width' => '0',
		'border_color' => '',
		'border_radius' => '0',
		'rectangle_corner' => '',
		'top_style' => 'default',
		'bottom_style' => 'default',
		'image' => '',
		'icon_pack' => 'elegant',
		'icon_shape' => 'square',
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
		'gradient_backgound' => '',
		'gradient_backgound_from' => '#fff',
		'gradient_backgound_to' => '#000',
		'gradient_backgound_style' => 'linear',
		'gradient_backgound_angle' => 'to bottom',
		'gradient_backgound_cusotom_deg' => '180',
		'gradient_radial_backgound_position' => 'at top',

		'button_1_text' => '',
		'button_1_link' => '',
		'button_1_style' => 'flat',
		'button_1_size' => 'small',
		'button_1_text_weight' => 'normal',
		'button_1_no_uppercase' => 0,
		'button_1_corner' => 3,
		'button_1_border' => 2,
		'button_1_text_color' => '',
		'button_1_background_color' => '',
		'button_1_border_color' => '',
		'button_1_hover_text_color' => '',
		'button_1_hover_background_color' => '',
		'button_1_hover_border_color' => '',
		'button_1_icon_pack' => 'elegant',
		'button_1_icon_elegant' => '',
		'button_1_icon_material' => '',
		'button_1_icon_fontawesome' => '',
		'button_1_icon_userpack' => '',
		'button_1_gradient_backgound' => '',
		'button_1_gradient_radial_swap_colors' => '',
		'button_1_gradient_backgound_from' => '',
		'button_1_gradient_backgound_to' => '',
		'button_1_gradient_backgound_hover_from' => '',
		'button_1_gradient_backgound_hover_to' => '',
		'button_1_gradient_backgound_style' => 'linear',
		'button_1_gradient_backgound_angle' => 'to bottom',
		'button_1_gradient_backgound_cusotom_deg' => '180',
		'button_1_gradient_radial_backgound_position' => 'at top',

		'button_2_activate' => 0,
		'button_2_text' => '',
		'button_2_link' => '',
		'button_2_style' => 'flat',
		'button_2_size' => 'small',
		'button_2_text_weight' => 'normal',
		'button_2_no_uppercase' => 0,
		'button_2_corner' => 3,
		'button_2_border' => 2,
		'button_2_text_color' => '',
		'button_2_background_color' => '',
		'button_2_border_color' => '',
		'button_2_hover_text_color' => '',
		'button_2_hover_background_color' => '',
		'button_2_hover_border_color' => '',
		'button_2_icon_pack' => 'elegant',
		'button_2_icon_elegant' => '',
		'button_2_icon_material' => '',
		'button_2_icon_fontawesome' => '',
		'button_2_icon_userpack' => '',
		'button_2_gradient_backgound' => '',
		'button_2_gradient_radial_swap_colors' => '',
		'button_2_gradient_backgound_from' => '',
		'button_2_gradient_backgound_to' => '',
		'button_2_gradient_backgound_hover_from' => '',
		'button_2_gradient_backgound_hover_to' => '',
		'button_2_gradient_backgound_style' => 'linear',
		'button_2_gradient_backgound_angle' => 'to bottom',
		'button_2_gradient_backgound_cusotom_deg' => '180',
		'button__gradient_radial_backgound_position' => 'at top',


		'centered' => '',
	), $atts, 'ct_alert_box'));
	$atts = is_array($atts) ? $atts : array();
	$button1 = array();
	foreach($atts as $key => $value) {
		if(substr($key, 0, 9) == 'button_1_') {
			$button1[substr($key, 9)] = $value;
		}
	}
	if($centered) {
		$button1['position'] = 'inline';
	} else {
		$button1['position'] = 'center';
	}
	$button2 = array();
	if($button_2_activate) {
		foreach($atts as $key => $value) {
			if(substr($key, 0, 9) == 'button_2_') {
				$button2[substr($key, 9)] = $value;
			}
		}
		if($centered) {
			$button2['position'] = 'inline';
		} else {
			$button2['position'] = 'center';
		}
	}

	$ab_buttons = '<div class="ct-alert-box-buttons">'.ct_button_shortcode($button1).($button_2_activate ? ct_button_shortcode($button2) : '').'</div>';

	$ab_picture = '';

	if($image && $icon_pack == 'image') {
		$ab_picture = '<div class="ct-alert-box-picture"><div class="ct-alert-box-image image-size-'.$icon_size.' image-shape-'.$icon_shape.'"><img src="'.ct_attachment_url($image).'" alt="#" class="img-responsive" /></div></div>';
	}
	if(($icon_pack =='elegant' && $icon_elegant) || ($icon_pack =='material' && $icon_material) || ($icon_pack =='fontawesome' && $icon_fontawesome) || ($icon_pack =='userpack' && $icon_userpack)) {
		$ab_picture = '<div class="ct-alert-box-picture">'.do_shortcode(ct_build_icon_shortcode($atts)).'</div>';
	}

	$ab_content = '<div class="ct-alert-box-content">'.do_shortcode($content).'</div>';

	$return_html = '<div class="ct-alert-box'.($centered ? ' centered-box' : '').'"><div class="ct-alert-inner">'.$ab_picture.$ab_content.$ab_buttons.'</div></div>';

	$return_html = ct_textbox_shortcode(array_diff_key($atts, array_diff_key($atts, array(
		'content_text_color' => '',
		'content_background_color' => '#f4f6f7',
		'content_background_image' => '',
		'content_background_style' => '',
		'content_background_position_horizontal' => 'center',
		'content_background_position_vertical' => 'top',
		'gradient_backgound' => '',
		'gradient_backgound_from' => '#fff',
		'gradient_backgound_to' => '#000',
		'gradient_backgound_style' => 'linear',
		'gradient_backgound_angle' => 'to bottom',
		'gradient_backgound_cusotom_deg' => '180',
		'gradient_radial_backgound_position' => 'at top',
		'border_width' => '0',
		'border_color' => '',
		'border_radius' => '0',
		'rectangle_corner' => '',
		'top_style' => 'default',
		'bottom_style' => 'default',
	))),$return_html);

	return $return_html;
}

function ct_button_shortcode($atts) {
	extract(shortcode_atts(array(
		'text' => '',
		'link' => '',
		'style' => 'flat',
		'size' => 'small',
		'text_weight' => 'normal',
		'no_uppercase' => 0,
		'corner' => 3,
		'border' => 2,
		'position' => 'inline',
		'text_color' => '',
		'background_color' => '',
		'border_color' => '',
		'hover_text_color' => '',
		'hover_background_color' => '',
		'hover_border_color' => '',
		'icon_pack' => 'elegant',
		'icon_elegant' => '',
		'icon_material' => '',
		'icon_fontawesome' => '',
		'icon_userpack' => '',
		'icon_position' => 'left',
		'separator' => '',
		'extra_class' => '',
		'effects_enabled' => false,
		'gradient_backgound' => '',
		'gradient_radial_swap_colors' => '',
		'gradient_backgound_from' => '',
		'gradient_backgound_to' => '',
		'gradient_backgound_hover_from' => '',
		'gradient_backgound_hover_to' => '',
		'gradient_backgound_style' => 'linear',
		'gradient_backgound_angle' => 'to bottom',
		'gradient_backgound_cusotom_deg' => '180',
		'gradient_radial_backgound_position' => 'at top',
	), $atts, 'ct_button'));
	$link = ( '||' === $link ) ? '' : $link;
	if($link === 'post_link') {
		$a_href = $link;
		$a_title = '';
		$a_target = '';
	} else {
		$link = vc_build_link( $link );
		$a_href = $link['url'];
		$a_title = $link['title'];
		$a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
	}
	$icon = '';
	if($icon_elegant && $icon_pack == 'elegant') {
		$icon = $icon_elegant;
	}
	if($icon_material && $icon_pack == 'material') {
		$icon = $icon_material;
	}
	if($icon_fontawesome && $icon_pack == 'fontawesome') {
		$icon = $icon_fontawesome;
	}
	if($icon_userpack && $icon_pack == 'userpack') {
		$icon = $icon_userpack;
	}
	return ct_button(array(
		'text' => $text,
		'href' => $a_href,
		'target' => $a_target,
		'title' => $a_title,
		'style' => $style,
		'size' => $size,
		'text_weight' => $text_weight,
		'no-uppercase' => $no_uppercase,
		'corner' => $corner,
		'border' => $border,
		'position' => $position,
		'text_color' => $text_color,
		'background_color' => $background_color,
		'border_color' => $border_color,
		'hover_text_color' => $hover_text_color,
		'hover_background_color' => $hover_background_color,
		'hover_border_color' => $hover_border_color,
		'icon_pack' => $icon_pack,
		'icon' => $icon,
		'icon_position' => $icon_position,
		'separator' => $separator,
		'extra_class' => $extra_class,
		'effects_enabled' => $effects_enabled,
		'gradient_backgound' => $gradient_backgound,
		'gradient_backgound_from' => $gradient_backgound_from,
		'gradient_backgound_to' => $gradient_backgound_to,
		'gradient_backgound_hover_from' => $gradient_backgound_hover_from,
		'gradient_backgound_hover_to' => $gradient_backgound_hover_to,
		'gradient_backgound_style' => $gradient_backgound_style,
		'gradient_radial_swap_colors' => $gradient_radial_swap_colors,
		'gradient_backgound_angle' => $gradient_backgound_angle,
		'gradient_backgound_cusotom_deg' => $gradient_backgound_cusotom_deg,
		'gradient_radial_backgound_position' => $gradient_radial_backgound_position
	));
}

function ct_dropcap_shortcode($atts) {
	extract(shortcode_atts(array(
		'letter' => '',
		'shape' => 'square',
		'color' => '',
		'style' => 'medium',
		'background_color' => '',
		'border_color' => '',
	), $atts, 'ct_dropcap'));
	$shape = ct_check_array_value(array('circle', 'square', 'hexagon'), $shape, 'circle');
	$style = ct_check_array_value(array('medium', 'big'), $style, 'medium');
	$css_style = '';
	if($color) {
		$css_style .= 'color: '.$color.';';
	}
	if($background_color) {
		$css_style .= 'background-color: '.$background_color.';';
	}
	if($border_color) {
		$css_style .= 'border: 1px solid '.$border_color.';';
	}
	$letter = substr($letter,0,1);
	$return_html =


		'<div class="ct-dropcap ct-dropcap-shape-'.$shape.' ct-dropcap-style-'.$style.'">'.
		($shape == 'hexagon' ? '<div class="dropcap-hexagon-inner"><div class="ct-dropcap-shape-hexagon-back"><div class="ct-dropcap-shape-hexagon-back-inner"><div class="ct-dropcap-shape-hexagon-back-inner-before" style="background-color: '.($border_color ? $border_color : $background_color).'"></div></div></div><div class="ct-dropcap-shape-hexagon-top"><div class="ct-dropcap-shape-hexagon-top-inner"><div class="ct-dropcap-shape-hexagon-top-inner-before" style="background-color:'.$background_color.'"></div></div></div></div>' : '').

		'<span class="ct-dropcap-letter" style="'.$css_style.'">'.$letter.'</span></div>';


	return $return_html;
}

function ct_counter_box_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'style' => 1,
		'columns' => 4,
		'connector_color' => '',
		'effects_enabled' => false,
		'team_person' => '',
		'team_image_size' => 'small',
		'number_format' => ''
	), $atts, 'ct_counter_box'));
	if(ct_is_plugin_active('js_composer/js_composer.php')) {
		global $vc_manager;
		if($vc_manager->mode() == 'admin_frontend_editor' || $vc_manager->mode() == 'admin_page' || $vc_manager->mode() == 'page_editable') {
			$effects_enabled = false;
		}
	}
	wp_enqueue_style('odometr');
	wp_enqueue_script('ct-counters-effects');
	$style = ct_check_array_value(array(1, 2, 'vertical') ,$style, 1);
	$content = str_replace('[ct_counter ', '[ct_counter use_style="'.$style.'" ',$content);
	$number_format = $number_format ? $number_format : '(ddd).ddd';
	if($style == 'vertical') {
		$team_html = '';
		if($team_person) {
			$team_image_size = ct_check_array_value(array('small', 'medium', 'large', 'xlarge'), $team_image_size, 'small');
			ob_start();
			ct_team(array('team_person' => $team_person, 'style' => 'style-counter', 'columns' => 1));
			$team_html = '<div class="ct-counter-team image-size-'.esc_attr($team_image_size).'">'.trim(preg_replace('/\s\s+/', ' ', ob_get_clean())).'</div>';
		}
		$content = str_replace('[ct_counter ', '[ct_counter connector_color="'.$connector_color.'" ',$content);
		return '<div data-number-format="'.$number_format.'" class="ct-counter-box ct-counter-style-' . $style . ($effects_enabled ? ' lazy-loading lazy-loading-not-hide' : '') . '" ' . ($effects_enabled ? 'data-ll-item-delay="0"' : '') . '>'.$team_html.'<div class="ct-counters-list">'.do_shortcode($content).'</div></div>';
	} else {
		$content = str_replace('[ct_counter ', '[ct_counter columns="'.$columns.'" ',$content);
		return '<div data-number-format="'.$number_format.'" class="ct-counter-box row inline-row inline-row-center ct-counter-style-' . $style . ($effects_enabled ? ' lazy-loading lazy-loading-not-hide' : '') . '" ' . ($effects_enabled ? 'data-ll-item-delay="0"' : '') . '>'.do_shortcode($content).'</div>';
	}
}

function ct_vc_get_team_persons() {
	$persons = get_posts(array(
		'post_type' => 'ct_team_person',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
	));
	$team_persons = array(__('None', 'ct') => '');
	foreach($persons as $person) {
		$team_persons[$person->post_title.' (ID='.$person->ID.')'] = $person->ID;
	}
	return $team_persons;
}

function ct_counter_shortcode($atts) {
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

	if(ct_is_plugin_active('js_composer/js_composer.php')) {
		global $vc_manager;
		if($vc_manager->mode() == 'admin_frontend_editor' || $vc_manager->mode() == 'admin_page' || $vc_manager->mode() == 'page_editable') {
			return '<div class="counter-shortcode-dummy"></div>';
		}
	}
	$return_html = '';
	$circle_border = '';
	if($use_style == 2) {
		$circle_border = $icon_border_color ? $icon_border_color : '#ffffff';
		$background_color = '';
		$hover_background_color = '';
		$atts['icon_background_color'] = '';
		$atts['icon_border_color'] = '';
	}
	if($use_style == 'vertical') {
		$atts['icon_background_color'] = $icon_background_color ? $icon_background_color : ($background_color ? $background_color : '#ffffff');
	}

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
			$hover_data .= ' data-hover-icon-color="'.$hover_icon_color.'"';
		}
		if($hover_background_color) {
			$hover_data .= ' data-hover-background-color="'.$hover_background_color.'"';
		}
		if($hover_numbers_color) {
			$hover_data .= ' data-hover-numbers-color="'.$hover_numbers_color.'"';
		}
		if($hover_text_color) {
			$hover_data .= ' data-hover-text-color="'.$hover_text_color.'"';
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
		if($use_style == 2) {
			$return_html .= '<div class="ct-counter-icon"><div class="ct-counter-icon-circle-1" style="border-color: '.esc_attr($circle_border).';"><div class="ct-counter-icon-circle-2" style="border-color: '.esc_attr($circle_border).';">'.$icon_html.'</div></div></div>';
		} else {
			$return_html .= '<div class="ct-counter-icon">'.$icon_html.'</div>';
		}
	}
	$return_html .= '<div class="ct-counter-number"'.($numbers_color ? ' style="color: '.esc_attr($numbers_color).'"' : '').'><div class="ct-counter-odometer" data-to="'.$to.'">'.$from.'</div>'.($suffix ? '<span class="ct-counter-suffix">'.$suffix.'</span>' : '').'</div>';
	if($text) {
		$return_html .= '<div class="ct-counter-text styled-subtitle"'.($text_color ? ' style="color: '.esc_attr($text_color).'"' : '').'>'.$text.'</div>';
	}

	$counter_bottom = '';
	if($use_style == 1 && $background_color) {
		$counter_bottom = '<div class="ct-counter-bottom"><div class="ct-counter-bottom-left" style="background-color: '.$background_color.';"></div><svg width="20" height="10" style="fill: '.$background_color.';"><path d="M 0,0 0,10 2,10 C 2,-2 18,-2, 18,10 L 20,10 20,0 " /></svg><div class="ct-counter-bottom-right" style="background-color: '.$background_color.';"></div></div>';
	}

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

function ct_news_shortcode($atts) {
	extract(shortcode_atts(array(
		'post_types' => 'post',
		'justified_style' => '',
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
	ct_blog(array(
		'blog_post_types' => $post_types ? explode(',', $post_types) : array('post', 'ct_news'),
		'blog_style' => $style,
		'justified_style' => $justified_style,
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

function ct_clients_shortcode($atts) {
	extract(shortcode_atts(array(
		'set' => '',
		'style' => '',
		'rows' => '3',
		'cols' => '3',
		'autoscroll' => '',
		'fullwidth' => '',
		'disable_grayscale' => false,
		'effects_enabled' => false
	), $atts, 'ct_clients'));

	ob_start();
	if($style == 'carousel') {
		ct_clients_block(array('disable_grayscale' => $disable_grayscale, 'clients_set' => $set, 'autoscroll' => $autoscroll, 'fullwidth' => $fullwidth, 'effects_enabled' => $effects_enabled));
	} else {
		ct_clients(array('disable_grayscale' => $disable_grayscale, 'clients_set' => $set, 'rows' => $rows, 'cols' => $cols, 'autoscroll' => $autoscroll, 'effects_enabled' => $effects_enabled));
	}
	$return_html = trim(preg_replace('/\s\s+/', ' ', ob_get_clean()));
	return $return_html;
}

function ct_testimonials_shortcode($atts) {
	extract(shortcode_atts(array(
		'set' => '',
		'fullwidth' => '',
		'style' => 'style1',
		'image_size' => 'size-small',
		'autoscroll' => 0,
	), $atts, 'ct_testimonials'));
	ob_start();
	ct_testimonialss(array('testimonials_set' => $set, 'fullwidth' => $fullwidth, 'style' => $style, 'image_size' => $image_size, 'autoscroll' => $autoscroll));


	$return_html = trim(preg_replace('/\s\s+/', ' ', ob_get_clean()));
	return $return_html;
}

function ct_map_with_text_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'background_color' => '',
		'color' => '',
		'size' => '',
		'link' => '',
		'grayscale' => '',
		'container' => '',
		'disable_scroll' => '',
		'rounded_corners' => ''
	), $atts, 'ct_map_with_text'));
	$size = str_replace( array( 'px', ' ' ), array( '', '' ), $size );
	$size = $size ? ($size + 46) : '';
	$map = '<div class="ct-map-with-text-map'.($grayscale ? ' grayscale' : '').'">'.do_shortcode('[vc_gmaps'.($link ? ' link="'.$link.'"' : '').' size="'.$size.'" disable_scroll="'.$disable_scroll.'"]').'</div>';
	$css_style = '';
	if($color) {
		$css_style .= 'color: '.$color.';';
	}
	if($background_color) {
		$css_style .= 'background-color: '.$background_color.';';
	}
	$return_html = '<div class="ct-map-with-text'.($rounded_corners ? ' rounded-corners' : '').'"><div class="ct-map-with-text-content" style="'.$css_style.'">'.($container ? '<div class="container">' : '').do_shortcode($content).($container ? '</div>' : '').'</div>'.$map.'</div>';
	return $return_html;
}

function ct_link($atts) {
	extract(shortcode_atts(array(
		'text' => '',
		'href' => '',
		'class' => '',
		'title' => '',
		'target' => '_self',
	), $atts, 'ct_link'));
	$return_html = '<a';
	if($href) {
		$return_html .= ' href="'.esc_url($href).'"';
	}
	if($class) {
		$return_html .= ' class="'.esc_attr($href).'"';
	}
	if($title) {
		$return_html .= ' title="'.esc_attr($title).'"';
	}
	$target = ct_check_array_value(array('_self', '_blank'), $target, '_self');
	$return_html .= ' target="'.esc_attr($target).'"';
	$return_html .= '>'.esc_html($text).'</a>';
	return $return_html;
}

function print_filters_for( $hook = '' ) {
	global $wp_filter;
	if( empty( $hook ) || !isset( $wp_filter[$hook] ) )
		return;

	$output = '<pre>';
	$output .= print_r( $wp_filter[$hook],1 );
	$output .= '</pre>';
	return $output;
}

function ct_run_shortcode($content) {
	global $shortcode_tags;
	$orig_shortcode_tags = $shortcode_tags;
	remove_all_shortcodes();

	add_shortcode('ct_list', 'ct_list_shortcode');
	add_shortcode('ct_table', 'ct_table_shortcode');

	$content = do_shortcode($content);
	$shortcode_tags = $orig_shortcode_tags;
	return $content;
}

function ct_userpack_to_dropdown() {
	return ct_icon_userpack_enabled() ? array(__('UserPack', 'ct') => 'userpack') : array();
}
function ct_userpack_to_shortcode($arr = array()) {
	return ct_icon_userpack_enabled() ? $arr : array();
}

function ct_shortcodes() {
	$icons_params = array();
	if(function_exists('vc_map_integrate_shortcode')) {
		$icons_params = vc_map_integrate_shortcode( 'vc_icon', 'i_', '',
			array('include_only_regex' => '/^(type|icon_\w*)/'),
			array(
				'type' => 'add_icon',
				'value' => 'true',
			)
		);
	}

	$shortcodes = array(
		'ct_alert_box' => array(
			'name' => __('Alert Box / CTA', 'ct'),
			'base' => 'ct_alert_box',
			'is_container' => true,
			'js_view' => 'VcCTAlertBoxView',
			'icon' => 'ct-icon-wpb-ui-alert-box',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Catch visitors attention with alert box', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Icon pack', 'ct'),
					'param_name' => 'icon_pack',
					'value' => array_merge(array(__('Elegant', 'ct') => 'elegant', __('Material Design', 'ct') => 'material', __('FontAwesome', 'ct') => 'fontawesome'), ct_userpack_to_dropdown(),array(__('Image', 'ct') => 'image')),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_elegant',
					'icon_pack' => 'elegant',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('elegant')
					),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_material',
					'icon_pack' => 'material',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('material')
					),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
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
					'heading' => __('Icon', 'ct'),
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
					'heading' => __('Image', 'ct'),
					'param_name' => 'image',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('image')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon Shape', 'ct'),
					'param_name' => 'icon_shape',
					'value' => array(__('Square', 'ct') => 'square', __('Circle', 'ct') => 'circle', __('Rhombus', 'ct') => 'romb', __('Hexagon', 'ct') => 'hexagon'),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon Style', 'ct'),
					'param_name' => 'icon_style',
					'value' => array(__('Default', 'ct') => '', __('45 degree Right', 'ct') => 'angle-45deg-r', __('45 degree Left', 'ct') => 'angle-45deg-l', __('90 degree', 'ct') => 'angle-90deg'),
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('elegant', 'material', 'fontawesome', 'userpack')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Icon Color', 'ct'),
					'param_name' => 'icon_color',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('elegant', 'material', 'fontawesome', 'userpack')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Icon Color 2', 'ct'),
					'param_name' => 'icon_color_2',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('elegant', 'material', 'fontawesome', 'userpack')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Icon Background Color', 'ct'),
					'param_name' => 'icon_background_color',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('elegant', 'material', 'fontawesome', 'userpack')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Icon Border Color', 'ct'),
					'param_name' => 'icon_border_color',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('elegant', 'material', 'fontawesome', 'userpack')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon Size', 'ct'),
					'param_name' => 'icon_size',
					'value' => array(__('Small', 'ct') => 'small', __('Medium', 'ct') => 'medium', __('Large', 'ct') => 'large', __('Extra Large', 'ct') => 'xlarge'),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Text Color', 'ct'),
					'param_name' => 'content_text_color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background Color', 'ct'),
					'param_name' => 'content_background_color',
					'std' => '#f4f6f7'
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Use Gradient Backgound', 'ct'),
					'param_name' => 'gradient_backgound',
					'value' => array(__('Yes', 'ct') => '1')
				),

				array(
					'type' => 'colorpicker',
					'heading' => __('From', 'ct'),
					'param_name' => 'gradient_backgound_from',
					'dependency' => array(
						'element' => 'gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('To', 'ct'),
					'param_name' => 'gradient_backgound_to',

					'dependency' => array(
						'element' => 'gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					"type" => "dropdown",
					'heading' => __('Style', 'ct'),
					'param_name' => 'gradient_backgound_style',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					"value" => array(
						__('Linear', "ct") => "linear",
						__('Radial', "ct") => "radial",
					) ,
					"std" => 'linear',
					'dependency' => array(
						'element' => 'gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					"type" => "dropdown",
					'heading' => __('Gradient Position', 'ct'),
					'param_name' => 'gradient_radial_backgound_position',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					"value" => array(
						__('Top', "ct") => "at top",
						__('Bottom', "ct") => "at bottom",
						__('Right', "ct") => "at right",
						__('Left', "ct") => "at left",
						__('Center', "ct") => "at center",

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
					'heading' => __('Custom Angle', 'ct'),
					'param_name' => 'gradient_backgound_angle',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					"value" => array(
						__('Vertical to bottom ↓', "ct") => "to bottom",
						__('Vertical to top ↑', "ct") => "to top",
						__('Horizontal to left  →', "ct") => "to right",
						__('Horizontal to right ←', "ct") => "to left",
						__('Diagonal from left to bottom ↘', "ct") => "to bottom right",
						__('Diagonal from left to top ↗', "ct") => "to top right",
						__('Diagonal from right to bottom ↙', "ct") => "to bottom left",
						__('Diagonal from right to top ↖', "ct") => "to top left",
						__('Custom', "ct") => "cusotom_deg",

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
					'heading' => __('Angle', 'ct'),
					'param_name' => 'gradient_backgound_cusotom_deg',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					'description' => __('Set value in DG 0-360', 'ct'),
					'dependency' => array(
						'element' => 'gradient_backgound_angle',
						'value' => array(
							'cusotom_deg',
						)
					)
				),
				array(
					'type' => 'attach_image',
					'heading' => __('Background Image', 'ct'),
					'param_name' => 'content_background_image',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Background style', 'ct'),
					'param_name' => 'content_background_style',
					'value' => array(
						__('Default', 'ct') => '',
						__('Cover', 'ct') => 'cover',
						__('Contain', 'ct') => 'contain',
						__('No Repeat', 'ct') => 'no-repeat',
						__('Repeat', 'ct') => 'repeat'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Background horizontal position', 'ct'),
					'param_name' => 'content_background_position_horizontal',
					'value' => array(
						__('Center', 'ct') => 'center',
						__('Left', 'ct') => 'left',
						__('Right', 'ct') => 'right'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Background vertical position', 'ct'),
					'param_name' => 'content_background_position_vertical',
					'value' => array(
						__('Top', 'ct') => 'top',
						__('Center', 'ct') => 'center',
						__('Bottom', 'ct') => 'bottom'
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Border Color', 'ct'),
					'param_name' => 'border_color',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Border Width (px)', 'ct'),
					'param_name' => 'border_width',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Border Radius (px)', 'ct'),
					'param_name' => 'border_radius',
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Rectangle Corner', 'ct'),
					'param_name' => 'rectangle_corner',
					'value' => array(
						__('Left Top', 'ct') => 'lt',
						__('Right Top', 'ct') => 'rt',
						__('Right Bottom', 'ct') => 'rb',
						__('Left Bottom', 'ct') => 'lb'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Top Arеа Style', 'ct'),
					'param_name' => 'top_style',
					'value' => array(
						__('Default', 'ct') => 'default',
						__('Flag', 'ct') => 'flag',
						__('Shield', 'ct') => 'shield',
						__('Ticket', 'ct') => 'ticket',
						__('Sentence', 'ct') => 'sentence',
						__('Note 1', 'ct') => 'note-1',
						__('Note 2', 'ct') => 'note-2',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Bottom Arеа Style', 'ct'),
					'param_name' => 'bottom_style',
					'value' => array(
						__('Default', 'ct') => 'default',
						__('Flag', 'ct') => 'flag',
						__('Shield', 'ct') => 'shield',
						__('Ticket', 'ct') => 'ticket',
						__('Sentence', 'ct') => 'sentence',
						__('Note 1', 'ct') => 'note-1',
						__('Note 2', 'ct') => 'note-2',
					),
				),

				array(
					'type' => 'textfield',
					'heading' => __('Button Text', 'ct'),
					'param_name' => 'button_1_text',
					'group' => __('Button 1', 'ct'),
				),
				array(
					'type' => 'vc_link',
					'heading' => __( 'URL (Link)', 'ct' ),
					'param_name' => 'button_1_link',
					'description' => __( 'Add link to button.', 'ct' ),
					'group' => __('Button 1', 'ct')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'button_1_style',
					'value' => array(__('Flat', 'ct') => 'flat', __('Outline', 'ct') => 'outline'),
					'group' => __('Button 1', 'ct')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Size', 'ct'),
					'param_name' => 'button_1_size',
					'value' => array(__('Tiny', 'ct') => 'tiny', __('Small', 'ct') => 'small', __('Medium', 'ct') => 'medium', __('Large', 'ct') => 'large', __('Giant', 'ct') => 'giant'),
					'std' => 'small',
					'group' => __('Button 1', 'ct')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Text weight', 'ct'),
					'param_name' => 'button_1_text_weight',
					'value' => array(__('Normal', 'ct') => 'normal', __('Thin', 'ct') => 'thin'),
					'group' => __('Button 1', 'ct')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('No uppercase', 'ct'),
					'param_name' => 'button_1_no_uppercase',
					'value' => array(__('Yes', 'ct') => '1'),
					'group' => __('Button 1', 'ct')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Border radius', 'ct'),
					'param_name' => 'button_1_corner',
					'value' => 3,
					'group' => __('Button 1', 'ct')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Border width', 'ct'),
					'param_name' => 'button_1_border',
					'value' => array(1, 2, 3, 4, 5, 6),
					'std' => 2,
					'dependency' => array(
						'element' => 'button_1_style',
						'value' => array('outline')
					),
					'group' => __('Button 1', 'ct')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Text color', 'ct'),
					'param_name' => 'button_1_text_color',
					'group' => __('Button 1', 'ct')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover text color', 'ct'),
					'param_name' => 'button_1_hover_text_color',
					'group' => __('Button 1', 'ct')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background color', 'ct'),
					'param_name' => 'button_1_background_color',
					'dependency' => array(
						'element' => 'button_1_style',
						'value' => array('flat')
					),
					'group' => __('Button 1', 'ct')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover background color', 'ct'),
					'param_name' => 'button_1_hover_background_color',
					'group' => __('Button 1', 'ct')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Border color', 'ct'),
					'param_name' => 'button_1_border_color',
					'dependency' => array(
						'element' => 'button_1_style',
						'value' => array('outline')
					),
					'group' => __('Button 1', 'ct')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover border color', 'ct'),
					'param_name' => 'button_1_hover_border_color',
					'dependency' => array(
						'element' => 'button_1_style',
						'value' => array('outline')
					),
					'group' => __('Button 1', 'ct')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Use Gradient Backgound Colors', 'ct'),
					'param_name' => 'button_1_gradient_backgound',
					'value' => array(__('Yes', 'ct') => '1'),
					'group' => __('Button 1', 'ct'),

				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background From', 'ct'),
					"edit_field_class" => "vc_col-sm-5 vc_column",
					'group' => __('Button 1', 'ct'),
					'param_name' => 'button_1_gradient_backgound_from',
					'dependency' => array(
						'element' => 'button_1_gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background To', 'ct'),
					"edit_field_class" => "vc_col-sm-5 vc_column",
					'group' => __('Button 1', 'ct'),
					'param_name' => 'button_1_gradient_backgound_to',
					'dependency' => array(
						'element' => 'button_1_gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover Background From', 'ct'),
					"edit_field_class" => "vc_col-sm-5 vc_column",
					'param_name' => 'button_1_gradient_backgound_hover_from',
					'group' => __('Button 1', 'ct'),
					'dependency' => array(
						'element' => 'button_1_gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover Background To', 'ct'),
					"edit_field_class" => "vc_col-sm-5 vc_column",
					'param_name' => 'button_1_gradient_backgound_hover_to',
					'group' => __('Button 1', 'ct'),
					'dependency' => array(
						'element' => 'button_1_gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					"type" => "dropdown",
					'heading' => __('Style', 'ct'),
					'param_name' => 'button_1_gradient_backgound_style',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					'group' => __('Button 1', 'ct'),
					"value" => array(
						__('Linear', "ct") => "linear",
						__('Radial', "ct") => "radial",
					) ,
					"std" => 'linear',
					'dependency' => array(
						'element' => 'button_1_gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					"type" => "dropdown",
					'heading' => __('Gradient Position', 'ct'),
					'param_name' => 'button_1_gradient_radial_backgound_position',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					'group' => __('Button 1', 'ct'),
					"value" => array(
						__('Top', "ct") => "at top",
						__('Bottom', "ct") => "at bottom",
						__('Right', "ct") => "at right",
						__('Left', "ct") => "at left",
						__('Center', "ct") => "at center",

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
					'heading' => __('Swap Colors', 'ct'),
					'param_name' => 'button_1_gradient_radial_swap_colors',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					'group' => __('Button 1', 'ct'),
					'value' => array(__('Yes', 'ct') => '1'),
					'dependency' => array(
						'element' => 'button_1_gradient_backgound_style',
						'value' => array(
							'radial',
						)
					)
				),


				array(
					"type" => "dropdown",
					'heading' => __('Custom Angle', 'ct'),
					'param_name' => 'button_1_gradient_backgound_angle',
					'group' => __('Button 1', 'ct'),
					"edit_field_class" => "vc_col-sm-4 vc_column",
					"value" => array(
						__('Vertical to bottom ↓', "ct") => "to bottom",
						__('Vertical to top ↑', "ct") => "to top",
						__('Horizontal to left  →', "ct") => "to right",
						__('Horizontal to right ←', "ct") => "to left",
						__('Diagonal from left to bottom ↘', "ct") => "to bottom right",
						__('Diagonal from left to top ↗', "ct") => "to top right",
						__('Diagonal from right to bottom ↙', "ct") => "to bottom left",
						__('Diagonal from right to top ↖', "ct") => "to top left",
						__('Custom', "ct") => "cusotom_deg",

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
					'heading' => __('Angle', 'ct'),
					'param_name' => 'button_1_gradient_backgound_cusotom_deg',
					'group' => __('Button 1', 'ct'),
					"edit_field_class" => "vc_col-sm-4 vc_column",
					'description' => __('Set value in DG 0-360', 'ct'),
					'dependency' => array(
						'element' => 'button_1_gradient_backgound_style',
						'value' => array(
							'cusotom_deg',
						)
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon pack', 'ct'),
					'param_name' => 'button_1_icon_pack',
					'value' => array_merge(array(__('Elegant', 'ct') => 'elegant', __('Material Design', 'ct') => 'material', __('FontAwesome', 'ct') => 'fontawesome'), ct_userpack_to_dropdown()),
					'std' => 2,
					'group' => __('Button 1', 'ct')
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'button_1_icon_elegant',
					'icon_pack' => 'elegant',
					'dependency' => array(
						'element' => 'button_1_icon_pack',
						'value' => array('elegant')
					),
					'group' => __('Button 1', 'ct')
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'button_1_icon_material',
					'icon_pack' => 'material',
					'dependency' => array(
						'element' => 'button_1_icon_pack',
						'value' => array('material')
					),
					'group' => __('Button 1', 'ct')
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'button_1_icon_fontawesome',
					'icon_pack' => 'fontawesome',
					'dependency' => array(
						'element' => 'button_1_icon_pack',
						'value' => array('fontawesome')
					),
					'group' => __('Button 1', 'ct')
				),
			),
			ct_userpack_to_shortcode(array(
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
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
					'heading' => __( 'Icon position', 'ct' ),
					'param_name' => 'button_1_icon_position',
					'value' => array(__( 'Left', 'ct' ) => 'left', __( 'Right', 'ct' ) => 'right'),
					'group' => __('Button 1', 'ct')
				),

				array(
					'type' => 'checkbox',
					'heading' => __('Activate Button', 'ct'),
					'param_name' => 'button_2_activate',
					'value' => array(__('Yes', 'ct') => '1'),
					'group' => __('Button 2', 'ct')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Button Text', 'ct'),
					'param_name' => 'button_2_text',
					'group' => __('Button 2', 'ct'),
					'dependency' => array(
						'element' => 'button_2_activate',
						'not_empty' => true
					),
				),
				array(
					'type' => 'vc_link',
					'heading' => __( 'URL (Link)', 'ct' ),
					'param_name' => 'button_2_link',
					'description' => __( 'Add link to button.', 'ct' ),
					'dependency' => array(
						'element' => 'button_2_activate',
						'not_empty' => true
					),
					'group' => __('Button 2', 'ct')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'button_2_style',
					'value' => array(__('Flat', 'ct') => 'flat', __('Outline', 'ct') => 'outline'),
					'dependency' => array(
						'element' => 'button_2_activate',
						'not_empty' => true
					),
					'group' => __('Button 2', 'ct')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Size', 'ct'),
					'param_name' => 'button_2_size',
					'value' => array(__('Tiny', 'ct') => 'tiny', __('Small', 'ct') => 'small', __('Medium', 'ct') => 'medium', __('Large', 'ct') => 'large', __('Giant', 'ct') => 'giant'),
					'std' => 'small',
					'dependency' => array(
						'element' => 'button_2_activate',
						'not_empty' => true
					),
					'group' => __('Button 2', 'ct')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Text weight', 'ct'),
					'param_name' => 'button_2_text_weight',
					'value' => array(__('Normal', 'ct') => 'normal', __('Thin', 'ct') => 'thin'),
					'dependency' => array(
						'element' => 'button_2_activate',
						'not_empty' => true
					),
					'group' => __('Button 2', 'ct')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('No uppercase', 'ct'),
					'param_name' => 'button_2_no_uppercase',
					'value' => array(__('Yes', 'ct') => '1'),
					'dependency' => array(
						'element' => 'button_2_activate',
						'not_empty' => true
					),
					'group' => __('Button 2', 'ct')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Border radius', 'ct'),
					'param_name' => 'button_2_corner',
					'value' => 3,
					'dependency' => array(
						'element' => 'button_2_activate',
						'not_empty' => true
					),
					'group' => __('Button 2', 'ct')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Border width', 'ct'),
					'param_name' => 'button_2_border',
					'value' => array(1, 2, 3, 4, 5, 6),
					'std' => 2,
					'dependency' => array(
						'element' => 'button_2_style',
						'value' => array('outline')
					),
					'group' => __('Button 2', 'ct')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Text color', 'ct'),
					'param_name' => 'button_2_text_color',
					'dependency' => array(
						'element' => 'button_2_activate',
						'not_empty' => true
					),
					'group' => __('Button 2', 'ct')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover text color', 'ct'),
					'param_name' => 'button_2_hover_text_color',
					'dependency' => array(
						'element' => 'button_2_activate',
						'not_empty' => true
					),
					'group' => __('Button 2', 'ct')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background color', 'ct'),
					'param_name' => 'button_2_background_color',
					'dependency' => array(
						'element' => 'button_2_style',
						'value' => array('flat')
					),
					'group' => __('Button 2', 'ct')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover background color', 'ct'),
					'param_name' => 'button_2_hover_background_color',
					'dependency' => array(
						'element' => 'button_2_activate',
						'not_empty' => true
					),
					'group' => __('Button 2', 'ct')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Border color', 'ct'),
					'param_name' => 'button_2_border_color',
					'dependency' => array(
						'element' => 'button_2_style',
						'value' => array('outline')
					),
					'group' => __('Button 2', 'ct')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover border color', 'ct'),
					'param_name' => 'button_2_hover_border_color',
					'dependency' => array(
						'element' => 'button_2_style',
						'value' => array('outline')
					),
					'group' => __('Button 2', 'ct')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Use Gradient Backgound Colors', 'ct'),
					'param_name' => 'button_2_gradient_backgound',
					'value' => array(__('Yes', 'ct') => '1'),
					'group' => __('Button 2', 'ct'),
					'dependency' => array(
						'element' => 'button_2_activate',
						'not_empty' => true
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background From', 'ct'),
					"edit_field_class" => "vc_col-sm-5 vc_column",
					'group' => __('Button 2', 'ct'),
					'param_name' => 'button_2_gradient_backgound_from',
					'dependency' => array(
						'element' => 'button_2_gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background To', 'ct'),
					"edit_field_class" => "vc_col-sm-5 vc_column",
					'group' => __('Button 2', 'ct'),
					'param_name' => 'button_2_gradient_backgound_to',
					'dependency' => array(
						'element' => 'button_2_gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover Background From', 'ct'),
					"edit_field_class" => "vc_col-sm-5 vc_column",
					'param_name' => 'button_2_gradient_backgound_hover_from',
					'group' => __('Button 2', 'ct'),
					'dependency' => array(
						'element' => 'button_2_gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover Background To', 'ct'),
					"edit_field_class" => "vc_col-sm-5 vc_column",
					'param_name' => 'button_2_gradient_backgound_hover_to',
					'group' => __('Button 2', 'ct'),
					'dependency' => array(
						'element' => 'button_2_gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					"type" => "dropdown",
					'heading' => __('Style', 'ct'),
					'param_name' => 'button_2_gradient_backgound_style',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					'group' => __('Button 2', 'ct'),
					"value" => array(
						__('Linear', "ct") => "linear",
						__('Radial', "ct") => "radial",
					) ,
					"std" => 'linear',
					'dependency' => array(
						'element' => 'button_2_gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					"type" => "dropdown",
					'heading' => __('Gradient Position', 'ct'),
					'param_name' => 'button_2_gradient_radial_backgound_position',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					'group' => __('Button 2', 'ct'),
					"value" => array(
						__('Top', "ct") => "at top",
						__('Bottom', "ct") => "at bottom",
						__('Right', "ct") => "at right",
						__('Left', "ct") => "at left",
						__('Center', "ct") => "at center",

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
					'heading' => __('Swap Colors', 'ct'),
					'param_name' => 'button_2_gradient_radial_swap_colors',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					'group' => __('Button 2', 'ct'),
					'value' => array(__('Yes', 'ct') => '1'),
					'dependency' => array(
						'element' => 'button_2_gradient_backgound_style',
						'value' => array(
							'radial',
						)
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon pack', 'ct'),
					'param_name' => 'button_2_icon_pack',
					'value' => array_merge(array(__('Elegant', 'ct') => 'elegant', __('Material Design', 'ct') => 'material', __('FontAwesome', 'ct') => 'fontawesome'), ct_userpack_to_dropdown()),
					'std' => 2,
					'dependency' => array(
						'element' => 'button_2_activate',
						'not_empty' => true
					),
					'group' => __('Button 2', 'ct')
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'button_2_icon_elegant',
					'icon_pack' => 'elegant',
					'dependency' => array(
						'element' => 'button_2_icon_pack',
						'value' => array('elegant')
					),
					'group' => __('Button 2', 'ct')
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'button_2_icon_material',
					'icon_pack' => 'material',
					'dependency' => array(
						'element' => 'button_2_icon_pack',
						'value' => array('material')
					),
					'group' => __('Button 2', 'ct')
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'button_2_icon_fontawesome',
					'icon_pack' => 'fontawesome',
					'dependency' => array(
						'element' => 'button_2_icon_pack',
						'value' => array('fontawesome')
					),
					'group' => __('Button 2', 'ct')
				),
			),
			ct_userpack_to_shortcode(array(
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
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
					'heading' => __( 'Icon position', 'ct' ),
					'param_name' => 'button_2_icon_position',
					'value' => array(__( 'Left', 'ct' ) => 'left', __( 'Right', 'ct' ) => 'right'),
					'dependency' => array(
						'element' => 'button_2_activate',
						'not_empty' => true
					),
					'group' => __('Button 2', 'ct')
				),

				array(
					'type' => 'checkbox',
					'heading' => __('Centered', 'ct'),
					'param_name' => 'centered',
					'value' => array(__('Yes', 'ct') => '1')
				),
			)),
		),

		'ct_button' => array(
			'name' => __('Button', 'ct'),
			'base' => 'ct_button',
			'icon' => 'ct-icon-wpb-ui-button',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Styled button element', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'textfield',
					'heading' => __('Button Text', 'ct'),
					'param_name' => 'text',
				),
				array(
					'type' => 'vc_link',
					'heading' => __( 'URL (Link)', 'ct' ),
					'param_name' => 'link',
					'description' => __( 'Add link to button.', 'ct' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Position', 'ct'),
					'param_name' => 'position',
					'value' => array(__('Inline', 'ct') => 'inline', __('Left', 'ct') => 'left', __('Right', 'ct') => 'right', __('Center', 'ct') => 'center', __('Fullwidth', 'ct') => 'fullwidth')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(__('Flat', 'ct') => 'flat', __('Outline', 'ct') => 'outline')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Size', 'ct'),
					'param_name' => 'size',
					'value' => array(__('Tiny', 'ct') => 'tiny', __('Small', 'ct') => 'small', __('Medium', 'ct') => 'medium', __('Large', 'ct') => 'large', __('Giant', 'ct') => 'giant'),
					'std' => 'small'
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Text weight', 'ct'),
					'param_name' => 'text_weight',
					'value' => array(__('Normal', 'ct') => 'normal', __('Thin', 'ct') => 'thin'),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('No uppercase', 'ct'),
					'param_name' => 'no_uppercase',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Border radius', 'ct'),
					'param_name' => 'corner',
					'value' => 3,
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Border width', 'ct'),
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
					'heading' => __('Text color', 'ct'),
					'param_name' => 'text_color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover text color', 'ct'),
					'param_name' => 'hover_text_color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background color', 'ct'),
					'param_name' => 'background_color',
					'dependency' => array(
						'element' => 'style',
						'value' => array('flat')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover background color', 'ct'),
					'param_name' => 'hover_background_color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Border color', 'ct'),
					'param_name' => 'border_color',
					'dependency' => array(
						'element' => 'style',
						'value' => array('outline')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover border color', 'ct'),
					'param_name' => 'hover_border_color',
					'dependency' => array(
						'element' => 'style',
						'value' => array('outline')
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Use Gradient Backgound Colors', 'ct'),
					'param_name' => 'gradient_backgound',
					'value' => array(__('Yes', 'ct') => '1')
				),

				array(
					'type' => 'colorpicker',
					'heading' => __('Background From', 'ct'),
					"edit_field_class" => "vc_col-sm-5 vc_column",
					'param_name' => 'gradient_backgound_from',
					'dependency' => array(
						'element' => 'gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background To', 'ct'),
					"edit_field_class" => "vc_col-sm-5 vc_column",
					'param_name' => 'gradient_backgound_to',
					'dependency' => array(
						'element' => 'gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover Background From', 'ct'),
					"edit_field_class" => "vc_col-sm-5 vc_column",
					'param_name' => 'gradient_backgound_hover_from',
					'dependency' => array(
						'element' => 'gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover Background To', 'ct'),
					"edit_field_class" => "vc_col-sm-5 vc_column",
					'param_name' => 'gradient_backgound_hover_to',
					'dependency' => array(
						'element' => 'gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					"type" => "dropdown",
					'heading' => __('Style', 'ct'),
					'param_name' => 'gradient_backgound_style',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					"value" => array(
						__('Linear', "ct") => "linear",
						__('Radial', "ct") => "radial",
					) ,
					"std" => 'linear',
					'dependency' => array(
						'element' => 'gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					"type" => "dropdown",
					'heading' => __('Gradient Position', 'ct'),
					'param_name' => 'gradient_radial_backgound_position',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					"value" => array(
						__('Top', "ct") => "at top",
						__('Bottom', "ct") => "at bottom",
						__('Right', "ct") => "at right",
						__('Left', "ct") => "at left",
						__('Center', "ct") => "at center",

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
					'heading' => __('Swap Colors', 'ct'),
					'param_name' => 'gradient_radial_swap_colors',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					'value' => array(__('Yes', 'ct') => '1'),
					'dependency' => array(
						'element' => 'gradient_backgound_style',
						'value' => array(
							'radial',
						)
					)
				),


				array(
					"type" => "dropdown",
					'heading' => __('Custom Angle', 'ct'),
					'param_name' => 'gradient_backgound_angle',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					"value" => array(
						__('Vertical to bottom ↓', "ct") => "to bottom",
						__('Vertical to top ↑', "ct") => "to top",
						__('Horizontal to left  →', "ct") => "to right",
						__('Horizontal to right ←', "ct") => "to left",
						__('Diagonal from left to bottom ↘', "ct") => "to bottom right",
						__('Diagonal from left to top ↗', "ct") => "to top right",
						__('Diagonal from right to bottom ↙', "ct") => "to bottom left",
						__('Diagonal from right to top ↖', "ct") => "to top left",
						__('Custom', "ct") => "cusotom_deg",

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
					'heading' => __('Angle', 'ct'),
					'param_name' => 'gradient_backgound_cusotom_deg',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					'description' => __('Set value in DG 0-360', 'ct'),
					'dependency' => array(
						'element' => 'gradient_backgound_angle',
						'value' => array(
							'cusotom_deg',
						)
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Separatot Style', 'ct'),
					'param_name' => 'separator',
					'value' => array(
						__('None', 'ct') => '',
						__('Single', 'ct') => 'single',
						__('Square', 'ct') => 'square',
						__('Soft Double', 'ct') => 'soft-double',
						__('Strong Double', 'ct') => 'strong-double'
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'ct' ),
					'param_name' => 'extra_class',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon pack', 'ct'),
					'param_name' => 'icon_pack',
					'value' => array_merge(array(__('Elegant', 'ct') => 'elegant', __('Material Design', 'ct') => 'material', __('FontAwesome', 'ct') => 'fontawesome'), ct_userpack_to_dropdown()),
					'std' => 2,
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_elegant',
					'icon_pack' => 'elegant',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('elegant')
					),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_material',
					'icon_pack' => 'material',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('material')
					),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
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
					'heading' => __('Icon', 'ct'),
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
					'heading' => __( 'Icon position', 'ct' ),
					'param_name' => 'icon_position',
					'value' => array(__( 'Left', 'ct' ) => 'left', __( 'Right', 'ct' ) => 'right'),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Lazy loading enabled', 'ct'),
					'param_name' => 'effects_enabled',
					'value' => array(__('Yes', 'ct') => '1')
				),
			)),
		),

		'ct_clients' => array(
			'name' => __('Clients', 'ct'),
			'base' => 'ct_clients',
			'icon' => 'ct-icon-wpb-ui-clients',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Clients overview inside content', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(__('Grid', 'ct') => 'grid', __('Carousel', 'ct') => 'carousel')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Clients Sets', 'ct'),
					'param_name' => 'set',
					'value' => ct_vc_get_terms('ct_clients_sets'),
					'group' =>__('Select Clients Sets', 'ct'),
					'edit_field_class' => 'ct-terms-checkboxes'
				),
				array(
					'type' => 'textfield',
					'heading' => __('Autoscroll', 'ct'),
					'param_name' => 'autoscroll',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Rows', 'ct'),
					'param_name' => 'rows',
					'value' => '3',
					'dependency' => array(
						'element' => 'style',
						'value' => array('grid')
					),
				),

				array(
					'type' => 'textfield',
					'heading' => __('Cols', 'ct'),
					'param_name' => 'cols',
					'value' => '3',
					'dependency' => array(
						'element' => 'style',
						'value' => array('grid')
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Fullwidth', 'ct'),
					'param_name' => 'fullwidth',
					'value' => array(__('Yes', 'ct') => '1'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('carousel')
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Lazy loading enabled', 'ct'),
					'param_name' => 'effects_enabled',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Disable grayscale', 'ct'),
					'param_name' => 'disable_grayscale',
					'value' => array(__('Yes', 'ct') => '1')
				),

			)),
		),

		'ct_countdown' => array(
			'name' => __( 'Countdown', 'ct' ),
			'base' => 'ct_countdown',
			'category' => __( 'Codex Themes', 'ct'),
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => __( 'Style', 'ct'),
					'param_name' => 'style',
					'value' => array(
						__('Boxes', 'ct') => 'style-3',
						__('Elegant', 'ct') => 'style-4',
						__('Cross', 'ct') => 'style-6',
						__('Days Only', 'ct') => 'style-7',
						__('Circles', 'ct') => 'style-5',
					),
				),
				array(
					'type' => 'ct_datepicker_param',
					'heading' => __( 'Start Event', 'ct' ),
					'description' => 'Date format : Day-Month-Year',
					'param_name' => 'start_eventdate',
					'dependency' => array(
						'element' => 'style',
						'value' => 'style-5',
					),
				),
				array(
					'type' => 'ct_datepicker_param',
					'heading' => __( 'Event Date', 'ct' ),
					'description' => 'Date format : Day-Month-Year',
					'param_name' => 'eventdate',
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Aligment', 'ct'),
					'param_name' => 'aligment',
					'value' => array( __('Left', 'ct') => 'align-left', __('Center', 'ct') => 'align-center', __('Right', 'ct') => 'align-right'),
					'dependency' => array(
						'element' => 'style',
						'value' => array(
							'style-4',
							'style-6',
							'style-7',
						)
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Numbers Weight', 'ct'),
					'param_name' => 'weight_number',
					'value' => array('Bold' => 8, 'Thin' => 4),
					'dependency' => array(
						'element' => 'style',
						'value' => 'style-5',
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __( 'Number color', 'ct' ),
					'param_name' => 'color_number',
					'dependency' => array(
						'element' => 'style',
						'value' => array(
							'style-3',
							'style-4',
							'style-6',
							'style-7',
						),
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __( 'Text color', 'ct' ),
					'param_name' => 'color_text',
					'dependency' => array(
						'element' => 'style',
						'value' => array(
							'style-3',
							'style-4',
							'style-5',
							'style-6',
							'style-7',
						),
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __( 'Border color', 'ct' ),
					'param_name' => 'color_border',
					'dependency' => array(
						'element' => 'style',
						'value' => array(
							'style-3',
							'style-4',
							'style-6',
						),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Countdown text', 'ct' ),
					'param_name' => 'countdown_text',
					'dependency' => array(
						'element' => 'style',
						'value' => 'style-7',
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background color', 'ct'),
					'param_name' => 'color_background',
					'dependency' => array(
						'element' => 'style',
						'value' => 'style-3',
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Color Days', 'ct'),
					'param_name' => 'color_days',
					'dependency' => array(
						'element' => 'style',
						'value' => 'style-5',
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Color Hours', 'ct'),
					'param_name' => 'color_hours',
					'dependency' => array(
						'element' => 'style',
						'value' => 'style-5',
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Color Minutes', 'ct'),
					'param_name' => 'color_minutes',
					'dependency' => array(
						'element' => 'style',
						'value' => 'style-5',
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Color Seconds', 'ct'),
					'param_name' => 'color_seconds',
					'dependency' => array(
						'element' => 'style',
						'value' => 'style-5',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'ct' ),
					'param_name' => 'extraclass',
				),
			)
		),

		'ct_counter' => array(
			'name' => __('Counter', 'ct'),
			'base' => 'ct_counter',
			'as_child' => array('only' => 'ct_counter_box'),
			'content_element' => true,
			'icon' => 'ct-icon-wpb-ui-counter',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Counter', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'textfield',
					'heading' => __('From', 'ct'),
					'param_name' => 'from',
				),
				array(
					'type' => 'textfield',
					'heading' => __('To', 'ct'),
					'param_name' => 'to',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Text', 'ct'),
					'param_name' => 'text',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Suffix', 'ct'),
					'param_name' => 'suffix',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background Color', 'ct'),
					'param_name' => 'background_color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Numbers Color', 'ct'),
					'param_name' => 'numbers_color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Text Color', 'ct'),
					'param_name' => 'text_color',
				),
				array(
					'type' => 'vc_link',
					'heading' => __( 'URL (Link)', 'ct' ),
					'param_name' => 'link',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon pack', 'ct'),
					'param_name' => 'icon_pack',
					'value' => array_merge(array(__('Elegant', 'ct') => 'elegant', __('Material Design', 'ct') => 'material', __('FontAwesome', 'ct') => 'fontawesome'), ct_userpack_to_dropdown()),
					'group' => __('Icon', 'ct')
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_elegant',
					'icon_pack' => 'elegant',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('elegant')
					),
					'group' => __('Icon', 'ct')
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_material',
					'icon_pack' => 'material',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('material')
					),
					'group' => __('Icon', 'ct')
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_fontawesome',
					'icon_pack' => 'fontawesome',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('fontawesome')
					),
					'group' => __('Icon', 'ct')
				),
			),
			ct_userpack_to_shortcode(array(
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
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
					'heading' => __('Icon Shape', 'ct'),
					'param_name' => 'icon_shape',
					'value' => array(__('Square', 'ct') => 'square', __('Circle', 'ct') => 'circle'),
					'group' => __('Icon', 'ct')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon Style', 'ct'),
					'param_name' => 'icon_style',
					'value' => array(__('Default', 'ct') => '', __('45 degree Right', 'ct') => 'angle-45deg-r', __('45 degree Left', 'ct') => 'angle-45deg-l', __('90 degree', 'ct') => 'angle-90deg'),
					'group' => __('Icon', 'ct')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Icon Color', 'ct'),
					'param_name' => 'icon_color',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'group' => __('Icon', 'ct')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Icon Color 2', 'ct'),
					'param_name' => 'icon_color_2',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'group' => __('Icon', 'ct')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Icon Background Color', 'ct'),
					'param_name' => 'icon_background_color',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'group' => __('Icon', 'ct')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Icon Border Color', 'ct'),
					'param_name' => 'icon_border_color',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'group' => __('Icon', 'ct')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon Size', 'ct'),
					'param_name' => 'icon_size',
					'value' => array(__('Small', 'ct') => 'small', __('Medium', 'ct') => 'medium', __('Large', 'ct') => 'large', __('Extra Large', 'ct') => 'xlarge'),
					'group' => __('Icon', 'ct')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Icon Color', 'ct'),
					'param_name' => 'hover_icon_color',
					'group' => __('Hover', 'ct'),
					'dependency' => array(
						'element' => 'link',
						'not_empty' => true
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background Color', 'ct'),
					'param_name' => 'hover_background_color',
					'group' => __('Hover', 'ct'),
					'dependency' => array(
						'element' => 'link',
						'not_empty' => true
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Numbers Color', 'ct'),
					'param_name' => 'hover_numbers_color',
					'group' => __('Hover', 'ct'),
					'dependency' => array(
						'element' => 'link',
						'not_empty' => true
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Text Color', 'ct'),
					'param_name' => 'hover_text_color',
					'group' => __('Hover', 'ct'),
					'dependency' => array(
						'element' => 'link',
						'not_empty' => true
					),
				),
			)),
		),

		'ct_counter_box' => array(
			'name' => __('Counter box', 'ct'),
			'base' => 'ct_counter_box',
			'is_container' => true,
			'js_view' => 'VcCTCounterBoxView',
			'as_parent' => array('only' => 'ct_counter'),
			'icon' => 'ct-icon-wpb-ui-counter-box',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Counter box', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(__('Style 1', 'ct') => '1', __('Style 2', 'ct') => '2', __('Vertical', 'ct') => 'vertical')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Columns', 'ct'),
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
					'heading' => __('Connector color', 'ct'),
					'param_name' => 'connector_color',
					'dependency' => array(
						'element' => 'style',
						'value' => array('vertical')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Team Person', 'ct'),
					'param_name' => 'team_person',
					'value' => ct_vc_get_team_persons(),
					'dependency' => array(
						'element' => 'style',
						'value' => array('vertical')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Team Person Image Size', 'ct'),
					'param_name' => 'team_image_size',
					'value' => array(__('Small', 'ct') => 'small', __('Medium', 'ct') => 'medium', __('Large', 'ct') => 'large', __('Extra Large', 'ct') => 'xlarge'),
					'dependency' => array(
						'element' => 'team_person',
						'not_empty' => true
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Lazy loading enabled', 'ct'),
					'param_name' => 'effects_enabled',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Number format', 'ct'),
					'param_name' => 'number_format',
					'std' => '(ddd).ddd',
					'description' => __('Example: (ddd).ddd -> 9999.99, ( ddd).ddd -> 9 999.99, (,ddd).ddd -> 9,999.99', 'ct')
				),
			)),
		),

		'ct_custom_header' => array(
			'name' => __('Custom Header', 'ct'),
			'base' => 'ct_custom_header',
			'is_container' => false,
			'js_view' => 'VcCTFullwidthView',
			'icon' => 'ct-icon-wpb-ui-header',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Custom Header', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'textarea_html',
					'heading' => __('Content', 'ct'),
					'param_name' => 'content',
					'value' => ''
				),
				array(
					'type' => 'textfield',
					'heading' => __('Title max width px', 'ct'),
					'param_name' => 'title_width',
					'value' => ''
				),
				array(
					'type' => 'textfield',
					'heading' => __('Title top margin', 'ct'),
					'param_name' => 'title_top_margin',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Title bottom margin', 'ct'),
					'param_name' => 'title_bottom_margin',
				),
				array(
					'type' => 'textarea',
					'heading' => __('Subtitle', 'ct'),
					'param_name' => 'subtitle',
					'value' => ''
				),
				array(
					'type' => 'textfield',
					'heading' => __('Subtitle max width px', 'ct'),
					'param_name' => 'subtitle_width',
					'value' => ''
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Subtitle color', 'ct'),
					'param_name' => 'subtitle_color',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon position', 'ct'),
					'param_name' => 'icon_position',
					'value' => array(
						__('Left', 'ct') => 'ct-custom-header-icon-position-left',
						__('Right', 'ct') => 'ct-custom-header-icon-position-right',
						__('No Display', 'ct') => 'ct-custom-header-no-icon',
						__('Centered', 'ct') => 'ct-custom-header-icon-position-centered'
					)
				),
				array(
					'type' => 'attach_image',
					'heading' => __('Background image', 'ct'),
					'param_name' => 'background_image',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Background style', 'ct'),
					'param_name' => 'background_style',
					'value' => array(
						__('Default', 'ct') => '',
						__('Cover', 'ct') => 'cover',
						__('Contain', 'ct') => 'contain',
						__('No Repeat', 'ct') => 'no-repeat',
						__('Repeat', 'ct') => 'repeat'
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Custom Header Background color', 'ct'),
					'param_name' => 'ch_background_color',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Background video type', 'ct'),
					'param_name' => 'video_background_type',
					'value' => array(
						__('None', 'ct') => '',
						__('YouTube', 'ct') => 'youtube',
						__('Vimeo', 'ct') => 'vimeo',
						__('Self', 'ct') => 'self'
					)
				),
				array(
					'type' => 'textfield',
					'heading' => __('Video id (YouTube or Vimeo) or src', 'ct'),
					'param_name' => 'video_background_src',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Video Aspect ratio (16:9, 16:10, 4:3...)', 'ct'),
					'param_name' => 'video_background_acpect_ratio',
					'value' => '16:9'
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background video overlay color', 'ct'),
					'param_name' => 'video_background_overlay_color',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Background video overlay opacity (0 - 1)', 'ct'),
					'param_name' => 'video_background_overlay_opacity',
				),
				array(
					'type' => 'attach_image',
					'heading' => __('Video Poster', 'ct'),
					'param_name' => 'video_background_poster',
					'dependency' => array(
						'element' => 'video_background_type',
						'value' => array('self')
					)
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Container', 'ct'),
					'param_name' => 'container',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Show Bread Crumbs', 'ct'),
					'param_name' => 'breadcrumbs',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Centreed Bread Crumbs', 'ct'),
					'param_name' => 'centreed_breadcrumbs',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon pack', 'ct'),
					'param_name' => 'pack',
					'value' => array_merge(array(__('Elegant', 'ct') => 'elegant', __('Material Design', 'ct') => 'material', __('FontAwesome', 'ct') => 'fontawesome'), ct_userpack_to_dropdown()),
					'std' => 2,
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_elegant',
					'icon_pack' => 'elegant',
					'dependency' => array(
						'element' => 'pack',
						'value' => array('elegant')
					),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_material',
					'icon_pack' => 'material',
					'dependency' => array(
						'element' => 'pack',
						'value' => array('material')
					),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_fontawesome',
					'icon_pack' => 'fontawesome',
					'dependency' => array(
						'element' => 'pack',
						'value' => array('fontawesome')
					),
				),
			),
			ct_userpack_to_shortcode(array(
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_userpack',
					'icon_pack' => 'userpack',
					'dependency' => array(
						'element' => 'pack',
						'value' => array('userpack')
					),
				),
			)),
			array(
				array(
					'type' => 'dropdown',
					'heading' => __('Shape', 'ct'),
					'param_name' => 'shape',
					'value' => array(__('None', 'ct') => 'none', __('Square', 'ct') => 'square', __('Circle', 'ct') => 'circle', __('Rhombus', 'ct') => 'romb', __('Hexagon', 'ct') => 'hexagon')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(__('Default', 'ct') => '', __('45 degree Right', 'ct') => 'angle-45deg-r', __('45 degree Left', 'ct') => 'angle-45deg-l', __('90 degree', 'ct') => 'angle-90deg')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Color', 'ct'),
					'param_name' => 'color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Color 2', 'ct'),
					'param_name' => 'color_2',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background Color', 'ct'),
					'param_name' => 'background_color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Border Color', 'ct'),
					'param_name' => 'border_color',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Opacity (0-1)', 'ct'),
					'param_name' => 'opacity',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Size', 'ct'),
					'param_name' => 'size',
					'value' => array(__('small', 'ct') => 'small', __('medium', 'ct') => 'medium', __('Large', 'ct') => 'large', __('Extra Large', 'ct') => 'xlarge')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Icon top margin', 'ct'),
					'param_name' => 'icon_top_margin',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Icon bottom margin', 'ct'),
					'param_name' => 'icon_bottom_margin',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Padding top', 'ct'),
					'param_name' => 'padding_top',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Padding bottom', 'ct'),
					'param_name' => 'padding_bottom',
				),
			)),
		),

		'ct_diagram' => array(
			'name' => __('Diagram', 'ct'),
			'base' => 'ct_diagram',
			'icon' => 'ct-icon-wpb-ui-diagram',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Styled diagrams and graphs', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'textfield',
					'heading' => __('title', 'ct'),
					'param_name' => 'title',
				),
				array(
					'type' => 'textfield',
					'heading' => __('summary', 'ct'),
					'param_name' => 'summary',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('type', 'ct'),
					'param_name' => 'type',
					'value' => array(__('circle', 'ct') => 'circle', __('line', 'ct') => 'line')
				),
				array(
					'type' => 'textarea',
					'heading' => __('Content', 'ct'),
					'param_name' => 'content',
					'value' => '[ct_skill title="Skill1" amount="70" color="#ff0000"]'."\n".
						'[ct_skill title="Skill2" amount="70" color="#ffff00"]'."\n".
						'[ct_skill title="Skill3" amount="70" color="#ff00ff"]'."\n".
						'[ct_skill title="Skill4" amount="70" color="#f0f0f0"]'
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Lazy loading enabled', 'ct'),
					'param_name' => 'effects_enabled',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(
						__('style-1', 'ct') => 'style-1',
						__('style-2', 'ct') => 'style-2',
						__('style-3', 'ct') => 'style-3'
					)
				),
			)),
		),

		'ct_divider' => array(
			'name' => __('Divider', 'ct'),
			'base' => 'ct_divider',
			'icon' => 'ct-icon-wpb-ui-divider',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Horizontal separator in different styles', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(
						__('1px', 'ct') => '',
						__('stroked', 'ct') => 1,
						__('3px', 'ct') => 2,
						__('7px', 'ct') => 3,
						__('dotted', 'ct') => 4,
						__('dashed', 'ct') => 5,
						__('zigzag', 'ct') => 6,
						__('wave', 'ct') => 7
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Color', 'ct'),
					'param_name' => 'color',
					/*'value' => ct_get_option('divider_default_color') ? ct_get_option('divider_default_color') : ''*/
				),
				array(
					'type' => 'textfield',
					'heading' => __('Margin top', 'ct'),
					'param_name' => 'margin_top',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Margin bottom', 'ct'),
					'param_name' => 'margin_bottom',
					/*'value' => '27'*/
				),
				array(
					'type' => 'textfield',
					'heading' => __('Width (px)', 'ct'),
					'param_name' => 'width',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Extra class name', 'ct'),
					'param_name' => 'class_name',
				),

			)),
		),

		'ct_dropcap' => array(
			'name' => __('Dropcap', 'ct'),
			'base' => 'ct_dropcap',
			'icon' => 'ct-icon-wpb-ui-dropcap',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Dropcap symbol for text content', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'textfield',
					'heading' => __('letter', 'ct'),
					'param_name' => 'letter',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Shape', 'ct'),
					'param_name' => 'shape',
					'value' => array(__('square', 'ct') => 'square', __('circle', 'ct') => 'circle', __('hexagon', 'ct') => 'hexagon')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(__('Medium', 'ct') => 'medium', __('Big', 'ct') => 'big')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Color', 'ct'),
					'param_name' => 'color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background Color', 'ct'),
					'param_name' => 'background_color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Border Color', 'ct'),
					'param_name' => 'border_color',
				),
			)),
		),

		'ct_fullwidth' => array(
			'name' => __('Fullwidth Container', 'ct'),
			'base' => 'ct_fullwidth',
			'is_container' => true,
			'js_view' => 'VcCTFullwidthView',
			'icon' => 'ct-icon-wpb-ui-fullwidth',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Fullwidth', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'colorpicker',
					'heading' => __('Color', 'ct'),
					'param_name' => 'color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background Color', 'ct'),
					'param_name' => 'background_color',
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Use Gradient Backgound', 'ct'),
					'param_name' => 'gradient_backgound',
					'value' => array(__('Yes', 'ct') => '1')
				),

				array(
					'type' => 'colorpicker',
					'heading' => __('From', 'ct'),
					'param_name' => 'gradient_backgound_from',
					'dependency' => array(
						'element' => 'gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('To', 'ct'),
					'param_name' => 'gradient_backgound_to',

					'dependency' => array(
						'element' => 'gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					"type" => "dropdown",
					'heading' => __('Style', 'ct'),
					'param_name' => 'gradient_backgound_style',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					"value" => array(
						__('Linear', "ct") => "linear",
						__('Radial', "ct") => "radial",
					) ,
					"std" => 'linear',
					'dependency' => array(
						'element' => 'gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					"type" => "dropdown",
					'heading' => __('Gradient Position', 'ct'),
					'param_name' => 'gradient_radial_backgound_position',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					"value" => array(
						__('Top', "ct") => "at top",
						__('Bottom', "ct") => "at bottom",
						__('Right', "ct") => "at right",
						__('Left', "ct") => "at left",
						__('Center', "ct") => "at center",

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
					'heading' => __('Custom Angle', 'ct'),
					'param_name' => 'gradient_backgound_angle',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					"value" => array(
						__('Vertical to bottom ↓', "ct") => "to bottom",
						__('Vertical to top ↑', "ct") => "to top",
						__('Horizontal to left  →', "ct") => "to right",
						__('Horizontal to right ←', "ct") => "to left",
						__('Diagonal from left to bottom ↘', "ct") => "to bottom right",
						__('Diagonal from left to top ↗', "ct") => "to top right",
						__('Diagonal from right to bottom ↙', "ct") => "to bottom left",
						__('Diagonal from right to top ↖', "ct") => "to top left",
						__('Custom', "ct") => "cusotom_deg",

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
					'heading' => __('Angle', 'ct'),
					'param_name' => 'gradient_backgound_cusotom_deg',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					'description' => __('Set value in DG 0-360', 'ct'),
					'dependency' => array(
						'element' => 'gradient_backgound_angle',
						'value' => array(
							'cusotom_deg',
						)
					)
				),
				array(
					'type' => 'attach_image',
					'heading' => __('Background image', 'ct'),
					'param_name' => 'background_image',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Background style', 'ct'),
					'param_name' => 'background_style',
					'value' => array(
						__('Default', 'ct') => '',
						__('Cover', 'ct') => 'cover',
						__('Contain', 'ct') => 'contain',
						__('No Repeat', 'ct') => 'no-repeat',
						__('Repeat', 'ct') => 'repeat'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Background horizontal position', 'ct'),
					'param_name' => 'background_position_horizontal',
					'value' => array(
						__('Center', 'ct') => 'center',
						__('Left', 'ct') => 'left',
						__('Right', 'ct') => 'right'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Background vertical position', 'ct'),
					'param_name' => 'background_position_vertical',
					'value' => array(
						__('Top', 'ct') => 'top',
						__('Center', 'ct') => 'center',
						__('Bottom', 'ct') => 'bottom'
					)
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Parallax', 'ct'),
					'param_name' => 'background_parallax',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Enable Parallax on Mobiles', 'ct'),
					'param_name' => 'background_parallax_mobile',
					'value' => array(__('Yes', 'ct') => '1'),
					'dependency' => array(
						'element' => 'background_parallax',
						'value' => array('1')
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Parallax type', 'ct'),
					'param_name' => 'background_parallax_type',
					'value' => array(
						__('Vertical', 'ct') => 'vertical',
						__('Horizontal', 'ct') => 'horizontal',
						__('Fixed', 'ct') => 'fixed'
					),
					'dependency' => array(
						'element' => 'background_parallax',
						'value' => array('1')
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Parallax overlay color', 'ct'),
					'param_name' => 'background_parallax_overlay_color',
					'dependency' => array(
						'element' => 'background_parallax',
						'value' => array('1')
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Background video type', 'ct'),
					'param_name' => 'video_background_type',
					'value' => array(
						__('None', 'ct') => '',
						__('YouTube', 'ct') => 'youtube',
						__('Vimeo', 'ct') => 'vimeo',
						__('Self', 'ct') => 'self'
					)
				),
				array(
					'type' => 'textfield',
					'heading' => __('Video id (YouTube or Vimeo) or src', 'ct'),
					'param_name' => 'video_background_src',
					'value' => ''
				),
				array(
					'type' => 'textfield',
					'heading' => __('Video Aspect ratio (16:9, 16:10, 4:3...)', 'ct'),
					'param_name' => 'video_background_acpect_ratio',
					'value' => '16:9'
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background video overlay color', 'ct'),
					'param_name' => 'video_background_overlay_color',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Background video overlay opacity (0 - 1)', 'ct'),
					'param_name' => 'video_background_overlay_opacity',
				),
				array(
					'type' => 'attach_image',
					'heading' => __('Video Poster', 'ct'),
					'param_name' => 'video_background_poster',
					'dependency' => array(
						'element' => 'video_background_type',
						'value' => array('self')
					)
				),
				array(
					'type' => 'textfield',
					'heading' => __('Padding top', 'ct'),
					'param_name' => 'padding_top',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Padding bottom', 'ct'),
					'param_name' => 'padding_bottom',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Padding left', 'ct'),
					'param_name' => 'padding_left',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Padding right', 'ct'),
					'param_name' => 'padding_right',
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Container', 'ct'),
					'param_name' => 'container',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Top Styled Marker Style', 'ct'),
					'param_name' => 'styled_marker_top_style',
					'value' => array(__('None', 'ct') => '', __('Triangle', 'ct') => 'triangle', __('Figure', 'ct') => 'figure', __('Wave', 'ct') => 'wave')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Top Styled Marker Direction', 'ct'),
					'param_name' => 'styled_marker_top_direction',
					'value' => array(__('Inside', 'ct') => 'inside', __('Outside', 'ct') => 'outside'),
					'dependency' => array(
						'element' => 'styled_marker_top_style',
						'value' => array('triangle', 'figure')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Bottom Styled Marker Style', 'ct'),
					'param_name' => 'styled_marker_bottom_style',
					'value' => array(__('None', 'ct') => '', __('Triangle', 'ct') => 'triangle', __('Figure', 'ct') => 'figure', __('Wave', 'ct') => 'wave')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Bottom Styled Marker Direction', 'ct'),
					'param_name' => 'styled_marker_bottom_direction',
					'value' => array(__('Inside', 'ct') => 'inside', __('Outside', 'ct') => 'outside'),
					'dependency' => array(
						'element' => 'styled_marker_bottom_style',
						'value' => array('triangle', 'figure')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Z-Index', 'ct'),
					'param_name' => 'z_index',
					'value' => array('auto',0,1,2,3,4,5,6,7,8,9,10)
				),
			)),
		),

		'ct_icon' => array(
			'name' => __('Icon', 'ct'),
			'base' => 'ct_icon',
			'icon' => 'ct-icon-wpb-ui-icon',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Customizable Font Icon', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Icon pack', 'ct'),
					'param_name' => 'pack',
					'value' => array_merge(array(__('Elegant', 'ct') => 'elegant', __('Material Design', 'ct') => 'material', __('FontAwesome', 'ct') => 'fontawesome'), ct_userpack_to_dropdown()),
					'std' => 2,
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_elegant',
					'icon_pack' => 'elegant',
					'dependency' => array(
						'element' => 'pack',
						'value' => array('elegant')
					),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_material',
					'icon_pack' => 'material',
					'dependency' => array(
						'element' => 'pack',
						'value' => array('material')
					),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_fontawesome',
					'icon_pack' => 'fontawesome',
					'dependency' => array(
						'element' => 'pack',
						'value' => array('fontawesome')
					),
				),
			),
			ct_userpack_to_shortcode(array(
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_userpack',
					'icon_pack' => 'userpack',
					'dependency' => array(
						'element' => 'pack',
						'value' => array('userpack')
					),
				),
			)),
			array(
				array(
					'type' => 'dropdown',
					'heading' => __('Shape', 'ct'),
					'param_name' => 'shape',
					'value' => array(__('Square', 'ct') => 'square', __('Circle', 'ct') => 'circle', __('Rhombus', 'ct') => 'romb', __('Hexagon', 'ct') => 'hexagon')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(__('Default', 'ct') => '', __('45 degree Right', 'ct') => 'angle-45deg-r', __('45 degree Left', 'ct') => 'angle-45deg-l', __('90 degree', 'ct') => 'angle-90deg')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Color', 'ct'),
					'param_name' => 'color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Color 2', 'ct'),
					'param_name' => 'color_2',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background Color', 'ct'),
					'param_name' => 'background_color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Border Color', 'ct'),
					'param_name' => 'border_color',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Size', 'ct'),
					'param_name' => 'size',
					'value' => array(__('small', 'ct') => 'small', __('medium', 'ct') => 'medium', __('Large', 'ct') => 'large', __('Extra Large', 'ct') => 'xlarge')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Link', 'ct'),
					'param_name' => 'link',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Link target', 'ct'),
					'param_name' => 'link_target',
					'value' => array(__('Self', 'ct') => '_self', __('Blank', 'ct') => '_blank')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Centered', 'ct'),
					'param_name' => 'centered',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Icon top margin', 'ct'),
					'param_name' => 'icon_top_margin',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Icon bottom margin', 'ct'),
					'param_name' => 'icon_bottom_margin',
				),
			)),
		),

		'ct_icon_with_text' => array(
			'name' => __('Icon with text', 'ct'),
			'base' => 'ct_icon_with_text',
			'is_container' => true,
			'js_view' => 'VcCTIconWithTextView',
			'icon' => 'ct-icon-wpb-ui-icon_with_text',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Font Icon with aligned text content', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Icon pack', 'ct'),
					'param_name' => 'icon_pack',
					'value' => array_merge(array(__('Elegant', 'ct') => 'elegant', __('Material Design', 'ct') => 'material', __('FontAwesome', 'ct') => 'fontawesome'), ct_userpack_to_dropdown()),
					'std' => 2,
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_elegant',
					'icon_pack' => 'elegant',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('elegant')
					),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_material',
					'icon_pack' => 'material',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('material')
					),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
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
					'heading' => __('Icon', 'ct'),
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
					'heading' => __('Shape', 'ct'),
					'param_name' => 'icon_shape',
					'value' => array(__('Square', 'ct') => 'square', __('Circle', 'ct') => 'circle', __('Rhombus', 'ct') => 'romb', __('Hexagon', 'ct') => 'hexagon')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon style', 'ct'),
					'param_name' => 'icon_style',
					'value' => array(__('Default', 'ct') => '', __('45 degree Right', 'ct') => 'angle-45deg-r', __('45 degree Left', 'ct') => 'angle-45deg-l', __('90 degree', 'ct') => 'angle-90deg')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('color', 'ct'),
					'param_name' => 'icon_color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('color 2', 'ct'),
					'param_name' => 'icon_color_2',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background Color', 'ct'),
					'param_name' => 'icon_background_color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Border Color', 'ct'),
					'param_name' => 'icon_border_color',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Size', 'ct'),
					'param_name' => 'icon_size',
					'value' =>  array(__('small', 'ct') => 'small', __('medium', 'ct') => 'medium', __('Large', 'ct') => 'large', __('Extra Large', 'ct') => 'xlarge')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Flow', 'ct'),
					'param_name' => 'flow',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Centered', 'ct'),
					'param_name' => 'centered',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Float right icon', 'ct'),
					'param_name' => 'float_right',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Icon top padding', 'ct'),
					'param_name' => 'icon_top_side_padding',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Icon right padding', 'ct'),
					'param_name' => 'icon_right_side_padding',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Icon bottom padding', 'ct'),
					'param_name' => 'icon_bottom_side_padding',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Icon left padding', 'ct'),
					'param_name' => 'icon_left_side_padding',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Icon top margin', 'ct'),
					'param_name' => 'icon_top_margin',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Icon bottom margin', 'ct'),
					'param_name' => 'icon_bottom_margin',
				),

			)),
		),

		'ct_icon_with_title' => array(
			'name' => __('Icon with Title', 'ct'),
			'base' => 'ct_icon_with_title',
			'icon' => 'ct-icon-wpb-ui-iconed_title',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Title with customizable font icon', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Icon pack', 'ct'),
					'param_name' => 'icon_pack',
					'value' => array_merge(array(__('Elegant', 'ct') => 'elegant', __('Material Design', 'ct') => 'material', __('FontAwesome', 'ct') => 'fontawesome'), ct_userpack_to_dropdown()),
					'std' => 2,
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_elegant',
					'icon_pack' => 'elegant',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('elegant')
					),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_material',
					'icon_pack' => 'material',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('material')
					),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
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
					'heading' => __('Icon', 'ct'),
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
					'heading' => __('Shape', 'ct'),
					'param_name' => 'icon_shape',
					'value' => array(__('square', 'ct') => 'square', __('circle', 'ct') => 'circle', __('romb', 'ct') => 'romb')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'icon_style',
					'value' => array(__('Default', 'ct') => '', __('45 degree Right', 'ct') => 'angle-45deg-r', __('45 degree Left', 'ct') => 'angle-45deg-l', __('90 degree', 'ct') => 'angle-90deg')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Color', 'ct'),
					'param_name' => 'icon_color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Color 2', 'ct'),
					'param_name' => 'icon_color_2',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background Color', 'ct'),
					'param_name' => 'icon_background_color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Border Color', 'ct'),
					'param_name' => 'icon_border_color',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Size', 'ct'),
					'param_name' => 'icon_size',
					'value' =>  array(__('small', 'ct') => 'small', __('medium', 'ct') => 'medium', __('Large', 'ct') => 'large', __('Extra Large', 'ct') => 'xlarge')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Title', 'ct'),
					'param_name' => 'title',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Title color', 'ct'),
					'param_name' => 'title_color',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Level', 'ct'),
					'param_name' => 'level',
					'value' => array(__('h1', 'ct') => 'h1', __('h2', 'ct') => 'h2', __('h3', 'ct') => 'h3', __('h4', 'ct') => 'h4', __('h5', 'ct') => 'h5', __('h6', 'ct') => 'h6')
				),
			)),
		),

		'ct_map_with_text' => array(
			'name' => __('Map with Text', 'ct'),
			'base' => 'ct_map_with_text',
			'is_container' => true,
			'js_view' => 'VcCTMapWithTextView',
			'icon' => 'ct-icon-wpb-ui-map-with-text',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Map with Text', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'colorpicker',
					'heading' => __('Background color', 'ct'),
					'param_name' => 'background_color',
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Map height', 'ct' ),
					'param_name' => 'size',
					'admin_label' => true,
					'description' => __( 'Enter map height in pixels. Example: 200 or leave it empty to make map responsive.', 'ct' )
				),
				array(
					'type' => 'textarea_safe',
					'heading' => __( 'Map embed iframe', 'ct' ),
					'param_name' => 'link',
					'description' => sprintf( __( 'Visit <a href="%s" target="_blank">Google maps</a> to create your map. 1) Find location 2) Click "Share" and make sure map is public on the web 3) Click folder icon to reveal "Embed on my site" link 4) Copy iframe code and paste it here.', 'ct' ), 'https://www.google.com/maps/d/')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Grayscale', 'ct'),
					'param_name' => 'grayscale',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Container', 'ct'),
					'param_name' => 'container',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Deactivate Map Zoom By Scrolling', 'ct'),
					'param_name' => 'disable_scroll',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Rounded Corners', 'ct'),
					'param_name' => 'rounded_corners',
					'value' => array(__('Yes', 'ct') => '1')
				),
			)),
		),

		'ct_news' => array(
			'name' => __('News & Blog', 'ct'),
			'base' => 'ct_news',
			'icon' => 'ct-icon-wpb-ui-news',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('News List', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'checkbox',
					'heading' => __('Post types', 'ct'),
					'param_name' => 'post_types',
					'value' => array(__('Post', 'ct') => 'post', __('News', 'ct') => 'ct_news')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(
						__('Default', 'ct') => 'default',
						__('Timeline', 'ct') => 'timeline',
						__('Timeline Fullwidth', 'ct') => 'timeline_new',
						__('Masonry 3x', 'ct') => '3x',
						__('Masonry 4x', 'ct') => '4x',
						__('100% width', 'ct') => '100%',
						__('Justified 3x', 'ct') => 'justified-3x',
						__('Justified 4x', 'ct') => 'justified-4x',
						__('Styled List 1', 'ct') => 'styled_list1',
						__('Styled List 2', 'ct') => 'styled_list2',
						__('Multi Author List', 'ct') => 'multi-author',
						__('Carousel', 'ct') => 'grid_carousel',
						__('Compact List', 'ct') => 'compact',
						__('Slider', 'ct') => 'slider',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Justified Style', 'ct'),
					'param_name' => 'justified_style',
					'value' => array(
						__('Style 1', 'ct') => 'justified-style-1',
						__('Style 2', 'ct') => 'justified-style-2',
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array('justified-3x', 'justified-4x'),
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Slider Style', 'ct'),
					'param_name' => 'slider_style',
					'value' => array(
						__('Fullwidth', 'ct') => 'fullwidth',
						__('Halfwidth', 'ct') => 'halfwidth',
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array('slider'),
					)
				),
				array(
					'type' => 'textfield',
					'heading' => __('Autoscroll', 'ct'),
					'param_name' => 'slider_autoscroll',
					'dependency' => array(
						'element' => 'style',
						'value' => array('slider'),
					)
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Categories', 'ct'),
					'param_name' => 'categories',
					'value' => ct_vc_get_blog_categories(),
					'group' =>__('Select Categories', 'ct'),
					'edit_field_class' => 'ct-terms-checkboxes'
				),
				array(
					'type' => 'textfield',
					'heading' => __('Post per page', 'ct'),
					'param_name' => 'post_per_page',
					'value' => '5'
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Pagination', 'ct'),
					'param_name' => 'post_pagination',
					'value' => array(
						__('Normal', 'ct') => 'normal',
						__('Load More', 'ct') => 'more',
						__('Infinite Scroll', 'ct') => 'scroll',
						__('Disable pagination', 'ct') => 'disable',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Loading animation', 'ct'),
					'param_name' => 'loading_animation',
					'std' => 'move-up',
					'value' => array(__('Disabled', 'ct') => 'disabled', __('Bounce', 'ct') => 'bounce', __('Move Up', 'ct') => 'move-up', __('Fade In', 'ct') => 'fade-in', __('Fall Perspective', 'ct') => 'fall-perspective', __('Scale', 'ct') => 'scale', __('Flip', 'ct') => 'flip'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('default', 'timeline', 'timeline_new', '3x', '4x', '100%', 'justified-3x', 'justified-4x', 'styled_list1', 'styled_list2', 'multi-author', 'compact')
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Ignore Sticky Posts', 'ct'),
					'param_name' => 'ignore_sticky',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Hide date in title', 'ct'),
					'param_name' => 'hide_date',
					'value' => array(__('Yes', 'ct') => '1'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('default', 'timeline', '3x', '4x', 'justified-3x', 'justified-4x', 'compact', 'slider')
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Hide author', 'ct'),
					'param_name' => 'hide_author',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Hide comments', 'ct'),
					'param_name' => 'hide_comments',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Hide likes', 'ct'),
					'param_name' => 'hide_likes',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Lazy loading enabled', 'ct'),
					'param_name' => 'effects_enabled',
					'value' => array(__('Yes', 'ct') => '1'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('grid_carousel')
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Lazy loading enabled', 'ct'),
					'param_name' => 'effects_enabled',
					'value' => array(__('Yes', 'ct') => '1'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('grid_carousel')
					),
				),

				array(
					'type' => 'textfield',
					'heading' => __('Button Text', 'ct'),
					'param_name' => 'button_text',
					'group' => __('Load More Button', 'ct'),
					'std' => __('Load More', 'ct'),
					'dependency' => array(
						'element' => 'post_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'button_style',
					'value' => array(__('Flat', 'ct') => 'flat', __('Outline', 'ct') => 'outline'),
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'post_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Size', 'ct'),
					'param_name' => 'button_size',
					'value' => array(__('Tiny', 'ct') => 'tiny', __('Small', 'ct') => 'small', __('Medium', 'ct') => 'medium', __('Large', 'ct') => 'large', __('Giant', 'ct') => 'giant'),
					'std' => 'medium',
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'post_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Text weight', 'ct'),
					'param_name' => 'button_text_weight',
					'value' => array(__('Normal', 'ct') => 'normal', __('Thin', 'ct') => 'thin'),
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'post_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('No uppercase', 'ct'),
					'param_name' => 'button_no_uppercase',
					'value' => array(__('Yes', 'ct') => '1'),
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'post_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Border radius', 'ct'),
					'param_name' => 'button_corner',
					'std' => 25,
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'post_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Border width', 'ct'),
					'param_name' => 'button_border',
					'value' => array(1, 2, 3, 4, 5, 6),
					'std' => 2,
					'dependency' => array(
						'element' => 'button_style',
						'value' => array('outline')
					),
					'group' => __('Load More Button', 'ct'),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Text color', 'ct'),
					'param_name' => 'button_text_color',
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'post_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover text color', 'ct'),
					'param_name' => 'button_hover_text_color',
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'post_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background color', 'ct'),
					'param_name' => 'button_background_color',
					'dependency' => array(
						'element' => 'button_style',
						'value' => array('flat')
					),
					'std' => '#00bcd5',
					'group' => __('Load More Button', 'ct'),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover background color', 'ct'),
					'param_name' => 'button_hover_background_color',
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'post_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Border color', 'ct'),
					'param_name' => 'button_border_color',
					'dependency' => array(
						'element' => 'button_style',
						'value' => array('outline')
					),
					'group' => __('Load More Button', 'ct'),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover border color', 'ct'),
					'param_name' => 'button_hover_border_color',
					'dependency' => array(
						'element' => 'button_style',
						'value' => array('outline')
					),
					'group' => __('Load More Button', 'ct'),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon pack', 'ct'),
					'param_name' => 'button_icon_pack',
					'value' => array_merge(array(__('Elegant', 'ct') => 'elegant', __('Material Design', 'ct') => 'material', __('FontAwesome', 'ct') => 'fontawesome'), ct_userpack_to_dropdown()),
					'std' => 2,
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'post_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'button_icon_elegant',
					'icon_pack' => 'elegant',
					'dependency' => array(
						'element' => 'button_icon_pack',
						'value' => array('elegant')
					),
					'group' => __('Load More Button', 'ct'),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'button_icon_material',
					'icon_pack' => 'material',
					'dependency' => array(
						'element' => 'button_icon_pack',
						'value' => array('material')
					),
					'group' => __('Load More Button', 'ct'),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'button_icon_fontawesome',
					'icon_pack' => 'fontawesome',
					'dependency' => array(
						'element' => 'button_icon_pack',
						'value' => array('fontawesome')
					),
					'group' => __('Load More Button', 'ct'),
				),
			),
			ct_userpack_to_shortcode(array(
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'button_icon_userpack',
					'icon_pack' => 'userpack',
					'dependency' => array(
						'element' => 'button_icon_pack',
						'value' => array('userpack')
					),
				),
			)),
			array(
				array(
					'type' => 'dropdown',
					'heading' => __( 'Icon position', 'ct' ),
					'param_name' => 'button_icon_position',
					'value' => array(__( 'Left', 'ct' ) => 'left', __( 'Right', 'ct' ) => 'right'),
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'post_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Separatot Style', 'ct'),
					'param_name' => 'button_separator',
					'value' => array(
						__('None', 'ct') => '',
						__('Single', 'ct') => 'single',
						__('Square', 'ct') => 'square',
						__('Soft Double', 'ct') => 'soft-double',
						__('Strong Double', 'ct') => 'strong-double',
						__('Load More', 'ct') => 'load-more'
					),
					'std' => 'load-more',
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'post_pagination',
						'value' => array('more')
					),
				),
			)),
		),

		'ct_project_info' => array(
			'name' => __('Project info', 'ct'),
			'base' => 'ct_project_info',
			'is_container' => false,
			'icon' => 'ct-icon-wpb-ui-project',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Project info', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(
						__('Style 1', 'ct') => '1',
						__('Style 2', 'ct') => '2',
					)
				),
				array(
					'type' => 'param_group',
					'heading' => __( 'Values', 'js_composer' ),
					'param_name' => 'values',
					'value' => urlencode( json_encode( array(
								array(
									'title' => __( 'Element', 'js_composer' ),
									'decription' => '',
									'icon' => '',
									'pack' => 'elegant',
									'icon_color' => '',
								),
								array(
									'title' => __( 'Element', 'js_composer' ),
									'value' => '',
									'icon' => '',
									'pack' => 'elegant',
									'icon_color' => '',
								),
							)
						)
					),
					'params' => array_merge(array(
						array(
							'type' => 'textfield',
							'heading' => __( 'Title', 'js_composer' ),
							'param_name' => 'title',
							'admin_label' => true,
						),
						array(
							'type' => 'textfield',
							'heading' => __( 'Decription', 'js_composer' ),
							'param_name' => 'decription',
						),
						array(
							'type' => 'dropdown',
							'heading' => __('Icon pack', 'ct'),
							'param_name' => 'pack',
							'value' => array_merge(array(__('Elegant', 'ct') => 'elegant', __('Material Design', 'ct') => 'material', __('FontAwesome', 'ct') => 'fontawesome'), ct_userpack_to_dropdown()),
						),
						array(
							'type' => 'ct_icon',
							'heading' => __('Icon', 'ct'),
							'param_name' => 'icon_elegant',
							'icon_pack' => 'elegant',
							'dependency' => array(
								'element' => 'pack',
								'value' => array('elegant')
							),
						),
						array(
							'type' => 'ct_icon',
							'heading' => __('Icon', 'ct'),
							'icon_pack' => 'material',
							'param_name' => 'icon_material',
							'dependency' => array(
								'element' => 'pack',
								'value' => array('material')
							),
						),
						array(
							'type' => 'ct_icon',
							'heading' => __('Icon', 'ct'),
							'param_name' => 'icon_fontawesome',
							'icon_pack' => 'fontawesome',
							'dependency' => array(
								'element' => 'pack',
								'value' => array('fontawesome')
							),
						),
					),
					ct_userpack_to_shortcode(array(
						array(
							'type' => 'ct_icon',
							'heading' => __('Icon', 'ct'),
							'param_name' => 'icon_userpack',
							'icon_pack' => 'userpack',
							'dependency' => array(
								'element' => 'pack',
								'value' => array('userpack')
							),
						),
					)),
					array(
						array(
							'type' => 'colorpicker',
							'heading' => __('Icon Color', 'ct'),
							'param_name' => 'icon_color',
						),

					)),
					'callbacks' => array(
						'after_add' => 'vcChartParamAfterAddCallback',
					),
				),
			)),
		),

		'ct_portfolio' => array(
			'name' => __('Portfolio', 'ct'),
			'base' => 'ct_portfolio',
			'icon' => 'ct-icon-wpb-ui-portfolio',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Portfolio overview inside content', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Layout', 'ct'),
					'param_name' => 'portfolio_layout',
					'value' => array(__('2x columns', 'ct') => '2x', __('3x columns', 'ct') => '3x', __('4x columns', 'ct') => '4x', __('100% width', 'ct') => '100%', __('1x column list', 'ct') => '1x')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Layout Version', 'ct'),
					'param_name' => 'portfolio_layout_version',
					'value' => array(__('Fullwidth', 'ct') => 'fullwidth', __('With Sidebar', 'ct') => 'sidebar'),
					'dependency' => array(
						'element' => 'portfolio_layout',
						'value' => array('1x')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Caption Position', 'ct'),
					'param_name' => 'portfolio_caption_position',
					'value' => array(__('Right', 'ct') => 'right', __('Left', 'ct') => 'left', __('Zigzag', 'ct') => 'zigzag'),
					'dependency' => array(
						'element' => 'portfolio_layout',
						'value' => array('1x')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'portfolio_style',
					'value' => array(__('Justified Grid', 'ct') => 'justified', __('Masonry Grid ', 'ct') => 'masonry', __('Metro Style', 'ct') => 'metro'),
					'dependency' => array(
						'element' => 'portfolio_layout',
						'value' => array('2x', '3x', '4x', '100%')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Columns 100% Width (1920x Screen)', 'ct'),
					'param_name' => 'portfolio_fullwidth_columns',
					'value' => array(__('4 Columns', 'ct') => '4', __('5 Columns', 'ct') => '5'),
					'dependency' => array(
						'element' => 'portfolio_layout',
						'value' => array('100%')
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Gaps Size', 'ct'),
					'param_name' => 'portfolio_gaps_size',
					'std' => 42,
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Display Titles', 'ct'),
					'param_name' => 'portfolio_display_titles',
					'value' => array(__('On Page', 'ct') => 'page', __('On Hover', 'ct') => 'hover')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Background Style', 'ct'),
					'param_name' => 'portfolio_background_style',
					'value' => array(__('White', 'ct') => 'white', __('Grey', 'ct') => 'gray', __('Dark', 'ct') => 'dark'),
					'dependency' => array(
						'element' => 'portfolio_display_titles',
						'value' => array('page')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Hover Type', 'ct'),
					'param_name' => 'portfolio_hover',
					'value' => array(__('Cyan Breeze', 'ct') => 'default', __('Zooming White', 'ct') => 'zooming-blur', __('Horizontal Sliding', 'ct') => 'horizontal-sliding', __('Vertical Sliding', 'ct') => 'vertical-sliding', __('Gradient', 'ct') => 'gradient', __('Circular Overlay', 'ct') => 'circular')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Pagination', 'ct'),
					'param_name' => 'portfolio_pagination',
					'value' => array(__('Normal', 'ct') => 'normal', __('Load More ', 'ct') => 'more', __('Infinite Scroll ', 'ct') => 'scroll')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Loading animation', 'ct'),
					'param_name' => 'loading_animation',
					'std' => 'move-up',
					'value' => array(__('Disabled', 'ct') => 'disabled', __('Bounce', 'ct') => 'bounce', __('Move Up', 'ct') => 'move-up', __('Fade In', 'ct') => 'fade-in', __('Fall Perspective', 'ct') => 'fall-perspective', __('Scale', 'ct') => 'scale', __('Flip', 'ct') => 'flip'),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Items per page', 'ct'),
					'param_name' => 'portfolio_items_per_page',
					'std' => '8'
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Show Date & Sets', 'ct'),
					'param_name' => 'portfolio_show_info',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Disable sharing buttons', 'ct'),
					'param_name' => 'portfolio_disable_socials',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Activate Filter', 'ct'),
					'param_name' => 'portfolio_with_filter',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Title', 'ct'),
					'param_name' => 'portfolio_title'
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Activate Likes', 'ct'),
					'param_name' => 'portfolio_likes',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Activate Sorting', 'ct'),
					'param_name' => 'portfolio_sorting',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Portfolios', 'ct'),
					'param_name' => 'portfolios',
					'value' => ct_vc_get_terms('ct_portfolios'),
					'group' =>__('Select Portfolios', 'ct'),
					'edit_field_class' => 'ct-terms-checkboxes'
				),

				array(
					'type' => 'textfield',
					'heading' => __('Button Text', 'ct'),
					'param_name' => 'button_text',
					'group' => __('Load More Button', 'ct'),
					'std' => __('Load More', 'ct'),
					'dependency' => array(
						'element' => 'portfolio_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'button_style',
					'value' => array(__('Flat', 'ct') => 'flat', __('Outline', 'ct') => 'outline'),
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'portfolio_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Size', 'ct'),
					'param_name' => 'button_size',
					'value' => array(__('Tiny', 'ct') => 'tiny', __('Small', 'ct') => 'small', __('Medium', 'ct') => 'medium', __('Large', 'ct') => 'large', __('Giant', 'ct') => 'giant'),
					'std' => 'medium',
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'portfolio_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Text weight', 'ct'),
					'param_name' => 'button_text_weight',
					'value' => array(__('Normal', 'ct') => 'normal', __('Thin', 'ct') => 'thin'),
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'portfolio_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('No uppercase', 'ct'),
					'param_name' => 'button_no_uppercase',
					'value' => array(__('Yes', 'ct') => '1'),
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'portfolio_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Border radius', 'ct'),
					'param_name' => 'button_corner',
					'std' => 25,
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'portfolio_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Border width', 'ct'),
					'param_name' => 'button_border',
					'value' => array(1, 2, 3, 4, 5, 6),
					'std' => 2,
					'dependency' => array(
						'element' => 'button_style',
						'value' => array('outline')
					),
					'group' => __('Load More Button', 'ct'),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Text color', 'ct'),
					'param_name' => 'button_text_color',
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'portfolio_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover text color', 'ct'),
					'param_name' => 'button_hover_text_color',
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'portfolio_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background color', 'ct'),
					'param_name' => 'button_background_color',
					'dependency' => array(
						'element' => 'button_style',
						'value' => array('flat')
					),
					'std' => '#00bcd5',
					'group' => __('Load More Button', 'ct'),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover background color', 'ct'),
					'param_name' => 'button_hover_background_color',
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'portfolio_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Border color', 'ct'),
					'param_name' => 'button_border_color',
					'dependency' => array(
						'element' => 'button_style',
						'value' => array('outline')
					),
					'group' => __('Load More Button', 'ct'),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover border color', 'ct'),
					'param_name' => 'button_hover_border_color',
					'dependency' => array(
						'element' => 'button_style',
						'value' => array('outline')
					),
					'group' => __('Load More Button', 'ct'),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon pack', 'ct'),
					'param_name' => 'button_icon_pack',
					'value' => array_merge(array(__('Elegant', 'ct') => 'elegant', __('Material Design', 'ct') => 'material', __('FontAwesome', 'ct') => 'fontawesome'), ct_userpack_to_dropdown()),
					'std' => 2,
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'portfolio_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'button_icon_elegant',
					'icon_pack' => 'elegant',
					'dependency' => array(
						'element' => 'button_icon_pack',
						'value' => array('elegant')
					),
					'group' => __('Load More Button', 'ct'),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'button_icon_material',
					'icon_pack' => 'material',
					'dependency' => array(
						'element' => 'button_icon_pack',
						'value' => array('material')
					),
					'group' => __('Load More Button', 'ct'),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'button_icon_fontawesome',
					'icon_pack' => 'fontawesome',
					'dependency' => array(
						'element' => 'button_icon_pack',
						'value' => array('fontawesome')
					),
					'group' => __('Load More Button', 'ct'),
				),
			),
			ct_userpack_to_shortcode(array(
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'button_icon_userpack',
					'icon_pack' => 'userpack',
					'dependency' => array(
						'element' => 'button_icon_pack',
						'value' => array('userpack')
					),
				),
			)),
			array(
				array(
					'type' => 'dropdown',
					'heading' => __( 'Icon position', 'ct' ),
					'param_name' => 'button_icon_position',
					'value' => array(__( 'Left', 'ct' ) => 'left', __( 'Right', 'ct' ) => 'right'),
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'portfolio_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Separatot Style', 'ct'),
					'param_name' => 'button_separator',
					'value' => array(
						__('None', 'ct') => '',
						__('Single', 'ct') => 'single',
						__('Square', 'ct') => 'square',
						__('Soft Double', 'ct') => 'soft-double',
						__('Strong Double', 'ct') => 'strong-double',
						__('Load More', 'ct') => 'load-more'
					),
					'std' => 'load-more',
					'group' => __('Load More Button', 'ct'),
					'dependency' => array(
						'element' => 'portfolio_pagination',
						'value' => array('more')
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Max. row\'s height in grid (px)', 'ct'),
					'param_name' => 'metro_max_row_height',
					'dependency' => array(
						'callback' => 'metro_max_row_height_callback'
					),
					'std' => 380,
				),

			)),
		),

		'ct_portfolio_slider' => array(
			'name' => __('Portfolio slider', 'ct'),
			'base' => 'ct_portfolio_slider',
			'icon' => 'ct-icon-wpb-ui-portfolio',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Portfolio slider inside content', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'textfield',
					'heading' => __('Title', 'ct'),
					'param_name' => 'portfolio_title',
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Portfolios', 'ct'),
					'param_name' => 'portfolios',
					'value' => ct_vc_get_terms('ct_portfolios'),
					'group' =>__('Select Portfolios', 'ct'),
					'edit_field_class' => 'ct-terms-checkboxes'
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Layout', 'ct'),
					'param_name' => 'portfolio_layout',
					'value' => array(__('3x columns', 'ct') => '3x', __('100% width', 'ct') => '100%')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Columns 100% Width (1920x Screen)', 'ct'),
					'param_name' => 'portfolio_fullwidth_columns',
					'value' => array(__('3 Columns', 'ct') => '3', __('4 Columns', 'ct') => '4', __('5 Columns', 'ct') => '5'),
					'std' => '4',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Gaps Size', 'ct'),
					'param_name' => 'portfolio_gaps_size',
					'std' => 42,
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Display Titles', 'ct'),
					'param_name' => 'portfolio_display_titles',
					'value' => array(__('On Page', 'ct') => 'page', __('On Hover', 'ct') => 'hover')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Hover Type', 'ct'),
					'param_name' => 'portfolio_hover',
					'value' => array(__('Cyan Breeze', 'ct') => 'default', __('Zooming White', 'ct') => 'zooming-blur', __('Horizontal Sliding', 'ct') => 'horizontal-sliding', __('Vertical Sliding', 'ct') => 'vertical-sliding', __('Gradient', 'ct') => 'gradient', __('Circular Overlay', 'ct') => 'circular')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Background Style', 'ct'),
					'param_name' => 'portfolio_background_style',
					'value' => array(__('White', 'ct') => 'white', __('Grey', 'ct') => 'gray', __('Dark', 'ct') => 'dark'),
					'dependency' => array(
						'element' => 'portfolio_display_titles',
						'value' => array('page')
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Show Date & Sets', 'ct'),
					'param_name' => 'portfolio_show_info',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Disable sharing buttons', 'ct'),
					'param_name' => 'portfolio_disable_socials',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Lazy loading enabled', 'ct'),
					'param_name' => 'effects_enabled',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Activate Likes', 'ct'),
					'param_name' => 'portfolio_likes',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Arrow', 'ct'),
					'param_name' => 'portfolio_slider_arrow',
					'value' => array(__('Big', 'ct') => 'portfolio_slider_arrow_big', __('Small', 'ct') => 'portfolio_slider_arrow_small')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Autoscroll', 'ct'),
					'param_name' => 'portfolio_autoscroll',
				),
			)),
		),

		'ct_pricing_column' => array(
			'name' => __('Pricing Table Column', 'ct'),
			'base' => 'ct_pricing_column',
			'icon' => 'ct-icon-wpb-ui-pricing-column',
			'as_parent' => array('only' => 'ct_pricing_price,ct_pricing_row,ct_pricing_row_title,ct_pricing_footer'),
			'as_child' => array('only' => 'ct_pricing_table'),
			'category' => __('Codex Themes', 'ct'),
			'is_container' => true,
			'js_view' => 'VcCTPricingColumnView',
			'params' => array_merge(array(
				array(
					'type' => 'textfield',
					'heading' => __('Top Choice', 'ct'),
					'param_name' => 'top_choice',
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Highlighted', 'ct'),
					'param_name' => 'highlighted',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Column width', 'ct'),
					'param_name' => 'cols',
					'value' => array(3, 4),
				),
					array(
					'type' => 'colorpicker',
					'heading' => __('Top choice color', 'ct'),
					'param_name' => 'top_choice_color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Top choice background color', 'ct'),
					'param_name' => 'top_choice_background_color',
				)
			)),
		),

		'ct_pricing_price' => array(
			'name' => __("Column's Header", 'ct'),
			'base' => 'ct_pricing_price',
			'icon' => 'ct-icon-wpb-ui-pricing-price',
			'as_child' => array('only' => 'ct_pricing_column'),
			'category' => __('Codex Themes', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'textfield',
					'heading' => __('Column title', 'ct'),
					'param_name' => 'title',
					'value' => ''
				),
				array(
					'type' => 'textfield',
					'heading' => __('Column subtitle', 'ct'),
					'param_name' => 'subtitle',
					'value' => ''
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Price background color ', 'ct'),
					'param_name' => 'backgroundcolor',
				),
				array(
					'type' => 'attach_image',
					'heading' => __('Price background image', 'ct'),
					'param_name' => 'background',
				),

				array(
					'type' => 'textfield',
					'heading' => __('Currency', 'ct'),
					'param_name' => 'currency',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Price', 'ct'),
					'param_name' => 'price',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Time period', 'ct'),
					'param_name' => 'time',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Styles', 'ct'),
					'param_name' => 'font_size_label',
					'value' => array(__('Use default styles', 'ct') => 'default', __('Use custom styles', 'ct') => 'custom'),
					'dependency' => array(
						'element' => 'style',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Set font size of the price', 'ct'),
					'param_name' => 'font_size',
					'dependency' => array(
						'element' => 'font_size_label',
						'value' => array('custom')
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Set font size of the time', 'ct'),
					'param_name' => 'font_size_time',
					'dependency' => array(
						'element' => 'font_size_label',
						'value' => array('custom')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Set color for Price', 'ct'),
					'param_name' => 'price_color',
					'dependency' => array(
						'element' => 'font_size_label',
						'value' => array('custom')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Set color for title', 'ct'),
					'param_name' => 'title_color',
					'dependency' => array(
						'element' => 'font_size_label',
						'value' => array('custom')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Set color for subtitle', 'ct'),
					'param_name' => 'subtitle_color',
					'dependency' => array(
						'element' => 'font_size_label',
						'value' => array('custom')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Set color for time', 'ct'),
					'param_name' => 'time_color',
					'dependency' => array(
						'element' => 'font_size_label',
						'value' => array('custom')
					),
				),
			)),
		),

		'ct_pricing_row' => array(
			'name' => __("Column's Row", 'ct'),
			'base' => 'ct_pricing_row',
			'icon' => 'ct-icon-wpb-ui-pricing-row',
			'as_child' => array('only' => 'ct_pricing_column'),
			'category' => __('Codex Themes', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'textarea_html',
					'heading' => __('Content', 'ct'),
					'param_name' => 'content',
					'value' => '#'
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Strike', 'ct'),
					'param_name' => 'strike',
					'value' => array(__('Yes', 'ct') => '1')
				),
			)),
		),
		'ct_pricing_row_title' => array(
			'name' => __("Column's Extra Title", 'ct'),
			'base' => 'ct_pricing_row_title',
			'icon' => 'ct-icon-wpb-ui-pricing-row',
			'as_child' => array('only' => 'ct_pricing_column'),
			'category' => __('Codex Themes', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'textfield',
					'heading' => __('Extra Title', 'ct'),
					'param_name' => 'content',
					'value' => '#'
				),
				array(
					'type' => 'textfield',
					'heading' => __('Extra Subtitle', 'ct'),
					'param_name' => 'subtitle',
					'value' => '#'
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Extra Title Color', 'ct'),
					'param_name' => 'title_color',

				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Extra Subtitle Color', 'ct'),
					'param_name' => 'subtitle_color',

				),
			)),
		),
		'ct_pricing_footer' => array(
			'name' => __("Column's Footer", 'ct'),
			'base' => 'ct_pricing_footer',
			'icon' => 'ct-icon-wpb-ui-pricing-footer',
			'as_child' => array('only' => 'ct_pricing_column'),
			'category' => __('Codex Themes', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'textfield',
					'heading' => __('Button Text', 'ct'),
					'param_name' => 'button_1_text',
				),
				array(
					'type' => 'vc_link',
					'heading' => __( 'URL (Link)', 'ct' ),
					'param_name' => 'button_1_link',
					'description' => __( 'Add link to button.', 'ct' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'button_1_style',
					'value' => array(__('Flat', 'ct') => 'flat', __('Outline', 'ct') => 'outline')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Size', 'ct'),
					'param_name' => 'button_1_size',
					'value' => array(__('Tiny', 'ct') => 'tiny', __('Small', 'ct') => 'small', __('Medium', 'ct') => 'medium', __('Large', 'ct') => 'large', __('Giant', 'ct') => 'giant'),
					'std' => 'small'
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Text weight', 'ct'),
					'param_name' => 'button_1_text_weight',
					'value' => array(__('Normal', 'ct') => 'normal', __('Thin', 'ct') => 'thin'),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('No uppercase', 'ct'),
					'param_name' => 'button_1_no_uppercase',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Border radius', 'ct'),
					'param_name' => 'button_1_corner',
					'value' => 3,
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Border width', 'ct'),
					'param_name' => 'button_1_border',
					'value' => array(1, 2, 3, 4, 5, 6),
					'std' => 2,
					'dependency' => array(
						'element' => 'button_1_style',
						'value' => array('outline')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Text color', 'ct'),
					'param_name' => 'button_1_text_color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover text color', 'ct'),
					'param_name' => 'button_1_hover_text_color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background color', 'ct'),
					'param_name' => 'button_1_background_color',
					'dependency' => array(
						'element' => 'button_1_style',
						'value' => array('flat')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover background color', 'ct'),
					'param_name' => 'button_1_hover_background_color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Border color', 'ct'),
					'param_name' => 'button_1_border_color',
					'dependency' => array(
						'element' => 'button_1_style',
						'value' => array('outline')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover border color', 'ct'),
					'param_name' => 'button_1_hover_border_color',
					'dependency' => array(
						'element' => 'button_1_style',
						'value' => array('outline')
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Use Gradient Backgound Colors', 'avxbuilder'),
					'param_name' => 'button_1_gradient_backgound',
					'value' => array(__('Yes', 'avxbuilder') => '1'),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background From', 'avxbuilder'),
					"edit_field_class" => "vc_col-sm-5 vc_column",
					'param_name' => 'button_1_gradient_backgound_from',
					'dependency' => array(
						'element' => 'button_1_gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Background To', 'avxbuilder'),
					"edit_field_class" => "vc_col-sm-5 vc_column",
					'param_name' => 'button_1_gradient_backgound_to',
					'dependency' => array(
						'element' => 'button_1_gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover Background From', 'avxbuilder'),
					"edit_field_class" => "vc_col-sm-5 vc_column",
					'param_name' => 'button_1_gradient_backgound_hover_from',
					'dependency' => array(
						'element' => 'button_1_gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover Background To', 'avxbuilder'),
					"edit_field_class" => "vc_col-sm-5 vc_column",
					'param_name' => 'button_1_gradient_backgound_hover_to',
					'dependency' => array(
						'element' => 'button_1_gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					"type" => "dropdown",
					'heading' => __('Style', 'avxbuilder'),
					'param_name' => 'button_1_gradient_backgound_style',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					"value" => array(
						__('Linear', "avxbuilder") => "linear",
						__('Radial', "avxbuilder") => "radial",
					) ,
					"std" => 'linear',
					'dependency' => array(
						'element' => 'button_1_gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					"type" => "dropdown",
					'heading' => __('Gradient Position', 'avxbuilder'),
					'param_name' => 'button_1_gradient_radial_backgound_position',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					"value" => array(
						__('Top', "avxbuilder") => "at top",
						__('Bottom', "avxbuilder") => "at bottom",
						__('Right', "avxbuilder") => "at right",
						__('Left', "avxbuilder") => "at left",
						__('Center', "avxbuilder") => "at center",

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
					'heading' => __('Swap Colors', 'avxbuilder'),
					'param_name' => 'button_1_gradient_radial_swap_colors',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					'value' => array(__('Yes', 'avxbuilder') => '1'),
					'dependency' => array(
						'element' => 'button_1_gradient_backgound_style',
						'value' => array(
							'radial',
						)
					)
				),


				array(
					"type" => "dropdown",
					'heading' => __('Custom Angle', 'avxbuilder'),
					'param_name' => 'button_1_gradient_backgound_angle',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					"value" => array(
						__('Vertical to bottom ↓', "avxbuilder") => "to bottom",
						__('Vertical to top ↑', "avxbuilder") => "to top",
						__('Horizontal to left  →', "avxbuilder") => "to right",
						__('Horizontal to right ←', "avxbuilder") => "to left",
						__('Diagonal from left to bottom ↘', "avxbuilder") => "to bottom right",
						__('Diagonal from left to top ↗', "avxbuilder") => "to top right",
						__('Diagonal from right to bottom ↙', "avxbuilder") => "to bottom left",
						__('Diagonal from right to top ↖', "avxbuilder") => "to top left",
						__('Custom', "avxbuilder") => "cusotom_deg",

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
					'heading' => __('Angle', 'avxbuilder'),
					'param_name' => 'button_1_gradient_backgound_cusotom_deg',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					'description' => __('Set value in DG 0-360', 'avxbuilder'),
					'dependency' => array(
						'element' => 'button_1_gradient_backgound_angle',
						'value' => array(
							'cusotom_deg',
						)
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon pack', 'ct'),
					'param_name' => 'button_1_icon_pack',
					'value' => array_merge(array(__('Elegant', 'ct') => 'elegant', __('Material Design', 'ct') => 'material', __('FontAwesome', 'ct') => 'fontawesome'), ct_userpack_to_dropdown()),
					'std' => 2,
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'button_1_icon_elegant',
					'icon_pack' => 'elegant',
					'dependency' => array(
						'element' => 'button_1_icon_pack',
						'value' => array('elegant')
					),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'button_1_icon_material',
					'icon_pack' => 'material',
					'dependency' => array(
						'element' => 'button_1_icon_pack',
						'value' => array('material')
					),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'button_1_icon_fontawesome',
					'icon_pack' => 'fontawesome',
					'dependency' => array(
						'element' => 'button_1_icon_pack',
						'value' => array('fontawesome')
					),
				),
			),
			ct_userpack_to_shortcode(array(
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
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
					'heading' => __( 'Icon position', 'ct' ),
					'param_name' => 'button_1_icon_position',
					'value' => array(__( 'Left', 'ct' ) => 'left', __( 'Right', 'ct' ) => 'right'),
				),

			)),
		),

		'ct_pricing_table' => array(
			'name' => __('Pricing table', 'ct'),
			'base' => 'ct_pricing_table',
			'icon' => 'ct-icon-wpb-ui-pricing-table',
			'is_container' => true,
			'js_view' => 'VcCTPricingTableView',
			'as_parent' => array('only' => 'ct_pricing_column'),
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Styled pricing table', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(__('Style 1', 'ct') => '1', __('Style 2', 'ct') => '2', __('Style 3', 'ct') => '3', __('Style 4', 'ct') => '4', __('Style 5', 'ct') => '5', __('Style 6', 'ct') => '6', __('Style 7', 'ct') => '7', __('Style 8', 'ct') => '8')
				),
			)),
		),

		'ct_quickfinder' => array(
			'name' => __('Quickfinder', 'ct'),
			'base' => 'ct_quickfinder',
			'icon' => 'ct-icon-wpb-ui-quickfinder',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Quickfinder overviews inside content', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(
						__('Default Style', 'ct') => 'default',
						__('Classic Box', 'ct') => 'classic',
						__('Iconed Box', 'ct') => 'iconed',
						__('Binded Box', 'ct') => 'binded',
						__('Binded Iconed Boxes', 'ct') => 'binded-iconed',
						__('Tag Box', 'ct') => 'tag',
						__('Vertical Style 1', 'ct') => 'vertical-1',
						__('Vertical Style 2', 'ct') => 'vertical-2',
						__('Vertical Style 3', 'ct') => 'vertical-3',
						__('Vertical Style 4', 'ct') => 'vertical-4',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Number Of Columns', 'ct'),
					'param_name' => 'columns',
					'value' => array(1,2,3,4,6),
					'std' => 3,
					'dependency' => array(
						'element' => 'style',
						'value' => array('classic', 'iconed', 'binded', 'binded-iconed', 'tag')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Box Style', 'ct'),
					'param_name' => 'box_style',
					'value' => array(
						__('Solid', 'ct') => 'solid',
						__('Soft Outlined', 'ct') => 'soft-outlined',
						__('Strong Outlined', 'ct') => 'strong-outlined',
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array('classic', 'iconed', 'binded', 'binded-iconed', 'tag')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Box Background Color', 'ct'),
					'param_name' => 'box_background_color',
					'dependency' => array(
						'element' => 'style',
						'value' => array('classic', 'iconed', 'binded', 'binded-iconed', 'tag')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Box Border Color', 'ct'),
					'param_name' => 'box_border_color',
					'dependency' => array(
						'element' => 'box_style',
						'value' => array('soft-outlined', 'strong-outlined')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Alignment', 'ct'),
					'param_name' => 'alignment',
					'value' => array(
						__('Centered', 'ct') => 'center',
						__('Left', 'ct') => 'left',
						__('Right', 'ct') => 'right',
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array('classic', 'iconed', 'binded', 'binded-iconed', 'tag', 'vertical-3')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon Position', 'ct'),
					'param_name' => 'icon_position',
					'value' => array(
						__('Top', 'ct') => 'top',
						__('Bottom', 'ct') => 'bottom',
						__('Top float', 'ct') => 'top-float',
						__('Center float', 'ct') => 'center-float',
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array('classic', 'iconed', 'binded', 'binded-iconed', 'tag')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Title Weight', 'ct'),
					'param_name' => 'title_weight',
					'value' => array(
						__('Bold', 'ct') => 'bold',
						__('Thin', 'ct') => 'thin',
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Activate Button', 'ct'),
					'param_name' => 'activate_button',
					'value' => array(__('Yes', 'ct') => '1'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('classic', 'iconed', 'binded', 'binded-iconed', 'tag')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Button Style', 'ct'),
					'param_name' => 'button_style',
					'value' => array(__('Flat', 'ct') => 'flat', __('Outline', 'ct') => 'outline'),
					'dependency' => array(
						'element' => 'activate_button',
						'not_empty' => true
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Button Text weight', 'ct'),
					'param_name' => 'button_text_weight',
					'value' => array(__('Normal', 'ct') => 'normal', __('Thin', 'ct') => 'thin'),
					'dependency' => array(
						'element' => 'activate_button',
						'not_empty' => true
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Button Border radius', 'ct'),
					'param_name' => 'button_corner',
					'value' => 3,
					'dependency' => array(
						'element' => 'activate_button',
						'not_empty' => true
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Button Text color', 'ct'),
					'param_name' => 'button_text_color',
					'dependency' => array(
						'element' => 'activate_button',
						'not_empty' => true
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Button Background color', 'ct'),
					'param_name' => 'button_background_color',
					'dependency' => array(
						'element' => 'button_style',
						'value' => array('flat')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Button Border color', 'ct'),
					'param_name' => 'button_border_color',
					'dependency' => array(
						'element' => 'button_style',
						'value' => array('outline')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover Icon Color', 'ct'),
					'param_name' => 'hover_icon_color',
					'group' => __('Hovers', 'ct'),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover Box Color', 'ct'),
					'param_name' => 'hover_box_color',
					'group' => __('Hovers', 'ct'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('classic', 'iconed', 'binded', 'binded-iconed', 'tag')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover Border Color', 'ct'),
					'param_name' => 'hover_border_color',
					'group' => __('Hovers', 'ct'),
					'dependency' => array(
						'element' => 'box_style',
						'value' => array('soft-outlined', 'strong-outlined')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover Title Color', 'ct'),
					'param_name' => 'hover_title_color',
					'group' => __('Hovers', 'ct'),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover Description Color', 'ct'),
					'param_name' => 'hover_description_color',
					'group' => __('Hovers', 'ct'),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover Button Text Color', 'ct'),
					'param_name' => 'hover_button_text_color',
					'group' => __('Hovers', 'ct'),
					'dependency' => array(
						'element' => 'activate_button',
						'not_empty' => true
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover Button Background Color', 'ct'),
					'param_name' => 'hover_button_background_color',
					'group' => __('Hovers', 'ct'),
					'dependency' => array(
						'element' => 'activate_button',
						'not_empty' => true
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Hover Button Border Color', 'ct'),
					'param_name' => 'hover_button_border_color',
					'group' => __('Hovers', 'ct'),
					'dependency' => array(
						'element' => 'button_style',
						'value' => array('outline')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Connector Color', 'ct'),
					'param_name' => 'connector_color',
					'dependency' => array(
						'element' => 'style',
						'value' => array('vertical-1', 'vertical-2', 'vertical-3', 'vertical-4')
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Lazy loading enabled', 'ct'),
					'param_name' => 'effects_enabled',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Quickfinders', 'ct'),
					'param_name' => 'quickfinders',
					'value' => ct_vc_get_terms('ct_quickfinders'),
					'group' =>__('Select Quickfinders', 'ct'),
					'edit_field_class' => 'ct-terms-checkboxes'
				),
			)),
		),

		'ct_quote' => array(
			'name' => __('Quoted text', 'ct'),
			'base' => 'ct_quote',
			'icon' => 'ct-icon-wpb-ui-quote',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Quoted text content', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'textarea_html',
					'heading' => __('Content', 'ct'),
					'param_name' => 'content',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(
						__('Default', 'ct') => 'default',
						__('Style 1', 'ct') => '1',
						__('Style 2', 'ct') => '2',
						__('Style 3', 'ct') => '3',
						__('Style 4', 'ct') => '4',
						__('Style 5', 'ct') => '5',
					)
				),
				array(
					'type' => 'checkbox',
					'heading' => __('No Paddings', 'ct'),
					'param_name' => 'no_paddings',
					'value' => array(__('Yes', 'ct') => '1')
				),
			)),
		),

		'ct_search_form' => array(
			'name' => __('Search form', 'ct'),
			'base' => 'ct_search_form',
			'is_container' => false,
			'icon' => 'ct-icon-wpb-ui-search-form',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Search form', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(
						__('Light', 'ct') => 'light',
						__('Dark', 'ct') => 'dark',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Alignment', 'ct'),
					'param_name' => 'alignment',
					'value' => array(
						__('Left', 'ct') => 'left',
						__('Right', 'ct') => 'right',
						__('Center', 'ct') => 'center',
					)
				),
				array(
					'type' => 'textfield',
					'heading' => __('Placehoder', 'ct'),
					'param_name' => 'placeholder',
					'std' => __('Search', 'ct')
				),
			)),
		),

		'ct_socials' => array(
			'name' => __('Socials', 'ct'),
			'base' => 'ct_socials',
			'is_container' => false,
			'icon' => 'ct-icon-wpb-ui-socials',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Socials', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(
						__('Default', 'ct') => 'default',
						__('Rounded', 'ct') => 'rounded',
						__('Square', 'ct') => 'square',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icons color', 'ct'),
					'param_name' => 'colored',
					'value' => array(
						__('Default', 'ct') => 'default',
						__('Custom', 'ct') => 'custom',
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Custom color', 'ct'),
					'param_name' => 'color',
					'dependency' => array(
						'element' => 'colored',
						'value' => 'custom'
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Alignment', 'ct'),
					'param_name' => 'alignment',
					'value' => array(
						__('Left', 'ct') => 'left',
						__('Right', 'ct') => 'right',
						__('Center', 'ct') => 'center',
					)
				),
				array(
					'type' => 'textfield',
					'heading' => __('Icons size', 'ct'),
					'param_name' => 'icons_size',
					'std' => 16
				),
				array(
					'type' => 'param_group',
					'heading' => __( 'Socials', 'ct' ),
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
							'heading' => __( 'Social', 'ct' ),
							'param_name' => 'social',
							'value' => array(
								__('Facebook', 'ct') => 'facebook',
								__('Twitter', 'ct') => 'twitter',
								__('Pinterest', 'ct') => 'pinterest',
								__('Google Plus', 'ct') => 'googleplus',
								__('Tumblr', 'ct') => 'tumblr',
								__('StumbleUpon', 'ct') => 'stumbleupon',
								__('Wordpress', 'ct') => 'wordpress',
								__('Instagram', 'ct') => 'instagram',
								__('Dribbble', 'ct') => 'dribbble',
								__('Vimeo', 'ct') => 'vimeo',
								__('Linkedin', 'ct') => 'linkedin',
								__('RSS', 'ct') => 'rss',
								__('DeviantArt', 'ct') => 'deviantart',
								__('Share', 'ct') => 'share',
								__('MySpace', 'ct') => 'myspace',
								__('Skype', 'ct') => 'skype',
								__('Youtube', 'ct') => 'youtube',
								__('Picassa', 'ct') => 'picassa',
								__('Google Drive', 'ct') => 'googledrive',
								__('Flickr', 'ct') => 'flickr',
								__('Blogger', 'ct') => 'blogger',
								__('Spotify', 'ct') => 'spotify',
								__('Delicious', 'ct') => 'delicious',
								__('Custom', 'ct') => 'custom',
							),
						),
						array(
							'type' => 'textfield',
							'heading' => __('SVG code', 'ct'),
							'param_name' => 'svg',
							'dependency' => array(
								'element' => 'social',
								'value' => array('custom')
							)
						),
						array(
							'type' => 'textfield',
							'heading' => __('SVG ViewBox', 'ct'),
							'description' => 'example: 0 0 32 32',
							'param_name' => 'viewbox',
							'dependency' => array(
								'element' => 'social',
								'value' => array('custom')
							),
						),
						array(
							'type' => 'textfield',
							'heading' => __('Url', 'ct'),
							'param_name' => 'url',
							'std' => '#'
						),
					)),
				),

			)),
		),

		'ct_video' => array(
			'name' => __('Self-Hosted Video ', 'ct'),
			'base' => 'ct_video',
			'icon' => 'ct-icon-wpb-ui-video',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Video content', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'textfield',
					'heading' => __('Width', 'ct'),
					'param_name' => 'width',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Height', 'ct'),
					'param_name' => 'height',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Video Aspect ratio (16:9, 16:10, 4:3...)', 'ct'),
					'param_name' => 'aspect_ratio',
					'value' => '16:9'
				),
				array(
					'type' => 'textfield',
					'heading' => __('Video URL in mp4 or flv format', 'ct'),
					'param_name' => 'video_src',
				),
				array(
					'type' => 'attach_image',
					'heading' => __('Poster Image', 'ct'),
					'param_name' => 'image_src',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Border Style', 'ct'),
					'param_name' => 'style',
					'value' => array(
						__('no border', 'ct') => 'default',
						__('8px & border', 'ct') => '1',
						__('16px & border', 'ct') => '2',
						__('8px outlined border', 'ct') => '3',
						__('20px outlined border', 'ct') => '4',
						__('20px border with shadow', 'ct') => '5',
						__('Combined border', 'ct') => '6',
						__('20px border radius', 'ct') => '7',
						__('55px border radius', 'ct') => '8',
						__('Dashed inside', 'ct') => '9',
						__('Dashed outside', 'ct') => '10',
						__('Rounded with border', 'ct') => '11'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Position', 'ct'),
					'param_name' => 'position',
					'value' => array(__('below', 'ct') => 'below', __('left', 'ct') => 'left', __('right', 'ct') => 'right')
				),
			)),
		),

		'ct_gallery' => array(
			'name' => __('Styled Gallery', 'ct'),
			'base' => 'ct_gallery',
			'icon' => 'ct-icon-wpb-ui-gallery',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Image gallery in different styles', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Gallery', 'ct'),
					'param_name' => 'gallery_gallery',
					'value' => ct_vc_get_galleries(),
					'save_always' => true,
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Gallery Type', 'ct'),
					'param_name' => 'gallery_type',
					'description' => __('Choose gallery type', 'ct'),
					'value' => array(__('Slider', 'ct') => 'slider', __('Grid', 'ct') => 'grid')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Layout', 'ct'),
					'param_name' => 'gallery_slider_layout',
					'value' => array(__('fullwidth', 'ct') => 'fullwidth', __('Sidebar', 'ct') => 'sidebar'),
					'dependency' => array(
						'element' => 'gallery_type',
						'value' => array('slider')
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Disable thumbnails bar', 'ct'),
					'param_name' => 'no_thumbs',
					'value' => array(__('Yes', 'ct') => '1'),
					'dependency' => array(
						'element' => 'gallery_type',
						'value' => array('slider')
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Pagination', 'ct'),
					'param_name' => 'pagination',
					'value' => array(__('Yes', 'ct') => '1'),
					'dependency' => array(
						'element' => 'no_thumbs',
						'not_empty' => true
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Autoscroll', 'ct'),
					'param_name' => 'autoscroll',
					'dependency' => array(
						'element' => 'gallery_type',
						'value' => array('slider')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Layout', 'ct'),
					'param_name' => 'gallery_layout',
					'description' => __('Choose gallery layout', 'ct'),
					'value' => array(__('2x columns', 'ct') => '2x', __('3x columns', 'ct') => '3x', __('4x columns', 'ct') => '4x', __('100% width', 'ct') => '100%'),
					'dependency' => array(
						'element' => 'gallery_type',
						'value' => array('grid')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'gallery_style',
					'description' => __('Choose gallery style', 'ct'),
					'value' => array(__('Justified Grid', 'ct') => 'justified', __('Masonry Grid', 'ct') => 'masonry', __('Metro Style', 'ct') => 'metro'),
					'dependency' => array(
						'element' => 'gallery_type',
						'value' => array('grid')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Columns 100% Width (1920x Screen)', 'ct'),
					'param_name' => 'gallery_fullwidth_columns',
					'value' => array(__('4 Columns', 'ct') => '4', __('5 Columns', 'ct') => '5'),
					'dependency' => array(
						'element' => 'gallery_layout',
						'value' => array('100%')
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Gaps size (px)', 'ct'),
					'param_name' => 'gaps_size',
					'dependency' => array(
						'element' => 'gallery_type',
						'value' => array('grid')
					),
					'std' => 42,

				),
				// array(
				// 	'type' => 'checkbox',
				// 	'heading' => __('No Gaps', 'ct'),
				// 	'param_name' => 'gallery_no_gaps',
				// 	'value' => array(__('Yes', 'ct') => '1'),
				// 	'dependency' => array(
				// 		'element' => 'gallery_type',
				// 		'value' => array('grid')
				// 	),
				// ),
				array(
					'type' => 'dropdown',
					'heading' => __('Hover Type', 'ct'),
					'param_name' => 'gallery_hover',
					'value' => array(__('Cyan Breeze', 'ct') => 'default', __('Zooming White', 'ct') => 'zooming-blur', __('Horizontal Sliding', 'ct') => 'horizontal-sliding', __('Vertical Sliding', 'ct') => 'vertical-sliding', __('Gradient', 'ct') => 'gradient', __('Circular Overlay', 'ct') => 'circular')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Border Style', 'ct'),
					'param_name' => 'gallery_item_style',
					'value' => array(
						__('no border', 'ct') => 'default',
						__('8px & border', 'ct') => '1',
						__('16px & border', 'ct') => '2',
						__('8px outlined border', 'ct') => '3',
						__('20px outlined border', 'ct') => '4',
						__('20px border with shadow', 'ct') => '5',
						__('Combined border', 'ct') => '6',
						__('20px border radius', 'ct') => '7',
						__('55px border radius', 'ct') => '8',
						__('Dashed inside', 'ct') => '9',
						__('Dashed outside', 'ct') => '10',
						__('Rounded with border', 'ct') => '11'
					),
					'dependency' => array(
						'element' => 'gallery_type',
						'value' => array('grid')
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Title', 'ct'),
					'param_name' => 'gallery_title',
					'dependency' => array(
						'element' => 'gallery_type',
						'value' => array('grid')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Loading animation', 'ct'),
					'param_name' => 'loading_animation',
					'std' => 'move-up',
					'value' => array(__('Disabled', 'ct') => 'disabled', __('Bounce', 'ct') => 'bounce', __('Move Up', 'ct') => 'move-up', __('Fade In', 'ct') => 'fade-in', __('Fall Perspective', 'ct') => 'fall-perspective', __('Scale', 'ct') => 'scale', __('Flip', 'ct') => 'flip'),
					'dependency' => array(
						'element' => 'gallery_type',
						'value' => array('grid')
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Max. row\'s height in grid (px)', 'ct'),
					'param_name' => 'metro_max_row_height',
					'dependency' => array(
						'callback' => 'metro_max_row_height_callback'
					),
					'std' => 380,
				),
			)),
		),

		'ct_image' => array(
			'name' => __('Styled Image', 'ct'),
			'base' => 'ct_image',
			'icon' => 'ct-icon-wpb-ui-image',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Image in different styles', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'textfield',
					'heading' => __('Width', 'ct'),
					'param_name' => 'width',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Height', 'ct'),
					'param_name' => 'height',
				),
				array(
					'type' => 'attach_image',
					'heading' => __('Src', 'ct'),
					'param_name' => 'src',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Alt text', 'ct'),
					'param_name' => 'alt',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Border Style', 'ct'),
					'param_name' => 'style',
					'value' => array(
						__('no border', 'ct') => 'default',
						__('8px & border', 'ct') => '1',
						__('16px & border', 'ct') => '2',
						__('8px outlined border', 'ct') => '3',
						__('20px outlined border', 'ct') => '4',
						__('20px border with shadow', 'ct') => '5',
						__('Combined border', 'ct') => '6',
						__('20px border radius', 'ct') => '7',
						__('55px border radius', 'ct') => '8',
						__('Dashed inside', 'ct') => '9',
						__('Dashed outside', 'ct') => '10',
						__('Rounded with border', 'ct') => '11',
						__('Rounded without border', 'ct') => '14'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Position', 'ct'),
					'param_name' => 'position',
					'value' => array(__('below', 'ct') => 'below', __('centered', 'ct') => 'centered', __('left', 'ct') => 'left', __('right', 'ct') => 'right')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Disable lightbox', 'ct'),
					'param_name' => 'disable_lightbox',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Lazy loading enabled', 'scalia'),
					'param_name' => 'effects_enabled',
					'value' => array(__('Yes', 'ct') => '1')
				),
			)),
		),

		'ct_list' => array(
			'name' => __('Styled List', 'ct'),
			'base' => 'ct_list',
			'icon' => 'ct-icon-wpb-ui-list',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('List in different styles', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Type', 'ct'),
					'param_name' => 'type',
					'value' => array(__('Default', 'ct') => '', __('Arrow', 'ct') => 'arrow', __('Double arrow', 'ct') => 'double-arrow',__('Check style 1', 'ct') => 'check-style-1', __('Check style 2', 'ct') => 'check-style-2', __('Disc style 1', 'ct') => 'disc-style-1', __('Disc style 2', 'ct') => 'disc-style-2', __('Checkbox', 'ct') => 'checkbox', __('Cross', 'ct') => 'cross', __('Snowflake style 1', 'ct') => 'snowflake-style-1', __('Snowflake style 2', 'ct') => 'snowflake-style-2', __('Square', 'ct') => 'square', __('Star', 'ct') => 'star', __('Plus', 'ct') => 'plus', __('Label', 'ct') => 'Label')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Color', 'ct'),
					'param_name' => 'color',
					'value' => array(
						__('Default Gray', 'ct') => '',
						__('Aubergine', 'ct') => '1',
						__('Teal', 'ct') => '2',
						__('Cyan', 'ct') => '3',
						__('Amber', 'ct') => '4',
						__('Red', 'ct') => '5',
						__('Deep Purple', 'ct') => '6',
						__('Purple', 'ct') => '7',
						__('Brown', 'ct') => '8',
						__('Light Red ', 'ct') => '9',
						__('Dark Pink', 'ct') => '10',
						__('Lime', 'ct') => '11'
					)

				),
				array(
					'type' => 'textarea_html',
					'heading' => __('Content', 'ct'),
					'param_name' => 'content',
					'value' => '<ul>'."\n".'<li>'.__('Element 1', 'ct').'</li>'."\n".'<li>'.__('Element 2', 'ct').'</li>'."\n".'<li>'.__('Element 3', 'ct').'</li>'."\n".'</ul>'
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Lazy loading enabled', 'ct'),
					'param_name' => 'effects_enabled',
					'value' => array(__('Yes', 'ct') => '1')
				),
			)),
		),

		'ct_table' => array(
			'name' => __('Table', 'ct'),
			'base' => 'ct_table',
			'icon' => 'ct-icon-wpb-ui-table',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Styled table content', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(__('style-1', 'ct') => '1', __('style-2', 'ct') => '2', __('style-3', 'ct') => '3')
				),
				array(
					'type' => 'textarea_html',
					'heading' => __('Content', 'ct'),
					'param_name' => 'content',
					'value' => '<table style="width: 100%;">'."\n".
						'<thead><tr><th><h6>'.__('Title 1', 'ct').'</h6></th><th><h6>'.__('Title 2', 'ct').'</h6></th><th><h6>'.__('Title 3', 'ct').'</h6></th></tr></thead>'."\n".
						'<tbody>'."\n".
						'<tr><td>'.__('Content 1 1', 'ct').'</td><td>'.__('Content 1 2', 'ct').'</td><td>'.__('Content 1 3', 'ct').'</td></tr>'."\n".
						'<tr><td>'.__('Content 2 1', 'ct').'</td><td>'.__('Content 2 2', 'ct').'</td><td>'.__('Content 2 3', 'ct').'</td></tr>'."\n".
						'<tr><td>'.__('Content 3 1', 'ct').'</td><td>'.__('Content 3 2', 'ct').'</td><td>'.__('Content 3 3', 'ct').'</td></tr>'."\n".
						'</tbody></table>',
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Row Headers For Responsive', 'ct'),
					'param_name' => 'row_headers',
					'value' => array(__('Yes', 'ct') => '1')
				),
			)),
		),

		'ct_team' => array(
			'name' => __('Team', 'ct'),
			'base' => 'ct_team',
			'icon' => 'ct-icon-wpb-ui-team',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Team overview inside content', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(
						__('Style 1', 'ct') => '1',
						__('Style 2', 'ct') => '2',
						__('Style 3', 'ct') => '3',
						__('Style 4', 'ct') => '4',
						__('Style 5', 'ct') => '5',
						__('Style 6', 'ct') => '6',
					)
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Teams', 'ct'),
					'param_name' => 'team',
					'value' => ct_vc_get_terms('ct_teams'),
					'group' =>__('Select Teams', 'ct'),
					'edit_field_class' => 'ct-terms-checkboxes'
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Columns', 'ct'),
					'param_name' => 'columns',
					'value' => array(1, 2, 3, 4),
					'std' => 3
				),
			)),
		),

		'ct_testimonials' => array(
			'name' => __('Testimonials', 'ct'),
			'base' => 'ct_testimonials',
			'icon' => 'ct-icon-wpb-ui-testimonials',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Testimonials', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(
						__('Style 1', 'ct') => 'style1',
						__('Style 2', 'ct') => 'style2'
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Testimonials Sets', 'ct'),
					'param_name' => 'set',
					'value' => ct_vc_get_terms('ct_testimonials_sets'),
					'group' =>__('Select Testimonials Sets', 'ct'),
					'edit_field_class' => 'ct-terms-checkboxes'
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Image Size', 'ct'),
					'param_name' => 'image_size',
					'value' => array(
						__('Small', 'ct') => 'size-small',
						__('Medium', 'ct') => 'size-medium',
						__('Large', 'ct') => 'size-large',
						__('Xlarge', 'ct') => 'size-xlarge'
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Fullwidth', 'ct'),
					'param_name' => 'fullwidth',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Autoscroll', 'ct'),
					'param_name' => 'autoscroll',
				),
			)),
		),

		'ct_textbox' => array(
			'name' => __('Styled Textbox', 'ct'),
			'base' => 'ct_textbox',
			'is_container' => true,
			'js_view' => 'VcCTTextboxView',
			'icon' => 'ct-icon-wpb-ui-textbox',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Customizable block of text', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'ct'),
					'param_name' => 'style',
					'value' => array(
						__('Default / No Title ', 'ct') => 'default',
						__('With Title Area', 'ct') => 'title',
						__('Picturebox ', 'ct') => 'picturebox',
						__('Iconedbox ', 'ct') => 'iconedbox',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon pack', 'ct'),
					'param_name' => 'icon_pack',
					'value' => array_merge(array(__('Elegant', 'ct') => 'elegant', __('Material Design', 'ct') => 'material', __('FontAwesome', 'ct') => 'fontawesome'), ct_userpack_to_dropdown()),
					'dependency' => array(
						'element' => 'style',
						'value' => array('title', 'iconedbox')
					),
					'group' => __( 'Title', 'ct' ),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_elegant',
					'icon_pack' => 'elegant',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('elegant')
					),
					'group' => __( 'Title', 'ct' ),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_material',
					'icon_pack' => 'material',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('material')
					),
					'group' => __( 'Title', 'ct' ),
				),
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
					'param_name' => 'icon_fontawesome',
					'icon_pack' => 'fontawesome',
					'dependency' => array(
						'element' => 'icon_pack',
						'value' => array('fontawesome')
					),
					'group' => __( 'Title', 'ct' ),
				),
			),
			ct_userpack_to_shortcode(array(
				array(
					'type' => 'ct_icon',
					'heading' => __('Icon', 'ct'),
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
					'heading' => __('Icon Shape', 'ct'),
					'param_name' => 'icon_shape',
					'value' => array(__('Square', 'ct') => 'square', __('Circle', 'ct') => 'circle', __('Rhombus', 'ct') => 'romb', __('Hexagon', 'ct') => 'hexagon'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('title', 'iconedbox')
					),
					'group' => __( 'Title', 'ct' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon Style', 'ct'),
					'param_name' => 'icon_style',
					'value' => array(__('Default', 'ct') => '', __('45 degree Right', 'ct') => 'angle-45deg-r', __('45 degree Left', 'ct') => 'angle-45deg-l', __('90 degree', 'ct') => 'angle-90deg'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('title', 'iconedbox')
					),
					'group' => __( 'Title', 'ct' ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Icon Color', 'ct'),
					'param_name' => 'icon_color',
					'dependency' => array(
						'element' => 'style',
						'value' => array('title', 'iconedbox')
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'group' => __( 'Title', 'ct' ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Icon Color 2', 'ct'),
					'param_name' => 'icon_color_2',
					'dependency' => array(
						'element' => 'style',
						'value' => array('title', 'iconedbox')
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'group' => __( 'Title', 'ct' ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Icon Background Color', 'ct'),
					'param_name' => 'icon_background_color',
					'dependency' => array(
						'element' => 'style',
						'value' => array('title', 'iconedbox')
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'group' => __( 'Title', 'ct' ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Icon Border Color', 'ct'),
					'param_name' => 'icon_border_color',
					'dependency' => array(
						'element' => 'style',
						'value' => array('title', 'iconedbox')
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'group' => __( 'Title', 'ct' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Icon Size', 'ct'),
					'param_name' => 'icon_size',
					'value' => array(__('Small', 'ct') => 'small', __('Medium', 'ct') => 'medium', __('Large', 'ct') => 'large', __('Extra Large', 'ct') => 'xlarge'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('title', 'iconedbox')
					),
					'group' => __( 'Title', 'ct' ),
				),
				array(
					'type' => 'textarea_raw_html',
					'heading' => __('Title Area Content', 'ct'),
					'param_name' => 'title_content',
					'dependency' => array(
						'element' => 'style',
						'value' => array('title', 'iconedbox')
					),
					'group' => __( 'Title', 'ct' ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Title Text Color', 'ct'),
					'param_name' => 'title_text_color',
					'dependency' => array(
						'element' => 'style',
						'value' => array('title', 'iconedbox')
					),
					'group' => __( 'Title', 'ct' ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Title Background Color', 'ct'),
					'param_name' => 'title_background_color',
					'dependency' => array(
						'element' => 'style',
						'value' => array('title', 'iconedbox')
					),
					'group' => __( 'Title', 'ct' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Title Area Top Padding', 'ct'),
					'param_name' => 'title_padding_top',
					'dependency' => array(
						'element' => 'style',
						'value' => array('title', 'iconedbox')
					),
					'group' => __( 'Title', 'ct' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Title Area Bottom Padding', 'ct'),
					'param_name' => 'title_padding_bottom',
					'dependency' => array(
						'element' => 'style',
						'value' => array('title', 'iconedbox')
					),
					'group' => __( 'Title', 'ct' ),
				),
				array(
					'type' => 'attach_image',
					'heading' => __('Choose Image', 'ct'),
					'param_name' => 'picture',
					'dependency' => array(
						'element' => 'style',
						'value' => array('picturebox')
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Image position', 'ct'),
					'param_name' => 'picture_position',
					'value' => array(
						__('Top', 'ct') => 'top',
						__('Bottom', 'ct') => 'bottom',
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array('picturebox')
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Disable Lightbox', 'ct'),
					'param_name' => 'disable_lightbox',
					'value' => array(__('Yes', 'ct') => '1'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('picturebox')
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Content Text Color', 'ct'),
					'param_name' => 'content_text_color',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Content Background Color', 'ct'),
					'param_name' => 'content_background_color',
					'std' => '#f4f6f7',
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Use Gradient Backgound', 'ct'),
					'param_name' => 'gradient_backgound',
					'value' => array(__('Yes', 'ct') => '1')
				),

				array(
					'type' => 'colorpicker',
					'heading' => __('From', 'ct'),
					'param_name' => 'gradient_backgound_from',
					'dependency' => array(
						'element' => 'gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('To', 'ct'),
					'param_name' => 'gradient_backgound_to',

					'dependency' => array(
						'element' => 'gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					"type" => "dropdown",
					'heading' => __('Style', 'ct'),
					'param_name' => 'gradient_backgound_style',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					"value" => array(
						__('Linear', "ct") => "linear",
						__('Radial', "ct") => "radial",
					) ,
					"std" => 'linear',
					'dependency' => array(
						'element' => 'gradient_backgound',
						'value' => array('1')
					)
				),
				array(
					"type" => "dropdown",
					'heading' => __('Gradient Position', 'ct'),
					'param_name' => 'gradient_radial_backgound_position',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					"value" => array(
						__('Top', "ct") => "at top",
						__('Bottom', "ct") => "at bottom",
						__('Right', "ct") => "at right",
						__('Left', "ct") => "at left",
						__('Center', "ct") => "at center",

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
					'heading' => __('Custom Angle', 'ct'),
					'param_name' => 'gradient_backgound_angle',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					"value" => array(
						__('Vertical to bottom ↓', "ct") => "to bottom",
						__('Vertical to top ↑', "ct") => "to top",
						__('Horizontal to left  →', "ct") => "to right",
						__('Horizontal to right ←', "ct") => "to left",
						__('Diagonal from left to bottom ↘', "ct") => "to bottom right",
						__('Diagonal from left to top ↗', "ct") => "to top right",
						__('Diagonal from right to bottom ↙', "ct") => "to bottom left",
						__('Diagonal from right to top ↖', "ct") => "to top left",
						__('Custom', "ct") => "cusotom_deg",

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
					'heading' => __('Angle', 'ct'),
					'param_name' => 'gradient_backgound_cusotom_deg',
					"edit_field_class" => "vc_col-sm-4 vc_column",
					'description' => __('Set value in DG 0-360', 'ct'),
					'dependency' => array(
						'element' => 'gradient_backgound_angle',
						'value' => array(
							'cusotom_deg',
						)
					)
				),
				array(
					'type' => 'attach_image',
					'heading' => __('Content Background Image', 'ct'),
					'param_name' => 'content_background_image',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Background style', 'ct'),
					'param_name' => 'content_background_style',
					'value' => array(
						__('Default', 'ct') => '',
						__('Cover', 'ct') => 'cover',
						__('Contain', 'ct') => 'contain',
						__('No Repeat', 'ct') => 'no-repeat',
						__('Repeat', 'ct') => 'repeat'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Background horizontal position', 'ct'),
					'param_name' => 'content_background_position_horizontal',
					'value' => array(
						__('Center', 'ct') => 'center',
						__('Left', 'ct') => 'left',
						__('Right', 'ct') => 'right'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Background vertical position', 'ct'),
					'param_name' => 'content_background_position_vertical',
					'value' => array(
						__('Top', 'ct') => 'top',
						__('Center', 'ct') => 'center',
						__('Bottom', 'ct') => 'bottom'
					)
				),
				array(
					'type' => 'textfield',
					'heading' => __('Padding top', 'ct'),
					'param_name' => 'padding_top',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Padding bottom', 'ct'),
					'param_name' => 'padding_bottom',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Padding left', 'ct'),
					'param_name' => 'padding_left',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Padding right', 'ct'),
					'param_name' => 'padding_right',
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Border Color', 'ct'),
					'param_name' => 'border_color',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Border Width', 'ct'),
					'param_name' => 'border_width',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Border Radius', 'ct'),
					'param_name' => 'border_radius',
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Rectangle Corner', 'ct'),
					'param_name' => 'rectangle_corner',
					'value' => array(
						__('Left Top', 'ct') => 'lt',
						__('Right Top', 'ct') => 'rt',
						__('Right Bottom', 'ct') => 'rb',
						__('Left Bottom', 'ct') => 'lb'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Top Arеа Style', 'ct'),
					'param_name' => 'top_style',
					'value' => array(
						__('Default', 'ct') => 'default',
						__('Flag', 'ct') => 'flag',
						__('Shield', 'ct') => 'shield',
						__('Ticket', 'ct') => 'ticket',
						__('Sentence', 'ct') => 'sentence',
						__('Note 1', 'ct') => 'note-1',
						__('Note 2', 'ct') => 'note-2',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Bottom Arеа Style', 'ct'),
					'param_name' => 'bottom_style',
					'value' => array(
						__('Default', 'ct') => 'default',
						__('Flag', 'ct') => 'flag',
						__('Shield', 'ct') => 'shield',
						__('Ticket', 'ct') => 'ticket',
						__('Sentence', 'ct') => 'sentence',
						__('Note 1', 'ct') => 'note-1',
						__('Note 2', 'ct') => 'note-2',
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Centered', 'ct'),
					'param_name' => 'centered',
					'value' => array(__('Yes', 'ct') => '1')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Lazy loading enabled', 'ct'),
					'param_name' => 'effects_enabled',
					'value' => array(__('Yes', 'ct') => '1')
				),
			)),
		),

		'ct_youtube' => array(
			'name' => __('Youtube', 'ct'),
			'base' => 'ct_youtube',
			'icon' => 'ct-icon-wpb-ui-youtube',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Youtube video content', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'textfield',
					'heading' => __('Width', 'ct'),
					'param_name' => 'width',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Height', 'ct'),
					'param_name' => 'height',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Video Aspect ratio (16:9, 16:10, 4:3...)', 'ct'),
					'param_name' => 'aspect_ratio',
					'value' => '16:9'
				),
				array(
					'type' => 'textfield',
					'heading' => __('Video_id', 'ct'),
					'param_name' => 'video_id',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Border Style', 'ct'),
					'param_name' => 'style',
					'value' => array(
						__('no border', 'ct') => 'default',
						__('8px & border', 'ct') => '1',
						__('16px & border', 'ct') => '2',
						__('8px outlined border', 'ct') => '3',
						__('20px outlined border', 'ct') => '4',
						__('20px border with shadow', 'ct') => '5',
						__('Combined border', 'ct') => '6',
						__('20px border radius', 'ct') => '7',
						__('55px border radius', 'ct') => '8',
						__('Dashed inside', 'ct') => '9',
						__('Dashed outside', 'ct') => '10',
						__('Rounded with border', 'ct') => '11'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Position', 'ct'),
					'param_name' => 'position',
					'value' => array(__('below', 'ct') => 'below', __('left', 'ct') => 'left', __('right', 'ct') => 'right')
				),
			)),
		),

		'ct_vimeo' => array(
			'name' => __('Vimeo', 'ct'),
			'base' => 'ct_vimeo',
			'icon' => 'ct-icon-wpb-ui-vimeo',
			'category' => __('Codex Themes', 'ct'),
			'description' => __('Vimeo video content', 'ct'),
			'params' => array_merge(array(
				array(
					'type' => 'textfield',
					'heading' => __('Width', 'ct'),
					'param_name' => 'width',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Height', 'ct'),
					'param_name' => 'height',
				),
				array(
					'type' => 'textfield',
					'heading' => __('Video Aspect ratio (16:9, 16:10, 4:3...)', 'ct'),
					'param_name' => 'aspect_ratio',
					'value' => '16:9'
				),
				array(
					'type' => 'textfield',
					'heading' => __('Video id', 'ct'),
					'param_name' => 'video_id',
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Border Style', 'ct'),
					'param_name' => 'style',
					'value' => array(
						__('no border', 'ct') => 'default',
						__('8px & border', 'ct') => '1',
						__('16px & border', 'ct') => '2',
						__('8px outlined border', 'ct') => '3',
						__('20px outlined border', 'ct') => '4',
						__('20px border with shadow', 'ct') => '5',
						__('Combined border', 'ct') => '6',
						__('20px border radius', 'ct') => '7',
						__('55px border radius', 'ct') => '8',
						__('Dashed inside', 'ct') => '9',
						__('Dashed outside', 'ct') => '10',
						__('Rounded with border', 'ct') => '11'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Position', 'ct'),
					'param_name' => 'position',
					'value' => array(__('below', 'ct') => 'below', __('left', 'ct') => 'left', __('right', 'ct') => 'right')
				),
			)),
		),

	);

	$available_shortcodes = ct_available_shortcodes();
	$available_shortcodes = array_flip($available_shortcodes);
	$shortcodes = array_intersect_key($shortcodes, $available_shortcodes);

	return apply_filters('ct_shortcodes_array', $shortcodes);
}

function ct_VC_init() {
	if(ct_is_plugin_active('js_composer/js_composer.php')) {
		global $vc_manager;
		remove_filter('the_excerpt', array($vc_manager->vc(), 'excerptFilter'));
		add_action('admin_print_scripts-post.php', 'ct_printScriptsMessages');
		add_action('admin_print_scripts-post-new.php', 'ct_printScriptsMessages');
		$shortcodes = ct_shortcodes();
		foreach($shortcodes as $shortcode) {
			vc_map($shortcode);
		}
		$vc_layout_sub_controls = array(
			array( 'link_post', __( 'Link to post', 'ct' ) ),
			array( 'no_link', __( 'No link', 'ct' ) ),
			array( 'link_image', __( 'Link to bigger image', 'ct' ) )
		);
		$target_arr = array(
			__( 'Same window', 'ct' ) => '_self',
			__( 'New window', 'ct' ) => '_blank'
		);
		vc_add_param('vc_column_inner', array(
			'type' => 'column_offset',
			'heading' => __('Responsiveness', 'ct'),
			'param_name' => 'offset',
			'group' => __( 'Width & Responsiveness', 'ct' ),
			'description' => __('Adjust column for different screen sizes. Control width, offset and visibility settings.', 'ct')
		));
		vc_add_param('vc_gmaps', array(
			'type' => 'checkbox',
			'heading' => __('Deactivate Map Zoom By Scrolling', 'ct'),
			'param_name' => 'disable_scroll',
			'value' => array(__('Yes', 'ct') => '1')
		));
		vc_add_param('vc_gmaps', array(
			'type' => 'checkbox',
			'heading' => __('Hide GMaps Default Title Bar', 'ct'),
			'param_name' => 'hide_title',
			'value' => array(__('Yes', 'ct') => '1')
		));
		vc_add_param('vc_gmaps', array(
			'type' => 'dropdown',
			'heading' => __('Style', 'ct'),
			'param_name' => 'style',
			'value' => array(
				__('no border', 'ct') => 'default',
				__('8px & border', 'ct') => '1',
				__('16px & border', 'ct') => '2',
				__('8px outlined border', 'ct') => '3',
				__('20px outlined border', 'ct') => '4',
				__('20px border with shadow', 'ct') => '5',
				__('Combined border', 'ct') => '6',
				__('20px border radius', 'ct') => '7',
				__('55px border radius', 'ct') => '8',
				__('Dashed inside', 'ct') => '9',
				__('Dashed outside', 'ct') => '10',
				__('Rounded with border', 'ct') => '11'
			)
		));
		vc_add_param('vc_accordion', array(
			'type' => 'checkbox',
			'heading' => __('Lazy loading enabled', 'ct'),
			'param_name' => 'effects_enabled',
			'value' => array(__('Yes', 'ct') => '1')
		));
		vc_add_param('vc_text_separator', array(
			'type' => 'dropdown',
			'heading' => __('Title level', 'ct'),
			'param_name' => 'title_level',
			'value' => array(
				__('H1', 'ct') => 'h1',
				__('H2', 'ct') => 'h2',
				__('H3', 'ct') => 'h3',
				__('H4', 'ct') => 'h4',
				__('H5', 'ct') => 'h5',
				__('H6', 'ct') => 'h6',
				__('XLarge', 'ct') => 'xlarge',
				__('Styled Subtitle', 'ct') => 'styled-subtitle',
			),
			'std' => 'h2',
			'weight' => 5
		));
		vc_add_param('vc_text_separator', array(
			'type' => 'checkbox',
			'heading' => __('Use light version of title', 'ct'),
			'param_name' => 'title_light',
			'value' => array(__('Yes', 'ct') => '1'),
			'dependency' => array(
				'element' => 'title_level',
				'value' => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'xlarge')
			),
			'weight' => 5
		));
		vc_add_param('contact-form-7', array(
			'type' => 'dropdown',
			'heading' => __('Style', 'thegem'),
			'param_name' => 'html_class',
			'value' => array(
				__('Default', 'ct') => '',
				__('White', 'ct') => 'ct-contact-form-white',
				__('Dark', 'ct') => 'ct-contact-form-dark',
			)
		));
		vc_remove_element('vc_carousel');
		vc_remove_element('vc_button');
		vc_remove_element('vc_cta_button');
		vc_remove_element('vc_cta_button2');
		vc_remove_element('vc_video');
		vc_remove_element('vc_flickr');
		vc_remove_element('vc_flickr');
		vc_remove_element('vc_icon');
		vc_remove_element('vc_cta');
		vc_map_update('vc_tta_section', array(
			'allowed_container_element' => array('vc_row', 'ct_textbox', 'ct_alert_box', 'ct_counter_box', 'ct_icon_with_text', 'ct_map_with_text', 'ct_pricing_table'),
		));
		vc_map_update('vc_column_inner', array(
			'allowed_container_element' => array('ct_textbox', 'ct_alert_box', 'ct_counter_box', 'ct_icon_with_text', 'ct_map_with_text', 'ct_pricing_table'),
		));
		vc_add_shortcode_param( 'ct_icon', 'ct_icon_settings_field' );
		vc_add_shortcode_param( 'ct_datepicker_param', 'ct_datepicker_param_settings_field');
		if(ct_is_plugin_active('woocommerce/woocommerce.php')) {
			add_filter( 'vc_autocomplete_ct_product_categories_ids_callback', 'CTProductCategoryCategoryAutocompleteSuggester', 10, 1 );
			vc_map(array(
				'name' => __( 'Codex Themes Product categories', 'js_composer' ),
				'base' => 'ct_product_categories',
				'icon' => 'icon-wpb-woocommerce',
				'category' => __( 'WooCommerce', 'js_composer' ),
				'description' => __( 'Display product categories loop', 'js_composer' ),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => __( 'Number', 'js_composer' ),
						'param_name' => 'number',
						'description' => __( 'The `number` field is used to display the number of products.', 'js_composer' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'Order by', 'js_composer' ),
						'param_name' => 'orderby',
						'value' => array(
							'',
							__( 'Date', 'js_composer' ) => 'date',
							__( 'ID', 'js_composer' ) => 'ID',
							__( 'Author', 'js_composer' ) => 'author',
							__( 'Title', 'js_composer' ) => 'title',
							__( 'Modified', 'js_composer' ) => 'modified',
							__( 'Random', 'js_composer' ) => 'rand',
							__( 'Comment count', 'js_composer' ) => 'comment_count',
							__( 'Menu order', 'js_composer' ) => 'menu_order',
						),
						'save_always' => true,
						'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'Sort order', 'js_composer' ),
						'param_name' => 'order',
						'value' => array(
							'',
							__( 'Descending', 'js_composer' ) => 'DESC',
							__( 'Ascending', 'js_composer' ) => 'ASC',
						),
						'save_always' => true,
						'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Columns', 'js_composer' ),
						'value' => 4,
						'param_name' => 'columns',
						'save_always' => true,
						'description' => __( 'How much columns grid', 'js_composer' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Number', 'js_composer' ),
						'param_name' => 'hide_empty',
						'description' => __( 'Hide empty', 'js_composer' ),
					),
					array(
						'type' => 'autocomplete',
						'heading' => __( 'Categories', 'js_composer' ),
						'param_name' => 'ids',
						'settings' => array(
							'multiple' => true,
							'sortable' => true,
						),
						'save_always' => true,
						'description' => __( 'List of product categories', 'js_composer' ),
					),
				),
			));
		}
		if($vc_manager->mode() != 'admin_frontend_editor' && $vc_manager->mode() != 'admin_page' && $vc_manager->mode() != 'page_editable') {
			add_filter('the_content', 'ct_run_shortcode', 7);
			add_filter('ct_print_shortcodes', 'ct_run_shortcode', 7);
			add_filter('widget_text', 'ct_run_shortcode', 7);
			add_filter('the_excerpt', 'ct_run_shortcode', 7);
		}
	} else {
		add_filter('the_content', 'ct_run_shortcode', 7);
		add_filter('ct_print_shortcodes', 'ct_run_shortcode', 7);
		add_filter('widget_text', 'ct_run_shortcode', 7);
		add_filter('the_excerpt', 'ct_run_shortcode', 7);
	}
}
add_action('init', 'ct_VC_init', 11);

function ct_update_vc_shortcodes_params() {
	$param = WPBMap::getParam('vc_gmaps', 'link');
	$param['description'] = sprintf( __( 'Visit <a href="%s" target="_blank">Google maps</a> to create your map. 1) Find location 2) Click "Share" and make sure map is public on the web 3) Click folder icon to reveal "Embed on my site" link 4) Copy iframe code and paste it here.', 'ct' ), 'https://www.google.com/maps/d/');
	vc_update_shortcode_param('vc_gmaps', $param);
}
add_action('vc_after_init', 'ct_update_vc_shortcodes_params');

add_action( 'vc_before_init', 'ct_vc_shortcodes_classes' );
function ct_vc_shortcodes_classes() {
	if(class_exists('WPBakeryShortCodesContainer')) {
		class WPBakeryShortCode_ct_alert_box extends WPBakeryShortCodesContainer {}
		class WPBakeryShortCode_ct_fullwidth extends WPBakeryShortCodesContainer {}
		class WPBakeryShortCode_ct_map_with_text extends WPBakeryShortCodesContainer {}
		class WPBakeryShortCode_ct_icon_with_text extends WPBakeryShortCodesContainer {}
		class WPBakeryShortCode_ct_textbox extends WPBakeryShortCodesContainer {}
		class WPBakeryShortCode_ct_counter_box extends WPBakeryShortCodesContainer {}
		class WPBakeryShortCode_ct_pricing_table extends WPBakeryShortCodesContainer {}
		class WPBakeryShortCode_ct_pricing_column extends WPBakeryShortCodesContainer {}
	}
}

function ct_js_remove_wpautop($content, $autop = false) {
	if(ct_is_plugin_active('js_composer/js_composer.php')) {
		return wpb_js_remove_wpautop($content, $autop);
	}
	return $content;
}

function ct_portfolio_slider_shortcode($atts) {
	extract(shortcode_atts(array(
		'portfolios' => '',
		'portfolio_title' => '',
		'portfolio_layout' => '3x',
		'portfolio_no_gaps' => '',
		'portfolio_display_titles' => 'page',
		'portfolio_hover' => 'default',
		'portfolio_background_style' => 'white',
		'portfolio_show_info' => '',
		'portfolio_disable_socials' => '',
		'portfolio_fullwidth_columns' => '4',
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

function ct_portfolio_shortcode($atts) {
	extract(shortcode_atts(array(
		'portfolios' => '',
		'portfolio_layout' => '2x',
		'portfolio_style' => 'justified',
		'portfolio_layout_version' => 'fullwidth',
		'portfolio_caption_position' => 'right',
		'portfolio_gaps_size' => 42,
		'portfolio_display_titles' => 'page',
		'portfolio_background_style' => 'white',
		'portfolio_hover' => 'default',
		'portfolio_pagination' => 'normal',
		'loading_animation' => 'move-up',
		'portfolio_items_per_page' => 8,
		'portfolio_show_info' => '',
		'portfolio_with_filter' => '',
		'portfolio_title' => '',
		'portfolio_disable_socials' => '',
		'portfolio_fullwidth_columns' => '4',
		'portfolio_likes' => false,
		'portfolio_sorting' => false,
		'metro_max_row_height' => 380
	), $atts, 'ct_portfolio'));
	if(ct_is_plugin_active('js_composer/js_composer.php')) {
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

function ct_vc_get_terms($taxonomy) {
	if(!taxonomy_exists($taxonomy)) return array();
	$terms = get_terms($taxonomy, array('hide_empty' => false));
	$sets = array();
	foreach ($terms as $term) {
		$sets[$term->name] = $term->slug;
	}
	return $sets;
}

function ct_vc_get_blog_categories() {
	$terms = get_terms('category', array('hide_empty' => false));
	$categories = array();
	foreach ($terms as $term) {
		$categories[$term->name.' ('.__('Posts', 'ct').')'] = $term->slug;
	}
	if(taxonomy_exists('ct_news_sets')) {
		$terms = get_terms('ct_news_sets', array('hide_empty' => false));
		foreach ((array)$terms as $term) {
			$categories[$term->name.' ('.__('News', 'ct').')'] = $term->slug;
		}
	}
	return $categories;
}

function ct_printScriptsMessages() {
	if(in_array( get_post_type(), vc_editor_post_types())) {
		wp_enqueue_script('ct_js_composer_js_custom_views');
	}
}

function ct_add_tta_tabs_tour_accordion_color() {
	$param_ct = array(__( 'Codex Themes', 'ct' ) => 'ct');
	$param = WPBMap::getParam( 'vc_tta_tabs', 'color' );
	$param['value'] = array_merge($param_ct, $param['value']);
	$param['std'] = 'ct';
	vc_update_shortcode_param( 'vc_tta_tabs', $param );
	$param = WPBMap::getParam( 'vc_tta_tour', 'color' );
	$param['value'] = array_merge($param_ct, $param['value']);
	$param['std'] = 'ct';
	vc_update_shortcode_param( 'vc_tta_tour', $param );
	$param = WPBMap::getParam( 'vc_tta_accordion', 'color' );
	$param['value'] = array_merge($param_ct, $param['value']);
	$param['std'] = 'ct';
	vc_update_shortcode_param( 'vc_tta_accordion', $param );
}
add_action( 'vc_after_init', 'ct_add_tta_tabs_tour_accordion_color' );

function ct_add_tta_accordion_styles_icons() {
	$param = WPBMap::getParam( 'vc_tta_accordion', 'style' );
	$param['value'][__( 'Simple solid', 'ct' )] = 'simple_solid';
	$param['value'][__( 'Simple dashed', 'ct' )] = 'simple_dashed';
	vc_update_shortcode_param( 'vc_tta_accordion', $param );
	$param = WPBMap::getParam( 'vc_tta_accordion', 'c_icon' );
	$param['value'][__( 'Solid squared', 'ct' )] = 'solid_squared';
	$param['value'][__( 'Solid rounded', 'ct' )] = 'solid_rounded';
	$param['value'][__( 'Outlined rounded', 'ct' )] = 'outlined_rounded';
	vc_update_shortcode_param( 'vc_tta_accordion', $param );
}
add_action( 'vc_after_init', 'ct_add_tta_accordion_styles_icons' );

function ct_add_vc_shortcodes_pagination_styles() {
	$param_ct = array(
		__( 'None', 'js_composer' ) => '',
		__( 'Codex Themes Circle', 'ct' ) => 'ct-circle',
		__( 'Codex Themes Square', 'ct' ) => 'ct-square'
	);
	$param = WPBMap::getParam( 'vc_tta_tabs', 'pagination_style' );
	$param['value'] = array_merge($param_ct, $param['value']);
	vc_update_shortcode_param( 'vc_tta_tabs', $param );
	$param = WPBMap::getParam( 'vc_tta_tour', 'pagination_style' );
	$param['value'] = array_merge($param_ct, $param['value']);
	vc_update_shortcode_param( 'vc_tta_tour', $param );
	$param = WPBMap::getParam( 'vc_tta_pageable', 'pagination_style' );
	$param['value'] = array_merge($param_ct, $param['value']);
	$param['std'] = 'ct-circle';
	vc_update_shortcode_param( 'vc_tta_pageable', $param );
}
add_action( 'vc_after_init', 'ct_add_vc_shortcodes_pagination_styles' );

function ct_add_vc_column_text_effects() {
	$param = WPBMap::getParam( 'vc_column_text', 'css_animation' );
	$param['value'][__( 'Fade', 'ct' )] = 'fade';
	vc_update_shortcode_param( 'vc_column_text', $param );
}
//add_action( 'vc_after_init', 'ct_add_vc_column_text_effects' );

function ct_product_categories($atts) {
	global $ct_product_categories_images;
	$ct_product_categories_images = true;
	$output = WC_Shortcodes::product_categories($atts);
	$ct_product_categories_images = false;
	return $output;
}
add_shortcode('ct_product_categories', 'ct_product_categories');

function CTProductCategoryCategoryAutocompleteSuggester( $query, $slug = false ) {
	global $wpdb;
	$cat_id = (int) $query;
	$query = trim( $query );
	$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
					FROM {$wpdb->term_taxonomy} AS a
					INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
					WHERE a.taxonomy = 'product_cat' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )", $cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

	$result = array();
	if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
		foreach ( $post_meta_infos as $value ) {
			$data = array();
			$data['value'] = $slug ? $value['slug'] : $value['id'];
			$data['label'] = __( 'Id', 'js_composer' ) . ': ' . $value['id'] . ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . __( 'Name', 'js_composer' ) . ': ' . $value['name'] : '' ) . ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . __( 'Slug', 'js_composer' ) . ': ' . $value['slug'] : '' );
			$result[] = $data;
		}
	}

	return $result;
}

function ct_socials_shortcode($atts) {
	$atts = shortcode_atts(array(
		'style' => 'default',
		'colored' => 'default',
		'color' => '',
		'alignment' => 'left',
		'icons_size' => 16,
		'socials' => urlencode(json_encode(array(
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
		)))
	), $atts, 'ct_socials');
	if($atts['colored'] != 'custom') {
		$atts['color'] = '';
	}
	$socials = vc_param_group_parse_atts($atts['socials']);
	$socials_html = '';
	foreach($socials as $social) {
		$social = shortcode_atts(array(
			'social' => 'facebook',
			'url' => '#',
			'svg' => '',
			'viewbox' =>'0 0 32 32'
		), $social);
		if($social['social'] === 'custom') {
			$socials_html .= '<a class="socials-item" target="_blank" href="'.$social['url'].'"><i class="socials-item-icon '.$social['social'].'" style="font-size: '.$atts['icons_size'].'px"><svg viewBox="'.$social['viewbox'].'" style="width: '.$atts['icons_size'].'px; height: '.$atts['icons_size'].'px;'.($atts['color'] ? 'fill: '.$atts['color'].';' : '').'"><path d="'.$social['svg'].'"/></svg></i></a>';
		} else {
			$socials_html .= '<a class="socials-item" target="_blank" href="'.$social['url'].'"'.($atts['color'] ? ' style="color: '.$atts['color'].';"' : '').'><i class="socials-item-icon '.$social['social'].'" style="font-size: '.$atts['icons_size'].'px"></i></a>';
		}
	}
	return '<div class="socials socials-list '.($atts['colored'] != 'custom' ? 'socials-colored' : 'socials-colored-hover').' socials-'.$atts['style'].' socials-alignment-'.$atts['alignment'].'">'.$socials_html.'</div>';
}

add_action( 'vc_before_init', 'ct_disable_vc_updater' );
function ct_disable_vc_updater() {
	global $vc_manager;
	$vc_manager->disableUpdater(true);
}

function ct_search_form_shortcode($atts) {
	$atts = shortcode_atts(array(
		'style' => 'light',
		'alignment' => 'left',
		'placeholder' => __('Search', 'ct')
	), $atts, 'ct_search_form');
	$output = '<div class="ct-search-form ct-search-form-style-'.$atts['style'].' ct-search-form-alignment-'.$atts['alignment'].'">'.
		'<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">'.
		'<input class="search-field" type="search" name="s" placeholder="'.$atts['placeholder'].'" />'.
		'<button class="search-submit" type="submit"></button>'.
		'</form>'.
		'</div>';
	return $output;
}

function ct_icon_settings_field( $settings, $value ) {
	add_thickbox();
	wp_enqueue_style('icons-'.$settings['icon_pack']);
	wp_enqueue_script('ct-icons-picker');
	return '<div class="ct_icon_block">'
		.'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput icons-picker ' .
		esc_attr( $settings['param_name'] ) . ' ' .
		esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" data-iconpack="'.esc_attr( $settings['icon_pack'] ).'" />'
		.'</div>'.
		'<script type="text/javascript">'.
			'(function($) {'.
				'$(function() {'.
					'jQuery(\'.icons-picker\').iconsPicker();'.
				'});'.
			'})(jQuery);'.
		'</script>';
}

/* COUNTDOWN */

function ct_datepickerTimeToTimestamp($eventdate){
	$date = preg_split('//u',$eventdate,-1,PREG_SPLIT_NO_EMPTY);
	$day = $date[0].$date[1];
	$month = $date[3].$date[4];
	$year = $date[6].$date[7].$date[8].$date[9];

	return mktime(0, 0, 0, $month, $day, $year);
}

function ct_countdown_shortcode($atts){
	extract(shortcode_atts(array(
		'style' => 'style-3',
		'eventdate' => date('d-m-Y', (time() + 84900)),
		'start_eventdate' => date('d-m-Y', (time() - 84900)),
		'aligment' => 'align-left',
		'extraclass' => '',
		'color_number' => '#333333',
		'color_text' => '#333333',
		'color_border' => '#333333',
		'color_background' => '',
		'countdown_text' => '',
		'color_days' => '#333333',
		'color_hours' => '#333333',
		'color_minutes' => '#333333',
		'color_seconds' => '#333333',
		'weight_number' => 8
	), $atts, 'countdown_shortcode'));

	wp_enqueue_script('ct-countdown');
	wp_enqueue_style('ct-countdown');
	$eventdate_timestamp = ct_datepickerTimeToTimestamp($eventdate);
	$eventdate_start_timestamp = ct_datepickerTimeToTimestamp($start_eventdate);

	if ($style == 'style-3'){
		$output  = "<div data-eventdate='".esc_attr($eventdate_timestamp)."' class='countdown-container countdown-style-3 ".esc_attr($extraclass)."'>";
		$output .= "<div class='countdown-wrapper countdown-info'>";
		$output .= "<div class='countdown-item count-1'><div class='wrap' style='background:".esc_attr($color_background)."; border-color: ".esc_attr($color_border)."'><span class='item-count countdown-days title-h1' style='color:".esc_attr($color_number)."'></span><span class='item-title styled-subtitle' style='color:".esc_attr($color_text)."'>".__('Days', 'ct')."</span></div></div>";
		$output .= "<div class='countdown-item count-2'><div class='wrap' style='background:".esc_attr($color_background)."; border-color: ".esc_attr($color_border)."'><span class='item-count countdown-hours title-h1' style='color:".esc_attr($color_number)."'></span><span class='item-title styled-subtitle' style='color:".esc_attr($color_text)."'>".__('Hours', 'ct')."</span></div></div>";
		$output .= "<div class='countdown-item count-3'><div class='wrap' style='background:".esc_attr($color_background)."; border-color: ".esc_attr($color_border)."'><span class='item-count countdown-minutes title-h1' style='color:".esc_attr($color_number)."'></span><span class='item-title styled-subtitle' style='color:".esc_attr($color_text)."'>".__('Minutes', 'ct')."</span></div></div>";
		$output .= "<div class='countdown-item count-4'><div class='wrap' style='background:".esc_attr($color_background)."; border-color: ".esc_attr($color_border)."'><span class='item-count countdown-seconds title-h1' style='color:".esc_attr($color_number)."'></span><span class='item-title styled-subtitle' style='color:".esc_attr($color_text)."'>".__('Seconds', 'ct')."</span></div></div>";
		$output .= "</div></div><div style='clear: both'></div>";

		return $output;
	}

	if ($style == 'style-4'){
		$output  = "<div data-eventdate='".esc_attr($eventdate_timestamp)."' class='countdown-container countdown-style-4 ".esc_attr($aligment)." ".esc_attr($extraclass)."'>";
		$output .= "<div class='countdown-wrapper countdown-info'>";
		$output .= "<div class='countdown-item count-1'><div class='wrap' style='border-color: ".esc_attr($color_border)."'><span class='item-count countdown-days title-h2' style='color:".esc_attr($color_number)."'></span><span class='item-title' style='color:".esc_attr($color_text)."'>".__('Days', 'ct')."</span></div></div>";
		$output .= "<div class='countdown-item count-2'><div class='wrap' style='border-color: ".esc_attr($color_border)."'><span class='item-count countdown-hours title-h2' style='color:".esc_attr($color_number)."'></span><span class='item-title' style='color:".esc_attr($color_text)."'>".__('Hours', 'ct')."</span></div></div>";
		$output .= "<div class='countdown-item count-3'><div class='wrap' style='border-color: ".esc_attr($color_border)."'><span class='item-count countdown-minutes title-h2' style='color:".esc_attr($color_number)."'></span><span class='item-title' style='color:".esc_attr($color_text)."'>".__('Minutes', 'ct')."</span></div></div>";
		$output .= "<div class='countdown-item count-4'><div class='wrap'><span class='item-count countdown-seconds title-h2' style='color:".esc_attr($color_number)."'></span><span class='item-title' style='color:".esc_attr($color_text)."'>".__('Seconds', 'ct')."</span></div></div>";
		$output .= "</div></div><div style='clear: both;'></div>";

		return $output;
	}

	$weight_class = '';
	if($weight_number == 4){
		$weight_class = 'light';
	}

	if ($style == 'style-5'){
		$output  = "<div data-eventdate='".esc_attr($eventdate_timestamp)."' data-starteventdate='".esc_attr($eventdate_start_timestamp)."'  data-colordays='".esc_attr($color_days)."' data-colorhours='".esc_attr($color_hours)."' data-colorminutes='".esc_attr($color_minutes)."' data-colorseconds='".esc_attr($color_seconds)."' data-weightnumber='".esc_attr($weight_number)."' class='countdown-container countdown-style-5 ".esc_attr($aligment)." ".esc_attr($extraclass)."'>";
		$output .= "<div class='countdown-wrapper countdown-info'>";
		$output .= "<div class='countdown-item count-1'><div class='circle-raphael-days'></div><div class='wrap'><span class='item-count countdown-days title-h1 ".$weight_class."' style='color:".esc_attr($color_days )."'></span><span class='item-title styled-subtitle' style='color:".esc_attr($color_text)."'>".__('Days', 'ct')."</span></div></div>";
		$output .= "<div class='countdown-item count-2'><div class='circle-raphael-hours'></div><div class='wrap'><span class='item-count countdown-hours title-h1 ".$weight_class."' style='color:".esc_attr($color_hours)."'></span><span class='item-title styled-subtitle' style='color:".esc_attr($color_text)."'>".__('Hours', 'ct')."</span></div></div>";
		$output .= "<div class='countdown-item count-3'><div class='circle-raphael-minutes'></div><div class='wrap'><span class='item-count countdown-minutes title-h1 ".$weight_class."' style='color:".esc_attr($color_minutes)."'></span><span class='item-title styled-subtitle' style='color:".esc_attr($color_text)."'>".__('Minutes', 'ct')."</span></div></div>";
		$output .= "<div class='countdown-item count-4'><div class='circle-raphael-seconds'></div><div class='wrap'><span class='item-count countdown-seconds title-h1 ".$weight_class."' style='color:".esc_attr($color_seconds)."'></span><span class='item-title styled-subtitle' style='color:".esc_attr($color_text)."'>".__('Seconds', 'ct')."</span></div></div>";
		$output .= "</div></div><div style='clear: both'></div>";


		return $output;
	}

	if ($style == 'style-6'){
		$output  = "<div data-eventdate='".esc_attr($eventdate_timestamp)."' class='countdown-container countdown-style-6 ".esc_attr($aligment)." ".esc_attr($extraclass)."'>";
		$output .= "<div class='countdown-wrapper countdown-info'>";
		$output .= "<div class='countdown-item count-1'><div class='wrap'><div class='countdown-item-border-1' style='background:".esc_attr($color_border)."'></div><span class='item-title' style='color:".esc_attr($color_text)."'>".__('Days', 'ct')."</span><span class='item-count countdown-days title-xlarge' style='color:".esc_attr($color_number)."'></span></div></div>";
		$output .= "<div class='countdown-item count-2'><div class='wrap'><div class='countdown-item-border-2' style='background:".esc_attr($color_border)."'></div><span class='item-title' style='color:".esc_attr($color_text) ."'>".__('Hours', 'ct')."</span><span class='item-count countdown-hours title-xlarge' style='color:".esc_attr($color_number)."'></span></div></div>";
		$output .= "<div class='countdown-item count-3'><div class='wrap'><div class='countdown-item-border-3' style='background:".esc_attr($color_border)."'></div><span class='item-title' style='color:".esc_attr($color_text)."'>".__('Minutes', 'ct')."</span><span class='item-count countdown-minutes title-xlarge' style='color:".esc_attr($color_number)."'></span></div></div>";
		$output .= "<div class='countdown-item count-4'><div class='wrap'><div class='countdown-item-border-4' style='background:".esc_attr($color_border)."'></div><span class='item-title' style='color:".esc_attr($color_text)."'>".__('Seconds', 'ct')."</span><span class='item-count countdown-seconds title-xlarge' style='color:".esc_attr($color_number)."'></span></div></div>";
		$output .= "</div></div><div style='clear: both'></div>";

		return $output;
	}

	if ($style == 'style-7'){
		$output  = "<div data-eventdate='".esc_attr($eventdate_timestamp)."' class='countdown-container countdown-style-7 ".esc_attr($aligment)." ".esc_attr($extraclass)."'>";
		$output .= "<div class='countdown-wrapper countdown-info'>";
		$output .= "<div class='countdown-item'><div class='wrap'><span class='item-count countdown-days title-xlarge' style='color:".esc_attr($color_number)."'></span></div>";
		if(!empty($countdown_text)){
			$output .= "<div class='countdown-text styled-subtitle' style='color:".esc_attr($color_text)."'>". $countdown_text ."</div>";
		}
		$output .= "</div></div></div><div style='clear: both'></div>";

		return $output;
	}
}

function ct_datepicker_param_settings_field($settings, $value){
	return "<input class='countdown_datepicker wpb_vc_param_value wpb-textinput " . esc_attr( $settings['param_name'] ) . ' ' .esc_attr( $settings['type'] ) . "_field' type='text' name='" . esc_attr( $settings['param_name'] ) . "' value='". $value ."'><script>jQuery(\".countdown_datepicker\").each(function () {
			if(!jQuery(this).data('datepicker')) {
				 jQuery(this).data('datepicker', true);
					jQuery(this).datepicker({
					constraintInput:true,
					dateFormat: \"dd-mm-yy\",
					showOtherMonths: true,
					selectOtherMonths: true,
					beforeShow: function(input, inst) {
						if(!inst.dpDiv.parent('.ui-lightness').length) {
							inst.dpDiv.wrap('<div class=\"ui-lightness\"/>');
						}
					}
				});
			}
		});</script>";

}

add_action('admin_enqueue_scripts', 'ct_countdown_admin_styles');
function ct_countdown_admin_styles(){
	wp_enqueue_style('jquery-ui-lightness', get_template_directory_uri() . '/css/jquery-ui/ui-lightness/jquery-ui.css');
	wp_enqueue_script('jquery-ui-datepicker');
}
