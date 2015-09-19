<?php
/**
 * Edit the images in a batch
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$guids = get_input('guid');
$titles = get_input('title');
$captions = get_input('caption');
$tags = get_input('tags');

$not_updated = array();
$titletoolong = false;
$desptoolong = false;
$tagstoolong = false;
foreach ($guids as $key => $guid) {
	$image = get_entity($guid);
	
	if ($image->canEdit()) {

		// set title appropriately
		if ($titles[$key]) {
			if (strlen($titles[$key]) > ZH_NAME_MAX)
				$titletoolong = true;
			else
				$image->title = $titles[$key];
		} else {
        	$title = substr($image->originalfilename, 0, strrpos($image->originalfilename, '.'));
        	if (strlen($title) > ZH_NAME_MAX)
        		$titletoolong = true;
        	else
            	// remove any possible bad characters from the title
            	$image->title = preg_replace('/\W/', '', $title);
		}

		// set description appropriately
		if (strlen($captions[$key]) > ZH_DESP_MAX)
			$desptoolong = true;
		else
			$image->description = $captions[$key];
		
		if (strlen($tags[$key]) > ZH_TAGS_MAX)
			$tagstoolong = true;
		else
			$image->tags = string_to_tag_array($tags[$key]);
		
		if (!$image->save()) {
			array_push($not_updated, $image->getGUID());
		}
	}
}

if($titletoolong)
	register_error(elgg_echo('photo:titletoolong').elgg_echo('input:max', array(ZH_NAME_MAX/3, ZH_NAME_MAX)));
if($desptoolong)
	register_error(elgg_echo('photo:desptoolong').elgg_echo('input:max', array(ZH_DESP_MAX/3, ZH_DESP_MAX)));
if($tagstoolong)
	register_error(elgg_echo('photo:tagstoolong').elgg_echo('input:max', array(ZH_TAGS_MAX/3, ZH_TAGS_MAX)));

if (count($not_updated) > 0) {	
	register_error(elgg_echo("images:notedited") . elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError , tidypics, images:notedited, user_id " .elgg_get_logged_in_user_guid()
	, "ERROR");
} else {
	system_message(elgg_echo("images:edited"));
}
forward($image->getContainerEntity()->getURL());
