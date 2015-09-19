<?php
/**
 * List all suggested groups
 */
elgg_push_context('zhg_contact');
$options = array(
		"count" => elgg_extract("count", $vars),
		"limit" => false,
		"full_view" => false,
		//'list_type' => 'gallery',
		//'gallery_class' => 'zhaohu-gallery',
		"pagination" => false
);

$list = elgg_view_entity_list($vars["entities"],
		$options);
elgg_pop_context('zhg_contact');

$result .= "<div id='zhaohu_manager_member_listing'>";
if(!empty($list)){
	$result .= $list;
} else {
	$result .= elgg_echo('zhaohu_manager:list:noresults');
}
$result .= "</div>";

echo elgg_view_module("main", "", $result);
