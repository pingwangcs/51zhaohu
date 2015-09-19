<?php
/**
 * Edit profile page
 */

gatekeeper();

$user = elgg_get_page_owner_entity();
if (!$user) {
	register_error(elgg_echo("profile:notfound"));
	forward();
}

// check if logged in user can edit this profile
if (!$user->canEdit()) {
	register_error(elgg_echo("profile:noaccess"));
	forward();
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

$content .= '<div id="zhaohu_profile_edit">';

elgg_set_context('profile_edit');

$title = elgg_echo('profile:edit');

$content .= elgg_view_form('profile/edit', array(), array('entity' => $user));

$params = array(
	'content' => $content,
);

$content .= '</div></div>';

$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);
