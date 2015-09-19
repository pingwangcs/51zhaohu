<?php
// echo "hello";

include(elgg_get_plugins_path()."zhaohu_manager/vendors/phpqrcode/qrlib.php");

$zhaohu_guid = (int) get_input("guid");
$code = get_input("code");
// we need to be sure ours script does not output anything!!!
// otherwise it will break up PNG binary!
ob_start("callback");

$codeText = elgg_get_site_url()."zhaohus/zhaohu/qrcoupon?guid={$zhaohu_guid}&code={$code}";

// end of processing here
//$debugLog = ob_get_contents();
ob_end_clean();
 
// outputs image directly into browser, as PNG stream
QRcode::png($codeText);


