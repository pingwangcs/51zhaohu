<?php

$zhaohu_guid = (int) get_input("guid");

$subject = isset($_SESSION['zhaouhu:subject'])?$_SESSION['zhaouhu:subject']:'';
$msg = isset($_SESSION['zhaouhu:msg'])?$_SESSION['zhaouhu:msg']:'';
$body .= "<label>" . elgg_echo('zhaohu:broadcast:subject');
$body .= elgg_view('input/text', array('name' => 'subject', 'value' => $subject)) . "</label>";
$body .= "<br><br><label>" . elgg_echo('zhaohu:broadcast:message');
$body .= elgg_view('input/longtext', array('name' => 'message', 'value' => $msg)) . "</label>";

// loader to show admin something is happening
$body .= "<div id='message_sending' class='elgg-ajax-loader left hidden'></div>";
$body .= "<br>";
$body .= "<div class='elgg-footer'>";
$body .= elgg_view('input/hidden', array('name'=>'zhaohu_guid', 'value'=>$zhaohu_guid));
$body .= elgg_view('input/submit', array(
									'value' => elgg_echo('send'),
									'name' => 'send_message',
									'js' => "onclick=\"$('#message_sending').show();$('.submit_button').hide();\""
									));
$body .= elgg_view('output/url', array(
		'text' => elgg_echo('cancel'),
		'href' => get_entity($zhaohu_guid)->getURL(),
		'class' => 'elgg-button elgg-button-cancel',
));
$body .= "</div>";

echo $body;
