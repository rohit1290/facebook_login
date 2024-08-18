<?php
$site_name = elgg_get_site_entity()->name;
$user = elgg_get_logged_in_user_entity();

$facebook_id = $user->getPluginSetting('facebook_login', 'fbid');
$facebook_name = $user->getPluginSetting('facebook_login', 'fbname');
$access_token = $user->getPluginSetting('facebook_login', 'fbaccess_token');
$body = "";

$body .= '<p>' . elgg_echo('facebook_login:usersettings:description', [$site_name]) . '</p>';

if (!$facebook_id) {
	// send user off to validate account
	$body .= '<p>' .  elgg_echo('facebook_login:usersettings:logout_required', [$site_name]) . '</p>';
} else {
	$body .= '<p>' . sprintf(elgg_echo('facebook_login:usersettings:authorized'), [$facebook_id, $facebook_name]) . '</p>';
	$url = elgg_get_site_url() . "facebook_login/revoke";
	$body .= '<p>' . sprintf(elgg_echo('facebook_login:usersettings:revoke'), $url) . '</p>';
}

echo elgg_view_page("Facebook Login", [
	'content' => $body,
	'show_owner_block_menu' => false,
	'filter_id' => 'settings',
	'filter_value' => 'account',
]);