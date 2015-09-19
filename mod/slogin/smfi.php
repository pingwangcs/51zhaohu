<?php
require_once dirname(__FILE__).'/vendors/smf/smf_2_api.php';
require_once dirname(__FILE__).'/vendors/smf/auth.php';
define("SMF_COOKIE_LEN", 4320); // 3 days

if((isset($_REQUEST["username"]))){
	$username =rawurldecode($_REQUEST["username"]);
	$in = smfapi_login($username, SMF_COOKIE_LEN);
	if(!$in)
		echo "<script type='text/javascript'>alert('Sorry! Failed to login to zhaohu forum! Please contact us and we would like to fix this for you!')</script>";
}
header("Location: {$_SERVER['HTTP_REFERER']}");

