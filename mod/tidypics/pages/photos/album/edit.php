<?php
/**
 * Edit an album
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$guid = (int) get_input('guid');

if (!$entity = get_entity($guid)) {
	register_error(elgg_echo("album:error") . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError , tidypics:album:edit, get_entity failed, entity_guid_id $guid, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}

if (!$entity->canEdit()) {
	// @todo cannot change it
	register_error(elgg_echo("actionunauthorized"));
	elgg_log("ZHError , tidypics:album:edit, user cannot edit entity, entity_guid_id $guid, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}

elgg_set_page_owner_guid($entity->getContainerGUID());
$owner = elgg_get_page_owner_entity();

gatekeeper(); 
group_gatekeeper();

if (!($owner instanceof ElggGroup)) {
	register_error(elgg_echo("album:error") . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError , tidypics:album:edit, page owner is not group, owner_id $owner->guid, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}

$title = elgg_echo('album:edit');

$vars = tidypics_prepare_form_vars($entity);
$content = elgg_view_form('photos/album/save', array('method' => 'post'), $vars);

// show album edit page in group context
if ($owner instanceof ElggGroup) {
	$body = elgg_view('zhgroups/group_header', array("group" => $owner));
	$body .= elgg_view('zhgroups/inGroupContent', array(
	'filter' => false,
	'group' => $owner,
	'content' => $content,
	));	
}
echo elgg_view_page($title, $body);
