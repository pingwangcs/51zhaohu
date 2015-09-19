<?php

	$options = array(
		"count" => elgg_extract("count", $vars),
		"offset" => elgg_extract("offset", $vars),
		"limit" => elgg_extract("limit", $vars),//ZHAOHU_MANAGER_SEARCH_LIST_LIMIT
		"full_view" => false,
		//'list_type' => 'gallery',
		//'gallery_class' => 'zhaohu-gallery',
		//'list_type_toggle' => false,		
		"pagination" => true			
	);
	
	//fordebug system_message("count ".$options["count"]);
	
	$list = elgg_view_entity_list($vars["entities"], 
			$options);

	$result .= "<div id='zhaohu_manager_zhaohu_listing'>";
	if(!empty($list)){
		$result .= $list;
	} else {
		$result .= elgg_echo('zhaohu:noresults');
	}
	$result .= "</div>";
	
	//$result .= elgg_view("zhaohu_manager/onthemap", $vars);
	
	/*
	if($vars["count"] > ZHAOHU_MANAGER_SEARCH_LIST_LIMIT) {
		$result .= '<div id="zhaohu_manager_zhaohu_list_search_more" rel="'. ((isset($vars["offset"])) ? $vars["offset"] : ZHAOHU_MANAGER_SEARCH_LIST_LIMIT).'">';
		$result .= elgg_echo('zhaohu_manager:list:showmore');
		$result .= ' (' . ($vars["count"] - ($offset + ZHAOHU_MANAGER_SEARCH_LIST_LIMIT)) . ')</div>';
	}*/
	echo $result;
	