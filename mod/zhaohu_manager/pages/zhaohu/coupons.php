<?php
group_gatekeeper();

$zhaohu_guid = get_input ("guid");

$zhaohu = get_entity($zhaohu_guid);
$group = $zhaohu->getContainerEntity();
if(empty($group) || !($group instanceof ElggGroup)){
	register_error(elgg_echo("coupon:view:err"). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError ,coupon:view, invalid group, zhaohu_id {$zhaohu_guid}, logged_user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}
elgg_set_page_owner_guid($zhaohu->container_guid);

if (!elgg_is_admin_logged_in()) {//!$group->canEdit()
	register_error(elgg_echo('coupon:nopermission'));
	forward(REFERER);
}

$name = elgg_echo('coupon:view:name', array($zhaohu->getURL(), $zhaohu->title));
$title = elgg_echo('coupon:view:title', array($zhaohu->title));

$options = array (
		"event_guid" => $zhaohu_guid,
		'offset' => 0,
		'limit' => ZHAOHU_MANAGER_SEARCH_LIST_LIMIT,
);
$res = zh_find_coupons($options);

$entities = $res["entities"];
$count =$res["count"];
//fordebug register_error ( 'count' . $count );

if ($count) {
	$content .= elgg_view ( "coupons/view", array (
			"entities" => $entities,
			"count" => $count,
	) );
}

$params = array(
		'content' => $content,
		'title' => $name,
		'filter' => '',
		'group' => $group,
);
$body = elgg_view('zhgroups/inGroupContent', $params);

$content = elgg_view('zhgroups/group_header', array("group" => $group)) . $body;
echo elgg_view_page($title, $content);