<?php
	$params = empty($params) ? array('style' => 'style1') : $params;
	$cryption_item_data = ct_get_sanitize_testimonial_data(get_the_ID());

	$cryption_columns_class = 'col-md-3 col-xs-12';
	switch ($params['columns']) {
		case 1:
			$cryption_columns_class = 'col-md-12 col-sm-12 col-xs-12'; break;
		case 2:
			$cryption_columns_class = 'col-md-6 col-sm-6 col-xs-12'; break;
		case 3:
			$cryption_columns_class = 'col-md-4 col-sm-6 col-xs-12'; break;
		default:
			$cryption_columns_class = 'col-md-3 col-xs-12';
	}
?>

<div class="<?php echo esc_attr($cryption_columns_class); ?> ct-testimonial-item-column">
	<div id="post-<?php the_ID(); ?>" <?php post_class('ct-testimonial-item centered-box shadow-box'); ?>>
		<?php if($cryption_item_data['link']) : ?><a href="<?php echo esc_url($cryption_item_data['link']); ?>" target="<?php echo esc_attr($cryption_item_data['link_target']); ?>"><?php endif; ?>

            <?php if ($params['style'] == 'style1') : ?>
            <div class="ct-testimonial-wrapper">
				<div class="ct-testimonial-content">
					<div class="ct-testimonial-text">
						<?php the_content(); ?>
					</div>
					<div class="ct-testimonial-info">
                        <div class="ct-testimonial-image">
                            <i><?php cryption_post_thumbnail('ct-person-50', false, 'img-responsive img-circle', array('srcset' => array('2x' => 'ct-testimonial'))); ?></i>
                        </div>
                        <div class="ct-testimonial-data">
                            <?php echo cryption_get_data($cryption_item_data, 'name', '', '<div class="ct-testimonial-name title-h6">', '</div>'); ?>
                            <?php echo cryption_get_data($cryption_item_data, 'company', '', '<div class="ct-testimonial-company small-body date-color">', '</div>'); ?>
                            <?php echo cryption_get_data($cryption_item_data, 'position', '', '<div class="ct-testimonial-position small-body date-color">', '</div>'); ?>
                        </div>
					</div>
				</div>
		    </div>
            <?php endif; ?>

            <?php if ($params['style'] == 'style2') : ?>
                <div class="ct-testimonial-wrapper">
                    <div class="ct-testimonial-content style2">
                        <div class="ct-testimonial-image">
                            <i><?php cryption_post_thumbnail('ct-person-80', false, 'img-responsive img-circle', array('srcset' => array('2x' => 'ct-testimonial'))); ?></i>
                        </div>
                        <div class="ct-testimonial-data">
                            <?php echo cryption_get_data($cryption_item_data, 'name', '', '<div class="ct-testimonial-name title-h6">', '</div>'); ?>
                            <?php echo cryption_get_data($cryption_item_data, 'company', '', '<div class="ct-testimonial-company small-body date-color">', '</div>'); ?>
                            <?php echo cryption_get_data($cryption_item_data, 'position', '', '<div class="ct-testimonial-position small-body date-color">', '</div>'); ?>
                        </div>
                        <div class="ct-testimonial-text">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

		<?php if($cryption_item_data['link']) : ?></a><?php endif; ?>
	</div>
</div>