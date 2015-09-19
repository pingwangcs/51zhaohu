<?php

$zhaohu = $vars["entity"];	
$result = "";
if (! $zhaohu instanceof Zhaohu) {
	register_error(elgg_echo("zhaohu:attendee:error"). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError ,zhaohu:attendees, invalid zhaohu, zhaohu $zhaohu->guid, user_id "
		.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}

$count = $zhaohu->countAttendees();
//fordebug system_message("count " . $count);
if($count==0)
{
	echo elgg_echo('zhaohu:noattendees');
	return;
}
$all_link = elgg_view('output/url', array(
		'href' => "/zhaohus/zhaohu/attendees/" . $zhaohu->guid ."/".$count,
		'text' => elgg_echo('link:view:all'),
));
$title = elgg_echo("zhaohu:attendees:sum", array($count)) . " (" . $all_link . ")";

$db_prefix = elgg_get_config('dbprefix');
$entities = elgg_get_entities_from_relationship(array(
		'relationship' => ZHAOHU_MANAGER_RELATION_ATTENDING,
		'relationship_guid' => $zhaohu->guid,
		'inverse_relationship' => FALSE,
		'limit' => ATTENDEE_IN_ZHAOHU_LIMIT,
		'offset' => 0,
		'joins' => array("JOIN {$db_prefix}users_entity u ON e.guid=u.guid"),
		'order_by' => 'u.name ASC',
));

if ($entities) {
	$options = array(
			"count" => $count,
			"offset" => 0,
			"limit" => ATTENDEE_IN_ZHAOHU_LIMIT,
			"full_view" => false,
			'list_type' => 'gallery',
			//'gallery_class' => 'zhaohu-gallery',
			"pagination" => false,
			"item_class" => "zhaohu-attendee-item",
			"size" => "small"
	);
	
	$list = elgg_view_entity_list($entities,$options);
// 	echo $list;
// 	return;
	if(!empty($list)){
		$result .= elgg_view_module("info", $title, $list, array("class" => "zhaohu-manager-zhaohu-view-attendees"));
		echo $result;
		return;
	}
}
register_error(elgg_echo("zhaohu:attendee:error"). elgg_echo("zhaohu:sorry"));
elgg_log("ZHError ,zhaohu:attendees, error calling elgg_get_entities_from_relationship, zhaohu_id {$zhaohu->guid}, user_id".
	elgg_get_logged_in_user_guid(), "ERROR");
forward(REFERER);

