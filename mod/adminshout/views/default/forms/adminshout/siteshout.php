<?php

$body = "<p>" . elgg_echo('adminshout:description') . "</p>";
$body .= "<label>" . elgg_echo('adminshout:subject:label');
$body .= elgg_view('input/text', array('name' => 'subject')) . "</label>";
$body .= "<br><br><label>" . elgg_echo('adminshout:message:label') . "</label>";
$body .= elgg_view('input/longtext', array('name' => 'message'));

// loader to show admin something is happening
$body .= "<div id='message_sending' class='elgg-ajax-loader left hidden'></div>";
$body .= "<br>";
$body .= "<div class='elgg-footer'>";
$body .= elgg_view('input/hidden', array('name'=>'group_guid', 'value'=>$group_guid));
$body .= elgg_view('input/submit', array(
									'value' => elgg_echo('adminshout:send'),
									'name' => 'send_message',
									'js' => "onclick=\"$('#message_sending').show();$('.submit_button').hide();\""
									));
$body .= "</div>";

echo $body;
