<?php

$cryption_classes = array('ct-news-item');

if ($params['effects_enabled'])
	$cryption_classes[] = 'lazy-loading-item';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class($cryption_classes); ?> <?php if(!empty($params['effects_enabled'])): ?>data-ll-effect="drop-bottom"<?php endif; ?> >
	<div class="ct-news-item-left">
		<div class="ct-news-item-image">
			<a href="<?php echo esc_url(get_permalink()); ?>"><?php cryption_post_thumbnail('ct-news-carousel'); ?></a>
		</div>
	</div>


	<div class="ct-news-item-right">
		<div class="ct-news-item-right-conteiner">
		<?php the_title('<div class="ct-news-item-title"><a href="'.esc_url(get_permalink()).'">', '</a></div>'); ?>

			<?php if(has_excerpt()) : ?>
				<div class='ct-news_title-excerpt'>
					<?php the_excerpt(); ?>
				</div>
			<?php else : ?>
				<div class='ct-news_title_excerpt'>
					<?php
						$cryption_item_title_data = cryption_get_sanitize_page_title_data(get_the_ID());

						echo wp_kses_post($cryption_item_title_data['title_excerpt']);
					?>
				</div>
			<?php endif; ?>
		</div>
		<div  class="ct-news-item-meta">
			<div class="ct-news-item-date small-body"><?php echo get_the_date(); ?></div>
			<div class="ct-news-zilla-likes">
				<?php if( function_exists('zilla_likes') ) { echo '<span class="post-meta-likes">';zilla_likes();echo '</span>'; } ?>
				<?php if(comments_open()): ?>
					<span class="comments-link"><?php comments_popup_link(0, 1, '%'); ?></span>
				<?php endif; ?>
			</div>
		</div>

	</div>


</article>