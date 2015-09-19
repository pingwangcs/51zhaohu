<?php
/**
 * Elgg registration action
 *
 * @package Elgg.Core
 * @subpackage User.Account
 */
elgg_make_sticky_form('register');

// Get variables
$username = get_input('username');
$password = get_input('password', null, false);
$password2 = get_input('password2', null, false);
$email = get_input('email');
$name = $username;
$friend_guid = (int) get_input('friend_guid', 0);
$invitecode = get_input('invitecode');

if(empty($username)){
	register_error(elgg_echo('slogin:username:empty'));
	forward(REFERER);
}
// if(empty($name)){
// 	register_error(elgg_echo('slogin:name:empty'));
// 	forward(REFERER);
// }
if(empty($password)){
	register_error(elgg_echo('slogin:password:empty'));
	forward(REFERER);
}
if(empty($password2)){
	register_error(elgg_echo('slogin:password2:empty'));
	forward(REFERER);
}

$password = base64_decode($password);
$password2 = base64_decode($password2);
$private_key = openssl_pkey_get_private(KEY_PRIVATE, KEY_PASSPHRASE);
//fordebug register_error("res ".$private_key);
if(!openssl_private_decrypt($password, $password, $private_key)) {
	register_error(elgg_echo('zhaohu:wrong'). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError , register, failed to decrypt password,  user_name {$username} , email {$email}"
	, "ERROR");
	forward(REFERER);
}
if(!openssl_private_decrypt($password2, $password2, $private_key)) {
	register_error(elgg_echo('zhaohu:wrong'). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError , register, failed to decrypt password2,  user_name {$username} , email {$email}"
	, "ERROR");
	forward(REFERER);
}

if (elgg_get_config('allow_registration')) {
	try {
		if (trim($password) == "" || trim($password2) == "") {
			throw new RegistrationException(elgg_echo('RegistrationException:EmptyPassword'));
		}

		if (strcmp($password, $password2) != 0) {
			throw new RegistrationException(elgg_echo('RegistrationException:PasswordMismatch'));
		}

		$guid = register_user($username, $password, $name, $email, false, $friend_guid, $invitecode);

		if ($guid) {
			$new_user = get_entity($guid);

			// allow plugins to respond to self registration
			// note: To catch all new users, even those created by an admin,
			// register for the create, user event instead.
			// only passing vars that aren't in ElggUser.
			$params = array(
				'user' => $new_user,
				'password' => $password,
				'friend_guid' => $friend_guid,
				'invitecode' => $invitecode
			);

			// @todo should registration be allowed no matter what the plugins return?
			if (!elgg_trigger_plugin_hook('register', 'user', $params, TRUE)) {
				$ia = elgg_set_ignore_access(true);
				$new_user->delete();
				elgg_set_ignore_access($ia);
				// @todo this is a generic messages. We could have plugins
				// throw a RegistrationException, but that is very odd
				// for the plugin hooks system.
				throw new RegistrationException(elgg_echo('registerbad'));
			}

			elgg_clear_sticky_form('register');
			system_message(elgg_echo("registerok", array(elgg_get_site_entity()->name)));

			smf_register($new_user, $password);
			
			// if exception thrown, this probably means there is a validation
			// plugin that has disabled the user
			try {
				login($new_user);
			} catch (LoginException $e) {
				// do nothing
			}

			// Forward on success, assume everything else is an error...
			forward();
		} else {
			register_error(elgg_echo("registerbad") . elgg_echo("zhaohu:sorry"));
			elgg_log("ZHError , registerbad, did not get valide guid, user_name {$username} , email {$email}"
			, "ERROR");
		}
	} catch (RegistrationException $r) {
		register_error(elgg_echo($r->getMessage()));
		elgg_log("ZHError , RegistrationException,  user_name {$username} , email {$email} ,Message "
			.$r->getMessage() , "ERROR");
	}
} else {
	register_error(elgg_echo('registerdisabled'));
}

forward(REFERER);
