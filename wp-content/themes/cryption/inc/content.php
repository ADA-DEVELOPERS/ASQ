<?php
function cryption_theme_widgets_init($value) {
	$value = array(
		'CT_Widget_Popular_Posts',
		'CT_Widget_Recent_Posts',
		'CT_Widget_Tweets',
        'CT_Widget_Testimonial',
        'CT_Widget_Contats',
        'CT_Widget_Picturebox',
		'CT_Socials',
		'CT_Project_Slider',
	);
	return $value;
}
add_filter('ct_available_widgets', 'cryption_theme_widgets_init');

function cryption_theme_post_types_init($value) {
	$value = array('galleries', 'portfolios', 'teams', 'testimonials', 'slideshows', 'clients', 'quickfinders', 'footers');
	return $value;
}
add_filter('ct_available_post_types', 'cryption_theme_post_types_init');

function cryption_contacts() {
	$output = '';
	if(cryption_get_option('contacts_address')) {
		$output .= '<div class="ct-contacts-item ct-contacts-address">'.esc_html__('Address:', 'cryption').'<br /> '.esc_html(stripslashes(cryption_get_option('contacts_address'))).'</div>';
	}
	if(cryption_get_option('contacts_phone')) {
		$output .= '<div class="ct-contacts-item ct-contacts-phone">'.esc_html__('Phone:', 'cryption').' '.esc_html(stripslashes(cryption_get_option('contacts_phone'))).'</div>';
	}
	if(cryption_get_option('contacts_fax')) {
		$output .= '<div class="ct-contacts-item ct-contacts-fax">'.esc_html__('Fax:', 'cryption').' '.esc_html(stripslashes(cryption_get_option('contacts_fax'))).'</div>';
	}
	if(cryption_get_option('contacts_email')) {
		$output .= '<div class="ct-contacts-item ct-contacts-email">'.esc_html__('Email:', 'cryption').' <a href="'.esc_url('mailto:'.sanitize_email(cryption_get_option('contacts_email'))).'">'.sanitize_email(cryption_get_option('contacts_email')).'</a></div>';
	}
	if(cryption_get_option('contacts_website')) {
		$output .= '<div class="ct-contacts-item ct-contacts-website">'.esc_html__('Website:', 'cryption').' <a href="'.esc_url(cryption_get_option('contacts_website')).'">'.esc_html(cryption_get_option('contacts_website')).'</a></div>';
	}
	if($output) {
		return '<div class="ct-contacts">'.$output.'</div>';
	}
	return;
}

function cryption_top_area_contacts()
{
	$output = '';
	if (cryption_get_option('top_area_contacts_address')) {
		$output .= '<div class="ct-contacts-item ct-contacts-address">' . esc_html(stripslashes(cryption_get_option('top_area_contacts_address'))) . '</div>';
	}
	if (cryption_get_option('top_area_contacts_phone')) {
		$output .= '<div class="ct-contacts-item ct-contacts-phone">' . esc_html(stripslashes(cryption_get_option('top_area_contacts_phone'))) . '</div>';
	}
	if (cryption_get_option('top_area_contacts_fax')) {
		$output .= '<div class="ct-contacts-item ct-contacts-fax">' . esc_html(stripslashes(cryption_get_option('top_area_contacts_fax'))) . '</div>';
	}
	if (cryption_get_option('top_area_contacts_email')) {
		$output .= '<div class="ct-contacts-item ct-contacts-email"><a href="' . esc_url('mailto:' . sanitize_email(cryption_get_option('top_area_contacts_email'))) . '">' . sanitize_email(cryption_get_option('top_area_contacts_email')) . '</a></div>';
	}
	if (cryption_get_option('top_area_contacts_website')) {
		$output .= '<div class="ct-contacts-item ct-contacts-website"><a href="' . esc_url(cryption_get_option('top_area_contacts_website')) . '">' . esc_html(cryption_get_option('top_area_contacts_website')) . '</a></div>';
	}
	if ($output) {
		return '<div class="ct-contacts inline-inside">' . $output . '</div>';
	}
	return;
}

function cryption_related_posts() {
	$post_tags = wp_get_post_tags(get_the_ID());
	$post_tags_ids = array();
	foreach($post_tags as $individual_tag) {
		$post_tags_ids[] = $individual_tag->term_id;
	}
	if($post_tags_ids) {
		$args=array(
			'tag__in' => $post_tags_ids,
			'post__not_in' => array(get_the_ID()),
			'posts_per_page' => 3,
			'orderby' => 'rand'
		);
		$related_query = new WP_Query($args);
		if($related_query->have_posts()) {
			wp_enqueue_script('ct-related-posts-carousel');
?>
	<div class="post-related-posts">
		<h3><?php esc_html_e('Related', 'cryption'); ?> <?php esc_html_e('posts', 'cryption'); ?></h3>
		<div class="post-related-posts-block">
			<div class="related-posts">
				<?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
					<div class="related-element col-md-4 col-sm-6 col-xs-12">
						<a href="<?php echo esc_url(get_permalink()); ?>"><?php cryption_post_thumbnail('ct-post-thumb', true, ''); ?></a>
						<div class="related-element-info clearfix">
							<div class="related-element-info-conteiner">
								<?php the_title('<a href="'.esc_url(get_permalink()).'">', '</a>'); ?>
							</div>
							
						</div>
					</div>
				<?php endwhile; wp_reset_postdata() ?>
			</div>

		</div>
	</div>
<?php
		}
	}
}

function cryption_comment_form_before_fields() {
	echo '<div class="row comment-form-fields">';
}
add_action( 'comment_form_before_fields', 'cryption_comment_form_before_fields' );

function cryption_comment_form_after_fields() {
	echo '</div>';
}
add_action( 'comment_form_after_fields', 'cryption_comment_form_after_fields' );

function cryption_comment($comment, $args, $depth) {
		if('div' == $args['style']) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
?>
		<<?php echo $tag; ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?> id="comment-<?php comment_ID(); ?>">
		<?php if('div' != $args['style']) : ?>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<?php endif; ?>
		<div class="comment-inner bordered-box">
			<div class="comment-header clearfix">
				<div class="comment-author vcard">
					<?php if(get_comment_type() == 'comment') : ?>
						<?php if(0 != $args['avatar_size']) { echo '<div class="comment-avatar bordered-box">'.get_avatar($comment, $args['avatar_size']).'</div>'; } ?>
					<?php endif; ?>
					<?php printf(wp_kses(__('<div class="fn title-h6">%s</div>', 'cryption'), array('div' => array('class' => array()))), get_comment_author_link()); ?>
					<div class="comment-meta commentmetadata date-color"><a href="<?php echo esc_url(get_comment_link($comment->comment_ID, $args)); ?>">
						<?php
							/* translators: 1: date, 2: time */
							printf(esc_html__('%1$s at %2$s', 'cryption'), get_comment_date(),  get_comment_time()); ?></a><?php edit_comment_link(esc_html__('(Edit)', 'cryption'), '&nbsp;&nbsp;', '');
						?>
					</div>
				</div>
				<div class="reply">
					<?php echo str_replace('comment-reply-link', 'comment-reply-link', get_comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'])))); ?>
				</div>
			</div>
			<?php if('0' == $comment->comment_approved) : ?>
			<div class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'cryption') ?></div>
			<?php endif; ?>

			<div class="comment-text">
				<?php comment_text(get_comment_id(), array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
			</div>

			<?php if('div' != $args['style']) : ?>
			</div>
			<?php endif; ?>
		</div>
<?php
}

function cryption_toparea_search_form() {
?>
<form role="search" method="get" id="top-area-searchform" class="searchform" action="<?php echo esc_url(home_url('/')); ?>">
	<div>
		<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="top-area-s" />
		<button type="submit" id="top-area-searchsubmit" value="<?php echo esc_attr_x('Search', 'submit button', 'cryption'); ?>"></button>
	</div>
</form>
<?php
}

function cryption_author_info($post_id, $full = FALSE) {
	$post = get_post($post_id);
	$user_id = $post->post_author;
	$user_data = get_userdata( $user_id );
	$show = TRUE;
	if(!cryption_get_option('show_author') || empty($user_data->description)) {
		$show = FALSE;
	}
	?>
	<?php if ($show): ?>
		<div class="post-author-block shadow-box clearfix">
			<div class="post-author-avatar"><?php echo get_avatar( $user_id, 95 ); ?></div>
			<div class="post-author-info">
				<?php if (!empty($user_data->data) && !empty($user_data->data->display_name)): ?><div class="name title-h5"><?php echo esc_html($user_data->data->display_name); ?> <span class="light"><?php esc_html_e('/ About Author', 'cryption'); ?></span></div><?php endif; ?>
				<?php if (!empty($user_data->description)): ?><div class="post-author-description"><?php echo wp_kses_post($user_data->description); ?></div><?php endif; ?>
				<?php if (!empty($user_data->data) && !empty($user_data->data->display_name)): ?><div class="post-author-posts-link"><a href="<?php echo esc_url(get_author_posts_url( $user_id )); ?>"><?php printf(esc_html__('More posts by %s', 'cryption'), $user_data->data->display_name); ?></a></div><?php endif; ?>
			</div>
		</div>
	<?php endif; ?>
<?php
}

function cryption_post_tags() {
	$post_tags = wp_get_post_tags(get_the_ID());
	$post_tags_ids = array();
	foreach($post_tags as $individual_tag) {
		$post_tags_ids[] = $individual_tag->term_id;
	}
	if ($post_tags_ids) {
		$args=array(
			'tag__in' => $post_tags_ids,
			'post__not_in' => array(get_the_ID()),
			'posts_per_page'=>3,
			'orderby' => 'rand'
		);
		$related_query = new WP_Query( $args );
	}

	echo '<div class="block-tags">';
	echo '<div class="block-date">';
	echo get_the_date();
	echo '</div>';

	if ($post_tags_ids) {
		echo '<span class="sep"></span>';
	}
	$tag_list = get_the_tag_list( '', wp_kses(__( '<span class="sep"></span>', 'cryption' ), array('span' => array('class' => array()))) );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}
	echo '</div>';
}

function cryption_blog($params = array()) {
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
		'text' => esc_html__('Load More', 'cryption'),
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

	$params['blog_pagination'] = cryption_check_array_value(array('normal', 'more', 'scroll', 'disable'), $params['blog_pagination'], 'normal');
	$params['color_style'] = cryption_check_array_value(array('style-1', 'style-2'), $params['color_style'], 'style-1');
	$params['slider_style'] = cryption_check_array_value(array('fullwidth', 'halfwidth'), $params['slider_style'], 'fullwidth');
	$params['loading_animation'] = cryption_check_array_value(array('disabled', 'bounce', 'move-up', 'fade-in', 'fall-perspective', 'scale', 'flip'), $params['loading_animation'], 'move-up');

	if ($params['blog_pagination'] == 'scroll' && $params['blog_style'] != 'grid_carousel' && $params['blog_style'] != 'slider') {
		$params['effects_enabled'] = true;
	}

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	if ($params['blog_pagination'] == 'disable' || $params['blog_style'] == 'grid_carousel'|| $params['blog_style'] == 'slider')
		$paged = 1;

	if ($params['paged'] != -1)
		$paged = $params['paged'];

	$params['blog_style'] = cryption_check_array_value(array('default', 'timeline', 'timeline_new', '3x', '4x', 'justified-3x', 'justified-4x', '100%', 'grid_carousel', 'styled_list1', 'styled_list2', 'multi-author', 'compact', 'slider'), $params['blog_style'], 'default');
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
				cryption_pagination($posts, in_array($blog_style, array('justified-3x', 'justified-4x', '3x', '4x', '100%')));
			}
			?>

			<?php if($params['blog_pagination'] == 'more' && !$params['is_ajax'] && $posts->max_num_pages > $paged): ?>
				<div class="blog-load-more <?php if ($blog_style == 'timeline_new') echo 'blog-load-more-style-timeline-new'?>">
					<div class="inner">
						<?php cryption_button(array_merge($params['button'], array('tag' => 'button', 'position' => 'center')), 1); ?>
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


function cryption_get_search_form($form) {
	$form = '<form role="search" method="get" id="searchform" class="searchform" action="' . esc_url(home_url('/')) . '">
				<div>
					<input type="text" value="' . get_search_query() . '" name="s" id="s" />
					 <button class="ct-button" type="submit" id="searchsubmit" value="' . esc_attr_x('Search', 'submit button', 'cryption') . '">'.esc_attr_x('Search', 'submit button', 'cryption').'</button>
				</div>
			</form>';
	return $form;
}
add_filter('get_search_form', 'cryption_get_search_form');

if(!function_exists('cryption_video_background')) {
function cryption_video_background($video_type, $video, $aspect_ratio = '16:9', $headerUp = false, $color = '', $opacity = '', $poster='') {
	$output = '';
	$video_type = cryption_check_array_value(array('', 'youtube', 'vimeo', 'self'), $video_type, '');
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
			$video_block = '<video autoplay="autoplay" controls="" loop="loop" src="'.esc_url($video).'" muted="muted"'.($poster ? ' poster="'.esc_url($poster).'"' : '').'></video>';
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

function cryption_aspect_ratio_to_percents($aspect_ratio) {
	if($aspect_ratio) {
		$aspect_ratio = explode(':', $aspect_ratio);
		if(count($aspect_ratio) > 1 && intval($aspect_ratio[0]) > 0 && intval($aspect_ratio[1]) > 0) {
			return round(intval($aspect_ratio[1])/intval($aspect_ratio[0]), 4)*100;
		}
	}
	return '56.25';
}

if(!function_exists('cryption_button')) {
function cryption_button($params = array(), $echo = false) {
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
		'attributes' => array(),
		'effects_enabled' => false
	), $params);

	$params['tag'] = cryption_check_array_value(array('a', 'button', 'input'), $params['tag'], 'a');
	$params['text'] = esc_html($params['text']);
	if($params['href'] === 'post_link') {
		$params['href'] = '{{ post_link_url }}';
	} else {
		$params['href'] = esc_url($params['href']);
	}
	$params['target'] = cryption_check_array_value(array('_self', '_blank'), trim($params['target']), '_self');
	$params['title'] = esc_attr($params['title']);
	$params['style'] = cryption_check_array_value(array('flat', 'outline'), $params['style'], 'flat');
	$params['size'] = cryption_check_array_value(array('tiny', 'small', 'medium', 'large', 'giant'), $params['size'], 'small');
	$params['text_weight'] = cryption_check_array_value(array('normal', 'thin'), $params['text_weight'], 'normal');
	$params['no-uppercase'] = $params['no-uppercase'] ? 1 : 0;
	$params['corner'] = intval($params['corner']) >= 0 ? intval($params['corner']) : 3;
	$params['border'] = cryption_check_array_value(array('1', '2', '3', '4', '5', '6'), $params['border'], '2');
	$params['position'] = cryption_check_array_value(array('inline', 'left', 'right', 'center', 'fullwidth'), $params['position'], 'inline');
	$params['text_color'] = esc_attr($params['text_color']);
	$params['background_color'] = esc_attr($params['background_color']);
	$params['border_color'] = esc_attr($params['border_color']);
	$params['hover_text_color'] = esc_attr($params['hover_text_color']);
	$params['hover_background_color'] = esc_attr($params['hover_background_color']);
	$params['hover_border_color'] = esc_attr($params['hover_border_color']);
	$params['icon'] = esc_attr($params['icon']);
	$params['icon_pack'] = cryption_check_array_value(array('ct-icons', 'elegant', 'material', 'fontawesome', 'userpack'), $params['icon_pack'], 'ct-icons');
	$params['icon_position'] = cryption_check_array_value(array('left', 'right'), $params['icon_position'], 'left');
	$params['separator'] = cryption_check_array_value(array('', 'single', 'square', 'soft-double', 'strong-double', 'load-more'), $params['separator'], '');
	$params['extra_class'] = esc_attr($params['extra_class']);
	$params['id'] = sanitize_title($params['id']);
	$params['gradient_backgound'] = $params['gradient_backgound'] ? 1 : 0;
	$params['gradient_radial_swap_colors'] = $params['gradient_radial_swap_colors'] ? 1 : 0;
	$params['gradient_backgound_from'] = esc_attr($params['gradient_backgound_from']);
	$params['gradient_backgound_to'] = esc_attr($params['gradient_backgound_to']);
	$params['gradient_backgound_hover_from'] = esc_attr($params['gradient_backgound_hover_from']);
	$params['gradient_backgound_hover_to'] = esc_attr($params['gradient_backgound_hover_to']);
	$params['gradient_backgound_style'] = cryption_check_array_value(array('linear', 'radial'), $params['gradient_backgound_style']);
	$params['gradient_backgound_angle'] = cryption_check_array_value(array('to bottom', 'to top','to right', 'to left', 'to bottom right', 'to top right', 'to bottom left', 'to top left', 'cusotom_deg'), $params['gradient_backgound_angle']);
	$params['gradient_backgound_cusotom_deg'] = esc_attr($params['gradient_backgound_cusotom_deg']);
	$params['gradient_radial_backgound_position'] = cryption_check_array_value(array('at top', 'at bottom', 'at right', 'at left', 'at center'), $params['gradient_radial_backgound_position']);

	$sep = '';
	if($params['separator']) {
		$params['position'] = 'center';
		if($params['style'] == 'flat') {
			$sep_color = $params['background_color'] ? $params['background_color'] : cryption_get_option('button_background_basic_color');
		} else {
			$sep_color = $params['border_color'] ? $params['border_color'] : cryption_get_option('button_outline_border_basic_color');
		}
		if($params['separator'] == 'load-more') {
			$sep_color = cryption_get_option('box_border_color');
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
				$output .= cryption_build_icon($params['icon_pack'], $params['icon']).$params['text'];
			} else {
				$output .= $params['text'].cryption_build_icon($params['icon_pack'], $params['icon']);
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

if(!function_exists('cryption_build_icon')) {
function cryption_build_icon($pack, $icon) {
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

function cryption_get_post_featured_content($post_id, $thumb_size = 'ct-blog-default-large', $single = false, $picture_sources=array()) {
	$format = get_post_format($post_id);
	$post_item_data = cryption_get_sanitize_post_data($post_id);
	$output = '';
	if($post_item_data['show_featured_content'] || !$single) {
		if($format == 'video' && $post_item_data['video']) {
			$aspect_percents = cryption_aspect_ratio_to_percents($post_item_data['video_aspect_ratio']);
			$video_block = '';
			if($post_item_data['video_type'] == 'youtube') {
				$video_block = '<iframe frameborder="0" allowfullscreen="allowfullscreen" scrolling="no" marginheight="0" marginwidth="0" src="'.esc_url('//www.youtube.com/embed/'.$post_item_data['video'].'?rel=0&amp;wmode=opaque').'"></iframe>';
			} elseif($post_item_data['video_type'] == 'vimeo') {
				$video_block = '<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.esc_url('//player.vimeo.com/video/'.$post_item_data['video'].'?title=0&amp;byline=0&amp;portrait=0').'"></iframe>';
			} else {
				wp_enqueue_style('wp-mediaelement');
				wp_enqueue_script('ct-mediaelement');
				$img = cryption_generate_thumbnail_src(get_post_thumbnail_id($post_id), $thumb_size);
				$video_block = '<video style="width: 100%; height: 100%;" controls="controls" src="'.esc_url($post_item_data['video']).'" '.(has_post_thumbnail() ? ' poster="'.esc_url($img[0]).'"' : '').' preload="none"></video>';
			}
			$output = '<div class="video-block" style="padding-top: '.esc_attr($aspect_percents).'%;">'.$video_block.'</div>';
		} elseif($format == 'audio' && $post_item_data['audio']) {
			wp_enqueue_style('wp-mediaelement');
			wp_enqueue_script('ct-mediaelement');
			$output = '<div class="audio-block"><audio width="100%" controls="controls" src="'.esc_url($post_item_data['audio']).'" preload="none"></audio></div>';
		} elseif($format == 'gallery' && cryption_is_plugin_active('ct-elements/ct-elements.php') && $post_item_data['gallery']) {
			ob_start();
			cryption_simple_gallery(array('gallery' => $post_item_data['gallery'], 'thumb_size' => $thumb_size, 'autoscroll' => $post_item_data['gallery_autoscroll'], 'responsive' => 1));
			$output = ob_get_clean();
		} elseif($format == 'quote' && $post_item_data['quote_text']) {
			$output = '<blockquote'.($post_item_data['quote_background'] ? ' style="background-color: '.$post_item_data['quote_background'].';"' : '').'>'.$post_item_data['quote_text'];
			if($post_item_data['quote_author'] || !$single) {
				$quote_author = $post_item_data['quote_author'] ? '<div class="quote-author"'.($post_item_data['quote_author_color'] ? ' style="color: '.$post_item_data['quote_author_color'].';"' : '').'>'.$post_item_data['quote_author'].'</div>' : '';
				$quote_link = !$single ? '<div class="quote-link"'.($post_item_data['quote_author_color'] ? ' style="color: '.$post_item_data['quote_author_color'].';"' : '').'><a href="'.esc_url(get_permalink($post_id)).'"></a></div>' : '';
				$output .= '<div class="quote-bottom clearfix">'.$quote_author.$quote_link.'</div>';
			}
			$output .= '</blockquote>';
		} elseif(has_post_thumbnail()) {
			ob_start();
			cryption_generate_picture(get_post_thumbnail_id($post_id), $thumb_size, $picture_sources, array('class' => 'img-responsive', 'alt' => get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true)));
			$image = ob_get_clean();
			if($single) {
				$output = $image;
			} else {
				$output = '<a href="'.esc_url(get_permalink($post_id)).'">'.$image.'</a>';
			}
		}
		$output = $output ? '<div class="post-featured-content">'.$output.'</div>' : '';
	}
	return $output;
}

function cryption_comment_form_fields($comment_fields) {
	if(!empty($comment_fields['comment'])) {
		$comment = $comment_fields['comment'];
		unset($comment_fields['comment']);
		$comment_fields = $comment_fields + array('comment' => $comment);
	}
	return $comment_fields;
}
add_filter('comment_form_fields', 'cryption_comment_form_fields');

if(!function_exists('cryption_add_srcset_rule')) {
	function cryption_add_srcset_rule(&$srcset, $condition, $size, $id=false) {
		if (!$id) {
			$id = get_post_thumbnail_id();
		}
		$im = cryption_generate_thumbnail_src($id, $size);
		$srcset[$condition] = $im[0];
	}
}

if(!function_exists('cryption_srcset_list_to_string')) {
	function cryption_srcset_list_to_string($srcset) {
		if (count($srcset) == 0) {
			return '';
		}
		$srcset_condtions = array();
		foreach ($srcset as $condition => $url) {
			$srcset_condtions[] = $url . ' ' . $condition;
		}
		return implode(', ', $srcset_condtions);
	}
}

if(!function_exists('cryption_quickfinder_srcset')) {
	function cryption_quickfinder_srcset($cryption_item_data) {
		$attr = array('srcset' => array());

		switch ($cryption_item_data['icon_size']) {
			case 'small':
			case 'medium':
				$attr['srcset']['1x'] = 'ct-person-80';
				$attr['srcset']['2x'] = 'ct-person-160';
				break;

			case 'large':
				$attr['srcset']['1x'] = 'ct-person-160';
				$attr['srcset']['2x'] = 'ct-person';
				break;

			case 'xlarge':
				$attr['srcset']['1x'] = 'ct-person-240';
				$attr['srcset']['2x'] = 'ct-person';
				break;
		}

		return $attr;
	}
}

if(!function_exists('cryption_post_picture')) {
	function cryption_post_picture($default_size, $sources=array(), $attrs=array(), $dummy = true) {
		if (has_post_thumbnail()) {
			cryption_generate_picture(get_post_thumbnail_id(), $default_size, $sources, $attrs);
		} elseif ($dummy) {
			if (empty($attrs['class'])) {
				$attrs['class'] = 'gem-dummy';
			} else {
				$attrs['class'] .= ' gem-dummy';
			}
			echo '<span class="' . esc_attr($attrs['class']) . '"></span>';
		}
	}
}

if(!function_exists('cryption_generate_picture')) {
	function cryption_generate_picture($attachment_id, $default_size, $sources=array(), $attrs=array()) {
		if (!in_array($default_size, array_keys(cryption_image_sizes()))) {
			return '';
		}
		$default_image = cryption_generate_thumbnail_src($attachment_id, $default_size);
		if (!$default_image) {
			return '';
		}
		list($src, $width, $height) = $default_image;
		$hwstring = image_hwstring($width, $height);

		$default_attrs = array('class' => "attachment-$default_size");
		if (empty($attrs['alt'])) {
			$attachment = get_post($attachment_id);
			$attrs['alt'] = trim(strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true)));
			if(empty($default_attr['alt']))
				$attrs['alt'] = trim(strip_tags($attachment->post_excerpt));
			if(empty($default_attr['alt']))
				$attrs['alt'] = trim(strip_tags($attachment->post_title));
		}

		$attrs = wp_parse_args($attrs, $default_attrs);
		$attrs = array_map('esc_attr', $attrs);
		$attrs_set = array();
		foreach ($attrs as $attr_key => $attr_value) {
			$attrs_set[] = $attr_key . '="' . $attr_value . '"';
		}
		?>
		<picture>
			<?php cryption_generate_picture_sources($attachment_id, $sources); ?>
			<img src="<?php echo $src; ?>" <?php echo $hwstring; ?> <?php echo implode(' ', $attrs_set); ?> />
		</picture>
		<?php
	}
}

if(!function_exists('cryption_generate_picture_sources')) {
	function cryption_generate_picture_sources($attachment_id, $sources) {
		if (!$sources) {
			return '';
		}
		?>
		<?php foreach ($sources as $source): ?>
			<?php
				$srcset = cryption_srcset_generate_urls($attachment_id, $source['srcset']);
				if (!$srcset) {
					continue;
				}
			?>
			<source srcset="<?php echo cryption_srcset_list_to_string($srcset); ?>" <?php if(!empty($source['media'])): ?>media="<?php echo esc_attr($source['media']); ?>"<?php endif; ?> <?php if(!empty($source['type'])): ?>type="<?php echo esc_attr($source['type']); ?>"<?php endif; ?><?php echo !empty($source['sizes']) ? ' sizes="'.esc_attr($source['sizes']).'"' : ''; ?>>
		<?php endforeach; ?>
		<?php
	}
}

if(!function_exists('cryption_srcset_generate_urls')) {
	function cryption_srcset_generate_urls($attachment_id, $srcset) {
		$result = array();
		$cryption_sizes = array_keys(cryption_image_sizes());
		foreach ($srcset as $condition => $size) {
			if (!in_array($size, $cryption_sizes)) {
				continue;
			}
			$im = cryption_generate_thumbnail_src($attachment_id, $size);
			$result[$condition] = esc_url($im[0]);
		}
		return $result;
	}
}
