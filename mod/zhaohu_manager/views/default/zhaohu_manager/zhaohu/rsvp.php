<?php 

	$zhaohu = $vars["entity"];
	
	if($zhaohu->openForRegistration()){
		$user_relation = $zhaohu->getRelationshipByUser();
		
		if ($user_relation == ZHAOHU_MANAGER_RELATION_ATTENDING) {
			$rel=ZHAOHU_MANAGER_RELATION_UNDO;				
		}
		else{
			$rel=ZHAOHU_MANAGER_RELATION_ATTENDING;
		}
		echo elgg_view("output/url", array(
				"is_action" => true,
			  	"class" => "zhaohu-join-button",
			  	"href" => "action/zhaohu_manager/zhaohu/rsvp?guid=" . $zhaohu->getGUID() . "&type=" . $rel,
				"text" => elgg_echo('zhaohu:relationship:' . $rel))
		);
		$href = "zhaohus/zhaohu/invite?guid=" . $zhaohu->getGUID();
		echo elgg_view("output/url",
				array('class' => 'zhaohu-invite-button',
						"href" => $href,
						"text" => elgg_echo('zhaohu:invite')));
	}