<?php

$group = $vars['entity'];
$limit = 8;
//offset
$groups = getGroupsNearbyForGroup($group->state, $group->city, $group->guid, $limit);

$options = array(
		"full_view" => false,
		//'list_type' => 'gallery',
		//'gallery_class' => 'zhaohu-gallery',
		'list_type_toggle' => false,
		'list_class' => 'zhaohu-list',
);
elgg_push_context('nearby_groups');
$list = elgg_view_entity_list($groups, $options);
elgg_push_context('nearby_groups');

if(!empty($list)){
	$result .= "<div class='zhgroups-group-listing zhaohu-group-sidebar-div'>";
	$result .= '<div id="nearby_zhaohu_groups_title">' . elgg_echo('zhgroups:nearby') . "</div>";
	$result .= $list;
	$result .= "</div>";
} else {
	$result = '';
}

echo $result;
