<?php 
$guid = (int) get_input("guid");

if(!empty($guid) && $entity = get_entity($guid)) {
	if($entity->getSubtype() == Zhaohu::SUBTYPE) {
		$groupID = $entity->container_guid;
		if($groupID) {
			$group = get_entity($groupID);
			if($group instanceof ElggGroup) {
				$entity->delete();
				forward($group->getURL());
			}
		}
	}
}

register_error(elgg_echo("zhaohu:delete:error") . elgg_echo("zhaohu:sorry"));
elgg_log("ZHError ,zhaohu:delete, invalid zhaohu, zhaohu_id $guid, user_id "
.elgg_get_logged_in_user_guid(), "ERROR");
forward(REFERER);