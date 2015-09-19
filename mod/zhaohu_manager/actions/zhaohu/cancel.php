<?php 
$guid = (int) get_input("guid");

if(!empty($guid) && $entity = get_entity($guid)){
	if($entity->getSubtype() == Zhaohu::SUBTYPE)	{
		$zhaohu = $entity;
		$zhaohu->status = 'cancelled';
		system_message(elgg_echo("zhaohu:cancel:ok"));
		forward(REFERER);
	}
}

register_error(elgg_echo("zhaohu:cancel:error") . elgg_echo("zhaohu:sorry"));
elgg_log("ZHError ,zhaohu:cancel, invalid zhaohu, zhaohu_id $guid, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
forward(REFERER);