<?php
elgg_load_js("zhgroups.invite");

$group = elgg_extract("entity", $vars, elgg_get_page_owner_entity());

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
//echo elgg_view('input/hidden', array('name' => 'forward_url', 'value' => $forward_url));
echo elgg_view('input/hidden', array('name' => 'group_guid', 'value' => $group->guid));
echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('invite')));
echo elgg_view('output/url', array(
			'text' => elgg_echo('cancel'),
			'href' => $group->getURL(),
			'class' => 'elgg-button elgg-button-cancel',
	));
/*
if (elgg_is_admin_logged_in()) {
	echo elgg_view("input/submit", array('name' => 'submit', "value" => elgg_echo("zhgroups:add_users"), "onclick" => "return confirm(\"" . elgg_echo("zhgroups:group:invite:add:confirm") . "\");"));
}*/
echo '</div>';
	
?>