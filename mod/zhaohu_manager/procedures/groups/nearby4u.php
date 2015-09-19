<?php
$user = elgg_get_logged_in_user_entity();
$offset = get_input ( "offset", 0 );

$user = elgg_get_logged_in_user_entity();
$group_guids = elgg_get_entities_from_relationship(array(
		'type' => 'group',
		'relationship' => 'member',
		'relationship_guid' => $user->guid,
		'inverse_relationship' => false,
		'limit' => false,
		'callback' => 'zhaohu_guid_only_callback'
));

$state = empty($user->state)?'WA':$user->state;

$entities_options = array (
		'type' => 'group',
		'offset' => $offset,
		'limit' => ZHAOHU_MANAGER_SEARCH_LIST_LIMIT 
);

$entities_options ['metadata_name_value_pairs'] [] = array (
		'name' => 'state',
		'value' => $state
);
$entities_options['order_by_metadata'] = array("name" => 'score', "direction" => 'DESC', "as" => "integer");

$nearby_groups = elgg_get_entities_from_metadata ( $entities_options );
foreach($nearby_groups as $key => $g) {
	if (in_array($g->guid, $group_guids)) {
    	unset($nearby_groups[$key]);
	}
}

$count = get_input ( "num", ZHAOHU_MANAGER_SEARCH_LIST_LIMIT );

if(!$_SESSION['_nearby_group']) 
	$count = $_SESSION['_nearby_group'];
else
	$count = getGroupsNearby($state, '', 0, 0, true) - countJoinedGroupsInState($user->guid, $state);

if (! $nearby_groups) {
	$content = elgg_echo ( 'groups:search:none' );
} else {
	$content = elgg_view ( "groups/findResult", array (
			"entities" => $nearby_groups,
			"count" => $count,
			"offset" => $offset,
			'limit' => ZHAOHU_MANAGER_SEARCH_LIST_LIMIT
	) );
}

echo $content;
exit ();