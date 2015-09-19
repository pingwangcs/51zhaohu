<?php
$userId = elgg_get_page_owner_guid();
$offset = get_input('offset', 0);
$count = elgg_get_entities_from_relationship(array(
		'type' => 'group',
		'relationship' => 'member',
		'relationship_guid' => $userId,
		'inverse_relationship' => false,
		'count' => true,
));

if (!$count) {
	echo elgg_echo('groups:none');
}
else {
	$groups = elgg_get_entities_from_relationship(array(
			'type' => 'group',
			'relationship' => 'member',
			'relationship_guid' => $userId,
			'inverse_relationship' => false,
			"offset" => $offset,
			"limit" => ZHGROUPS_IN_PROFILE_LIMIT,
	));
// 	echo '<div id="zhaohu_profile_joined_groups">';
// 	echo "<h3>".elgg_echo("zhgroups:memberof", array($count))."</h3>";
// 	elgg_push_context('inprofile');
// 	$options = array(
// 			"count" => $count,
// 			"offset" => $offset,
// 			"limit" => ZHGROUPS_IN_PROFILE_LIMIT,
// 			"full_view" => false,
// 			'list_type' => 'gallery',
// 			//'gallery_class' => 'zhaohu-gallery',
// 			"pagination" => true
// 	);	
// 	//fordebug system_message("count ".$options["count"]);	
// 	echo elgg_view_entity_list($groups, $options);
// 	echo '</div>';

	elgg_pop_context('inprofile');

}
