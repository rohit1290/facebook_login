<?php
$user = elgg_get_logged_in_user_entity();

// unregister user's information
$user->removePluginSetting('facebook_login', 'fbid');
$user->removePluginSetting('facebook_login', 'fbaccess_token');
// $user->removePluginSetting('facebook_login', 'fbname');

elgg_register_success_message(elgg_echo('facebook_login:revoke:success'));
$url = elgg_get_site_url().'settings/plugins/'.$user->username.'/facebook_login';
header("Location: {$url}");
die();