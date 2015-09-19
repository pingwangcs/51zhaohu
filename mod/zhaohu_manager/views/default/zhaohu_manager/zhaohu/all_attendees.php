<?php

$options = array(
		"count" => elgg_extract("count", $vars),
		"offset" => elgg_extract("offset", $vars),
		"limit" => ZHAOHU_MANAGER_ALL_ATTENDEE_LIMIT,
		"full_view" => false,
		//'list_type' => 'gallery',
		//'gallery_class' => 'zhaohu-gallery',
		"pagination" => true,
		"size" => "small"
);

$list = elgg_view_entity_list($vars["entities"], $options);

if(!empty($list)){
	$result = $list;
} else {
	$result = "";
}

echo elgg_view_module("main", "", $result);
