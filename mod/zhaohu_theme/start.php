<?php
/*
 * zhaohu theme, including mobile theme
 */
elgg_register_event_handler('init', 'system', 'zhaohu_theme_init');
elgg_unregister_event_handler('pagesetup', 'system', 'users_pagesetup');
//rm unused user setting menus
elgg_unregister_event_handler('pagesetup', 'system', 'usersettings_pagesetup');

function zhaohu_theme_init() {
	// check mobile view
	check_mobile_mode();
	// include css files of this mod
	elgg_extend_view('css/elgg', 'zhaohu_theme/css');
	elgg_register_css('elgg.mobile', '/css/mobile.css');
	elgg_register_css('elgg.mobilize', '/css/mobilize.css');
	
	elgg_register_action("zhaohu/switch_view",
	dirname(__FILE__) . "/actions/zhaohu/switch_view.php", "public");
	
	if(elgg_get_viewtype() == "mobile"){
		zhaohu_mobile_theme_init();
	}
	else{
		// TODO: this needs to be changed to zhaohu_desktop_theme_init() after development is done.
// 		zhaohu_mobile_theme_init();
// 		elgg_set_viewtype('mobile');
//      Real code
		zhaohu_desktop_theme_init();
		elgg_set_viewtype('default');
	}
}


function zhaohu_desktop_theme_init() {

	// Register topbar and footer links
	elgg_register_event_handler('pagesetup', 'system', 'prepare_zhaohu_topbar_footer');

	// need to register index handler
	elgg_register_plugin_hook_handler('index', 'system', 'zhaohu_index_page_handler');

	// Register handler for "about" links, such as about_us, service_terms, etc.
	elgg_register_page_handler('zhaohu_about', 'zhaohu_about_pages_handler');

	// add Settings link to owner block
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'zhaohu_user_hover_menu');
}

function zhaohu_mobile_theme_init() {
	if (!elgg_in_context('admin')) {
		elgg_load_css('elgg.mobile');
		elgg_load_css('elgg.mobilize');
	}
	// need to register index handler
	elgg_register_plugin_hook_handler('index', 'system', 'zhaohu_index_page_handler');
	// add Settings link to owner block
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'zhaohu_user_hover_menu');
	
	elgg_register_event_handler('pagesetup', 'system', 'prepare_zhaohu_footer');
	elgg_register_page_handler('zhaohu_about', 'zhaohu_about_pages_handler');
}

function zhaohu_index_page_handler(){
	$url = elgg_get_site_url().'zhgroups/find?tag='.rawurlencode(elgg_echo("AllInterests")).'&showType=zhaohus&state=WA&city=Seattle';
	forward($url);
}

function zhaohu_about_pages_handler($page, $identifier){
	$plugin_path = elgg_get_plugins_path();
	$base_path = $plugin_path . 'zhaohu_theme/pages';
	
	//TODO: Need to handle page not found fatal error
	if($page[0]=='feedbacks'){
		forward(elgg_get_site_url().'mod/contactform/');
	}
	else
		require "$base_path/zhaohu_about/$page[0].php";	
	return true;
}

function prepare_zhaohu_topbar_footer(){
	unregister_default_topbar_menu_items();
	unregister_default_footer_menu_items();
	register_zhaohu_topbar_menu_items();
	register_zhaohu_footer_menu_items();
}

function prepare_zhaohu_footer(){
	unregister_default_footer_menu_items();
	register_zhaohu_footer_menu_items();
}

function unregister_default_topbar_menu_items()
{
	elgg_unregister_menu_item('topbar', 'elgg_logo');
	elgg_unregister_menu_item('topbar', 'profile');
	elgg_unregister_menu_item('topbar', 'friends');
	elgg_unregister_menu_item('topbar', 'usersettings');
	elgg_unregister_menu_item('topbar', 'messages');
	elgg_unregister_menu_item('topbar', 'logout');
}

function unregister_default_footer_menu_items()
{
	elgg_unregister_menu_item('footer', 'report_this');
}

function register_zhaohu_footer_menu_items()
{

}

function zhaohu_user_hover_menu($hook, $type, $return, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'user')
		&&	elgg_get_logged_in_user_guid() == $entity->guid) {			
		$item = new ElggMenuItem('usersettings', elgg_echo('settings'), "settings/user/{$entity->username}");
		$item->setSection('action');
		$return[] = $item;
	}
	return $return;
}

function register_zhaohu_topbar_menu_items()
{
	$site_url = elgg_get_site_url();
	# register site logo
	$logo_url =  $site_url . "mod/zhaohu_theme/images/51logo.png";
	elgg_register_menu_item('topbar', array(
		'name' => 'zhaohu_logo',
		'href' => $site_url,
		'text' => "<img src=\"$logo_url\" alt=\"elgg_echo('zhaohu:home_page')\" height=\"77\" />",
		'priority' => 1,
		'title' => elgg_echo('zhaohu:home_page'),
	));
	
// 	$topbar_find_zhaohu_link = elgg_view('zhaohu_views/zhaohu_link', array(
// 		'href' => $site_url,
// 		'text' => elgg_echo('zhaohu:find_zhaohu'),
// 	));
// 	elgg_register_menu_item('topbar', array(
// 		'name' => 'find_zhaohu',
// 		'href' => false, # not generate link, directly show 'text' content
// 		'text' => "<div class=\"zhaohu-topbar-func-div\"> $topbar_find_zhaohu_link</div>",
// 		'priority' => 700,
// 		'section' => 'alt',
// 	));
	
	// link to the special activity search, such as halloween, thanksgiving etc. 
	$topbar_special_activity_link = elgg_view('zhaohu_views/zhaohu_link', array(
			'href' => $site_url . 'bbs/',
			'text' => elgg_echo('zhaohu:51zhaohu_bbs'),
	));
	elgg_register_menu_item('topbar', array(
		'name' => 'special_activity',
		'href' => false, # not generate link, directly show 'text' content
		'text' => "<div class=\"zhaohu-topbar-func-div zhaohu-topbar-special-div\"> $topbar_special_activity_link</div>",
		'priority' => 600,
		'section' => 'alt',
	));
	
	$topbar_photowall_link = elgg_view('zhaohu_views/zhaohu_link', array(
			'href' => $site_url . "photos/all",
			'text' => elgg_echo('zhaohu:photowall'),
	));
	elgg_register_menu_item('topbar', array(
	'name' => 'photowall',
	'href' => false, # not generate link, directly show 'text' content
	'text' => "<div class=\"zhaohu-topbar-func-div\"> $topbar_photowall_link </div>",
	'priority' => 700,
	'section' => 'alt',
	));

	if(elgg_is_logged_in()) #when logged in
	{
		$viewer = elgg_get_logged_in_user_entity();
		
		$topbar_create_group_link = elgg_view('zhaohu_views/zhaohu_link', array(
			'href' => $site_url . "groups/add/" . $viewer->guid,
			'text' => elgg_echo('zhaohu:create_group'),
		));
		elgg_register_menu_item('topbar', array(
			'name' => 'create_group',
			'href' => false, # not generate link, directly show 'text' content
			'text' => "<div class=\"zhaohu-topbar-func-div\"> $topbar_create_group_link</div>",
			'priority' => 800,
			'section' => 'alt',
		));

		elgg_register_menu_item('topbar', array(
			'name' => 'profile',
			'href' => $viewer->getURL(),
			'text' => elgg_view('output/img', array(
				'src' => $viewer->getIconURL('small'),
				'alt' => $viewer->name,
				'title' => elgg_echo('profile'),
				'class' => 'elgg-border-plain elgg-transition zhaohu-topbar-profile-img',
			)),
			'priority' => 900,
			'link_class' => 'elgg-topbar-avatar',
			'section' => 'alt',
		));
		
		//Display notification of new messages in topbar
		if (elgg_is_active_plugin('messages')) {
			$tooltip = elgg_echo("messages");
			$text = elgg_view('output/img', array(
					'src' => "{$site_url}/mod/messages/graphics/mail.png",
					'alt' => elgg_echo('messages'),
					'title' => elgg_echo('messages'),
					'class' => 'zhaohu-topbar-profile-img',
			));
			// get unread messages
			$num_messages =0;
			$num_messages = (int)messages_count_unread();
			if ($num_messages != 0) {
				$text .= "<span class=\"messages-new\">$num_messages</span>";
				$tooltip .= " (" . elgg_echo("messages:unreadcount", array($num_messages)) . ")";
			}
			elgg_register_menu_item('topbar', array(
			'name' => 'messages',
			'href' => 'messages/inbox/' . elgg_get_logged_in_user_entity()->username,
			'text' => $text,
			'priority' => 950,
			'title' => $tooltip,
			'link_class' => 'elgg-topbar-avatar',
			'section' => 'alt',
			));
		}

		// logout
		elgg_register_menu_item('topbar', array(
			'name' => 'logout',
			'id' => 'logout',
			'href' => "action/logout",
			'text' => elgg_echo('logout'),
			'is_action' => TRUE,
			'priority' => 1000,
			'class' => 'zhaohu-topbar-login-reg-link',
			'section' => 'alt',
		));
	}
	else #when NOT logged in
	{
		elgg_register_menu_item('topbar', array(
			'name' => 'login',
			'href' => 'login',
			'text' => elgg_echo('login'),
			'priority' => 900,
			'class' => 'zhaohu-topbar-login-reg-link',
			'section' => 'alt',
		));
		elgg_register_menu_item('topbar', array(
			'name' => 'register',
			'href' => 'register',
			'text' => elgg_echo('register'),
			'class' => 'zhaohu-topbar-login-reg-link',
			'priority' => 1000,
			'section' => 'alt',
		));
	}
}