<?php
	
	$guid = get_input("guid");
	
	if(!empty($guid) && ($entity = get_entity($guid))){
		if($entity->getSubtype() == Zhaohu::SUBTYPE) {
			$zhaohu = $entity;
		}
	}
	
	if($zhaohu){
		elgg_set_page_owner_guid($zhaohu->getContainerGUID());
	
		$title_text = $zhaohu->title;
		
		// render zhaohu content
		$content = elgg_view_entity($zhaohu, array("full_view" => true));
		
		echo elgg_view_page($title_text, $content);		
	} else {
		register_error(elgg_echo("zhaohu:view:error") . elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError ,zhaohu:view, invalid zhaohu, zhaohu_id $guid, user_id "
			.elgg_get_logged_in_user_guid(), "ERROR");		
		forward(REFERER);
	}