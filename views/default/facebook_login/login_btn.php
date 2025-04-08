<?php
$divider = elgg_format_element('div', [
  'style' => 'display: flex; align-items: center; text-align: center; margin: 20px 0;',
],
elgg_format_element('hr', [
  'style' => 'flex: 1; border: none; border-top: 1px solid #ccc;',
  ]) .
  elgg_format_element('span', [
    'style' => 'padding: 0 10px; color: #999;',
  ], 'or') .
  elgg_format_element('hr', [
    'style' => 'flex: 1; border: none; border-top: 1px solid #ccc;',
  ])
);

$loginbtn = elgg_view('output/url', [
  'href' => elgg_normalize_url('facebook_login/connect'),
  'text' => elgg_view('output/img', [
    'src' => elgg_get_simplecache_url('fb/login.png'),
    'alt' => "Facebook Login",
    'width' => "100%",
    'style' => "padding-bottom: 30px"
  ]),
  'is_trusted' => true,
]);

echo elgg_format_element('div', [
  'class' => 'elgg-form-login',
], $divider . $loginbtn);


?>