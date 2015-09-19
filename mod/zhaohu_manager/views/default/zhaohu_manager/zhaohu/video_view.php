<?php
$zhaohu = $vars ["entity"];
$owner = $zhaohu->getOwnerEntity ();
$zhaohu_details = "";
$zhaohu_details .= '<div class="zhaohu-manager-zhaohu-title">' . $zhaohu->title . '</div>';

$zhaohu_details .= '<div id="zhaohu-video">'
		.'<iframe src="'.$zhaohu->videoUrl.'" frameborder="0" allowfullscreen></iframe>'
				.'</div>';

$owner_link = elgg_view ( 'output/url', array (
		'href' => $owner->getURL (),
		'text' => $owner->name,
		'is_trusted' => true
) );
$author_text = elgg_echo ( 'zhaouhu:initiated_by' ) . ': ' . $owner_link;
$zhaohu_details .= '<div><label>' . $author_text . '</label></div>';
// Time
$zhaohu_details .= '<div><label>' . elgg_echo ( 'zhaohu:start_time' ) . ': </label>' . date ( ZHAOHU_MANAGER_FORMAT_DATE, $zhaohu->start_day ) . " " . date ( 'H:i', $zhaohu->start_time );
// optional end day
if ($zhaohu->end_ts) {
	$zhaohu_details .= '<div><label>' . elgg_echo ( 'zhaohu:end_time' ) . ': </label>' . date ( ZHAOHU_FORMAT_TS, $zhaohu->end_ts ) . '</div>';
}
if ($zhaohu->coupon_end_ts) {
	$zhaohu_details .= '<div><label>' . elgg_echo ( 'coupon:end_time' ) . ': </label>' . date ( ZHAOHU_FORMAT_TS, $zhaohu->coupon_end_ts ) . '</div>';
}
$zhaohu_details .= '</div>';
// Render zhaohu details information
$body = elgg_view ( "zhaohu_manager/zhaohu/div_container", array (
		"content" => $zhaohu_details,
		"div_class" => "zhaohu-details-info",
		"div_id" => "zhaohu_details_information"
) );

$zhaohu_description = ! $zhaohu->description ? elgg_echo ( 'None' ) : $zhaohu->description;
$zhaohu_description = '<label>' . elgg_echo ( 'description' ) . ':</label>' . elgg_view ( "output/longtext", array (
		"value" => $zhaohu_description 
) );

$body .= elgg_view ( "zhaohu_manager/zhaohu/div_container", array (
		"content" => $zhaohu_description,
		"div_class" => "zhaohu-manager-zhaohu-description",
		"div_id" => "zhaohu_manager_zhaohu_description" 
) );

$body .= '<div class="zh-share"><div class="fb-share-button" data-href="' . $zhaohu->getUrl () . '" data-layout="button"></div>';
$body .= '<div><wb:share-button appkey="59jzyP" addition="simple" type="button" ralateUid="5360144513" default_text="说点什么" pic="http%3A%2F%2F51zhaohu.com%2Fmod%2Fzhaohu_theme%2Fimages%2Flogo64.png"></wb:share-button></div>';
$body .= "<div><script type=\"text/javascript\">(function(){var p = {url:location.href, showcount:'0',desc:'',summary:'',title:'',site:'',pics:'',style:'101',width:142,height:30}; var s = []; for(var i in p){s.push(i + '=' + encodeURIComponent(p[i]||''));}";
$body .= "document.write(['<a version=\"1.0\" class=\"qzOpenerDiv\" href=\"http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?',s.join('&'),'\" ftarget=\"_blank\">分享</a>'].join(''));})();</script>";
$body .= '</div></div>';

if ($zhaohu->status == 'published') {
	$body .= elgg_view ( 'wire/event', array (
			'entity_guid' => $zhaohu->guid,
			'show_add_form' => true
	) );
}
echo $body;
?>

<html xmlns:wb="http://open.weibo.com/wb">
<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js"
	type="text/javascript" charset="utf-8"></script>
<script
	src="http://qzonestyle.gtimg.cn/qzone/app/qzlike/qzopensl.js#jsdate=20111201"
	charset="utf-8"></script>
<?php	