<?php
$guid = get_input ("group_guid");
elgg_set_page_owner_guid($guid);

$group = get_entity($guid);
if (!$group || !elgg_instanceof($group, 'group')) {
	forward(REFERER);
}

group_gatekeeper();

$title = elgg_echo('zhgroups:contact:title');

$content = elgg_echo('zhgroups:founder');
$owner = $group->getOwnerEntity();
elgg_push_context('zhg_contact');
$content .= elgg_view_entity($owner, array("full_view" => false));
elgg_pop_context('zhg_contact');


// use db query instead of $group->getMembers because we need order by
$db_prefix = elgg_get_config('dbprefix');
$entities_options = array(
		'relationship' => 'group_admin',
		'relationship_guid' => $group->guid,
		'inverse_relationship' => true,
		'type' => 'user',
		"limit" => false,
		'joins' => array("JOIN {$db_prefix}users_entity u ON e.guid=u.guid"),
		'order_by' => 'u.name ASC',
);
$members = elgg_get_entities_from_relationship($entities_options);
$entities_options ['count'] = true;
$count = elgg_get_entities_from_relationship($entities_options);
//fordebug register_error ( 'count' . $count );

if ($members) {
	$content .= elgg_echo('zhgroups:admins');
	$content .= elgg_view ( "zhgroups/contact", array (
			"entities" => $members,
			"count" => $count,
	) );
}

$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
		'group' => $group,
);
$body = elgg_view('zhgroups/inGroupContent', $params);

$content = elgg_view('zhgroups/group_header', array("group" => $group)) . $body;
echo elgg_view_page($title, $content);