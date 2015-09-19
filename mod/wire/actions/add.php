<?php
/**
 * Action for adding a wire post
 * 
 */
$entity_guid = (int) get_input('entity_guid');
//fordebug register_error("in action entity_guid {$entity_guid}");
// don't filter since we strip and filter escapes some characters
$body = get_input('body', '', false);

$access_id = ACCESS_PUBLIC;
$method = 'site';
$parent_guid = (int) get_input('parent_guid');

// Let's see if we can get an entity with the specified GUID
$entity = get_entity($entity_guid);
if (!$entity) {
	register_error(elgg_echo("wire:entity:notfound"));
	forward(REFERER);
}
// make sure the post isn't blank
if (empty($body)) {
	register_error(elgg_echo("wire:blank"));
	forward(REFERER);
}

$guid = wire_save_post($body, elgg_get_logged_in_user_guid(), $entity_guid, $access_id, $parent_guid, $method);
if (!$guid) {
	register_error(elgg_echo("wire:error"));
	forward(REFERER);
}

// Send response to original poster if not already registered to receive notification
if ($parent_guid) {
	wire_send_response_notification($guid, $parent_guid, $user, $entity);
	$parent = get_entity($parent_guid);
	forward($entity->getURL());
	//forward("wire/thread/$parent->wire_thread");
}

system_message(elgg_echo("wire:posted"));
forward(REFERER);
