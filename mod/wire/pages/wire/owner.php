<?php
/**
 * User's wire posts
 * 
 */

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('wire/all');
}

$title = elgg_echo('wire:user', array($owner->name));

elgg_push_breadcrumb(elgg_echo('wire'), "wire/all");
elgg_push_breadcrumb($owner->name);

$context = '';
// cannot add new post, since the post needs to be tied to another entity (e.g. event)
// if (elgg_get_logged_in_user_guid() == $owner->guid) {
// 	$form_vars = array('class' => 'wire-form');
// 	$content = elgg_view_form('wire/add', $form_vars);
// 	$content .= elgg_view('input/urlshortener');
// 	$context = 'mine';
// }

$content .= elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'wire',
	'owner_guid' => $owner->guid,
	'limit' => WIRE_POST_LIMIT,
));

$body = elgg_view_layout('one_column', array(
	//'filter_context' => $context,
	'content' => $content,
	'title' => $title,
	//'sidebar' => elgg_view('wire/sidebar'),
));

echo elgg_view_page($title, $body);
