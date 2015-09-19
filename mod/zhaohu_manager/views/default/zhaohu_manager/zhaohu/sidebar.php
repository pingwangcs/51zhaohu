<?php

$zhaohu = $vars["entity"];

$sidebar_content = '<div id="zhaohu_zhaohu_page_right_bar">';

if (elgg_is_logged_in() && $zhaohu->status == 'published') {
	// add add-to-calender button
	$sidebar_content .= elgg_view("zhaohu_manager/zhaohu/addthisevent", array("entity" => $zhaohu));
}

if ($zhaohu->canEdit()) {
	// add zhaohu operation buttons
	$sidebar_content .= elgg_view("zhaohu_manager/zhaohu/operation", $vars);
}

$sidebar_content .= '<div class="zhaohu-group-sidebar-div zhaohu-manager-zhaohu-list-attendees">';
$sidebar_content .= elgg_view("zhaohu_manager/zhaohu/attendees", $vars);
$sidebar_content .= '</div>';

// Render zhaohu map if there is location info
if($zhaohu->location)
{
	$zhaohu_map = '<div id="zhaohu_gm_canvas" style="width: 200px; height: 200px;"></div>';
	$zhaohu_map .= elgg_view(
						"input/button",
						array(
								"is_action" => true,
								'id' => 'zhaohu_manager_zhaohu_get_directions',
								'class' => 'elgg-button-action',
								"value" => elgg_echo('zhaohu:getdirections')));
	
	$sidebar_content .= elgg_view(
							"zhaohu_manager/zhaohu/div_container",
							array(
									"content" => $zhaohu_map,
									"div_class" => "zhaohu-manager-zhaohu-map",
									"div_id" => "zhaohu_manager_zhaohu_map"));
}

$sidebar_content .= '</div>';

echo $sidebar_content;