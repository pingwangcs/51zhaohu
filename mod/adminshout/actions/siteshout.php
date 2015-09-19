<?php

$subject = get_input('subject', $_SESSION['_adminshout:subject']);
$message = get_input('message', $_SESSION['_adminshout:message']);
$__elgg_ts = get_input('__elgg_ts');
$__elgg_token = get_input("__elgg_token");

$offset = (int)get_input('offset', 0);
$limit = 2000;
$success = 0;
$failed = 0;
//check there is a title and message
if($subject && $message){

	$users = elgg_get_entities(array('type' => 'user', 'limit' => $limit, 'offset' => $offset));
	
	if ($users) {
		$_SESSION['_adminshout:subject'] = $subject;
		$_SESSION['_adminshout:message'] = $message;
		
		foreach ($users as $u) {
			if(!$u->isBanned()){
				set_time_limit(60); // ask for more time
				//notify_user($u->guid, $u->site_guid, $subject, $message);				
				$result = zhsite_send_email_to_user($u, $subject, $message, true);
				if($result)
					$success ++;
				else {
					$failed ++;
					elgg_log("Error in siteshout for user id {$u->guid}", "ERROR");
				}
			}
		}
		
		$offset += $limit;
		
		elgg_log("siteshout success {$success}, failed {$failed}", "ERROR");
		forward(elgg_get_site_url() . "action/adminshout/siteshout?offset=$offset&__elgg_ts=$__elgg_ts&__elgg_token=$__elgg_token");
	} else {
		// If there are no more users and the offset is greater than zero that means we have processed some
		// messages
		if ($offset>0) {
			system_message(elgg_echo('adminshout:success'));
		} else {
			register_error(elgg_echo('adminshout:fail'));
		}
	}
	
	// Cleanup session
	$_SESSION['_adminshout:subject'] = "";
	$_SESSION['_adminshout:message'] = "";
	unset($_SESSION['_adminshout:subject']);
	unset($_SESSION['_adminshout:message']);
	
} else {
	register_error(elgg_echo('adminshout:inputs'));
}

// Forward to shout page
forward(REFERER);
		

?>
