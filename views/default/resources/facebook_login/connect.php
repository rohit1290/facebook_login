<?php
// Note: Manual Login Flow Doc:
// https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow

$cncl_url = elgg_get_site_url(). "login";

if (!facebook_login_allow_sign_on_with_facebook()) {
	elgg_register_error_message(elgg_echo('Facebook registration is disabled'));
	header("Location: {$cncl_url}");
	die();
}
if (elgg_is_logged_in()) {
	elgg_register_error_message(elgg_echo('Please logout and then login using facebook'));
	header("Location: {$cncl_url}");
	die();
}

$app_version = elgg_get_plugin_setting('default_graph_version', 'facebook_login');
$app_id = elgg_get_plugin_setting('app_id', 'facebook_login');
$redirect_uri = elgg_generate_url('collection:object:facebook_login:login');
$state = md5(rand(1000, 999));

$url = "https://www.facebook.com/$app_version/dialog/oauth?client_id={$app_id}&redirect_uri={$redirect_uri}&state={$state}";

header("Location: {$url}");
die();