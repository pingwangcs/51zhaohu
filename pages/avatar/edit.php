<?php
/**
 * Upload and crop an avatar page
 */

// Only logged in users
gatekeeper();

elgg_set_context('profile_edit');

$title = elgg_echo('avatar:edit');

$entity = elgg_get_page_owner_entity();
if (!elgg_instanceof($entity, 'user') || !$entity->canEdit()) {
	register_error(elgg_echo('avatar:noaccess'));
	forward(REFERER);
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

$content .= '<div id="zhaohu_profile_picture_edit">';
$content .= elgg_view('core/avatar/upload', array('entity' => $entity));

// only offer the crop view if an avatar has been uploaded
if (isset($entity->icontime)) {
	$content .= elgg_view('core/avatar/crop', array('entity' => $entity));
}
$content .= '</div></div>';

$params = array(
	'content' => $content,
	//'title' => $title,
);
$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);
