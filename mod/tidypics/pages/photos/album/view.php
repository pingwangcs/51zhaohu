<?php
/**
 * This displays the photos that belong to an album
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

group_gatekeeper();

// get the album entity
$album_guid = (int) get_input('guid');
$album = get_entity($album_guid);
if (!$album) {
        register_error(elgg_echo('noaccess'));
        $_SESSION['last_forward_from'] = current_page_url();
	 elgg_log("ZHError , tidypics:album:view, get_entity failed, album_id {$album_guid}, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
        forward('');
}
$container = $album->getContainerEntity();
if (!$container) {
	register_error(elgg_echo('noaccess'));
	$_SESSION['last_forward_from'] = current_page_url();
	elgg_log("ZHError , tidypics:album:view, getContainerEntity failed, album_id {$album_guid}, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward('');
}

elgg_set_page_owner_guid($album->getContainerGUID());
$owner = elgg_get_page_owner_entity();

$title = elgg_echo($album->getTitle());

$content = elgg_view_entity($album, array('full_view' => true));

if (elgg_is_logged_in()) {
	if (elgg_instanceof($owner, 'group')) {
		$logged_in_guid = $owner->guid;
    } else {
        $logged_in_guid = elgg_get_logged_in_user_guid();
    }
}
if(elgg_get_viewtype() == 'default'){
$body = elgg_view('zhgroups/group_header', array("group" => $container));

$body .= elgg_view('zhgroups/inGroupContent', array(
	'filter' => false,
	'content' => $content,
	'title' => $album->getTitle(),
	'group' => $container,
	//'sidebar' => elgg_view('photos/sidebar', array('page' => 'album')),
));
} else {
	$body = elgg_view_layout('one_column', array(
			'content' => $content,
			'title' => $album->getTitle(),
	));
}

echo elgg_view_page($title, $body);