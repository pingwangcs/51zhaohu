<?php
if (!elgg_is_logged_in()) {
	register_error(elgg_echo("zhaohu:notloggedin"). elgg_echo("zhaohu:sorry"));
	forward(REFERER);
}

$logged_in_user = elgg_get_logged_in_user_entity();
$zhaohu_guid = (int) get_input('guid');
$zhaohu = get_entity($zhaohu_guid);

if (!($zhaohu instanceof Zhaohu)) {
	register_error ( elgg_echo ( "zhaohu:invite:err" ) . elgg_echo ( "zhaohu:sorry" ) );
	elgg_log ( "ZHError ,zhaohu:invite, invalid zhaohu, zhaohu_id $zhaohu_guid, user_id " . elgg_get_logged_in_user_guid (), "ERROR" );
	forward ( REFERER );
}
if($zhaohu->isPast()){
	register_error(elgg_echo("zhaohu:invite:past"));
	forward(REFERER);
}
if($zhaohu->status != 'published'){
	register_error(elgg_echo("zhaohu:invite:unpublished"));
	forward(REFERER);
}

$text = get_input("comment");
$emails = get_input("email2invite");
if(empty($emails)){
	register_error(elgg_echo("zhaohu:emails:empty"));
	forward(REFERER);
}
if (!is_array($emails))
	$emails = array($emails);
//fordebug register_error("emails ".$emails[0]);

$invited = 0; // counters
// Invite by e-mail address
if (!empty($emails)) {
	foreach ($emails as $email) {
		//fordebug register_error("$zhaohuid " . $zhaohu->guid . " email " . $email. " text " . $text . ' resend ' . $resend);
		$invite_result = send_invite_email($logged_in_user, $zhaohu, $email, $text);
		//fordebug register_error("invite_result  ".$invite_result );
		if ($invite_result === true) {
			$invited++;
		}
	}
}		
// which message to show
if ($invited) {
	system_message(elgg_echo("zhaohu:invite:ok"));
} else {
	register_error(elgg_echo('zhaohu:invite:err'). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError , zhgroups:invite, error sending invitations, user_id "
		.elgg_get_logged_in_user_guid()." , emails ".implode("|", $emails), "ERROR");
}

forward(REFERER);
