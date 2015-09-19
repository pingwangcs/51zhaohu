<?php
/**
 * Mail group members
 */
elgg_load_js("zhgroups.mail");

$group = $vars["entity"];
$memberId = $vars["memberId"];
$form_data = '';
if($memberId) {
	$member = get_entity($memberId);
	$form_data .= "<div id='zhgroups_mail_memberId'><label>".elgg_echo("zhgroups:mail:to")."</label><br />";
	$form_data .= "<a href='".$member->getURL()."'>$member->name</a>";
	$form_data .= elgg_view("input/hidden", array("name" => "user_guids", "value" => $memberId));
	$form_data .= "</div>";
}
else {
// get members
$members = $group->getMembers(false);

$friendpicker_value = array();
if (!empty($members)) {
	foreach ($members as $member) {
		$friendpicker_value[] = $member->getGUID();
	}
}

$form_data .= "<label>" . elgg_echo("zhgroups:mail:form:recipients") . ": <span id='zhgroups_mail_recipients_count'>" . count($friendpicker_value) . "</span></label>";
$form_data .= "<br />";
$form_data .= "<a href='javascript:void(0);' onclick='$(\"#zhgroups_mail_member_selection\").toggle();'>" . elgg_echo("zhgroups:mail:form:members:selection") . "</a>";

$form_data .= "<div id='zhgroups_mail_member_selection'>";
$form_data .= elgg_view("input/friendspicker", array("entities" => $members, "value" => $friendpicker_value, "highlight" => "all", "name" => "user_guids"));
$form_data .= "</div>";

$form_data .= "<div id='zhgroups_mail_member_options'>";
$form_data .= elgg_view("input/button", array("class" => "elgg-button-action", "id" => "zhgroups_mail_clear", "value" => elgg_echo("zhgroups:clear_selection")));
$form_data .= elgg_view("input/button", array("class" => "elgg-button-action", "id" => "zhgroups_mail_all", "value" => elgg_echo("zhgroups:all_members")));
$form_data .= "<br />";
$form_data .= "</div>";
}

$subject = isset($_SESSION['zhgroups:subject'])?$_SESSION['zhgroups:subject']:'';
$form_data .= "<div>";
$form_data .= "<label>" . elgg_echo("zhgroups:mail:form:subject") . "</label>";
$form_data .= elgg_view("input/text", array("name" => "subject", "value" => $subject));
$form_data .= "</div>";

$body = isset($_SESSION['zhgroups:body'])?$_SESSION['zhgroups:body']:'';
$form_data .= "<div>";
$form_data .= "<label>" . elgg_echo("zhgroups:mail:form:body") . "</label>";
$form_data .= elgg_view("input/longtext", array("name" => "body", "value" => $body));
$form_data .= "</div>";

$form_data .= "<div class='elgg-foot'>";
$form_data .= elgg_view("input/hidden", array("name" => "group_guid", "value" => $group->getGUID()));
$form_data .= elgg_view("input/submit", array("value" => elgg_echo("send")));
$form_data .= elgg_view('output/url', array(
	'text' => elgg_echo('cancel'),
	'href' => $group->getURL(),
	'class' => 'elgg-button elgg-button-cancel',
	));
$form_data .= "</div>";

echo elgg_view("input/form", array("body" => $form_data,
										"action" => $vars["url"] . "action/zhgroups/mail",
										"id" => "zhgroups_mail_form",
										"class" => "elgg-form-alt"));