<?php
/**
 * Elgg login action
 *
 * @package Elgg.Core
 * @subpackage User.Authentication
 */

// set forward url
if (!empty($_SESSION['last_forward_from'])) {
	$forward_url = $_SESSION['last_forward_from'];
} elseif (get_input('returntoreferer')) {
	$forward_url = REFERER;
} else {
	// forward to main index page
	$forward_url = '';
}

$username = get_input('username');
$password = get_input('password', null, false);
$password = base64_decode($password);
$private_key = openssl_pkey_get_private(KEY_PRIVATE, KEY_PASSPHRASE);
//fordebug register_error("res ".$private_key);
if(!openssl_private_decrypt($password, $password, $private_key)) {
	register_error(elgg_echo('zhaohu:wrong'). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError login:failed, failed to decrypt message,  user_name {$username}"
	, "ERROR");
	forward(REFERER);
}
//fordebug
//system_message($password);

$persistent = (bool) get_input("persistent");
$result = false;

if (empty($username) || empty($password)) {
	register_error(elgg_echo('login:empty'));
	forward();
}

// check if logging in with email address
if (strpos($username, '@') !== false && ($users = get_user_by_email($username))) {
	$username = $users[0]->username;
}

$result = elgg_authenticate($username, $password);
if ($result !== true) {
	register_error($result);
	forward(REFERER);
}

$user = get_user_by_username($username);
if (!$user) {
	register_error(elgg_echo('login:baduser'));
	forward(REFERER);
}

try {
	login($user, $persistent);
	smf_register($user, $password);
	forward(elgg_get_site_url()."mod/slogin/smfi.php?username=".rawurlencode($user->username));

	// re-register at least the core language file for users with language other than site default
	register_translations(dirname(dirname(__FILE__)) . "/languages/");
} catch (LoginException $e) {
	register_error(elgg_echo('zhaohu:wrong'). elgg_echo("zhaohu:sorry"));
	elgg_log("ZHError LoginException, user_name {$username}, LoginException message "
		.$e->getMessage(), "ERROR");
	forward(REFERER);
}

// elgg_echo() caches the language and does not provide a way to change the language.
// @todo we need to use the config object to store this so that the current language
// can be changed. Refs #4171
if ($user->language) {
	$message = elgg_echo('loginok', array(), $user->language);
} else {
	$message = elgg_echo('loginok');
}

if (isset($_SESSION['last_forward_from'])) {
	unset($_SESSION['last_forward_from']);
}

system_message($message);
forward($forward_url);
