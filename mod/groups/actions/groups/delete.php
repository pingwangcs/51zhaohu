<?php
/**
 * Delete a group
 */
		
$guid = (int) get_input('guid');
if (!$guid) {
	// backward compatible
	elgg_deprecated_notice("Use 'guid' for group delete action", 1.8);
	$guid = (int)get_input('group_guid');
}
$entity = get_entity($guid);

if (!$entity->canEdit()) {
	register_error(elgg_echo('group:notdeleted') . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError group:notdeleted group_id {$guid} , user_id " 
	. elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}

if (($entity) && ($entity instanceof ElggGroup)) {
	// delete group icons
	$owner_guid = $entity->owner_guid;
	$prefix = "groups/" . $entity->guid;
	$imagenames = array('.jpg', 'tiny.jpg', 'small.jpg', 'medium.jpg', 'large.jpg');
	$img = new ElggFile();
	$img->owner_guid = $owner_guid;
	foreach ($imagenames as $name) {
		$img->setFilename($prefix . $name);
		$img->delete();
	}

	// delete group
	updateJoinedGroupsForDeletion($entity);
	if ($entity->delete()) {
		system_message(elgg_echo('group:deleted'));
		forward(elgg_get_site_url());
	} else {
		register_error(elgg_echo('group:notdeleted') . elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError group:notdeleted group_id {$guid} , user_id "
		. elgg_get_logged_in_user_guid(), "ERROR");		
	}
} else {
	register_error(elgg_echo('group:notdeleted') . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError group:notdeleted group_id {$guid} , user_id "
	. elgg_get_logged_in_user_guid(), "ERROR");
}
forward(REFERER);
