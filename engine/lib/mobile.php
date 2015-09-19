<?php
/*
 * Check whether we should use mobile view
 * 
 */
global $IS_FROM_APP;
$IS_FROM_APP = false;

function check_mobile_mode(){
	global $IS_FROM_APP;
	setcookie( "51zhaohu_app", "true", time() + 3600 );
	if($_COOKIE['51zhaohu_app']){
		$IS_FROM_APP = true;
	}
	if($_COOKIE['51zh_desktop']){
		elgg_set_viewtype('default');
		return;
	}
	if($_COOKIE['51zh_mobile']){
		elgg_set_viewtype('mobile');
		return;
	}
	$useragent = strtolower( $_SERVER['HTTP_USER_AGENT'] );
	//detect if there is a mobile device
	if(preg_match('/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/',$useragent)||preg_match('/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /',$useragent && !strstr($useragent,'ipad'))){
		//the hack to hide mobile view is below
		elgg_set_viewtype('mobile');
		//elgg_set_viewtype('default');
	} else {
		elgg_set_viewtype('default');
	}
}
function elgg_is_from_app() {
	global $IS_FROM_APP;
	return $IS_FROM_APP;
}
