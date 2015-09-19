<?php
require_once dirname(__FILE__).'/vendors/smf/auth.php';
require_once dirname(__FILE__).'/vendors/smf/SmfRestClient.php';

define("KEY_PRIVATE", 'file://'.elgg_get_plugins_path() . 'slogin/pk');
define("KEY_PASSPHRASE", "J03yHon9'");
define("SMF_SEC_KEY", "48f3c0wFbg7ni+=8");

elgg_register_event_handler('init', 'system', 'slogin_init');

function slogin_init() {    
    elgg_register_js("slogin.jsbn", elgg_get_site_url() . "mod/slogin/vendors/javascript-rsa/jsbn.js");
    elgg_register_js("slogin.rsa", elgg_get_site_url() . "mod/slogin/vendors/javascript-rsa/rsa.js");

    elgg_extend_view('forms/login', 'slogin/slogin', 501);
    elgg_extend_view('forms/register', 'slogin/sregister', 501);
    
    elgg_register_action('login',
    dirname(__FILE__) . '/actions/slogin/login.php', 'public');
    elgg_register_action('register',
    dirname(__FILE__) . '/actions/slogin/register.php', 'public');
    elgg_register_action('logout',
    dirname(__FILE__) . '/actions/slogin/logout.php', 'public');
}

function smf_ifOnline($username){
	$api = new SmfRestClient(simple_auth(SMF_SEC_KEY, 'ENCODE'));	
	$result = $api->check_ifOnline($username);	
	return $result->data == 'true';
}

function smf_register($user, $password){
	$api = new SmfRestClient(simple_auth(SMF_SEC_KEY, 'ENCODE'));
	$find = $api->get_user($user->username);
	if($find->data!='false')
		return;

	$code = simple_auth($password, 'ENCODE');
	$regOptions = array("member_name"=>"{$user->username}",
	"real_name"=>"{$user->name}",
	"email"=>"{$user->email}",
	"password"=>"{$code}",
	"require"=>"nothing");
	// if use api call directly
	//$mem_id = smfapi_registerMember ( $regOptions );
	$mem_id = $api->register_member( $regOptions );

	if (!$mem_id)
		elgg_log("ZHError smf_register failed, user_id {$user->guid}", "ERROR");
	return $mem_id;
}

function smf_setUserPassword($username, $password)
{
	$api = new SmfRestClient(simple_auth(SMF_SEC_KEY, 'ENCODE'));

	$passwd=sha1(strtolower($username) . $password);
	$result = $api->update_memberData($username, array('passwd' => $passwd));
	return $result->data == 'true';
}

function smf_updateMemberData($username, $info)
{
	$api = new SmfRestClient(simple_auth(SMF_SEC_KEY, 'ENCODE'));
	$result = $api->update_memberData($username, $info);
	return $result->data == 'true';
}

