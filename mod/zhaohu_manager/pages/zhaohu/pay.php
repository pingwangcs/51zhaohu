<?php

if (!elgg_is_logged_in()) {
	register_error("zhaohu:rsvpByPay:notloggedin");
	forword(elgg_get_site_url());
}

$guid = (int) get_input("guid");
$zhaohu = false;

if(empty($guid)){
	register_error(elgg_echo('zhaohu:rsvpByPay:err') . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError ,zhaohu:rsvpByPay, empty guid, user_id "
			.elgg_get_logged_in_user_guid(), "ERROR");
			forward();
}

$zhaohu = get_entity($guid);
if(!$zhaohu || $zhaohu->getSubtype() != Zhaohu::SUBTYPE) {
	register_error(elgg_echo('zhaohu:rsvpByPay:err') . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError ,zhaohu:rsvpByPay, invalide zhaohu, zhaohu_id $guid, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward();
}


$user_guid = elgg_get_logged_in_user_guid();
DoRsvp($guid, $user_guid, ZHAOHU_MANAGER_RELATION_ATTENDING);
forward($zhaohu->getURL());