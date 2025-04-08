<?php
echo elgg_view_field([
	'#type'=> 'text',
	'#label' => elgg_echo('facebook_login:app_id'),
	'name' => 'params[app_id]',
	'value' => $vars['entity']->app_id,
	'class' => 'text_input',
]);

echo elgg_view_field([
	'#type'=> 'text',
	'#label' => elgg_echo('facebook_login:app_secret'),
	'name' => 'params[app_secret]',
	'value' => $vars['entity']->app_secret,
	'class' => 'text_input',
]);

echo elgg_view_field([
	'#type'=> 'text',
	'#label' => elgg_echo('facebook_login:default_graph_version'),
	'name' => 'params[default_graph_version]',
	'value' => $vars['entity']->default_graph_version,
	'class' => 'text_input',
]);

echo elgg_view_field([
	'#type'=> 'dropdown',
	'#label' => elgg_echo('facebook_login:login'),
	'name' => 'params[sign_on]',
	'options_values' => [
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no'),
	],
	'value' => $vars['entity']->sign_on ? $vars['entity']->sign_on : 'yes',
]);

echo elgg_view_field([
	'#type'=> 'dropdown',
	'#label' => elgg_echo('facebook_login:new_users'),
	'name' => 'params[new_users]',
	'options_values' => [
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no'),
	],
	'value' => $vars['entity']->new_users ? $vars['entity']->new_users : 'no',
]);