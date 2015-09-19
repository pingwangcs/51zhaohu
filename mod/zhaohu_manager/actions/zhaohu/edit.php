<?php
	// start a new sticky form session in case of failure
	elgg_make_sticky_form('zhaohu');

	// publish or draft
	$publish = (bool)get_input('publish');
	
	$guid = get_input("guid");
	$container_guid = get_input("container_guid");
	$title = get_input("title");
	$status = get_input("status");
	$tags = get_input("tags");
	$description = get_input("description");
	$country = get_input("country");
	$state = get_input("state");
	$city = get_input("city");
	$address = get_input("address");
	$zip = get_input("zip");
	$contact_details = get_input("contact_details");
	$videoUrl = get_input("videoUrl");
	$latitude = get_input("latitude");
	$longitude = get_input("longitude");
	$payoption1name = get_input("payoption1name");
	$payoption1value = get_input("payoption1value");
	$payoption2name = get_input("payoption2name");
	$payoption2value = get_input("payoption2value");
    //$fee = get_input('fee');
	//$currency = get_input("currency");
	$buyButtonID = get_input("buyButtonID");
	$start_day = get_input("start_day");
	$end_day = get_input("end_day");
	$end_time_hours = get_input("end_time_hours");
	$end_time_minutes = get_input("end_time_minutes");
	$coupon_end_day = get_input("coupon_end_day");
	$coupon_end_time_hours = get_input("coupon_end_time_hours");
	$coupon_end_time_minutes = get_input("coupon_end_time_minutes");
	$max_attendees = get_input("max_attendees");
	$has_coupon = get_input("has_coupon");
	$use_paypal = get_input("use_paypal");
	$min_attendees = get_input("min_attendees");
	//$waiting_list = get_input("waiting_list");
	$access_id = get_input("access_id");
	$delete_current_icon = get_input("delete_current_icon");	
	//$waiting_list_enabled = get_input("waiting_list_enabled");
	
	$start_time_hours = get_input("start_time_hours");
	$start_time_minutes = get_input("start_time_minutes");
	$start_time = mktime($start_time_hours, $start_time_minutes, 1, 0, 0, 0);
	
	if (!empty($end_day)) {
		$end_date = explode('-', $end_day);
		$end_day = mktime(0,0,1,$end_date[1], $end_date[2], $end_date[0]);
		$end_ts = mktime($end_time_hours, $end_time_minutes, 1, $end_date[1], $end_date[2], $end_date[0]);
	}
	
	if($has_coupon==1 && !empty($coupon_end_day)){
		$coupon_end_date = explode('-', $coupon_end_day);
		$coupon_end_day = mktime(0,0,1,$coupon_end_date[1], $coupon_end_date[2], $coupon_end_date[0]);
		$coupon_end_ts = mktime($coupon_end_time_hours, $coupon_end_time_minutes, 1, $coupon_end_date[1], $coupon_end_date[2], $coupon_end_date[0]);
	}
	
	if(!empty($start_day)) {
		$date = explode('-',$start_day);
		$start_day = mktime(0,0,1,$date[1],$date[2],$date[0]);
		
		$start_ts = mktime($start_time_hours, $start_time_minutes, 1, $date[1], $date[2], $date[0]);
		
		if (!empty($end_ts) && ($end_ts < $start_ts)) {
			register_error(elgg_echo('zhaohu:edit:end_time_error'));			
			forward(REFERER);
		}
	}
	
	if(!empty($guid) && $entity = get_entity($guid)) {
		if($entity->getSubtype() == Zhaohu::SUBTYPE) {
			$zhaohu = $entity;
		}
	}
	
	if(!empty($tags)) {
		if(strlen($tags)>ZH_TAGS_MAX){
			register_error(elgg_echo('zhaohu:tagstoolong').elgg_echo('input:max', array(ZH_TAGS_MAX/3, ZH_TAGS_MAX)));
			forward(REFERER);
		}
		$tags = string_to_tag_array($tags);
	}		
	if(empty($title)){		
		register_error(elgg_echo("zhaohu:edit:title_empty"));		
		forward(REFERER);		
	}
	if(strlen($title)>ZH_NAME_MAX){
		register_error(elgg_echo('zhaohu:titletoolong').elgg_echo('input:max', array(ZH_NAME_MAX/3, ZH_NAME_MAX)));
		forward(REFERER);
	}
	if(strlen($description)>ZH_ZHAOHU_DESP_MAX)
	{
		register_error(elgg_echo('zhaohu:desptoolong').elgg_echo('input:max', array(ZH_ZHAOHU_DESP_MAX/3, ZH_ZHAOHU_DESP_MAX)));
		forward(REFERER);
	}
	if(strlen($city) > ZH_CITY_MAX)
	{
		register_error(elgg_echo('zhaohu:citytoolong').elgg_echo('input:max', array(ZH_CITY_MAX/3, ZH_CITY_MAX)));
		forward(REFERER);
	}
	if(strlen($address) > ZH_ADDRESS_MAX)
	{
		register_error(elgg_echo('zhaohu:addresstoolong').elgg_echo('input:max', array(ZH_ADDRESS_MAX/3, ZH_ADDRESS_MAX)));
		forward(REFERER);
	}
	if (!empty($zip) && !preg_match("/^\d{5}(-\d{4})?$/", $zip)){
		register_error(elgg_echo('zhaohu:zip:error'));
		forward(REFERER);
	}
	if(strlen($contact_details) > ZH_CONTACT_MAX)
	{
		register_error(elgg_echo('zhaohu:contacttoolong').elgg_echo('input:max', array(ZH_CONTACT_MAX/3, ZH_CONTACT_MAX)));
		forward(REFERER);
	}
// 	if(!empty($fee) && !is_numeric($fee)) {
// 		$fee = "";
// 		register_error(elgg_echo("zhaohu:edit:fee_invalid"));
// 		forward(REFERER);
// 	}
// 	if(strlen($currency) > ZH_CURRENCY_MAX)
// 	{
// 		register_error('zhaohu:currencytoolong');
// 		forward(REFERER);
// 	}
// 	if(!empty($fee) && empty($currency)){
// 		register_error(elgg_echo('zhaohu:edit:currency_empty'));
// 		forward(REFERER);
// 	}
//  	if(strlen($buyButtonID) != 13){
//  		register_error(elgg_echo('zhaohu:buyButtonIDnotcorrect'));
//  		forward(REFERER);
//  	}
	
// 	if($use_paypal==1 && empty($fee)){
// 		register_error(elgg_echo('zhaohu:edit:fee_empty'));
// 		forward(REFERER);
// 	}
	if(!empty($max_attendees) && !is_numeric($max_attendees)) {		
		$max_attendees = "";
		register_error(elgg_echo("zhaohu:edit:max_attendees_invalid"));
		forward(REFERER);
	}
	if(!empty($min_attendees) && !is_numeric($min_attendees)) {
		$min_attendees = "";
		register_error(elgg_echo("zhaohu:edit:min_attendees_invalid"));
		forward(REFERER);
	}
	if($publish){
		if(empty($start_day))
		{
			register_error(elgg_echo("zhaohu:edit:start_day_empty"));
			forward(REFERER);
		}
		if(empty($end_day))
		{
			register_error(elgg_echo("zhaohu:edit:end_day_empty"));
			forward(REFERER);
		}
		if(empty($description))
		{
			register_error(elgg_echo("zhaohu:edit:description_empty"));
			forward(REFERER);
		}
		if(empty($tags)){
			register_error(elgg_echo("zhaohu:edit:tags_empty"));
			forward(REFERER);
		}
		if(empty($country))
		{
			register_error(elgg_echo("zhaohu:edit:country_empty"));
			forward(REFERER);
		}
		if(empty($state))
		{
			register_error(elgg_echo("zhaohu:edit:state_empty"));
			forward(REFERER);
		}
		if(empty($city))
		{
			register_error(elgg_echo("zhaohu:edit:city_empty"));
			forward(REFERER);
		}
// 		if($end_ts < mktime(0, 0, 0)){//need to be updated with isPast
// 			register_error(elgg_echo("zhaohu:publish:past"));
// 			forward(REFERER);
// 		}
	}
	$location = "";
	if(!empty($address))
		$location .= $address . ', ';
	$location .= $city . ', ' . $state. ', ' . $country;
	if($zip && !empty($zip))
		$location .= ', ' . $zip;
	
		$newZhaohu = false;		
		if (!isset($zhaohu)) {
			$newZhaohu = true;			
			$zhaohu = new Zhaohu();
			$zhaohu->hasUpdates = true;
		}
		else {
			// set the previous status for the hooks to update the time_created and river entries
			$old_status = $zhaohu->status;
		}
		// if preview, force status to be draft
		if ($publish == false) {
			$status = 'draft';
		}
		else
		{
			$status = 'published';
		}
		
		// if draft, set access to private and cache the future access
		if ($status == 'draft') {
			$future_access = $access_id;
			$access_id = ACCESS_PRIVATE;
		}		
		
		if(!$zhaohu->hasUpdates){
			if($title!=$zhaohu->title || $description!=$zhaohu->description 
			|| $country!=$zhaohu->country || $state!=$zhaohu->state || $city !=$zhaohu->city
			|| $address!=$zhaohu->address || $zip!=$zhaohu->zip)
				$zhaohu->hasUpdates = true;
		}
		
		if(!$zhaohu->hasUpdates){
			if($contact_details!=$zhaohu->contact_details || $fee!=$zhaohu->fee 
			|| $start_day !=$zhaohu->start_day || $start_time!=$zhaohu->start_time
			|| $end_day !=$zhaohu->end_day || $end_ts!=$zhaohu->end_ts)
				$zhaohu->hasUpdates = true;
		}
		
		$zhaohu->title = $title;
		$zhaohu->description = $description;
		$zhaohu->container_guid = $container_guid;
		$zhaohu->access_id = $access_id;
		$zhaohu->future_access = $future_access;
		$zhaohu->status = $status;
		
		$zhaohu->setLocation($location);
		//$zhaohu->setLatLong($latitude, $longitude);
		$zhaohu->country = $country;
		$zhaohu->state = $state;
		$zhaohu->city = $city;
		$zhaohu->address = $address;
		$zhaohu->zip = $zip;
		$zhaohu->tags = $tags;
				
		$zhaohu->max_attendees = $max_attendees;
		$zhaohu->has_coupon = $has_coupon;
		$zhaohu->min_attendees = $min_attendees;
		$zhaohu->contact_details = $contact_details;
		$zhaohu->videoUrl = $videoUrl;
		$zhaohu->use_paypal = $use_paypal;
		//$zhaohu->fee = $fee;
		//$zhaohu->currency = $currency;
		$zhaohu->payoption1name = $payoption1name;
		$zhaohu->payoption1value = $payoption1value;
		$zhaohu->payoption2name = $payoption2name;
		$zhaohu->payoption2value = $payoption2value;
		$zhaohu->buyButtonID = $buyButtonID;
		$zhaohu->start_day = $start_day;
		$zhaohu->start_time = $start_time;
		$zhaohu->end_day = $end_day;
		if (!empty($end_ts)) {
			$zhaohu->end_ts = $end_ts;
		}
		$zhaohu->coupon_end_day = $coupon_end_day;
		if (!empty($coupon_end_ts)) {
			$zhaohu->coupon_end_ts = $coupon_end_ts;
		}
		//$zhaohu->setAccessToOwningObjects($access_id);
		$zhaohu->save();
		if (($newZhaohu || $old_status == 'draft') && $status == 'published') {
			add_to_river('river/object/zhaohu/create', 'create', elgg_get_logged_in_user_guid(), $zhaohu->getGUID());
		}
		
		$prefix = "zhaohus/".$zhaohu->guid."/";
		
		$has_uploaded_icon = (!empty($_FILES['icon']['type']) && substr_count($_FILES['icon']['type'], 'image/'));
		if($has_uploaded_icon){			
			if(!checkImageExt($_FILES['icon']['name'])){
				register_error(elgg_echo('zhgroups:image:format:error'));
				forward(REFERER);
			}
			// rotate uploaded image if needed
			$filename = $_FILES['icon']['tmp_name'];
			zhaohu_rotate_image_niubility($filename);
			
			if (($icon_file = get_resized_image_from_uploaded_file("icon", 100, 100)) && ($icon_sizes = elgg_get_config("icon_sizes"))) {
				// create icon
				$fh = new ElggFile();
				$fh->owner_guid = $zhaohu->getOwnerGUID();
			
				foreach ($icon_sizes as $icon_name => $icon_info) {
					if ($icon_file = get_resized_image_from_uploaded_file("icon", $icon_info["w"], $icon_info["h"], $icon_info["square"], $icon_info["upscale"])) {
						$fh->setFilename($prefix . $icon_name . ".jpg");
			
						if($fh->open("write")){
							$fh->write($icon_file);
							$fh->close();
						}
					}
				}
				$zhaohu->icontime = time();
			}
		}
		
		if ($delete_current_icon) {
			if ($icon_sizes = elgg_get_config("icon_sizes")) {
				$fh = new ElggFile();
				$fh->owner_guid = $zhaohu->getOwnerGUID();
					
				foreach ($icon_sizes as $name => $info) {
					$fh->setFilename($prefix . $name . ".jpg");
			
					if($fh->exists()){
						$fh->delete();
					}
				}
			}			
			unset($zhaohu->icontime);
		}
			
		// added because we need an update zhaohu
		if ($zhaohu->save()) {
			// remove sticky form entries
			elgg_clear_sticky_form('zhaohu');
			//system_message(elgg_echo("zhaohu:edit:ok"));
			if ($status == 'published'){
				//zhaohuPubedNotify($zhaohu);
				sendEventDigestPerGroup($zhaohu->container_guid);
			}
			forward($zhaohu->getURL());
		}
		else{
			register_error(elgg_echo("zhaohu:edit:save:error") . elgg_echo("zhaohu:sorry"));
			elgg_log("ZHError ,zhaohu:edit, error calling zhaohu->save, zhaohu_id $zhaohu->guid, user_id "
			.elgg_get_logged_in_user_guid(), "ERROR");
			forward(REFERER);
		}