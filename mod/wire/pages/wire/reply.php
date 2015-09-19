<?php
/**
 * Reply page
 * 
 */

gatekeeper();

$post = get_entity(get_input('guid'));

$title = elgg_echo('wire:reply');

elgg_push_breadcrumb(elgg_echo('wire'), 'wire/all');
elgg_push_breadcrumb($title);

$content = elgg_view('wire/reply', array('post' => $post));
$form_vars = array('class' => 'wire-form');
$content .= elgg_view_form('wire/add', $form_vars, array('post_guid' => $post->guid));
$content .= elgg_view('input/urlshortener');


$body = elgg_view_layout('content', array(
	'filter' => false,
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
