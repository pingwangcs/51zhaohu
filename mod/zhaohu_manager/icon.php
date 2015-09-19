<?php

/**
 * Elgg zhaohu icon cache/bypass
 *
 * @package ElggZhaohu
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
$guid = get_input('guid');

$zhaohu = get_entity($guid);
if (!($zhaohu instanceof Zhaohu)) {
	header("HTTP/1.1 404 Not Found");
	exit;
}

// If is the same ETag, content didn't changed.
$etag = $zhaohu->icontime . $guid;
if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) == "\"$etag\"") {
	header("HTTP/1.1 304 Not Modified");
	exit;
}

$size = strtolower(get_input('size'));
if (!in_array($size, array('large', 'medium', 'small', 'tiny', 'master', 'topbar')))
	$size = "medium";

$filehandler = new ElggFile();
$filehandler->owner_guid = $zhaohu->owner_guid;
$filehandler->setFilename("/zhaohus/{$guid}/{$size}.jpg");

$success = false;

if ($filehandler->open("read")) {
	if ($contents = $filehandler->read($filehandler->size())) {
		$success = true;
	}
}

if (!$success) {
	$location = elgg_get_plugins_path() . "groups/graphics/default{$size}.gif";
	$contents = @file_get_contents($location);	
	elgg_log("ZHError ,Zhaohu icon direct failed, zhaohu_id {$guid}, user_id ".elgg_get_logged_in_user_guid(), 'ERROR');
}

header("Content-type: image/jpeg");
header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+10 days")), true);
header("Pragma: public");
header("Cache-Control: public");
header("Content-Length: " . strlen($contents));
header("ETag: \"$etag\"");
echo $contents;