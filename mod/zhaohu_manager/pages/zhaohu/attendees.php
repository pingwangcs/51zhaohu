<?php
	
$guid = get_input("guid");
$offset = get_input ( "offset", 0 );
$count = get_input("count");
if(!empty($guid) && ($entity = get_entity($guid))){
	if($entity->getSubtype() == Zhaohu::SUBTYPE) {
		$zhaohu = $entity;
	}
}
if(!$zhaohu){
	register_error(elgg_echo("zhaohu:attendee:error"). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError ,zhaohu:attendees, invaid zhaohu, zhaohu_id $guid, user_id "
		.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);	
}

elgg_set_page_owner_guid($zhaohu->getContainerGUID());
$page_title = elgg_echo('zhaohu:attendees:page_title', array($zhaohu->title));
$title = elgg_echo('zhaohu:attendees:title', array($zhaohu->getURL(), $zhaohu->title));

if($count==0)
{
	echo elgg_echo('zhaohu:noattendees');
	return;
}
$db_prefix = elgg_get_config('dbprefix');
$entities = elgg_get_entities_from_relationship(array(
		'relationship' => ZHAOHU_MANAGER_RELATION_ATTENDING,
		'relationship_guid' => $guid,
		'inverse_relationship' => FALSE,
		'limit' => ZHAOHU_MANAGER_ALL_ATTENDEE_LIMIT,
		'offset' => $offset,
		'joins' => array("JOIN {$db_prefix}users_entity u ON e.guid=u.guid"),
		'order_by' => 'u.name ASC',
));

if ($entities) {
	$content = elgg_view ( "zhaohu_manager/zhaohu/all_attendees", array (
			"entities" => $entities,
			"count" => $count,
			"offset" => $offset
	));
} else {
	register_error(elgg_echo("zhaohu:attendee:error"). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError ,zhaohu:attendees, error calling elgg_get_entities_from_relationship, zhaohu_id {$guid} , user_id " 
			. elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}

if(elgg_get_viewtype() == 'default'){
$group = get_entity($zhaohu->container_guid);
$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
		'group' => $group,
);
$body =  elgg_view('zhgroups/group_header', array("group" => $group)) 
		. elgg_view('zhgroups/inGroupContent', $params);

} else {
	$body = elgg_view_layout('one_column',
		array('content' => $content, 'title' => $title));
}

echo elgg_view_page($page_title, $body);
