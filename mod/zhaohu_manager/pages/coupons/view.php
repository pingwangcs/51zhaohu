<?php
// this is for letting a user view coupons in his/her profile
// Only logged in users
gatekeeper();

elgg_set_context('profile_edit');

$title = elgg_echo('coupon:user:title');

$entity = elgg_get_page_owner_entity();

if (!elgg_instanceof($entity, 'user') || !$entity->canEdit()) {
	register_error(elgg_echo('coupon:nopermission'));
	forward(REFERER);
}

$content = '<div class="zhaohu-profile">';

// render owner block
$content .= elgg_view('profile/owner_block');

$content .= '<div id="zhaohu_profile_picture_edit">';

$options = array (
		'user_guid' => $entity->guid,
		'offset' => 0,
		'limit' => ZHAOHU_MANAGER_SEARCH_LIST_LIMIT,
);
$res = zh_find_coupons($options);
$entities = $res["entities"];
$count =$res["count"];

if ($count) {
	$content .= elgg_view ( "coupons/view", array (
			"entities" => $entities,
			"count" => $count,
			"isUserProfile" => true,
	) );
} else {
	$content .= elgg_echo('coupon:noresults');
}

$content .= '</div></div>';

$params = array(
	'content' => $content,
	//'title' => $title,
);
$body = elgg_view_layout('one_column', $params);
echo elgg_view_page($title, $body);
