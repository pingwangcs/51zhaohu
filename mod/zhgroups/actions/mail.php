<?php
/**
 * Mail all the members of a group
 */

$group_guid = (int) get_input("group_guid", 0);
$user_guids = get_input("user_guids");
$subject = get_input("subject");
$body = get_input("body");
$_SESSION['zhgroups:subject'] = $subject;
$_SESSION['zhgroups:body'] = $body;

if(empty($user_guids)){
	register_error(elgg_echo("zhaohu:emails:empty"));
	forward(REFERER);
}
if(empty($subject)){
	register_error(elgg_echo("zhgroups:mail:subject:empty"));
	forward(REFERER);
}
if(empty($body)){
	register_error(elgg_echo("zhgroups:mail:body:empty"));
	forward(REFERER);
}
if (!is_array($user_guids)) {
	$user_guids = array($user_guids);
}
//turn off verfiy for performance
//$user_guids = zhgroups_verify_group_members($group_guid, $user_guids);

if (!empty($group_guid)) {
	$group = get_entity($group_guid);
	
	if (!empty($group) && ($group instanceof ElggGroup)) {
		if ($group->canEdit()) {
			set_time_limit(0);
			
			$body .= PHP_EOL;
			$body .= elgg_echo("zhgroups:mail:message:from") . ': <a href="'.$group->getURL()
				.'" target="_blank">'.$group->name.'</a>';			
			foreach ($user_guids as $guid) {
				$user = get_entity($guid);
				$message = '<div style="color:#333;font-size:16px;">'.elgg_echo('zhaohu:hi', array($user->name)) . $body . '</div>';
				zhgroups_send_email_to_user($group, $user, $subject, $message, false, true);
				//notify_user($guid, $group->getGUID(), $subject, $body, NULL, "email");
			}		
			system_message(elgg_echo("zhgroups:action:mail:success"));
		} else {
			register_error(elgg_echo('zhaohu:wrong'). elgg_echo("zhaohu:sorry"));
			elgg_log("ZHError , zhgroups:mail, user does not have permission, group_id {$group_guid} , user_id "
			.elgg_get_logged_in_user_guid()." , recipients ".implode("|", $user_guids), "ERROR");
		}
		unset($_SESSION['zhgroups:subject']);
		unset($_SESSION['zhgroups:body']);
		forward($group->getURL());
	} else {
		register_error(elgg_echo('zhaohu:wrong'). elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError , zhgroups:mail, group is invalid, group_id {$group_guid} , user_id "
		.elgg_get_logged_in_user_guid()." , recipients ".implode("|", $user_guids), "ERROR");
	}
} else {
	register_error(elgg_echo('zhaohu:wrong'). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError , zhgroups:mail, group_guid is empty , user_id "
	.elgg_get_logged_in_user_guid()." , recipients ".implode("|", $user_guids), "ERROR");
}

unset($_SESSION['zhgroups:subject']);
unset($_SESSION['zhgroups:body']);
forward(REFERER);
