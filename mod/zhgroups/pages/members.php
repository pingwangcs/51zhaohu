<?php
$guid = get_input ( "group_guid");
$offset = get_input ( "offset", 0 );
elgg_set_page_owner_guid($guid);
$group = get_entity($guid);
if (!$group || !elgg_instanceof($group, 'group')) {
	forward(REFERER);
}

group_gatekeeper();

$title = elgg_echo('groups:members:title', array($group->name));

// use db query instead of $group->getMembers because we need order by
$db_prefix = elgg_get_config('dbprefix');
$entities_options = array(
		'relationship' => 'member',
		'relationship_guid' => $group->guid,
		'inverse_relationship' => true,
		'type' => 'user',
		'offset' => $offset,
		'limit' => ZHAOHU_GROUPS_MEMBER_LIMIT,
		'joins' => array("JOIN {$db_prefix}users_entity u ON e.guid=u.guid"),
		'order_by' => 'u.name ASC',
);
$members = elgg_get_entities_from_relationship($entities_options);
$entities_options ['count'] = true;
$count = elgg_get_entities_from_relationship($entities_options);
//fordebug register_error ( 'count' . $count );

if (! $members) {
	$content = elgg_echo ( 'groups:members:none' );
} else {
	$content = elgg_view ( "zhgroups/findMembers", array (
			"entities" => $members,
			"count" => $count,
			"offset" => $offset
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
