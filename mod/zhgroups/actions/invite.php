<?php
/**
 * Invite a user to join a group
 *
 * @package ElggGroups
 */
if (!elgg_is_logged_in()) {
	register_error(elgg_echo("zhaohu:notloggedin"). elgg_echo("zhaohu:sorry"));
	forward(REFERER);
}
$logged_in_user = elgg_get_logged_in_user_entity();

$group_guid = (int) get_input("group_guid");
$text = get_input("comment");

$emails = get_input("email2invite");
if(empty($emails)){
	register_error(elgg_echo("zhaohu:emails:empty"));
	forward(REFERER);
}
if (!is_array($emails))
	$emails = array($emails);
//fordebug register_error("emails ".$emails[0]);

$group = get_entity($group_guid);

	//($group->canEdit() || zhgroups_allow_members_invite($group))
	if ( !empty($group) && ($group instanceof ElggGroup) && $group->isMember($logged_in_user)) {
		// show hidden (unvalidated) users
		$hidden = access_get_show_hidden_status();
		access_show_hidden_entities(true);		
		
		$invited = 0; // counters
	
		// Invite member by e-mail address
		if (!empty($emails)) {
			foreach ($emails as $email) {
				//fordebug register_error("groupid " . $group->guid . " email " . $email. " text " . $text);
				$invite_result = send_invite_email($logged_in_user, $group, $email, $text);
				//fordebug register_error("invite_result  ".$invite_result );
				if ($invite_result === true) {
					$invited++;
				}
			}
		}
				
		// restore hidden users
		access_show_hidden_entities($hidden);
		
		// which message to show
		if ($invited) {
				system_message(elgg_echo("zhaohu:invite:ok"));
		} else {
				register_error(elgg_echo('zhaohu:invite:err'). elgg_echo("zhaohu:sorry"));
				elgg_log("ZHError , zhgroups:invite, error sending invitations, group_id {$group_guid} , user_id "
					.elgg_get_logged_in_user_guid()." , emails ".implode("|", $emails), "ERROR");
		}
	} else {
		register_error(elgg_echo('zhaohu:invite:err'). elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError , zhgroups:invite, group is invalid or user does not have permission, group_id {$group_guid} , user_id "
				.elgg_get_logged_in_user_guid()." , emails ".implode("|", $emails), "ERROR");
	}

forward(REFERER);
