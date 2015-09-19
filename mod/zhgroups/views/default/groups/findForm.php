<?php
/**
 * Group and zhaohu tag-based search form and result divs
 */
elgg_load_js("zhaohu_manager.search");

echo "<div id=\"zhaohu_search_and_result_div\">";
echo "<div id=\"zhaohu_search_div\">";
$option_string = elgg_echo('groups:search:tags');

$params = array(
		'name' => 'tag',
		'id' => 'zhf_tag_input', //zhf is zhaohu find
		'class' => 'zhaohu-search-div-input',
		'value' => elgg_echo('AllInterests'),
);
echo elgg_view('input/text', $params);


echo elgg_echo('groups:around');

echo elgg_view('input/text', array(
		'name' => 'zhf_state_input',
		'id' => 'zhf_state_input', //zhf is zhaohu find
		'class' => 'zhaohu-search-div-input',
		'value' => 'WA'));
$stateDD = "<ul id='zhf_state_dd' class='zh-state-dd'>";
foreach (elgg_get_config('zhstates') as $t) {
	$stateDD .= "<li>" . elgg_view("output/url", array("href" => "#", "text" => elgg_echo($t), "class"=>"zhf-state-opt")) . "</li>";
}
$stateDD .= "</ul>";
echo $stateDD;

echo elgg_view('input/text', array(
		'name' => 'zhf_city_input',
		'id' => 'zhf_city_input', //zhf is zhaohu find
		'class' => 'zhaohu-search-div-input',
		'value' => 'Seattle'));

echo "<ul id='zhf_city_dd' class='zht_dd zht_dd_city_position'></ul>";

echo elgg_view("output/url",
		array('class' => 'zhaohu-search',
				"href" => "#",
				"text" => elgg_echo('find:groups'),
				"id" => "zhf_groups"));

echo elgg_view("output/url",
		array('class' => 'zhaohu-search',
				"href" => "#",
				"text" => elgg_echo('find:zhaohus'),
				"id" => "zhf_zhaohus"));

echo genTagDiv("zhf_tag_dd", "tag-opt");
echo '</div><div id="zhaohu_past"><input type="checkbox" name="zhf_past" id="zhf_past" value="1" />';
echo elgg_echo('zhaohu:past_zhaohus');
echo "</div><div id=\"zhaohu_search_result_div\">";

// home page left side bar
$popular_interests_ul = elgg_view("zhaohu_manager/popular_interests");
$hot_topics = elgg_view("zhaohu_manager/hot_topics");
echo '<div id="zhaohu_homepage_left_side_bar">' . $popular_interests_ul . $hot_topics. '</div>';

echo "<div id='find_result_groups' class='find_result_entities'></div>";
echo "<div id='find_result_zhaohus' class='find_result_entities'></div>";

// home page right side bar
$follow_us = elgg_view("zhaohu_manager/follow_us");
$recommended_zhaohus = elgg_view("zhaohu_manager/recommended_zhaohus");
$recommended_groups = elgg_view("zhaohu_manager/recommended_groups");
$wechat_qrcode = elgg_view("zhaohu_manager/wechat_qrcode");

echo '<div id="zhaohu_homepage_right_side_bar">' . $recommended_zhaohus . $recommended_groups . $follow_us . $wechat_qrcode . '</div>';
echo "</div></div>";

?>
