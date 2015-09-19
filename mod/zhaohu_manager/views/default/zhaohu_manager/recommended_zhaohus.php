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

elgg_push_context("recommended_zhaohu");
$list = elgg_view_entity_list($zhaohus_entities, $display_options);
elgg_pop_context("recommended_zhaohu");

$header_title = elgg_echo("zhaohu:recommended_zhaohus");
$content = "<div id='zhaohu_homepage_recommended_zhaohus' class='zhaohu-homepage-right-sidebar-div'>";
$content .= "<div id='zhaohu_homepage_recommended_zhaohus_header' class='zhaohu-homepage-right-sidebar-div-header'>$header_title</div>";
$content .= "<div id='zhaohu_homepage_recommended_zhaohus_content' class='zhaohu-homepage-right-sidebar-div-content'>";

if(!empty($list)){
	$content .= $list;
} else {
	$content .= elgg_echo('zhaohu:noresults');
}

$content .= "</div>";
// more recommended zhaohus
// $more_link = elgg_view("output/url", array("href" => "#", "text" => elgg_echo('zhaohu:more_recommended_zhaohus'), "id"=>"more_recommended_zhaohus"));
// $content .= "<div class='zhaohu-homepage-right-sidebar-div-footer'>$more_link</div>";
$content .= "</div>";
echo $content;