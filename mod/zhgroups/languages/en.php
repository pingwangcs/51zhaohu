<?php
/**
 * zhaohu Index English language file
*/

$english = array(		
		'user:username' => 'My user name',
		'profile:view' => 'My info',
		'profile:home_mobile' => '<---',
		'profile:address' => 'Street Address',
		'profile:state' => 'State',//must have
		'profile:city' => 'City/Town',//must have
		'profile:zip' => 'ZIP',
		'profile:country' => 'Country',
		'profile:gender' => 'Gender',
		'profile:female' => 'Female',
		'profile:male' => 'Male',
		'profile:birthdate' => 'Birthdate',
		'profile:birthYear' => 'Birth Year',
		'profile:birthMonth' => 'Birth Month',
		'profile:birthDay' => 'Birth Day',
		'profile:QQ' => 'QQ',
		'profile:edit:fail' => 'Could not edit your profile.',
		'profile:zip:err' => 'The zip code seems not valid. Please check and try again?',
		'zhgroups:memberof' => 'Member of %s groups',
		//
		'zhgroups:whatsnew' => "What's new",
		'groups:country' => 'Country',//must have
		'groups:state' => 'State',//must have
		'groups:city' => 'City/Town',//must have
		'groups:tagstoolong' => 'Interests are too long',
		'groups:desptoolong' => 'Description is too long',
		'groups:citytoolong' => 'City is too long',
		'groups:nametoolong' => 'Name is too long',
		//
		'zhgroups:add_users' => "Add users",
		'zhgroups:mail' => "Mail Members",
		'zhgroups:removeuser' => "Remove member",
		'zhgroups:email' => "Email",
		'zhgroups:nearby' => "Other groups nearby",
		'zhgroup:home' => 'Home',
		'zhgroup:photos' => 'Photos',
		'zhgroups:invite' => 'Invite friends',		
		//
		'zhgroups:admin' => 'Admin',
		'zhgroups:admins' => 'Admins',
		'zhgroups:contact:title' => 'Contact us by email',
		'zhgroups:contact' => 'Contact us',
		'zhgroups:admin:none' => 'None',
		//
		'zhgroups:clear_selection' => 'Clear selection',
		'zhgroups:all_members' => 'All members',
		'zhgroups:notmember' => "Sorry that you need to be a group member to perform the operation",
		'zhgroups:toggleadmin:owner' => "Sorry that you are already group owner, so could not become an admin",
		//notifications
		'zhgroups:notifications:sub' => 'Turn on notifications',
		'zhgroups:notifications:unsub' => 'Turn off notifications',
		'zhgroups:notifications:msg:sub' => 'You subscribed to group notification emails',
		'zhgroups:notifications:msg:unsub' => 'You unsubscribed to group notification emails',
		'zhgroups:notifications:sub:error' => 'Could not subscribe to group notification emails,',
		'zhgroups:notifications:unsub:error' => 'Could not unsubscribe to group notification emails,',
		'zhgroups:emunsub:error' => 'Could not turn off the group notifications.',
		// group admins
		//'zhgroups:multiple_admin:group_admins' => "Group admins",
		'zhgroups:multiple_admin:remove' => "Remove group admin",
		'zhgroups:multiple_admin:add' => "Add group admin",
		// group admins - action
		'zhgroups:action:toggle_admin:success:remove' => "Successfully removed  %s as group admin",
		'zhgroups:action:toggle_admin:success:add' => "Successfully added %s as group admin",
		'river:zhgroups:admin:add' => '%s is promoted as admin of %s',
		'zhgroups:image:format:error' => 'Sorry that the file format is not supported',
		// group mail
		'zhgroups:mail:to' => "To",
		'zhgroups:mail:message:from' => "From group",
		
		'zhgroups:mail:title' => "Send a mail to the group members",
		'zhgroups:mail:form:recipients' => "Number of recipients",
		'zhgroups:mail:form:members:selection' => "Select individual members",
		
		'zhgroups:mail:form:subject' => "Subject",
		'zhgroups:mail:form:body' => "Body",
		
		'zhgroups:mail:form:js:members' => "Please select at least one member to send the message to",
		'zhgroups:mail:form:js:description' => "Please enter a message",
		//Unsubscribe
		'zhgroups:mail:unsub1' => "Unsubscribe",
		'zhgroups:mail:unsub2' => "from similar emails from this Zhaohu Group",
		'51zhaohu:address' => "51zhaohu, Bellevue, WA USA",
		// group mail - action
		'zhgroups:action:mail:success' => "Succesfully sent your message",
		
		// actions
		'zhgroups:action:error:entity' => "The given GUID didn't result in a correct entity",
		'zhaohu:emails:empty' => "Please input one or more emails",
		'zhgroups:mail:subject:empty' => "Please input the email subject",
		'zhgroups:mail:body:empty' => "Please input the email body",
		'zhgroups:markfeatured' => "make this a featured group",
		'zhgroups:unmarkfeatured' => "make this a unfeatured group",
		'zhaohu:hi' => "Hi %s,",
		'zhgroups:join:subject' => "%s has joined %s",
		'zhgroups:join:body' => "Hi %s,

		<a href='%s'>%s</a> has joined the group <a href='%s'>%s</a>.
		<a href='%s'>Click</a> to view the profile of %s.",
		'zhgroups:add:admin:subject' => "You are now the admin of %s",
		'zhgroups:add:admin:body' => "Hi %s,
		Congratulations!
		
		<a href='%s'>%s</a> has promoted you to be the administrator of <a href='%s'>%s</a>.
		<a href='%s'>Click</a> to view the profile of %s.",
		'zhgroups:rm:admin:subject' => "You are no longer the admin of %s",
		'zhgroups:rm:admin:body' => "Hi %s,
		
		Sorr that <a href='%s'>%s</a>revoked the administrator privilege of <a href='%s'>%s</a> from you.
		Thank you a lot for taking care of <a href='%s'>%s</a>!
		We bet that you would enjoy the group more than before as you are now free from the duties~",
		'zhgroups:transfer:onwer:subject' => "You are now the owner of %s",
		'zhgroups:transfer:onwer:body' => "Hi %s,
		Congratulations!

		<a href='%s'>%s</a> has transferred the onwership of the group <a href='%s'>%s</a> to you.
		<a href='%s'>Click</a> to view the profile of %s.",
		// group invite message
		'zhgroups:groups:invite:body' => "Hi %s,
		
%s invited you to join the '%s' group.
%s
		
Click below to view your invitations:
%s",	
		// group add message
		'zhgroups:groups:invite:add:subject' => "You've been added to the group %s",
		'zhgroups:groups:invite:add:body' => "Hi %s,
		
%s added you to the group %s.
%s
		
To view the group click on this link
%s",
		//invite
		'zhgroups:group:invite:add:confirm' => "Are you sure you want to add these users directly?",
		//
		'zhgroups:unsub:site' => "To change your site wide notification settings, please go to your profile page and click on Edit Settings to to unsubscribe.",
		'zh:learn:more' => 'Learn more',
		'can' => 'Canada',
		'usa' => 'United States',
);
		
add_translation('en', $english);		