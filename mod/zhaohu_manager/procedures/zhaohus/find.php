<?php
$state = get_input ( "state" );
$city = get_input ( "city" );
$tag = get_input ( "tag" );
$past = get_input ( "past");
$offset = get_input ( "offset", 0 );
$past_only = $past=='y'?true:false;
//$featured_zhaohu = get_input("featured", "n"); //featured=y
$unfeatured_only = get_input("unfeatured_only", "n");

$options = array (
		'state' => $state,
		//'city' => $city, //to get more zhaohu
		"past_zhaohus" => $past_only, //must have
		'past_only' => $past_only,
		'offset' => $offset,
		'limit' => ZHAOHU_MANAGER_SEARCH_LIST_LIMIT,
		//'featured_zh' => $featured_zhaohu,
		'unfeatured_only' => $unfeatured_only,
);

$res = find_zhaohus_by_tag_title($options, $tag);
//$res = find_zhaohus_feature_up($options, $tag);
$entities = $res["entities"];
$count = $res["count"];

if (! $entities) {
	$content = elgg_echo ( 'zhaohu:noresults' );
} else {
	$content = elgg_view ( "zhaohu_manager/findResult", array (
			"entities" => $entities,
			"count" => $count,
			"offset" => $offset,
			"limit" => ZHAOHU_MANAGER_SEARCH_LIST_LIMIT
	) );
}

echo $content;
exit ();

	