<?php

$gguid = get_input ( "gguid" );
$past = get_input ( "past" );
$group = get_entity($gguid);
$offset = get_input ( "offset", 0 );

if ($group->canEdit())
	$all_status = true;
else
	$all_status = false;

//fordebug echo('past '. $past);
$pz = $past == 'y'?true:false;

$zhaohu_options = array(
		"container_guid" => $gguid,
		"past_zhaohus" => $pz,
		"past_only" => $pz,
		"all_status" => $all_status,
		'offset' => $offset,
		'limit' => ZHAOHU_MANAGER_ZHAOHU_IN_GROUP_LIMIT
		);

$zhaohus = zhaohu_manager_find_zhaohus($zhaohu_options);

$entities = $zhaohus ["entities"];
$count = $zhaohus ["count"];

if (! $entities) {
	$content = elgg_echo ( 'zhaohu:noresults' );
} else {
	$content = elgg_view ( "zhaohu_manager/findResult", array (
			"entities" => $entities,
			"count" => $count,
			"offset" => $offset,
			"limit" => ZHAOHU_MANAGER_ZHAOHU_IN_GROUP_LIMIT
	) );
}

echo $content;
exit ();

	