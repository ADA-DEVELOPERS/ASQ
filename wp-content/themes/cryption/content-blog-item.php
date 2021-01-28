<?php

	$cryption_blog_style = isset($cryption_blog_style) ? $cryption_blog_style : 'default';

	$cryption_post_data = cryption_get_sanitize_page_title_data(get_the_ID());

	$params = isset($params) ? $params : array(
		'hide_author' => 0,
		'hide_comments' => 0,
		'hide_date' => 0,
		'hide_likes' => 0,
	);

	$cryption_categories = get_the_category();
	$cryption_categories_list = array();
	foreach($cryption_categories as $cryption_category) {
		$cryption_categories_list[] = '<a href="'.esc_url(get_category_link( $cryption_category->term_id )).'" title="'.esc_attr( sprintf( esc_html__( "View all posts in %s", "cryption" ), $cryption_category->name ) ).'">'.$cryption_category->cat_name.'</a>';
	}

	$cryption_classes = array();

	if(is_sticky() && !is_paged()) {
		$cryption_classes = array_merge($cryption_classes, array('sticky', 'default-background', 'shadow-box'));
	}

	$cryption_featured_content = cryption_get_post_featured_content(get_the_ID());
	if(empty($cryption_featured_content)) {
		$cryption_classes[] = 'no-image';
	}

	$cryption_classes[] = 'item-animations-not-inited';

?>

<article id="post-<?php the_ID(); ?>" <?php post_class($cryption_classes); ?>>
	<?php if(get_post_format() == 'quote' && $cryption_featured_content) : ?>
		<?php echo $cryption_featured_content; ?>
	<?php else : ?>
	<div class="item-post-container">
		<div class="item-post clearfix">

			<?php if($cryption_featured_content) : ?>
				<div class="post-image"><?php echo $cryption_featured_content; ?></div>
			<?php endif; ?>


			

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

			<div class="post-footer">
				<div class="post-read-more"><?php cryption_button(array('icon' => 'more', 'icon_position' => 'left', 'href' => get_the_permalink(),  'text' => esc_html__('Read More', 'cryption'), 'size' => 'small', 'corner' => 20), 1); ?></div>
			</div>

		</div>
	</div>
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
