<?php 
$zhaohu_guid = (int) get_input("guid");

if(empty($zhaohu_guid)){
	register_error(elgg_echo("coupon:gen:err"). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError, coupons::gen, empty zhaohu_guid, logged_user_id "
		.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}

$zhaohu = get_entity($zhaohu_guid);
if($zhaohu->getSubtype() != Zhaohu::SUBTYPE) {
	register_error(elgg_echo("coupon:gen:err") . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError, coupons::gen, invalid zhaohu, zhaohu_id $zhaohu_guid, user_id "
		.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}

genCoupons($zhaohu);
forward(REFERER);
