<?php
/*
 * Zhaohu index page
 */

$title = elgg_echo("zhaohu:home_page");
// echo '<meta name="description" content="'.elgg_echo('zhaohu:home_des').'"/>';
if(elgg_is_logged_in()) #when logged in
{
	$viewer = elgg_get_logged_in_user_entity();
	$user_welcome_div = elgg_view("zhaohu_views/zhaohu_user_welcome", array('user' => $viewer)); 
	$find_form_div = elgg_view('groups/findForm');
	$vars = array('content' => $user_welcome_div . $find_form_div);
}
else{
	$highlight_div = elgg_view("zhaohu_views/zhaohu_highlight"); 
	$find_form_div = elgg_view('groups/findForm');
	$vars = array('content' => $highlight_div . $find_form_div);
}

$body = elgg_view_layout('home_page', $vars);

echo elgg_view_page($title, $body);