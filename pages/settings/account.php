<?php
/**
 * Elgg user account settings.
 *
 * @package Elgg
 * @subpackage Core
 */

// Only logged in users
gatekeeper();

// Make sure we don't open a security hole ...
if ((!elgg_get_page_owner_entity()) || (!elgg_get_page_owner_entity()->canEdit())) {
	register_error(elgg_echo('noaccess'));
	forward('/');
}

$content = '<div class="zhaohu-profile">';

// render owner block
if(elgg_get_viewtype() == 'mobile'){
	$content .=elgg_view("output/url", array("href" => "profile/$user->username",
			"class" => "profile-home-mobile",
			"text" => elgg_echo('profile:home_mobile')));
} else{
	$content .= elgg_view('profile/owner_block');
}

$content .= '<div id="zhaohu_profile_settings">';

$title = elgg_echo('usersettings:user');

$content .= elgg_view('core/settings/account');

$params = array(
	'content' => $content
);
$body = elgg_view_layout('one_column', $params);

$content .= "</div></div>";

echo elgg_view_page($title, $body);
