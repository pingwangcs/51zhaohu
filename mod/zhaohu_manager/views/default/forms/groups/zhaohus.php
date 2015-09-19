<?php

$group = elgg_extract("entity", $vars, elgg_get_page_owner_entity());

$tabs = array(
		"upcoming_zhaohus" => array(
				"text" => elgg_echo("zhaohu:upcoming_zhaohus"),
				"href" => "#",
				"rel" => "upcoming_zhaohus",
				"priority" => 200,
				"onclick" => "groups_zhaohus_switch_tab(\"upcoming-zhaohus\");",
				"selected" => true
		),
		"past_zhaohus" => array(
				"text" => elgg_echo("zhaohu:past_zhaohus"),
				"href" => "#",
				"rel" => "past_zhaohus",
				"priority" => 300,
				"onclick" => "groups_zhaohus_switch_tab(\"past-zhaohus\");"
		)
);

if ($group->canEdit())
	$all_status = true;
else
	$all_status = false;

$form_data = "<div id='groups_upcoming_zhaohus'>";
// $zhaohu_options = array("container_guid" => $group->guid,
// 		"past_zhaohus" => false,
// 		"all_status" => $all_status);
// $form_data .= getZhaohussForTab($zhaohu_options);
$form_data .= "</div>";

$form_data .= "<div id='groups_past_zhaohus'>";//class='hidden'
// $zhaohu_options = array("container_guid" => $group->guid,
// 		"past_zhaohus" => true,
// 		"past_only" => true,
// 		"all_status" => $all_status);
// $form_data .= getZhaohussForTab($zhaohu_options);
$form_data .= "</div>";

// build tabs
if (!empty($tabs)) {
	foreach ($tabs as $name => $tab) {
		$tab["name"] = $name;
			
		elgg_register_menu_item("filter", $tab);
	}
	echo elgg_view_menu("filter", array("sort_by" => "priority"));
}
$form_data .= elgg_view('input/hidden', array('id' => 'gguid', 'value' => $group->guid));

// show form
echo $form_data;
?>
<script type="text/javascript">
$(function() {
	groups_zhaohus_switch_tab('upcoming-zhaohus');
});

function groups_zhaohus_switch_tab(tab){
	$('#groups_zhaohus_form li').removeClass('elgg-state-selected');
	$('#groups_zhaohus_form li.elgg-menu-item-' + tab).addClass('elgg-state-selected');



	var showDiv, hideDiv, past;
	
	if(tab =='upcoming-zhaohus'){
		showDiv = '#groups_upcoming_zhaohus';
		hideDiv = '#groups_past_zhaohus';
		past = 'n';
	}
	else {
		showDiv = '#groups_past_zhaohus';
		hideDiv = '#groups_upcoming_zhaohus';
		past = 'y';
	}

	var gguid = $("#gguid").val();

	$.ajax({
		 type: 'GET',
		 cache: false,
		 url: elgg.get_site_url() + 'zhaohus/proc/zhaohus/findInGroup?gguid='+gguid+'&past='+past,
		 dataType: 'html',
		 success: function(data, status, xml){
			$(showDiv).html(data);					
			$(hideDiv).hide();	
			$(showDiv).show();
		 },
		 error: function(xml, status, error){
			 $(showDiv).html(elgg_echo("zhaohu:error"));
		 },
	});
}

</script>