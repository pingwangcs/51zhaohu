<?php
/**
 * Elgg demo custom index page plugin
 * 
 */
define("ZHAOHU_MANAGER_BASE_ZOOM", 8);
define("ZHAOHU_MANAGER_FORMAT_DATE", "Y-m-d");
define("ZHAOHU_FORMAT_TS", "Y-m-d H:i");
define("ZHAOHU_APP_FORMAT_TS", "jS F Y");
define("ZHAOHU_SESSION_DATA_TTL", 3600);
define("ZHAOHU_MANAGER_SEARCH_LIST_LIMIT", 20);
define("ZHAOHU_MANAGER_COUPON_LIST_LIMIT", 20);
define("ZHAOHU_RECOMMENDED_SHOW_LIMIT", 5); //how many recommended zhaohus shows up on home page
define("ZHAOHU_MANAGER_ZHAOHU_IN_GROUP_LIMIT", 10);
define("EVENT_IN_GROUP_DIGEST_LIMIT", 5); //how many recommended events in group digest email
define("ZHAOHU_MANAGER_ALL_ATTENDEE_LIMIT", 10);
define("ZHAOHU_ATTENDEE_IN_EMAIL", 2);
define("ZHAOHU_MANAGER_SEARCH_LIST_MAPS_LIMIT", 50);
define("ATTENDEE_IN_ZHAOHU_LIMIT", 10);
define("BUYERS_IN_ZHAOHU_LIMIT", 10);
define("ZHAOHU_MANAGER_BROADCAST_LIMIT", 200);

define("ZHAOHU_TITLE_SHORT", 30);
define("ZH_ZHAOHU_DESP_MAX", 9000);
define("ZH_ADDRESS_MAX", 180);
define("ZH_CONTACT_MAX", 240);
define("ZH_CURRENCY_MAX", 30);
define("COUPON_CODE_LEN", 4);
define("COUPON_CODE_TRIES", 9000);
define("COUPON_OUT_LIMIT", 500);

define("ZHAOHU_MANAGER_RELATION_ATTENDING", "zhaohu_attending");
define("ZHAOHU_MANAGER_RELATION_ATTENDING_WAITINGLIST", "zhaohu_waitinglist");
define("ZHAOHU_MANAGER_RELATION_ATTENDING_PENDING", "zhaohu_pending");
define("ZHAOHU_MANAGER_RELATION_ORGANIZING", "zhaohu_organizing");
define("ZHAOHU_MANAGER_RELATION_UNDO", "zhaohu_undo");

require_once(dirname(__FILE__) . "/lib/functions.php");
require_once(dirname(__FILE__) . "/lib/hooks.php");
require_once(dirname(__FILE__) . "/lib/notify.php");
require_once(dirname(__FILE__) . "/lib/restapi.php");

elgg_register_event_handler('init', 'system', 'zhaohu_manager_init');

function zhaohu_manager_init() {
	zhaohu_expose_restapi();
	// owner block menu
	if(elgg_get_viewtype()=='default')
		elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'zh_owner_block_menu');

	// remove rss icon
	elgg_unregister_plugin_hook_handler('output:before', 'layout', 'elgg_views_add_rss_link');
	// Register subtype

	// Register entity_type for search
	elgg_register_entity_type("object", Zhaohu::SUBTYPE);
	elgg_register_entity_type("object", Coupon::SUBTYPE);
	
	// Extend system CSS with our own styles
	elgg_extend_view("css/elgg", "zhaohu_manager/css/site");	
	
	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('zhaohus', 'zhaohu_page_handler');
	elgg_register_page_handler('zhaohu_icon', 'zhaohu_icon_handler');
		
	// Add a menu item to the main site menu
	elgg_register_menu_item('site', ElggMenuItem::factory(array(
	'name' => 'zhaohu',
	'href' => '/zhaohus',
	'text' => elgg_echo('zhaohu_manager:zhaohu'),
	)));
	
	// register default elgg zhaohus
	elgg_register_plugin_hook_handler("register", "menu:entity", "zhaohu_manager_entity_menu", 600);
	
	//actions
	elgg_register_action("zhaohu/broadcast",
	dirname(__FILE__) . "/actions/zhaohu/broadcast.php");
	elgg_register_action("zhaohu/invite",
	dirname(__FILE__) . "/actions/zhaohu/invite.php");
	elgg_register_action("zhaohu_manager/zhaohu/cancel",
	dirname(__FILE__) . "/actions/zhaohu/cancel.php");
	elgg_register_action("zhaohu_manager/zhaohu/delete",
	dirname(__FILE__) . "/actions/zhaohu/delete.php");
	elgg_register_action("zhaohu_manager/zhaohu/edit",
	dirname(__FILE__) . "/actions/zhaohu/edit.php");
	elgg_register_action("zhaohu_manager/zhaohu/feature",
	dirname(__FILE__) . "/actions/zhaohu/feature.php");	
	elgg_register_action("zhaohu_manager/zhaohu/publish",
	dirname(__FILE__) . "/actions/zhaohu/publish.php");
	elgg_register_action("zhaohu_manager/zhaohu/rsvp",
	dirname(__FILE__) . "/actions/zhaohu/rsvp.php");
	elgg_register_action("coupon/delete",
	dirname(__FILE__) . "/actions/coupon/delete.php");
	elgg_register_action("coupon/use",
	dirname(__FILE__) . "/actions/coupon/use.php");
	elgg_register_action("coupons/gen",
	dirname(__FILE__) . "/actions/coupons/gen.php");
	elgg_register_action("coupons/send",
	dirname(__FILE__) . "/actions/coupons/send.php");
	// add widgets
	//elgg_register_widget_type("zhaohus", elgg_echo("zhaohu:widgets:title"), elgg_echo("zhaohu:widgets:description"), "index,dashboard,profile,groups");
	//elgg_register_plugin_hook_handler("widget_url", "widget_manager", "zhaohu_manager_widget_zhaohus_url");
	
	// register js libraries
	//$maps_key = elgg_get_plugin_setting("google_api_key", "zhaohu_manager");
	$maps_key="";
	elgg_register_simplecache_view("js/zhaohu_manager/gm_div");
	$gm_div_js = elgg_get_simplecache_url("js", "zhaohu_manager/gm_div");	
	elgg_register_js("zhaohu_manager.maps.gm.div", 
		$gm_div_js, 'footer');
	elgg_register_js("zhaohu_manager.maps.base", 
		"//maps.googleapis.com/maps/api/js?sensor=false", 'footer');

	elgg_register_simplecache_view("js/addthisevent/atemin");
	$addthisevent_js = elgg_get_simplecache_url("js", "addthisevent/atemin");
	elgg_register_js("addthisevent.base", $addthisevent_js, 'footer');
	//
	$view_type = elgg_get_viewtype();
	
	elgg_register_simplecache_view("js/zhaohu_manager/search");
	$search_js = elgg_get_simplecache_url("js", "zhaohu_manager/search");	
	elgg_register_js("zhaohu_manager.search", $search_js);
	
	elgg_register_simplecache_view("js/zhaohu_manager/edit");
	$edit_js = elgg_get_simplecache_url("js", "zhaohu_manager/edit");
	elgg_register_js("zhaohu_manager.edit", $edit_js);
}

function zh_owner_block_menu($hook, $type, $return, $params) {
	$user = $params['entity'];
	if (elgg_is_logged_in()) {
		if (elgg_get_logged_in_user_guid() == $user->guid) {
			$url = "zhaohus/coupons/$user->username";
			$item = new ElggMenuItem('profile:coupons', elgg_echo('profile:coupons'), $url);
			$return[] = $item;
		}
	}
	return $return;
}

function zhaohu_page_handler($page) {

	if (!isset($page[0])) {
		$page[0] = 'unknow';
	}
	//fordebug system_message("$page[0] ");
	if(!empty($page)) {
		switch($page[0]) {
			case "proc":
				if(file_exists(dirname(__FILE__)."/procedures/".$page[1]."/".$page[2].".php")) {
					$include = "/procedures/".$page[1]."/".$page[2].".php";
				} else {
					echo json_encode(array("valid" => 0));
					//exit();
				}
				break;
			case "pay":
				$include = "/pages/pay/{$page[1]}.php";
				break;
			case "coupon":
				$include = "/pages/coupon/{$page[1]}.php";
				break;
			case "coupons":
				$username = $page[1];
				$user = get_user_by_username($username);
				elgg_set_page_owner_guid($user->guid);
				set_input("username", $username);
				$include = "/pages/coupons/view.php";
				break;
			case "zhaohu":
				switch($page[1]) {
					case "broadcast":
						break;
					case "attendees":
						set_input("guid", $page[2]);
						set_input("count", $page[3]);
						break;
					case "coupons":
						break;
					case "usecoupon":
						break;
					case "qrcoupon":
						$old_ia = elgg_set_ignore_access(true);
						useQrCoupon();
						elgg_set_ignore_access($old_ia);
						return true;
					case "emRsvp":
						zhaohuRsvp();
						return true;
					case "pay":
						set_input("guid", $page[2]);
						break;
					case "new":
						$page[1] = "edit";
						set_input("owner_guid", $page[2]);
				}
			default:
				if(!empty($page[2]) && ($page[1] !== "new")) {
					set_input("guid", $page[2]);
				}
				$view_type = elgg_get_viewtype();
				if ($view_type == 'mobile' && file_exists(dirname(__FILE__)."/pages/".$page[0]."/mobile_".$page[1].".php")){
					$include = "/pages/".$page[0]."/mobile_".$page[1].".php";
				}
				elseif(file_exists(dirname(__FILE__)."/pages/".$page[0]."/".$page[1].".php")) {
					$include = "/pages/".$page[0]."/".$page[1].".php";
				} else {
					register_error(elgg_echo("zhaohu:wrong"). elgg_echo("zhaohu:sorry"));
					elgg_log("ZHError ,zhaohu_page_handler, /pages/".$page[0]."/".$page[1].".php does not exist, user_id "
						.elgg_get_logged_in_user_guid(), "ERROR");
					forward(REFERER);
				}
				break;
		}
	}

	include(dirname(__FILE__) . $include);

	return true;
}

function zhaohu_icon_handler($page) {
	if (isset($page[0])) {
		set_input('guid', $page[0]);
	}
	if (isset($page[1])) {		
		set_input('size', substr($page[1], 0, -4));
	}
	$plugin_dir = elgg_get_plugins_path();
	include("$plugin_dir/zhaohu_manager/icon.php");
	return true;
}