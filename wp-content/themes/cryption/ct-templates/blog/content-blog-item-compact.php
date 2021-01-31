<?php

	$cryption_post_data = cryption_get_sanitize_page_title_data(get_the_ID());

	$params = isset($params) ? $params : array(
		'hide_author' => 0,
		'hide_comments' => 0,
		'hide_date' => 0,
	);

	$cryption_classes = array();

	if(is_sticky() && !is_paged()) {
		$cryption_classes = array_merge($cryption_classes, array('sticky'));
	}

	if(has_post_thumbnail()) {
		$cryption_classes[] = 'no-image';
	}

	$cryption_classes[] = 'item-animations-not-inited';
	$cryption_classes[] = 'clearfix';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($cryption_classes); ?>>
	<div class="ct-compact-item-left">
		<div class="ct-compact-item-image">
			<a class="default" href="<?php echo esc_url(get_permalink()); ?>"><?php cryption_post_thumbnail('ct-blog-compact', true, 'img-responsive'); ?></a>
		</div>
	</div>
	<div class="ct-compact-item-right">
		<div class="ct-compact-item-content">
			<div class="post-title">
				<?php the_title('<h5 class="entry-title reverse-link-color"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">'.(!$params['hide_date'] ? get_the_date('d M').': ' : '').'<span>', '</span></a></h5>'); ?>
			</div>
			<div class="post-text">
				<div class="summary">
					<?php if ( !empty( $cryption_post_data['title_excerpt'] ) ): ?>
						<?php echo $cryption_post_data['title_excerpt']; ?>
					<?php else: ?>
						<?php echo preg_replace('%&#x[a-fA-F0-9]+;%', '', apply_filters('the_excerpt', get_the_excerpt())); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
