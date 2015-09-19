<?php

	$zhaohu = $vars["entity"];
	$owner = $zhaohu->getOwnerEntity();
	$zhaohu_details = "";
	// zhaohu details
	$zhaohu_details .= '<div class="zhaohu-view-image-mobile-container"><img class="zhaohu-view-image-mobile" src="' . $zhaohu->getIcon('large') . '" border="0" /></div>';
	
	// zhaohu info div
	$zhaohu_details .= '<div class="zhaohu_details_mobile">';
	
	// Title
	$zhaohu_details .= '<div class="zhaohu-title-mobile">' . $zhaohu->title . '</div>';
	
	if(!elgg_is_from_app()){
		$zhaohu_details .= elgg_view(
				"zhaohu_manager/zhaohu/div_container",
				array(
						"content" => elgg_view("zhaohu_manager/zhaohu/actions", $vars),
						"div_class" => "zhaohu-user-actions-mobile",
						"div_id" => "zhaohu_user_actions_mobile"));
	}
	
	// status
	if($zhaohu->canEdit())
	{
		$zhaohu_details .= '<div><label>' . elgg_echo('zhaohu:status')
		. ': </label>' .elgg_echo($zhaohu->status). '</div>';
	}
	
	// Time
	$zhaohu_details .= '<div><label>' . elgg_echo('zhaohu:start_time') . ': </label>' . date(ZHAOHU_MANAGER_FORMAT_DATE, $zhaohu->start_day) . " ". date('H', $zhaohu->start_time) . ':' . date('i', $zhaohu->start_time);
	// optional end day
	if ($zhaohu->end_ts) {
		$zhaohu_details .= '<div><label>' . elgg_echo ( 'zhaohu:end_time' ) . ': </label>' . date ( ZHAOHU_FORMAT_TS, $zhaohu->end_ts ) . '</div>';
	}
	
	if ($zhaohu->coupon_end_ts) {
		$zhaohu_details .= '<div><label>' . elgg_echo('coupon:end_time') . ': </label>' . date(ZHAOHU_MANAGER_FORMAT_DATE, $zhaohu->coupon_end_ts) . " ". date('H', $zhaohu->coupon_end_ts) . ':' . date('i', $zhaohu->coupon_end_ts) . '</div>';
	}
	$zhaohu_details .= '</div>';
	// Location	
	if($zhaohu->location)
	{
		$location_link = elgg_view('output/url', array(
			'href' => "https://maps.google.com/?q=" . $zhaohu->getLocation(),
			'text' => $zhaohu->getLocation()));
		$zhaohu_details .= '<div><label>' . elgg_echo('zhaohu:location') . ': </label>';
		$zhaohu_details .= '<span id="zhaohu_gm_location">' . $location_link . '</span></div>';
	}
	
	// tags/interest
// 	$tags = $zhaohu->getTags();
// 	if($tags){
// 		$zhaohu_details .= '<div style="display:inline-flex;"><label>' . elgg_echo('profile:interests') . ':</label>';
// 		$zhaohu_details .= elgg_view("output/tags", array('value' => $tags)). '</div>';
// 	}
	
	$owner_link = elgg_view('output/url', array(
			'href' => $owner->getURL(),
			'text' => $owner->name,
			'is_trusted' => true));
	
	$author_text = elgg_echo('zhaouhu:initiated_by') . ': ' . $owner_link;
	$zhaohu_details .= '<div><label>'.$author_text.'</label></div>';

// 	$max_attendees = !$zhaohu->max_attendees? elgg_echo('None'):$zhaohu->max_attendees;
// 	$zhaohu_details .= '<div><label>' . elgg_echo('zhaohu:max_attendees') . ': </label>'
// 			. $max_attendees . '</div>';
	
// 	$min_attendees = !$zhaohu->min_attendees? elgg_echo('None'):$zhaohu->min_attendees;
// 	$zhaohu_details .= '<div><label>' . elgg_echo('zhaohu:min_attendees') . ': </label>'
// 			. $min_attendees . '</div>';
	
	$fee = !$zhaohu->fee?elgg_echo('None'):$zhaohu->fee;
	$zhaohu_details .= '<div><label>' . elgg_echo('zhaohu:fee') . ': </label>'
				. elgg_view("output/text", array("value" => $fee)) . '</div>';
	
	$contact_details = !$zhaohu->contact_details?elgg_echo('None'):$zhaohu->contact_details;
	$zhaohu_details .= '<div><label>' . elgg_echo('zhaohu:contact_details') . ': </label>'
			. elgg_view("output/text", array("value" => $contact_details)). '</div>';
	

	$zhaohu_details .= '</div>';
	
	// Render zhaohu details information
	$body = elgg_view(
				"zhaohu_manager/zhaohu/div_container", 
				array(
					"content" => $zhaohu_details ,
					"div_class" => "zhaohu-details-info-mobile",
					"div_id" => "zhaohu_details_information_mobile"));

	$zhaohu_description = !$zhaohu->description?elgg_echo('None'):$zhaohu->description;
	$zhaohu_description = '<label>' . elgg_echo('description') . ':</label>' 
		. elgg_view("output/longtext", array("value" => $zhaohu_description));
	
	$body .= elgg_view(
				"zhaohu_manager/zhaohu/div_container",
				array("content" => $zhaohu_description,
						"div_class" => "zhaohu_details_mobile"));

	if($zhaohu->status == 'published'){
		$body .= '<div class="zhaohu_more_mobile">'
				.elgg_view("zhaohu_manager/zhaohu/attendees",
						array("entity" => $zhaohu)) . '</div>';
		
		$body .= '<div class="zhaohu_more_mobile">'
				.elgg_view('wire/event', array('entity_guid'=>$zhaohu->guid, 'show_add_form'=>true))
				. '</div>';
	}

	echo $body;
?>
<?php	