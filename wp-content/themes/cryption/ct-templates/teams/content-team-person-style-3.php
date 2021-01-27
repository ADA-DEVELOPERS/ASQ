<?php
	$ct_item_data = ct_get_sanitize_team_person_data(get_the_ID());
	$ct_link_start = '';
	$ct_link_end = '';
	if($ct_link = ct_get_data($ct_item_data, 'link')) {
		$ct_link_start = '<a href="'.esc_url($ct_link).'" target="'.esc_attr(ct_get_data($ct_item_data, 'link_target')).'">';
		$ct_link_end = '</a>';
	}
	$ct_grid_class = '';
	if($params['columns'] == '1') {
		$ct_grid_class = 'col-xs-12';
	} elseif($params['columns'] == '2') {
		$ct_grid_class = 'col-sm-6 col-xs-12';
	} elseif($params['columns'] == '3') {
		$ct_grid_class = 'col-md-4 col-sm-6 col-xs-12';
	} else {
		$ct_grid_class = 'col-md-3 col-sm-6 col-xs-12';
	}
	$ct_email_link = ct_get_data($ct_item_data, 'email', '', '<div class="team-person-email date-color"><a class="date-color" href="mailto:', '"></a></div>');
	if($ct_item_data['hide_email']) {
		$ct_email = explode('@', $ct_item_data['email']);
		if(count($ct_email) == 2) {
			$ct_email_link = '<div class="team-person-email"><a href="#" class="hidden-email date-color" data-name="'.$ct_email[0].'" data-domain="'.$ct_email[1].'"></a></div>';
		}
	}
	$ct_socials_block = '';
	foreach(ct_team_person_socials_list() as $ct_key => $ct_value) {
		if($ct_item_data['social_link_'.$ct_key]) {
			$ct_socials_block .= '<a title="'.esc_attr($ct_value).'" target="_blank" href="'.esc_url($ct_item_data['social_link_'.$ct_key]).'" class="socials-item"><i class="socials-item-icon social-item-rounded '.esc_attr($ct_key).'"></i></a>';
		}
	}
?>

<div class="<?php echo esc_attr($ct_grid_class); ?> inline-column">
	<div id="post-<?php the_ID(); ?>" <?php post_class(array('team-person', 'centered-box', 'bordered-box')); ?>>
		<?php if(has_post_thumbnail()) : ?><div class="team-person-image"><?php echo $ct_link_start; ct_post_thumbnail('ct-person', false, 'img-responsive'); echo $ct_link_end; ?></div><?php endif; ?>
		<div class="team-person-info">
			<?php echo ct_get_data($ct_item_data, 'name', '', '<div class="team-person-name styled-subtitle">', '</div>'); ?>
			<?php echo ct_get_data($ct_item_data, 'position', '', '<div class="team-person-position date-color">', '</div>'); ?>
			<?php echo ct_get_data($ct_item_data, 'phone', '', '<div class="ct-styled-color-1"><div class="team-person-phone title-h5">', '</div></div>'); ?>
			<?php if($ct_socials_block) : ?><div class="socials team-person-socials socials-colored-hover"><?php echo $ct_socials_block; ?></div><?php endif; ?>
		</div>
		<?php echo $ct_email_link; ?>
	</div>
</div>