<?php
/**
 * Elgg notifications plugin
 *
 * @package ElggNotifications
 */

elgg_register_event_handler('init', 'system', 'notifications_plugin_init');

function notifications_plugin_init() {

	elgg_extend_view('css/elgg','notifications/css');

	// Unset the default notification settings
	elgg_unregister_plugin_hook_handler('usersettings:save', 'user', 'notification_user_settings_save');
	elgg_unextend_view('forms/account/settings', 'core/settings/account/notifications');
	elgg_extend_view('forms/account/settings', 'notifications/subscriptions/personal');
	elgg_register_plugin_hook_handler('usersettings:save', 'user', 'zhnotifications_user_settings_save');

	// update notifications based on relationships changing
	elgg_register_event_handler('delete', 'member', 'notifications_relationship_remove');
}

function zhnotifications_user_settings_save() {
	$base = elgg_get_plugins_path() . 'zhnotifications';
	include($base . "/actions/save.php");
}



/**
 * Update notifications when a relationship is deleted
 *
 * @param string $event
 * @param string $object_type
 * @param object $relationship
 */
function notifications_relationship_remove($event, $object_type, $relationship) {
	global $NOTIFICATION_HANDLERS;

	$user_guid = $relationship->guid_one;
	$object_guid = $relationship->guid_two;

	// loop through all notification types
	foreach($NOTIFICATION_HANDLERS as $method => $foo) {
		remove_entity_relationship($user_guid, "notify{$method}", $object_guid);
	}
}


