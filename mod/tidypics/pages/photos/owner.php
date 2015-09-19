<?php
/**
 * Show all the albums that belong to a user or group
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

group_gatekeeper();

$owner = elgg_get_page_owner_entity();

if (!$owner) {
        forward(REFERER);
}

$title = elgg_echo('album:user', array($owner->name));

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('photos'), 'photos/siteimagesall');
elgg_push_breadcrumb(elgg_echo('tidypics:albums'), 'photos/all');
elgg_push_breadcrumb($owner->name);

$content = "";
$loggedin_user = elgg_get_logged_in_user_entity();
if ($owner instanceof ElggGroup){
	$content .= elgg_view('output/url', array(
	'text' => elgg_echo("photos:add"),
	'href' => "photos/add/".$owner->guid,
	'class' => 'elgg-button elgg-button-action'));
}

$offset = (int)get_input('offset', 0);
$limit = (int)get_input('limit', GROUPS_ALBUM_LIMIT);

$content .= elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'album',
	'container_guid' => $owner->getGUID(),
	'limit' => $limit,
	'offset' => $offset,
	'full_view' => false,
	'list_type' => 'gallery',
	'list_type_toggle' => false,
	'gallery_class' => 'tidypics-gallery',
));
if (!$content) {
	$content = elgg_echo('tidypics:none');
}

if (elgg_is_logged_in()) {
        if ($owner instanceof ElggGroup) {
                $logged_in_guid = $owner->getGUID();
        } else {
                $logged_in_guid = elgg_get_logged_in_user_guid();
        }
}

//elgg_register_title_button();

$params = array(
	'filter_context' => 'mine',
	'content' => $content,
	'title' => $title,
	//'sidebar' => elgg_view('photos/sidebar', array('page' => 'owner')),
);

if ($owner->getGUID() != elgg_get_logged_in_user_guid()) {
	$params['filter_context'] = '';
}

// don't show filter if out of filter context
if ($owner instanceof ElggGroup && elgg_get_viewtype() == 'default') {
	$params['filter'] = false;
	$params['group'] = $owner;
	$body = elgg_view('zhgroups/group_header', array("group" => $owner));
	$body .= elgg_view('zhgroups/inGroupContent', $params);
} else {
	$body = elgg_view_layout('content', $params);
}

echo elgg_view_page($title, $body);
