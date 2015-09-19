<?php
	
	$guid = get_input("guid");
	
	if(!empty($guid) && ($entity = get_entity($guid))){
		if($entity->getSubtype() == Zhaohu::SUBTYPE) {
			$zhaohu = $entity;
		}
	}
	
	if($zhaohu){

		// add export button		
		elgg_load_js("addthisevent.base");
		//
		elgg_set_page_owner_guid($zhaohu->getContainerGUID());
	
		$title_text = $zhaohu->title;
		
		// render zhaohu page middle div
		$content = elgg_view_entity($zhaohu, array("full_view" => true));
		
		$sidebar = elgg_view("zhaohu_manager/zhaohu/sidebar", array("entity" => $zhaohu));
		/*$body = elgg_view_layout('content', array(
			'filter' => '',
			'content' => $output,
			'title' => $title_text,
			'sidebar' => $sidebar
		));*/
		$group = get_entity($zhaohu->container_guid);
		$params = array(
				'content' => $content,
				'filter' => '',
				'group' => $group,
				'sidebar' => $sidebar,
				'sidebar_class' => 'zhaohu-right-sidebar'
		);
		// render zhaohu page left div with middle div
		$body = elgg_view('zhgroups/inGroupContent', $params);
		// Add group header div on top of left bar and middle div
		$page_body = elgg_view('zhgroups/group_header', array("group" => $group)) . $body;
		
		echo elgg_view_page($title_text, $page_body);		
	} else {
		register_error(elgg_echo("zhaohu:view:error") . elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError ,zhaohu:view, invalid zhaohu, zhaohu_id $guid, user_id "
			.elgg_get_logged_in_user_guid(), "ERROR");		
		forward(REFERER);
	}