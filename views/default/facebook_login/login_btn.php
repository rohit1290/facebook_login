<?php
$img = elgg_view('output/img', [
	'src' => elgg_get_simplecache_url('facebook_login/facebook_login.png'),
	'alt' => "Facebook Login",
  'width' => "70%",
  'style' => "display:block;margin:auto;"
]);

$params = [
		'href' => elgg_normalize_url('facebook_login/connect'),
		'text' => $img,
		'is_trusted' => true,
	];

echo elgg_view('output/url', $params);