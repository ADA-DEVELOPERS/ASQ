<?php
	$cryption_item_data = ct_get_sanitize_team_person_data(get_the_ID());
	$cryption_link_start = '';
	$cryption_link_end = '';
	if($cryption_link = cryption_get_data($cryption_item_data, 'link')) {
		$cryption_link_start = '<a href="'.esc_url($cryption_link).'" target="'.esc_attr(cryption_get_data($cryption_item_data, 'link_target')).'">';
		$cryption_link_end = '</a>';
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
	$cryption_email_link = cryption_get_data($cryption_item_data, 'email', '', '<div class="team-person-email"><a href="mailto:', '">'.$cryption_item_data['email'].'</a></div>');
	if($cryption_item_data['hide_email']) {
		$cryption_email = explode('@', $cryption_item_data['email']);
		if(count($cryption_email) == 2) {
			$cryption_email_link = '<div class="team-person-email"><a href="#" class="hidden-email" data-name="'.esc_attr($cryption_email[0]).'" data-domain="'.esc_attr($cryption_email[1]).'">'.esc_html__('Send Message', 'cryption').'</a></div>';
		}
	}
	$cryption_socials_block = '';
	foreach(ct_team_person_socials_list() as $cryption_key => $cryption_value) {
		if($cryption_item_data['social_link_'.$cryption_key]) {
			$cryption_socials_block .= '<a title="'.esc_attr($cryption_value).'" target="_blank" href="'.esc_url($cryption_item_data['social_link_'.$cryption_key]).'" class="socials-item"><i class="socials-item-icon social-item-rounded '.esc_attr($cryption_key).'"></i></a>';
		}
	}
?>
<div class="<?php echo esc_attr($cryption_grid_class); ?> inline-column">
	<div id="post-<?php the_ID(); ?>" <?php post_class(array('team-person', 'centered-box'));?> style="">

		<?php if ($params['style'] == 'style-1') : ?>
		<?php if(has_post_thumbnail()) : ?><div class="team-person-image bordered-box"><?php echo $cryption_link_start; cryption_post_thumbnail('ct-person', false, 'img-responsive', array('srcset' => array('2x' => 'ct-person'))); echo $cryption_link_end; ?></div><?php endif; ?>
		<?php endif; ?>

		<?php if ($params['style'] == 'style-2') : ?>
			<?php if(has_post_thumbnail()) : ?><div class="team-person-image"><?php echo $cryption_link_start; cryption_post_thumbnail('ct-person-800', false, 'img-responsive', array('srcset' => array('2x' => 'ct-person'))); echo $cryption_link_end; ?></div><?php endif; ?>
		<?php endif; ?>

        <?php if ($params['style'] == 'style-counter') : ?>
            <?php if(has_post_thumbnail()) : ?><div class="team-person-image"><?php echo $cryption_link_start; cryption_post_thumbnail('ct-person-80', false, 'img-responsive', array('srcset' => array('2x' => 'ct-person'))); echo $cryption_link_end; ?></div><?php endif; ?>
        <?php endif; ?>

		<div class="team-person-info">
            <?php if ($params['style'] == 'style-counter') : ?>
                <?php echo cryption_get_data($cryption_item_data, 'name', '', '<div class="team-person-name title-h2 light">', '</div>'); ?>
                <?php echo cryption_get_data($cryption_item_data, 'position', '', '<div class="team-person-position">', '</div>'); ?>
            <?php else : ?>
                <?php echo cryption_get_data($cryption_item_data, 'name', '', '<div class="team-person-name title-h4">', '</div>'); ?>
                <?php echo cryption_get_data($cryption_item_data, 'position', '', '<div class="team-person-position date-color small-body">', '</div>'); ?>
            <?php endif; ?>
			<?php echo cryption_get_data($cryption_item_data, 'phone', '', '<div class="ct-styled-color-1"><div class="team-person-phone title-h5">', '</div></div>'); ?>
			<?php echo $cryption_email_link; ?>
			<?php if ($params['style'] == 'style-1') : ?>
				<div class="team-person-content">
				<?php the_content(); ?>
				</div>
			<?php endif; ?>
			<?php if($cryption_socials_block) : ?><div class="socials team-person-socials socials-colored-hover"><?php echo $cryption_socials_block; ?></div><?php endif; ?>
		</div>
	</div>
</div>