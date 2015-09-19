<?php
/**
 * Create new album page
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$owner = elgg_get_page_owner_entity();

gatekeeper();
group_gatekeeper();
$user = elgg_get_logged_in_user_entity();
if (!$owner->isMember($user)) {
	register_error(elgg_echo('zhgroups:notmember'));
	forward(REFERER);
}

$title = elgg_echo('photos:add');

$vars = tidypics_prepare_form_vars();
$content = elgg_view_form('photos/album/save', array('method' => 'post'), $vars);

$body = elgg_view('zhgroups/group_header', array("group" => $owner));

$body .= elgg_view('zhgroups/inGroupContent', array(
		'filter' => false,
		'content' => $content,
		'title' => $title,
		'group' => $owner,
		//'sidebar' => elgg_view('photos/sidebar', array('page' => 'album')),
));

echo elgg_view_page($title, $body);
