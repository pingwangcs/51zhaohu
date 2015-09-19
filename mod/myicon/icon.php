<?php
/**
 * Icon display
 *
 * @package ElggGroups
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

/*
//$group_guid = get_input('group_guid');

$group = get_entity($group_guid);
if (!($group instanceof ElggGroup)) {
	header("HTTP/1.1 404 Not Found");
	exit;
}
*/
$icon = $_GET['icon'];
$size = $_GET['size'];

if (!in_array($size, array('large', 'medium', 'small', 'tiny', 'master', 'topbar')))
	$size = "medium";
// If is the same ETag, content didn't changed.
$etag = $icon . $size;
if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) == "\"$etag\"") {
	header("HTTP/1.1 304 Not Modified");
	exit;
}

$location = elgg_get_plugins_path() ."myicon/graphics/{$icon}{$size}.jpg";

$filesize = @filesize($location);
if ($filesize) {
	header("Content-type: image/jpeg");
	header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+10 days")), true);
	header("Pragma: public");
	header("Cache-Control: public");
	header("Content-Length: $filesize");
	header("ETag: \"$etag\"");
	readfile($location);
	exit;
}
