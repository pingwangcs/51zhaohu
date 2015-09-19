<?php

function zhgroups_page_handler($page) {
	$result = false;
	switch ($page[0]) {
		case 'find' :
			include (dirname ( dirname ( __FILE__ ) ) . "/pages/find.php");
			break;
		case 'topic' :
			include (dirname ( dirname ( __FILE__ ) ) . "/pages/topic.php");
			break;
		case "mail" :
			set_input ( "group_guid", $page [1] );
			include (dirname ( dirname ( __FILE__ ) ) . "/pages/mail.php");
			break;
		case "members" :
			set_input ( "group_guid", $page [1] );
			include (dirname ( dirname ( __FILE__ ) ) . "/pages/members.php");
			break;
		case "contact" :
			set_input ( "group_guid", $page [1] );
			include (dirname ( dirname ( __FILE__ ) ) . "/pages/contact.php");
			break;			
		case "invite" :
			set_input ( "group_guid", $page [1] );
			include (dirname ( dirname ( __FILE__ ) ) . "/pages/invite.php");
			break;
		case "notifications" :
			zhgroups_toggle_notifications();
			break;
		case "emUnsub" :
			zhgroupsUnsub();
			break;			
	}
	return $result;
}

// toremove
function zhgroups_site_menu_setup($hook, $type, $return, $params) {

	$group = elgg_get_page_owner_entity();
	
	// Check for valid group
	if (!elgg_instanceof($group, 'group')) {
		return $return;
	}
	foreach ($return as $index => $item) {		
		unset($return[$index]);
	}
// $return['default']
//			$return['more'] = array_splice($return['default'], $max_display_items);
	$return['default'][] = ElggMenuItem::factory(array(
	'name' => 'home',
	'href' => $group->getURL(),
	'text' => elgg_echo('Home'),
	));
	$return['default'][] = ElggMenuItem::factory(array(
	'name' => 'gm',
	'href' => 'zhgroups/members/' . $group->guid,
	'text' => elgg_echo('Group Members'),
	));
	$return['default'][] = ElggMenuItem::factory(array(
	'name' => 'photos',
	'href' => 'photos/group/' . $group->guid .'/all',
	'text' => elgg_echo('Photos'),
	));
	// group members
	if ($group->isMember(elgg_get_logged_in_user_entity())) {
		$return['more'] = zhgroups_register_action_buttons($group);
	} elseif (elgg_is_logged_in()) {
		$url = elgg_get_site_url() . "action/groups/join?group_guid={$group->getGUID()}";
		$url = elgg_add_action_tokens_to_url($url);
		$return['default'][] = ElggMenuItem::factory(array(
				'name' => 'join',
				'href' => $url,
				'text' => elgg_echo('groups:join'),
				'class'=> 'zhaohu-action',
		));
	}
	
	// check if we have anything selected
	$selected = false;
	foreach ($return as $section) {
		foreach ($section as $item) {
			if ($item->getSelected()) {
				$selected = true;
				break 2;
			}
		}
	}

	if (!$selected) {
		// nothing selected, match name to context or match url
		$current_url = current_page_url();
		foreach ($return as $section_name => $section) {
			foreach ($section as $key => $item) {
				// only highlight internal links
				if (strpos($item->getHref(), elgg_get_site_url()) === 0) {
					if ($item->getName() == elgg_get_context()) {
						$return[$section_name][$key]->setSelected(true);
						break 2;
					}
					if ($item->getHref() == $current_url) {
						$return[$section_name][$key]->setSelected(true);
						break 2;
					}
				}
			}
		}
	}

	return $return;
}

// toremove
function zhgroups_register_action_buttons($group) {

	$actions = array();

	// group owners
	if ($group->canEdit()) {
		// new zhaohu
		$url = elgg_get_site_url() . "zhaohus/zhaohu/new/" . $group->getGUID();
		$actions[$url] = 'zhaohu:new';				
		// edit and mail
		$url = elgg_get_site_url() . "groups/edit/{$group->getGUID()}";
		$actions[$url] = 'groups:edit';
		$url = elgg_get_site_url() . "zhgroups/mail/{$group->getGUID()}";
		$actions[$url] = 'zhgroups:mail';
	}

	//contact us
	$url = elgg_get_site_url() . "zhgroups/contact/{$group->getGUID()}";
	$actions[$url] = 'zhgroups:contact';
	
	//notifications
	//todo: notifysite -> notifyemail
	if(check_entity_relationship ( elgg_get_logged_in_user_guid (), 'notifyemail', $group->guid ))
		$rel = 'unsub';
	else
		$rel = 'sub';
	//$url = "action/zhgroups/notifications?guid=" . $group->guid . "&type=" . $rel;
	$url = "zhgroups/notifications?guid=" . $group->guid . "&type=" . $rel;
	$actions[$url] = 'zhgroups:notifications:'.$rel;

	//invite
	$url = elgg_get_site_url() . "zhgroups/invite/{$group->getGUID()}";
	$actions[$url] = 'groups:invite';

	
	if ($group->getOwnerGUID() != elgg_get_logged_in_user_guid()) {
		// leave
		$url = elgg_get_site_url() . "action/groups/leave?group_guid={$group->getGUID()}";
		$url = elgg_add_action_tokens_to_url($url);
		$actions[$url] = 'groups:leave';
	}		

	$result = array();
	if ($actions) {
		foreach ($actions as $url => $text) {
			$result[] = ElggMenuItem::factory(array(
			'name' => $text,
			'href' => $url,
			'text' => elgg_echo($text)));
		}
	}
	return $result;
}

/**
 * Modify the title menu in the groups context.
 *
 * @param string $hook         the 'register' hook
 * @param string $type         for the 'menu:title' menu
 * @param array  $return_value the menu items to show
 * @param arary  $params       params to help extend the menu items
 *
 * @return ElggMenuItem[] a list of menu items
 */
function zhgroups_menu_title_handler($hook, $type, $return_value, $params) {
	$result = $return_value;

	$page_owner = elgg_get_page_owner_entity();
	$user = elgg_get_logged_in_user_entity();

	if (!empty($result) && is_array($result)) {
		if (elgg_in_context("groups")) {
			// modify some group menu items
			if (!empty($page_owner) && !empty($user) && ($page_owner instanceof ElggGroup)) {
				$invite_found = false;

				foreach ($result as $menu_item) {
						
					switch ($menu_item->getName()) {
						case "groups:joinrequest":
							if (check_entity_relationship($user->getGUID(), "membership_request", $page_owner->getGUID())) {
								// user already requested to join this group
								$menu_item->setText(elgg_echo("zhgroups:joinrequest:already"));
								$menu_item->setTooltip(elgg_echo("zhgroups:joinrequest:already:tooltip"));
								$menu_item->setHref(elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/groups/killrequest?user_guid=" . $user->getGUID() . "&group_guid=" . $page_owner->getGUID()));
							} elseif (check_entity_relationship($page_owner->getGUID(), "invited", $user->getGUID())) {
								// the user was invited, so let him/her join
								$menu_item->setName("groups:join");
								$menu_item->setText(elgg_echo("groups:join"));
								$menu_item->setTooltip(elgg_echo("zhgroups:join:already:tooltip"));
								$menu_item->setHref(elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/groups/join?user_guid=" . $user->getGUID() . "&group_guid=" . $page_owner->getGUID()));
							}								
							break;
						case "groups:invite":
							//$invite_found = true;
							unset($menu_item);
							break;
					}
				}

				// maybe allow normal users to invite new members
				//if (elgg_in_context("group_profile") && !$invite_found) {
					// this is only allowed for group members
					if ($page_owner->isMember($user)) {
						// normal users are allowed to invite users
						$text = elgg_echo("groups:invite");
						
						$result[] = ElggMenuItem::factory(array(
								"name" => "groups:invite",
								"href" => "zhgroups/invite/" . $page_owner->getGUID(),
								"text" => $text,
								"link_class" => "elgg-button elgg-button-action",
						));
					}
				//}
			}
				

		}
	}

	return $result;
}

function zh_profile_fields_setup() {
	global $CONFIG;

	$profile_defaults = array (
			'description' => 'longtext',
			'gender' => 'dropdown',
			'interests' => 'tags',
			'birthYear' => 'dropdown',
			'birthMonth' => 'dropdown',
			'birthDay' => 'dropdown',
			'country' => 'dropdown',
			'state' => 'dropdown',
			'city' => 'text',
			'address' => 'text',
			'zip' => 'text',
			'contactemail' => 'email',
			'phone' => 'text',
			'website' => 'url',
			'QQ' => 'text',
	);

	$CONFIG->profile_fields = elgg_trigger_plugin_hook('profile:fields', 'profile', NULL, $profile_defaults);

	// register any tag metadata names
	foreach ($CONFIG->profile_fields as $name => $type) {
		if ($type == 'tags' || $type == 'location' || $type == 'tag') {
			elgg_register_tag_metadata_name($name);
			// register a tag name translation
			add_translation(get_current_language(), array("tag_names:$name" => elgg_echo("profile:$name")));
		}
	}
}