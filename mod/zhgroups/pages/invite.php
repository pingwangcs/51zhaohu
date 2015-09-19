<?php
/**
 * Invite users to groups
 *
 * @package ElggGroups
 */

gatekeeper();
$guid = (int) get_input("group_guid");
$group = get_entity($guid);

if (!empty($group) && ($group instanceof ElggGroup)) {

	//if ($group->canEdit() || zhgroups_allow_members_invite($group)) {
		elgg_set_page_owner_guid($guid);
		$title = elgg_echo("groups:invite:title");
	
		$content = elgg_view_form("zhgroups/invite", 
						array(
							"id" => "invite_to_group",
							"class" => "elgg-form-alt mtm",
							"enctype" => "multipart/form-data"
							), array("entity" => $group)
					);
		
		$params = array(
			"content" => $content,
			"title" => $title,
			"filter" => "",
			'group' => $group
		);
		
		$body = elgg_view('zhgroups/inGroupContent', $params);
		
		$content = elgg_view('zhgroups/group_header', array("group" => $group)) . $body;
		echo elgg_view_page($title, $content);
} else {
	register_error(elgg_echo("zhaohu:wrong"). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError , zhgroups:pages/invite, group is invalid, group_id {$guid} , user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}
