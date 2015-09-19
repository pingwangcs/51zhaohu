<?php
// generate a div which includes all the recommended groups

$search_options = array (
		'type' 			=> 'group',
		'subtype' 		=> 0,
		'offset' 		=> 0,
		'limit' 		=> 5, // TODO: change this to some constant
		'joins' => array(),
		'wheres' => array(),
);

$search_options['metadata_name_value_pairs'][] = array('name' => 'featured_group', 'value' => 'yes');
$search_options['count'] = false;
$recommended_groups = elgg_get_entities_from_metadata($search_options);

$display_options = array(
		"count" => ZHAOHU_RECOMMENDED_SHOW_LIMIT,
		"offset" => 0,
		"limit" => ZHAOHU_RECOMMENDED_SHOW_LIMIT, //5
		"full_view" => false,
		"pagination" => false
);

$header_title = elgg_echo("zhaohu:recommended_groups");
$content = "<div id='zhaohu_homepage_recommended_groups' class='zhaohu-homepage-right-sidebar-div'>";
$content .= "<div id='zhaohu_homepage_recommended_groups_header' class='zhaohu-homepage-right-sidebar-div-header'>$header_title</div>";
$content .= "<div id='zhaohu_homepage_recommended_groups_content' class='zhaohu-homepage-right-sidebar-div-content'>";

elgg_push_context("recommended_groups");
$list = elgg_view_entity_list($recommended_groups, $display_options);
elgg_pop_context("recommended_groups");

if(!empty($list)){
	$content .= $list;
} else {
	$content .= elgg_echo('zhaohu:noresults');
}

$content .= "</div>";
$content .= "</div>";
echo $content;