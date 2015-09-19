<?php

/**
 * Group zhaohu manager module
 */

$group = elgg_get_page_owner_entity();

if ($group->zhaohu_manager_enable == "no") {
	return true;
}

$zhaohu_options = array();
$zhaohu_options["container_guid"] = elgg_get_page_owner_guid();

$zhaohus = zhaohu_manager_find_zhaohus($zhaohu_options);

elgg_push_context("widgets");
$content = elgg_view_entity_list($zhaohus['entities'], array('count' => 0,
                                                            'offset' => 0,
                                                            'limit' => 5,
                                                            'full_view' => false));
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('zhaohu:noresults') . '</p>';
}

$all_link = elgg_view('output/url', array(
	'href' => "/zhaohus/zhaohu/list/" . $group->getGUID(),
	'text' => elgg_echo('link:view:all'),
));

$new_link = elgg_view('output/url', array(
	'href' => "/zhaohus/zhaohu/new/" . $group->getGUID(),
	'text' => elgg_echo('zhaohu:new'),
));

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('zhaohu_manager:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));
