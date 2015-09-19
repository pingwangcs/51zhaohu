<?php
require_once (dirname(dirname(dirname(__FILE__))) . '/engine/start.php');

//echo "auth";
if (isset($_POST["user"]) && isset($_POST["provider"])) {
	$provider = $_POST["provider"];
	$user =json_decode($_POST["user"]);
	//system_message("User figureurl: " . $user->figureurl);
	//system_message("User id: " . $user->id);
	//system_message("User email: " . $user->email);
	//system_message("User name: " . $user->nickname);
	//echo var_dump($_POST["user"]);
	
	// look for users that have already connected via this plugin
	$options = array(
			'type' => 'user',
			'plugin_id' => 'zhsocial',
			'plugin_user_setting_name_value_pairs' => array(
					"$provider-uid" => $user->id
			),
			'plugin_user_setting_name_value_pairs_operator' => 'AND',
			'limit' => 0
	);
	$zh_users = elgg_get_entities_from_plugin_user_settings($options);
	if ( !$zh_users ) { // user has not connected with plugin before
		if(empty($user->username))
			$new_name = $user->nickname;
		else
			$new_name = $user->username;
		$org_userlogin = preg_replace('/\s+/', '', $new_name);
		$userlogin = $org_userlogin;
		if ( !$org_userlogin ) {
			$org_userlogin = $provider . '_user';
			$userlogin = $org_userlogin. '_' . rand(1000, 9999);
		}		
		while ( get_user_by_username($userlogin) ) {
			$userlogin = $org_userlogin . '_' . rand(1000, 9999);
		}
		
		$password = generate_random_cleartext_password();
		
		$new_user = new ElggUser();
		$new_user->username = $userlogin;
		$new_user->name = $user->nickname;
		if(!empty($user->gender)){
			if(substr($user->gender, 0, 1)=='f' || $user->gender =='女')
				$new_user->gender = 'female';
			else
				$new_user->gender = 'male';
		}
		//$new_user->province = $user->province;
		if(!empty($user->city))
			$new_user->city = $user->city;
		if(!empty($user->email))
			$new_user->email = $user->email;
		$new_user->access_id = ACCESS_PUBLIC;
		$new_user->salt = generate_random_cleartext_password();
		$new_user->password = generate_user_password($new_user, $password);
		$new_user->owner_guid = 0;
		$new_user->container_guid = 0;
		$res = $new_user->save();
		if (!$res ) {	
			register_error(elgg_echo('zhsocial:register:error', array($provider)) . elgg_echo("zhaohu:sorry"));
			elgg_log("ZHError zhsocial:register:error, provider {$provider} , user_id {$user->id} , userlogin {$userlogin}"
			, "ERROR");
			return;
		}
		system_message(elgg_echo('zhsocial:register:ok', array($provider)));		
		elgg_set_plugin_user_setting("$provider-uid", $user->id, $new_user->guid, 'zhsocial');	
		login($new_user);
// 		if($user->figureurl)
//  			zhsocial_apply_icon($new_user, $user->figureurl);
	}
	elseif ( count($zh_users) == 1 ) {
		elgg_set_ignore_access(true);
		login($zh_users[0]);
		elgg_set_ignore_access($ignore_access);
	} else {
		register_error(elgg_echo("zhsocial:login:error", array($provider)). elgg_echo("zhaohu:sorry"));
		elgg_log("ZHError zhsocial:login:error, more than 1 zhaohu user found for provider {$provider} , user_id {$user->id}"
		, "ERROR");
	}	
}
