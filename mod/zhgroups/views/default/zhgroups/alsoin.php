<?php

$group = $vars['entity'];
$limit = 8;
$groups = getInThisGroupAlsoIN($group, $limit);
//echo $groups;

$options = array(
		"full_view" => false,
		//'list_type' => 'gallery',
		//'gallery_class' => 'zhaohu-gallery',
		'list_type_toggle' => false,
);
//fordebug register_error("count ".$options["count"]);

$list = elgg_view_entity_list($groups,
		$options);

$result .= "<div class='zhgroups-group-listing zhaohu-group-sidebar-div'>";
$result .="<h4>People in this group also in</h4>";
if(!empty($list)){
	$result .= $list;
} else {
	$result .= elgg_echo('zhgroups:list:noresults');
}
$result .= "</div>";
echo $result;
