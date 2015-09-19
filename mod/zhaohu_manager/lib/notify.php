<?php
//for testing only
function notifyOnCoupon($user, $zhaohu, $coupon, $group) {
	$siteUrl = elgg_get_site_url();
	$couponUrl = $siteUrl."zhaohus/coupon/qrcode?guid={$zhaohu->guid}&code={$coupon->code}";
	$profileUrl = $siteUrl."zhaohus/coupons/{$user->username}";
	$subject = elgg_echo('zhaohu:coupon:subject', array($zhaohu->title));
	$message = '<div style="color:#333;font-size:16px;padding-bottom: 20px;">' . elgg_echo('zhaohu:coupon:body', array(
			$user->name,
			$zhaohu->getURL(),
			$zhaohu->title,
			$couponUrl,
			$profileUrl)).'</div>';
	zhgroups_send_email_to_user($group, $user, $subject, $message, false, true);
}

function sendCoupon($group, $zhaohu, $user, $subject, $siteUrl) {
	$coupon = getCouponPerUserEvent($zhaohu->guid, $user->guid);
	if($coupon==null){
		elgg_log("ZHError ,sendCoupon, did not find coupon for zhaohu_id {$zhaohu->guid}, user_id {$user->guid}", "ERROR");
		return false;
	}
	//fordebug register_error("group name {$group->name}, user id {$user->guid}");	
	$couponUrl = $siteUrl."zhaohus/coupon/qrcode?guid={$zhaohu->guid}&code={$coupon->code}";
	$profileUrl = $siteUrl."zhaohus/coupons/{$user->username}";
	$subject = elgg_echo('zhaohu:coupon:subject', array($zhaohu->title));
	$message = '<div style="color:#333;font-size:16px;padding-bottom: 20px;">' . elgg_echo('zhaohu:coupon:body', array(
			$user->name,
			$zhaohu->getURL(),
			$zhaohu->title,
			$couponUrl,
			$profileUrl)).'</div>';
	
	//fordebug register_error("coupon code {$coupon->code} profile url {$profileUrl}");
	return zhgroups_send_email_to_user($group, $user, $subject, $message, false, true);
}

function sendCoupons($zhaohu) {
	if(!elgg_is_admin_logged_in()){
		register_error(elgg_echo("coupon:nopermission") . elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError ,zhaohuSendCoupon, user has no permission, user_id "
				.elgg_get_logged_in_user_guid(), "ERROR");
				return false;
	}
// 	if(!$zhaohu->isPast()){
// 		system_message(elgg_echo("coupon:notdue"));
// 		return false;
// 	}
	if(!$zhaohu->hasEnoughCouponers()){
		system_message(elgg_echo("coupon:notenough"));
		return false;
	}
	$group_guid = $zhaohu->container_guid;
	$group = get_entity($group_guid);

	if (empty($group) || !($group instanceof ElggGroup)) {
		register_error(elgg_echo("coupon:send:err") . elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError ,sendCoupons, invalid group, group_id $group_guid, user_id "
		.elgg_get_logged_in_user_guid(), "ERROR");
		return false;
	}

	$attendees = $zhaohu->getAttendees(COUPON_OUT_LIMIT);
	$subject = elgg_echo('zhaohu:coupon:subject', array($zhaohu->title));
	$siteUrl = elgg_get_site_url();
	set_time_limit(0);
	foreach ($attendees as $user) {
		//fordebug register_error('user id '.$user->guid . 'ground id '.$group_guid);
		$res = sendCoupon($group, $zhaohu, $user, $subject, $siteUrl);
		if(!$res){
			elgg_log("ZHError ,sendCoupons, failed to send for user_id {$user->guid}, zhaohu_id {$zhaohu->guid}", "ERROR");
		} else {
			elgg_log("sendCoupons, sent ok for user_id {$user->guid}, zhaohu_id {$zhaohu->guid}", "ERROR");
		}
	}
	system_message(elgg_echo("coupon:send:ok"));
	return true;
}

function sendEventDigestPerGroup($group_guid) {
	$group = get_entity($group_guid);
	if (empty($group) || !($group instanceof ElggGroup)) {
		register_error(elgg_echo("zhgroup:digest:error") . elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError, sendEventDigestPerGroup, group is invalid group_id {$group_guid}, user_id "
			.elgg_get_logged_in_user_guid(), "ERROR");
		return false;
	}
	$options = array(
			"container_guid" => $group_guid,
			"has_updates" => true,
			'offset' => 0,
			'limit' => EVENT_IN_GROUP_DIGEST_LIMIT
	);
	$res = zhaohu_manager_find_zhaohus ( $options );
	$events = $res["entities"];
	$count = $res["count"];
	if($count < EVENT_IN_GROUP_DIGEST_LIMIT){
		return true;
	}
	
	$subject = elgg_echo("zhgroup:digest:subject", array($events['0']->title, $events['1']->title));
	
	$body = '<table align="center" border="0" cellspacing="0" cellpadding="0" width="634" bgcolor="#FFFFFF" style="min-width:634px;border-collapse:collapse;color:#222222"><tbody><tr>';
	$body .= '<table border="0" bgcolor="#f1f1f1" cellspacing="0" cellpadding="0" width="630" style="min-width:630px;border-collapse:collapse">'
		.'<tbody><tr><td style="padding:18px 0 15px 25px;color:#222222;font-family:sans-serif;font-size:20px;font-weight:bold">'.elgg_echo("zhgroup:digest:intro", array($group->getURL(), $group->name)).'</td></tr></tbody></table>';
	$body .= '<table border="0" bgcolor="#FAFBFB" cellspacing="0" cellpadding="0" width="630" style="min-width:630px;border-collapse:collapse"><tbody>';
	$eventsInfo = array();
	$eventsIcon = array();
	$eventsAttendees = array();
	foreach ($events as $key=>$event){
		//fordebug register_error("event id {$event->title}");
		$eventsInfo[] = printDigestEventInfo($event);
		$eventsIcon[] = printDigestEventIcon($event);
		$eventsAttendees[] = '<tr><td width="606" style="min-width:606px;padding:0px 0 5px 25px">'
			.zhaohuPubEmailAttendees($event).'</td></tr>';
	}
	$members = $group->getMembers(false);
	set_time_limit(0);
	//fordebug $done= false;
	foreach ($members as $member) {
		//fordebug register_error('mem id '.$member->guid . 'ground id '.$group_guid);
		if ($notification_settings = get_user_notification_settings($member->guid)) {
			if ($notification_settings->email && check_entity_relationship ( $member->guid, 'notifyemail', $group_guid )) {
				$bodyPerUser = $body;
				for($i=0;$i<$count;$i++){
					//left
					$bodyPerUser .= $eventsInfo[$i];
					$bodyPerUser .= '<tr><td>'.zhaohuPubEmailPart2($events[$i], $member->guid).'</td></tr>';
					$bodyPerUser .= '</tbody></table></td></tr></tbody></table>';
					//right
					$bodyPerUser .= $eventsIcon[$i];
					$bodyPerUser .= '</div></td></tr>';
					$bodyPerUser .= $eventsAttendees[$i];
					$events[$i]->hasUpdates = false;
				}

				$bodyPerUser .= '</tbody></table></tr></tbody></table>';
				//fordebug if(!$done){ register_error("body {$bodyPerUser}"); $done=true;}
				zhgroups_send_email_to_user($group, $member, $subject, $bodyPerUser, true, true);
			}
		}
	}
	system_message(elgg_echo("zhgroup:digest:ok"));
}

function zhaohuPubedNotify($zhaohu) {
	if(!$zhaohu->hasUpdates){
		system_message(elgg_echo("zhaohu:notify:noupdates"));
		return;
	}
	$subject = 'Join ' . $zhaohu->title . ' ' . date(ZHAOHU_MANAGER_FORMAT_DATE, $zhaohu->start_day);
	$group_guid = $zhaohu->container_guid;
	$group = get_entity($group_guid);

	if (!empty($group) && ($group instanceof ElggGroup)) {
		//comment to let everyone new zhaohu
// 		if ($group->canEdit()) {
			$body = zhaohuPubEmailPart1($zhaohu, $group);

			$members = $group->getMembers(false);
			set_time_limit(0);

			foreach ($members as $member) {
				//fordebug register_error('mem id '.$member->guid . 'ground id '.$group_guid);
				if ($notification_settings = get_user_notification_settings($member->guid)) {
					if ($notification_settings->email && check_entity_relationship ( $member->guid, 'notifyemail', $group_guid )) {
							$bodyOut = $body.zhaohuPubEmailPart2($zhaohu, $member->guid);
							//notify_user($member->guid, $group_guid, $subject, $bodyOut, NULL);//, "email"
							zhgroups_send_email_to_user($group, $member, $subject, $bodyOut, true, true);
					}
				}
			}
			$zhaohu->hasUpdates = false;
			system_message(elgg_echo("zhaohu:notify:ok"));
// 		} else {
// 			register_error(elgg_echo("zhaohu:notify:error") . elgg_echo("zhaohu:sorry"));
// 			elgg_log("ZHError ,zhaohuPubedNotify, user has no permission to this group, group_id $group_guid, user_id "
// 				.elgg_get_logged_in_user_guid(), "ERROR");
// 		}
		} else {
		register_error(elgg_echo("zhaohu:notify:error") . elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError ,zhaohuPubedNotify, invalid group, group_id $group_guid, user_id "
			.elgg_get_logged_in_user_guid(), "ERROR");
		}
}

function zhaohuPubEmailAttendees($zhaohu) {
	$content = '';
	$count = $zhaohu->countAttendees();
	//fordebug system_message("count " . $count);
	if($count < ZHAOHU_ATTENDEE_IN_EMAIL)
		return $content;

	$content .= '<div style="border-bottom:1px dotted #ccc">';
	$content .= '<div style="border-top:5px;border-bottom:5px;">';
	//$content .= '<div style="border-top:10px solid #fff;border-bottom:10px solid #fff;background:#fff">';
	$content .= '<div style="color:#333;font-size:16px;font-weight:bold">';
	$content .= $count . elgg_echo('zhaohu:mail:attendees');
	$content .= '</div><div style="clear:both;width:100%;overflow:hidden">';
	$offset = 0;
	$limit = 2; // ZHAOHU_EMAIL_ATTENDEE_LIMIT

	$users = $zhaohu->getAttendees ( $limit, $offset );
	//fordebug foreach ($users as $u) { system_message("user_id ".$u->guid); }

	if ($users) {
		foreach ( $users as $u ) {
			$content .= '<div style="float:left;border-top:10px;border-left:none;border-right:15px;width:46%;max-width:46%;min-width:220px">';
			$content .= '<table style="width:100%"><tbody><tr><td style="min-width:52px;padding-right:10px;overflow:hidden;min-height:52px;height:52px;max-height:52px;width:52px" valign="top">';
			$content .= '<div style="min-height:52px;overflow:hidden;min-width:52px;min-height:52px;max-height:52px">';
			$content .= elgg_view_entity_icon ( $u, "small" );
			$content .= '</div></td><td align="left" valign="top"><div style="border-bottom:5px;line-height:16px;font-size:16px;">';
			$content .= '<a href="'.$u->getURL().'" style="color:#333;text-decoration:none" target="_blank">'.$u->name.'</a>';
			$content .= '</div><div style="border-bottom:5px;line-height:14px;font-size:14px">"'.strip_tags(mb_substr($u->description, 0, 20)). '..."</div>';
			$content .= '</td></tr></tbody></table></div>';
		}
	}
	$content .= '</div></div></div>';
	return $content;
}

function printDigestEventInfo($zhaohu) {
	$email = '<tr><td width="606" style="min-width:606px;padding:10px 0 25px 25px"><div>';
	$email .= '<table align="left" border="0" cellspacing="0" cellpadding="0" width="311" style="border-collapse:collapse"><tbody><tr><td>';
	$email .= '<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="border-collapse:collapse"><tbody>';
	
	$email .= '<tr><td style="padding-bottom:5px"><a href="'.$zhaohu->getURL().'" style="text-decoration:none;color:#222222;font-family:sans-serif;font-size:24px;padding:10px 0 5px" target="_blank">'.$zhaohu->title.'</a></td></tr>';
	//time
	$email .= '<tr><td style="color:#222222;font-family:sans-serif;font-size:16px;padding-bottom:2px">'.date(ZHAOHU_MANAGER_FORMAT_DATE, $zhaohu->start_day)
	.' '. date('H', $zhaohu->start_time). ':' . date('i', $zhaohu->start_time).'</td></tr>';
	//locaiton
	$email .= '<tr><td style="color:#222222;font-family:sans-serif;font-size:16px;padding-bottom:2px">'.$zhaohu->location.'</td></tr>';
	//description
	$email .= '<tr><td style="padding-bottom:2px"><a href="'.$zhaohu->getURL()
	.'" style="text-decoration:none;color:#222222;font-family:sans-serif;font-size:16px;" target="_blank"><font color="#333">'.mb_substr($zhaohu->description, 0, 100) .'...</font></a></td></tr>';

	return $email;
}
function printDigestEventIcon($zhaohu) {
	return '<table align="left" border="0" cellspacing="0" cellpadding="0" width="150" style="border-collapse:collapse"><tbody><tr><td><a href="'
			. $zhaohu->getURL() .'" target="_blank"><img width="150" border="0" align="right" style="margin:0" src="'
			. $zhaohu->getIcon('large') .'" alt="'. $zhaohu->title .'"></a></td></tr></tbody></table>';
}

function zhaohuPubEmailPart1($zhaohu, $group) {
	$email = '';
	$email .= '<div><a style="float:right" href="' . $zhaohu->getURL() . '" target="_blank"><img src="' . $zhaohu->getIcon('medium') . '"/></a></div>';
	$email .= '<div><a style="font-size:26px;font-weight:bold;padding:5px;" href="'
			.$zhaohu->getURL().'"target="_blank">'.$zhaohu->title.'</a></div>';
	
	$email .= '<div><a style="font-size:18px;line-height:20px;padding:5px;" href="'
		.$group->getURL().'" target="_blank"><font color="#DF7401">'.$group->name.'</font></a></div>';
	
	//time
	$email .= '<div style="font-size:16px;line-height:20px;padding:5px;"><span style="color:#333">'
			.date(ZHAOHU_MANAGER_FORMAT_DATE, $zhaohu->start_day) 
			.' '. date('H', $zhaohu->start_time). ':' . date('i', $zhaohu->start_time).'</span></div>';
	//locaiton
	$email .= '<div style="font-size:16px;line-height:20px;padding:5px;"><span style="color:#333">'
			.$zhaohu->location.'</span></div>';
	
	//description
	$email .= '<div style="font-size:16px;padding:5px;"><a href="'
			.$zhaohu->getURL().'" style="text-decoration:none;" target="_blank"><font color="#333">'
			.mb_substr($zhaohu->description, 0, 100) .'...</font></a></div>';
	
	//attendees
	$email .= zhaohuPubEmailAttendees($zhaohu);
	return $email;
}

function zhaohuPubEmailPart2($zhaohu, $user_guid) {
	$url = elgg_get_site_url() . "zhaohus/zhaohu/emRsvp?guid=" . $zhaohu->getGUID(). "&user=" .$user_guid. "&type=" . ZHAOHU_MANAGER_RELATION_ATTENDING."&k=".md5($zhaohu->time_created . get_site_secret() . $user_guid);
	$emRsvp = '<div style="background-color:#FE9A20;padding:4px 22px;border-radius:4px;margin-top:5px;margin-right:5px;display:inline-block;font-size:18px;text-decoration:none;"><a style="text-decoration:none;" href='
			.$url.'><font color="#FFF">'.elgg_echo('zhaohu:relationship:' . ZHAOHU_MANAGER_RELATION_ATTENDING).'</font></a></div>';
	return $emRsvp;
}

function zhaohuEmailHead() {
	return '<div style="margin-bottom:10px"><table style="width:100%" cellpadding="0" cellspacing="0"><tbody><tr>'
			.'<td style="padding:0;"><a href="http://www.51zhaohu.com/" target="_blank"><img src="http://51zhaohu.com/mod/zhaohu_theme/images/51logo.png" alt="51zhaohu" style="border:0" height="70"></a></td>'
			.'</tr></tbody></table></div>';
}

function zhaohuEmailSupport(){
	return  '<div style="border-top:10px solid #fff;border-bottom:10px solid #fff;background:#fff;font-size:14px;color:#333">'
			.elgg_echo('zhaohu:support', array(elgg_get_site_url() .'zhaohu_about/help_center')) .'</div>';
}

function zhaohuEmailSocialButtons(){	
	return '<table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tbody><tr><td align="center" valign="bottom">'				
		.'<div style="color:#333;font-size:15px;font-weight:bold;margin-bottom:8px;">Follow us</div></td></tr><tr><td align="center">'
		.'<a href="https://www.facebook.com/51zhaohu" target="_blank" style="margin-right:5px"><img src="http://www.51zhaohu.com/mod/zhaohu_theme/images/fb.png" alt="Facebook" style="border:0" height="40" width="40"></a>'
		.'<a href="https://twitter.com/51zhaohu" target="_blank" style="margin-right:5px"><img src="http://www.51zhaohu.com/mod/zhaohu_theme/images/twitter.png" alt="Twitter" style="border:0" height="40" width="40"></a>'
		.'<a href="http://www.pinterest.com/51zhaohu/" target="_blank" style="margin-right:5px"><img src="http://www.51zhaohu.com/mod/zhaohu_theme/images/pinterest.png" alt="Pinterest" style="border:0" height="40" width="40"></a>'
		.'</td></tr></tbody></table>';
}

function zhaohuEmailEnd(){
	return zhaohuEmailSupport() . zhaohuEmailSocialButtons() . '<div style="clear:both;background:#ececec;text-align:center;margin-top:20px;border-top:solid 10px #ececec;border-bottom:solid 10px #ececec">'
			.'<div style="width:94%;margin:0 auto;border-left:solid 10px #ececec;border-right:solid 10px #ececec;min-width:220px;max-width:600px;text-align:left;font-family:arial;color:#333;font-size:12px;line-height:14px">'
			.'<p style="margin:0 0 .25em;color:#333">'.elgg_echo('51zhaohu').': http://51zhaohu.com</p></div></div>';
}

function zhaohuEmailUnsubEnd($group, $user_guid, $is_notificiation, $from_group){	
	$end = '<div style="clear:both;background:#ececec;text-align:center;margin-top:20px;border-top:solid 10px #ececec;border-bottom:solid 10px #ececec">'
			.'<div style="width:94%;margin:0 auto;border-left:solid 10px #ececec;border-right:solid 10px #ececec;min-width:220px;max-width:600px;text-align:left;font-family:arial;color:#333;font-size:12px;line-height:14px">';
	
	if($is_notificiation){
		if($from_group) {
			$unsub = elgg_get_site_url() . "zhgroups/emUnsub?guid=" . $group->guid . "&user=" .$user_guid. "&k=".md5($group->time_created . get_site_secret() . $user_guid);
			$end .= '<p style="margin:0 0 .25em;color:#333"><a href="'.$unsub.'" style="color:#ccc;text-decoration:underline" target="_blank">'
					.elgg_echo('zhgroups:mail:unsub1').'</a> '.elgg_echo('zhgroups:mail:unsub2').'</p>';
		}
		$end .= '<p style="margin:0 0 .25em;color:#333">'.elgg_echo('zhgroups:unsub:site').'</p>';
	}

	$end .= '<p style="margin:0 0 .25em;color:#333">'.elgg_echo('51zhaohu').': http://51zhaohu.com</p></div></div>';
	return zhaohuEmailSupport() . zhaohuEmailSocialButtons() . $end;
}

function zhgroups_send_email_to_user($group, $to_user, $subject, $message, $is_notificiation, $from_group){
	if($is_notificiation){
		if ($notification_settings = get_user_notification_settings($to_user->guid)) {
			if (!$notification_settings->email || !check_entity_relationship ($to_user->guid, 'notifyemail', $group->guid )) 
				return;
		} else {
			elgg_log("ZHError ,zhgroups_send_email_to_user, error calling get_user_notification_settings, group_id {$group->guid}, "
			."to_user_id {$to_user->guid}, logged_user_id ".elgg_get_logged_in_user_guid(), "ERROR");
			return;
		}
	}
	$end = zhaohuEmailUnsubEnd($group, $to_user->guid, $is_notificiation, $from_group);
	$to_email = $to_user->name . "<" . $to_user->email. ">";
	return zhgroups_send_email($group->name, $to_email, $subject, $message, $end);
}

//site wide email
function zhsite_send_email_to_user($to_user, $subject, $message, $is_notificiation){
	if($is_notificiation){
		if ($notification_settings = get_user_notification_settings($to_user->guid)) {
			if (!$notification_settings->email )
				return false;
		} else {
			elgg_log("ZHError ,zhsite_send_email_to_user, error calling get_user_notification_settings, to_user_id {$to_user->guid}, "
				."logged_user_id ".elgg_get_logged_in_user_guid(), "ERROR");
			return false;
		}
	}
	$end = zhaohuEmailUnsubEnd(null, $to_user->guid, $is_notificiation, false);
	$to_email = $to_user->name . "<" . $to_user->email. ">";
	return zhgroups_send_email(elgg_get_site_entity()->name, $to_email, $subject, $message, $end);
}

function zhgroups_send_email($from_name, $to_email, $subject, $message, $end=''){
	$site = elgg_get_site_entity();
	if ($site->email){
		$site_from = $from_name . " <" . $site->email . ">";
	} else {
		// no site email, so make one up
		$site_from = $from_name . " <noreply@" . get_site_domain($site->getGUID()) . ">";
	}
	if(empty($end))
		$body = zhaohuEmailHead().$message.zhaohuEmailEnd();
	else
		$body = zhaohuEmailHead().$message.$end;
	return elgg_send_email($site_from, $to_email, $subject, $body);
}
