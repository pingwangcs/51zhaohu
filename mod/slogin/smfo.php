<?php
require_once dirname(__FILE__).'/vendors/smf/smf_2_api.php';

if((isset($_REQUEST["username"]))){
	$username =rawurldecode($_REQUEST["username"]);
	$outed = true;
	// for debug
	// $isonline=smfapi_isOnline($username)?'T':'F';
	if(smfapi_isOnline($username))
		$outed = smfapi_logout($username);
	if(!$outed)
		echo "<script type='text/javascript'>alert('Sorry! Failed to logout zhaohu forum! Please click logout at zhaohu forum.')</script>";
}
header("Location: http://{$_SERVER['HTTP_HOST']}");
?>