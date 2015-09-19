<?php 
$guid = (int) get_input("guid");

if(!empty($guid) && $zhaohu = get_entity($guid)){
	if($zhaohu->getSubtype() == Zhaohu::SUBTYPE){

		if(empty($zhaohu->start_day))
		{
			register_error(elgg_echo("zhaohu:edit:start_day_empty"));
			forward(REFERER);
		}
		if(empty($zhaohu->end_ts))
		{
			register_error(elgg_echo("zhaohu:edit:end_day_empty"));
			forward(REFERER);
		}
		if(empty($zhaohu->description))
		{
			register_error(elgg_echo("zhaohu:edit:description_empty"));
			forward(REFERER);
		}
		if(empty($zhaohu->tags)){
			register_error(elgg_echo("zhaohu:edit:tags_empty"));
			forward(REFERER);
		}
		if(empty($zhaohu->country))
		{
			register_error(elgg_echo("zhaohu:edit:country_empty"));
			forward(REFERER);
		}
		if(empty($zhaohu->state))
		{
			register_error(elgg_echo("zhaohu:edit:state_empty"));
			forward(REFERER);
		}
		if(empty($zhaohu->city))
		{
			register_error(elgg_echo("zhaohu:edit:city_empty"));
			forward(REFERER);
		}
// 		if(empty($zhaohu->address))
// 		{
// 			register_error(elgg_echo("zhaohu:edit:address_empty"));
// 			forward(REFERER);
// 		}
// 		if($zhaohu->isPast()){
// 			register_error(elgg_echo("zhaohu:publish:past"));
// 			forward(REFERER);
// 		}
		$zhaohu->access_id = $zhaohu->future_access;
		$old_status = $zhaohu->status;
		$zhaohu->status = 'published';
		$zhaohu->save();
		if ($old_status == 'draft') {
			add_to_river('river/object/zhaohu/create', 'create', elgg_get_logged_in_user_guid(), $zhaohu->getGUID());
		}
		//zhaohuPubedNotify($zhaohu);
		sendEventDigestPerGroup($zhaohu->container_guid);
		//system_message(elgg_echo("zhaohu:publish:ok"));
		forward(REFERER);
	}
}

register_error(elgg_echo("zhaohu:publish:error") . elgg_echo("zhaohu:sorry"));
elgg_log("ZHError ,zhaohu:publish, invalid zhaohu, zhaohu_id $guid, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
forward(REFERER);