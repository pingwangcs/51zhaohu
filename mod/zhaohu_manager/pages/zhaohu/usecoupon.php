<?php
group_gatekeeper();

$guid = (int) get_input("guid");
$zhaohu = false;

if(empty($guid)){
	register_error(elgg_echo('coupon:use:err') . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError ,coupon:use, empty guid, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward();
}

$zhaohu = get_entity($guid);
if(!$zhaohu || $zhaohu->getSubtype() != Zhaohu::SUBTYPE) {
	register_error(elgg_echo('coupon:use:err') . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError ,coupon:use, invalide zhaohu, zhaohu_id $guid, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward();	
}
if(!$zhaohu->canEdit()) {
	register_error(elgg_echo('coupon:use:err') . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError ,coupon:use, no permission, zhaohu_id $guid, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward();
}
$title = elgg_echo("coupon:use:title", array($zhaohu->title));

$group = get_entity($zhaohu->container_guid);	
if ( empty($group) || !($group instanceof ElggGroup) ) {
	register_error(elgg_echo('coupon:use:err') . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError ,coupon:use, invalid group, zhaohu_id $guid , user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward();
}
elgg_set_page_owner_guid($zhaohu->container_guid);

$content = elgg_view_form('coupon/use');

$body = elgg_view('zhgroups/group_header', array("group" => $group));

$body .= elgg_view('zhgroups/inGroupContent', array(
		'filter' => false,
		'content' => $content,
		'title' => $title,
		'group' => $group));


echo elgg_view_page($title, $body);
