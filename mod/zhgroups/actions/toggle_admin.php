<?php
/**
 * add/remove a user as a group admin
 */

$group_guid = (int) get_input("group_guid");
$user_guid = (int) get_input("user_guid");

$group = get_entity($group_guid);
$user = get_user($user_guid);

if (empty($group) || !($group instanceof ElggGroup)) {
	register_error(elgg_echo('zhaohu:wrong'). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError , zhgroups:toggle_admin, group is invalid, group_id {$group_guid} , user_id {$user_guid} , logged_in_user_id "
		.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}
if (empty($user)) {
	register_error(elgg_echo('zhaohu:wrong'). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError , zhgroups:toggle_admin, user is invalid, group_id {$group_guid} , user_id {$user_guid} , logged_in_user_id "
		.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}
if(!$group->canEdit()) {
	register_error(elgg_echo('zhaohu:wrong'). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError , zhgroups:toggle_admin, user does not have permission, group_id {$group_guid} , user_id {$user_guid}, logged_in_user_id "
		.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}
if(!$group->isMember($user)) {
	register_error(elgg_echo('zhaohu:wrong'). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError , zhgroups:toggle_admin, user is not group member, group_id {$group_guid} , user_id {$user_guid}, logged_in_user_id "
		.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}
if($group->getOwnerGUID() == $user->guid) {
	register_error(elgg_echo("zhgroups:toggleadmin:owner"));
	forward(REFERER);
}	
		
if (!check_entity_relationship($user->getGUID(), "group_admin", $group_guid)) {
	if (add_entity_relationship($user->getGUID(), "group_admin", $group_guid)) {
		system_message(elgg_echo("zhgroups:action:toggle_admin:success:add", array($user->name)));
		add_to_river('river/group/admin', 'add',  $user->guid, $group->guid);
		$subject = elgg_echo('zhgroups:add:admin:subject', array($group->name));
		$body = '<div style="color:#333;font-size:16px;">' . elgg_echo('zhgroups:add:admin:body', array(
				$user->name,
				$group->getOwnerEntity()->getURL(),
				$group->getOwnerEntity()->name,
				$group->getURL(),
				$group->name,
				$group->getURL(),
				$group->name,
		)).'</div>';
		zhgroups_send_email_to_user($group, $user, $subject, $body, true, true);
	} else {
		register_error(elgg_echo('zhaohu:wrong'). elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError , zhgroups:toggle_admin, error add_entity_relationship, group_id {$group_guid} , user_id {$user_guid}, logged_in_user_id "
		.elgg_get_logged_in_user_guid(), "ERROR");
	}
} else {
	if (remove_entity_relationship($user->getGUID(), "group_admin", $group_guid)) {
		system_message(elgg_echo("zhgroups:action:toggle_admin:success:remove", array($user->name)));
		$subject = elgg_echo('zhgroups:rm:admin:subject', array($group->name));
		$body = '<div style="color:#333;font-size:16px;">' . elgg_echo('zhgroups:rm:admin:body', array(
				$user->name,
				$group->getOwnerEntity()->getURL(),
				$group->getOwnerEntity()->name,
				$group->getURL(),
				$group->name,
				$group->getURL(),
				$group->name,
		)).'</div>';
		zhgroups_send_email_to_user($group, $user, $subject, $body, true, true);
	} else {
		register_error(elgg_echo('zhaohu:wrong'). elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError , zhgroups:toggle_admin, error remove_entity_relationship, group_id {$group_guid} , user_id {$user_guid}, logged_in_user_id "
		.elgg_get_logged_in_user_guid(), "ERROR");
	}
}
forward(REFERER);

