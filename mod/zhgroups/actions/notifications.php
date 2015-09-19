<?php
$guid = (int) get_input("guid");
$user_guid = elgg_get_logged_in_user_guid();
$rel = get_input("type");
//todo: notifysite -> notifyemail
if($rel == 'sub') {
	add_entity_relationship($user_guid, 'notifyemail', $guid);
} else {
	remove_entity_relationship($user_guid, 'notifyemail', $guid);
}
system_message(elgg_echo('zhgroups:notifications:msg:' . $rel));