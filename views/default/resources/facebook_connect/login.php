<?php

$cncl_url = elgg_get_site_url(). "login";

if (!facebook_login_allow_sign_on_with_facebook()) {
	register_error(elgg_echo('Facebook registration is disabled'));
	header("Location: {$cncl_url}");
	die();
}
if (elgg_is_logged_in()) {
	register_error(elgg_echo('Please logout and then login using facebook'));
	header("Location: {$cncl_url}");
	die();
}

/*
 Response (on Cancel)
 YOUR_REDIRECT_URI?
  error_reason=user_denied
  &error=access_denied
  &error_description=Permissions+error.
*/
	
$error_reason = get_input('error_reason', null);
$error_description = get_input('error_description', null);

if ($error_reason == "user_denied") {
	register_error(elgg_echo($error_description));
	header("Location: {$cncl_url}");
	die();
}

// Response (on Sucess)
// https://yourdomain/facebook_login/login?
// code=<code>
// &token=<token>
// &state=<randomcode>#_=_

$code = get_input('code', null);
if($code == null) {
	register_error("Authorization not found");
	header("Location: {$cncl_url}");
	die();
}

$app_version = elgg_get_plugin_setting('default_graph_version', 'facebook_login');
$app_id = elgg_get_plugin_setting('app_id', 'facebook_login');
$app_secret = elgg_get_plugin_setting('app_secret', 'facebook_login');
$redirect_uri = elgg_generate_url('collection:object:facebook_login:login');
// $state = md5(rand(1000, 999));

$url = "https://graph.facebook.com/$app_version/oauth/access_token?client_id=$app_id&redirect_uri=$redirect_uri&client_secret=$app_secret&code=$code";
$code_exchange = file_get_contents($url);

// {
//   "access_token":"",
//   "token_type":"",
//   "expires_in":
//  }

// If file_get_contents failed and did not got any response
if ($code_exchange === false) {
	register_error("There was an error with the login. Please try again");
	header("Location: {$cncl_url}");
	die();
}

$code_exchange = json_decode($code_exchange, true);
if(!array_key_exists('access_token', $code_exchange)) {
	register_error("No access token found. Please try again");
	header("Location: {$cncl_url}");
	die();
}

$access_token = $code_exchange['access_token'];

$url = "https://graph.facebook.com/$app_version/me/permissions/email?access_token=$access_token";
$perm_data = file_get_contents($url);

// If file_get_contents failed and did not got any response
if ($perm_data === false) {
	register_error("There was an error with the permissions. Please try again");
	header("Location: {$cncl_url}");
	die();
}

$perm_data = json_decode($perm_data, true);
if($perm_data['data'][0]['status'] != "granted") {
	// Re Requesting for the permission (email) as it was not allowed earlier
	$url = "https://www.facebook.com/$app_version/dialog/oauth?client_id={$app_id}&redirect_uri={$redirect_uri}&auth_type=rerequest&scope=email";
	header("Location: {$cncl_url}");
	die();
}

$url = "https://graph.facebook.com/$app_version/me?fields=id,name,email&access_token=$access_token";
$user_data = file_get_contents($url);

// If file_get_contents failed and did not got any response
if ($user_data === false) {
	register_error("No user data returned from facebook");
	header("Location: {$cncl_url}");
	die();
}

$user_data = json_decode($user_data, true);
$fbid = $user_data['id'];
$fbname = $user_data['name'];
$email = $user_data['email'];
$fbaccess_token = $access_token;

// Check if user exists with the email ID
$getUsers = get_user_by_email($email);
if ((int) $getUsers[0]->guid > 0) {
	// if exists then retrieved the user
	$user = get_user($getUsers[0]->guid);
	$user->name = $fbname;
	$user->validated = 1;
	$user->validated_method = 'facebook';
	$user->language = get_current_language();
	$user->save();
} else {
	// Check new registration allowed
	if (!facebook_login_allow_new_users_with_facebook()) {
		register_error(elgg_echo('registerdisabled'));
		header("Location: {$cncl_url}");
		die();
	}
	// If not exist then create a profile for the user with name and email id,
	$u = explode("@", $email);
	$username = $u[0];
	$usernameTmp = $username;

	$username = elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function() use ($username) {
		while (get_user_by_username($username)) {
			$username = $usernameTmp . '_' . rand(1000, 9999);
		}
		return $username;
	});

	$password = generate_random_cleartext_password();
	$uguid = register_user($username, $password, $fbname, $email);
	if ($uguid === false) {
		register_error(elgg_echo('registerbad'));
		header("Location: {$cncl_url}");
		die();
	} else {
		$user = get_user($uguid);
	  // Send mail to user
		fb_login_send_user_password_mail($email, $fbname, $username, $password);
	}
}

  // We have a registered user
  login($user, true);
  system_message(elgg_echo('facebook_login:login:success'));

  // then map id, accessToken
  $user->setPluginSetting('facebook_login', 'fbid', $fbid);
  $user->setPluginSetting('facebook_login', 'fbaccess_token', $fbaccess_token);
  // $user->setPluginSetting('facebook_login', 'fbname', $fbname);

  // also update the profile image of the user
  $url = "https://graph.facebook.com/$app_version/me/picture?type=large&redirect=false&access_token=$access_token";
  $picture_json = file_get_contents($url);

if ((int) $user->icontime < (time() - 31536000)) {
	// Dont change icon if updated within last 1 year
	if ($picture_json !== false) {
		$picture_json = json_decode($picture_json, true);
		$fb_pic_url = $picture_json['data']['url'];
		$picture = file_get_contents($fb_pic_url);
		
		$sizes = [
			'topbar' => [16, 16, true],
			'tiny' => [25, 25, true],
			'small' => [40, 40, true],
			'medium' => [100, 100, true],
			'large' => [200, 200, false],
			'master' => [550, 550, false],
		];
		$filehandler = new ElggFile();
		$filehandler->owner_guid = $user->getGUID();
		foreach ($sizes as $size => $dimensions) {
			$filehandler->setFilename("profile/$user->guid$size.jpg");
			$filehandler->open('write');
			$filehandler->write($picture);
			$filehandler->close();
		}
		$user->icontime = time();
		$user->save();
	}
}

header("Location: {$cncl_url}");
die();