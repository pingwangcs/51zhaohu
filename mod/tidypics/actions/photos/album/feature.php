<?php

// Get input data
$album_guid = get_input('album_guid');
$action = get_input('action_type');

$album = get_entity($album_guid);

if (!elgg_instanceof($album, 'object', 'album')) {
	register_error(elgg_echo('album:invalid_album'). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError , tidypics:set_cover, album:invalid_album, album_id {$album_guid} , user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}

//get the action, is it to feature or unfeature
if ($action == "feature") {
	$album->featured = "y";
	system_message(elgg_echo('album:featured', array($album->title)));
} else {
	$album->featured = "n";
	system_message(elgg_echo('album:unfeatured', array($album->title)));
}

forward(REFERER);