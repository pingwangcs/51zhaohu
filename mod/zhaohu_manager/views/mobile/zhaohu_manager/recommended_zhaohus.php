<?php
	// generate a div which includes all the recommended zhaohus
	
$search_options = array (
		'tags' => elgg_echo('AllInterests'),
		'state' => elgg_echo('All'),
		'city' => elgg_echo('All'),
		'offset' => 0,
		'limit' => ZHAOHU_RECOMMENDED_SHOW_LIMIT,
		'featured_only' => 'y',
);

$zhaohus = zhaohu_manager_find_zhaohus($search_options);
$zhaohus_entities = $zhaohus["entities"];

$display_options = array(
		"count" => ZHAOHU_RECOMMENDED_SHOW_LIMIT,
		"offset" => 0,
		"limit" => ZHAOHU_RECOMMENDED_SHOW_LIMIT, //5
		"full_view" => false,
		"pagination" => false
);

$list = elgg_view_entity_list($zhaohus_entities, $display_options);

$content = "<div id='zhaohu_homepage_recommended_zhaohus' class='zhaohu_listing_mobile'>";

if(!empty($list)){
	$content .= $list;
} else {
	$content .= elgg_echo('zhaohu:noresults');
}

$content .= "</div>";

echo $content;