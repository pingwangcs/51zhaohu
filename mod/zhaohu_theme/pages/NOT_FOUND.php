<?php
/*
 * Zhaohu NOT found page
*/

$title = elgg_echo("zhaohu:not_found");
$content = "NOT FOUND";

$vars = array(
		'content' => $content,
);

$body = elgg_view_layout('one_sidebar', $vars);

echo elgg_view_page($title, $body);