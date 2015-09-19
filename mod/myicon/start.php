<?php
/**
 * Gravatar plugin
 */

elgg_register_event_handler('init', 'system', 'myicon_init');

function myicon_init() {
	elgg_set_config('myicon_user', array('female', 'male'));//,
	elgg_set_config('myicon_user_count', 2);
	elgg_set_config('myicon_group', array('g1'));
	elgg_set_config('myicon_group_count', 1);
	elgg_set_config('myicon_zhaohu', array('act1', 'act2', 'act3'));
	elgg_set_config('myicon_zhaohu_count', 3);

	// Do not remove the code below, they are for generating icons
	//add 2 helpers to generate icon files of multiple sizes
	//generateMultiSizesForType('user');
	//generateMultiSizesForType('zhaohu');
	//generateMultiSizesForType('group');
	
	elgg_register_plugin_hook_handler('entity:icon:url', 'user', 'myicon_avatar_hook', 900);
	elgg_register_plugin_hook_handler('entity:icon:url', 'group', 'myicon_avatar_hook', 900);
}

/**
 * This hooks into the getIcon API and returns a myicon icon
 */
function myicon_avatar_hook($hook, $type, $url, $params) {
	$entity=$params['entity'];
	// check if user already has an icon	
	if (!$entity->icontime) {
		$size = $params['size'];
		$icon = pickIcon($entity);
		if(!$icon) {
			elgg_log("ZHError ,myicon_avatar_hook, entity_id $entity->guid, user id " . elgg_get_logged_in_user_guid()
			, "ERROR");
			return false;
		}
		return "mod/myicon/icon.php?size=$size&icon=$icon";
	}	
}

function pickIcon($entity){
	if ( $entity instanceof ElggUser) {
		$config = 'myicon_user';
		$count = 'myicon_user_count';
		if($entity->gender)
			$idx = $entity->gender == 'female'?0:1;
		else
			$idx = 1;
	} else if ( $entity instanceof ElggGroup) {
		$config = 'myicon_group';
		$count = 'myicon_group_count';
		// $idx =  $entity->guid % elgg_get_config($count);
		$idx = 0;
	} else {
		return '';
	}
	
	$icons = elgg_get_config($config);
	return $icons[$idx];
}

function generateMultiSizesForType($type){
	$config = 'myicon_'. $type;
	$icons = elgg_get_config($config);
	foreach($icons as $icon) {
		generateMultiSizesForFile($type, $icon);
	}
	elgg_set_config('myicon_'.$type.'_processed', true);
}

function generateMultiSizesForFile($type, $iconName){
	$filehandler = new ElggFile();
	// 1. must run this code as admin 
	// 2. and put some original icon files in the file dir of the admin
	// example dir: data/2014/01/18/33/myicon/user, and 
	// data/2014/01/18/33/myicon/group
	// 3. the files must have the right permission set: 
	//		user:group should be like www-data:www-data on linux
	$filehandler->owner_guid = elgg_get_logged_in_user_guid();
	$filehandler->setFilename("myicon/" . $type."/".$iconName . ".png");
	
	$fileName = $filehandler->getFilenameOnFilestore();
	//fordebug register_error($fileName);
	$prefix = "myicon/" . $type . "/".$iconName;
	
	$icon_sizes = elgg_get_config('icon_sizes');
	$sizes = array('large', 'medium', 'small', 'tiny', 'master', 'topbar');
	$thumbs = array();
	foreach ($sizes as $size) {
		//fordebug register_error("{$size}");
		$thumbs[$size] = get_resized_image_from_existing_file(
				$fileName,
				$icon_sizes[$size]['w'],
				$icon_sizes[$size]['h'],
				$icon_sizes[$size]['square']
		);
	}
	
	if ($thumbs['tiny']) { // just checking if resize successful
		$thumb = new ElggFile();
		$thumb->owner_guid = elgg_get_logged_in_user_guid();
		$thumb->setMimeType('image/jpeg');
	
		foreach ($sizes as $size) {
			$thumb->setFilename("{$prefix}{$size}.jpg");
			//fordebug register_error("{$prefix}{$size}.jpg");
			$thumb->open("write");
			$thumb->write($thumbs[$size]);			
			$thumb->close();
		}
	}

}

