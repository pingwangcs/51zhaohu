<?php
/**
 * Elgg logout action
 *
 * @package Elgg
 * @subpackage Core
 */

// Log out
$user = get_loggedin_user();

if(logout())
	forward(elgg_get_site_url()."mod/slogin/smfo.php?username=".rawurlencode($user->username));
else {
	register_error(elgg_echo('logouterror'));
	elgg_log("ZHError logout() failed, user_id {$user->guid}", "ERROR");	
} 
