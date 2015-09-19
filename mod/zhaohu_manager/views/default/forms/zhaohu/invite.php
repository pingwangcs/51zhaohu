<?php
elgg_load_js("zhgroups.invite");

$zhaohu_guid = (int) get_input("guid");
$zhaohu = get_entity($zhaohu_guid);

$form_data .= "<div id='zh_invite_email'>";
$form_data .= "<div>" . elgg_echo("zhaohu:invite:email:description");
$form_data .= elgg_view("output/url", array("text"=>elgg_echo("add"),
		"href"=>"#",
		'id'=>'zh_email_add',
		'class' => 'elgg-button elgg-button-action'));
$form_data .= "</div>";
$form_data .= elgg_view("input/text", array("name" => "zh_invite_email_input",
	"id" => "zh_invite_email_input"));
$form_data .="<div id='zh_invite_email_results'></div>";
$form_data .="<div id='zh_invite_email_invalid' class='hidden'></div>";
$form_data .= "</div>";
// optional text
$form_data .= elgg_view_module("aside", elgg_echo("zhaohu:invite:text"), elgg_view("input/longtext", array("name" => "comment")));

// show form
echo $form_data;

// show buttons
echo '<div class="elgg-foot">';
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $zhaohu->guid));
echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('invite')));
echo elgg_view('output/url', array(
			'text' => elgg_echo('cancel'),
			'href' => $zhaohu->getURL(),
			'class' => 'elgg-button elgg-button-cancel',
	));

echo '</div>';
	
?>