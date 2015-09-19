<?php
/**
 * zhaohu user welcome view, the div contain user welcome message and near by zhaohu info
 * @uses user $vars['user'] the current logged in user
 */

$user = $vars['user'];


$zhaohu_user_welcome_message_div = elgg_view("zhaohu_views/zhaohu_user_welcome_message", array("user_name" => $user->name));
$zhaohu_user_welcome_summary_div = elgg_view("zhaohu_views/zhaohu_user_welcome_summary", array("user" => $user));


echo '<div id="zhaohu_user_welcome_div"><div id="zhaohu_user_welcome_content_div">' . $zhaohu_user_welcome_message_div . $zhaohu_user_welcome_summary_div . '</div></div>';
