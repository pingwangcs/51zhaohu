<?php
/**
 * List all suggested groups
 */
elgg_push_context('zhg_contact');
$entity = $vars['entity'];
$isUserProfile = $vars['isUserProfile'];
$context = $isUserProfile ? 'cp_user_profile':'cp_event';
elgg_push_context($context);
$options = array(
		"count" => elgg_extract("count", $vars),
		"limit" => false,
		"full_view" => false,
		"pagination" => false
);

$list = elgg_view_entity_list($vars["entities"],
		$options);
elgg_pop_context($context);

$result .= "<div id='zhaohu_manager_member_listing'>";
if(!empty($list)){
	$result .= $list;
} else {
	$result .= elgg_echo('zhaohu_manager:list:noresults');
}
$result .= "</div>";

echo elgg_view_module("main", "", $result);
