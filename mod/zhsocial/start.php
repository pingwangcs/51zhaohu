<?php
elgg_register_event_handler('init', 'system', 'zhsocial_init');

function zhsocial_init() {	
	elgg_register_simplecache_view("js/zhsocial/login");
	$login_js = elgg_get_simplecache_url("js", "zhsocial/login");
	elgg_register_js("zhsocial.login", $login_js);	
	elgg_extend_view('forms/login', 'zhsocial/login', 501);	
}

function zhsocial_apply_icon($zh_user, $icon_url) {
// 	if($zh_user->icontime)
// 		return;	
	$icon_sizes = elgg_get_config('icon_sizes');
	$prefix = "profile/{$zh_user->guid}";

	$filehandler = new ElggFile();
	$filehandler->owner_guid = $zh_user->guid;	
	$filehandler->setFilename($prefix . ".jpg");
	$filehandler->open("write");
	$filehandler->write(file_get_contents($icon_url));
	$filehandler->close();
	$filename = $filehandler->getFilenameOnFilestore();
	
	$sizes = array('topbar', 'tiny', 'small', 'medium', 'large', 'master');
	
	$thumbs = array();
	foreach ($sizes as $size) {
		$thumbs[$size] = get_resized_image_from_existing_file(
				$filename,
				$icon_sizes[$size]['w'],
				$icon_sizes[$size]['h'],
				$icon_sizes[$size]['square']
		);
	}
	
	if ($thumbs['tiny']) { // just checking if resize successful
		$thumb = new ElggFile();
		$thumb->owner_guid = $zh_user->guid;
		$thumb->setMimeType('image/jpeg');
	
		foreach ($sizes as $size) {
			$thumb->setFilename("{$prefix}{$size}.jpg");
			$thumb->open("write");
			$thumb->write($thumbs[$size]);
			$thumb->close();
		}
	
		$zh_user->icontime = time();
	}
}