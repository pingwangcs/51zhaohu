<?php

/**
 * Elgg notifications
 *
 * @package ElggNotifications
 */
$user = elgg_get_logged_in_user_entity();
$result = false;
$changed = false;
$old_settings = get_user_notification_settings($user->guid);
global $NOTIFICATION_HANDLERS;
foreach($NOTIFICATION_HANDLERS as $method => $foo) {
	$personal[$method] = get_input($method.'personal');
	if (($old_settings->$method && $personal[$method] == '1') || 
		(!$old_settings->$method && $personal[$method] != '1'))
		continue;
	
	$result = set_user_notification_setting($user->guid, $method, ($personal[$method] == '1') ? true : false);
	if (!$result) {
		register_error(elgg_echo('notifications:usersettings:save:fail') . elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError , error calling set_user_notification_setting, user id " . $user->guid
		, "ERROR");
		forward(REFERER);
	} else {
		$changed = true;
	}
}
if ($changed) {
	system_message(elgg_echo('notifications:subscriptions:success'));
}

