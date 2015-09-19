<?php
/**
 * content for the group river/activity widget
 */
echo "<h3>" . elgg_echo('zhgroups:whatsnew') . "</h3>";

$group = $vars["entity"];
$group_guid = $group->guid;


if ($group_guid) {
	// get activity filter
	//$activity_filter = $widget->activity_filter;
	
	//get the number of items to display
	$dbprefix = elgg_get_config("dbprefix");
	$offset = 0;
	$limit = ZHAOHU_GROUPS_ACTIVITY_LIMIT;
	
	$sql = "SELECT {$dbprefix}river.*";
	$sql .= " FROM {$dbprefix}river";
	$sql .= " INNER JOIN {$dbprefix}entities AS entities1 ON {$dbprefix}river.object_guid = entities1.guid";
	$sql .= " WHERE (entities1.container_guid in (" . $group_guid . ")";
	$sql .= " OR {$dbprefix}river.object_guid IN (" . $group_guid . "))";
	/*
	if (!empty($activity_filter) && is_string($activity_filter)) {
		list($type, $subtype) = explode(",", $activity_filter);
		
		if (!empty($type)) {
			$filter_where = " ({$dbprefix}river.type = '" . sanitise_string($type) . "'";
			
			if (!empty($subtype)) {
				$filter_where .= " AND {$dbprefix}river.subtype = '" . sanitise_string($subtype) . "'";
			}
			
			$filter_where .= ")";
			$sql .= " AND " . $filter_where;
		}
	}*/
	
	$sql .= " AND " . get_access_sql_suffix("entities1");
	$sql .= " ORDER BY {$dbprefix}river.posted DESC";
	$sql .= " LIMIT {$offset},{$limit}";
	
	$items = get_data($sql, "elgg_row_to_elgg_river_item");
	
	if (!empty($items)) {
		$options = array(
			"pagination" => false,
			"count" => count($items),
			"items" => $items,
			"list_class" => "elgg-list-river elgg-river",
			"limit" => $limit,
			"offset" => $offset
		);
		
		$river_items = elgg_view("page/components/list", $options);
	} else {
		$river_items = elgg_echo("widgets:group_river_widget:view:noactivity");
	}
	
	// display
	echo $river_items;
} else {
	echo elgg_echo("zhgroups:not_valid_group");
}

	