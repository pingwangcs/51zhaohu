<?php
$zhaohu = $vars ["entity"];
$owner = $zhaohu->getOwnerEntity ();
$zhaohu_details = "";

// zhaohu info div
$zhaohu_details .= '<div class="zhaohu_details_mobile">';

// Title
$zhaohu_details .= '<div class="zhaohu-title-mobile">' . $zhaohu->title . '</div>';

$zhaohu_details .= '<div id="zhaohu-video">'
		.'<iframe src="'.$zhaohu->videoUrl.'" frameborder="0" allowfullscreen></iframe>'
				.'</div>';

$owner_link = elgg_view('output/url', array(
		'href' => $owner->getURL(),
		'text' => $owner->name,
		'is_trusted' => true));

$author_text = elgg_echo('zhaouhu:initiated_by') . ': ' . $owner_link;
$zhaohu_details .= '<div><label>'.$author_text.'</label></div>';
// Time
$zhaohu_details .= '<div><label>' . elgg_echo('zhaohu:start_time') . ': </label>' . date(ZHAOHU_MANAGER_FORMAT_DATE, $zhaohu->start_day) . " ". date('H', $zhaohu->start_time) . ':' . date('i', $zhaohu->start_time);
// optional end day
if ($zhaohu->end_ts) {
	$zhaohu_details .= '<div><label>' . elgg_echo ( 'zhaohu:end_time' ) . ': </label>' . date ( ZHAOHU_FORMAT_TS, $zhaohu->end_ts ) . '</div>';
}

$zhaohu_details .= '</div>';
// Render zhaohu details information
	$body = elgg_view(
				"zhaohu_manager/zhaohu/div_container", 
				array(
					"content" => $zhaohu_details ,
					"div_class" => "zhaohu-details-info-mobile",
					"div_id" => "zhaohu_details_information_mobile"));

	$zhaohu_description = !$zhaohu->description?elgg_echo('None'):$zhaohu->description;
	$zhaohu_description = '<label>' . elgg_echo('description') . ':</label>' 
		. elgg_view("output/longtext", array("value" => $zhaohu_description));
	
	$body .= elgg_view(
				"zhaohu_manager/zhaohu/div_container",
				array("content" => $zhaohu_description,
						"div_class" => "zhaohu_details_mobile"));

	if($zhaohu->status == 'published'){
		$body .= '<div class="zhaohu_more_mobile">'
				.elgg_view('wire/event', array('entity_guid'=>$zhaohu->guid, 'show_add_form'=>true))
				. '</div>';
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