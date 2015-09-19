<?php

$zhaohu_guid = (int) get_input("guid");
$fields = array("code" => ELGG_ENTITIES_ANY_VALUE);

if (elgg_is_sticky_form('usecoupon')) {
	$fields = array_merge($fields, elgg_get_sticky_values('usecoupon'));
}
$body = "";
$body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('coupon:code') . "</td><td>" 
		. elgg_view('input/text', array('name' => 'code', 'value' => $fields["code"])) . "</td></tr>";

$body .= elgg_view('input/hidden', array('name'=>'guid', 'value'=>$zhaohu_guid));
$use_button = elgg_view('input/submit', array(
		'value' => elgg_echo('coupon:use'),
		'name' => 'use',
));

$zhaohu = get_entity($zhaohu_guid);
if($zhaohu){
	$cancelURL = $zhaohu->getURL();
}

$cancel_button = elgg_view('output/url', array(
		'text' => elgg_echo('cancel'),
		'href' => $cancelURL,
		'class' => 'elgg-button elgg-button-cancel',
));

$body .= $use_button . $cancel_button;

echo $body;
