<?php
/*
 * Zhaohu feedbacks page
 */

$title = elgg_echo("zhaohu:feedbacks");

$content = '<div class="zhaohu-zhaohu-about">feedbacks</div>';

$vars = array(
	'content' => $content,
);

$body = elgg_view_layout('one_column', $vars);

echo elgg_view_page($title, $body);