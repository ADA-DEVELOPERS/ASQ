<?php

	$cryption_post_data = cryption_get_sanitize_page_title_data(get_the_ID());

	$cryption_categories = get_the_category();
	$cryption_categories_list = array();
	foreach($cryption_categories as $cryption_category) {
		$cryption_categories_list[] = '<a href="'.esc_url(get_category_link( $cryption_category->term_id )).'" title="'.esc_attr( sprintf( esc_html__( "View all posts in %s", "cryption" ), $cryption_category->name ) ).'">'.$cryption_category->cat_name.'</a>';
	}

	$cryption_classes = array();
	$cryption_sources = array();
	$has_content_gallery = get_post_format(get_the_ID()) == 'gallery';

	if(is_sticky() && !is_paged()) {
		$cryption_classes = array_merge($cryption_classes, array('sticky'));
		$cryption_featured_content = cryption_get_post_featured_content(get_the_ID(), 'ct-blog-justified-sticky');
	} else {
		$cryption_post_gallery_size = 'ct-blog-justified';
		if ($has_content_gallery) {
			if ($blog_style == 'justified-3x') {
				$cryption_post_gallery_size = 'ct-blog-justified-3x';
			} elseif ($blog_style == 'justified-4x') {
				$cryption_post_gallery_size = 'ct-blog-justified-4x';
			}
		}

		if (has_post_thumbnail() && !$has_content_gallery) {
			if ($blog_style == 'justified-3x') {
				$cryption_sources = array(
					array('media' => '(max-width: 992px)', 'srcset' => array('1x' => 'ct-blog-justified', '2x' => 'ct-blog-justified')),
					array('media' => '(max-width: 1100px)', 'srcset' => array('1x' => 'ct-blog-justified-3x-small', '2x' => 'ct-blog-justified')),
					array('media' => '(max-width: 1920px)', 'srcset' => array('1x' => 'ct-blog-justified-3x', '2x' => 'ct-blog-justified'))
				);
			} elseif ($blog_style == 'justified-4x') {
				$cryption_sources = array(
					array('media' => '(max-width: 600px)', 'srcset' => array('1x' => 'ct-blog-justified', '2x' => 'ct-blog-justified')),
					array('media' => '(max-width: 992px)', 'srcset' => array('1x' => 'ct-blog-justified-4x', '2x' => 'ct-blog-justified')),
					array('media' => '(max-width: 1125px)', 'srcset' => array('1x' => 'ct-blog-justified-3x-small', '2x' => 'ct-blog-justified')),
					array('media' => '(max-width: 1920px)', 'srcset' => array('1x' => 'ct-blog-justified-4x', '2x' => 'ct-blog-justified'))
				);
			}
		}

		$cryption_featured_content = cryption_get_post_featured_content(get_the_ID(), $has_content_gallery ? $cryption_post_gallery_size : 'ct-blog-justified', false, $cryption_sources);
	}


	if ($blog_style == 'justified-3x'){
		if (is_sticky() && !is_paged())
			$cryption_classes = array_merge($cryption_classes, array('col-lg-4', 'col-md-4', 'col-sm-6', 'col-xs-6', 'inline-column'));
		else
			$cryption_classes = array_merge($cryption_classes, array('col-lg-4', 'col-md-4', 'col-sm-6', 'col-xs-6', 'inline-column'));
	} elseif ($blog_style == 'justified-4x'){
		if (is_sticky() && !is_paged())
			$cryption_classes = array_merge($cryption_classes, array('col-lg-6', 'col-md-6', 'col-sm-12', 'col-xs-12', 'inline-column'));
		else
			$cryption_classes = array_merge($cryption_classes, array('col-lg-3', 'col-md-3', 'col-sm-6', 'col-xs-6', 'inline-column'));
	}

	if(is_sticky() && !is_paged() && empty($cryption_featured_content)) {
		$cryption_classes[] = 'no-image';
	}

	$cryption_classes[] = 'item-animations-not-inited';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($cryption_classes); ?>>
	<?php if(get_post_format() == 'quote' && $cryption_featured_content) : ?>
		<?php echo $cryption_featured_content; ?>
	<?php else : ?>
		<?php
		if(!is_single() && is_sticky() && !is_paged()) :
			echo '<div class="post-content-wrapper default-background centered-box shadow-box">';
		else :
			echo '<div class="post-content-wrapper '.($params['color_style'] == 'style-2' ? 'main-background' : 'blog-item-default-background').' centered-box shadow-box">';
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

			<div class="post-meta-container date-color">
				<div class="post-meta-date">
				<?php echo get_the_date(); ?>
				<?php if(!$params['hide_author']) : ?><span class="post-meta-author"><?php printf( esc_html__( "by %s", "cryption" ), get_the_author_link() ) ?></span><?php endif; ?>
				</div>
				<div class="post-meta-likes">
					<?php if( function_exists('zilla_likes') ) { echo '<span class="post-meta-like">';zilla_likes();echo '</span>'; } ?>

				</div>
			</div>

			<div class="post-title">
				<?php the_title('<h5 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h5>'); ?>
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
				<div class="post-read-more"><?php cryption_button(array('position' => 'left', 'icon' => 'more', 'icon_position' => 'right', 'href' => get_the_permalink(),  'text' => esc_html__(' Read More', 'cryption'), 'size' => 'small', 'corner' => 20), 1); ?></div>
			</div>
		</div>
	</div>
<?php endif; ?>
</article>
