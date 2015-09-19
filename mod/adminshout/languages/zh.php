<?php
	
$chinese = array(
	
	// Generic form
	'adminshout:subject:label' => 'Subject',
	'adminshout:message:label' => 'Your message',

	// Send shout to group members
	'adminshout:group:description' => 'Use the form below to send a message to all members of your group. Note that this may take some time.',
	'adminshout:group' => 'Send group message',

	// Shout to all users
	'adminshout' => 'Send message to all members',
	'adminshout:description' => 'Use the form below to send a message to all members of your site. Note that this may take some time.',
	'adminshout:send' => 'Send message',
	'admin:adminshout' => 'Send site message',
	'admin:adminshout:siteshout' => '',

	// Messages
	'adminshout:success' => 'Successfully sent message to members',
	'adminshout:fail' => 'Could not notify users',
	'adminshout:nogroup' => 'Could not find group!',
	'adminshout:notowner' => 'You do not have access to this!',
	'adminshout:inputs' => 'Please make sure you include a subject and a message before sending!',
);
					
add_translation("zh",$chinese);
?>
