<?php
define("ZHAOHU_GROUPS_MEMBER_LIMIT", 20);
define("ZHAOHU_GROUPS_ACTIVITY_LIMIT", 10);
define("ZHGROUPS_IN_PROFILE_LIMIT", 10);

require_once(dirname(__FILE__) . "/lib/functions.php");
require_once(dirname(__FILE__) . "/lib/hooks.php");

elgg_register_event_handler("init", "system", "zhgroups_init");
elgg_unregister_event_handler('init', 'system', 'groups_fields_setup');
elgg_register_event_handler('init', 'system', 'zhgroups_fields_setup', 10000);
elgg_unregister_event_handler('init', 'system', 'elgg_profile_fields_setup', 10000);
elgg_register_event_handler('init', 'system', 'zh_profile_fields_setup', 10000); // Ensure this runs after other plugins
function zhgroups_init() {
	zhdd_setup();
	elgg_register_plugin_hook_handler('register', 'menu:river', 'zhgroups_river_menu_setup');
	elgg_register_plugin_hook_handler("register", "menu:title", "zhgroups_menu_title_handler");

	elgg_register_plugin_hook_handler("permissions_check", "group", "zhgroups_multiple_admin_can_edit_hook");
	elgg_register_event_handler("leave", "group", "zhgroups_multiple_admin_group_leave");
	
	elgg_unregister_plugin_hook_handler('register', 'menu:entity', 'groups_entity_menu_setup');
	elgg_unregister_plugin_hook_handler('register', 'menu:owner_block', 'groups_activity_owner_block_menu');
	elgg_unregister_plugin_hook_handler('register', 'menu:owner_block', 'discussion_owner_block_menu');
	elgg_register_plugin_hook_handler('prepare', 'menu:site', 'zhgroups_site_menu_setup');
	
	elgg_extend_view("groups/sidebar/my_status", "zhgroups/activity");
	elgg_extend_view("user/elements/summary", "zhgroups/memberops");
	
	elgg_extend_view("css/elgg", "css/zhgroups/group_tools");
	elgg_extend_view("css/elgg", "css/zhgroups/site");
	
	elgg_register_page_handler('zhgroups', 'zhgroups_page_handler');
	setIconSize();
	
	elgg_register_action("zhgroups/mail", dirname(__FILE__) . "/actions/mail.php");
	elgg_register_action("zhgroups/invite", dirname(__FILE__) . "/actions/invite.php");
	elgg_register_action("zhgroups/toggle_admin", dirname(__FILE__) . "/actions/toggle_admin.php");
	elgg_register_action("zhgroups/notifications", dirname(__FILE__) . "/actions/notifications.php");
	//js
	//elgg_extend_view("js/elgg", "js/zhgroups/site");
	elgg_register_simplecache_view("js/zhgroups/invite");
	$zhg_invite = elgg_get_simplecache_url("js", "zhgroups/invite");
	elgg_register_js("zhgroups.invite", $zhg_invite, 'footer');
	
	elgg_register_simplecache_view("js/zhgroups/mail");
	$zhg_mail = elgg_get_simplecache_url("js", "zhgroups/mail");
	elgg_register_js("zhgroups.mail", $zhg_mail, 'footer');
	
	elgg_register_simplecache_view("js/zhgroups/edit");
	$zhg_edit = elgg_get_simplecache_url("js", "zhgroups/edit");
	elgg_register_js("zhgroups.edit", $zhg_edit, 'footer');
	
	elgg_register_simplecache_view("js/profile/edit");
	$zhp_edit = elgg_get_simplecache_url("js", "profile/edit");
	elgg_register_js("zhp.edit", $zhp_edit);
	
	elgg_register_simplecache_view("js/location");
	$zhp_edit = elgg_get_simplecache_url("js", "location");
	elgg_register_js("location", $zhp_edit);
	
}

function zhgroups_river_menu_setup($hook, $type, $return, $params) {
	$return = array();
	return $return;
}

function zhdd_setup() {
	$zh_tags = array('AllInterests', 'Friends', 'Holiday', 'Christmas', 'Charity', 'Culturals', 'Comics', 'Dancing', 'Drawing', 'Families', 'Fashion', 'Fitness',
	'Foodie', 'Games',  'Geek', 'Green', 'Healthy', 'Innovation', 'Investing', 'Literature', 'Movie', 
	'Music', 'Outdoor', 'Parenting', 'Pets', 'Photography', 'Rent', 'Singles', 
	'Theater', 'Travel', 'Tutoring', 'Sculpture', 'Students', 'Weight Loss', 'Wine Tasting', 'Young Professional');

	elgg_set_config('zhtags', $zh_tags);
	
	$zh_states = array('All', 'CA', 'NY', 'WA');
	elgg_set_config('zhstates', $zh_states);
}

function zhgroups_fields_setup() {
	$profile_defaults = array(
			'description' => 'longtext',
			//'briefdescription' => 'text',
			'interests' => 'tags',
			'country' => 'dropdown',
			'state' => 'dropdown',
			'city' => 'text',
			//'website' => 'url',
	);

	$profile_defaults = elgg_trigger_plugin_hook('profile:fields', 'group', NULL, $profile_defaults);

	elgg_set_config('group', $profile_defaults);

	// register any tag metadata names
	foreach ($profile_defaults as $name => $type) {
		if ($type == 'tags') {
			elgg_register_tag_metadata_name($name);

			// only shows up in search but why not just set this in en.php as doing it here
			// means you cannot override it in a plugin
			add_translation(get_current_language(), array("tag_names:$name" => elgg_echo("groups:$name")));
		}
	}
}

function setGroupToolOptions() {
	$tool_options = elgg_get_config('group_tool_options');
	if ($tool_options) {
		foreach ($tool_options as $group_option) {		
			//fordebug system_message('name ' . $group_option->name);
			if($group_option->name == 'related_groups')
				$group_option->default_on = 'yes';
		}
	}
	elgg_set_config('group_tool_options', $tool_options);
}

function setIconSize() {
	$icon_sizes = array(
			'topbar' => array('w' => 16, 'h' => 16, 'square' => TRUE, 'upscale' => TRUE),
			'tiny' => array('w' => 25, 'h' => 25, 'square' => TRUE, 'upscale' => TRUE),
			'small' => array('w' => 40, 'h' => 40, 'square' => TRUE, 'upscale' => TRUE),
			'medium' => array('w' => 100, 'h' => 100, 'square' => TRUE, 'upscale' => TRUE),
			'large' => array('w' => 200, 'h' => 200, 'square' => TRUE, 'upscale' => FALSE),
			'master' => array('w' => 550, 'h' => 550, 'square' => FALSE, 'upscale' => FALSE),
	);
	elgg_set_config('icon_sizes', $icon_sizes);
}
?>