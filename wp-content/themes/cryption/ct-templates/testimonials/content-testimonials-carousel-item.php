<?php
	$params = empty($params) ? array('style' => 'style1') : $params;
	$cryption_item_data = ct_get_sanitize_testimonial_data(get_the_ID());
?>


<div id="post-<?php the_ID(); ?>" <?php post_class('ct-testimonial-item'); ?>>
	<div class="ct-testimonial-item-inner centered-box">

		<div class="ct-testimonial-circle"><div class="ct-testimonial-circle-inner"></div></div>

		<?php if($cryption_item_data['link']) : ?><a href="<?php echo esc_url($cryption_item_data['link']); ?>" target="<?php echo esc_attr($cryption_item_data['link_target']); ?>"><?php endif; ?>
			<div class="ct-testimonial-wrapper">
				<?php if ($params['style'] == 'style1') : ?>
                    <div class="ct-testimonial-image">
                        <i><?php cryption_post_thumbnail('ct-person-80', false, 'img-responsive img-circle', array('srcset' => array('2x' => 'ct-testimonial'))); ?></i>
                    </div>
					<div class="ct-testimonial-content">
                        <div class="ct-testimonial-data">
                            <?php echo cryption_get_data($cryption_item_data, 'name', '', '<div class="ct-testimonial-name title-h6">', '</div>'); ?>
                            <?php echo cryption_get_data($cryption_item_data, 'company', '', '<div class="ct-testimonial-company small-body date-color">', '</div>'); ?>
                            <?php echo cryption_get_data($cryption_item_data, 'position', '', '<div class="ct-testimonial-position small-body date-color">', '</div>'); ?>
                        </div>
                        <div class="ct-testimonial-text">
                            <?php the_content(); ?>
                        </div>
					</div>
				<?php endif; ?>

				<?php if ($params['style'] == 'style2') : ?>
					<div class="ct-testimonial-image">
						<i><?php cryption_post_thumbnail('ct-person-80', false, 'img-responsive img-circle', array('srcset' => array('2x' => 'ct-testimonial'))); ?></i>
					</div>
					<div class="ct-testimonial-content">
						<?php echo cryption_get_data($cryption_item_data, 'name', '', '<div class="ct-testimonial-name title-h5">', '</div>'); ?>
						<?php echo cryption_get_data($cryption_item_data, 'company', '', '<div class="ct-testimonial-company">', '</div>'); ?>
						<?php echo cryption_get_data($cryption_item_data, 'position', '', '<div class="ct-testimonial-position">', '</div>'); ?>
						<div class="ct-testimonial-text styled-subtitle">
							<?php the_content(); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<?php if($cryption_item_data['link']) : ?></a><?php endif; ?>

	</div>

</div>




