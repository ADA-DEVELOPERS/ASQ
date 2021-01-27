<?php if(is_singular()) : ?>
<div class="block-content">
	<div class="container">
<?php endif; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row">
		<div class="item-post">
			
			<div class="post-text col-md-<?php echo has_post_thumbnail() ? 9 : 12; ?>">
				<header class="entry-header">

					<?php if (!is_single()) :
						the_title('<div class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></div>');
					endif;
					?>

					<div class="entry-meta">
						<?php
						if ('post' == get_post_type())
							cryption_posted_on();

						if (!post_password_required() && (comments_open() || get_comments_number())) :
							?>

						<?php
						endif;

						?>
						<?php the_tags('<span class="entry-meta">|<span class="tag-links">', '|', '</span></span>'); ?>

					</div>
					<!-- .entry-meta -->
				</header>
				<!-- .entry-header -->

				<?php if (is_search()) : ?>
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div><!-- .entry-summary -->
				<?php else : ?>
					<div class="entry-content">
						<?php
						the_content(wp_kses(__('Continue reading <span class="meta-nav">&rarr;</span>', 'cryption'), array('span' => array('class' => array()))));
						wp_link_pages(array(
							'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'cryption') . '</span>',
							'after' => '</div>',
							'link_before' => '<span>',
							'link_after' => '</span>',
						));
						?>
					</div><!-- .entry-content -->
				<?php endif; ?>
			</div>
		</div>
	</div>
</article><!-- #post-## -->
<?php if(is_singular()) : ?>
	</div>
</div>
<?php endif; ?>
