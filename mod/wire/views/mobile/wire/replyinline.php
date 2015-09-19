<?php
$post = get_entity(get_input('guid'));

$poster = $post->getOwnerEntity();
$poster_details = array(htmlspecialchars($poster->name,  ENT_QUOTES, 'UTF-8'));
$content = elgg_echo('wire:replyto', $poster_details);
$form_vars = array('class' => 'wire-form');
$content .= elgg_view_form('wire/add', $form_vars, array('post_guid' => $post->guid));
$content .= elgg_view('input/urlshortener');
echo $content;