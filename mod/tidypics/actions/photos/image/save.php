<?php
/**
 * Save image action
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

// Get input data
$title = get_input('title');
$description = get_input('description');
$tags = get_input('tags');
$guid = get_input('guid');

elgg_make_sticky_form('tidypics');

if (empty($title)) {
	register_error(elgg_echo("image:blank"));
	forward(REFERER);
}
if(strlen($title)>ZH_NAME_MAX){
	register_error(elgg_echo('photo:titletoolong').elgg_echo('input:max', array(ZH_NAME_MAX/3, ZH_NAME_MAX)));
	forward(REFERER);
}
if(strlen($description)>ZH_DESP_MAX){
	register_error(elgg_echo('photo:desptoolong').elgg_echo('input:max', array(ZH_DESP_MAX/3, ZH_DESP_MAX)));
	forward(REFERER);
}

$image = get_entity($guid);

$image->title = $title;
$image->description = $description;
if($tags) {
        $image->tags = string_to_tag_array($tags);
} else {
        $image->deleteMetadata('tags');
}

if (!$image->save()) {
	register_error(elgg_echo("image:error") . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError , tidypics:image:save, image->save failed, image_guid {$guid}, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}

elgg_clear_sticky_form('tidypics');

system_message(elgg_echo("image:saved"));
forward($image->getURL());
