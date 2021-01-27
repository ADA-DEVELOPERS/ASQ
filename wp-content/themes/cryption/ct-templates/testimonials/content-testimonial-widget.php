<div class="testimonials-style-1-item">
	<div class="testimonials-style-1-text"><?php the_content(); ?></div>
	<div class="testimonials-style-1-container">
		<div class="testimonials-style-1-image"> <?php echo $link_start; ?> <?php if ($params['effects_enabled']): ?><span
				class="lazy-loading-item" style="display: block;" data-ll-item-delay="0"
				data-ll-effect="clip"><?php endif; ?> <?php cryption_post_thumbnail('ct-post-thumb'); ?> <?php if ($params['effects_enabled']): ?></span><?php endif; ?> <?php echo $link_end; ?>
		</div>
		<div class="testimonials-style-1-info">
			<div class="testimonials-style-1-name ct-testimonial-name"><?php echo $item_data['name'] ?></div>
			<?php if ($item_data['position']) : ?>
				<div class="testimonials-style-1-post ct-testimonial-position small-body"><?php echo esc_html($item_data['position']); ?></div>
			<?php endif; ?>
			<?php if ($item_data['company']) : ?>
				<div class="testimonials-style-1-post ct-testimonial-company small-body"><?php echo esc_html($item_data['company']); ?></div>
			<?php endif; ?>
		</div>
	</div>
</div>
