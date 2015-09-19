<?php
$user = elgg_get_logged_in_user_entity();
$offset = get_input('offset', 0);
$count = $user->joined_groups;

$groups = elgg_get_entities_from_relationship(array(
		'type' => 'group',
		'relationship' => 'member',
		'relationship_guid' => $user->guid,
		'inverse_relationship' => false,
		"offset" => $offset,
		"limit" => ZHAOHU_MANAGER_SEARCH_LIST_LIMIT,
));

if (!$groups) {
	$content = elgg_echo('groups:none');
}
else {
	$content = elgg_view ( "groups/findResult", array (
			"entities" => $groups,
			"count" => $count,
			"offset" => $offset,
			'limit' => ZHAOHU_MANAGER_SEARCH_LIST_LIMIT
	) );
}

echo $content;
exit ();