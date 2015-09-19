<?php

function zhaohu_guid_only_callback($row) {
	return (int) $row->guid;
}

function pickZhaohuIcon($entity){
	$icons = elgg_get_config('myicon_zhaohu');
	$idx =  ($entity->guid) % elgg_get_config('myicon_zhaohu_count');
	return $icons[$idx];
}

function genTagDiv($divId, $liClass) {
 	$iDD = "<ul id='".$divId."' class='zht_dd zht_dd_tag_position'><li><ul><li>"; //zhaohu group edit interests dropdown
	$tagNo = 0;
	foreach (elgg_get_config('zhtags') as $t) {
		if($tagNo==9) {
			$iDD .= "</ul></li><li><ul>";
			$tagNo = 0;
		}
		$iDD .= "<li>" . elgg_view("output/url", array("href" => "#", "text" => elgg_echo($t), "class"=>$liClass)) . "</li>";
		$tagNo++;
	}
	$iDD .= "</ul></li></ul>";
	return $iDD;
}

function useQrCoupon() {
	$res = useQrCouponImpl();
	if($res){
		$zhaohu_guid = (int) get_input("guid");
		$zhaohu = get_entity($zhaohu_guid);
		$url = $zhaohu->getURL();
	} else {
		$url = elgg_get_site_url();
	}
	forward($url);
}

function useQrCouponImpl() {
	$zhaohu_guid = (int) get_input("guid");
	$code = get_input("code");

	if(empty($code)){
		register_error(elgg_echo("coupon:use:empty:code"). elgg_echo("zhaohu:sorry"));
		return false;
	}
	if(empty($zhaohu_guid)){
		register_error(elgg_echo("coupon:use:err"). elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError ,coupon:use, empty zhaohu_guid, logged_user_id "
			.elgg_get_logged_in_user_guid(), "ERROR");
		return false;
	}
	$zhaohu = get_entity($zhaohu_guid);
	if(!($zhaohu->getSubtype() == Zhaohu::SUBTYPE)) {
		elgg_log("ZHError ,coupon:use, invalid zhaohu, zhaohu_id {$zhaohu_guid} , user_id {$user_guid}, logged_user_id "
		.elgg_get_logged_in_user_guid(), "ERROR");
		return false;
	}
	$group = $zhaohu->getContainerEntity();
	if(empty($group) || !($group instanceof ElggGroup)){
		register_error(elgg_echo("coupon:use:error"). elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError ,coupon:use, invalid group, zhaohu_id {$guid} , user_id {$user_guid}, logged_user_id "
		.elgg_get_logged_in_user_guid(), "ERROR");
		return false;
	}
	
	// allow anyone to use coupon
// 	if (!$group->canEdit()){
// 		register_error(elgg_echo("coupon:nopermission"));
// 		elgg_log("ZHError ,coupon:use, not admin, coupon_guid {$coupon_guid}, logged_user_id "
// 		.elgg_get_logged_in_user_guid(), "ERROR");
// 		return false;
// 	}
		if($zhaohu->isCouponExpired()){
			register_error(elgg_echo("coupon:expired"));
			return false;
		}

	$options = array (
			'event_guid' => $zhaohu_guid,
			'code' => $code,
			'offset' => 0,
			'limit' => 0,
	);

	$res = zh_find_coupons($options);
	if($res['count']!=1){
		register_error(elgg_echo("coupon:notfound"). elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError ,coupon:use, invalid coupon, coupon_guid {$coupon_guid}", "ERROR");
		return false;
	}
	$coupon = $res['entities']['0'];
	
	$coupon->useCoupon();
	system_message(elgg_echo("coupon:use:ok"));
	return true;
}

function genCoupons($zhaohu) {
	if(!elgg_is_admin_logged_in()){
		register_error(elgg_echo("coupon:nopermission") . elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError ,coupons::gen, user has no permission, user_id "
				.elgg_get_logged_in_user_guid(), "ERROR");
				return false;
	}
// 	if(!$zhaohu->isPast()){
// 		system_message(elgg_echo("coupon:notdue"));
// 		return false;
// 	}
	if(!$zhaohu->hasEnoughCouponers()){
		system_message(elgg_echo("coupon:notenough"));
		return false;
	}
	if(Coupon::try_get_coupon_for_event($zhaohu->guid)){
		register_error(elgg_echo("coupon:generated"));
		return false;
	}
	
	$attendees = $zhaohu->getAttendees(COUPON_OUT_LIMIT);
	set_time_limit(0);
	foreach ($attendees as $user) {
		//fordebug system_message("user guid {$user->guid}");
		$res = Coupon::gen($user, $zhaohu);
		if(!$res){
			elgg_log("ZHError ,genCoupons, failed for user_id {$user->guid}, zhaohu_id {$zhaohu->guid}", "ERROR");
		} else {
			elgg_log("genCoupons, generated ok for user_id {$user->guid}, zhaohu_id {$zhaohu->guid}", "ERROR");
		}
	}
	system_message(elgg_echo("coupon:gen:ok"));
	return true;
}

function zhaohuRsvp() {
	$guid = (int) get_input("guid");
	$user_guid = (int) get_input("user", elgg_get_logged_in_user_guid());
	$rel = get_input("type");
	$k = get_input("k");
	$zhaohu = get_entity($guid);
	if(!empty($k)) {
		$rightK = md5($zhaohu->time_created . get_site_secret() . $user_guid);
		DoRsvp($guid, $user_guid, $rel);
// 		if( $rightK == $k)
// 			DoRsvp($guid, $user_guid, $rel);
// 		else
// 			register_error(elgg_echo("zhaohu:rsvp:error") . elgg_echo("zhaohu:sorry"));
// 		elgg_log("ZHError ,zhaohuRsvp, the provided key $K is invalid, zhaohu_id $guid, user_id "
// 			.elgg_get_logged_in_user_guid(), "ERROR");
	} else {
		register_error(elgg_echo("zhaohu:rsvp:error") . elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError ,zhaohuRsvp, missing the key, zhaohu_id $guid, user_id "
			.elgg_get_logged_in_user_guid(), "ERROR");
	}	
	forward($zhaohu->getURL());
}

function DoRsvp($guid, $user_guid, $rel) {
	if(empty($rel)) {
		register_error(elgg_echo("zhaohu:rsvp:error") . elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError ,DoRsvp, empty rel,  zhaohu_id $guid, user_id $user_guid, logged_user_id "
			.elgg_get_logged_in_user_guid(), "ERROR");
		return;
	}
	
	if(!empty($guid) && ($zhaohu = get_entity($guid))) {
		if($zhaohu->getSubtype() == Zhaohu::SUBTYPE) {
				
			if($user = get_entity($user_guid)) {
				if($rel == ZHAOHU_MANAGER_RELATION_ATTENDING) {
					if($zhaohu->hasSpotsLeft() ) {
						$rsvp = $zhaohu->rsvp($rel, $user_guid);
					} else {
						system_message(elgg_echo('zhaohu:rsvp:nospotsleft'));
						return;
					}
				} else {
					if($zhaohu->$rel || ($rel == ZHAOHU_MANAGER_RELATION_UNDO) || ($rel == ZHAOHU_MANAGER_RELATION_ATTENDING)) {
						$rsvp = $zhaohu->rsvp($rel, $user_guid);
					} else {
						register_error(elgg_echo('zhaohu:rsvp:error') . elgg_echo("zhaohu:sorry"));
						elgg_log("ZHError ,DoRsvp,  the RSVP type $rel is not supported, zhaohu_id $guid, user_id $user_guid, logged_user_id "
						.elgg_get_logged_in_user_guid(), "ERROR");
					}
				}
	
 				if ($rsvp)
 					system_message(elgg_echo('zhaohu:relationship:message:' . $rel));
				else {
					register_error(elgg_echo('zhaohu:rsvp:error') . elgg_echo("zhaohu:sorry"));
					elgg_log("ZHError ,DoRsvp, error calling zhaohu->rsvp, RSVP type $rel, zhaohu_id $guid, user_id $user_guid, logged_user_id "
					.elgg_get_logged_in_user_guid(), "ERROR");
				}
			}
		} else {
			register_error(elgg_echo('zhaohu:rsvp:error') . elgg_echo("zhaohu:sorry"));
			elgg_log("ZHError ,DoRsvp, zhaohu is of invalid type, RSVP type $rel, zhaohu_id $guid, user_id $user_guid, logged_user_id "
			.elgg_get_logged_in_user_guid(), "ERROR");
		}
	} else {
		register_error(elgg_echo('zhaohu:rsvp:error') . elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError ,DoRsvp, invalid zhaohu, RSVP type $rel, zhaohu_id $guid, user_id $user_guid, logged_user_id "
		.elgg_get_logged_in_user_guid(), "ERROR");
	}
}

function zhaohu_manager_zhaohu_get_relationship_options()	{
	$result = array(
			ZHAOHU_MANAGER_RELATION_ATTENDING,
			//ZHAOHU_MANAGER_RELATION_ORGANIZING,
			//ZHAOHU_MANAGER_RELATION_ATTENDING_WAITINGLIST,
			//ZHAOHU_MANAGER_RELATION_ATTENDING_PENDING
	);
		
	return $result;
}

function zhaohu_manager_get_form_pulldown_hours($name = '', $value = '', $h = 23) {
	$time_hours_options = range(0, $h);

	array_walk($time_hours_options, 'zhaohu_manager_time_pad');

	return elgg_view('input/dropdown', array('name' => $name, 'value' => $value, 'options' => $time_hours_options));
}

function zhaohu_manager_get_form_pulldown_minutes($name = '', $value = '') {
	$time_minutes_options = range(0, 59, 5);

	array_walk($time_minutes_options, 'zhaohu_manager_time_pad');

	return elgg_view('input/dropdown', array('name' => $name, 'value' => $value, 'options' => $time_minutes_options));
}

function zhaohu_manager_time_pad(&$value) {
	$value = str_pad($value, 2, "0", STR_PAD_LEFT);
}

/*function to add end_day for existing zhaohu*/
function zhaohu_add_end_day_all(){
	zhaohu_add_end_day(true);
	zhaohu_add_end_day(false);
	system_message("Added end_day for all zhaohu");
}

function zhaohu_add_end_day($past_only){
	$options = array (
			"past_zhaohus" => $past_only, //must have
			'past_only' => $past_only,
			'offset' => 0,
			'limit' => 500
	);
	
	$zhaohus = zhaohu_manager_find_zhaohus ($options, $tag);
	$entities = $zhaohus["entities"];
	$count = $zhaohus["count"];
	$num=0;

	foreach ($entities as $zhaohu){
		if (elgg_instanceof($zhaohu, 'object', 'zhaohu')) {
			$tmp_date=date(ZHAOHU_MANAGER_FORMAT_DATE, $zhaohu->end_ts);
			$date = explode('-', $tmp_date);
			//system_message("zhaohu id: ".$zhaohu->guid ."end_date".$tmp_date);
			$end_day = mktime(0,0,1,$date[1],$date[2],$date[0]);
			$zhaohu->end_day = $end_day;
			$zhaohu->save();
			$num++;
			elgg_log("Added end_day for zhaohu ".$zhaohu->guid, 'NOTICE');
		}
	}
	elgg_log("Summary: added end_day for {$num} zhaohus", 'NOTICE');
}

function zhaohu_guid_callback($row) {
	return ($row->guid) ? $row->guid : false;
}

function find_zhaohus_feature_up($options, $tag){
	$options['featured_only']='y';
	$featured_res = find_zhaohus_by_tag_title($options, $tag);
	$featured_entities = $featured_res["entities"];
	$featured_count = $featured_res["count"];

	$featured_guids = array_map("zhaohu_guid_callback", $featured_entities);

	$options['featured_only']='n';
	$res = find_zhaohus_by_tag_title($options, $tag);
	$entities = $res["entities"];
	$count = $res["count"];
	
	foreach ($entities as $key => $entity) {
		if (in_array($entity->guid, $featured_guids)){
			unset($entities[$key]);
		}
	}
	$merged = $featured_entities? array_merge($featured_entities, $entities) : $entities;

	$result = array("entities" => $merged,
			"count" => $count);
	return $result;
}
function find_zhaohus_by_tag_title($options, $tag){
	$options['by_tag'] = true;
	$options['by_title'] = false;
	$resByTag = zhaohu_manager_find_zhaohus ($options, $tag);
	$entitiesByTag = $resByTag["entities"];
	$countByTag = $resByTag["count"];
	//fordebug register_error("countByTag {$countByTag}");
	
	$options['by_tag'] = false;
	$options['by_title'] = true;
	$resByTitle = zhaohu_manager_find_zhaohus($options, $tag);
	$entitiesByTitle = $resByTitle ["entities"];
	$countByTitle = $resByTitle ["count"];
	//fordebug register_error("countByTitle {$countByTitle}");
	if($countByTag==0)
		return $resByTitle;
	
	if($countByTitle==0)
		return $resByTag;
	
	$options['by_tag'] = true;
	$options['by_title'] = true;
	$options['count_only'] = true;
	$resIntersect = zhaohu_manager_find_zhaohus($options, $tag);
	$countIntersect = $resIntersect["count"];
	//fordebug register_error("countIntersect {$countIntersect}");
	$entities = merge_entities_by_guid($entitiesByTag, $entitiesByTitle);
	$count = $countByTag+$countByTitle-$countIntersect;
	$result = array("entities" => $entities,
			"count" => $count,);
	return $result;
}

function merge_entities_by_guid($ent1, $ent2){
	$lookup = array();
	foreach ($ent1 as $idx => $entity) {
		//fordebug system_message("arr1 guid ". $entity->guid);
		array_push($lookup, $entity->guid);
	}
	foreach ($ent2 as $idx => $entity) {
		//fordebug system_message("arr2 guid ". $entity->guid);
		if(!in_array($entity->guid, $lookup))
			array_push($ent1, $entity);
	}
	return $ent1;
}

function getCouponPerUserEvent($zhaohu_guid, $user_guid){
	$options = array (
			'event_guid' => $zhaohu_guid,
			'user_guid' => $user_guid,
			'offset' => 0,
			'limit' => 0,
	);
	$res = zh_find_coupons($options);
	if($res['count']!=1){
		register_error(elgg_echo("coupon:notfound"). elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError ,sendCoupon, cannot find coupon, zhaohu_guid {$zhaohu_guid}, user_guid {$user_guid}", "ERROR");
		return null;
	}
	return $res['entities']['0'];
}

function zh_find_coupons($options = array()){
	$defaults = array(
			'count' 			=> false,
			'offset' 			=> 0,
			'limit'				=> ZHAOHU_MANAGER_COUPON_LIST_LIMIT,
			'count_only'		=> false,
			'user_guid' => null,
			'event_guid' => null,
			'code' => null,
	);

	$options = array_merge($defaults, $options);
	$entities_options = array(
			'type' 			=> 'object',
			'subtype' 		=> Coupon::SUBTYPE,
			'offset' 		=> $options['offset'],
			'limit' 		=> $options['limit'],
			'joins' => array(),
			'wheres' => array(),
	);
	if($options["user_guid"] && !empty($options["user_guid"])){
		$entities_options['metadata_name_value_pairs'][] = array('name' => 'user_guid', 'value' => $options["user_guid"]);
	}
	if($options["event_guid"] && !empty($options["event_guid"])){
		$entities_options['metadata_name_value_pairs'][] = array('name' => 'event_guid', 'value' => $options["event_guid"]);
	}
	if($options["code"] && !empty($options["code"])){
		$entities_options['metadata_name_value_pairs'][] = array('name' => 'code', 'value' => $options["code"]);
	}

	$entities_options['count'] = true;
	$count = elgg_get_entities_from_metadata($entities_options);

	$entities = null;
	if(!$options['count_only'] && $count) {
		$entities_options['count'] = false;
		$entities = elgg_get_entities_from_metadata($entities_options);
	}
	$result = array("entities" => $entities,"count" => $count);	
	return $result;	
}

function zhaohu_manager_find_zhaohus($options = array(), $tag = null){
	$defaults = array(
			'count' 			=> false,
			'offset' 			=> 0,
			'limit'				=> ZHAOHU_MANAGER_SEARCH_LIST_LIMIT,
			'container_guid'	=> null,
			'container_guids'	=> null,
			'query'				=> false,
			'meattending'		=> false,
			'owning'			=> false,
			'by_title'		=> false,
			'by_tag'		=> false,
			'past_zhaohus'		=> false,
			'past_only'		=> false,
			'featured_only'		=> 'n',
			'unfeatured_only'		=> 'n',
			'all_status'		=> false,
			'has_updates'		=> false,
			'count_only'		=> false,
			//'tags' => null,
			'country' => null,
			'state' => null,
			'city' => null,
			'start_day' => '',
			'end_day' => ''			
	);
	
	$options = array_merge($defaults, $options);
	//zhaohus plugin saves tags as "tags"
	$entities_options = array(
			'type' 			=> 'object',
			'subtype' 		=> 'zhaohu',
			'offset' 		=> $options['offset'],
			'limit' 		=> $options['limit'],
			'joins' => array(),
			'wheres' => array(),
	);

	if($tag!=null) {
		if($options["by_title"]){			
			$db_prefix = elgg_get_config('dbprefix');
			$entities_options['joins'][] = "JOIN {$db_prefix}objects_entity oe ON e.guid = oe.guid";
			$entities_options['wheres'][] = "oe.title LIKE '%$tag%'";	
		}
		if($options["by_tag"] && $tag != 'All' && $tag !=elgg_echo('AllInterests')) {
			$entities_options['metadata_name'] = 'tags';
			$entities_options['metadata_value'] = $tag;
		}
	}
	
	if($options["container_guid"]){
		// limit for a group
		$entities_options['container_guid'] = $options['container_guid'];
	}
	// limit for friends and groups
	if($options["container_guids"]){
		$entities_options['container_guids'] = $options['container_guids'];
	}
	
	if($options["country"] && !empty($options["country"]) && $options["country"] !=elgg_echo("All")){
		$entities_options['metadata_name_value_pairs'][] = array('name' => 'country', 'value' => $options["country"]);
	}
	
	if($options["state"] && !empty($options["state"]) && $options["state"] !=elgg_echo("All")){
		$entities_options['metadata_name_value_pairs'][] = array('name' => 'state', 'value' => $options["state"]);
	}
	
	if($options["city"] && !empty($options["city"]) && $options["city"] !=elgg_echo("All")){
		$entities_options['metadata_name_value_pairs'][] = array('name' => 'city', 'value' => $options["city"]);
	}
	
	if(!$options["all_status"]){
		$entities_options['metadata_name_value_pairs'][] = array('name' => 'status', 'value' => 'published');
	}
	
	if($options["has_updates"]){
		$entities_options['metadata_name_value_pairs'][] = array('name' => 'hasUpdates', 'value' => true);
	}
	
	if($options["featured_only"] && $options["featured_only"] == 'y')
	{
		$entities_options['metadata_name_value_pairs'][] = array('name' => 'featured_zh', 'value' => 'y');
	}
	
	if($options["unfeatured_only"] && $options["unfeatured_only"] == 'y')
	{
		$entities_options['metadata_name_value_pairs'][] = array('name' => 'featured_zh', 'value' => 'n');
	}
	
	if(!empty($options['start_day'])) {
		$entities_options['metadata_name_value_pairs'][] = array('name' => 'start_day', 'value' => strtotime($options['start_day']), 'operand' => '>=');
		$options['past_zhaohus'] = true;
	}
	
	if(!empty($options['end_day'])) {
		$entities_options['metadata_name_value_pairs'][] = array('name' => 'start_day', 'value' => strtotime($options['end_day']), 'operand' => '<=');
		$options['past_zhaohus'] = true;
	}
	if(!$options['past_zhaohus']) {
		// only show from current day or newer
		$entities_options['metadata_name_value_pairs'][] = array('name' => 'end_day', 'value' => mktime(0, 0, 1), 'operand' => '>=');
		$entities_options['order_by_metadata'] = array("name" => 'end_day', "direction" => 'ASC', "as" => "integer");
	}
	if($options['past_only']) {
		$entities_options['metadata_name_value_pairs'][] = array('name' => 'end_day', 'value' => mktime(0, 0, 1), 'operand' => '<');
		$entities_options['order_by_metadata'] = array("name" => 'end_day', "direction" => 'DESC', "as" => "integer");
	}
	
	if($options['meattending']) {
		$entities_options['joins'][] = "JOIN " . elgg_get_config("dbprefix") . "entity_relationships e_r ON e.guid = e_r.guid_one";
			
		$entities_options['wheres'][] = "e_r.guid_two = " .  $options['user_guid']; //elgg_get_logged_in_user_guid()
		$entities_options['wheres'][] = "e_r.relationship = '" . ZHAOHU_MANAGER_RELATION_ATTENDING . "'";
	}
	
	if($options['owning']) {
		$entities_options['owner_guids'] = array($options['user_guid']);
	}		
	
	$entities_options['count'] = true;
	$count = elgg_get_entities_from_metadata($entities_options);
	
	$entities = null;
	if(!$options['count_only'] && $count) {
		$entities_options['count'] = false;
		$entities = elgg_get_entities_from_metadata($entities_options);
	}

	$result = array(
			"entities" 	=> $entities,
			"count" 	=> $count);

	return $result;
}

function getZhaohuNews($offset)
{
	$user = elgg_get_logged_in_user_entity();
	$zhaohu_options = array();
	$zhaohu_options['past_zhaohus'] = true;
	$zhaohu_options['offset'] = $offset;
	$friends = get_user_friends($user->guid, ELGG_ENTITIES_ANY_VALUE, 0);
	$groups = $user->getGroups("",0,0);
	if(!$friends && !$groups) {
		return elgg_echo('zhaohu:noresults');
	}
	else {
		$zhaohu_options['container_guids'] = array();
		foreach ($friends as $friend) {
			$zhaohu_options['container_guids'][] = $friend->getGUID();
		}
		foreach ($groups as $group) {
			$zhaohu_options['container_guids'][] = $group->getGUID();
		}

		$zhaohus = zhaohu_manager_find_zhaohus($zhaohu_options);
		return 	$zhaohus;
	}
}

function getZhaohussForTab($zhaohu_options)
{
	$zhaohu_options["limit"] = ZHAOHU_MANAGER_ZHAOHU_IN_GROUP_LIMIT;
	$offset = get_input('offset', 0);
	$zhaohu_options["offset"] = $offset;
	//fordebug register_error('offset: ' . $zhaohu_options["offset"]);
	$zhaohus = zhaohu_manager_find_zhaohus($zhaohu_options);
	$entities = $zhaohus["entities"];
	$count = $zhaohus["count"];
	//fordebug register_error('count: ' . $count);
	return elgg_view("zhaohu_manager/findResult", array("entities" => $entities, 
			"count" => $count,
			"limit"=> ZHAOHU_MANAGER_ZHAOHU_IN_GROUP_LIMIT,
			"offset" => $offset ));
}

function countZhaohuForGroup($groupId, $includePast)
{
	$zhaohu_options = array("container_guid" => $groupId,
		"count_only" => true,
		"limit" => false,
		"past_zhaohus" => $includePast);
	$zhaohus = zhaohu_manager_find_zhaohus($zhaohu_options);

	return $zhaohus['count'];	
}

function getNextZhaohuForGroup($groupId) {
	$zhaohu_options = array("container_guid" => $groupId,
			"limit" => 1,
			"past_zhaohus" => false);
	$zhaohus = zhaohu_manager_find_zhaohus($zhaohu_options);
	$zhEntities = $zhaohus["entities"];
	$nextZhaohu = null;
	if($zhEntities){
		$nextZhaohu = $zhEntities['0'];
	}
	return $nextZhaohu;
}

