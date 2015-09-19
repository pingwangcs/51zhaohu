<?php

$group = $vars['group'];
$user = elgg_get_logged_in_user_entity();
$site_url = elgg_get_site_url();

$result = '<div id="zhaohu_group_header_div">';
$result .= '<div id="zhaohu_group_header_title_div">' . $group->name . '</div>';
$result .= '<div id="zhaohu_group_header_commands_div">'; 
$result .= '<ul id="zhaohu_group_header_commands_list">';
$result .= '<li><a class="zhaohu-group-command-link" href="' . $site_url . 'groups/profile/' . $group->guid . '">' . elgg_echo('zhgroup:home') . '</a></li>';
// if ($group->canEdit()) // comment to let everyone new event
	$result .= '<li><a id="zhaohu_start_zhaohu_link" class="zhaohu-group-command-link" href="' . $site_url . 'zhaohus/zhaohu/new/' . $group->guid . '">' . elgg_echo('zhaohu:new') . '</a></li>';
$result .= '<li><a class="zhaohu-group-command-link" href="' . $site_url . 'zhgroups/members/' . $group->guid . '">' . elgg_echo('zhgroups:members') . '</a></li>';
$result .= '<li><a class="zhaohu-group-command-link" href="' . $site_url . 'photos/group/' . $group->guid . '/all' . '">' . elgg_echo('zhgroup:photos') . '</a></li>';

if ($group->isMember($user)) {
	$result .= '<li id="zhaohu_group_header_commands_dropdown_link"><a class="zhaohu-group-command-link" href="#"> ... </a>';
	$result .= '<ul id="zhaohu_group_header_commands_dropdown_list">';
	if ($group->canEdit()) {
		//$result .= '<li><a class="zhaohu-group-command-link1" href="' . $site_url . 'zhaohus/zhaohu/new/' . $group->guid . '">' . elgg_echo('zhaohu:new') . '</a></li>';
		$result .= '<li><a class="zhaohu-group-command-link1" href="' . $site_url . 'groups/edit/' . $group->guid . '">' . elgg_echo('groups:edit') . '</a></li>';
		$result .= '<li><a class="zhaohu-group-command-link1" href="' . $site_url . 'zhgroups/mail/' . $group->guid . '">' . elgg_echo('zhgroups:mail') . '</a></li>';
	}
	
	$result .= '<li><a class="zhaohu-group-command-link1" href="' . $site_url . 'zhgroups/contact/' . $group->guid . '">' . elgg_echo('zhgroups:contact') . '</a></li>';
	if(check_entity_relationship ($user->guid, 'notifyemail', $group->guid ))
		$rel = 'unsub';
	else
		$rel = 'sub';
	$url = "zhgroups/notifications?guid=" . $group->guid . "&type=" . $rel;
	
	$result .= '<li><a class="zhaohu-group-command-link1" href="' . $site_url . 'zhgroups/notifications?guid=' . $group->guid . '&type=' . $rel . '">' . elgg_echo('zhgroups:notifications:'.$rel) . '</a></li>';
	$result .= '<li><a class="zhaohu-group-command-link1" href="' . $site_url . 'zhgroups/invite/' . $group->guid . '">' . elgg_echo('zhgroups:invite') . '</a></li>';

	$leave_group_url = elgg_get_site_url() . "action/groups/leave?group_guid={$group->getGUID()}";
	$leave_group_url = elgg_add_action_tokens_to_url($leave_group_url);
	$result .= '<li><a class="zhaohu-group-command-link1" href="' . $leave_group_url . '">' . elgg_echo('groups:leave') . '</a></li>';

	$result .= '</ul></li>';
}
elseif(elgg_is_logged_in()){
	$join_group_url = elgg_get_site_url() . "action/groups/join?group_guid={$group->getGUID()}";
	$join_group_url = elgg_add_action_tokens_to_url($join_group_url);
	$result .= '<li><a class="zhaohu-group-command-link" href="' . $join_group_url . '">' . elgg_echo('groups:join') . '</a></li>';
}

if (elgg_is_admin_logged_in()) {
	if ($group->featured_group == "yes") {
		$featured_group_url = "action/groups/featured?group_guid={$group->guid}&action_type=unfeature";
		$wording = elgg_echo("zhgroups:unmarkfeatured");
	} else {
		$featured_group_url = "action/groups/featured?group_guid={$group->guid}&action_type=feature";
		$wording = elgg_echo("zhgroups:markfeatured");
	}
	$feature_group_action_url = elgg_add_action_tokens_to_url($featured_group_url);
	$result .= '<li><a class="zhaohu-group-command-link" href="' . $feature_group_action_url . '">' . $wording . '</a></li>';
}

$result .= "</ul></div></div>";
echo $result;
