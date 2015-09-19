<?php
$content = '<div class="messages-buttonbank">';
$content .= elgg_view('output/url', array(
		'text' => elgg_echo('messages:inbox'),
		'href' => "messages/inbox/" . elgg_get_logged_in_user_entity()->username,
		'class' => 'elgg-button elgg-button-cancel',
));
$content .= elgg_view('output/url', array(
		'text' => elgg_echo('messages:sentmessages'),
		'href' => "messages/sent/" . elgg_get_logged_in_user_entity()->username,
		'class' => 'elgg-button elgg-button-cancel',
));
$content .= '</div>';
echo $content;