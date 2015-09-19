<?php

	$widget = $vars["entity"];
	
	$num_display = (int) $widget->num_display;
	if($num_display < 1){
		$num_display = 5;
	}
	$zhaohu_options = array("limit" => $num_display);
	
	$owner = $widget->getOwnerEntity();
	
	switch($owner->getType()){
		case "group":
			$zhaohu_options["container_guid"] = $owner->getGUID();
			break;
		case "user":
			switch($widget->type_to_show){
				case "owning":
					$zhaohu_options["owning"] = true;
					$zhaohu_options["user_guid"] = elgg_get_logged_in_user_guid();
					break;
				case "attending":
					$zhaohu_options["meattending"] = true;
					$zhaohu_options["user_guid"] = elgg_get_logged_in_user_guid();
					break;
			}
			break;
	}
	
	$zhaohus = zhaohu_manager_find_zhaohus($zhaohu_options);
	$content = elgg_view_entity_list($zhaohus['entities'], array("count" => $zhaohus["count"], "offset" => 0, "limit" => $num_display, "pagination" => false, "full_view" => false));	
	
	if(empty($content)){
		$content = elgg_echo("notfound");
	}
	
	if($user = elgg_get_logged_in_user_entity()){
		if($owner instanceof ElggGroup){
			//if((($who_create_group_zhaohus == "group_admin") && $owner->canEdit()) || (($who_create_group_zhaohus == "members") && $owner->isMember($user))){
			if($owner->canEdit())
				$add_link = "/zhaohus/zhaohu/new/" . $owner->getGUID();
			}
		}		
		if($add_link){
			$content .= "<div>" . elgg_view("output/url", array("text" => elgg_echo("zhaohu:new"), "href" => $add_link)) . "</div>";
		}
	}
	
	echo $content;