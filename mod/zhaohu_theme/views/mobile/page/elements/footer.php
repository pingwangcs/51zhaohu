<script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" data-appid="101165869" charset="utf-8"></script>
<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=3194664931" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js"></script>
<script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>
<script type="text/javascript">
window.fbAsyncInit = function() {
    FB.init({
      appId      : '1493337114213955',
      xfbml      : true,
      version    : 'v2.2'
    });
  };

(function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

$(document).ready(function() {
    zhLogout.init();
});
var zhLogout = {
	init: function() {
		$('#logout').live('click', function() {
			//alert('qq logout');
			FB.logout(function(response) {});
			QC.Login.signOut();
			WB2.logout();
			if(WB2.checkLogin()) {alert("新浪微博登出失败");}
			else {$("登出成功").alert();
				window.setTimeout(function() { $("登出成功").alert('close'); }, 1000);}
		});
	}
}
</script>
<?php
/**
 * zhaohu footer
 * The standard footer that displays across the site
 *
 * @package zhaohu
 * @subpackage Core
 *
 */
//for 51zhaohu QQ login
echo '<html><head><meta property="qc:admins" content="1763573120017056375" /></head></html>';
//for 91zhaohu QQ login
echo '<html><head><meta property="qc:admins" content="1763573520017056375" /></head></html>';
echo '<div id="fb-root"></div>';

$footer_links = array(
	array('title' => elgg_echo('zhaohu:about_us'), 'href' => 'zhaohu_about/about_us'),
	array('title' => elgg_echo('zhaohu:service_terms'), 'href' => 'zhaohu_about/service_terms'),
	array('title' => elgg_echo('zhaohu:privacy_terms'), 'href' => 'zhaohu_about/privacy_terms'),
	array('title' => elgg_echo('zhaohu:contact_us'), 'href' => 'zhaohu_about/contact_us'),
	array('title' => elgg_echo('zhaohu:feedbacks'), 'href' => 'zhaohu_about/feedbacks'),
	array('title' => elgg_echo('zhaohu:help_center'), 'href' => 'zhaohu_about/help_center'),
// 	array('title' => elgg_echo('zhaohu:function_introduction'), 'href' => 'zhaohu_about/function_introduction'),
	array('title' => elgg_echo('zhaohu:friend_links'), 'href' => 'zhaohu_about/friend_links'),
);

if (elgg_is_logged_in()) {
	$href = "javascript:elgg.forward('reportedcontent/add'";
	$href .= "+'?address='+encodeURIComponent(location.href)";
	$href .= "+'&title='+encodeURIComponent(document.title));";

	$report_this_link_array = array('title' => elgg_echo('reportedcontent:this:tooltip'), 'href' => $href);
	array_push($footer_links, $report_this_link_array);
}

echo "<div class=\"zhaohu-footer\">";
$switch_view_txt = elgg_get_viewtype() == 'default'? 'zhaohu:switch2mobile':'zhaohu:switch2desktop';
echo elgg_view("output/url", array(
		"is_action" => true,
		"class" => "switch-view-mobile",
		"href" => "action/zhaohu/switch_view",
		"text" => elgg_echo($switch_view_txt))
);
echo '  |  ';
for($i = 0, $size = count($footer_links); $i < $size; ++$i) {
	echo elgg_view('zhaohu_views/zhaohu_link', array(
		'href' => $footer_links[$i]['href'],
		'text' => $footer_links[$i]['title'],
		));
	echo '  |  ';
}

echo "</div>";
?>

