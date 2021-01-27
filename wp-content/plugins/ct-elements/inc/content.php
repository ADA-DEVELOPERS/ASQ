<?php

function ct_slideshow_block($params = array()) {
	if($params['slideshow_type'] == 'LayerSlider') {
		if($params['lslider']) {
			echo '<div class="preloader slideshow-preloader"><div class="preloader-spin"></div></div><div class="ct-slideshow">';
			echo do_shortcode('[layerslider id="'.$params['lslider'].'"]');
			echo '</div>';
		}
	} elseif($params['slideshow_type'] == 'revslider') {
		if($params['slider']) {
			echo '<div class="preloader slideshow-preloader"><div class="preloader-spin"></div></div><div class="ct-slideshow">';
			echo do_shortcode('[rev_slider alias="'.$params['slider'].'"]');
			echo '</div>';
		}
	} elseif($params['slideshow_type'] == 'NivoSlider') {
		echo '<div class="preloader slideshow-preloader"><div class="preloader-spin"></div></div><div class="ct-slideshow">';
		ct_nivoslider($params);
		echo '</div>';
	}
}

/* QUICKFINDER BLOCK */

function ct_quickfinder($params) {
	$params = is_array($params) ? $params : array();
	$params = array_merge(array(
		'quickfinders' => '',
		'style' => 'default',
		'columns' => 4,
		'alignment' => 'center',
		'icon_position' => 'top',
		'title_weight' => 'bold',
		'activate_button' => 0,
		'button_style' => 'flat',
		'button_text_weight' => 'normal',
		'button_corner' => 3,
		'button_text_color' => '',
		'button_background_color' => '',
		'button_border_color' => '',
		'hover_icon_color' => '',
		'hover_box_color' => '',
		'hover_border_color' => '',
		'hover_title_color' => '',
		'hover_description_color' => '',
		'hover_button_background_color' => '',
		'hover_button_text_color' => '',
		'hover_button_border_color' => '',
		'box_style' => 'solid',
		'box_background_color' => '',
		'box_border_color' => '',
		'connector_color' => '',
		'effects_enabled' => ''
	), $params);
	$params['style'] = ct_check_array_value(array('default', 'classic', 'iconed', 'binded', 'binded-iconed', 'tag', 'vertical-1', 'vertical-2', 'vertical-3', 'vertical-4'), $params['style'], 'default');
	$params['columns'] = ct_check_array_value(array(1,2,3,4,6), $params['columns'], 4);
	$params['alignment'] = ct_check_array_value(array('center', 'left', 'right'), $params['alignment'], 'center');
	$params['icon_position'] = ct_check_array_value(array('top', 'bottom', 'top-float', 'center-float'), $params['icon_position'], 'top');
	$params['title_weight'] = ct_check_array_value(array('bold', 'thin'), $params['title_weight'], 'bold');
	$params['activate_button'] = $params['activate_button'] ? 1 : 0;
	$params['hover_icon_color'] = esc_attr($params['hover_icon_color']);
	$params['hover_box_color'] = esc_attr($params['hover_box_color']);
	$params['hover_border_color'] = esc_attr($params['hover_border_color']);
	$params['hover_title_color'] = esc_attr($params['hover_title_color']);
	$params['hover_description_color'] = esc_attr($params['hover_description_color']);
	$params['hover_button_background_color'] = esc_attr($params['hover_button_background_color']);
	$params['hover_button_text_color'] = esc_attr($params['hover_button_text_color']);
	$params['hover_button_border_color'] = esc_attr($params['hover_button_border_color']);
	$params['box_style'] = ct_check_array_value(array('solid', 'soft-outlined', 'strong-outlined'), $params['box_style'], 'solid');
	$params['box_background_color'] = esc_attr($params['box_background_color']);
	$params['box_border_color'] = esc_attr($params['box_border_color']);
	$params['connector_color'] = esc_attr($params['connector_color']);
	$params['effects_enabled'] = $params['effects_enabled'] ? 1 : 0;

	$hover_data = '';
	if($params['hover_icon_color']) {
		$hover_data .= ' data-hover-icon-color="'.$params['hover_icon_color'].'"';
	}
	if($params['hover_box_color']) {
		$hover_data .= ' data-hover-box-color="'.$params['hover_box_color'].'"';
	}
	if($params['hover_border_color']) {
		$hover_data .= ' data-hover-border-color="'.$params['hover_border_color'].'"';
	}
	if($params['hover_title_color']) {
		$hover_data .= ' data-hover-title-color="'.$params['hover_title_color'].'"';
	}
	if($params['hover_description_color']) {
		$hover_data .= ' data-hover-description-color="'.$params['hover_description_color'].'"';
	}
	if($params['hover_button_background_color']) {
		$hover_data .= ' data-hover-button-background-color="'.$params['hover_button_background_color'].'"';
	}
	if($params['hover_button_text_color']) {
		$hover_data .= ' data-hover-button-text-color="'.$params['hover_button_text_color'].'"';
	}
	if($params['hover_button_border_color']) {
		$hover_data .= ' data-hover-button-border-color="'.$params['hover_button_border_color'].'"';
	}
	$binded = '';
	if($params['style'] == 'binded') {
		$params['style'] = 'classic';
		$binded = ' quickfinder-binded';
	}
	if($params['style'] == 'binded-iconed') {
		$params['style'] = 'iconed';
		$binded = ' quickfinder-binded';
	}

	$args = array(
		'post_type' => 'ct_qf_item',
		'orderby' => 'menu_order ID',
		'order' => 'ASC',
		'posts_per_page' => -1,
	);
	if($params['quickfinders'] != '') {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'ct_quickfinders',
				'field' => 'slug',
				'terms' => explode(',', $params['quickfinders'])
			)
		);
	}
	$quickfinder_items = new WP_Query($args);

	$quickfinder_style = $params['style'];
	$quickfinder_item_rotation = 'odd';

	$connector_color = $params['connector_color'];
	if(($quickfinder_style == 'vertical-1' || $quickfinder_style == 'vertical-2' || $quickfinder_style == 'vertical-3' || $quickfinder_style == 'vertical-4') && !$connector_color) {
		$connector_color = '#b6c6c9';
	}

	if($quickfinder_items->have_posts()) {
		wp_enqueue_script('ct-quickfinders-effects');
		echo '<div class="quickfinder quickfinder-style-'.$params['style'].$binded.' '.($quickfinder_style == 'vertical-1' || $quickfinder_style == 'vertical-2'  || $quickfinder_style == 'vertical-3' || $quickfinder_style == 'vertical-4' ? 'quickfinder-style-vertical' : 'row inline-row').' quickfinder-icon-position-'.$params['icon_position'].' quickfinder-alignment-'.$params['alignment'].' quickfinder-title-'.$params['title_weight'].'"'.$hover_data.'>';
		while($quickfinder_items->have_posts()) {
			$quickfinder_items->the_post();
			include(locate_template(array('ct-templates/quickfinders/content-quickfinder-item-'.$params['style'].'.php', 'ct-templates/quickfinders/content-quickfinder-item.php')));
			$quickfinder_item_rotation = $quickfinder_item_rotation == 'odd' ? 'even' : 'odd';
		}
		echo '</div>';
	}
	wp_reset_postdata();
}

function ct_quickfinder_block($params) {
	echo '<div class="container">';
	ct_quickfinder($params);
	echo '</div>';
}

/* TEAM BLOCK */

function ct_team($params) {
	$params = array_merge(array('team' => '', 'team_person' => '', 'style' => '', 'columns' => '2'), $params);
	$args = array(
		'post_type' => 'ct_team_person',
		'orderby' => 'menu_order ID',
		'order' => 'ASC',
		'posts_per_page' => -1,
	);
	if($params['team'] != '') {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'ct_teams',
				'field' => 'slug',
				'terms' => explode(',', $params['team'])
			)
		);
	} elseif($params['team_person'] != '') {
		$args['p'] = $params['team_person'];
	}
	$persons = new WP_Query($args);

	if($persons->have_posts()) {
		echo '<div class="ct-team row inline-row ct-team-'.esc_attr($params['style']).'">';
		while($persons->have_posts()) {
			$persons->the_post();
			include(locate_template(array('ct-templates/teams/content-team-person-'.$params['style'].'.php', 'ct-templates/teams/content-team-person.php')));
		}
		echo '</div>';
	}
	wp_reset_postdata();
}

/* GALLERY */

function ct_gallery($params) {
	$params = array_merge(array('gallery' => 0, 'hover' => 'default', 'layout' => 'fullwidth', 'no_thumbs' => 0, 'pagination' => 0, 'autoscroll' => 0), $params);

	if(metadata_exists('post', $params['gallery'], 'ct_gallery_images')) {
		$ct_gallery_images_ids = get_post_meta($params['gallery'], 'ct_gallery_images', true);
	} else {
		$attachments_ids = get_posts('post_parent=' . $params['gallery'] . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids');
		$ct_gallery_images_ids = implode(',', $attachments_ids);
	}
	$attachments_ids = array_filter(explode(',', $ct_gallery_images_ids));
?>
<?php if(count($attachments_ids)) : wp_enqueue_script('ct-gallery'); wp_enqueue_style('ct-animations'); ?>
	<div class="preloader"><div class="preloader-spin"></div></div>
	<div class="ct-gallery ct-gallery-hover-<?php echo esc_attr($params['hover']); ?><?php echo ($params['no_thumbs'] ? ' no-thumbs' : ''); ?><?php echo ($params['pagination'] ? ' with-pagination' : ''); ?>"<?php echo (intval($params['autoscroll']) ? ' data-autoscroll="'.intval($params['autoscroll']).'"' : ''); ?>>
	<?php foreach($attachments_ids as $attachment_id) : ?>
		<?php
			$item = get_post($attachment_id);
			if($item) {
				$thumb_image_url = wp_get_attachment_image_src($item->ID, 'ct-post-thumb');
				$preview_image_url = ct_generate_thumbnail_src($item->ID, 'ct-gallery-'.esc_attr($params['layout']));
				$full_image_url = wp_get_attachment_image_src($item->ID, 'full');
			}
		?>
		<?php if(!empty($thumb_image_url[0]) && $item) : ?>
			<div class="ct-gallery-item">
				<div class="ct-gallery-item-image">
					<a href="<?php echo $preview_image_url[0]; ?>" data-full-image-url="<?php echo esc_attr($full_image_url[0]); ?>">
						<svg width="20" height="10"><path d="M 0,10 Q 9,9 10,0 Q 11,9 20,10" /></svg>
						<img  src="<?php echo $thumb_image_url[0]; ?>" alt="" class="img-responsive">
						<span class="ct-gallery-caption slide-info">
							<?php if($item->post_excerpt) : ?><span class="ct-gallery-item-title "><?php echo apply_filters('the_excerpt', $item->post_excerpt); ?></span><?php endif; ?>
							<?php if($item->post_content) : ?><span class="ct-gallery-item-description"><?php echo apply_filters('the_content', $item->post_content); ?></span><?php endif; ?>
						</span>
					</a>
					<span class="ct-gallery-line"></span>
				</div>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
	</div>
<?php endif; ?>
<?php
}

function ct_simple_gallery($params) {
	$params = array_merge(array('gallery' => 0, 'thumb_size' => 'ct-gallery-simple', 'autoscroll' => 0, 'responsive' => 0), $params);

	if(metadata_exists('post', $params['gallery'], 'ct_gallery_images')) {
		$ct_gallery_images_ids = get_post_meta($params['gallery'], 'ct_gallery_images', true);
	} else {
		$attachments_ids = get_posts('post_parent=' . $params['gallery'] . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids');
		$ct_gallery_images_ids = implode(',', $attachments_ids);
	}
	$attachments_ids = array_filter(explode(',', $ct_gallery_images_ids));
?>
<?php if(count($attachments_ids)) : wp_enqueue_script('ct-gallery'); wp_enqueue_style('ct-animations'); ?>
	<div class="preloader"><div class="preloader-spin"></div></div>
	<div class="ct-simple-gallery<?php echo ($params['responsive'] ? ' responsive' : ''); ?>"<?php echo (intval($params['autoscroll']) ? ' data-autoscroll="'.intval($params['autoscroll']).'"' : ''); ?>>
	<?php foreach($attachments_ids as $attachment_id) : ?>
		<?php
			$item = get_post($attachment_id);
			if($item) {
				$thumb_image_url = ct_generate_thumbnail_src($item->ID, $params['thumb_size']);
				$full_image_url = wp_get_attachment_image_src($item->ID, 'full');
			}
		?>
		<?php if(!empty($thumb_image_url[0]) && $item) : ?>
			<div class="ct-gallery-item">
				<div class="ct-gallery-item-image">
					<a href="<?php echo esc_attr($full_image_url[0]); ?>">
						<img src="<?php echo $thumb_image_url[0]; ?>" alt="" class="img-responsive">
					</a>
				</div>
				<div class="ct-gallery-caption">
					<?php if($item->post_excerpt) : ?><div class="ct-gallery-item-title"><?php echo apply_filters('the_excerpt', $item->post_excerpt); ?></div><?php endif; ?>
					<?php if($item->post_content) : ?><div class="ct-gallery-item-description"><?php echo apply_filters('the_content', $item->post_content); ?></div><?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
	</div>
<?php endif; ?>
<?php
}

function ct_clients($params) {
	$params = array_merge(array(
		'clients_set' => '',
		'rows' => '3',
		'cols' => '3',
		'autoscroll' => '',
		'effects_enabled' => false,
		'disable_grayscale' => false,
		'widget' => false,
		'disable_carousel' => false,
	), $params);
	$args = array(
		'post_type' => 'ct_client',
		'orderby' => 'menu_order ID',
		'order' => 'ASC',
		'posts_per_page' => -1,
	);
	if($params['clients_set'] != '') {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'ct_clients_sets',
				'field' => 'slug',
				'terms' => explode(',', $params['clients_set'])
			)
		);
	}
	$clients_items = new WP_Query($args);

	$rows = ((int)$params['rows']) ? (int)$params['rows'] : 3;
	$cols = ((int)$params['cols']) ? (int)$params['cols'] : 3;

	$items_per_slide = $rows * $cols;
	$params['autoscroll'] = intval($params['autoscroll']);

	if($clients_items->have_posts()) {

		wp_enqueue_script('ct-clients-grid-carousel');
		if(!$params['disable_carousel']) {
			echo '<div class="preloader"><div class="preloader-spin"></div></div>';
		}
		echo '<div class="ct-clients ct-clients-type-carousel-grid '.($params['disable_carousel'] ? 'carousel-disabled ' : '') . ($params['disable_grayscale'] ? 'disable-grayscale ' : '') . ($params['effects_enabled'] ? 'lazy-loading' : '') . '" ' . ($params['effects_enabled'] ? 'data-ll-item-delay="0"' : '') . ' data-autoscroll="'.esc_attr($params['autoscroll']).'">';
		echo '<div class="ct-clients-slide"><div class="ct-clients-slide-inner clearfix">';
		$i = 0;
		while($clients_items->have_posts()) {
			$clients_items->the_post();
			if($i == $items_per_slide) {
				echo '</div></div><div class="ct-clients-slide"><div class="ct-clients-slide-inner clearfix">';
				$i = 0;
			}
			include(locate_template('content-clients-carousel-grid-item.php'));
			$i++;
		}
		echo '</div></div>';
		echo '</div>';
	}
	wp_reset_postdata();
}

function ct_testimonialss($params) {
	$params = array_merge(array('testimonials_set' => '', 'fullwidth' => '', 'autoscroll' => 0), $params);
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
		echo '<div class="'.$params['image_size'].' '.$params['style'].' ct-testimonials'.( $params['fullwidth'] ? ' fullwidth-block' : '' ).'"'.( intval($params['autoscroll']) ? ' data-autoscroll="'.intval($params['autoscroll']).'"' : '' ).'>';
		while($testimonials_items->have_posts()) {
			$testimonials_items->the_post();
			get_template_part('content', 'testimonials-carousel-item');
		}

		echo '<div  class="testimonials_svg"><svg width="100" height="50"><path d="M 0,-1 Q 45,5 50,50 Q 55,5 100,-1" /></svg></div>';

		echo '</div>';
	}
	wp_reset_postdata();
}

function portolios_cmp($term1, $term2) {
	$order1 = get_option('portfoliosets_' . $term1->term_id . '_order', 0);
	$order2 = get_option('portfoliosets_' . $term2->term_id . '_order', 0);
	if($order1 == $order2)
		return 0;
	return $order1 > $order2;
}

// Print Portfolio Block
function ct_portfolio($params) {
	$params = array_merge(
		array(
			'portfolio' => '',
			'title' => '',
			'layout' => '2x',
			'layout_version' => 'fullwidth',
			'caption_position' => 'right',
			'style' => 'justified',
			'gaps_size' => 42,
			'display_titles' => 'page',
			'background_style' => 'white',
			'hover' => '',
			'pagination' => 'normal',
			'loading_animation' => 'move-up',
			'items_per_page' => 8,
			'with_filter' => false,
			'show_info' => false,
			'is_ajax' => false,
			'disable_socials' => false,
			'fullwidth_columns' => '5',
			'likes' => false,
			'sorting' => false,
			'orderby' => '',
			'order' => '',
			'button' => array(),
			'metro_max_row_height' => 380
		),
		$params
	);

	$params['button'] = array_merge(apply_filters('ct_portfolio_load_more_button_defaults', array(
		'text' => __('Load More', 'ct'),
		'style' => 'flat',
		'size' => 'medium',
		'text_weight' => 'normal',
		'no_uppercase' => 0,
		'corner' => 25,
		'border' => 2,
		'text_color' => '',
		'background_color' => '#00bcd5',
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
		'separator' => 'load-more',
	)), $params['button']);


	$params['button']['icon'] = '';
	if($params['button']['icon_elegant'] && $params['button']['icon_pack'] == 'elegant') {
		$params['button']['icon'] = $params['button']['icon_elegant'];
	}
	if($params['button']['icon_material'] && $params['button']['icon_pack'] == 'material') {
		$params['button']['icon'] = $params['button']['icon_material'];
	}
	if($params['button']['icon_fontawesome'] && $params['button']['icon_pack'] == 'fontawesome') {
		$params['button']['icon'] = $params['button']['icon_fontawesome'];
	}
	if($params['button']['icon_userpack'] && $params['button']['icon_pack'] == 'userpack') {
		$params['button']['icon'] = $params['button']['icon_userpack'];
	}

	$params['loading_animation'] = ct_check_array_value(array('disabled', 'bounce', 'move-up', 'fade-in', 'fall-perspective', 'scale', 'flip'), $params['loading_animation'], 'move-up');

	$gap_size = round(intval($params['gaps_size'])/2);

	if (empty($params['fullwidth_columns']))
		$params['fullwidth_columns'] = 5;

	if ($params['sorting'] == 'false')
		$params['sorting'] = false;

	if ($params['sorting'] == 'true')
		$params['sorting'] = true;

	wp_enqueue_style('ct-portfolio');
	wp_enqueue_style('ct-animations');
	wp_enqueue_script('imagesloaded');
	wp_enqueue_script('isotope-js');
	wp_enqueue_script('ct-isotope-metro');
	wp_enqueue_script('ct-isotope-masonry-custom');
	wp_enqueue_script('ct-scroll-monitor');
	wp_enqueue_script('jquery-transform');
	wp_enqueue_script('ct-items-animations');
	wp_enqueue_script('ct-juraSlider');
	wp_enqueue_script('ct-portfolio');

	$portfolio_uid = substr( md5(rand()), 0, 7);

	$localize = array_merge(
		array('data' => $params),
		array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('portfolio_ajax-nonce')
		)
	);
	wp_localize_script('ct-portfolio', 'portfolio_ajax_'.$portfolio_uid, $localize);

	$layout_columns_count = -1;
	if($params['layout'] == '1x')
		$layout_columns_count = 1;
	if($params['layout'] == '2x')
		$layout_columns_count = 2;
	if($params['layout'] == '3x')
		$layout_columns_count = 3;
	if($params['layout'] == '4x')
		$layout_columns_count = 4;

	$items_per_page = intval($params['items_per_page']) ? intval($params['items_per_page']) : 8;

	$page = 1;
	$next_page = 0;

	if($params['pagination'] == 'more' || $params['pagination'] == 'scroll') {
		$count = $items_per_page;
		if(isset($params['more_count'])) {
			$count = intval($params['more_count']);
		}
		if($layout_columns_count == -1)
			$layout_columns_count = 5;
		if($count == 0)
			$count = $layout_columns_count * 2;
		$page = isset($params['more_page']) ? intval($params['more_page']) : 1;
		if($page == 0)
			$page = 1;
		$portfolio_loop = new WP_Query(array(
			'post_type' => 'ct_pf_item',
			'tax_query' =>$params['portfolio'] ? array(
				array(
					'taxonomy' => 'ct_portfolios',
					'field' => 'slug',
					'terms' => explode(',', $params['portfolio'])
				)
			) : array(),
			'post_status' => 'publish',
			'orderby' => $params['orderby'] ? $params['orderby'] : ($params['sorting'] ? 'date' :'menu_order ID'),
			'order' => $params['order'] ? $params['order'] : ($params['sorting'] ? 'DESC' :'ASC'),
			'posts_per_page' => $count,
			'paged' => $page
		));
		if($portfolio_loop->max_num_pages > $page)
			$next_page = $page + 1;
		else
			$next_page = 0;
	} else {
		$portfolio_loop = new WP_Query(array(
			'post_type' => 'ct_pf_item',
			'tax_query' =>$params['portfolio'] ? array(
				array(
					'taxonomy' => 'ct_portfolios',
					'field' => 'slug',
					'terms' => explode(',', $params['portfolio'])
				)
			) : array(),
			'post_status' => 'publish',
			'orderby' => $params['orderby'] ? $params['orderby'] : ($params['sorting'] ? 'date' :'menu_order ID'),
			'order' => $params['order'] ? $params['order'] : ($params['sorting'] ? 'DESC' :'ASC'),
			'posts_per_page' => -1,
		));
	}

	$terms = array();

	$portfolio_title = $params['title'] ? $params['title'] : '';
	global $post;
	$portfolio_posttemp = $post;
?>
<?php if($portfolio_loop->have_posts()) : ?>
	<?php
		if($params['portfolio']) {
			$terms = explode(',', $params['portfolio']);
			foreach($terms as $key => $term) {
				$terms[$key] = get_term_by('slug', $term, 'ct_portfolios');
				if(!$terms[$key]) {
					unset($terms[$key]);
				}
			}
		} else {
			$terms = get_terms('ct_portfolios', array('hide_empty' => false));
		}
		
		$terms = apply_filters('portfolio_terms_filter', $terms);

		usort($terms, 'portolios_cmp');
		$ct_terms_set = array();
		foreach ($terms as $term) {
			$ct_terms_set[$term->slug] = $term;
		}
	?>

	<?php if(!$params['is_ajax']) : ?>
		<?php echo apply_filters('portfolio_preloader_filter', '<div class="preloader"><div class="preloader-spin"></div></div>'); ?>
		<div class="portfolio-preloader-wrapper">
		<?php if($portfolio_title): ?>
			<h3 class="title portfolio-title"><?php echo $portfolio_title; ?></h3>
		<?php endif; ?>

		<?php

			$portfolio_classes = array(
				'portfolio',
				'no-padding',
				'portfolio-pagination-' . $params['pagination'],
				'portfolio-style-' . $params['style'],
				'background-style-' . $params['background_style'],
				'hover-' . esc_attr($params['hover']),
				'item-animation-' . $params['loading_animation'],
				'title-on-' . $params['display_titles']
			);

			if ($gap_size == 0) {
				$portfolio_classes[] = 'no-gaps';
			}

			if ($params['layout'] == '100%') {
				$portfolio_classes[] = 'fullwidth-columns-' . intval($params['fullwidth_columns']);
			}

			if ($params['display_titles'] == 'page' && $params['hover'] == 'gradient') {
				$portfolio_classes[] = 'hover-gradient-title';
			}

			if ($params['display_titles'] == 'page' && $params['hover'] == 'circular') {
				$portfolio_classes[] = 'hover-circular-title';
			}

			if ($params['display_titles'] == 'hover' || $params['hover'] == 'gradient' || $params['hover'] == 'circular') {
				$portfolio_classes[] = 'hover-title';
			}

			if ($params['style'] == 'masonry' && $params['layout'] != '1x') {
				$portfolio_classes[] = 'portfolio-items-masonry';
			}

			if ($layout_columns_count != -1) {
				$portfolio_classes[] = 'columns-' . intval($layout_columns_count);
			}

			$portfolio_classes = apply_filters('portfolio_classes_filter', $portfolio_classes);

		?>

			<div data-per-page="<?php echo $items_per_page; ?>" data-portfolio-uid="<?php echo esc_attr($portfolio_uid); ?>" class="<?php echo implode(' ', $portfolio_classes); ?>" data-hover="<?php echo $params['hover']; ?>" <?php if($params['pagination'] == 'more' || $params['pagination'] == 'scroll'): ?>data-next-page="<?php echo esc_attr($next_page); ?>"<?php endif; ?>>
				<?php if(($params['with_filter'] && count($terms) > 0) || $params['sorting']): ?>
					<div class="portfilio-top-panel<?php if($params['layout'] == '100%'): ?> fullwidth-block<?php endif; ?>" <?php if ($gap_size && $params['layout'] == '100%'): ?>style="padding-left: <?php echo 2*$gap_size; ?>px; padding-right: <?php echo 2*$gap_size; ?>px;"<?php endif; ?>><div class="portfilio-top-panel-row">
						<div class="portfilio-top-panel-left">
						<?php if($params['with_filter'] && count($terms) > 0): ?>


							<div <?php if(!$params['sorting']): ?> style="text-align: center;"<?php endif; ?>  class="portfolio-filters">
								<a href="#" data-filter="*" class="active all title-h6"><?php echo ct_build_icon('ct-icons', 'portfolio-show-all'); ?><span class="light"><?php echo apply_filters('portfolio_show_all_filter', __('Show All', 'ct')); ?></span></a>
								<?php foreach($terms as $term) : ?>
									<a href="#" data-filter=".<?php echo $term->slug; ?>" class="title-h6"><?php if(get_option('portfoliosets_' . $term->term_id . '_icon_pack') && get_option('portfoliosets_' . $term->term_id . '_icon')) { echo ct_build_icon(get_option('portfoliosets_' . $term->term_id . '_icon_pack'),get_option('portfoliosets_' . $term->term_id . '_icon')); } ?><span class="light"><?php echo $term->name; ?></span></a>
								<?php endforeach; ?>
							</div>
							<div class="portfolio-filters-resp">
								<button class="menu-toggle dl-trigger"><?php _e('Portfolio filters', 'ct'); ?><span class="menu-line-1"></span><span class="menu-line-2"></span><span class="menu-line-3"></span></button>
								<ul class="dl-menu">
									<li><a href="#" data-filter="*"><?php _e('Show All', 'ct'); ?></a></li>
									<?php foreach($terms as $term) : ?>
										<li><a href="#" data-filter=".<?php echo esc_attr($term->slug); ?>"><?php echo $term->name; ?></a></li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
						</div>
						<div class="portfilio-top-panel-right">
						<?php if($params['sorting']): ?>
							<div class="portfolio-sorting title-h6">
								<div class="orderby light">
									<label for="" data-value="date"><?php _e('Date', 'ct') ?></label>
									<a href="javascript:void(0);" class="sorting-switcher" data-current="date"></a>
									<label for="" data-value="name"><?php _e('Name', 'ct') ?></label>
								</div>
								<div class="portfolio-sorting-sep"></div>
								<div class="order light">
									<label for="" data-value="DESC"><?php _e('DESC', 'ct') ?></label>
									<a href="javascript:void(0);" class="sorting-switcher" data-current="DESC"></a>
									<label for="" data-value="ASC"><?php _e('ASC', 'ct') ?></label>
								</div>
							</div>

						<?php endif; ?>
						</div>
					</div></div>
				<?php endif; ?>
				<div class="<?php if($params['layout'] == '100%'): ?>fullwidth-block no-paddings<?php endif; ?>">
				<div class="row" <?php if($params['layout'] == '100%'): ?>style="margin: 0; padding-left: <?php echo $gap_size; ?>px; padding-right: <?php echo $gap_size; ?>px;"<?php else: ?>style="margin: -<?php echo $gap_size; ?>px;"<?php endif; ?>>
				<div class="portfolio-set clearfix" data-max-row-height="<?php echo floatval($params['metro_max_row_height']); ?>">
	<?php else: ?>
		<div data-page="<?php echo $page; ?>" data-next-page="<?php echo $next_page; ?>">
	<?php endif; ?>

					<?php $eo_marker = false; while ($portfolio_loop->have_posts()) : $portfolio_loop->the_post(); ?>
						<?php $slugs = wp_get_object_terms($post->ID, 'ct_portfolios', array('fields' => 'slugs')); ?>
						<?php include(locate_template(array('ct-templates/portfolios/content-portfolio-item-'.$params['layout'].'.php', 'ct-templates/portfolios/content-portfolio-item.php'))); ?>
					<?php $eo_marker = !$eo_marker; endwhile; ?>

	<?php if(!$params['is_ajax']) : ?>
				</div><!-- .portflio-set -->
					</div><!-- .row-->
				<?php if($params['pagination'] == 'normal'): ?>
					<div class="portfolio-navigator ct-pagination">
					</div>
				<?php endif; ?>
				<?php if($params['pagination'] == 'more' && $next_page > 0): ?>
					<div class="portfolio-load-more">
						<div class="inner">
							<?php ct_button(array_merge($params['button'], array('tag' => 'button')), 1); ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if($params['pagination'] == 'scroll' && $next_page > 0): ?>
					<div class="portfolio-scroll-pagination"></div>
				<?php endif; ?>
			</div><!-- .full-width -->
		</div><!-- .portfolio-->
	</div><!-- .portfolio-preloader-wrapper-->
	<?php else: ?>
	</div>
	<?php endif; ?>

<?php else: ?>
	<div data-page="<?php echo esc_attr($page); ?>" data-next-page="<?php echo esc_attr($next_page); ?>"></div>
<?php endif; ?>

<?php $post = $portfolio_posttemp; wp_reset_postdata(); ?>
<?php
}

function ct_portfolio_block($params = array()) {
	echo '<div class="block-content clearfix">';
	ct_portfolio_slider($params);
	echo '</div>';
}

// Print Portfolio Slider
function ct_portfolio_slider($params) {
	$params = array_merge(
		array(
			'portfolio' => '',
			'title' => '',
			'layout' => '3x',
			'no_gaps' => false,
			'display_titles' => 'page',
			'hover' => '',
			'show_info' => false,
			'style' => 'justified',
			'is_slider' => true,
			'disable_socials' => false,
			'fullwidth_columns' => '5',
			'effects_enabled' => false,
			'background_style' => '',
			'autoscroll' => false,
			'gaps_size' => 42,
		),
		$params
	);

	$gap_size = round(intval($params['gaps_size'])/2);

	if (empty($params['fullwidth_columns']))
		$params['fullwidth_columns'] = 5;

	wp_enqueue_style('ct-portfolio');


	wp_enqueue_script('imagesloaded');
	wp_enqueue_script('jquery-transform');
	wp_enqueue_script('ct-juraSlider');
	wp_enqueue_script('ct-portfolio');

	$layout_columns_count = -1;
	if($params['layout'] == '3x')
		$layout_columns_count = 3;

	$layout_fullwidth = false;
	if($params['layout'] == '100%')
		$layout_fullwidth = true;

	$portfolio_loop = new WP_Query(array(
		'post_type' => 'ct_pf_item',
		'tax_query' =>$params['portfolio'] ? array(
			array(
				'taxonomy' => 'ct_portfolios',
				'field' => 'slug',
				'terms' => explode(',', $params['portfolio'])
			)
		) : array(),
		'post_status' => 'publish',
		'orderby' => 'menu_order ID',
		'order' => 'ASC',
		'posts_per_page' => -1,
	));

	$terms = array();

	$portfolio_title = __('Portfolio', 'ct');
	if($portfolio_set = get_term_by('slug', $params['portfolio'], 'ct_portfolios')) {
		$portfolio_title = $portfolio_set->name;
	}
	$portfolio_title = $params['title'] ? $params['title'] : $portfolio_title;
	global $post;
	$portfolio_posttemp = $post;

	$classes = array('portfolio', 'portfolio-slider', 'clearfix', 'no-padding', 'col-lg-12', 'col-md-12', 'col-sm-12', 'hover-'.$params['hover']);
	if($layout_fullwidth)
		$classes[] = 'full';
	if( ($params['display_titles'] == 'hover' && $params['layout'] != '1x') || $params['hover'] == 'gradient' || $params['hover'] == 'circular' )
		$classes[] = 'hover-title';
	if ($params['display_titles'] == 'page' && $params['hover'] == 'gradient')
		$classes[] = 'hover-gradient-title';
	if ($params['display_titles'] == 'page' && $params['hover'] == 'circular')
		$classes[] = 'hover-circular-title';
	if($params['style'] == 'masonry')
		$classes[] = 'portfolio-items-masonry';
	if($layout_columns_count != -1)
		$classes[] = 'columns-'.$layout_columns_count;
	if($params['no_gaps'])
		$classes[] = 'without-padding';
	if($params['layout'] == '100%')
		$classes[] = 'fullwidth-columns-'.$params['fullwidth_columns'];

	if ($params['effects_enabled'])
		$classes[] = 'lazy-loading';

	if ($params['disable_socials'])
		$classes[] = 'disable-socials';
	if ($params['portfolio_arrow'])
		$classes[] = $params['portfolio_arrow'];
	if ($params['background_style'])
		$classes[] = 'background-style-'.$params['background_style'];

	$classes[] = 'title-on-' . $params['display_titles'];


?>

	<?php if($portfolio_loop->have_posts()) : ?>
	<div class="preloader"><div class="preloader-spin"></div></div>
	<div <?php post_class($classes); ?> <?php if($params['effects_enabled']): ?>data-ll-item-delay="0"<?php endif;?> data-hover="<?php echo esc_attr($params['hover']); ?>">
		<div class="navigation <?php if($layout_fullwidth): ?>fullwidth-block<?php endif; ?>">
			<?php if($params['title']): ?>
				<h3 class="title <?php if($params['effects_enabled']): ?>lazy-loading-item<?php endif;?>" <?php if($params['effects_enabled']): ?>data-ll-effect="fading"<?php endif;?>><?php echo $params['title']; ?></h3>
			<?php endif; ?>
			<div class="portolio-slider-prev">
				<span>&#xe603;</span>
			</div>

			<div class="portolio-slider-next">
				<span>&#xe601;</span>
			</div>

			<?php
				if($params['portfolio']) {
					$terms = explode(',', $params['portfolio']);
					foreach($terms as $key => $term) {
						$terms[$key] = get_term_by('slug', $term, 'ct_portfolios');
						if(!$terms[$key]) {
							unset($terms[$key]);
						}
					}
				} else {
					$terms = get_terms('ct_portfolios', array('hide_empty' => false));
				}
				$terms_set = array();
				foreach ($terms as $term)
					$terms_set[$term->slug] = $term;
			?>

			<div class="portolio-slider-content">
				<div class="portolio-slider-center">
					<div class="<?php if($params['layout'] == '100%'): ?>fullwidth-block<?php endif; ?>">
						<div class="portfolio-set clearfix" style="margin: -<?php echo $gap_size; ?>px;" <?php if(intval($params['autoscroll'])) { echo 'data-autoscroll="'.intval($params['autoscroll']).'"'; } ?>>
							<?php while ($portfolio_loop->have_posts()) : $portfolio_loop->the_post(); ?>
								<?php $slugs = wp_get_object_terms($post->ID, 'ct_portfolios', array('fields' => 'slugs')); ?>
								<?php include(locate_template('ct-templates/portfolios/content-portfolio-carusel-item.php')); ?>
							<?php endwhile; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php $post = $portfolio_posttemp; wp_reset_postdata(); ?>
<?php
}

// Print Gallery Block
function ct_gallery_block($params) {
	$params = array_merge(
		array(
			'ids' => array(),
			'gallery' => '',
			'type' => 'slider',
			'layout' => '3x',
			'fullwidth_columns' => '5',
			'style' => 'justified',
			'no_gaps' => false,
			'hover' => 'default',
			'item_style' => '',
			'title' => '',
			'gaps_size' => '',
			'effects_enabled' => '',
			'loading_animation' => 'move-up',
			'metro_max_row_height' => 380
		),
		$params
	);
	wp_enqueue_style('ct-gallery');
	wp_enqueue_style('ct-animations');
	wp_enqueue_script('imagesloaded');
	wp_enqueue_script('isotope-js');
	wp_enqueue_script('ct-isotope-metro');
	wp_enqueue_script('ct-isotope-masonry-custom');
	wp_enqueue_script('jquery-transform');
	wp_enqueue_script('ct-removewhitespace');
	wp_enqueue_script('ct-scroll-monitor');
	wp_enqueue_script('ct-items-animations');
	wp_enqueue_script('jquery-collagePlus');
	wp_enqueue_script('ct-gallery');

	if (empty($params['fullwidth_columns']))
		$params['fullwidth_columns'] = 5;

	$params['loading_animation'] = ct_check_array_value(array('disabled', 'bounce', 'move-up', 'fade-in', 'fall-perspective', 'scale', 'flip'), $params['loading_animation'], 'move-up');

	$layout_columns_count = -1;
	if($params['layout'] == '2x')
		$layout_columns_count = 2;
	if($params['layout'] == '3x')
		$layout_columns_count = 3;
	if($params['layout'] == '4x')
		$layout_columns_count = 4;

	if(!empty($params['ids'])) {
		$ct_gallery_images_ids = $params['ids'];
	} else {
		if(metadata_exists('post', $params['gallery'], 'ct_gallery_images')) {
			$ct_gallery_images_ids = get_post_meta($params['gallery'], 'ct_gallery_images', true);
		} else {
			$attachments_ids = get_posts('post_parent=' . $params['gallery'] . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids&post_status=publish');
			$ct_gallery_images_ids = implode(',', $attachments_ids);
		}
		$attachments_ids = array_filter(explode(',', $ct_gallery_images_ids));
	}
	$attachments_ids = array_filter(explode(',', $ct_gallery_images_ids));
	$gallery_uid = uniqid();

?>



<div class="preloader"><div class="preloader-spin"></div></div>
<div class="gallery-preloader-wrapper">
	<?php if($params['title']): ?>
		<h3 style="text-align: center;"><?php echo $params['title']; ?></h3>
	<?php endif; ?>
	<?php if(count($attachments_ids) > 0) : ?>
	<div class="row"
		<?php if ($params['gaps_size'] && ($params['style'])  == 'metro'):;?>style="margin-top: -<?php echo ($params['gaps_size'] / 2) ;?>px"<?php endif;?>
		<?php if ($params['gaps_size'] && ($params['style'])  != 'metro'):;?>style="margin-top: -<?php echo ($params['gaps_size'] / 2) ;?>px"<?php endif;?>>


		<div class="<?php if ($params['gaps_size'] && ($params['style'])  != 'metro'):;?>gaps-margin<?php endif;?><?php if ($params['gaps_size'] && ($params['style'])  == 'metro'):;?>without-padding <?php endif;?> <?php if($params['style'] == 'metro' && $params['item_style']): ?>metro-item-style-<?php echo $params['item_style']; endif; ?> gallery-style-<?php echo $params['style']; ?> ct-gallery-grid <?php if($params['style'] == 'metro'): ?>metro<?php endif; ?> <?php if($params['type'] == 'slider'): ?>gallery-slider<?php endif; ?> col-lg-12 col-md-12 col-sm-12 <?php if($params['type'] == 'grid' && $params['style'] == 'masonry'): ?>gallery-items-masonry<?php endif; ?> <?php if($params['type'] == 'grid' && $params['no_gaps']): ?>without-padding<?php endif; ?> <?php if($layout_columns_count != -1) echo 'columns-'.$layout_columns_count; ?> hover-<?php echo $params['hover']; ?> item-animation-<?php echo $params['loading_animation']; ?> <?php if($params['layout'] == '100%'): ?>fullwidth-columns-<?php echo intval($params['fullwidth_columns']); ?><?php endif; ?>" data-hover="<?php echo $params['hover']; ?>">
			
			<?php if ($params['type'] == 'grid' && $params['layout'] == '100%'):?>
				<div class="fullwidth-block" <?php if ($params['gaps_size']):;?> style="padding-left: <?php echo ($params['gaps_size'] / 2);?>px; padding-right: <?php echo ($params['gaps_size'] / 2);?>px;"<?php endif;?>>
			<?php endif;?>
			
				<ul
					<?php if ($params['type'] != 'grid' || $params['layout'] != '100%'):?>
						style="margin-left: -<?php echo ($params['gaps_size'] / 2);?>px; margin-right: -<?php echo ($params['gaps_size'] / 2);?>px;"
					<?php endif;?>

					class="gallery-set clearfix" data-max-row-height="<?php echo floatval($params['metro_max_row_height']); ?>">
					<?php foreach($attachments_ids as $attachment_id) : ?>
						<?php include(locate_template('content-gallery-item.php')); ?>
					<?php endforeach; ?>
				</ul>

			<?php if ($params['type'] == 'grid' && $params['layout'] == '100%'):?>
				</div>
			<?php endif; ?>
		</div>
	</div>



	<?php endif; ?>
</div>
<?php
}

function ct_news_block($params) {
	echo '<div class="block-content"><div class="container">';
	ct_newss($params);
	echo '</div></div>';
}

function ct_newss($params) {
	$params = array_merge(array('news_set' => '', 'effects_enabled' => false), $params);
	$args = array(
		'post_type' => 'ct_news',
		'orderby' => 'menu_order ID',
		'order' => 'ASC',
		'posts_per_page' => -1,
	);
	if($params['news_set'] != '') {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'ct_news_sets',
				'field' => 'slug',
				'terms' => explode(',', $params['news_set'])
			)
		);
	}

	$news_items = new WP_Query($args);
	if($news_items->have_posts()) {
		wp_enqueue_script('ct-news-carousel');
		echo '<div class="preloader"><div class="preloader-spin"></div></div>';
		echo '<div class="ct-news ct-news-type-carousel clearfix">';
		while($news_items->have_posts()) {
			$news_items->the_post();
			include(locate_template('content-news-carousel-item.php'));
		}
		echo '</div>';
	}
	wp_reset_postdata();
}

function ct_nivoslider($params = array()) {
	$params = array_merge(array('slideshow' => ''), $params);
	$args = array(
		'post_type' => 'ct_slide',
		'orderby' => 'menu_order ID',
		'order' => 'ASC',
		'posts_per_page' => -1,
	);
	if($params['slideshow']) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'ct_slideshows',
				'field' => 'slug',
				'terms' => explode(',', $params['slideshow'])
			)
		);
	}
	$slides = new WP_Query($args);

	if($slides->have_posts()) {

		wp_enqueue_style('nivo-slider');
		wp_enqueue_script('ct-nivoslider-init-script');

		echo '<div class="preloader"><div class="preloader-spin"></div></div>';
		echo '<div class="ct-nivoslider">';
		while($slides->have_posts()) {
			$slides->the_post();
			if(has_post_thumbnail()) {
				$item_data = ct_get_sanitize_slide_data(get_the_ID());
?>
	<?php if($item_data['link']) : ?>
		<a href="<?php echo esc_url($item_data['link']); ?>" target="<?php echo esc_attr($item_data['link_target']); ?>" class="ct-nivoslider-slide">
	<?php else : ?>
		<div class="ct-nivoslider-slide">
	<?php endif; ?>
	<?php ct_post_thumbnail('full', false, ''); ?>
	<?php if($item_data['text_position']) : ?>
		<div class="ct-nivoslider-caption" style="display: none;">
			<div class="caption-<?php echo esc_attr($item_data['text_position']); ?>">
				<div class="ct-nivoslider-title"><?php the_title(); ?></div>
				<div class="clearboth"></div>
				<div class="ct-nivoslider-description"><?php the_excerpt(); ?></div>
			</div>
		</div>
	<?php endif; ?>
	<?php if($item_data['link']) : ?>
		</a>
	<?php else : ?>
		</div>
	<?php endif; ?>
<?php
			}
		}
		echo '</div>';
	}
	wp_reset_postdata();
}

if(!function_exists('ct_video_background')) {
function ct_video_background($video_type, $video, $aspect_ratio = '16:9', $headerUp = false, $color = '', $opacity = '', $poster='') {
	$output = '';
	$video_type = ct_check_array_value(array('', 'youtube', 'vimeo', 'self'), $video_type, '');
	if($video_type && $video) {
		$video_block = '';
		if($video_type == 'youtube' || $video_type == 'vimeo') {
			$link = '';
			if($video_type == 'youtube') {
				$link = '//www.youtube.com/embed/'.$video.'?playlist='.$video.'&autoplay=1&controls=0&loop=1&fs=0&showinfo=0&autohide=1&iv_load_policy=3&rel=0&disablekb=1&wmode=transparent';
			}
			if($video_type == 'vimeo') {
				$link = '//player.vimeo.com/video/'.$video.'?autoplay=1&controls=0&loop=1&title=0&badge=0&byline=0&autopause=0';
			}
			$video_block = '<iframe src="'.esc_url($link).'" frameborder="0"></iframe>';
		} else {
			$video_block = '<video autoplay="autoplay" loop="loop" src="'.$video.'" muted="muted"'.($poster ? ' poster="'.esc_url($poster).'"' : '').'></video>';
		}
		$overlay_css = '';
		if($color) {
			$overlay_css = 'background-color: '.$color.'; opacity: '.floatval($opacity).';';
		}
		$output = '<div class="ct-video-background" data-aspect-ratio="'.esc_attr($aspect_ratio).'"'.($headerUp ? ' data-headerup="1"' : '').'><div class="ct-video-background-inner">'.$video_block.'</div><div class="ct-video-background-overlay" style="'.$overlay_css.'"></div></div>';
	}
	return $output;
}
}

/* Acoordion Script Reaplace */

function ct_vc_base_register_front_js() {
	wp_deregister_script('vc_accordion_script');
	wp_register_script('vc_accordion_script', get_template_directory_uri() . '/js/vc-accordion.js', array('jquery'), WPB_VC_VERSION, true);
	wp_register_script('ct_tabs_script', get_template_directory_uri() . '/js/vc-tabs.min.js', array('jquery', 'vc_accordion_script'), WPB_VC_VERSION, true);
	wp_register_style( 'vc_tta_style', vc_asset_url( 'css/js_composer_tta.min.css' ), false, WPB_VC_VERSION );
}
add_action('vc_base_register_front_js', 'ct_vc_base_register_front_js');


function ct_socials_sharing_block() {
	if(ct_get_option('show_social_icons')) {
		get_template_part('socials', 'sharing');
	}
}
add_action('ct_sharing_block', 'ct_socials_sharing_block');

if(!function_exists('ct_button')) {
	function ct_button($params = array(), $echo = false) {
		$params = array_merge(array(
			'tag' => 'a',
			'text' => '',
			'href' => '#',
			'target' => '_self',
			'title' => '',
			'style' => 'flat',
			'size' => 'small',
			'text_weight' => 'normal',
			'no-uppercase' => 0,
			'corner' => 3,
			'border' => 2,
			'position' => 'inline',
			'text_color' => '',
			'background_color' => '',
			'border_color' => '',
			'hover_text_color' => '',
			'hover_background_color' => '',
			'hover_border_color' => '',
			'icon' => '',
			'icon_pack' => '',
			'icon_position' => 'left',
			'separator' => '',
			'extra_class' => '',
			'id' => '',
			'attributes' => array(),
			'effects_enabled' => false,
			'effects_enabled' => false,
			'gradient_backgound' => '',
			'gradient_backgound_from' => '',
			'gradient_backgound_to' => '',
			'gradient_backgound_hover_from' => '',
			'gradient_backgound_hover_to' => '',
			'gradient_backgound_style' => 'linear',
			'gradient_backgound_angle' => 'to bottom',
			'gradient_backgound_cusotom_deg' => '180',
			'gradient_radial_backgound_position' => 'at top',
			'gradient_radial_swap_colors' => '',
		), $params);
	
		$params['tag'] = ct_check_array_value(array('a', 'button', 'input'), $params['tag'], 'a');
		$params['text'] = esc_html($params['text']);
		if($params['href'] === 'post_link') {
			$params['href'] = '{{ post_link_url }}';
		} else {
			$params['href'] = esc_url($params['href']);
		}
		$params['target'] = ct_check_array_value(array('_self', '_blank'), trim($params['target']), '_self');
		$params['title'] = esc_attr($params['title']);
		$params['style'] = ct_check_array_value(array('flat', 'outline'), $params['style'], 'flat');
		$params['size'] = ct_check_array_value(array('tiny', 'small', 'medium', 'large', 'giant'), $params['size'], 'small');
		$params['text_weight'] = ct_check_array_value(array('normal', 'thin'), $params['text_weight'], 'normal');
		$params['no-uppercase'] = $params['no-uppercase'] ? 1 : 0;
		$params['corner'] = intval($params['corner']) >= 0 ? intval($params['corner']) : 3;
		$params['border'] = ct_check_array_value(array('1', '2', '3', '4', '5', '6'), $params['border'], '2');
		$params['position'] = ct_check_array_value(array('inline', 'left', 'right', 'center', 'fullwidth'), $params['position'], 'inline');
		$params['text_color'] = esc_attr($params['text_color']);
		$params['background_color'] = esc_attr($params['background_color']);
		$params['border_color'] = esc_attr($params['border_color']);
		$params['hover_text_color'] = esc_attr($params['hover_text_color']);
		$params['hover_background_color'] = esc_attr($params['hover_background_color']);
		$params['hover_border_color'] = esc_attr($params['hover_border_color']);
		$params['icon'] = esc_attr($params['icon']);
		$params['icon_pack'] = ct_check_array_value(array('ct-icons', 'elegant', 'material', 'fontawesome', 'userpack'), $params['icon_pack'], 'ct-icons');
		$params['icon_position'] = ct_check_array_value(array('left', 'right'), $params['icon_position'], 'left');
		$params['separator'] = ct_check_array_value(array('', 'single', 'square', 'soft-double', 'strong-double', 'load-more'), $params['separator'], '');
		$params['extra_class'] = esc_attr($params['extra_class']);
		$params['id'] = sanitize_title($params['id']);
		$params['gradient_backgound'] = $params['gradient_backgound'] ? 1 : 0;
		$params['gradient_radial_swap_colors'] = $params['gradient_radial_swap_colors'] ? 1 : 0;
		$params['gradient_backgound_from'] = esc_attr($params['gradient_backgound_from']);
		$params['gradient_backgound_to'] = esc_attr($params['gradient_backgound_to']);
		$params['gradient_backgound_hover_from'] = esc_attr($params['gradient_backgound_hover_from']);
		$params['gradient_backgound_hover_to'] = esc_attr($params['gradient_backgound_hover_to']);
		$params['gradient_backgound_style'] = ct_check_array_value(array('linear', 'radial'), $params['gradient_backgound_style']);
		$params['gradient_backgound_angle'] = ct_check_array_value(array('to bottom', 'to top','to right', 'to left', 'to bottom right', 'to top right', 'to bottom left', 'to top left', 'cusotom_deg'), $params['gradient_backgound_angle']);
		$params['gradient_backgound_cusotom_deg'] = esc_attr($params['gradient_backgound_cusotom_deg']);
		$params['gradient_radial_backgound_position'] = ct_check_array_value(array('at top', 'at bottom', 'at right', 'at left', 'at center'), $params['gradient_radial_backgound_position']);

		$sep = '';
		if($params['separator']) {
			$params['position'] = 'center';
			if($params['style'] == 'flat') {
				$sep_color = $params['background_color'] ? $params['background_color'] : ct_get_option('button_background_basic_color');
			} else {
				$sep_color = $params['border_color'] ? $params['border_color'] : ct_get_option('button_outline_border_basic_color');
			}
			if($params['separator'] == 'load-more') {
				$sep_color = ct_get_option('box_border_color');
			}
			if($params['separator'] == 'square') {
				$sep.= '<div class="ct-button-separator-line"><svg width="100%" height="8px"><line x1="4" x2="100%" y1="4" y2="4" stroke="'.esc_attr($sep_color).'" stroke-width="8" stroke-linecap="square" stroke-dasharray="0, 15"/></svg></div>';
			} else {
				$sep.= '<div class="ct-button-separator-holder"><div class="ct-button-separator-line" style="border-color: '.esc_attr($sep_color).';"></div></div>';
			}
		}
	
		$output = '';
	
		$output .= '<div'.($params['id'] ? ' id="'.esc_attr($params['id']).'"' : '').' class="'.esc_attr('ct-button-container ct-button-position-'.$params['position'].($params['extra_class'] ? ' '.$params['extra_class'] : '').($params['separator'] ? ' ct-button-with-separator' : '') . ($params['effects_enabled'] ? ' lazy-loading' : '') ).'">';
		if($params['separator']) {
			$output .= '<div class="ct-button-separator ct-button-separator-type-'.esc_attr($params['separator']).'">'.$sep.'<div class="ct-button-separator-button">';
		}
		$output .= '<'.$params['tag'];
		if($params['title']) {
			$output .= ' title="'.esc_attr($params['title']).'"';
		}
		$output .= ' class="'.esc_attr('ct-button ct-button-size-'.$params['size'].' ct-button-style-'.$params['style'].' ct-button-text-weight-'.$params['text_weight'].($params['style'] == 'outline' ? ' ct-button-border-'.$params['border'] : '').($params['text'] == '' ? ' ct-button-empty' : '').($params['icon'] && $params['text'] != '' ? ' ct-button-icon-position-'.$params['icon_position'] : '').($params['no-uppercase'] ? ' ct-button-no-uppercase' : '').(empty($params['attributes']['class']) ? '' : ' '.$params['attributes']['class']) . ($params['effects_enabled'] ? ' lazy-loading-item' : '')) .'"';
		$output .= $params['effects_enabled'] ? ' data-ll-effect="drop-right-without-wrap"' : '';
		$output .= ' style="';
		$output .= 'border-radius: '.esc_attr($params['corner']).'px;';
		if($params['style'] == 'outline' && $params['border_color']) {
			$output .= 'border-color: '.esc_attr($params['border_color']).';';
		}
		if($params['style'] == 'flat' && $params['background_color']) {
			$output .= 'background-color: '.esc_attr($params['background_color']).';';
		}
		if ($params['gradient_backgound_angle'] == 'cusotom_deg') {
			$params['gradient_backgound_angle'] = $params['gradient_backgound_cusotom_deg'].'deg';
		}
		if($params['gradient_backgound'] == 1 && $params['gradient_backgound_style'] == 'linear') {
			$output .= 'background: linear-gradient('.$params['gradient_backgound_angle'].', '.$params['gradient_backgound_from'].', '.$params['gradient_backgound_to'].');';
		}
		if($params['gradient_backgound'] == 1 && $params['gradient_backgound_style'] == 'radial') {
			$output .= 'background: radial-gradient('.$params['gradient_radial_backgound_position'].', '.$params['gradient_backgound_from'].', '.$params['gradient_backgound_to'].');';
		}
		if($params['gradient_backgound'] == 1 && $params['gradient_backgound_style'] == 'radial' && $params['gradient_radial_swap_colors'] == 1 )  {
			$output .= 'background: radial-gradient('.$params['gradient_radial_backgound_position'].', '.$params['gradient_backgound_to'].', '.$params['gradient_backgound_from'].');';
		}
		if($params['text_color']) {
			$output .= 'color: '.esc_attr($params['text_color']).';';
		}
		$output .= '"';
		$output .= ' onmouseleave="';
		if($params['style'] == 'outline' && $params['border_color']) {
			$output .= 'this.style.borderColor=\''.esc_attr($params['border_color']).'\';';
		}
		if($params['style'] == 'flat' && $params['background_color']) {
			$output .= 'this.style.backgroundColor=\''.esc_attr($params['background_color']).'\';';
		}
		if($params['style'] == 'outline' && $params['hover_background_color']) {
			$output .= 'this.style.backgroundColor=\'transparent\';';
		}
		if($params['text_color']) {
			$output .= 'this.style.color=\''.esc_attr($params['text_color']).'\';';
		}
		if($params['gradient_backgound'] == 1 && $params['gradient_backgound_style'] == 'linear') {
			$output .= 'this.style.background=\'linear-gradient(' . $params['gradient_backgound_angle'] .' , '.  $params['gradient_backgound_from'] .' , '. $params['gradient_backgound_to'].')\';';
		}
		if($params['gradient_backgound'] == 1 && $params['gradient_backgound_style'] == 'radial') {
			$output .= 'this.style.background=\'radial-gradient(' . $params['gradient_radial_backgound_position'] .' , '.  $params['gradient_backgound_from'] .' , '. $params['gradient_backgound_to'].')\';';
		}
		if($params['gradient_backgound'] == 1 && $params['gradient_backgound_style'] == 'radial' && $params['gradient_radial_swap_colors'] == 1 )  {
			$output .= 'this.style.background=\'radial-gradient(' . $params['gradient_radial_backgound_position'] .' , '.  $params['gradient_backgound_to'] .' , '. $params['gradient_backgound_from'].')\';';
		}
		$output .= '"';
		$output .= ' onmouseenter="';
		if($params['hover_border_color']) {
			$output .= 'this.style.borderColor=\''.esc_attr($params['hover_border_color']).'\';';
		}
		if($params['hover_background_color']) {
			$output .= 'this.style.backgroundColor=\''.esc_attr($params['hover_background_color']).'\';';
		}
		if($params['hover_text_color']) {
			$output .= 'this.style.color=\''.esc_attr($params['hover_text_color']).'\';';
		}
		if($params['gradient_backgound'] == 1 && $params['gradient_backgound_style'] == 'linear') {
			$output .= 'this.style.background=\'linear-gradient(' . $params['gradient_backgound_angle'] .' , '.  $params['gradient_backgound_hover_from'] .' , '. $params['gradient_backgound_hover_to'].')\';';
		}
		if($params['gradient_backgound'] == 1 && $params['gradient_backgound_style'] == 'radial') {
			$output .= 'this.style.background=\'radial-gradient(' . $params['gradient_radial_backgound_position'] .' , '.  $params['gradient_backgound_hover_from'] .' , '. $params['gradient_backgound_hover_to'].')\';';
		}
		if($params['gradient_backgound'] == 1 && $params['gradient_backgound_style'] == 'radial' && $params['gradient_radial_swap_colors'] == 1 ) {
			$output .= 'this.style.background=\'radial-gradient(' . $params['gradient_radial_backgound_position'] .' , '.  $params['gradient_backgound_hover_to'] .' , '. $params['gradient_backgound_hover_from'].')\';';

		}
		$output .= '"';
		if($params['tag'] == 'a') {
			$output .= ' href="'.esc_url($params['href']).'"';
			$output .= ' target="'.esc_attr($params['target']).'"';
		}
		if(!empty($params['attributes']) && is_array($params['attributes'])) {
			foreach($params['attributes'] as $param => $value) {
				if($param != 'class') {
					$output .= ' '.esc_attr($param).'="'.esc_attr($value).'"';
				}
			}
		}
		if($params['tag'] != 'input') {
			$output .= '>';
			if($params['icon']) {
				if($params['icon_position'] == 'left') {
					$output .= ct_build_icon($params['icon_pack'], $params['icon']).$params['text'];
				} else {
					$output .= $params['text'].ct_build_icon($params['icon_pack'], $params['icon']);
				}
			} else {
				$output .= $params['text'];
			}
			$output .= '</'.$params['tag'].'>';
		} else {
			$output .= ' />';
		}
		if($params['separator']) {
			$output .= '</div>'.$sep.'</div>';
		}
		$output .= '</div> ';
		if($echo) {
			echo $output;
		} else {
			return $output;
		}
	}
}

if(!function_exists('ct_build_icon')) {
	function ct_build_icon($pack, $icon) {
		if($icon) {
			if(in_array($pack, array('elegant', 'material', 'fontawesome', 'userpack'))) {
				wp_enqueue_style('icons-'.$pack);
				return '<i class="ct-print-icon ct-icon-pack-'.esc_attr($pack).'">&#x'.$icon.';</i>';
			} else {
				return '<i class="ct-print-icon ct-icon-pack-'.esc_attr($pack).' ct-icon-'.esc_attr($icon).'"></i>';
			}
		}
	}
}


if(!function_exists('ct_blog') && ct_check_function_version()) {
function ct_blog($params = array()) {
	$params = array_merge(array(
		'blog_style' => 'default',
		'color_style' => 'style-1',
		'slider_style' => 'fullwidth',
		'slider_autoscroll' => 0,
		'blog_post_per_page' => '',
		'blog_categories' => '',
		'blog_post_types' => '',
		'blog_pagination' => '',
		'blog_ignore_sticky' => 0,
		'is_ajax' => 0,
		'paged' => -1,
		'effects_enabled' => 0,
		'loading_animation' => 'move-up',
		'hide_date' => 0,
		'hide_author' => 0,
		'hide_comments' => 0,
		'hide_likes' => 0,
		'button' => array()
	), $params);

	$params['button'] = array_merge(array(
		'text' => esc_html__('Load More', 'avxbuilder'),
		'style' => 'flat',
		'size' => 'medium',
		'text_weight' => 'normal',
		'no_uppercase' => 0,
		'corner' => 25,
		'border' => 2,
		'text_color' => '',
		'background_color' => '#e8668a',
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
		'separator' => 'load-more',
	), $params['button']);

	$params['button']['icon'] = '';
	if($params['button']['icon_elegant'] && $params['button']['icon_pack'] == 'elegant') {
		$params['button']['icon'] = $params['button']['icon_elegant'];
	}
	if($params['button']['icon_material'] && $params['button']['icon_pack'] == 'material') {
		$params['button']['icon'] = $params['button']['icon_material'];
	}
	if($params['button']['icon_fontawesome'] && $params['button']['icon_pack'] == 'fontawesome') {
		$params['button']['icon'] = $params['button']['icon_fontawesome'];
	}
	if($params['button']['icon_userpack'] && $params['button']['icon_pack'] == 'userpack') {
		$params['button']['icon'] = $params['button']['icon_userpack'];
	}

	$params['blog_pagination'] = ct_check_array_value(array('normal', 'more', 'scroll', 'disable'), $params['blog_pagination'], 'normal');
	$params['color_style'] = ct_check_array_value(array('style-1', 'style-2'), $params['color_style'], 'style-1');
	$params['slider_style'] = ct_check_array_value(array('fullwidth', 'halfwidth'), $params['slider_style'], 'fullwidth');
	$params['loading_animation'] = ct_check_array_value(array('disabled', 'bounce', 'move-up', 'fade-in', 'fall-perspective', 'scale', 'flip'), $params['loading_animation'], 'move-up');

	if ($params['blog_pagination'] == 'scroll' && $params['blog_style'] != 'grid_carousel' && $params['blog_style'] != 'slider') {
		$params['effects_enabled'] = true;
	}

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	if ($params['blog_pagination'] == 'disable' || $params['blog_style'] == 'grid_carousel'|| $params['blog_style'] == 'slider')
		$paged = 1;

	if ($params['paged'] != -1)
		$paged = $params['paged'];

	$params['blog_style'] = ct_check_array_value(array('default', 'timeline', 'timeline_new', '3x', '4x', 'justified-3x', 'justified-4x', '100%', 'grid_carousel', 'styled_list1', 'styled_list2', 'multi-author', 'compact', 'slider'), $params['blog_style'], 'default');
	$params['blog_post_per_page'] = intval($params['blog_post_per_page']) > 0 ? intval($params['blog_post_per_page']) : 5;

	if(!is_array($params['blog_categories']) && $params['blog_categories']) {
		$params['blog_categories'] = explode(',', $params['blog_categories']);
	}

	$params['blog_post_types'] = is_array($params['blog_post_types']) && !empty($params['blog_post_types']) ? $params['blog_post_types'] : array('post');

	if ($params['blog_style'] == 'timeline_new') {
		$params['blog_ignore_sticky'] = 1;
	}

	$args = array(
		'post_type' => $params['blog_post_types'],
		'posts_per_page' => $params['blog_post_per_page'],
		'post_status' => 'publish',
		'ignore_sticky_posts' => $params['blog_ignore_sticky'],
		'paged' => $paged
	);
	if(!empty($params['blog_categories']) && !in_array('--all--', $params['blog_categories'])) {
		$args['tax_query'] = array(
			'relation' => 'OR',
			array(
				'taxonomy' => 'category',
				'field' => 'slug',
				'terms' => $params['blog_categories']
			),
			array(
				'taxonomy' => 'ct_news_sets',
				'field' => 'slug',
				'terms' => $params['blog_categories']
			),
		);
	}

	$posts = new WP_Query($args);

	$next_page = 0;
	if($params['blog_pagination'] == 'more' || $params['blog_pagination'] == 'scroll') {
		if($posts->max_num_pages > $paged)
			$next_page = $paged + 1;
		else
			$next_page = 0;
	}


	$blog_style = $params['blog_style'];

	wp_enqueue_style('ct-blog');
	wp_enqueue_style('ct-additional-blog');
	wp_enqueue_style('ct-blog-timeline-new');
	wp_enqueue_style('ct-animations');

	if($blog_style == '3x' || $blog_style == '4x' || $blog_style == '100%' || $blog_style == 'timeline_new') {
		wp_enqueue_script('imagesloaded');
		wp_enqueue_script('isotope-js');
	}
	wp_enqueue_script('ct-items-animations');
	wp_enqueue_script('ct-gallery');
	wp_enqueue_script('ct-blog');
	wp_enqueue_script('ct-scroll-monitor');

	$localize = array_merge(
		array('data' => $params),
		array(
			'url' => esc_url(admin_url('admin-ajax.php')),
			'nonce' => wp_create_nonce('blog_ajax-nonce')
		)
	);
	wp_localize_script('ct-blog', 'ct_blog_ajax', $localize);

	if($posts->have_posts()) {
		if ($params['blog_style'] == 'grid_carousel') {
			wp_enqueue_script('ct-news-carousel');
			echo '<div class="preloader"><div class="preloader-spin"></div></div>';
			echo '<div class="ct-news ct-news-type-carousel clearfix ' . ($params['effects_enabled'] ? 'lazy-loading' : '') . '" ' . ($params['effects_enabled'] ? 'data-ll-item-delay="0"' : '') . '>';
			while($posts->have_posts()) {
				$posts->the_post();
				include(locate_template('content-news-carousel-item.php'));
			}
			echo '</div>';
		} elseif ($params['blog_style'] == 'slider') {
			$slider_style = $params['slider_style'];
			wp_enqueue_script('ct-news-carousel');
			echo '<div class="preloader"><div class="preloader-spin"></div></div>';
			echo '<div class="ct-blog-slider ct-blog-slider-style-'.$slider_style.' clearfix"'.(intval($params['slider_autoscroll']) ? ' data-autoscroll="'.intval($params['slider_autoscroll']).'"' : '').'>';
			while($posts->have_posts()) {
				$posts->the_post();
				include(locate_template('ct-templates/blog/content-blog-item-slider.php'));
			}
			echo '</div>';
		} else {
			if($params['is_ajax']) {
				echo '<div data-page="' . $paged . '" data-next-page="' . $next_page . '">';
			} else {
				if ($blog_style == '3x' || $blog_style == '4x' || $blog_style == '100%')
					echo '<div class="preloader"><div class="preloader-spin"></div></div>';
				if ($blog_style == 'timeline_new') {
					echo '<div class="timeline_new-wrapper"><div class="timeline-new-line"></div>';
				}
				echo '<div class="blog blog-style-'.str_replace('%', '', $blog_style) . ($blog_style == 'timeline_new' ? ' blog-style-timeline' : '').' '. (in_array($blog_style, array('3x', '4x', '100%', 'justified-3x', 'justified-4x')) && $params['color_style'] ? $params['color_style'] : ''). (in_array($blog_style, array('justified-3x', 'justified-4x')) && $params['color_style'] ? ' inline-row' : '').' clearfix '.($blog_style == '3x' || $blog_style == '4x' || $blog_style == '100%' ? 'blog-style-masonry ' : '').($blog_style == '100%' ? 'fullwidth-block' : '') . ' item-animation-' . $params['loading_animation'] . '" data-next-page="' . $next_page . '">';
			}

			$last_post_date = '';
			while($posts->have_posts()) {
				$posts->the_post();
				if($blog_style == '3x' || $blog_style == '4x' || $blog_style == '100%') {
					include(locate_template(array('ct-templates/blog/content-blog-item-masonry.php', 'content-blog-item.php')));
				} elseif($blog_style == 'justified-3x' || $blog_style == 'justified-4x') {
					include(locate_template(array('ct-templates/blog/content-blog-item-justified.php', 'content-blog-item.php')));
				} else {
					include(locate_template(array('ct-templates/blog/content-blog-item-'.$blog_style.'.php', 'content-blog-item.php')));
				}
				$last_post_date = get_the_date("M Y");
			}
			echo '</div>';
			if (!$params['is_ajax'] && $blog_style == 'timeline_new') {
				echo "</div>";
			}
			if ($params['blog_pagination'] == 'normal' && !$params['is_ajax']) {
				ct_pagination($posts, in_array($blog_style, array('justified-3x', 'justified-4x', '3x', '4x', '100%')));
			}
			?>

			<?php if($params['blog_pagination'] == 'more' && !$params['is_ajax'] && $posts->max_num_pages > $paged): ?>
				<div class="blog-load-more <?php if ($blog_style == 'timeline_new') echo 'blog-load-more-style-timeline-new'?>">
					<div class="inner">
						<?php ct_button(array_merge($params['button'], array('tag' => 'button', 'position' => 'center')), 1); ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if($params['blog_pagination'] == 'scroll' && !$params['is_ajax'] && $posts->max_num_pages > $paged): ?>
				<div class="blog-scroll-pagination"></div>
			<?php endif; ?>

			<?php
		}
	}
	wp_reset_postdata();
}
}

if(!function_exists('ct_pagination') && ct_check_function_version()) {
function ct_pagination($query = false, $centered=false) {
	if(!$query) {
		$query = $GLOBALS['wp_query'];
	}
	if($query->max_num_pages < 2) {
		return;
	}

	$paged        = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
	$pagenum_link = html_entity_decode(get_pagenum_link());
	$query_args   = array();
	$url_parts    = explode('?', $pagenum_link);

	if(isset($url_parts[1])) {
		wp_parse_str($url_parts[1], $query_args);
	}

	$pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
	$pagenum_link = trailingslashit($pagenum_link) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit('page/%#%', 'paged') : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links(array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $query->max_num_pages,
		'current'  => $paged,
		'mid_size' => 3,
		'add_args' => array_map('urlencode', $query_args),
		'prev_text' => '',
		'next_text' => '',
	));

	if($links) :

	?>
	<div class="ct-pagination<?php echo ($centered ? ' centered-box' : ''); ?>"><div class="ct-pagination-links">
		<?php echo $links; ?>
	</div></div><!-- .pagination -->
	<?php
	endif;
}
}

if(!function_exists('ct_contacts') && ct_check_function_version()) {
	function ct_contacts() {
		$output = '';
		if(cryption_get_option('contacts_address')) {
			$output .= '<div class="ct-contacts-item ct-contacts-address">'.esc_html__('Address:', 'avxbuilder').'<br> '.esc_html(stripslashes(cryption_get_option('contacts_address'))).'</div>';
		}
		if(cryption_get_option('contacts_phone')) {
			$output .= '<div class="ct-contacts-item ct-contacts-phone">'.esc_html__('Phone:', 'avxbuilder').' '.esc_html(stripslashes(cryption_get_option('contacts_phone'))).'</div>';
		}
		if(cryption_get_option('contacts_fax')) {
			$output .= '<div class="ct-contacts-item ct-contacts-fax">'.esc_html__('Fax:', 'avxbuilder').' '.esc_html(stripslashes(cryption_get_option('contacts_fax'))).'</div>';
		}
		if(cryption_get_option('contacts_email')) {
			$output .= '<div class="ct-contacts-item ct-contacts-email">'.esc_html__('Email:', 'avxbuilder').' <a href="'.esc_url('mailto:'.sanitize_email(cryption_get_option('contacts_email'))).'">'.sanitize_email(cryption_get_option('contacts_email')).'</a></div>';
		}
		if(cryption_get_option('contacts_website')) {
			$output .= '<div class="ct-contacts-item ct-contacts-website">'.esc_html__('Website:', 'avxbuilder').' <a href="'.esc_url(cryption_get_option('contacts_website')).'">'.esc_html(cryption_get_option('contacts_website')).'</a></div>';
		}
		if($output) {
			return '<div class="ct-contacts">'.$output.'</div>';
		}
		return;
	}
}

if(!function_exists('ct_aspect_ratio_to_percents') && ct_check_function_version()) {
	function ct_aspect_ratio_to_percents($aspect_ratio) {
		if($aspect_ratio) {
			$aspect_ratio = explode(':', $aspect_ratio);
			if(count($aspect_ratio) > 1 && intval($aspect_ratio[0]) > 0 && intval($aspect_ratio[1]) > 0) {
				return round(intval($aspect_ratio[1])/intval($aspect_ratio[0]), 4)*100;
			}
		}
		return '56.25';
	}
}