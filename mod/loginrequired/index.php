<?php
/**
 * Elgg custom index page
 * 
 */

$site_url = elgg_get_site_url();
$logo_url =  $site_url . "mod/loginrequired/graphics/red_cross.png";

$title = elgg_echo("zhaohu:maintenance");
$maintenance_str = "<div class=\"maintenance-string\">" . elgg_echo("zhaohu:maintenance") . "</div>";
$image = "<img src=\"$logo_url\" class=\"maintenance-image\" />";

$content = '<div class="maintenance-content">' . $image . $maintenance_str . '</div>';



$vars = array(
		'content' => $content,
);

$body = elgg_view_layout('one_column', $vars);

echo elgg_view_page($title, $body);
