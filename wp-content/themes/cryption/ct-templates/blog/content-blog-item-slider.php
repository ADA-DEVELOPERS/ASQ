<?php

	$cryption_slider_style = isset($cryption_slider_style) ? $cryption_slider_style : '';

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

	$cryption_classes[] = 'clearfix';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($cryption_classes); ?>>
	<div class="ct-slider-item-image">
		<a href="<?php echo esc_url(get_permalink()); ?>"><?php cryption_post_thumbnail('ct-blog-slider-'.$slider_style, true, 'img-responsive'); ?></a>
	</div>
	<div class="ct-slider-item-overlay">
		<div class="ct-compact-item-content">
			<div class="post-title">
				<?php the_title('<h5 class="entry-title reverse-link-color"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">'.(!$params['hide_date'] ? get_the_date('d M').': ' : '').'<span>', '</span></a></h5>'); ?>
			</div>
			<div class="post-text date-color">
				<div class="summary">
					<?php if ( !empty( $cryption_post_data['title_excerpt'] ) ): ?>
						<?php echo wpautop($cryption_post_data['title_excerpt']); ?>
					<?php else: ?>
						<?php
							if ($slider_style == 'fullwidth'){
								echo preg_replace('%&#x[a-fA-F0-9]+;%', '', apply_filters('the_excerpt', get_the_excerpt()));
							}else{
								echo substr(preg_replace('%&#x[a-fA-F0-9]+;%', '', apply_filters('the_excerpt', get_the_excerpt())),0, 149).'. .';
							}
						?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="post-meta date-color">
			<div class="entry-meta clearfix ct-post-date">
				<div class="post-meta-right">
					<?php if(comments_open() && !$params['hide_comments'] ): ?>
						<span class="comments-link"><?php comments_popup_link(0, 1, '%'); ?></span>
					<?php endif; ?>
					<?php if(comments_open() && !$params['hide_comments'] && function_exists('zilla_likes') && !$params['hide_likes']): ?><span class="sep"></span><?php endif; ?>
					<?php if( function_exists('zilla_likes') && !$params['hide_likes'] ) { echo '<span class="post-meta-likes">';zilla_likes();echo '</span>'; } ?>
				</div>
				<div class="post-meta-left">
					<?php if(!$params['hide_author']) : ?><span class="post-meta-author"><?php printf( esc_html__( "By %s", "cryption" ), get_the_author_link() ) ?></span><?php endif; ?>
				</div>
			</div><!-- .entry-meta -->
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
