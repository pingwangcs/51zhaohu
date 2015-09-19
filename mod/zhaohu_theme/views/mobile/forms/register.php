<?php
/**
 * Elgg register form
 *
 * @package Elgg
 * @subpackage Core
 */

$password = $password2 = '';
$username = get_input('u');
$email = get_input('e');
$name = get_input('n');

if (elgg_is_sticky_form('register')) {
	extract(elgg_get_sticky_values('register'));
	elgg_clear_sticky_form('register');
}

?>

<div>
	<label><?php echo elgg_echo('email'); ?></label><br />
	<?php
	echo elgg_view('input/text', array(
		'name' => 'email',
		'id' => 'email',
		'value' => $email,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('username'); ?></label><br />
	<?php
	echo elgg_view('input/text', array(
		'name' => 'username',
		'value' => $username,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('password'); ?></label><br />
	<?php
	echo elgg_view('input/password', array(
		'name' => 'password',
		'id' => 'password',
		'value' => $password,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('passwordagain'); ?></label><br />
	<?php
	echo elgg_view('input/password', array(
		'name' => 'password2',
		'id' => 'password2',
		'value' => $password2,
	));
	?>
</div>
<div>
	<?php
	echo elgg_view('input/checkbox', array(
		'name' => 'agreement',
		'id' => 'agreement_checkbox',
		'onclick' => 'enableSubmit(this);',
	));
	?>
	<label>
	<?php
	
	$service_term = elgg_view("output/url",
							  array("href" => "zhaohu_about/service_terms",
							        "text" => elgg_echo('zhaohu:service_terms'),
									"class" => "zhaohu-register-terms-link",));
	$privacy_term = elgg_view("output/url",
							  array("href" => "zhaohu_about/privacy_terms",
									"text" => elgg_echo('zhaohu:privacy_terms'),
									"class" => "zhaohu-register-terms-link"));
	
	echo elgg_echo('zhaohu:agree_with_terms', array($service_term, $privacy_term));
	?>
	</label>
</div>
<?php
// view to extend to add more fields to the registration form
echo elgg_view('register/extend', $vars);

// Add captcha hook
echo elgg_view('input/captcha', $vars);

echo '<div class="elgg-foot">';
echo elgg_view('input/hidden', array('name' => 'friend_guid', 'value' => $vars['friend_guid']));
echo elgg_view('input/hidden', array('name' => 'invitecode', 'value' => $vars['invitecode']));
echo elgg_view('input/submit', array('name' => 'submit', 'id'=> 'register', 'value' => elgg_echo('register')));
echo '</div>';
