<?php
function ct_tag_cloud_args($args){
	$args['smallest'] = 12;
	$args['largest'] = 30;
	$args['unit'] = 'px';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'ct_tag_cloud_args');
add_filter( 'woocommerce_product_tag_cloud_widget_args', 'ct_tag_cloud_args');

function ct_clients_block($params) {
	$params = array_merge(array('clients_set' => '', 'autoscroll' => '', 'fullwidth' => '', 'effects_enabled' => false, 'disable_grayscale' => false), $params);
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
				'terms' => $params['clients_set']
			)
		);
	}
	$clients_items = new WP_Query($args);
	$params['autoscroll'] = intval($params['autoscroll']);
	if($clients_items->have_posts()) {
		wp_enqueue_script('ct-clients-grid-carousel');
		$clients_title = '';
		$clients_description = '';

		if($clients_set = get_term_by('slug', $params['clients_set'], 'ct_clients_sets')) {
			$clients_title = $clients_set->name;
			$clients_description = $clients_set->description;
		}

 		?>

		<?php if($params['fullwidth']) : ?><div class="fullwidth-block"><?php endif; ?>

			<div class="ct_client-carousel <?php if($params["disable_grayscale"]): ?> disable-grayscale<?php endif; ?> <?php if($params['effects_enabled']): ?>lazy-loading<?php endif; ?>" <?php if($params['effects_enabled']): ?>data-ll-item-delay="0"<?php endif; ?>>
				<div class="preloader slideshow-preloader"><div class="preloader-spin"></div></div>
				<div class="<?php echo ($params['fullwidth'] ? 'container ' : ''); ?> ct_client_carousel-items" data-autoscroll='<?php echo $params['autoscroll']?>'>
				<?php
					while($clients_items->have_posts()) {
					$clients_items->the_post();
					$link_start = '';
					$link_end = '';
					$item_data = ct_get_sanitize_client_data(get_the_ID());
					if($link = ct_get_data($item_data, 'link')) {
						$link_start = '<a href="'.esc_url($link).'" target="'.ct_get_data($item_data, 'link_target').'" class="grayscale grayscale-hover rounded-corners ">';
						$link_end = '</a>';
					}
				?>
				<div class="ct-client-item  <?php if($params['effects_enabled']): ?>lazy-loading-item<?php endif; ?>" <?php if($params['effects_enabled']): ?>data-ll-effect="drop-right"<?php endif; ?>> <?php echo $link_start?> <?php ct_post_thumbnail('ct-person', '', '')?> <?php echo $link_end?></div>
				<?php
		}
		?>

				</div>
			</div>
		<?php if($params['fullwidth']) : ?></div><?php endif; ?>
		<?php
	}
	wp_reset_postdata();
}

function ct_pf_categories() {
	$terms = get_the_terms(get_the_ID(), 'ct_portfolios');
	if($terms && !is_wp_error($terms)) {
		$list = array();
		foreach($terms as $term) {
			$list[] = $term->name;
		}
		echo  '<span class="sep">|</span> <span class="tags-links">'.join(' <span class="sep">|</span> ', $list).'</span>';
	}
}



/* BASIC GRID STYLES */
function ct_shortcode_post_grid_add_array_templates($templates) {
	$templatesMy['ct_basicGrid'] = array(
		'name' => __( 'Codex Themes Basic Grid 1', 'js_composer' ),
		'template' => '[vc_gitem c_zone_position="bottom" el_class="ct-basic-grid"]
			[vc_gitem_animated_block]
				[vc_gitem_zone_a height_mode="1-1" link="post_link" featured_image="yes"]
					[vc_gitem_row position="top"]
						[vc_gitem_col width="1/1"][/vc_gitem_col]
					[/vc_gitem_row]
					[vc_gitem_row position="middle"]
						[vc_gitem_col width="1/2"][/vc_gitem_col]
						[vc_gitem_col width="1/2"][/vc_gitem_col]
					[/vc_gitem_row]
					[vc_gitem_row position="bottom"]
						[vc_gitem_col width="1/1"][/vc_gitem_col]
					[/vc_gitem_row]
				[/vc_gitem_zone_a]
				[vc_gitem_zone_b]
					[vc_gitem_row position="top"]
						[vc_gitem_col width="1/1"][/vc_gitem_col]
					[/vc_gitem_row]
					[vc_gitem_row position="middle"]
						[vc_gitem_col width="1/2"][/vc_gitem_col]
						[vc_gitem_col width="1/2"][/vc_gitem_col]
					[/vc_gitem_row]
					[vc_gitem_row position="bottom"]
						[vc_gitem_col width="1/1"][/vc_gitem_col]
					[/vc_gitem_row]
				[/vc_gitem_zone_b]
			[/vc_gitem_animated_block]
			[vc_gitem_zone_c]
				[vc_gitem_row]
					[vc_gitem_col width="1/1" featured_image=""]
						[ct_post_title_with_date]
						[vc_gitem_post_excerpt link="none" font_container="tag:p|text_align:left" use_custom_fonts="" google_fonts="font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal"]
						[ct_button link="post_link" text="' . __( 'Read more', 'js_composer' ) . '" style="outline" size="tiny"]
					[/vc_gitem_col]
				[/vc_gitem_row]
			[/vc_gitem_zone_c]
		[/vc_gitem]');

	$templatesMy['ct_basicGrid_2'] = array(
		'name' => __( 'Codex Themes Basic Grid 2', 'js_composer' ),
		'template' => '[vc_gitem c_zone_position="bottom" el_class="ct-basic-grid-2"]
			[vc_gitem_animated_block]
				[vc_gitem_zone_a height_mode="1-1" link="post_link" featured_image="yes"]
					[vc_gitem_row position="top"]
						[vc_gitem_col width="1/1"][/vc_gitem_col]
					[/vc_gitem_row]
					[vc_gitem_row position="middle"]
						[vc_gitem_col width="1/2"][/vc_gitem_col]
						[vc_gitem_col width="1/2"][/vc_gitem_col]
					[/vc_gitem_row]
					[vc_gitem_row position="bottom"]
						[vc_gitem_col width="1/1"][/vc_gitem_col]
					[/vc_gitem_row]
				[/vc_gitem_zone_a]
				[vc_gitem_zone_b]
					[vc_gitem_row position="top"]
						[vc_gitem_col width="1/1"][/vc_gitem_col]
					[/vc_gitem_row]
					[vc_gitem_row position="middle"]
						[vc_gitem_col width="1/2"][/vc_gitem_col]
						[vc_gitem_col width="1/2"][/vc_gitem_col]
					[/vc_gitem_row]
					[vc_gitem_row position="bottom"]
						[vc_gitem_col width="1/1"][/vc_gitem_col]
					[/vc_gitem_row]
				[/vc_gitem_zone_b]
			[/vc_gitem_animated_block]
			[vc_gitem_zone_c]
				[vc_gitem_row]
					[vc_gitem_col width="1/1" featured_image=""]
						[ct_post_title_with_date]
						[vc_gitem_post_excerpt link="none" font_container="tag:p|text_align:left" use_custom_fonts="" google_fonts="font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal"]
						[ct_button link="post_link" text="' . __( 'Read more', 'js_composer' ) . '" style="outline" size="tiny"]
					[/vc_gitem_col]
				[/vc_gitem_row]
			[/vc_gitem_zone_c]
		[/vc_gitem]');

	$templatesMy['ct_mediaGrid'] = array(
		'name' => __( 'Codex Themes Media Grid 1', 'js_composer' ),
		'template' => '[vc_gitem el_class="ct-media-grid"]
				[vc_gitem_animated_block animation="slideBottom"]
					[vc_gitem_zone_a height_mode="1-1" link="none" featured_image="yes"]
						[vc_gitem_row position="top"]
							[vc_gitem_col width="1/1"][/vc_gitem_col]
						[/vc_gitem_row]
						[vc_gitem_row position="middle"]
							[vc_gitem_col width="1/2"][/vc_gitem_col]
							[vc_gitem_col width="1/2"][/vc_gitem_col]
						[/vc_gitem_row]
						[vc_gitem_row position="bottom"]
							[vc_gitem_col width="1/1"][/vc_gitem_col]
						[/vc_gitem_row]
					[/vc_gitem_zone_a]
					[vc_gitem_zone_b link="none" featured_image=""]
						[vc_gitem_row position="top"]
							[vc_gitem_col width="1/1"][/vc_gitem_col]
						[/vc_gitem_row]
						[vc_gitem_row position="middle"]
							[vc_gitem_col width="1/1"]
								[vc_gitem_post_title link="post_link" font_container="tag:div|text_align:center" use_custom_fonts="yes"]
								[vc_separator color="white" align="align_center" border_width="2" el_width="50"]
								[vc_gitem_post_excerpt link="none" font_container="tag:div|text_align:center" use_custom_fonts="yes"]
								[ct_post_author]
							[/vc_gitem_col]
						[/vc_gitem_row]
						[vc_gitem_row position="bottom"]
							[vc_gitem_col width="1/1"][/vc_gitem_col]
						[/vc_gitem_row]
					[/vc_gitem_zone_b]
				[/vc_gitem_animated_block]
			[/vc_gitem]');

	$templatesMy['ct_mediaGrid_2'] = array(
		'name' => __( 'Codex Themes Media Grid 2', 'js_composer' ),
		'template' => '[vc_gitem el_class="ct-media-grid-2"]
				[vc_gitem_animated_block animation="slideBottom"]
					[vc_gitem_zone_a height_mode="1-1" link="none" featured_image="yes"]
						[vc_gitem_row position="top"]
							[vc_gitem_col width="1/1"][/vc_gitem_col]
						[/vc_gitem_row]
						[vc_gitem_row position="middle"]
							[vc_gitem_col width="1/2"][/vc_gitem_col]
							[vc_gitem_col width="1/2"][/vc_gitem_col]
						[/vc_gitem_row]
						[vc_gitem_row position="bottom"]
							[vc_gitem_col width="1/1"][/vc_gitem_col]
						[/vc_gitem_row]
					[/vc_gitem_zone_a]
					[vc_gitem_zone_b link="none" featured_image=""]
						[vc_gitem_row position="top"]
							[vc_gitem_col width="1/1"][/vc_gitem_col]
						[/vc_gitem_row]
						[vc_gitem_row position="middle"]
							[vc_gitem_col width="1/1"]
								[ct_post_author]
								[vc_gitem_post_excerpt link="none" font_container="tag:div|text_align:left" use_custom_fonts="yes"]
								[vc_gitem_post_title link="post_link" font_container="tag:div|text_align:left" use_custom_fonts="yes"]
							[/vc_gitem_col]
						[/vc_gitem_row]
						[vc_gitem_row position="bottom"]
							[vc_gitem_col width="1/1"][/vc_gitem_col]
						[/vc_gitem_row]
					[/vc_gitem_zone_b]
				[/vc_gitem_animated_block]
			[/vc_gitem]');
	return array_merge($templatesMy, $templates);
}
/* Add shortcode POST AUTOR */
add_filter('vc_grid_item_predefined_templates', 'ct_shortcode_post_grid_add_array_templates');

function ct_add_default_post_grid_template() {
	$param = WPBMap::getParam( 'vc_basic_grid', 'item' );
	$param['std'] = 'ct_basicGrid';
	vc_update_shortcode_param( 'vc_basic_grid', $param );
}
add_action( 'vc_after_init', 'ct_add_default_post_grid_template' );

function ct_attribute_post_author( $value, $data ) {
   extract( array_merge( array(
      'post' => null,
      'data' => ''
   ), $data ) );

   return get_the_author_link();
}
add_filter( 'vc_gitem_template_attribute_post_author', 'ct_attribute_post_author', 10, 2 );

function ct_post_author() {
   return '<div class="midia-grid-item-post-author">By <span>{{ post_author }}</span></div>'; 
}
add_shortcode( 'ct_post_author', 'ct_post_author' );
/* Add shortcode POST TITLE WITH DATE */

add_filter( 'vc_gitem_template_attribute_post_title_with_date', 'ct_attribute_post_title_with_date', 10, 2 );
function ct_attribute_post_title_with_date( $value, $data ) {
	extract( array_merge( array(
		'post' => null,
		'data' => ''
	), $data ) );

	return '<div class="post-title"><h4 class="entry-title"><a href="'.esc_url(get_permalink()).'" rel="bookmark">'.mysql2date('d M', $post->post_date).': <span class="light">'. get_the_title($post->ID) .'</span></a></h4></div>';
}

add_shortcode( 'ct_post_title_with_date', 'ct_post_title_with_date' );
function ct_post_title_with_date($atts) {
	return '{{ post_title_with_date }}'; 
}







/* ADD 2 ICONS PACKS TWO TABS ACCORIONS TOURS */

add_action( 'vc_base_register_front_css', 'ct_vc_iconpicker_base_register_css' );
add_action( 'vc_base_register_admin_css', 'ct_vc_iconpicker_base_register_css' );

/* Подключаем Font Icons CSS */
function ct_vc_iconpicker_base_register_css() {
	wp_register_style('ct-elegant-icons', get_template_directory_uri() . '/css/icons-elegant.css');
	wp_register_style('ct-material-icons', get_template_directory_uri() . '/css/icons-material.css');
}



add_action('vc_enqueue_font_icon_element', 'ct_vc_change_icon_font', 10);
function ct_vc_change_icon_font($font){
	if($font === 'elegant'){
		wp_enqueue_style( 'icons-elegant' );
	} elseif ($font === 'material'){
		wp_enqueue_style( 'icons-material' );
	}
}

add_action( 'vc_backend_editor_enqueue_js_css', 'ct_iconpicker_editor_jscss', 10 );
add_action( 'vc_frontend_editor_enqueue_js_css', 'ct_iconpicker_editor_jscss', 10 );

function ct_iconpicker_editor_jscss() {
	wp_enqueue_style('icons-elegant');
	wp_enqueue_style('icons-material');
}



/* Добавляем 2 options в выпадающий список */
function ct_add_2_icon_packs() {
	$param = WPBMap::getParam( 'vc_tta_section', 'i_type' );
	if(is_array($param['value'])) {
		$paramMy = array();
		$paramMy[__( 'Elegant Icons', 'ct' )] = 'elegant';
		$paramMy[__( 'Material Design', 'ct' )] = 'material';
		$param['value'] = array_merge($paramMy, $param['value']);
		vc_update_shortcode_param( 'vc_tta_section', $param );
	}
}
add_action( 'vc_after_init', 'ct_add_2_icon_packs' );

/* Для правильной сортировки элементов */
function ct_change_element_weight() {
	$param = WPBMap::getParam( 'vc_tta_section', 'el_class' );
	$param['weight'] = -2;
	vc_update_shortcode_param( 'vc_tta_section', $param );
}
add_action( 'vc_after_init', 'ct_change_element_weight' );

/* Привязываем опции к иконкам */
function ct_add_2_icon_packs_dependences(){
	$attributes = array(
	    'type' => 'iconpicker',
	    'heading' => "Elegant",
	    'param_name' => 'i_icon_elegant', // пак с иконками
	    'weight' => -1, //  default 0 - unsorted and appended to bottom, 1 - appended to top
	    'dependency' => array(
			'element' => 'i_type',  // тип элемента к которому привязываем
			'value' => array('elegant') // название option
		),
		'settings' => array(
			'emptyIcon' => false, // default true, display an "EMPTY" icon?
			'type' => 'elegant',
			'iconsPerPage' => 4000, // default 100, how many icons per/page to display
		),
	);
	vc_add_param( 'vc_tta_section', $attributes );

	$attributes = array(
	    'type' => 'iconpicker',
	    'heading' => "Material",
	    'param_name' => 'i_icon_material',
	    'weight' => -1, //  default 0 - unsorted and appended to bottom, 1 - appended to top
	    'dependency' => array(
			'element' => 'i_type',
			'value' => array('material')
		),
		'settings' => array(
			'emptyIcon' => false, // default true, display an "EMPTY" icon?
			'type' => 'material',
			'iconsPerPage' => 4000, // default 100, how many icons per/page to display
		),

	);
	vc_add_param( 'vc_tta_section', $attributes );
}
add_action( 'vc_after_init', 'ct_add_2_icon_packs_dependences' );