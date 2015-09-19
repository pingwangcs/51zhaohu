<?php

function zhaohu_manager_entity_menu($hook, $entity_type, $returnvalue, $params){
	$result = $returnvalue;

	if (elgg_in_context("widgets")) {
		return $result;
	}

	if (($entity = elgg_extract("entity", $params)) && elgg_instanceof($entity, "object", Zhaohu::SUBTYPE)) {
		$attendee_menu_options = array(
				"name" => "attendee_count",
				"priority" => 50,
				"text" => elgg_echo("zhaohu:attending:entity_menu", array($entity->countAttendees())),
				"href" => false
		);

		$result[] = ElggMenuItem::factory($attendee_menu_options);

		// change some of the basic menus
		if (!empty($result) && is_array($result)) {
			foreach ($result as &$item) {
				switch ($item->getName()) {
					case "edit":
						$item->setHref("zhaohus/zhaohu/edit/" . $entity->getGUID());
						break;						
					case "delete":
						$href = elgg_get_site_url() . "action/zhaohu_manager/zhaohu/delete?guid=" . $entity->getGUID();
						$href = elgg_add_action_tokens_to_url($href);

						$item->setHref($href);
						$item->setConfirmText(elgg_echo("deleteconfirm"));
						break;
				}
			}
		}
		
		$status_text = elgg_echo("zhaohu:status:{$entity->status}");
		$status_mi = array(
				'name' => 'status',
				'text' => "<span>$status_text</span>",
				'href' => false,
				'priority' => 50,
		);
		$result[] = ElggMenuItem::factory($status_mi);
		
		if($entity->status == 'published')
		{
			$cancel_href = elgg_get_site_url() . "action/zhaohu_manager/zhaohu/cancel?guid=" . $entity->getGUID();
			$cancel_href = elgg_add_action_tokens_to_url($cancel_href);
			$cancel_mi = array(
					'name' => 'cancel',
					'text' => elgg_echo('cancel'),
					'href' => $cancel_href,
					'confirm'=>elgg_echo('zhaohu:cancelwarning'),
					'priority' => 200,
			);
			$result[] = ElggMenuItem::factory($cancel_mi);			
		}
	}

	return $result;
}

/**
 * Generates correct title link for widgets depending on the context
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $returnvalue
 * @param unknown_type $params
 * @return optional new link
 */
function zhaohu_manager_widget_zhaohus_url($hook, $entity_type, $returnvalue, $params){
	$result = $returnvalue;
	$widget = $params["entity"];

	if(empty($result) && ($widget instanceof ElggWidget) && $widget->handler == "zhaohus"){
		switch($widget->context){
			case "index":
				$result = "/zhaohus";
				break;
			case "groups":
				$result = "/zhaohus/zhaohu/list/" . $widget->getOwnerGUID();
				break;
			case "profile":
			case "dashboard":
				break;
		}
	}
	return $result;
}
