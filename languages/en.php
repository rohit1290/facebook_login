<?php
/**
 * An english language definition file
 */

return array(
	'facebook_login' => 'Facebook Services',

	'facebook_login:requires_oauth' => 'Facebook Services requires the OAuth Libraries plugin to be enabled.',

	'facebook_login:app_id' => 'Facebook Application Id',
	'facebook_login:app_secret' => 'Facebook Application Secret Code',
	'facebook_login:default_graph_version' => 'Facebook Default Graph Version',
	'facebook_login:permissions' => 'Facebook Permissions',

	'facebook_login:settings:instructions' => 'You must obtain a client id and secret from <a href="http://www.facebook.com/developers/" target="_blank">Facebook</a>. Most of the fields are self explanatory, the one piece of data you will need is the callback url which takes the form http://[yoursite]/action/facebooklogin/return - [yoursite] is the url of your Elgg network.',

	'facebook_login:usersettings:description' => "Link your %s account with Facebook.",
	'facebook_login:usersettings:request' => "You must first <a href=\"%s\">authorize</a> %s to access your Facebook account.",
	'facebook_login:usersettings:logout_required' => 'You must first authorize %s to access your Facebook account. Request you to kindly logout and login agian usinng the facebook login button.',
	'facebook_login:authorize:error' => 'Unable to authorize Facebook.',
	'facebook_login:authorize:success' => 'Facebook access has been authorized.',

	'facebook_login:usersettings:authorized' => "You have authorized %s to access your Facebook account: @%s.",
	'facebook_login:usersettings:revoke' => 'Click <a href="%s">here</a> to revoke access.',
	'facebook_login:revoke:success' => 'Facebook access has been revoked.',

	'facebook_login:login' => 'Allow existing users who have connected their Facebook account to sign in with Facebook?',
	'facebook_login:new_users' => 'Allow new users to sign up using their Facebook account even if manual registration is disabled?',
	'facebook_login:login:success' => 'You have been logged in.',
	'facebook_login:login:error' => 'Unable to login with Facebook.',
	'facebook_login:login:email' => "You must enter a valid email address for your new %s account.",
	'facebook_login:email:subject' => '%s registration successful',
	'facebook_login:email:body' => '
Hi %s,

Congratulations! You have been successfully registered. Please visit our network here on %s %s.

Your login details are-

Username is %s
Email is %s
Password is %s

You can login using either email id or username.

%s
%s'
	
);
