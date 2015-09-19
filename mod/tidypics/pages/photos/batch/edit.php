<?php
/**
 * Edit the image information for a batch of images
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

gatekeeper();

$guid = (int) get_input('guid');

if (!$batch = get_entity($guid)) {
	// @todo either deleted or do not have access
	register_error(elgg_echo("album:error") . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError , tidypics:batch:edit,  get_entity failed, entity_guid_id $guid, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}

if (!$batch->canEdit()) {
	register_error(elgg_echo("actionunauthorized"));
	elgg_log("ZHError , tidypics:batch:edit, user cannot edit entity, entity_guid_id $guid, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}

$album = $batch->getContainerEntity();

elgg_set_page_owner_guid($batch->getContainerEntity()->getContainerGUID());
$owner = elgg_get_page_owner_entity();

$title = elgg_echo('tidypics:editprops');

$content = elgg_view_form('photos/batch/edit', array(), array('batch' => $batch));

$body = elgg_view('zhgroups/group_header', array("group" => $owner));

$body .= elgg_view('zhgroups/inGroupContent', array(
		'filter' => false,
		'content' => $content,
		'title' => $title,
		'group' => $owner,
		//'sidebar' => elgg_view('photos/sidebar', array('page' => 'album')),
));

echo elgg_view_page($title, $body);
