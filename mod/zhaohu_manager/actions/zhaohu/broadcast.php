<?php

$zhaohu_guid = (int) get_input('zhaohu_guid');
$subject = get_input('subject', $_SESSION['zhaouhu:subject']);
$message = get_input('message', $_SESSION['zhaouhu:msg']);
$_SESSION['zhaouhu:subject'] = $subject;
$_SESSION['zhaouhu:msg'] = $message;
$limit = ZHAOHU_MANAGER_BROADCAST_LIMIT;//

$zhaohu = get_entity($zhaohu_guid);
$group = get_entity($zhaohu->container_guid);
if (empty($group) || !($group instanceof ElggGroup)) {
	register_error(elgg_echo("zhaohu:broadcast:error"). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError ,zhaohu:broadcast, invalid group, group_id $zhaohu->container_guid, zhaohu_id $zhaohu_guid, user_id "
		.elgg_get_logged_in_user_guid(), "ERROR");	
	forward(REFERER);
}

if (!($zhaohu instanceof Zhaohu)) {
	register_error ( elgg_echo ( "zhaohu:broadcast:error" ) . elgg_echo ( "zhaohu:sorry" ) );
	elgg_log ( "ZHError ,zhaohu:broadcast, invalid zhaohu, zhaohu_id $zhaohu_guid, user_id " . elgg_get_logged_in_user_guid (), "ERROR" );
	forward ( REFERER );
}
if (!elgg_is_logged_in() || !$zhaohu->canEdit()) {
	register_error(elgg_echo("zhaohu:broadcast:error"). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError ,zhaohu:broadcast, not logged in or no permission, zhaohu_id $zhaohu_guid, user_id "
	.elgg_get_logged_in_user_guid(), "ERROR");
	forward(REFERER);
}
if($zhaohu->isPast()){
	register_error(elgg_echo("zhaohu:broadcast:past"));
	forward(REFERER);
}
if($zhaohu->status != 'published'){
	register_error(elgg_echo("zhaohu:broadcast:unpublished"));
	forward(REFERER);
}

		if(empty($subject)) {			
			register_error(elgg_echo('zhaohu:broadcast:subject:empty'));
			forward(REFERER);				
		}
		if(empty($message)) {
			register_error(elgg_echo('zhaohu:broadcast:message:empty'));
			forward(REFERER);
		}		

		$count = $zhaohu->countAttendees();
		//fordebug system_message("count " . $count);
		if($count==0)
		{
			system_message(elgg_echo("zhaohu:noattendees"));
			forward(REFERER);
		}
		$offset = 0;
		$errCount = 0;
		if(substr($message, 0, 4)!='<div')
			$message = '<div style="color:#333;font-size:16px;">' .$message.'</div>';
		
		//totest if the last user would get the message
		for(;$offset < $count;$offset += $limit)
		{
			$users = $zhaohu->getAttendees($limit, $offset);
			/*fordebug foreach ($users as $u) {system_message("user_id ".$u->guid);}*/
			if ($users) {
				foreach ($users as $u) {
					set_time_limit(120); // ask for more time
					//notify_user($u->guid, $zhaohu->guid, $subject, $message);
					if(!zhgroups_send_email_to_user($group, $u, $subject, $message, false, true)){
						$errCount ++;
						elgg_log("ZHError ,zhaohu:broadcast, error calling zhgroups_send_email_to_user, to_user_id $u->guid", "ERROR");
					}						
				}
			}
			else {
				register_error(elgg_echo("zhaohu:broadcast:error"). elgg_echo("zhaohu:sorry"));
				elgg_log("ZHError ,zhaohu:broadcast, error calling zhaohu->getAttendees, zhaohu_id $zhaohu_guid, user_id "
					.elgg_get_logged_in_user_guid(), "ERROR");
				forward(REFERER);
			}
		}
		
		if($errCount==0)
			system_message(elgg_echo('zhaohu:broadcast:success'));
		else {
			register_error(elgg_echo("zhaohu:broadcast:email:error"). elgg_echo("zhaohu:sorry"));
			elgg_log("ZHError ,zhaohu:broadcast, error calling zhgroups_send_email_to_user, errCount $errCount, zhaohu_id $zhaohu_guid, user_id "
			.elgg_get_logged_in_user_guid(), "ERROR");
		}
		// Cleanup session
		unset($_SESSION['zhaouhu:subject']);
		unset($_SESSION['zhaouhu:msg']);
		forward(REFERER);
