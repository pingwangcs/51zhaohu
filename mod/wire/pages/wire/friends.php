<?php
/**
 * Wire posts of your friends
 */

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('wire/all');
}

$title = elgg_echo('wire:friends');

elgg_push_breadcrumb(elgg_echo('wire'), "wire/all");
elgg_push_breadcrumb($owner->name, "wire/owner/$owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

if (elgg_get_logged_in_user_guid() == $owner->guid) {
	$form_vars = array('class' => 'wire-form');
	$content = elgg_view_form('wire/add', $form_vars);
	$content .= elgg_view('input/urlshortener');
}

$content .= list_user_friends_objects($owner->guid, 'wire', 15, false);

$body = elgg_view_layout('content', array(
	'filter_context' => 'friends',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
