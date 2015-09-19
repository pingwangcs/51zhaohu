<?php
	if (!elgg_is_logged_in()) {
		register_error(elgg_echo('zhaohu:new:tologin'));
		forward(REFERER);
	}
	$logged_in_user = elgg_get_logged_in_user_entity();
	$title_text = elgg_echo("zhaohu:edit:title");

	$guid = get_input("guid");
	$zhaohu = false;

	if(!empty($guid) && ($entity = get_entity($guid))){
		if(($entity->getSubtype() == Zhaohu::SUBTYPE) && $entity->canEdit())	{
			$zhaohu = $entity;

			elgg_set_page_owner_guid($zhaohu->container_guid);
		}
		else if (!elgg_instanceof($entity, 'group')){
			register_error(elgg_echo('zhaohu:edit:error') . elgg_echo("zhaohu:sorry"));
			elgg_log("ZHError ,zhaohu:edit, invalid entity(can be zhaohu or group), guid $guid, user_id "
				.$logged_in_user->guid, "ERROR");
			forward(REFERER);
		}
	}	
	$page_owner = elgg_get_page_owner_entity();
	if(!$page_owner || !($page_owner instanceof ElggGroup)){
		// for now only support group zhaohu
		register_error(elgg_echo('zhaohu:edit:error') . elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError ,zhaohu:edit, page_owner is not group, zhaohu_id $guid, page_owner_id $page_owner->guid, user_id "
		.$logged_in_user->guid, "ERROR");
		forward(REFERER);		
	}
	$group = $page_owner;
	group_gatekeeper();
	if(!$group->isMember($logged_in_user)){
		register_error(elgg_echo('zhaohu:new:tojoin'));
		forward(REFERER);
	}
	
	//new zhaohu
	if (!$zhaohu) {
		$forward = true;
		$title_text = elgg_echo("zhaohu:new");
		//comment to let everyone new event
// 		if(!$page_owner->canEdit()){
// 			register_error(elgg_echo('zhaohu:edit:error') . elgg_echo("zhaohu:sorry"));
// 			elgg_log("ZHError ,zhaohu:edit, user has no permission, zhaohu_id $guid, group_id $page_owner->guid, user_id "
// 				.$logged_in_user->guid, "ERROR");
// 			forward(REFERER);
// 		}
	}
	
	$form = elgg_view("zhaohu_manager/forms/zhaohu/edit", array("entity" => $zhaohu));

	$params = array(
			"content" => $form,
			"title" => $title_text,
			"filter" => "",
			'group' => $group
	);
	
	$body = elgg_view('zhgroups/inGroupContent', $params);
	
	$content = elgg_view('zhgroups/group_header', array("group" => $group)) . $body;
	echo elgg_view_page($title_text, $content);
