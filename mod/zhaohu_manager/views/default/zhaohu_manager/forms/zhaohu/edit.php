<?php
elgg_load_js("zhaohu_manager.edit");
elgg_load_js("location");

	$group = elgg_get_page_owner_entity();
	// defaults
	$fields = array(
			"guid" => ELGG_ENTITIES_ANY_VALUE,
			"title" => ELGG_ENTITIES_ANY_VALUE,
			"status" => 'draft',
			"tags" => ELGG_ENTITIES_ANY_VALUE,
			"description" => ELGG_ENTITIES_ANY_VALUE,
			"country" => ELGG_ENTITIES_ANY_VALUE,
			"state" => ELGG_ENTITIES_ANY_VALUE,
			"city" => ELGG_ENTITIES_ANY_VALUE,
			"address" => ELGG_ENTITIES_ANY_VALUE,
			"zip" => ELGG_ENTITIES_ANY_VALUE,
			"location" => ELGG_ENTITIES_ANY_VALUE,
			"latitude" => ELGG_ENTITIES_ANY_VALUE,
			"longitude" => ELGG_ENTITIES_ANY_VALUE,
			"website" => ELGG_ENTITIES_ANY_VALUE,
			"contact_details" => ELGG_ENTITIES_ANY_VALUE,
			"videoUrl" => ELGG_ENTITIES_ANY_VALUE,
			"fee" => ELGG_ENTITIES_ANY_VALUE,
			"currency" => ELGG_ENTITIES_ANY_VALUE,
			'payoption1name'=> ELGG_ENTITIES_ANY_VALUE,
			'payoption1value'=> ELGG_ENTITIES_ANY_VALUE,
			'payoption2name'=> ELGG_ENTITIES_ANY_VALUE,
			'payoption2value'=> ELGG_ENTITIES_ANY_VALUE,
			"buyButtonID" => ELGG_ENTITIES_ANY_VALUE,
			"start_day" => date(ZHAOHU_MANAGER_FORMAT_DATE, time()),
			"end_day" => date(ZHAOHU_MANAGER_FORMAT_DATE, time()),
			"coupon_end_day" => date(ZHAOHU_MANAGER_FORMAT_DATE, time()),
			"start_time" => time(),
			"end_ts" => time()+3600,
			"coupon_end_ts" => time()+3600,
			//"registration_ended" => ELGG_ENTITIES_ANY_VALUE,
			//"hide_owner_block" => ELGG_ENTITIES_ANY_VALUE,
			//"notify_onsignup" => ELGG_ENTITIES_ANY_VALUE,
			"max_attendees" => ELGG_ENTITIES_ANY_VALUE,
			"has_coupon" => 0,
			"use_paypal" => 0,
			"min_attendees"=> ELGG_ENTITIES_ANY_VALUE,
			"access_id" => get_default_access(),
			"container_guid" => $group->getGUID(),
			//"zhaohu_going" => 0,
			//"registration_completed" => ELGG_ENTITIES_ANY_VALUE,
		);
	
	if ($zhaohu = $vars['entity']) {
		// edit mode
		$fields["guid"] = $zhaohu->getGUID();
		$fields["location"] = $zhaohu->getLocation();
		$fields["latitude"] = $zhaohu->getLatitude();
		$fields["longitude"] = $zhaohu->getLongitude();
		$fields["tags"] = string_to_tag_array($zhaohu->tags);
		
		if ($zhaohu->icontime) {
			$currentIcon = '<img src="' . $zhaohu->getIcon() . '" />';
		}
		
		foreach ($fields as $field => $value) {
			if (!in_array($field, array("guid", "location", "latitude", "longitude"))) {
				$fields[$field] = $zhaohu->$field;
			}
		}
		
		if ($zhaohu->status == 'draft') {
			$fields['access_id'] = $zhaohu->future_access;
		}
		
		// convert timestamp to date notation for correct display
		if (!empty($fields["start_day"])) {
			$fields["start_day"] = date(ZHAOHU_MANAGER_FORMAT_DATE, $fields["start_day"]);
		}
		if (!empty($fields["end_day"])) {
			$fields["end_day"] = date(ZHAOHU_MANAGER_FORMAT_DATE, $fields["end_day"]);
		} else
			$fields["end_day"] = date(ZHAOHU_MANAGER_FORMAT_DATE, $fields["start_day"]);
	}
	
	if (elgg_is_sticky_form('zhaohu')) {
		// merge defaults with sticky data
		$fields = array_merge($fields, elgg_get_sticky_values('zhaohu'));
	}
	
	elgg_clear_sticky_form('zhaohu');
	$form_body .= elgg_view('input/hidden', array('name' => 'latitude', 'id' => 'zhaohu_latitude', 'value' => $fields["latitude"]));
	$form_body .= elgg_view('input/hidden', array('name' => 'longitude', 'id' => 'zhaohu_longitude', 'value' => $fields["longitude"]));
	$form_body .= elgg_view('input/hidden', array('name' => 'guid', 'value' => $fields["guid"]));
	$form_body .= elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $fields["container_guid"]));
	
	$form_body .= "<table>";
	
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('title') . " *</td><td>" . elgg_view('input/text', array('name' => 'title', 'value' => $fields["title"])) . "</td></tr>";
	
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:edit:start:date') . " *</td>";
	$form_body .= "<td>" . elgg_view('input/date', array('name' => 'start_day', 'id' => 'start_day', 'value' => $fields["start_day"], "class" => "zhaohu_manager_zhaohu_edit_date")) . "</td></tr>";
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:edit:start:time') . "</td>";	
	$form_body .= "<td>" . zhaohu_manager_get_form_pulldown_hours('start_time_hours', date('H', $fields["start_time"]));
	$form_body .= zhaohu_manager_get_form_pulldown_minutes('start_time_minutes', date('i', $fields["start_time"])) . "</td></tr>";
	
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:edit:end:date') . "</td>";
	$form_body .= "<td>" . elgg_view('input/date', array('name' => 'end_day', 'id' => 'end_day', 'value' => $fields["end_day"], "class" => "zhaohu_manager_zhaohu_edit_date")) . "</td></tr>";
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:edit:end:time') . "</td>";
	$form_body .= "<td>" . zhaohu_manager_get_form_pulldown_hours('end_time_hours', date('H', $fields["end_ts"]));
	$form_body .= zhaohu_manager_get_form_pulldown_minutes('end_time_minutes', date('i', $fields["end_ts"])) . "</td></tr>";
	
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('description') . " *</td><td>" . elgg_view('input/longtext', array('name' => 'description', 'value' => $fields["description"])) . "</td></tr>";
	
	$iDD = genTagDiv("zhe_i_dd", "zhe-i-opt");
	
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('tags') . 
	" *</td><td>" . elgg_view('input/tags', array('id'=>'zhe_i', 'name' => 'tags', 'value' => $fields["tags"]));
	$form_body .= $iDD;
	
	$form_body .= "</td></tr>";
	
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:edit:icon') . "</td><td>" . elgg_view('input/file', array('name' => 'icon')) . "</td></tr>";
	
	if (!empty($currentIcon)) {
		$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:edit:currenticon') . "</td><td>".$currentIcon."<br />".
		elgg_view('input/checkboxes', array('name' => 'delete_current_icon', 'id' => 'delete_current_icon', 'value' => 0, 'options' =>
		array(elgg_echo('zhaohu:edit:delete_current_icon')=>'1')))."</td></tr>";
	}
	if($fields["country"] == ELGG_ENTITIES_ANY_VALUE )
		$fields["country"] = 'US';
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:country') . " *</td><td>" 
		. elgg_view('input/dropdown', 
		array('id'=> 'zh_country', 
		'name' => 'country',
		'value' => $fields["country"],
		'options_values' => array('CA' => elgg_echo('can'), 'US' => elgg_echo('usa')))) . "</td></tr>";

	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:state') . " *</td><td>" . elgg_view('input/dropdown', array('id'=> 'zh_state', 'name' => 'state', 'value' => $fields["state"])) . "</td></tr>";
	echo elgg_view('input/hidden', array('id' => 'zh_state_val','value' => $fields["state"]));
	
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:city') . " *</td><td>" . elgg_view('input/text', array('id'=> 'zhe_city', 'name' => 'city', 'value' => $fields["city"])) . "</td></tr>";
	
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:address') . "</td><td>" . elgg_view('input/text', array('id' => 'zhe_address', 'name' => 'address', 'value' => $fields["address"])) . "</td></tr>";

	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:zip') . "</td><td>" . elgg_view('input/text', array('id'=> 'zhe_zip', 'name' => 'zip', 'value' => $fields["zip"])) . "</td></tr>";

	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:contact_details') . "</td><td>" . elgg_view('input/text', array('name' => 'contact_details', 'value' => $fields["contact_details"])) . "</td></tr>";
	
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:videoUrl') . "</td><td>" . elgg_view('input/text', array('name' => 'videoUrl', 'value' => $fields["videoUrl"])) . "</td></tr>";
	
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:use_paypal') ."</td><td>"
		 . elgg_view('input/dropdown', array('name' => 'use_paypal', 'value' => $fields["use_paypal"],
		 		'options_values' => array(0 =>elgg_echo('option:no'), 1 =>elgg_echo('option:yes')))) . "</td></tr>";
	
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:payoption1name') . "</td><td>" . elgg_view('input/text', array('name' => 'payoption1name', 'value' => $fields["payoption1name"])) . "</td></tr>";
	
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:payoption1value') . "</td><td>" . elgg_view('input/text', array('name' => 'payoption1value', 'value' => $fields["payoption1value"])) . "</td></tr>";
	
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:payoption2name') . "</td><td>" . elgg_view('input/text', array('name' => 'payoption2name', 'value' => $fields["payoption2name"])) . "</td></tr>";
	
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:payoption2value') . "</td><td>" . elgg_view('input/text', array('name' => 'payoption2value', 'value' => $fields["payoption2value"])) . "</td></tr>";
	
	
	if(elgg_is_admin_logged_in()){
		$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:buyButtonID') . "</td><td>" . elgg_view('input/text', array('name' => 'buyButtonID', 'value' => $fields["buyButtonID"])) . "</td></tr>";
	}
	
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:max_attendees') ." ". elgg_echo('zhaohu:arabic') . "</td><td>" . elgg_view('input/text', array('name' => 'max_attendees', 'value' => $fields["max_attendees"])) . "</td></tr>";

	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:has_coupon') ."</td><td>"
	 . elgg_view('input/dropdown', array('name' => 'has_coupon', 'value' => $fields["has_coupon"], 
	'options_values' => array(0 =>elgg_echo('option:no'), 1 =>elgg_echo('option:yes')))) . "</td></tr>";
	 
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('coupon:end:date') . "</td>";
	$form_body .= "<td>" . elgg_view('input/date', array('name' => 'coupon_end_day', 'id' => 'coupon_end_day', 'value' => $fields["coupon_end_day"], "class" => "zhaohu_manager_zhaohu_edit_date")) . "</td></tr>";
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('coupon:end:time') . "</td>";
	$form_body .= "<td>" . zhaohu_manager_get_form_pulldown_hours('coupon_end_time_hours', date('H', $fields["coupon_end_ts"]));
	$form_body .= zhaohu_manager_get_form_pulldown_minutes('coupon_end_time_minutes', date('i', $fields["coupon_end_ts"])) . "</td></tr>";
	 
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('zhaohu:min_attendees') ." ". elgg_echo('zhaohu:arabic') . "</td><td>" . elgg_view('input/text', array('name' => 'min_attendees', 'value' => $fields["min_attendees"])) . "</td></tr>";
	
	$form_body .= "</td></tr><tr><td>&nbsp</td></tr>";
	
	$form_body .= "<tr><td class='zhaohu_manager_zhaohu_edit_label'>" . elgg_echo('access') . "</td><td>" . elgg_view('input/access', array('name' => 'access_id', 'value' => $fields["access_id"])) . "</td></tr>";
	
	$form_body .= "</table>";
	
	$action_buttons = '';
	
	$draft_button = '';
	// published news do not get the draft button
	if (!$vars['entity'] || ($zhaohu && $zhaohu->status != 'published')) {
		$draft_button = elgg_view('input/submit', array(
				'value' => elgg_echo('zhaohu:draft'),
				'name' => 'draft',
				//'class' => 'mls',
		));
	}
	
	$publish_button = elgg_view('input/submit', array(
			'value' => elgg_echo('publish'),
			'name' => 'publish',
	));
	
	if($zhaohu)
		$cancelURL = $zhaohu->getURL();
	else
		$cancelURL = $group->getURL();
	$cancel_button = elgg_view('output/url', array(
			'text' => elgg_echo('cancel'),
			'href' => $cancelURL,
			'class' => 'elgg-button elgg-button-cancel',
	));
	
	$action_buttons = $draft_button . $publish_button . $cancel_button; 

	$form_body .= $action_buttons;
	$form_body .= '<div class="zhaohu_manager_required">(* = '.elgg_echo('zh:requiredfields').')</div>';
	
	$form = elgg_view('input/form', array(
									'id' => 'zhaohu_manager_zhaohu_edit',
									'name' 	=> 'zhaohu_manager_zhaohu_edit',
									'action' => '/action/zhaohu_manager/zhaohu/edit',
									'enctype' => 'multipart/form-data',
									'body' => $form_body
									));
	
	echo elgg_view_module("main", "", $form);
	
	// unset sticky data TODO: replace with sticky forms functionality
// 	$_SESSION['createzhaohu_values'] = null;