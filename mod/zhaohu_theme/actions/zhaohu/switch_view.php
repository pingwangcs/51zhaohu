<?php
if(elgg_get_viewtype()=='default'){
	$old_viewtype = '51zh_desktop';
	$new_viewtype = '51zh_mobile';
} else {
	$old_viewtype = '51zh_mobile';
	$new_viewtype = '51zh_desktop';
}

setcookie($old_viewtype, "y", time() - 3600, "/");
setcookie($new_viewtype, "y", time() + 36000, "/");
