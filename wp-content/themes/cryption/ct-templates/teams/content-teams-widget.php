<?php
if($item_data['link']) {
$link_start = '<a href="'.esc_url($item_data['link']).'" target="'.esc_attr($item_data['link_target']).'">';
	$link_end = '</a>';
}
$cryption_item_data = ct_get_sanitize_team_person_data(get_the_ID());
$cryption_socials_block = '';
foreach(ct_team_person_socials_list() as $cryption_key => $cryption_value) {
	if($cryption_item_data['social_link_'.$cryption_key]) {
		$cryption_socials_block .= '<a title="'.esc_attr($cryption_value).'" target="_blank" href="'.esc_url($cryption_item_data['social_link_'.$cryption_key]).'" class="socials-item"><i class="socials-item-icon social-item-rounded '.esc_attr($cryption_key).'"></i></a>';
	}
}
?>
<div class="ct-teams-item rounded-corners">
	<div class="ct-teams-image"><?php echo $link_start ?> <?php if($params['effects_enabled']): ?><div class="lazy-loading-item" style="display: block;" data-ll-item-delay="0" data-ll-effect="clip"><?php endif; ?> <?php cryption_post_thumbnail('ct-post-thumb'); ?> <?php if($params['effects_enabled']): ?></div><?php endif; ?> <?php echo $link_end; ?> </div>
	<div class="ct-teams-name"><?php echo esc_html($item_data['name']); ?></div>
	<div class="ct-teams-position body-small"><?php echo esc_html($item_data['position']); ?></div>
	<div class="ct-teams-phone"> <?php echo esc_html($item_data['phone']); ?></div>

<?php
$email_link = cryption_get_data($item_data, 'email', '', '<div class="team-person-email"><a href="mailto:', '">'.$item_data['email'].'</a></div>');
if($item_data['hide_email']) {
	$email = explode('@', $item_data['email']);
	if(count($email) == 2) {
		$email_link = '<div class="team-person-email"><a href="#" class="hidden-email" data-name="'.esc_attr($email[0]).'" data-domain="'.esc_attr($email[1]).'">'.__('Send Message', 'cryption').'</a></div>';
	}
}
echo $email_link;
?>
	<?php if($cryption_socials_block) : ?><div class="socials team-person-socials socials-colored-hover"><?php echo $cryption_socials_block; ?></div><?php endif; ?>

