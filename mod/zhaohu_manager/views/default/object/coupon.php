<?php

$coupon = $vars["entity"];
$content = "";
$status = $coupon->used?'used':'unused';
if(elgg_in_context("cp_event")) {
	//$content .= '<label>' . elgg_echo('coupon:id') . '</label>: ' .  $coupon->guid.'<br>';
	$content .= '<label>' . elgg_echo('coupon:code') . '</label>: ' .  $coupon->code.'<br>';
	$content .= '<label>' . elgg_echo('coupon:status') . '</label>: ' . elgg_echo($status) .'<br>';
	$content .= '<label>' . elgg_echo('coupon:count') . '</label>: ' . $coupon->count .'<br>';
	$url = elgg_get_site_url()."zhaohus/coupon/qrcode?guid={$coupon->event_guid}&code={$coupon->code}";
	$content .= elgg_echo('coupon:qrcode:title', array($url)).'<br>';
	$content .= '<label>' .elgg_echo('coupon:buyer'). '</label>';
	$user = get_entity($coupon->user_guid);
	$content .= elgg_view_entity($user, array("full_view" => false));
	$content .= elgg_view("output/url", array(
		"is_action" => true,
		"class" => "zhaohu-join-button",
		"href" => "action/coupon/delete?guid=" . $coupon->guid,
		"text" => elgg_echo('delete')));
} else{
	$content .= '<label>' .elgg_echo('coupon:event'). '</label>';
	$event = get_entity($coupon->event_guid);
	$content .= elgg_echo('coupon:event:title', array($event->getURL(), $event->title)).'<br>';
	$content .= '<label>' . elgg_echo('coupon:status') . '</label>: ' . elgg_echo($status) .'<br>';
	$content .= '<label>' . elgg_echo('coupon:count') . '</label>: ' . $coupon->count .'<br>';
	$url = elgg_get_site_url()."zhaohus/coupon/qrcode?guid={$coupon->event_guid}&code={$coupon->code}";
	$content .= elgg_echo('coupon:qrcode:title', array($url)).'<br>';
}

echo $content;
