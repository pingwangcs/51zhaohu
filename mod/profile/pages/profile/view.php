<?php

$user = elgg_get_page_owner_entity();
if (!$user) {
	register_error(elgg_echo("profile:notfound"));
	forward();
}
$body = elgg_view_layout('one_column', array('content' => elgg_view('profile/details')));
echo elgg_view_page($user->name, $body);

