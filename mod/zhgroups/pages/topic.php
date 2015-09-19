<?php
/*
 * Zhaohu index page
 */
$title = elgg_echo("zhaohu:home_page");
echo '<meta name="description" content="'.elgg_echo('zhaohu:home_des').'"/>';

$site_url = elgg_get_site_url();
$logo_url =  $site_url . "mod/zhaohu_theme/images/logo_hand.png";

$content = '<div class="zhaohu-zhaohu-about">';

$content .= '<div class="zhaohu-zhaohu-about-video">';
$content .= '<iframe width="560" height="315" src="//www.youtube.com/embed/x5L7KmGL6qg" frameborder="0" allowfullscreen></iframe>';
$content .= '</div></div>';

$vars = array(
	'content' => $content,
);

$body = elgg_view_layout('one_column', $vars);

echo elgg_view_page($title, $body);
