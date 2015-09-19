<?php

$coupon_guid = (int) get_input("guid");

if(!elgg_is_admin_logged_in()) {
	register_error(elgg_echo("coupon:nopermission"));
	elgg_log("ZHError ,coupon:delete, not admin, coupon_guid {$coupon_guid}, logged_user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}
if(empty($coupon_guid)){
	register_error(elgg_echo("coupon:delete:err"). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError ,coupon:delete, empty coupon_id, logged_user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}

$coupon = get_entity($coupon_guid);
if($coupon->getSubtype() != Coupon::SUBTYPE) {
	register_error(elgg_echo("coupon:delete:err"). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError ,coupon:delete, invalid coupon, coupon_guid {$coupon_guid}, logged_user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}

if(!$coupon->delete()){
	register_error(elgg_echo("coupon:delete:err"). elgg_echo("zhaohu:sorry"));
}
else {
	system_message(elgg_echo("coupon:delete:ok"));
}
forward(REFERER);


