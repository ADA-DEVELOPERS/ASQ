<?php

	$cryption_post_data = cryption_get_sanitize_page_title_data(get_the_ID());

	$cryption_categories = get_the_category();
	$cryption_categories_list = array();
	foreach($cryption_categories as $cryption_category) {
		$cryption_categories_list[] = '<a href="'.esc_url(get_category_link( $cryption_category->term_id )).'" title="'.esc_attr( sprintf( esc_html__( "View all posts in %s", "cryption" ), $cryption_category->name ) ).'">'.$cryption_category->cat_name.'</a>';
	}

	$cryption_classes = array();
	$cryption_sources = array();
	$cryption_featured_content = '';
	$has_content_gallery = get_post_format(get_the_ID()) == 'gallery';

	if(is_sticky() && !is_paged()) {
		$cryption_classes = array_merge($cryption_classes, array('sticky'));
		$cryption_featured_content = cryption_get_post_featured_content(get_the_ID(), 'ct-blog-masonry-sticky');
	} else {
		$cryption_post_gallery_size = 'ct-blog-masonry';
		if ($has_content_gallery) {
			if ($blog_style == '100%') {
				$cryption_post_gallery_size = 'ct-blog-masonry-100';
			} elseif ($blog_style == '3x') {
				$cryption_post_gallery_size = 'ct-blog-masonry-3x';
			} elseif ($blog_style == '4x') {
				$cryption_post_gallery_size = 'ct-blog-masonry-4x';
			}
		}

		if (has_post_thumbnail() && !$has_content_gallery) {
			if ($blog_style == '100%') {
				$cryption_sources = array(
					array('media' => '(max-width: 600px)', 'srcset' => array('1x' => 'ct-blog-masonry', '2x' => 'ct-blog-masonry')),
					array('media' => '(max-width: 992px)', 'srcset' => array('1x' => 'ct-blog-masonry-100-medium', '2x' => 'ct-blog-masonry')),
					array('media' => '(max-width: 1100px)', 'srcset' => array('1x' => 'ct-blog-masonry-100-small', '2x' => 'ct-blog-masonry')),
					array('media' => '(max-width: 1920px)', 'srcset' => array('1x' => 'ct-blog-masonry-100', '2x' => 'ct-blog-masonry'))
				);
			} elseif ($blog_style == '3x') {
				$cryption_sources = array(
					array('media' => '(max-width: 600px)', 'srcset' => array('1x' => 'ct-blog-masonry', '2x' => 'ct-blog-masonry')),
					array('media' => '(max-width: 992px)', 'srcset' => array('1x' => 'ct-blog-masonry-100-medium', '2x' => 'ct-blog-masonry')),
					array('media' => '(max-width: 1920px)', 'srcset' => array('1x' => 'ct-blog-masonry-100', '2x' => 'ct-blog-masonry'))
				);
			} elseif ($blog_style == '4x') {
				$cryption_sources = array(
					array('media' => '(max-width: 600px)', 'srcset' => array('1x' => 'ct-blog-masonry', '2x' => 'ct-blog-masonry')),
					array('media' => '(max-width: 992px)', 'srcset' => array('1x' => 'ct-blog-masonry-100-medium', '2x' => 'ct-blog-masonry')),
					array('media' => '(max-width: 1920px)', 'srcset' => array('1x' => 'ct-blog-masonry-4x', '2x' => 'ct-blog-masonry'))
				);
			}
		}
		$cryption_featured_content = cryption_get_post_featured_content(get_the_ID(), $has_content_gallery ? $cryption_post_gallery_size : 'ct-blog-masonry', false, $cryption_sources);
	}

	if(empty($cryption_featured_content)) {
		$cryption_classes[] = 'no-image';
	}

	if ($blog_style == '3x') {
		$cryption_classes = array_merge($cryption_classes, array('col-lg-4', 'col-md-4', 'col-sm-6', 'col-xs-6'));
	}

	if ($blog_style == '4x' || $blog_style == '100%') {
		$cryption_classes = array_merge($cryption_classes, array('col-lg-3', 'col-md-3', 'col-sm-6', 'col-xs-6'));
	}

	$cryption_classes[] = 'item-animations-not-inited';

	?>

<article id="post-<?php the_ID(); ?>" <?php post_class($cryption_classes); ?>>
	<?php if (isset($params['effects_enabled']) && $params['effects_enabled']): ?>
		<div class="item-lazy-scroll-wrap">
	<?php endif; ?>

	<?php if(get_post_format() == 'quote' && $cryption_featured_content) : ?>
		<?php echo $cryption_featured_content; ?>
	<?php else : ?>
		<?php
		if(!is_single() && is_sticky() && !is_paged()) :
			echo '<div class="post-content-wrapper default-background shadow-box">';
		else :
			echo '<div class="post-content-wrapper '.($params['color_style'] == 'style-2' ? 'main-background' : 'blog-item-default-background').' shadow-box">';
		endif;
		?>
		<?php
			if(!is_single() && is_sticky() && !is_paged()) {
				// echo '<div class="sticky-label">&#xe61a;</div>';
			}
		?>
		<?php if($cryption_featured_content): ?>
			<div class="post-image"><?php echo $cryption_featured_content; ?></div>
		<?php endif; ?>
		<div class="description">

			
			<div class="post-title">
				<?php the_title('<h4 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h4>'); ?>
			</div>
			<div class="post-text">
				<div class="summary">
					<?php if ( !empty( $cryption_post_data['title_excerpt'] ) ): ?>
						<?php echo wp_kses_post($cryption_post_data['title_excerpt']); ?>
					<?php else: ?>
						<?php echo preg_replace('%&#x[a-fA-F0-9]+;%', '', apply_filters('the_excerpt', get_the_excerpt())); ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="info clearfix">
				<div class="post-read-more"><?php cryption_button(array('position' => 'left', 'icon' => 'more', 'icon_position' => 'right', 'href' => get_the_permalink(),  'text' => esc_html__('Read More', 'cryption'), 'size' => 'small', 'corner' => 20), 1); ?></div>
			</div>
		</div>
		</div>
	<?php endif; ?>

	<?php if (isset($params['effects_enabled']) && $params['effects_enabled']): ?>
		</div>
	<?php endif; ?>
</article>
