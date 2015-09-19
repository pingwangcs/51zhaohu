<?php
/**
 * zhaohu user welcome message view, the div contain user welcome message
 * @uses string $vars['user_name'] the current logged in user name
 */

$user_name = $vars['user_name'];

$hello_string = '<div id="zhaohu_user_welcome_hello">' . $user_name . ', ' . elgg_echo("zhaohu:hello") . ' :) </div>';

$site_url = elgg_get_site_url();
$help_link_url = $site_url . "zhaohu_about/help_center";
$help_link = elgg_view('output/url', array('text' => elgg_echo('zhaohu:help_string'),
										   'href' => $help_link_url,
										   'class' => 'zhaohu-help-link'));

$welcome_message = '<div id="zhaohu_user_welcome_message">'. elgg_echo("zhaohu:welcome_message") . $help_link . '</div>';

echo '<div id="zhaohu_user_welcome_message_div">' . $hello_string . $welcome_message . '</div>';