<?php
	$cryption_item_data = ct_get_sanitize_team_person_data(get_the_ID());
	$cryption_link_start = '';
	$cryption_link_end = '';
	if($cryption_link = cryption_get_data($cryption_item_data, 'email')) {
		$cryption_link_start = '<a href="'.esc_url('mailto:'.$cryption_link).'">';
		$cryption_link_end = '</a>';
		if($cryption_item_data['hide_email']) {
			$cryption_email = explode('@', $cryption_link);
			if(count($cryption_email) == 2) {
				$cryption_link_start = '<a href="#" class="hidden-email" data-name="'.esc_attr($cryption_email[0]).'" data-domain="'.esc_attr($cryption_email[1]).'">';
				$cryption_link_end = '</a>';
			}
		}
	}
	$cryption_grid_class = '';
	if($params['columns'] == '1') {
		$cryption_grid_class = 'col-xs-12';
	} elseif($params['columns'] == '2') {
		$cryption_grid_class = 'col-sm-6 col-xs-12';
	} elseif($params['columns'] == '3') {
		$cryption_grid_class = 'col-md-4 col-sm-6 col-xs-12';
	} else {
		$cryption_grid_class = 'col-md-3 col-sm-6 col-xs-12';
	}
	$cryption_socials_block = '';
	foreach(ct_team_person_socials_list() as $cryption_key => $cryption_value) {
		if($cryption_item_data['social_link_'.$cryption_key]) {
			$cryption_socials_block .= '<a title="'.esc_attr($cryption_value).'" target="_blank" href="'.esc_url($cryption_item_data['social_link_'.$cryption_key]).'" class="socials-item"><i class="socials-item-icon social-item-rounded '.esc_attr($cryption_key).'"></i></a>';
		}
	}
?>


<div class="<?php echo esc_attr($cryption_grid_class); ?> inline-column">
	<?php if($cryption_item_data['link']) : ?><a class="team-person-box-link" href="<?php echo esc_url($cryption_item_data['link']); ?>" target="<?php echo esc_attr($cryption_item_data['link_target']); ?>"><?php endif; ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(array('team-person')); ?>><div class="team-person-hover shadow-box">
			<div class="team-person-box clearfix">
				<div class="team-person-info">
                    <?php if(has_post_thumbnail()) : ?><div class="team-person-image"><?php echo $cryption_link_start; cryption_post_thumbnail('ct-person-100', false, 'img-responsive', array('srcset' => array('2x' => 'ct-person'))); echo $cryption_link_end; ?></div><?php endif; ?>
                    <?php echo cryption_get_data($cryption_item_data, 'name', '', '<div class="team-person-name title-h5">', '</div>'); ?>
					<?php echo cryption_get_data($cryption_item_data, 'position', '', '<div class="team-person-position date-color body-small">', '</div>'); ?>
                    <?php if ($params['style'] == 'style-6') : ?>
                        <div class="team-person-content">
                            <?php the_content(); ?>
                        </div>
                    <?php endif; ?>
                    <?php echo cryption_get_data($cryption_item_data, 'phone', '', '<div class="ct-styled-color-1"><div class="team-person-phone title-h6">', '</div></div>'); ?>
				</div>
                <?php if($cryption_socials_block) : ?><div class="socials team-person-socials socials-colored-hover"><?php echo $cryption_socials_block; ?></div><?php endif; ?>
			</div>
		</div>
	</div>
	<?php if($cryption_item_data['link']) : ?></a><?php endif; ?>
</div>