<?php

gatekeeper();

$title = elgg_echo("zhaohu:invite:title");

$guid = (int) get_input("guid");
$zhaohu = false;

if (empty($guid)) {
	register_error ( elgg_echo ( "zhaohu:invite:err" ) . elgg_echo ( "zhaohu:sorry" ) );
	elgg_log ( "ZHError ,zhaohu:invite, zhaohu guid is empty", "ERROR" );
	forward ( REFERER );
}
$zhaohu = get_entity($guid);
if(!($zhaohu instanceof Zhaohu)){
	register_error ( elgg_echo ( "zhaohu:invite:err" ) . elgg_echo ( "zhaohu:sorry" ) );
	elgg_log ( "ZHError ,zhaohu:invite, zhaohu is invalid, guid {$guid}", "ERROR" );
	forward ( REFERER );
}
elgg_set_page_owner_guid($zhaohu->container_guid);

$group = get_entity($zhaohu->container_guid);
	
if ( empty($group) || !($group instanceof ElggGroup) ) {
	register_error(elgg_echo('zhaohu:invite:err') . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError, zhaohu:invite, invalid group, zhaohu_id $guid , user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward();
}

$content = elgg_view_form('zhaohu/invite');

$body = elgg_view('zhgroups/group_header', array("group" => $group));

$body .= elgg_view('zhgroups/inGroupContent', array(
		'filter' => false,
		'content' => $content,
		'title' => $title,
		'group' => $group));

echo elgg_view_page($title, $body);
