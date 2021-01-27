<?php

function ct_remote_upload_page () {
?>
<div class="wrap">
	<div id="icon-tools" class="icon32"></div>
	<h2>Remote Upload</h2>
	<form method="POST">
		<?php wp_nonce_field( 'ct_remote_upload', 'ct_remote_upload_field' ); ?>
		<input type="text" name="url" />
		<button type="submit"><?php _e('Upload', 'ct'); ?></button>
	</form>
</div>
<?php
}

add_action('admin_init', 'ct_remote_upload_submit');
function ct_remote_upload_submit () {
	if(isset($_REQUEST['ct_remote_upload_field']) && wp_verify_nonce( $_REQUEST['ct_remote_upload_field'], 'ct_remote_upload' ) && !empty($_REQUEST['url'])) {
		$url = $_REQUEST['url'];
		$result = media_sideload_image($url, 0);
	}
}

add_action('post-upload-ui', 'ct_remote_upload_test');

function ct_remote_upload_test () {
	wp_enqueue_script('ct-remote-upload-scripts');
?>
	<h2>Remote Upload</h2>
		<textarea class="urls-list" rows="5" cols="100" style="vertical-align: top;"></textarea>
		<button type="submit" id="ct-remote-upload-button"><?php _e('Upload', 'ct'); ?></button>
<?php
}

add_action('admin_enqueue_scripts', 'ct_remote_upload_enqueue');
function ct_remote_upload_enqueue () {
	wp_register_script('ct-remote-upload-scripts', plugins_url( '/../js/remote-upload.js' , __FILE__ ), array('jquery'), false, true);
	wp_localize_script('ct-remote-upload-scripts', 'ct_remote_upload_object', array(
		'security' => wp_create_nonce('ct_remote_upload_ajax_security'),
	));
}

add_action('wp_ajax_ct_remote_upload_ajax', 'ct_remote_upload_ajax');
function ct_remote_upload_ajax () {
	$urls = !empty($_REQUEST['urls']) ? explode("\n", $_REQUEST['urls']) : array();
	foreach($urls as $url) {
		$result = media_sideload_image($url, 0);
	}
	die(-1);
}
