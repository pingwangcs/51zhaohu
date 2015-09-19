<?php 
$guid= $vars["guid"];

//todo: notifysite -> notifyemail
if(check_entity_relationship ( elgg_get_logged_in_user_guid (), 'notifyemail', $guid ))
	$rel = 'unsub';
else
	$rel = 'sub';

echo elgg_view("output/url",
		array("is_action" => true,
				'class' => 'zhaohu-action',
				"href" => "action/zhgroups/notifications?guid=" . $guid . "&type=" . $rel,
				"text" => elgg_echo('zhgroups:notifications:'.$rel)));

