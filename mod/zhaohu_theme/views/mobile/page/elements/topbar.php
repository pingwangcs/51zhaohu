<?php
/**
 * Elgg mobile topbar
 * icon and slogan
 */

$site_url = elgg_get_site_url();
$logo_img ='<img src="' . $site_url . 'mod/zhaohu_theme/images/mobile_view_logo.png">';
$photo_wall_url = $site_url . 'photos/all';
$logo = '<div id="zhaohu_mobile_logo">' . elgg_view('output/url', array('href' => $site_url, 'text' => $logo_img)) . '</div>';
// $photo_wall = '<a href="' . $photo_wall_url . '" id="zhaohu_mobile_topbar_photo_wall">' . elgg_echo("zhaohu:photowall") . '</a>';

// login_box will show login button if user is not logged in, otherwise, it shows user avatar img, linking to user's profile page
if(elgg_is_logged_in()) #when logged in
{
	$viewer = elgg_get_logged_in_user_entity();
	$viewer_href = $viewer->getURL();
	$viewer_img = elgg_view('output/img', array(
		'src' => $viewer->getIconURL('small'),
		'alt' => $viewer->name,
		'title' => elgg_echo('profile'),
		'class' => 'zhaohu-mobile-topbar-profile',
		));
	$login_box = '<a href="'. $viewer_href . '" id="profile">' . $viewer_img . '</a>';
}
else # when not logged in
{
	$login_url = $site_url . 'login';
	$login_str = elgg_echo("login");
	$login_box = '<a href="' . $login_url . '" id="zhaohu_mobile_topbar_login">' . $login_str . '</a>';
}
echo '<div id="zhaohu_mobile_topbar" class="zhaohu-mobile-topbar">' . $logo . $photo_wall . $login_box . '</div>';