<?php
/**
 * Elgg report action
 * 
 * @package ElggReportContent
 */
$title = get_input('title');
$description = get_input('description');
$address = get_input('address');
$access = ACCESS_PRIVATE; //this is private and only admins can see it

if ($title && $address) {

	$report = new ElggObject;
	$report->subtype = "reported_content";
	$report->owner_guid = elgg_get_logged_in_user_guid();
	$report->title = $title;
	$report->address = $address;
	$report->description = $description;
	$report->access_id = $access;

	if ($report->save()) {
		if (!elgg_trigger_plugin_hook('reportedcontent:add', 'system', array('report' => $report), true)) {
			$report->delete();
			register_error(elgg_echo('reportedcontent:failed') . elgg_echo("zhaohu:sorry"));
			elgg_log("ZHError reportedcontent:failed user_id " .elgg_get_logged_in_user_guid()
			, "ERROR");
		} else {
			system_message(elgg_echo('reportedcontent:success'));
			$report->state = "active";
		}
		forward($address);
	} else {
		register_error(elgg_echo('reportedcontent:failed') . elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError reportedcontent:failed user_id " .elgg_get_logged_in_user_guid()
		, "ERROR");
		forward($address);
	}
} else {
	register_error(elgg_echo('reportedcontent:failed') . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError reportedcontent:failed user_id " .elgg_get_logged_in_user_guid()
	, "ERROR");
	forward($address);
}
