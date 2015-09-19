<?php
/*
 * Zhaohu friend links page
 */

$title = elgg_echo("zhaohu:friend_links");

$content = '<div class="zhaohu-zhaohu-about">';
$content .= '<p><a href="http://www.hhlink.com" target="_blank"><img src="http://www.hhlink.com/hhLink/hh88x31.gif" width="88px" border=0 /></a></p>';
$content .= '<p><a href="http://www.ctrip.com" target="_blank"><img src="http://pages.ctrip.com/public/link/images/0702-1.jpg" width="88px" border="0" /></a> </p>';
$content .= '</div>';

$vars = array(
	'content' => $content,
);

$body = elgg_view_layout('one_column', $vars);

echo elgg_view_page($title, $body);