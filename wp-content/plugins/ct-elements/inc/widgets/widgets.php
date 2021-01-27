<?php
function ct_widgets_init() {
	if (!is_blog_installed())
		return;
	$available_widgets = apply_filters('ct_available_widgets', array(
		'CT_Widget_Picturebox',
		'CT_Widget_Tweets',
		'CT_Widget_Popular_Posts',
		'CT_Widget_Testimonial',
		'CT_Widget_news',
		'CT_Widget_Teams',
		'CT_Widget_Recent_Posts',
		'CT_Widget_Flickr',
		'CT_Widget_Submenu',
		'CT_Widget_Facebook',
		'CT_Widget_ProjectInfo',
		'CT_Widget_Contats',
		'CT_Widget_Gallery',
		'CT_Widget_Clients',
		'CT_Socials',
		'CT_Project_Slider'
	));
	foreach($available_widgets as $available_widget) {
		register_widget($available_widget);
	}
}
add_action('widgets_init', 'ct_widgets_init');

	class CT_Project_Slider extends WP_Widget
	{
		function __construct()
		{
			$widget_ops = array('Project_Slider' => 'widget_project_slider', 'description' => __('Project Slider', 'ct'));
			parent::__construct('project_slider', __('Project Slider', 'ct'), $widget_ops);
		}
		function widget($args, $instance)
		{
			$widget_data = array_merge(array(
				'ct_portfolios' => '',
				'title' => '',
				'rows' => '',
				'pf_link' => ''
			), $instance);

			extract($args);
			wp_enqueue_script('ct-portfolio-grid-carousel', get_template_directory_uri() . '/js/portfolio-grid-carousel.js', array(), false, true);
			echo $before_widget;
			if (!empty($widget_data['title'])) {
				echo $before_title . $widget_data['title'] . $after_title;
			}
			$params = array("ct_portfolios" =>  $widget_data['ct_portfolios'], "pf_link" =>   $widget_data['pf_link'],  "rows" =>   $widget_data['rows'] );
			if($args['id'] !== 'footer-widget-area') {
				echo '<div class="preloader"><div class="preloader-spin"></div></div>';
			}
			echo '<div class="widget-portfolio-carousel-grid'.($args['id'] === 'footer-widget-area' ? ' carousel-disabled' : '').'">';
			echo '<div class="widget-portfolio-carousel-slide">';
			echo '<div class="clearfix">';
			ct_widget_pf($params);
			echo '</div></div></div>';
			wp_reset_postdata();
			echo $after_widget;
		}

		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = $new_instance['title'];
			$instance['rows'] = $new_instance['rows'];
			$instance['ct_portfolios'] = $new_instance['ct_portfolios'];
			$instance['pf_link'] = $new_instance['pf_link'];
			return $instance;
		}

		function form($instance) {
			$instance = wp_parse_args((array)$instance, array('title' => '', 'rows' => '2', 'pf_link' => '',  'ct_portfolios' => array()  ));
			$title = strip_tags($instance['title']);
			$rows = strip_tags($instance['rows']);
			$pf_link = array('0' => __('Self Link', 'ct'), '1' => __('Image', 'ct'));
			$portfolios = array();
			if(taxonomy_exists('ct_portfolios')) {
				$portfolios_terms = get_terms('ct_portfolios', array('hide_empty' => false));
				foreach($portfolios_terms as $term) {
					$portfolios[$term->slug] = $term->name;
				}
			}
			?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ct'); ?>: <input
						class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
						name="<?php echo $this->get_field_name('title'); ?>" type="text"
						value="<?php echo esc_attr($title); ?>"/></label></p>
			<p><label for="portfolio_select"><?php _e('Select Portfolios', 'ct') ?>:</label><br />
			<?php ct_print_checkboxes($portfolios, $instance['ct_portfolios'], $this->get_field_name('ct_portfolios').'[]', $this->get_field_id('ct_portfolios'), '<br/>'); ?></p>

			<label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Link', 'ct'); ?>:</label><br/>
			<?php ct_print_select_input($pf_link, $instance['pf_link'], $this->get_field_name('pf_link'), $this->get_field_id('pf_link')) ?>
			<br/>
			<p><label for="<?php echo $this->get_field_id('rows'); ?>"><?php _e('Rows', 'ct'); ?>: <input
						class="widefat" id="<?php echo $this->get_field_id('rows'); ?>"
						name="<?php echo $this->get_field_name('rows'); ?>" type="text"
						value="<?php echo esc_attr($rows); ?>"/></label></p>
		<?php
		}
	}



	function ct_widget_pf($params) {
		wp_enqueue_script('ct-widgets');
		$params = array_merge(array('pf_link' => '', 'ct_portfolios' => '','rows' => '2', 'cols' => '3',), $params);
		$args = array(
			'post_type' => 'ct_pf_item',
			'post_status' => 'publish',
			'orderby' => 'menu_order ID',
			'order' => 'DESC',
			'posts_per_page' => -1,
			'tax_query' =>$params['ct_portfolios'] ? array(
				array(
					'taxonomy' => 'ct_portfolios',
					'field' => 'slug',
					'terms' =>  $params['ct_portfolios']
				)
			) : array(),
		);

		$loop = new WP_Query($args);
		global $post;
		$portfolio_posttemp = $post;
		$rows = ((int)$params['rows']) ? (int)$params['rows'] : 3;
		$cols = ((int)$params['cols']) ? (int)$params['cols'] : 3;
		$items_per_slide = $rows * $cols;
		$i = 0;
		while ($loop->have_posts()) : $loop->the_post();
			$small_image_url = ct_generate_thumbnail_src(get_post_thumbnail_id(), 'ct-widget-column-1x');
			$small_image_url_2x = ct_generate_thumbnail_src(get_post_thumbnail_id(), 'ct-widget-column-2x');
			$large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
			if ($params['pf_link'] == 1) {
				$portfolio_link = $large_image_url[0];
			}
			if ($params['pf_link'] == 0) {
				$portfolio_link = get_permalink($post->ID);
			}
			if($i == $items_per_slide) {
				echo '</div></div><div class="widget-portfolio-carousel-slide"><div class="clearfix">';
				$i = 0;
			}
			$fancy = 0;
			if (($params['pf_link']) == 1) {
				$fancy = 1;
			}

			$image =  esc_attr($small_image_url[0]);

			?>
			<a style="width: 80px" class="widget-ct-portfolio-item <?php  if (!$image) {echo "ct-portfolio-dummy";}?> <?php if ($fancy == 1):  ?> fancy<?php endif; ?>" href="<?php echo  $portfolio_link ?>" target="_self">
				<span class="widget-ct-portfolio-item-hover"></span>
				<img src="<?php echo esc_attr($small_image_url[0]);?>" srcset="<?php echo esc_attr($small_image_url_2x[0]);?> 2x" width="<?php echo esc_attr($small_image_url[1]); ?>" height="<?php echo esc_attr($small_image_url[2]); ?>" alt="<?php the_title(); ?>" />

			</a>
			<?php
			$i++;
		endwhile;
		$post = $portfolio_posttemp; wp_reset_postdata();
	}






	class CT_Socials extends WP_Widget {
		function __construct() {
			$widget_ops = array('socials' => 'widget_socials', 'description' => __('Socials', 'ct'));
			parent::__construct('socials', __('Socials', 'ct'), $widget_ops);
		}

		function widget($args, $instance) {

			extract($args);
			$widget_data = array_merge(array(
				'title' => '',
				'add_border_radius' => '',
			), $instance);
			echo $before_widget;
			if (!empty($widget_data['title'])) {
				echo $before_title . $widget_data['title'] . $after_title;
			}
			$socials_icons = array('twitter' => ct_get_option('twitter_active'), 'facebook' => ct_get_option('facebook_active'), 'linkedin' => ct_get_option('linkedin_active'), 'googleplus' => ct_get_option('googleplus_active'), 'stumbleupon' => ct_get_option('stumbleupon_active'), 'rss' => ct_get_option('rss_active'), 'vimeo' => ct_get_option('vimeo_active'), 'instagram' => ct_get_option('instagram_active'), 'pinterest' => ct_get_option('pinterest_active'), 'youtube' => ct_get_option('youtube_active'), 'flickr' => ct_get_option('flickr_active'));
			if (in_array(1, $socials_icons)) : ?>
				<div class="socials inline-inside socials-colored">
					<?php foreach ($socials_icons as $name => $active) : ?>
						<?php if($active) : ?>
						<a href="<?php echo esc_url(ct_get_option($name . '_link')); ?>" target="_blank"
						   title="<?php echo esc_attr($name); ?>" class="socials-item"><i
								class="socials-item-icon <?php  if ($widget_data['add_border_radius']) {echo "social-item-rounded";}?> <?php echo esc_attr($name); ?>"></i></a>
						<?php endif; ?>
					<?php endforeach; ?>
					<?php do_action('ct_footer_socials'); ?>
				</div>
			<?php endif; ?>
			<?php
			echo $after_widget;
		}

		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['add_border_radius'] = strip_tags($new_instance['add_border_radius']);
			$instance['title'] = strip_tags($new_instance['title']);
			return $instance;
		}

		function form($instance) {
			$instance = wp_parse_args((array)$instance, array('title' => '', 'add_border_radius' => ''));
			$title = strip_tags($instance['title']);
			$add_border_radius = (bool) $instance['add_border_radius'];
			?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ct'); ?>: <input
						class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
						name="<?php echo $this->get_field_name('title'); ?>" type="text"
						value="<?php echo esc_attr($title); ?>"/></label></p>
			<p>
				<input type="checkbox" name="<?php echo $this->get_field_name('add_border_radius'); ?>" id="<?php echo $this->get_field_id('add_border_radius'); ?>" value="1" <?php checked($add_border_radius, 1); ?> />
				<label for="<?php echo $this->get_field_id('add_border_radius'); ?>"><?php _e('Rounded icons', 'ct'); ?></label>
			</p>
		<?php
		}
	}
/* CT_Widget_Picturebox */




class CT_Widget_Picturebox extends WP_Widget {

	function __construct() {
		$widget_ops = array('Picturebox' => 'widget_picturebox', 'description' => __('Picturebox', 'ct'));
		parent::__construct('Picturebox', __('Picturebox', 'ct'), $widget_ops);
	}


	function widget($args, $instance) {
		$widget_data = array_merge(array(
			'image' => '',
			'title' => '',
			'text' => '',
			'link' => ''
		), $instance);

		extract($args);
		echo $before_widget;

		if($widget_data['title']) {
			echo $before_title . $widget_data['title'] . $after_title;
		}

		if($widget_data['image']) {
			?>
			<div class="ct-picturebox">
				<div class="ct-picturebox-image">
					<a  class="picture-box-link <?php  if (!$widget_data['link']) {echo "fancy";}?>" href="<?php echo $widget_data['link'] ? esc_url($widget_data['link']) : esc_url($widget_data['image']); ?>">
						<img class="img-responsive" src="<?php echo esc_url($widget_data['image']); ?>" alt="<?php echo esc_attr($widget_data['title']); ?>" />
					</a>
				</div>
				<?php if($widget_data['text']) : ?>
				<div class="ct-picturebox-text"><p><?php echo nl2br($widget_data['text']); ?></p></div>
				<?php endif; ?>
			</div>
			<?php
		}

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['image'] = strip_tags($new_instance['image']);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = $new_instance['text'];
		$instance['link'] = strip_tags($new_instance['link']);
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args((array)$instance, array('image' => '', 'title' => '', 'text' => '', 'link' => ''));
		$image = esc_url($instance['image']);
		$title = strip_tags($instance['title']);
		$text = $instance['text'];
		$link = esc_url($instance['link']);
		?>

		<p><label for="<?php echo $this->get_field_id('image'); ?>"><?php _e('Image link', 'ct'); ?>: <input
					class="widefat picture-select" id="<?php echo $this->get_field_id('image'); ?>"
					name="<?php echo $this->get_field_name('image'); ?>" type="text"
					value="<?php echo esc_attr($image); ?>"/></label></p>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ct'); ?>: <input
					class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
					name="<?php echo $this->get_field_name('title'); ?>" type="text"
					value="<?php echo esc_attr($title); ?>"/></label></p>
		<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Description', 'ct'); ?>: <textarea
					class="widefat" id="<?php echo $this->get_field_id('text'); ?>"
					name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_attr($text); ?></textarea></label></p>
		<p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link', 'ct'); ?>: <input
					class="widefat" id="<?php echo $this->get_field_id('link'); ?>"
					name="<?php echo $this->get_field_name('link'); ?>" type="text"
					value="<?php echo esc_attr($link); ?>"/></label></p>

	<?php

	}
}


/* POPULAR POSTS */

class CT_Widget_Popular_Posts extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'Custom_Popular_Posts', 'description' => __('The popular posts with thumbnails', 'ct'));
		parent::__construct('Custom_Popular_Posts', __('Custom Popular Posts', 'ct'), $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$widget_data = array_merge(array(
			'items' => '',
			'title' => '',
		), $instance);
		if (!is_numeric($widget_data['items'])) {
			$widget_data['items'] = 3;
		}
		if (empty($widget_data['title'])) {
			$widget_data['title'] = __('Popular Posts', 'CT');
		}
		if (!empty($widget_data['items'])) {
			echo $before_title . $widget_data['title'] . $after_title;
			pp_posts('popular', $widget_data['items'], TRUE);
		}
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['items'] = strip_tags($new_instance['items']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args((array)$instance, array('title' => '', 'items' => ''));
		$title = strip_tags($instance['title']);
		$items = strip_tags($instance['items']);

		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'CT'); ?>: <input
					class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
					name="<?php echo $this->get_field_name('title'); ?>" type="text"
					value="<?php echo esc_attr($title); ?>"/></label></p>
		<p><label for="<?php echo $this->get_field_id('items'); ?>"><?php _e('Items (default 3)', 'CT'); ?>: <input
					class="widefat" id="<?php echo $this->get_field_id('items'); ?>"
					name="<?php echo $this->get_field_name('items'); ?>" type="text"
					value="<?php echo esc_attr($items); ?>"/></label></p>

	<?php
	}
}

function pp_posts($sort = 'recent', $items = 3, $echo = TRUE, $categories = array()) {
	$return_html = '';
	if ($sort == 'recent') {
		$category = '';
		if (!in_array(0, $categories))
			$category = '&category='.implode(',', $categories);
		$posts = get_posts('numberposts=' . $items . '&order=DESC&orderby=date&post_type=post&post_status=publish'.$category);
	} else {
		global $wpdb;
		$query = "SELECT ID, post_title, post_content, post_date FROM {$wpdb->prefix}posts WHERE post_type = 'post' AND post_status= 'publish' ORDER BY comment_count DESC LIMIT 0, %d";
		$posts = $wpdb->get_results($wpdb->prepare($query, $items));
	}
	if (!empty($posts)) {
		$return_html .= '<ul class="posts  styled">';
		foreach ($posts as $post) {
			$image_thumb = '';
			if (has_post_thumbnail($post->ID, 'ct-post-thumb')) {
				$image_id = get_post_thumbnail_id($post->ID);
				$image_thumb = wp_get_attachment_image_src($image_id, 'ct-post-thumb', true);
			}
			$return_html .= '<li class="clearfix ct-pp-posts">';
			if (!empty($image_thumb)) {
				$return_html .= '<div class="ct-pp-posts-image"><a href="' . get_permalink($post->ID) . '"><img src="' . $image_thumb[0] . '" alt=""/></a></div>';
			} else {
				$return_html .= '<div class="ct-pp-posts-image"><a href="' . get_permalink($post->ID) . '"><span class="ct-dummy"></span></a></div>';
			}
			$return_html .= '<div class="ct-pp-posts-text"> <div class="ct-pp-posts-item"><a href="' . get_permalink($post->ID) . '">' . $post->post_title . '</a></div>';
			$return_html .= '<div class="ct-pp-posts-date">' . apply_filters('get_the_date', mysql2date(get_option('date_format'), $post->post_date), '') . '</div></div></li>';
		}
		$return_html .= '</ul>';
	}
	if ($echo) {
		echo $return_html;
	} else {
		return $return_html;
	}
}


/* CT_Widget_Recent_Posts */

class CT_Widget_Recent_Posts extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'Custom_Recent_Posts', 'description' => __('The recent posts with thumbnails', 'ct'));
		parent::__construct('Custom_Recent_Posts', __('Custom Recent Posts', 'ct'), $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$widget_data = array_merge(array(
			'items' => '',
			'title' => '',
			'categories' => array()
		), $instance);

		if (!is_numeric($widget_data['items'])) {
			$widget_data['items'] = 3;
		}

		if (empty($widget_data['title'])) {
			$widget_data['title'] = __('Recent Posts', 'CT');
		}
		if (!$widget_data['categories'])
			$widget_data['categories'] = array();
		if (!empty($widget_data['items'])) {
			echo $before_title . $widget_data['title'] . $after_title;
			pp_posts('recent', $widget_data['items'], TRUE, $widget_data['categories']);
		}
		echo $after_widget;

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['items'] = strip_tags($new_instance['items']);
		$instance['categories'] = $new_instance['categories'];

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args((array)$instance, array('title' => '', 'items' => '', 'categories' => array() ));
		$title = strip_tags($instance['title']);
		$items = strip_tags($instance['items']);

		$category_terms = get_categories(array('hide_empty' => false));
		$categories = array('0' => __('All Items', 'ct'));
		foreach($category_terms as $term) {
			$categories[$term->term_id] = $term->name;
		}
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ct'); ?>: <input
					class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
					name="<?php echo $this->get_field_name('title'); ?>" type="text"
					value="<?php echo esc_attr($title); ?>"/></label></p>
		<p><label for="<?php echo $this->get_field_id('items'); ?>"><?php _e('Items (default 3)', 'ct'); ?>: <input
					class="widefat" id="<?php echo $this->get_field_id('items'); ?>"
					name="<?php echo $this->get_field_name('items'); ?>" type="text"
					value="<?php echo esc_attr($items); ?>"/></label></p>
		<p><label><?php _e('Select Categories', 'ct') ?>:</label><br />

		<?php ct_print_checkboxes($categories, $instance['categories'], $this->get_field_name('categories').'[]', $this->get_field_id('categories'), '<br/>'); ?></p>
	<?php
	}
}


/* CT_Widget_Tweets */

class CT_Widget_Tweets extends WP_Widget {
	function __construct() {
		$widget_ops = array('Tweets' => 'widget_Tweets', 'description' => __('Tweets', 'ct'));
		parent::__construct('Tweets', __('Tweets', 'ct'), $widget_ops);
	}

	function widget($args, $instance) {
		extract($args);
		$widget_data = array_merge(array(
			'title' => '',
			'consumer_key' => '',
			'consumer_secret' => '',
			'access_token' => '',
			'access_token_secret' => '',
			'twitter_id' => '',
			'count' => '',
		), $instance);
		echo $before_widget;
		if ($widget_data['title']) {
			echo $before_title . $widget_data['title'] . $after_title;
		}
		if ($widget_data['twitter_id'] && $widget_data['consumer_key'] && $widget_data['consumer_secret'] && $widget_data['access_token'] && $widget_data['access_token_secret'] && $widget_data['count']) {
			$transName = 'list_tweets_' . $args['widget_id'];
			$cacheTime = 10;
			delete_transient($transName);
			if (false === ($twitterData = get_transient($transName))) {
				// require the twitter auth class
				require_once (plugin_dir_path( __FILE__ ) . '../twitteroauth/twitteroauth.php');
				$twitterConnection = new TwitterOAuth(
					$widget_data['consumer_key'], // Consumer Key
					$widget_data['consumer_secret'], // Consumer secret
					$widget_data['access_token'], // Access token
					$widget_data['access_token_secret'] // Access token secret
				);
				$twitterData = $twitterConnection->get(
					'statuses/user_timeline',
					array(
						'screen_name' => $widget_data['twitter_id'],
						'count' => $widget_data['count'],
						'exclude_replies' => false
					)
				);
				if ($twitterConnection->http_code != 200) {
					$twitterData = get_transient($transName);
				}
				// Save our new transient.
				set_transient($transName, $twitterData, 60 * $cacheTime);
			};
			$twitter = get_transient($transName);
			if ($twitter && is_array($twitter)) {
				?>
				<div class="twitter-box">
					<div class="twitter-holder">
						<div class="b">
							<div class="tweets-container" id="tweets_<?php echo $args['widget_id']; ?>">
								<ul id="jtwt" class="styled">
									<?php foreach ($twitter as $tweet): ?>
									<?php
									$twitterTime = strtotime($tweet->created_at);
									$timeAgo = $this->ago($twitterTime);
									?>
										<li class="jtwt_tweet"><div class="jtwt_date"><?php echo $timeAgo; ?></div>
											<p class="jtwt_tweet_text icon-twitter">
												<?php
												$latestTweet = $tweet->text;
												$latestTweet = preg_replace('/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '&nbsp;<a href="http://$1" target="_blank">http://$1</a>&nbsp;', $latestTweet);
												$latestTweet = preg_replace('/@([a-z0-9_]+)/i', '&nbsp;<a href="http://twitter.com/$1" target="_blank">@$1</a>&nbsp;', $latestTweet);
												echo $latestTweet;
												?>
											</p>



										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					</div>
					<span class="arrow"></span>
				</div>
			<?php
			}
		}
		echo $after_widget;
	}

	function ago($time) {
		$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths = array("60", "60", "24", "7", "4.35", "12", "10");
		$now = time();
		$difference = $now - $time;
		$tense = "ago";
		for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
			$difference /= $lengths[$j];
		}
		$difference = round($difference);

		if ($difference != 1) {
			$periods[$j] .= "s";
		}
		return "$difference $periods[$j] ago ";
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['consumer_key'] = $new_instance['consumer_key'];
		$instance['consumer_secret'] = $new_instance['consumer_secret'];
		$instance['access_token'] = $new_instance['access_token'];
		$instance['access_token_secret'] = $new_instance['access_token_secret'];
		$instance['twitter_id'] = $new_instance['twitter_id'];
		$instance['count'] = $new_instance['count'];
		return $instance;
	}

	function form($instance) {
		$defaults = array(
			'title' => 'Recent Tweets',
			'twitter_id' => '',
			'count' => 3,
			'consumer_key' => '',
			'consumer_secret' => '',
			'access_token' => '',
			'access_token_secret' => ''
		);
		$instance = wp_parse_args((array)$instance, $defaults); ?>
		<p><?php printf(__('<a href="%s">Find or Create your Twitter App</a>', 'CT'), 'http://dev.twitter.com/apps'); ?></p>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
				   name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('consumer_key'); ?>">Consumer Key:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('consumer_key'); ?>"
				   name="<?php echo $this->get_field_name('consumer_key'); ?>"
				   value="<?php echo $instance['consumer_key']; ?>"/>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('consumer_secret'); ?>">Consumer Secret:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('consumer_secret'); ?>"
				   name="<?php echo $this->get_field_name('consumer_secret'); ?>"
				   value="<?php echo $instance['consumer_secret']; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('access_token'); ?>">Access Token:</label>
			<input class="widefat"" id="<?php echo $this->get_field_id('access_token'); ?>"
			name="<?php echo $this->get_field_name('access_token'); ?>"
			value="<?php echo $instance['access_token']; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('access_token_secret'); ?>">Access Token Secret:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('access_token_secret'); ?>"
				   name="<?php echo $this->get_field_name('access_token_secret'); ?>"
				   value="<?php echo $instance['access_token_secret']; ?>"/>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('twitter_id'); ?>">Twitter ID:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('twitter_id'); ?>"
				   name="<?php echo $this->get_field_name('twitter_id'); ?>"
				   value="<?php echo $instance['twitter_id']; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('count'); ?>">Number of Tweets:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>"
				   name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $instance['count']; ?>"/>
		</p>

	<?php
	}
}


/* Testimonials */

class CT_Widget_Testimonial extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'ct-widget-testimonial', 'description' => __('List of testimonials', 'ct'));
		parent::__construct('ct_testimonials', __('Testimonial', 'ct'), $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		echo $before_widget;
		$widget_data = array_merge(array(
			'title' => '',
			'testimonials_set' => '',
			'autoscroll_testimonials' => $autoscroll_testimonials = isset($instance['autoscroll_testimonials']) ? $instance['autoscroll_testimonials'] : 5000,
			'effects_enabled' => false
		), $instance);
		$params = array("testimonials_set" => $widget_data['testimonials_set'], "autoscroll_testimonials" => $widget_data['autoscroll_testimonials'], "effects_enabled" => $widget_data['effects_enabled']);
		if (!empty($widget_data['title'])) {
            echo ($params['effects_enabled'] ? '<div class="lazy-loading" data-ll-item-delay="0"><div class="lazy-loading-item" data-ll-effect="drop-top" data-ll-step="0.5">' : '').$before_title . $widget_data['title']. $after_title.($params['effects_enabled'] ? '</div></div>' : '');
		}
		echo $params['effects_enabled'] ? '<div class="lazy-loading" data-ll-item-delay="0"><div class="lazy-loading-item" data-ll-effect="drop-right-unwrap" data-ll-offset="0.5" data-ll-item-delay="400">' : '';
		ct_testimonials($params);
		echo $params['effects_enabled'] ? '</div></div>' : '';
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['testimonials_set'] = $new_instance['testimonials_set'];
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['autoscroll_testimonials'] = strip_tags($new_instance['autoscroll_testimonials']);
		$instance['effects_enabled'] = (bool) $new_instance['effects_enabled'];
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args((array)$instance, array('style' => '', 'testimonials_set' => '', 'title' => '', 'autoscroll_testimonials' => '', 'effects_enabled' => false));
		$testimonials_sets = array('' => __('All Testimonials', 'ct'));
		$testimonials_sets_terms = get_terms('ct_testimonials_sets', array('hide_empty' => false));
		$title = strip_tags($instance['title']);
		$autoscroll_testimonials = strip_tags($instance['autoscroll_testimonials']);
		foreach ($testimonials_sets_terms as $term) {
			$testimonials_sets[$term->slug] = $term->name;
		}
		$effects_enabled = (bool) $instance['effects_enabled'];
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ct'); ?>: <input
					class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
					name="<?php echo $this->get_field_name('title'); ?>" type="text"
					value="<?php echo esc_attr($title); ?>"/></label></p>

		<p><label for="<?php echo $this->get_field_id('autoscroll_testimonials'); ?>"><?php _e('Autoscroll Speed', 'ct'); ?>: <input
					class="widefat" id="<?php echo $this->get_field_id('autoscroll_testimonials'); ?>"
					name="<?php echo $this->get_field_name('autoscroll_testimonials'); ?>" type="text"
					value="<?php echo esc_attr($autoscroll_testimonials); ?>"/></label></p>

		<label for="<?php echo $this->get_field_id('testimonials_set'); ?>"><?php _e('Testimonials Set', 'ct'); ?>:</label><br/>
		<?php ct_print_select_input($testimonials_sets, $instance['testimonials_set'], $this->get_field_name('testimonials_set'), $this->get_field_id('testimonials_set')) ?>
		<br/>
		</p>

		<p>
			<input type="checkbox" name="<?php echo $this->get_field_name('effects_enabled'); ?>" id="<?php echo $this->get_field_id('effects_enabled'); ?>" value="1" <?php checked($effects_enabled, 1); ?> />
			<label for="<?php echo $this->get_field_id('effects_enabled'); ?>"><?php _e('Lazy loading enabled', 'ct'); ?></label>
		</p>
	<?php
	}
}

function ct_testimonials($params) {
	wp_enqueue_script('ct-widgets');
	$params = array_merge(array('style' => '', 'testimonials_set' => '',  'autoscroll_testimonials' => '', 'effects_enabled' => false), $params);
	$args = array(
		'post_type' => 'ct_testimonial',
		'orderby' => 'menu_order ID',
		'order' => 'DESC'
	);
	if ($params['testimonials_set'] != '') {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'ct_testimonials_sets',
				'field' => 'slug',
				'terms' => $params['testimonials_set']
			)
		);
	}
	$testimonials = new WP_Query($args);
	if ($testimonials->have_posts()) {
		if ($params['style'] == 0) {
			echo '<div class="widget-testimonials testimonials-style-1-block "><div  data-autoscroll="'.$params['autoscroll_testimonials'].'" class="testimonials-carousel-style-1 testimonials-style-1">';
			$link_start = '';
			$link_end = '';
			while ($testimonials->have_posts()) {
				$testimonials->the_post();
				$item_data = ct_get_sanitize_testimonial_data(get_the_ID());
				$image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'ct-post-thumb');
				if($item_data['link']) {
					$link_start = '<a href="'.$item_data['link'].'" target="'.$item_data['link_target'].'">';
					$link_end = '</a>';
				}
				include(locate_template(array('ct-templates/testimonials/content-testimonial-widget.php')));

			}
			echo '</div></div>';
		}
		if ($params['style'] == 1) {
			echo '<div class="testimonials testimonials-style-2"><div class="testimonials-style-2"><div data-autoscroll="'.$params['autoscroll_testimonials'].'"  class="testimonials-carousel-style-2" >';
			$link_start = '';
			$link_end = '';
			while ($testimonials->have_posts()) {
				$testimonials->the_post();
				$item_data = ct_get_sanitize_testimonial_data(get_the_ID());
				$image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'ct-post-thumb');
				if($item_data['link']) {
					$link_start = '<a href="'.$item_data['link'].'" target="'.$item_data['link_target'].'">';
					$link_end = '</a>';
				}
				?>
				<div class="testimonials-style-2-item">
					<div class="testimonials-style-2-text ct-testimonial-text"> <?php the_content(); ?>
						<div class="testimonials-style-2-teg">&#xe60c;</div>
					</div>


					<div class="testimonials-style-2-bg">
					<svg class="wrap-style">
					<use xlink:href="<?php echo get_template_directory_uri() . '/css/post-arrow.svg' ?>#dec-post-arrow" /></use>
					</svg>
						<div class="testimonials-style-2-image"> <?php echo $link_start ?> <?php if($params['effects_enabled']): ?><span class="lazy-loading-item" style="display: block;" data-ll-item-delay="0" data-ll-effect="clip"><?php endif; ?> <span> <?php ct_post_thumbnail('ct-post-thumb');?> </span> <?php if($params['effects_enabled']): ?></span><?php endif; ?> <?php echo $link_end;?> </div>
							<div class="testimonials-style-2-name ct-testimonial-name">
							 	<?php  echo ($item_data['name']); ?>
 							</div>
						<div class="testimonials-style-2-post ct-testimonial-position small-body"><?php echo $item_data['position']  ?></div>
						<div class="testimonials-style-2-post ct-testimonial-position small-body"><?php echo $item_data['company'] ?></div>
					</div>
				</div>
				<?php
			}
			echo '</div></div></div>';
		}
	}

	wp_reset_postdata();
}


/* news */

class CT_Widget_news extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'ct_news', 'description' => __('ct news', 'ct'));
		parent::__construct('ct_news_list', __('News', 'ct'), $widget_ops);
	}

	function widget($args, $instance) {
		extract($args);
		echo $before_widget;
		$widget_data = array_merge(array(
			'title' => '',
			'count' => '',
			'news_set' => ''
		), $instance);
		$params = array("count" => $widget_data['count'], "news_set" => $widget_data['news_set'] );
		if (intval ($params['count']) == 0) {
			$params['count'] = 3;
		}
		if (!empty($widget_data['title'])) {
			echo $before_title . $widget_data['title'] . $after_title;
		}
		ct_news_list($params);
		echo $after_widget;
	}
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['news_set'] = $new_instance['news_set'];
		$instance['count'] = $new_instance['count'];
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	function form($instance)
	{
		$instance = wp_parse_args((array)$instance, array('count' => '', 'news_set' => '', 'title' => ''));
		$count = strip_tags($instance['count']);
		$news_sets = array('' => __('All News', 'ct'));
		$news_sets_terms = get_terms('ct_news_sets', array('hide_empty' => false));
		$title = strip_tags($instance['title']);
		foreach ($news_sets_terms as $term) {
			$news_sets[$term->slug] = $term->name;
		}
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ct'); ?>: <input
					class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
					name="<?php echo $this->get_field_name('title'); ?>" type="text"
					value="<?php echo esc_attr($title); ?>"/></label></p>
		<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Count', 'ct'); ?>: <input
					class="widefat" id="<?php echo $this->get_field_id('count'); ?>"
					name="<?php echo $this->get_field_name('count'); ?>" type="text"
					value="<?php echo esc_attr($count); ?>"/></label></p>
		<label
			for="<?php echo $this->get_field_id('news_set'); ?>"><?php _e('News sets ', 'ct'); ?>
			:</label><br/>
		<?php ct_print_select_input($news_sets, $instance['news_set'], $this->get_field_name('news_set'), $this->get_field_id('news_set')) ?>
		<br/>
	<?php
	}
}

function ct_news_list($params) {
	$params = array_merge(array('count' => '', 'news_set' => ''), $params);
	$args = array(
		'post_type' => 'ct_news',
		'posts_per_page' => $params['count'],
		'orderby' => 'menu_order ID',
		'order' => 'DESC'
	);
	if ($params['news_set'] != '') {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'ct_news_sets',
				'field' => 'slug',
				'terms' => $params['news_set']
			)
		);
	}
	$loop = new WP_Query($args);
	echo '<ul class="posts styled">';
	while ($loop->have_posts()) : $loop->the_post();
		?>
		<li class="ct-latest-news">
			<div class="ct-latest-news-image">
				<a href='<?php the_permalink() ?>'> <?php ct_post_thumbnail('ct-post-thumb', true, '') ?> </a>
			</div>
			<div class="ct-latest-news-title">
				<a href='<?php the_permalink() ?>'>  <?php the_title(); ?></a>
				<span> <?php echo get_the_date()?> </span>
			</div>
		</li>
		<?php
	endwhile;
	echo '</ul>';
	wp_reset_postdata();
}

/* Flickr */

class CT_Widget_Flickr extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'Custom_Flickr', 'description' => __('Display your recent Flickr photos', 'ct') );
		parent::__construct('Custom_Flickr', __('Flickr', 'ct'), $widget_ops);
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;

		$widget_data = array_merge(array(
			'flickr_id' => empty($instance['flickr_id']) ? ' ' : apply_filters('widget_title', $instance['flickr_id']),
			'title' => '',
			'items' => '',
		), $instance);
		if(!is_numeric($widget_data['items']))
		{
            $widget_data['items'] = 9;
		}
		if(empty($widget_data['title']))
		{
			$widget_data['title'] = __('Photostream', 'CT');
		}

		if(!empty($widget_data['items']) && !empty($widget_data['flickr_id']))
		{
			$photos_arr = get_flickr(array('type' => 'user', 'id' => $widget_data['flickr_id'], 'items' =>$widget_data['items'] ));

			if(!empty($photos_arr))
			{
				echo $before_title.$widget_data['title'].$after_title;
				echo '<div class="flickr clearfix">';
				$num = 0;
				foreach($photos_arr as $photo) {
					echo '<div class="flickr-item position-'.($num % 3).'">';
					echo '<a href="'.esc_url($photo['url']).'" title="'.esc_attr($photo['title']).'" class="fancy"><img src="'.esc_url($photo['thumb_url']).'" alt="" /></a>';
					echo '</div>';
					$num++;
				}
				echo '</div>';
			}
		}
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['items'] = strip_tags($new_instance['items']);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['flickr_id'] = strip_tags($new_instance['flickr_id']);
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'flickr_id' => '', 'title' => '') );
		$items = strip_tags($instance['items']);
		$flickr_id = strip_tags($instance['flickr_id']);
		$title = strip_tags($instance['title']);
		?>
		<p><label for="<?php echo $this->get_field_id('flickr_id'); ?>"><?php printf(__('Flickr ID <a href="%s">Find your Flickr ID here</a>', 'CT'), 'http://idgettr.com/'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" type="text" value="<?php echo esc_attr($flickr_id); ?>" /></label></p>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'CT'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

		<p><label for="<?php echo $this->get_field_id('items'); ?>"><?php _e('Items (default 9)', 'CT'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
	<?php
	}
}

function get_flickr($settings) {
	if (!function_exists('MagpieRSS')) {
		// Check if another plugin is using RSS, may not work
		include_once (ABSPATH . WPINC . '/class-simplepie.php');
	}

	if(!isset($settings['items']) || empty($settings['items']))
	{
		$settings['items'] = 9;
	}

	// get the feeds
	if ($settings['type'] == "user") { $rss_url = 'http://api.flickr.com/services/feeds/photos_public.gne?id=' . $settings['id'] . '&tags=' . (isset($settings['tags']) ? $settings['tags'] : ''). '&per_page='.$settings['items'].'&format=rss_200'; }
	elseif ($settings['type'] == "favorite") { $rss_url = 'http://api.flickr.com/services/feeds/photos_faves.gne?id=' . $settings['id'] . '&format=rss_200'; }
	elseif ($settings['type'] == "set") { $rss_url = 'http://api.flickr.com/services/feeds/photoset.gne?set=' . $settings['set'] . '&nsid=' . $settings['id'] . '&format=rss_200'; }
	elseif ($settings['type'] == "group") { $rss_url = 'http://api.flickr.com/services/feeds/groups_pool.gne?id=' . $settings['id'] . '&format=rss_200'; }
	elseif ($settings['type'] == "public" || $settings['type'] == "community") { $rss_url = 'http://api.flickr.com/services/feeds/photos_public.gne?tags=' . $settings['tags'] . '&format=rss_200'; }
	else {
		print '<strong>'.__('No "type" parameter has been setup. Check your settings, or provide the parameter as an argument.', 'CT').'</strong>';
		die();
	}
	# get rss file

	$feed = new SimplePie();
	$feed->set_feed_url($rss_url);
	$feed->set_cache_location(plugin_dir_path( __FILE__ ).'cache/');
	$feed->init();
	$feed->handle_content_type();

	$photos_arr = array();

	foreach ($feed->get_items() as $key => $item)
	{
		$enclosure = $item->get_enclosure();
		$img = image_from_description($item->get_description());
		$thumb_url = select_image($img, 0);
		$large_url = select_image($img, 4);

		$photos_arr[] = array(
			'title' => $enclosure->get_title(),
			'thumb_url' => $thumb_url,
			'url' => $large_url,
		);

		$current = intval($key+1);

		if($current == $settings['items'])
		{
			break;
		}
	}

	return $photos_arr;
}

function image_from_description($data) {
	preg_match_all('/<img src="([^"]*)"([^>]*)>/i', $data, $matches);
	return $matches[1][0];
}

function select_image($img, $size) {
	$img = explode('/', $img);
	$filename = array_pop($img);

	// The sizes listed here are the ones Flickr provides by default.  Pass the array index in the

	// 0 for square, 1 for thumb, 2 for small, etc.
	$s = array(
		'_s.', // square
		'_t.', // thumb
		'_m.', // small
		'.',   // medium
		'_b.'  // large
	);

	$img[] = preg_replace('/(_(s|t|m|b))?\./i', $s[$size], $filename);
	return implode('/', $img);
}


/*Submenu*/

class CT_Widget_Submenu extends WP_Widget {
	function __construct()
	{
		$widget_ops = array('classname' => 'widget_submenu', 'description' => __('Submenu', 'ct'));
		parent::__construct('Submenu', __('Submenu', 'ct'), $widget_ops);
	}

	function widget($args, $instance) {
		// Get menu
		$nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;
		extract($args);
		$title = $instance['title'];
		if ( !$nav_menu )
			return;
		echo $args['before_widget'];
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		}
		wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu, 'walker' => new Submenu_Walker_Nav_Menu, 'items_wrap' => '<ul class="styled">%3$s</ul>') );
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
		$title = strip_tags($instance['title']);
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
		if ( !$menus ) {
			echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.', 'CT'), admin_url('nav-menus.php') ) .'</p>';
			return;
		}
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ct'); ?>: <input
					class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
					name="<?php echo $this->get_field_name('title'); ?>" type="text"
					value="<?php echo esc_attr($title); ?>"/></label></p>
		<p>
			<label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu', 'CT'); ?>:</label>
			<select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
				<?php
				foreach ( $menus as $menu ) {
					echo '<option value="' . $menu->term_id . '"'
						. selected( $nav_menu, $menu->term_id, false )
						. '>'. $menu->name . '</option>';
				}
				?>
			</select>
		</p>
	<?php
	}
}

add_filter('wp_nav_menu_items', 'ct_wp_nav_menu_items_before', 9, 2);
function ct_wp_nav_menu_items_before($items, $args) {
	if(is_object($args->walker) && get_class($args->walker) == 'Submenu_Walker_Nav_Menu') {
		return $items.'@#@';
	}
	return $items;
}

add_filter('wp_nav_menu_items', 'ct_wp_nav_menu_items_after', 11, 2);
function ct_wp_nav_menu_items_after($items, $args) {
	if(is_object($args->walker) && get_class($args->walker) == 'Submenu_Walker_Nav_Menu') {
		return substr($items, 0, strpos($items, "@#@"));
	}
	return $items;
}

class Submenu_Walker_Nav_Menu extends Walker_Nav_Menu {

	var $current_tree_ids = array();

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ($depth == 0)
			return;

		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"styled\">\n";
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ($depth == 0)
			return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		if ($depth == 0 && ($item->current_item_ancestor || $item->current)) {
			$this->current_tree_ids[] = $item->ID;
		}

		if (!in_array($item->menu_item_parent, $this->current_tree_ids))
			return;

		$this->current_tree_ids[] = $item->ID;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		if($depth != 0) {
			$output .= $indent . '<li' . $id . $value . $class_names .'>';
		}

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		if($depth != 0) {
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if (!in_array($item->menu_item_parent, $this->current_tree_ids))
			return;

		$output .= "</li>\n";
	}
}


/* FACEBOOK */

class CT_Widget_Facebook extends WP_Widget {
	function __construct()
	{
		$widget_ops = array('classname' => 'Facebook', 'description' => __('Facebook', 'ct'));
		parent::__construct('Facebook', __('Facebook', 'ct'), $widget_ops);
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$fb_page_url = $instance['fb_page_url'];
		$title = $instance['title'];
		$widget_data = array_merge(array(
			'fb_page_url' => '',
			'title' => '',

		), $instance);
		if(!empty($fb_page_url)){
			echo $before_title;
			if($widget_data['title']) {
				echo $widget_data['title'];
			} else {
				echo __('Find us on Facebook', 'ct');
			}
			echo $after_title;
			?>
			<div class="rounded-corners shadow-box bordered-box"><iframe src="//www.facebook.com/plugins/likebox.php?href=<?php echo urlencode($widget_data['fb_page_url']); ?>&amp;width=240&amp;height=230&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;show_border=false&amp;header=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px; height:250px; margin:  -10px 0 -10px -10px; vertical-align: top;" allowTransparency="true"></iframe></div>
		<?php
		}

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['fb_page_url'] = strip_tags($new_instance['fb_page_url']);
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'fb_page_url' => '', 'title' => '') );
		$fb_page_url = strip_tags($instance['fb_page_url']);
		$title = strip_tags($instance['title']);

		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'CT'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('fb_page_url'); ?>"><?php _e('Facebook Page URL', 'CT'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('fb_page_url'); ?>" name="<?php echo $this->get_field_name('fb_page_url'); ?>" type="text" value="<?php echo esc_attr($fb_page_url); ?>" /></label></p>
	<?php
	}
}

function ct_widget_categories_args($cat_args) {
	$cat_args['walker'] = new CT_Walker_Category;
	return $cat_args;
}
add_filter('widget_categories_args', 'ct_widget_categories_args');

class CT_Walker_Category extends Walker_Category {

	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		extract($args);

		$cat_name = esc_attr( $category->name );

		/** This filter is documented in wp-includes/category-template.php */
		$cat_name = apply_filters( 'list_cats', $cat_name, $category );

		$link = '<a href="' . esc_url( get_term_link($category) ) . '" ';
		if ( $use_desc_for_title == 0 || empty($category->description) ) {
			$link .= 'title="' . esc_attr( sprintf(__( 'View all posts filed under %s', 'ct' ), $cat_name) ) . '"';
		} else {
			$link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
		}

		$link .= '>';
		$link .= $cat_name . '</a>';

		if ( !empty($feed_image) || !empty($feed) ) {
			$link .= ' ';

			if ( empty($feed_image) )
				$link .= '(';
			$link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $feed_type ) ) . '"';
			if ( empty($feed) ) {
				$alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s', 'ct' ), $cat_name ) . '"';
			} else {
				$title = ' title="' . $feed . '"';
				$alt = ' alt="' . $feed . '"';
				$name = $feed;
				$link .= $title;
			}

			$link .= '>';

			if ( empty($feed_image) )
				$link .= $name;
			else
				$link .= "<img src='$feed_image'$alt$title" . ' />';

			$link .= '</a>';

			if ( empty($feed_image) )
				$link .= ')';
		}

		if ( !empty($show_count) )
			$link .= ' (' . number_format_i18n( $category->count ) . ')';

		if ( 'list' == $args['style'] ) {
			$category_children_ids = array();
			foreach(get_categories(array('child_of' => $category->term_id)) as $category_child) {
				$category_children_ids[] = $category_child->term_id;
			}
			$output .= "\t<li";
			$class = 'cat-item cat-item-' . $category->term_id;
			if ( !empty($current_category) ) {
				$_current_category = get_term( $current_category, $category->taxonomy );
				if ( $category->term_id == $current_category )
					$class .=  ' current-cat';
				elseif ( $category->term_id == $_current_category->parent )
					$class .=  ' current-cat-parent';
				elseif(in_array($current_category, $category_children_ids)) {
					$class .=  ' current-cat-ancestor';
				}
				if($args['has_children']) {
					$class .=  ' cat-parent';
				}
			}
			$output .=  ' class="' . $class . '"';
			$output .= ">$link\n";
		} else {
			$output .= "\t$link<br />\n";
		}
	}

}

/*ProjectInfo*/

class CT_Widget_ProjectInfo extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'project_info', 'description' => __( 'Project Info / Contact Info / Custom Iconed Fields', 'ct') );
		parent::__construct('project_info', __('Project Info / Contact Info / Custom Iconed Fields', 'ct'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$widget_data = array_merge(array(
			'title' => apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base ),
			'fields' => '',
			'button_url' => '',
			'style' => '',
			'iconcolor' => 'iconcolor',
			'icon_pack' => '',
		), $instance);
		if(!($button_text = $instance['button_text'])) {
			$button_text = __('Project Preview', 'CT');
		}
		if ($widget_data['icon_pack'] == 'elegant') {
			wp_enqueue_style('icons-elegant');
		}
		if ($widget_data['icon_pack'] == 'material') {
			wp_enqueue_style('icons-material');
		}
		if ($widget_data['icon_pack'] == 'fontawesome') {
			wp_enqueue_style('icons-fontawesome');
		}
		if ($widget_data['icon_pack'] == 'userpack') {
			wp_enqueue_style('icons-userpack');
		}
		echo $before_widget;
		if ( $widget_data['title'] )
			echo $before_title. $widget_data['title'] .$after_title;
		if ($widget_data['style'] == 0) {
			echo '<div class="project_info-item-style-1">';
		}
		if ($widget_data['style'] == 1) {
			echo '<div class="project_info-item-style-2">';
		}
		foreach($widget_data['fields'] as $field) : ?>
			<?php if($field['title']) : ?>

				<div class="project_info-item<?php if($field['icon']) echo ' iconed'; ?><?php if($widget_data['style'] == 0); ?>">
					<div class="title">
						<?php if($field['icon']) : ?><span style="color:<?php echo $field['iconcolor'];?>; background-color:<?php echo $field['iconcolor'];?>" class="icon icon-<?php echo $widget_data['icon_pack']?>";>&#x<?php echo $field['icon']; ?>;</span><?php endif; ?>
						<span class="project_info-item-title"> <?php  echo $field['title']; ?> </span>
					</div>
					<div class="value"><?php echo $field['value']; ?></div>
				</div>
			<?php endif; ?>
		<?php endforeach;
		echo '</div>'
		?>
		<?php if($widget_data['button_url']) : ?>
			<div class="project-info-button">
			<a class="ct-button ct-button-size-tiny ct-button-style-outline ct-button-text-weight-normal ct-button-border-2"  target="_self" href="<?php echo $widget_data['button_url'] ?>"><?php echo $button_text; ?></h6></a>
			</div>
		<?php endif; ?>

		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args((array) $new_instance, array( 'title' => '', 'fields' => array(), 'button_url' => '', 'button_text' => '',  'icon_pack' => ''));
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['fields'] = $new_instance['fields'];
		$instance['button_url'] = $new_instance['button_url'];
		$instance['button_text'] = $new_instance['button_text'];
		$instance['style'] = $new_instance['style'];
		$instance['icon_pack'] = $new_instance['icon_pack'];

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'fields' => array(), 'button_url' => '', 'button_text' => '', 'style' => '', 'icon_pack' => ''  ) );
		$title = $instance['title'];

		$fields = $instance['fields'];
		$button_url = $instance['button_url'];
		$button_text = $instance['button_text'];
		$style = array('0' => __('Style 1', 'ct'), '1' => __('Style 2', 'ct'));
		$icon_pack = ct_icon_packs_select_array();
		add_thickbox();
		wp_enqueue_style('icons-elegant');
		wp_enqueue_style('icons-material');
		wp_enqueue_style('icons-fontawesome');
		wp_enqueue_style('icons-userpack');
		wp_enqueue_script('ct-icons-picker');
		?>



		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'CT'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<h3>Fields:</h3>
		<?php ct_print_select_input($style, $instance['style'], $this->get_field_name('style'), $this->get_field_id('style')) ?>
		</br></br>

		<span>Select icon pack</span></br>
		<?php ct_print_select_input($icon_pack, $instance['icon_pack'], $this->get_field_name('icon_pack'), $this->get_field_id('icon_pack')) ?>

		<?php for( $i=0; $i < 10; $i++ ) : ?>
			<h4>Field #<?php echo ($i+1); ?>:</h4>
			<p><label for="<?php echo $this->get_field_id('fields_' . $i . '_title'); ?>"><?php _e('Title', 'CT'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('fields_' . $i . '_title'); ?>" name="<?php echo $this->get_field_name('fields') . '[' . $i . '][title]'; ?>" type="text" value="<?php echo isset($fields[$i]) ? $fields[$i]['title'] : ''; ?>" /></label></p>

			<p><label for="<?php echo $this->get_field_id('fields_' . $i . '_value'); ?>"><?php _e('Value', 'CT'); ?>: <textarea class="widefat" rows="3" cols="20" id="<?php echo $this->get_field_id('fields_' . $i . '_value'); ?>" name="<?php echo $this->get_field_name('fields') . '[' . $i . '][value]'; ?>"><?php echo isset($fields[$i]) ? $fields[$i]['value'] : ''; ?></textarea></label></p>
			<p>
				<label for="<?php echo $this->get_field_id('fields_' . $i . '_iconcolor'); ?>"><?php _e('Icon Color', 'CT'); ?>: <input class="widefat iconcolor" id="<?php echo $this->get_field_id('fields_' . $i . '_iconcolor'); ?>" name="<?php echo $this->get_field_name('fields') . '[' . $i . '][iconcolor]'; ?>" type="text" value="<?php echo isset($fields[$i]) ? $fields[$i]['iconcolor'] : ''; ?>" /></label><br/>

				<label for="<?php echo $this->get_field_id('fields_' . $i . '_icon'); ?>"><?php _e('Icon', 'CT'); ?>:<br /><input class="widefat icon icons-picker" id="<?php echo $this->get_field_id('fields_' . $i . '_icon'); ?>" name="<?php echo $this->get_field_name('fields') . '[' . $i . '][icon]'; ?>" type="text" value="<?php echo isset($fields[$i]) ? $fields[$i]['icon'] : ''; ?>" /></label><br/>
			</p>
			<script type="text/javascript">
				(function($) {
					$(function() {
						jQuery('[id$=icon_pack]').change(function() {
							jQuery(this).closest('.widget-content').find('.icons-picker').data('iconpack', jQuery(this).val());
						}).trigger('change');
					});
				})(jQuery);
			</script>
		<?php endfor; ?>
		<script type="text/javascript">
			(function($) {
				$(function() {
					jQuery('.icons-picker').iconsPicker();
				});
			})(jQuery);
		</script>
		<p>&nbsp;</p>
		<p><label for="<?php echo $this->get_field_id('button_url'); ?>"><?php _e('Button URL', 'CT'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('button_url'); ?>" name="<?php echo $this->get_field_name('button_url'); ?>" type="text" value="<?php echo $button_url; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('button_text'); ?>"><?php _e('Button Text', 'CT'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('button_text'); ?>" name="<?php echo $this->get_field_name('button_text'); ?>" type="text" value="<?php echo $button_text; ?>" /></label></p>
	<?php
	}
}


class CT_Widget_Teams extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'Teams', 'description' => __('Teams', 'ct'));
		parent::__construct('Teams', __('Teams', 'ct'), $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$widget_data = array_merge(array(
			'teams' => '',
			'title' => '',
			'person_data_email' => '',
			'teams_animation_speed' => '',
			'effects_enabled' => false
		), $instance);
		if (!is_numeric($widget_data['teams_animation_speed'])) {
			$widget_data['teams_animation_speed'] = 5000;
		}
		$params = array("teams" => $widget_data['teams'], "teams_animation_speed" => $widget_data['teams_animation_speed'], "effects_enabled" => $widget_data['effects_enabled'], "person_data_email" => $widget_data['person_data_email']);
		if (!empty($widget_data['title'])) {
			echo ($params['effects_enabled'] ? '<div class="lazy-loading" data-ll-item-delay="0"><div class="lazy-loading-item" data-ll-effect="drop-top" data-ll-step="0.5">' : '').$before_title . $widget_data['title']. $after_title.($params['effects_enabled'] ? '</div></div>' : '');
		}
		echo $params['effects_enabled'] ? '<div class="lazy-loading" data-ll-item-delay="0"><div class="lazy-loading-item" data-ll-effect="drop-right-unwrap" data-ll-offset="0.5" data-ll-item-delay="400">' : '';
		ct_teams($params);


		echo $params['effects_enabled'] ? '</div></div>' : '';
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['teams'] = $new_instance['teams'];
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['teams_animation_speed'] = strip_tags($new_instance['teams_animation_speed']);
		$instance['effects_enabled'] = (bool) $new_instance['effects_enabled'];
        $instance['person_data_email'] = (bool)  $new_instance['person_data_email'];


        return $instance;
	}

	function form($instance) {

		$instance = wp_parse_args((array)$instance, array('teams' => '', 'title' => '', 'teams_animation_speed' => '', 'effects_enabled' => false, 'person_data_email' => ''));
		$team = $instance['teams'];
		$team_terms = get_terms('ct_teams', array('hide_empty' => false));
		$title = strip_tags($instance['title']);
		$teams_animation_speed = strip_tags($instance['teams_animation_speed']);
		$person_data_email =(bool)$instance['person_data_email'];
		$ct_teams = array();
		foreach ($team_terms as $term) {
			$ct_teams[$term->slug] = $term->name;
		}
		$effects_enabled = (bool) $instance['effects_enabled'];

		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ct'); ?>: <input
					class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
					name="<?php echo $this->get_field_name('title'); ?>" type="text"
					value="<?php echo esc_attr($title); ?>"/></label></p>

		<p><label for="<?php echo $this->get_field_id('teams_animation_speed'); ?>"><?php _e('Autoscroll Speed', 'ct'); ?>: <input
					class="widefat" id="<?php echo $this->get_field_id('teams_animation_speed'); ?>"
					name="<?php echo $this->get_field_name('teams_animation_speed'); ?>" type="text"
					value="<?php echo esc_attr($teams_animation_speed); ?>"/></label></p>

		<label
			for="<?php echo $this->get_field_id('team'); ?>"><?php _e('Team Set', 'ct'); ?>
			:</label>
		<br/>



		<?php
		ct_print_checkboxes($ct_teams, $team, $this->get_field_name('teams').'[]');
		?>
		<br/>

		<p>
			<input type="checkbox" name="<?php echo $this->get_field_name('effects_enabled'); ?>" id="<?php echo $this->get_field_id('effects_enabled'); ?>" value="1" <?php checked($effects_enabled, 1); ?> />
			<label for="<?php echo $this->get_field_id('effects_enabled'); ?>"><?php _e('Lazy loading enabled', 'ct'); ?></label>
		</p>
        <p>
            <input type="checkbox" name="<?php echo $this->get_field_name('person_data_email'); ?>" id="<?php echo $this->get_field_id('person_data_email'); ?>" value="1" <?php checked($person_data_email, 1); ?> />
            <label for="<?php echo $this->get_field_id('person_data_email'); ?>"><?php _e('Hide Email', 'ct'); ?></label>
        </p>


	<?php
	}
}


function ct_teams($params) {
	wp_enqueue_script('ct-widgets');
	$params = array_merge(array('teams' => '','teams_animation_speed' => '' ,'person_data_email' => ''), $params);
	$args = array(
		'post_type' => 'ct_team_person',
		'orderby' => 'menu_order ID',
		'order' => 'DESC'
	);
	if ($params['teams'] != '') {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'ct_teams',
				'field' => 'slug',
				'terms' => $params['teams']
			)
		);
	}
	$loop = new WP_Query($args);

	echo '<div class="widget-teams">';
	echo '<div data-autoscroll="'.$params['teams_animation_speed'].'" class="ct-teams-items-carousel">';
	echo '<div class="ct-teams-items">';
	$link_start = '';
	$link_end = '';

	while ($loop->have_posts()) : $loop->the_post();
		$item_data = ct_get_sanitize_team_person_data(get_the_ID());
		include(locate_template(array('ct-templates/teams/content-teams-widget.php')));
            ?>
		</div>
		<?php
	endwhile;
	echo '</div></div></div>';
	wp_reset_postdata();
}


/* CT_Widget_Contacts */

class CT_Widget_Contats extends WP_Widget {
	function __construct() {
		$widget_ops = array('Cotnacts' => 'widget_contacts', 'description' => __('Contacts', 'ct'));
		parent::__construct('Contacts', __('Contacts', 'ct'), $widget_ops);
	}

	function widget($args, $instance) {

		extract($args);
		$widget_data = array_merge(array(
			'title' => '',
		), $instance);
		echo $before_widget;
		if (!empty($widget_data['title'])) {
			echo $before_title . $widget_data['title'] . $after_title;
		}
		echo  ct_contacts();
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args((array)$instance, array('title' => ''));
		$title = strip_tags($instance['title']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ct'); ?>: <input
					class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
					name="<?php echo $this->get_field_name('title'); ?>" type="text"
					value="<?php echo esc_attr($title); ?>"/></label></p>
	<?php
	}
}

/* CT_Widget_Gallery */

class CT_Widget_Gallery extends WP_Widget {

	function __construct() {
		parent::__construct('ct_gallery', __('Codex Themes Gallery', 'ct'), array('classname' => 'widget_ct_gallery', 'description' => __('Codex Themes Gallery', 'ct')));
	}

	function widget($args, $instance) {
		$widget_data = array_merge(array(
			'title' => '',
			'gallery' => '',
			'autoscroll' => '',
		), $instance);

		extract($args);
		echo $before_widget;

		if($widget_data['title']) {
			echo $before_title . $widget_data['title'] . $after_title;
		}

		if($widget_data['gallery']) {
			ct_simple_gallery(array('gallery' => $widget_data['gallery'], 'autoscroll' => $widget_data['autoscroll']));
		}

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['gallery'] = intval($new_instance['gallery']);
		$instance['autoscroll'] = intval($new_instance['autoscroll']);
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args((array)$instance, array('title' => '', 'gallery' => '', 'autoscroll' => ''));
		$title = strip_tags($instance['title']);
		$gallery = $instance['gallery'];
		$autoscroll = $instance['autoscroll'];
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ct'); ?>: <input
					class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
					name="<?php echo $this->get_field_name('title'); ?>" type="text"
					value="<?php echo esc_attr($title); ?>"/></label></p>
		<p><label for="<?php echo $this->get_field_id('gallery'); ?>"><?php _e('Select Gallery', 'ct'); ?>:</label><br/>
		<?php ct_print_select_input(ct_galleries_array(), $instance['gallery'], $this->get_field_name('gallery'), $this->get_field_id('gallery')) ?></p>
		<p><label for="<?php echo $this->get_field_id('autoscroll'); ?>"><?php _e('Autoscroll (msec)', 'ct'); ?>: <input
					class="widefat" id="<?php echo $this->get_field_id('autoscroll'); ?>"
					name="<?php echo $this->get_field_name('autoscroll'); ?>" type="text"
					value="<?php echo esc_attr($autoscroll); ?>"/></label></p>
	<?php
	}
}

/* CT_Widget_Clients */

class CT_Widget_Clients extends WP_Widget {

	function __construct() {
		parent::__construct('CT_Widget_Clients', __('Codex Themes Clients', 'ct'), array('classname' => 'widget_ct_clients', 'description' => __('Codex Themes Clients', 'ct')));
	}

	function widget($args, $instance) {
		$widget_data = array_merge(array(
			'title' => '',
			'clients_set' => '',
			'rows' => '3',
			'cols' => '3',
			'autoscroll' => '',
			'effects_enabled' => false,
			'disable_grayscale' => false,
			'widget' => true
		), $instance);

		if($args['id'] === 'footer-widget-area') {
			$widget_data['disable_carousel'] = true;
		}

		extract($args);
		echo $before_widget;

		if($widget_data['title']) {
			echo $before_title . $widget_data['title'] . $after_title;
		}

		ct_clients($widget_data);

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['clients_set'] = $new_instance['clients_set'];
		$instance['rows'] = intval($new_instance['rows']) > 0 ? intval($new_instance['rows']) : 3;
		$instance['autoscroll'] = intval($new_instance['autoscroll']);
		$instance['effects_enabled'] = (bool) $new_instance['effects_enabled'];
		$instance['disable_grayscale'] = (bool) $new_instance['disable_grayscale'];
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args((array)$instance, array(
			'title' => '',
			'clients_set' => '',
			'rows' => 3,
			'autoscroll' => '',
			'effects_enabled' => false,
			'disable_grayscale' => false,
		));
?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'ct' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'clients_set' ) ); ?>"><?php _e( 'Clients sets:', 'ct' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('clients_set') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'clients_set' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['clients_set'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'rows' ) ); ?>"><?php _e( 'Rows count:', 'ct' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('rows') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'rows' ) ); ?>" type="number" value="<?php echo esc_attr( $instance['rows'] ); ?>" min="1" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'autoscroll' ) ); ?>"><?php _e( 'Autoscroll:', 'ct' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('autoscroll') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'autoscroll' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['autoscroll'] ); ?>" />
		</p>
		<p>
			<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'effects_enabled' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id('effects_enabled') ); ?>" value="1" <?php checked($instance['effects_enabled'], 1); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'effects_enabled' ) ); ?>"><?php _e( 'Effects enabled', 'ct' ); ?></label>
		</p>
		<p>
			<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'disable_grayscale' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id('disable_grayscale') ); ?>" value="1" <?php checked($instance['disable_grayscale'], 1); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'disable_grayscale' ) ); ?>"><?php _e( 'Disable grayscale', 'ct' ); ?></label>
		</p>
	<?php
	}
}