<?php
/**
 * List all suggested groups
 */
elgg_push_context('find_groups');
$options = array(
		"count" => elgg_extract("count", $vars),
		"offset" => elgg_extract("offset", $vars),
		"limit" => ZHAOHU_MANAGER_SEARCH_LIST_LIMIT,
		"full_view" => false,
		'list_type' => 'gallery',
		'gallery_class' => 'zhaohu-gallery',
		'list_type_toggle' => false,
		"pagination" => true
);

//fordebug system_message("count ".$options["count"]);

$list = elgg_view_entity_list($vars["entities"],
		$options);
elgg_pop_context('find_groups');
//echo $list;

$result .= "<div id='zhaohu_manager_group_listing'>";
if(!empty($list)){
	$result .= $list;
} else {
	$result .= elgg_echo('zhaohu:noresults');
}
$result .= "</div>";

echo elgg_view_module("main", "", $result);
