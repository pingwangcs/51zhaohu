<?php
/*
 * Zhaohu function introduction page
 */

$title = elgg_echo("zhaohu:function_introduction");

$content = '<div class="zhaohu-zhaohu-about">Under construction</div>';
$vars = array(
	'content' => $content,
);

$body = elgg_view_layout('one_column', $vars);

echo elgg_view_page($title, $body);