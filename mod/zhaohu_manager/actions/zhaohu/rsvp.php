<?php

$guid = (int) get_input("guid");
$user_guid = get_input("user", elgg_get_logged_in_user_guid());
$rel = get_input("type");

$user=get_entity($user_guid);
$zhaohu = get_entity($guid);
$group = $zhaohu->getContainerEntity();

if(empty($group) || !($group instanceof ElggGroup)){
	register_error(elgg_echo("zhaohu:rsvp:error"). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError ,zhaohu:rsvp, invalid group, zhaohu_id {$guid} , user_id {$user_guid}, logged_user_id "
		.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);	
}
if($zhaohu->isPast()){
	register_error(elgg_echo("zhaohu:rsvp:past"));
	forward(REFERER);
}

if (!$group->isMember($user)){
	//register_error(elgg_echo("zhaohu:rsvp:notmember"));
	if (groups_join_group($group, $user)) {
		updateNearbyGroupCache($user, $group, 0);
		add_entity_relationship($user->guid, 'notifyemail', $group->guid);
		$subject = elgg_echo('zhgroups:join:subject', array(
				$user->name,
				$group->name,
		));
		$body = '<div style="color:#333;font-size:16px;">' . elgg_echo('zhgroups:join:body', array(
				$group->getOwnerEntity()->name,
				$user->getURL(),
				$user->name,
				$group->getURL(),
				$group->name,
				$user->getURL(),
				$user->name,
		)).'</div>';
		zhgroups_send_email_to_user($group, $group->getOwnerEntity(), $subject, $body, true, true);
		//system_message(elgg_echo("groups:joined"));
	}
}
DoRsvp($guid, $user_guid, $rel);
forward(REFERER);

	
