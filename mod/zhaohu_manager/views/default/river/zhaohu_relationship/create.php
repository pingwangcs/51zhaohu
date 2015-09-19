<?php

	$user = get_entity($vars['item']->subject_guid);
	$zhaohu = get_entity($vars['item']->object_guid);
	$action_type = $vars['item']->action_type;
	
	$subject_url = "<a href=\"{$user->getURL()}\">{$user->name}</a>";
	$zhaohu_url = "<a href=\"" . $zhaohu->getURL() . "\">" . mb_substr($zhaohu->title, 0, ZHAOHU_TITLE_SHORT) . "</a>";
	
	//$relationtype = $zhaohu->getRelationshipByUser($user->getGUID()); 
	
	$string = elgg_echo("river:zhaohu_relationship:create:" . $action_type, array($subject_url, $zhaohu_url));
	
	echo elgg_view('river/item', array(
		'item' => $vars['item'],
		"summary" => $string
	));