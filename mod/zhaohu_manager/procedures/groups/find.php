<?php
$state = get_input ( "state" );
$city = get_input ( "city" );
$tag = get_input ( "tag" );
$offset = get_input ( "offset", 0 );
$findResult = null;
// groups plugin saves tags as "interests" - see groups_fields_setup() in start.php

$options = array (
		'state' => $state,
		//'city' => $city, //to get more zhaohu
		'offset' => $offset,
		'limit' => ZHAOHU_MANAGER_SEARCH_LIST_LIMIT
);

$res = find_groups_by_tag_title($options, $tag);
$entities = $res["entities"];
$count = $res["count"];

if (!$count) {
	$content = elgg_echo ( 'groups:search:none' );
} else {
	$content = elgg_view ( "groups/findResult", array (
			"entities" => $entities,
			"count" => $count,
			"offset" => $offset,
			'limit' => ZHAOHU_MANAGER_SEARCH_LIST_LIMIT
	) );
}

echo $content;
exit ();