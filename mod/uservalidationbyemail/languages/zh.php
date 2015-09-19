<?php
/**
 * Email user validation plugin language pack.
 *
 * @package Elgg.Core.Plugin
 * @subpackage ElggUserValidationByEmail
 */

$chinese = array(
	'admin:users:unvalidated' => 'Unvalidated',
	
	'email:validate:subject' => "%s客官, %s请您验证邮件地址",
	'email:validate:body' => "%s客官,

51招呼在这儿期待您已久了。来51招呼，招呼您的小伙伴吧。
请客官验证邮件地址，精彩只有一步之遥哦～
请点击以下链接进行验证:
%s
如果客官无法点击链接, 请复制粘帖此链接到浏览器。
验证成功之后，客官可以去您的<a href='%s'>个人主页</a>完善资料，好让更多的人仰慕玉树凌风的您。
",
	'email:confirm:success' => "成功验证了客官您的邮件地址",
	'email:confirm:fail' => "抱歉无法验证客官您的邮件地址.",

	'uservalidationbyemail:registerok' => "请点击我们发送给客官的链接验证您的邮件地址，激活客官的账号",
	'uservalidationbyemail:login:fail' => "登录失败，因为客官的帐号还没有通过验证. 我们给客官重新发送了一封验证邮件.",

	'uservalidationbyemail:admin:no_unvalidated_users' => 'No unvalidated users.',

	'uservalidationbyemail:admin:unvalidated' => 'Unvalidated',
	'uservalidationbyemail:admin:user_created' => 'Registered %s',
	'uservalidationbyemail:admin:resend_validation' => 'Resend validation',
	'uservalidationbyemail:admin:validate' => 'Validate',
	'uservalidationbyemail:admin:delete' => 'Delete',
	'uservalidationbyemail:confirm_validate_user' => 'Validate %s?',
	'uservalidationbyemail:confirm_resend_validation' => 'Resend validation email to %s?',
	'uservalidationbyemail:confirm_delete' => 'Delete %s?',
	'uservalidationbyemail:confirm_validate_checked' => 'Validate checked users?',
	'uservalidationbyemail:confirm_resend_validation_checked' => 'Resend validation to checked users?',
	'uservalidationbyemail:confirm_delete_checked' => 'Delete checked users?',
	'uservalidationbyemail:check_all' => 'All',

	'uservalidationbyemail:errors:unknown_users' => 'Unknown users',
	'uservalidationbyemail:errors:could_not_validate_user' => 'Could not validate user.',
	'uservalidationbyemail:errors:could_not_validate_users' => 'Could not validate all checked users.',
	'uservalidationbyemail:errors:could_not_delete_user' => 'Could not delete user.',
	'uservalidationbyemail:errors:could_not_delete_users' => 'Could not delete all checked users.',
	'uservalidationbyemail:errors:could_not_resend_validation' => 'Could not resend validation request.',
	'uservalidationbyemail:errors:could_not_resend_validations' => 'Could not resend all validation requests to checked users.',

	'uservalidationbyemail:messages:validated_user' => 'User validated.',
	'uservalidationbyemail:messages:validated_users' => 'All checked users validated.',
	'uservalidationbyemail:messages:deleted_user' => 'User deleted.',
	'uservalidationbyemail:messages:deleted_users' => 'All checked users deleted.',
	'uservalidationbyemail:messages:resent_validation' => 'Validation request resent.',
	'uservalidationbyemail:messages:resent_validations' => 'Validation requests resent to all checked users.'

);

add_translation("zh", $chinese);