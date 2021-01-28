<!-- <?php
/**
 * The template for displaying the footer
 */

$id = is_singular() ? get_the_ID() : 0;
$effects_params = cryption_get_sanitize_page_effects_data($id);
?>

</div>
<!- #main -->

<?php if(empty($effects_params['effects_hide_footer'])) : ?>
<?php if(is_active_sidebar('pre-footer-widget-area')) : ?>
	<footer id="pre-footer" class="pre-footer">
		<div class="container">
			<div class="row"><?php dynamic_sidebar('pre-footer-widget-area'); ?></div>
		</div>
	</footer>
<?php endif; ?>
<?php
	$cryption_custom_footer = get_post(cryption_get_option('custom_footer'));
	$cryption_q = new WP_Query(array('p' => cryption_get_option('custom_footer'), 'post_type' => 'ct_footer', 'post_status' => 'private'));
	if(cryption_get_option('custom_footer') && $cryption_custom_footer && $cryption_q->have_posts()) : $cryption_q->the_post(); ?>
	<footer class="custom-footer"><div class="container"><?php the_content(); ?></div></footer>
<?php wp_reset_postdata(); endif; ?>
<?php if(is_active_sidebar('footer-widget-area')) : ?>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<?php get_sidebar('footer'); ?>
		</div>
	</footer><!-- #colophon -->
<?php endif; ?>

<?php if(cryption_get_option('footer_active')) : ?>

	<footer id="footer-nav" class="site-footer">
		<div class="container"><div class="row">

				<div class="col-md-4 col-md-push-8">
					<?php $socials_icons = array('twitter' => cryption_get_option('twitter_active'), 'facebook' => cryption_get_option('facebook_active'), 'linkedin' => cryption_get_option('linkedin_active'), 'instagram' => cryption_get_option('instagram_active'), 'youtube' => cryption_get_option('youtube_active'), 'telegram' => cryption_get_option('telegram_active'), 'slack' => cryption_get_option('slack_active'));
					if(in_array(1, $socials_icons)) : ?>
						<div id="footer-socials"><div class="socials inline-inside socials-colored socials-rounded">
								<?php foreach($socials_icons as $name => $active) : ?>
									<?php if($active) : ?>
										<a href="<?php echo esc_url(cryption_get_option($name . '_link')); ?>" target="_blank" title="<?php echo esc_attr($name); ?>" class="socials-item"><i class="socials-item-icon <?php echo esc_attr($name); ?>"></i></a>
									<?php endif; ?>
								<?php endforeach; ?>
								<?php do_action('cryption_footer_socials'); ?>
							</div></div><!-- #footer-socials -->
					<?php endif; ?>
				</div>

				<div class="col-md-4">
					<?php if(has_nav_menu('footer')) : ?>
						<nav id="footer-navigation" class="site-navigation footer-navigation centered-box" role="navigation">
							<?php wp_nav_menu(array('theme_location' => 'footer', 'menu_id' => 'footer-menu', 'menu_class' => 'nav-menu styled clearfix inline-inside', 'container' => false, 'depth' => 1, 'walker' => new cryption_walker_footer_nav_menu)); ?>
						</nav>
					<?php endif; ?>
				</div>

				<div class="col-md-4 col-md-pull-8"><div class="footer-site-info"><?php echo wp_kses_post(do_shortcode(nl2br(stripslashes(cryption_get_option('footer_html'))))); ?></div></div>

			</div></div>
	</footer><!-- #footer-nav -->
<?php endif; ?>
<?php endif; ?>


</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
