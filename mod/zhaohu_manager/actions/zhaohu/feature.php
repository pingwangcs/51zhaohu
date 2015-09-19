<?php	
/**
 * Feature a zhaohu
 *
 * @package zhaohu_manager
 */

$zhaohu_guid = get_input('guid');
$action = get_input('action_type');

$zhaohu = get_entity($zhaohu_guid);

if (!elgg_instanceof($zhaohu, 'object', 'zhaohu')) {
	register_error(elgg_echo("zhaohu:feature:error"). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError ,zhaohu:feature, invalid zhaohu, zhaohu_id $zhaohu_guid, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}

//get the action, is it to feature or unfeature
if ($action == "feature") {
	$zhaohu->featured_zh = "y";
	system_message(elgg_echo('zhaohu:feature_done', array($zhaohu->title)));
} else {
	$zhaohu->featured_zh = "n";
	system_message(elgg_echo('zhaohu:unfeature_done', array($zhaohu->title)));
}

forward(REFERER);
