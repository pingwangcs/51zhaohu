<?php
/**
 * Edit an image
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$guid = (int) get_input('guid');

if (!$entity = get_entity($guid)) {
	// @todo either deleted or do not have access
	register_error(elgg_echo("album:error") . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError , tidypics:image:edit, get_entity failed, entity_guid_id $guid, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}

if (!$entity->canEdit()) {
	// @todo cannot change it
	register_error(elgg_echo("actionunauthorized"));
	elgg_log("ZHError , tidypics:image:edit, user cannot edit image, image_id $guid, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");	
	forward($entity->getContainerEntity()->getURL());
}

$album = $entity->getContainerEntity();
if (!$album) {

}

elgg_set_page_owner_guid($album->getContainerGUID());
$owner = elgg_get_page_owner_entity();

gatekeeper();
group_gatekeeper();

$title = elgg_echo('image:edit');

$vars = tidypics_prepare_form_vars($entity);
$content = elgg_view_form('photos/image/save', array('method' => 'post'), $vars);

// show album edit page in group context
if ($owner instanceof ElggGroup) {
	$params['filter'] = false;
	$params['group'] = $owner;
	$params['content'] = $content;
	$page_body = elgg_view('zhgroups/inGroupContent', $params);
	$body = elgg_view('zhgroups/group_header', array("group" => $owner)) . $page_body;
}else{
	$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => ''
	));
}
echo elgg_view_page($title, $body);
