<?php
require_once __DIR__ . "/lib/functions.php";

return [
	'plugin' => [
		'name' => 'Facebook Login',
		'version' => '5.0',
		'dependencies' => [],
	],
	'bootstrap' => FacebookLogin::class,
	'views' => [
		'default' => [
			'facebook_login/' => __DIR__ . '/graphics',
		],
	],
	'routes' => [
		'collection:object:facebook_login:login' => [
			'path' => '/facebook_login/login',
			'resource' => 'facebook_login/login',
			'walled' => false,
		],
		'collection:object:facebook_login:connect' => [
			'path' => '/facebook_login/connect',
			'resource' => 'facebook_login/connect',
			'walled' => false,
		],
		'collection:object:facebook_login:revoke' => [
			'path' => '/facebook_login/revoke',
			'resource' => 'facebook_login/revoke',
		],
	],
];
