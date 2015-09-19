<?php

function zhaohu_expose_restapi(){
	expose_function("test.echo",
	"my_echo",
	array("string" => array('type' => 'string')),
	'A testing method which echos back a string',
	'GET',
	false,
	false
	);
	expose_function("event.get",
	"ws_get_event",
	array("guid" => array('type' => 'int', required => true),
	),
	'API that gets one event',
	'GET',
	false,
	false
	);
	expose_function("photo.get",
	"ws_get_photo",
	array("guid" => array('type' => 'int', required => true),
	),
	'API that gets one photo',
	'GET',
	false,
	false
	);
	expose_function("event.search",
	"ws_search_events",
	array("state" => array('type' => 'string', 'default' => 'WA'),
	"keyword" => array('type' => 'string', 'default' => 'All'),
	"past" => array('type' => 'string', 'default' => 'n'),
	"featured" => array('type' => 'string', 'default' => 'n'),
	"offset" => array('type' => 'int', 'default' => '0'),
	),
	'API that searches events',
	'GET',
	false,
	false
	);
	expose_function("album.list",
	"ws_list_albums",
	array("offset" => array('type' => 'int', 'default' => '0'),
	),
	'API that lists albums',
	'GET',
	false,
	false
	);
	expose_function("photo.list",
	"ws_list_photos",
	array("album_guid" => array('type' => 'int', required => true),
	"offset" => array('type' => 'int', 'default' => '0'),
	"batch_size" => array('type' => 'int', 'default' => ZHAOHU_MANAGER_SEARCH_LIST_LIMIT),
	),
	'API that lists albums',
	'GET',
	false,
	false
	);
}

function my_echo($string) {
	return $string;
}

function ws_list_albums($offset){

	$entities = elgg_get_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => 'album',
			'metadata_name_value_pairs' => array('name' => 'featured', 'value' => 'y'),
			'order_by' => 'e.time_updated desc',
			'limit' => ZHAOHU_MANAGER_SEARCH_LIST_LIMIT,
			'offset' => $offset,
	));
	$total_count = elgg_get_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => 'album',
			'metadata_name_value_pairs' => array('name' => 'featured', 'value' => 'y'),
			'count' => true,
	));
	
	$count = count($entities);
	$albums = array();
	if($entities){
		foreach($entities as $entity) {
			$albums[] = ws_entity2album($entity);
		}
	}
	
	$result = array();
	$result['entities'] = $albums;
	$result['subtype'] = 'album';
	$result['count'] = $count;
	$result['batch_size'] = ZHAOHU_MANAGER_SEARCH_LIST_LIMIT;
	$result['has_more'] = $total_count > $offset+$count;
	$result['total_count'] = $total_count;
	
	return $result;
}

function ws_list_photos($album_guid, $offset, $batch_size){
	$entities = array();
	$total_count = 0;
	$count = 0;
	$album = get_entity($album_guid);
	if($album){
		$total_count = $album->getSize();
		$entities = $album->getImages($batch_size, $offset);
		$count = count($entities);
		if($entities){
			foreach($entities as $entity) {
				$photos[] = ws_entity2photo($entity);
			}
		}
	}
	$result = array();
	$result['entities'] = $photos;
	$result['subtype'] = 'image';
	$result['count'] = $count;
	$result['batch_size'] = $batch_size;
	$result['has_more'] = $total_count > $offset+$count;
	$result['total_count'] = $total_count;
	
	return $result;
}

function ws_search_events($state, $keyword, $past, $featured, $offset){
	$past_only = $past=='y'?true:false;

	$options = array (
			'state' => $state,
			//'city' => $city, //to get more zhaohu
			"past_zhaohus" => $past_only, //must have
			'past_only' => $past_only,
			'offset' => $offset,
			'limit' => ZHAOHU_MANAGER_SEARCH_LIST_LIMIT,
			'featured_only' => $featured,
	);
	
	$res = find_zhaohus_by_tag_title($options, $keyword);
	$entities = $res["entities"];
	$total_count = $res["count"];
	$count = count($entities);
	
	$events = array();
	if($entities){
		foreach($entities as $entity) {
			$events[] = ws_entity2event($entity, false);
		}
	}
	$result = array();
	$result['entities'] = $events;
	$result['subtype'] = 'zhaohu';
	$result['count'] = $count;
	$result['batch_size'] = ZHAOHU_MANAGER_SEARCH_LIST_LIMIT;
	$result['has_more'] = $total_count > $offset+$count;
	$result['total_count'] = $total_count;
	
	return $result;	
}

function ws_get_event($guid){
	$entity = get_entity($guid);
	return ws_entity2event($entity, true);
}

function ws_get_photo($guid){
	$entity = get_entity($guid);
	return ws_entity2photo($entity, true);
}

function ws_entity2event($entity, $full){
	$event = array();
	if($entity){
		$event['guid'] = $entity->guid;
		$event['access_id'] = $entity->access_id;
		$event['icon_url_small'] = $entity->getIcon('small');
		$event['icon_url_medium'] = $entity->getIcon('medium');
		$event['icon_url_large'] = $entity->getIcon('large');
		$event['title'] = $entity->title;
		$event['start_date'] = date(ZHAOHU_MANAGER_FORMAT_DATE, $entity->start_day) . " ". date('H:i', $entity->start_time);
		$event['end_date'] = date(ZHAOHU_FORMAT_TS, $entity->end_ts);
		$event['country'] = $entity->country;
		$event['state'] = $entity->state;
		$event['city'] = $entity->city;
		$event['address'] = $entity->address;
		$event['zip'] = $entity->zip;
		$owner = $entity->getOwnerEntity();
		$event['owner_name'] = $owner->name;
		$event['owner_url'] = $owner->getURL();
		$group = $entity->getContainerEntity();
		$event['group_name'] = $group->name;
		$event['group_url'] = $group->getURL();
		$event['url'] = $entity->getURL();
		$event['full_address'] = $entity->getLocation();
		//extra
		if($full){
			$event['tags'] = $entity->getTags();
			$event['max_attendees'] = $entity->max_attendees;
			$event['min_attendees'] = $entity->min_attendees;
			$event['has_coupon'] = $entity->has_coupon;
			$event['coupon_end_ts'] = date(ZHAOHU_FORMAT_TS, $entity->coupon_end_ts);
			$event['use_paypal'] = $entity->use_paypal;
			//$event['fee'] = $entity->fee;
			//$event['currency'] = $entity->currency;
			$event['buyButtonID'] = $entity ->buyButtonID;
			$event['contact_details'] = $entity->contact_details;
			$event['description'] = $entity->descriptions;
		}
	}
	return $event;	
}

function ws_entity2album($entity){
	$album = array();
	if($entity){
		$album['guid'] = $entity->guid;
		$album['access_id'] = $entity->access_id;
		$album['title'] = $entity->title;
		$album['time_updated'] = date(ZHAOHU_FORMAT_TS, $entity->time_updated);
		$album['time_updated_en'] = date(ZHAOHU_APP_FORMAT_TS, $entity->time_updated);
		$album['url'] = elgg_get_site_url()."services/api/rest/json/?method=photo.list&album_guid={$entity->guid}";
		if($entity->cover){
			$album['cover'] = elgg_get_site_url()."photos/thumbnail/{$entity->cover}/large";
		}
		$album['size'] = $entity->getSize();
	}
	return $album;
}

function ws_entity2photo($entity){
	$photo = array();
	if($entity){
		$photo['guid'] = $entity->guid;
		$photo['access_id'] = $entity->access_id;
		$photo['title'] = $entity->title;
		$photo['url'] = elgg_get_site_url()."services/api/rest/json/?method=photo.get&guid={$entity->guid}";
		$photo['thumbnail_small'] = elgg_get_site_url()."photos/thumbnail/{$entity->guid}/small";
		$photo['thumbnail_large'] = elgg_get_site_url()."photos/thumbnail/{$entity->guid}/large";
		$photo['thumbnail_master'] = elgg_get_site_url()."photos/thumbnail/{$entity->guid}/master";
		$photo['album_guid'] = $entity->getContainerGuid();
	}
	return $photo;
}