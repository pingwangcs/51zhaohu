<?php
$user = $vars['entity'];
$group_guid = elgg_get_page_owner_guid();
$group = get_entity($group_guid);
$loggedin_user = elgg_get_logged_in_user_entity();
$context = elgg_get_context();
if ( $context == 'zhg_contact' || $context == 'cp_event') {
	echo $user->email;
}
else if ( $context == 'zhg_members' && !empty($group) && $group->canEdit()) {
	echo elgg_view('output/url', array(
			'href' => "zhgroups/mail/{$group_guid}?memberId={$user->guid}",
			'text' => elgg_echo('zhgroups:email'),
			'class' => 'elgg-button-action',
	));
	
	if($group->getOwnerGUID() != $user->guid) {		
		if (($group->getOwnerGUID() == $loggedin_user->guid) || $loggedin_user->isAdmin()) {
			if (check_entity_relationship($user->guid, "group_admin", $group_guid)) {
				$text = elgg_echo("zhgroups:multiple_admin:remove");
			} else {
				$text = elgg_echo("zhgroups:multiple_admin:add");
			}
		
			echo elgg_view('output/url', array(
					"href" => elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/zhgroups/toggle_admin?group_guid={$group_guid}&user_guid={$user->guid}"),
					'text' => $text,
					'class' => 'elgg-button-action',
			));
		}
		
		echo elgg_view('output/confirmlink', array(
				'href' => "action/groups/remove?user_guid={$user->guid}&group_guid={$group_guid}",
				'text' => elgg_echo('zhgroups:removeuser'),
				'class' => 'elgg-button-action',
		));
	}	
}
else {
	echo '';
}