<?php

	$user = get_entity($vars['item']->subject_guid);
	$group = get_entity($vars['item']->object_guid);
	$action_type = $vars['item']->action_type;

	$subject_url = "<a href=\"{$user->getURL()}\">{$user->name}</a>";
	$group_url = "<a href=\"{$group->getURL()}\">{$group->name}</a>";
	
	$string = elgg_echo("river:zhgroups:admin:" . $action_type, array($subject_url, $group_url));
	
	echo elgg_view('river/item', array(
		'item' => $vars['item'],
		"summary" => $string
	));