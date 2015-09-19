<?php

function zhgroups_date($l, $u) {
	$arr = Array();
	foreach (range($l, $u) as $v) {
	    $arr[$v] = $v;
	}
	return $arr;
}

function checkImageExt($filename) {
	$extension = substr(strrchr($filename, '.'), 1);
	switch (strtolower($extension)) {
		case 'png':		break;
		case 'gif':		break;
		case 'jpg':
		case 'jpeg':	break;
		default:
			return false;
	}
	return true;
}

function find_groups_by_tag_title($options, $tag){
	$options['by_tag'] = true;
	$options['by_title'] = false;
	$resByTag = zhgroups_find_groups($options, $tag);
	$entitiesByTag = $resByTag["entities"];
	$countByTag = $resByTag["count"];
	
	$options['by_tag'] = false;
	$options['by_title'] = true;
	$resByTitle = zhgroups_find_groups($options, $tag);
	$entitiesByTitle = $resByTitle["entities"];
	$countByTitle = $resByTitle["count"];

	if($countByTag==0)
		return $resByTitle;

	if($countByTitle==0)
		return $resByTag;
	
	$options['by_tag'] = true;
	$options['by_title'] = true;
	$options['count_only'] = true;
	$resIntersect = zhgroups_find_groups($options, $tag);
	$countIntersect = $resIntersect["count"];
	
	$entities = merge_entities_by_guid($entitiesByTag, $entitiesByTitle);
	$count = $countByTag+$countByTitle-$countIntersect;
	$result = array("entities" => $entities,
			"count" => $count,);
	return $result;
}

function zhgroups_find_groups($options = array(), $tag = null){
	$defaults = array(
			'count' 		=> false,
			'offset' 		=> 0,
			'limit'			=> ZHAOHU_MANAGER_SEARCH_LIST_LIMIT,
			'count_only'	=> false,
			'by_title'		=> false,
			'by_tag'		=> false,
	);
	$options = array_merge($defaults, $options);
	
	$entities_options = array (
			'type' => 'group',
			'offset' => $options['offset'],
			'limit' => $options['limit'],
			'joins' => array(),
			'wheres' => array(),
	);
	
	if($tag!=null) {
		if($options["by_title"]){
			$db_prefix = elgg_get_config('dbprefix');
			$entities_options['joins'][] = "JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid";
			$entities_options['wheres'][] = "ge.name LIKE '%$tag%'";
		}
		if($options["by_tag"] && $tag != 'All' && $tag !=elgg_echo('AllInterests')) {
			$entities_options['metadata_name'] = 'interests';
			$entities_options['metadata_value'] = $tag;
		}
	}
	
	if($options["state"] && !empty($options["state"]) && $options["state"] !=elgg_echo("All")){
		$entities_options['metadata_name_value_pairs'][] 
			= array('name' => 'state', 'value' => $options["state"]);
	}
	
	$entities_options['count'] = true;
	$count = elgg_get_entities_from_metadata($entities_options);

	$entities = null;
	if(!$options['count_only'] && $count) {
		$entities_options['count'] = false;
		$entities_options['order_by_metadata'] = array("name" => 'score', "direction" => 'DESC', "as" => "integer");
		$entities = elgg_get_entities_from_metadata($entities_options);
	}

	$result = array(
			"entities" 	=> $entities,
			"count" 	=> $count
	);

	return $result;
}
//$guid is group guid 
function zhgroups_toggle_notifications() {
	$guid = (int) get_input("guid");	
	$user_guid = elgg_get_logged_in_user_guid();
	$rel = get_input("type");
	//todo: notifysite -> notifyemail
	if($rel == 'sub') {
		add_entity_relationship($user_guid, 'notifyemail', $guid);
	} else {
		remove_entity_relationship($user_guid, 'notifyemail', $guid);
	}
	system_message(elgg_echo('zhgroups:notifications:msg:' . $rel));
	forward(REFERER);
}

function zhgroupsUnsub() {
	$guid = (int) get_input("guid");
	$user_guid = get_input("user", elgg_get_logged_in_user_guid());
	$k = get_input("k");
	$group = get_entity($guid);
	//todo: notifysite -> notifyemail
	if(!empty($k)) {
		$rightK = md5($group->time_created . get_site_secret() . $user_guid);
		if( $rightK == $k) {
				remove_entity_relationship($user_guid, 'notifyemail', $guid);
				system_message(elgg_echo('zhgroups:notifications:msg:unsub'));
				forward($group->getURL());
		}
		else {
			register_error(elgg_echo("zhgroups:emunsub:error") . elgg_echo("zhaohu:sorry"));
			elgg_log("ZHError , zhgroups:zhgroupsUnsub, invalid key {$k}, group_id {$guid} , user_id {$user_guid}"
			, "ERROR");
		}
	} else {
		register_error(elgg_echo("zhgroups:emunsub:error") . elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError , zhgroups:zhgroupsUnsub, missing key, group_id {$guid} , user_id {$user_guid}"
		, "ERROR");
	}
	forward(elgg_get_site_url());
}

/**
 * Event to remove the admin role when a user leaves a group
 *
 * @param string $event  leave
 * @param string $type   group
 * @param array  $params array with the user and the group
 *
 * @return void|boolean
 */
function zhgroups_multiple_admin_group_leave($event, $type, $params) {

	if (!empty($params) && is_array($params)) {
		if (array_key_exists("group", $params) && array_key_exists("user", $params)) {
			$entity = $params["group"];
			$user = $params["user"];

			if (($entity instanceof ElggGroup) && ($user instanceof ElggUser)) {
				if (check_entity_relationship($user->getGUID(), "group_admin", $entity->getGUID())) {
					return remove_entity_relationship($user->getGUID(), "group_admin", $entity->getGUID());
				}
			}
		}
	}
}

/**
 * Allow group admins (not owners) to also edit group content
 *
 * @param string $hook         the 'permissions_check' hook
 * @param string $type         for the 'group' type
 * @param bool   $return_value the current value
 * @param array  $params       supplied params to help change the outcome
 *
 * @return bool true if can edit, false otherwise
 */
function zhgroups_multiple_admin_can_edit_hook($hook, $type, $return_value, $params) {
	$result = $return_value;

	if (!empty($params) && is_array($params) && !$result) {
		if (array_key_exists("entity", $params) && array_key_exists("user", $params)) {
			$entity = $params["entity"];
			$user = $params["user"];

			if (($entity instanceof ElggGroup) && ($user instanceof ElggUser)) {
				if ($entity->isMember($user) && check_entity_relationship($user->getGUID(), "group_admin", $entity->getGUID())) {
					$result = true;
				}
			}
		}
	}

	return $result;
}

/**
 * Verify that all supplied user_guids are a member of the group
 *
 * @param int   $group_guid the GUID of the group
 * @param array $user_guids an array of user GUIDs to check
 *
 * @return boolean|int[] returns all user_guids that are a member
 */
function zhgroups_verify_group_members($group_guid, $user_guids) {
	$result = false;

	if (!empty($group_guid) && !empty($user_guids)) {
		if (!is_array($user_guids)) {
			$user_guids = array($user_guids);
		}

		$group = get_entity($group_guid);
		if (!empty($group) && ($group instanceof ElggGroup)) {
			$options = array(
					"type" => "user",
					"limit" => false,
					"relationship" => "member",
					"relationship_guid" => $group->getGUID(),
					"inverse_relationship" => true,
					"callback" => "zhgroups_guid_only_callback"
			);
				
			$member_guids = elgg_get_entities_from_relationship($options);
			if (!empty($member_guids)) {
				$result = array();

				foreach ($user_guids as $user_guid) {
					if (in_array($user_guid, $member_guids)) {
						$result[] = $user_guid;
					}
				}
			}
		}
	}

	return $result;
}

/**
 * Custom callback function to only return the GUID from a database row
 *
 * @param stdClass $row the database row
 *
 * @return int the GUID
 */
function zhgroups_guid_only_callback($row) {
	return (int) $row->guid;
}

/**
 * Check if a invitation code results in a group
 *
 * @param string $invite_code the invite code
 * @param int    $group_guid  (optional) the group to check
 *
 * @return boolean|ElggGroup a group for the invitation or false
 */
function zhgroups_check_group_email_invitation($invite_code, $group_guid = 0) {
	$result = false;

	if (!empty($invite_code)) {
		$options = array(
				"type" => "group",
				"limit" => 1,
				"site_guids" => false,
				"annotation_name_value_pairs" => array(
						array(
								"name" => "email_invitation",
								"value" => $invite_code
						),
						array(
								"name" => "email_invitation",
								"value" => $invite_code . "|%",
								"operand" => "LIKE"
						)
				),
				"annotation_name_value_pairs_operator" => "OR"
		);

		if (!empty($group_guid)) {
			$options["annotation_owner_guids"] = array($group_guid);
		}

		// find hidden groups
		$ia = elgg_set_ignore_access(true);

		$groups = elgg_get_entities_from_annotations($options);

		if (!empty($groups)) {
			$result = $groups[0];
		}

		// restore access
		elgg_set_ignore_access($ia);
	}

	return $result;
}


/**
 * Invite a user to a group
 *
 * @param ElggGroup $group  the group to be invited for
 * @param ElggUser  $user   the user to be invited
 * @param string    $text   (optional) extra text in the invitation
 * @param boolean   $resend should existing invitations be resend
 *
 * @return boolean true if the invitation was send
 */
function zhgroups_invite_user(ElggGroup $group, ElggUser $user, $text = "", $resend = false) {
	$result = false;

	$loggedin_user = elgg_get_logged_in_user_entity();

	if (!empty($user) && ($user instanceof ElggUser) && !empty($group) && ($group instanceof ElggGroup) && !empty($loggedin_user)) {
		// Create relationship
		$relationship = add_entity_relationship($group->getGUID(), "invited", $user->getGUID());

		if ($relationship || $resend) {
			// Send email
			$url = elgg_get_site_url() . "groups/invitations/" . $user->username;
				
			$subject = elgg_echo("groups:invite:subject", array(
					$user->name,
					$group->name
			));
			$msg = elgg_echo("zhgroups:groups:invite:body", array(
					$user->name,
					$loggedin_user->name,
					$group->name,
					$text,
					$url
			));
				
			if (notify_user($user->getGUID(), $group->getOwnerGUID(), $subject, $msg, null, "email")) {
				$result = true;
			}
		}
	}

	return $result;
}

/**
 * Add a user to a group
 *
 * @param ElggGroup $group the group to add the user to
 * @param ElggUser  $user  the user to be added
 * @param string    $text  (optional) extra text for the notification
 *
 * @return boolean 	true if successfull
 */
function zhgroups_add_user(ElggGroup $group, ElggUser $user, $text = "") {
	$result = false;

	$loggedin_user = elgg_get_logged_in_user_entity();

	if (!empty($user) && ($user instanceof ElggUser) && !empty($group) && ($group instanceof ElggGroup) && !empty($loggedin_user)) {
		// make sure all goes well
		$ia = elgg_set_ignore_access(true);

		if ($group->join($user)) {
			// Remove any invite or join request flags
			remove_entity_relationship($group->getGUID(), "invited", $user->getGUID());
			remove_entity_relationship($user->getGUID(), "membership_request", $group->getGUID());

			// notify user
			$subject = elgg_echo("zhgroups:groups:invite:add:subject", array($group->name));
			$msg = elgg_echo("zhgroups:groups:invite:add:body", array(
					$user->name,
					$loggedin_user->name,
					$group->name,
					$text,
					$group->getURL()
			));
				
			$params = array(
					"group" => $group,
					"inviter" => $loggedin_user,
					"invitee" => $user
			);
			//to do?
			$msg = elgg_trigger_plugin_hook("invite_notification", "zhgroups", $params, $msg);

			if (notify_user($user->getGUID(), $group->getOwnerGUID(), $subject, $msg, null, "email")) {
				$result = true;
			}
		}

		// restore access
		elgg_set_ignore_access($ia);
	}

	return $result;
}

/**
 * Invite a new user by email to a group
 *
 * @param $user     invitation sender
 * @param $entity   the group or event to be invited for
 * @param string    $email  the email address to be invited
 * @param string    $text   (optional) extra text in the invitation
 *
 * @return boolean|NULL true is invited, false on failure, null when already send
 */
function send_invite_email($user, $entity, $email, $text = "") {
	$result = false;
	if(empty($email)){
		elgg_log("ZHError, send_invite_email, email is empty", "ERROR");
		return $result;
	}
	if(!is_email_address($email)){
		elgg_log("ZHError, send_invite_email, email is invalid, email {$email}", "ERROR");
		return $result;
	}
	if(empty($entity)){
		elgg_log("ZHError, send_invite_email, entity is empty", "ERROR");
		return $result;
	}
	if($entity instanceof ElggGroup){
		$senderName = $entity->name;
	} else if($entity instanceof Zhaohu){
		$senderName = $entity->title;
	} else {
		elgg_log("ZHError, send_invite_email, entity is invalid entity id {$entity->guid}", "ERROR");
		return $result;
	}
	
	$subject = elgg_echo("zhaohu:invite:email:subject", array($user->name, $senderName));
	$body = '<div style="color:#333;font-size:16px;">'
		.elgg_echo("zhaohu:invite:email:body", array(
		$user->getURL(),
		$user->name,
		$entity->getURL(),
		$senderName,
		$user->name,
		$text
		)).'</div>';
	//$body = elgg_trigger_plugin_hook("invite_notification", "zhgroups", $params, $body);
	//for debug register_error("senderName {$senderName}, email {$email}, subjec {$subject}");
	//for debug register_error("body {$body}");
	$result = zhgroups_send_email($senderName, $email, $subject, $body, '');

	return $result;
}

/**
 * Generate a unique code to be used in email invitations
 *
 * @param int    $group_guid the group GUID
 * @param string $email      the email address
 *
 * @return boolean|string the invite code, or false on failure
 */
function zhgroups_generate_email_invite_code($group_guid, $email) {
	$result = false;

	if (!empty($group_guid) && !empty($email)) {
		// get site secret
		$site_secret = get_site_secret();

		// generate code
		$result = md5($site_secret . $email . $group_guid);
	}

	return $result;
}

function getGroupsNearbyForGroup($state, $city, $groupID, $limit, $offset=0){
	$groups = getGroupsNearby($state, $city, $limit, $offset, false);
	foreach($groups as $key => $g) {
		if($g->guid == $groupID){
			unset($groups[$key]);
		}
	}
	return array_values($groups);
}

function countJoinedGroupsInState($userId, $state){
	$groups = elgg_get_entities_from_relationship(array(
			'type' => 'group',
			'relationship' => 'member',
			'relationship_guid' => $userId,
			'inverse_relationship' => false,
			'distinct'=>true,
	));	
	$count = 0;
	foreach($groups as $key => $g) {		
		if(!empty($g->state) && $g->state == $state){
			$count++;
		}
	}
	return $count;
}

function getGroupsNearby($state, $city, $limit, $offset=0, $count=false){
	$entities_options = array (
			'type' => 'group',
			'offset' => $offset,
			'limit' => $limit);

	if($state){
		$entities_options['metadata_name'] =  'state';
		$entities_options['metadata_value'] =  $state;
	}
	$entities_options['order_by_metadata'] = array("name" => 'score', "direction" => 'DESC', "as" => "integer");
	
	if($count)
		$entities_options ['count'] = true;		

	return elgg_get_entities_from_metadata ( $entities_options );
}

function getInThisGroupAlsoIN($group, $limit){
	
	$userLimit = 100;
	$members = get_group_members($group->guid, $userLimit, 0/*offset*/);
	$memberIds = array();
	if (!empty($members)) {
		foreach ($members as $member) {
			$memberIds[] = $member->getGUID();
		}
	}
	$in = "r.guid_one IN (" . implode(",", $memberIds) . ")";
	$notIn = "r.guid_two NOT IN (" . $group->guid . ")";

	$groups = elgg_get_entities_from_relationship(array(
	'relationship' => 'member',
	//'relationship_guid' => $group_guid,
	'inverse_relationship' => false,
	'type' => 'group',
	'limit' => $limit,
	'offset' => 0,
	'count' => false,
	'wheres'=> array($in, $notIn),
	'group_by' => 'r.guid_two', //r.guid_two is group guid
	'order_by' => 'count(r.guid_one) DESC'
	));
	return $groups;
	/*$content = '';
	foreach ($groups as $group){
		$content .= $group->guid;
	}
	return $content;*/
}