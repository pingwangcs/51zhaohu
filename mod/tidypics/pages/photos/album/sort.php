<?php
/**
 * Album sort page
 *
 * This displays a listing of all the photos so that they can be sorted
 */

gatekeeper();
group_gatekeeper();

// get the album entity
$album_guid = (int) get_input('guid');
$album = get_entity($album_guid);

// panic if we can't get it
if (!$album) {
	register_error(elgg_echo("album:error") . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError , tidypics:album:sort, get_entity failed, album_id $album_guid, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
	forward();
}

if(!$album->canEdit()){
	register_error(elgg_echo("actionunauthorized"));
	elgg_log("ZHError , tidypics:album:sort, user cannot edit album, album_id $album_guid, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}

// container should always be set, but just in case
$owner = $album->getContainerEntity();
elgg_set_page_owner_guid($owner->getGUID());

if (!($owner instanceof ElggGroup)) {
	register_error(elgg_echo("album:error") . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError , tidypics:album:sort, page owner is not group, owner_id $owner->guid, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);	
}

$title = elgg_echo('tidypics:sort', array($album->getTitle()));

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('photos'), 'photos/siteimagesall');
elgg_push_breadcrumb(elgg_echo('tidypics:albums'), 'photos/all');
if (elgg_instanceof($owner, 'group')) {
	elgg_push_breadcrumb($owner->name, "photos/group/$owner->guid/all");
} else {
	elgg_push_breadcrumb($owner->name, "photos/owner/$owner->username");
}
elgg_push_breadcrumb($album->getTitle(), $album->getURL());
elgg_push_breadcrumb(elgg_echo('album:sort'));

if ($album->getSize()) {
	$content = elgg_view_form('photos/album/sort', array(), array('album' => $album));
} else {
	$content = elgg_echo('tidypics:sort:no_images');
}

$body = elgg_view('zhgroups/group_header', array("group" => $owner));
$page_body = elgg_view('zhgroups/inGroupContent', array(
	'filter' => false,
	'group' => $owner,
	'content' => $content,
	'title' => $title,
));
$body .= $page_body;

echo elgg_view_page($title, $body);
