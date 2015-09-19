<?php
	$options = array(
		"count" => elgg_extract("count", $vars),
		"offset" => elgg_extract("offset", $vars),
		"limit" => elgg_extract("limit", $vars),//ZHAOHU_MANAGER_SEARCH_LIST_LIMIT
		"full_view" => false,
		"pagination" => true			
	);
	
	$list = elgg_view_entity_list($vars["entities"], $options);

	$result .= "<div id='zhaohu_manager_zhaohu_listing_mobile' class='zhaohu_listing_mobile'>";
	if(!empty($list)){
		$result .= $list;
	} else {
		$result .= elgg_echo('zhaohu:noresults');
	}
	$result .= "</div>";
	
	echo $result;
	