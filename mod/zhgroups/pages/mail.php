<?php
/**
 * Mail group members
 */

gatekeeper();

$group_guid = (int) get_input("group_guid", 0);
$group = get_entity($group_guid);

if (!empty($group) && ($group instanceof ElggGroup) && $group->canEdit()) {
	// set page owner
	elgg_set_page_owner_guid($group->getGUID());
	elgg_set_context("groups");
	
	// build page elements
	$title_text = elgg_echo("zhgroups:mail:title");
	$memberId = get_input('memberId');
	$form = elgg_view_form("zhgroups/mail", null,array("entity" => $group, "memberId" => $memberId));
	
	$params = array(
			"content" => $form,
			"title" => $title_text,
			"filter" => "",
			'group' => $group
	);
	
	$body = elgg_view('zhgroups/inGroupContent', $params);
	
	$content = elgg_view('zhgroups/group_header', array("group" => $group)) . $body;
	echo elgg_view_page($title_text, $content);
} else {
	forward(REFERER);
}
