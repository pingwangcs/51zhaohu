<?php

gatekeeper();

$title = elgg_echo("zhaohu:broadcast:title");

$guid = (int) get_input("guid");
$zhaohu = false;

if(!empty($guid) && ($entity = get_entity($guid))){
	if(($entity->getSubtype() == Zhaohu::SUBTYPE) && $entity->canEdit())	{
		$zhaohu = $entity;

		elgg_set_page_owner_guid($zhaohu->container_guid);
	}
	else{
		register_error(elgg_echo('zhaohu:broadcast:error') . elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError ,zhaohu:broadcast, user has no permission to zhaohu, zhaohu_id $guid , user_id "
			.elgg_get_logged_in_user_guid(), "ERROR");
		forward($entity->getURL());
	}	
}
else {
	register_error(elgg_echo('zhaohu:broadcast:error') . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError ,zhaohu:broadcast, invalid zhaohu, zhaohu_id $guid , user_id "
		.elgg_get_logged_in_user_guid(), "ERROR");
	forward();
}

$group = get_entity($zhaohu->container_guid);
	
if ( empty($group) || !($group instanceof ElggGroup) ) {
	register_error(elgg_echo('zhaohu:broadcast:error') . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError ,zhaohu:broadcast, invalid zhaohu, zhaohu_id $guid , user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward();
}

$content = elgg_view_form('zhaohu/broadcast');

$body = elgg_view('zhgroups/group_header', array("group" => $group));

$body .= elgg_view('zhgroups/inGroupContent', array(
		'filter' => false,
		'content' => $content,
		'title' => $title,
		'group' => $group));


// $body = elgg_view_layout('content', array(
// 	'content' => $content,
// 	'title' => $title,
// 	'filter' => '',
// ));

echo elgg_view_page($title, $body);
