<?php 
/**
 * Group entity view
 * 
 * @package ElggGroups
 */
 
$group = $vars['entity'];

$icon = elgg_view_entity_icon($group, 'tiny');

$metadata = elgg_view_menu('entity', array(
	'entity' => $group,
	'handler' => 'groups',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

if (elgg_in_context('owner_block') || elgg_in_context('widgets')) {
	$metadata = '';
}

if ($vars['full_view']) {
	echo elgg_view('groups/profile/summary', $vars);
} elseif(elgg_in_context('find_groups')) {
	$search_title_length = 15;  
	$group_url = $group->getURL();
	$group_icon = $group->getIconURL("large");

	$group_name = mb_substr($group->name, 0, $search_title_length);
	if(mb_strlen($group->name) > $search_title_length)
	{
		$group_name .= "...";
		
	}
	
	echo "<div class=\"zhaohu-group-search-result\" style=\"background-image: url({$group_icon});\" OnClick=\"javascript: window.location.href = '{$group_url}'\">";
    if($group->featured_group == "yes")
    {
    	// add featured group special icon
    	$featured_icon_url = elgg_get_site_url() . "mod/zhaohu_theme/images/V-2.png";
    	echo "<div class='zhaohu-featured-group-div'><img src=\"{$featured_icon_url}\" class='zhaohu-featured-icon-search-result'></div>";
    }
	echo "<div class=\"zhaohu-group-search-result-text\">";
    echo elgg_view("output/url", array("text" => $group_name, 
    								   "href" => $group_url,
    		                           "class" => "zhaohu-group-search-result-link"));
	echo "</div></div>";
}
//render groups inside nearby group div on group home page
elseif(elgg_in_context('nearby_groups')) {  
	$group_url = $group->getURL();
	
	echo '<div class="zhaohu-group-nearby">';
	echo elgg_view_entity_icon($group, "small", array("img_class" => "nearby-group-icon", "link_class" => "nearby-group-icon-link"));
	$str_length = 10;
	$group_name = mb_substr($group->name, 0, $str_length);
	if(mb_strlen($group->name) > $str_length)
	{
		$group_name .= "...";
	}
	echo elgg_view("output/url", array("text" => $group_name, "href" => $group_url, "class"=>"nearby-group-title"));
	echo "</div>";
}
elseif(elgg_in_context('recommended_groups')) {
	$group_url = $group->getURL();

	
	$icon = elgg_view_entity_icon($group, "medium", array("img_class" => "recommended-group-icon", "link_class" => "recommended-group-icon-link"));
	$str_length = 10;
	$group_name = mb_substr($group->name, 0, $str_length);
	if(mb_strlen($group->name) > $str_length)
	{
		$group_name .= "...";
	}

	$content = elgg_view("output/url", array("text" => $group_name, "href" => $group_url, "class"=>"recommended-group-title"));
    $content .= '<div class="zhaohu-group-recommended-details">';
    
    $group_owner = $group->getOwnerEntity();
    $content .= '<label>' . elgg_echo("zhgroups:founder") . '</label>' . ": " . $group_owner->name;
    $content .= '</div>';
    
    $description_length = 32;
    $group_description = mb_substr($group->description, 0, $description_length);
    if(mb_strlen($group->description) > $description_length)
    {
    	$group_description .= "...";
    }
    
    $content .= $group_description;
	echo elgg_view_image_block($icon, $content, array("class" => "recommended-group-item-div"));
}
// render groups inside user profile page
elseif(elgg_in_context('inprofile')) {
	$group_url = $group->getURL();
	
	echo "<div class=\"zhaohu-group-inprofile\">";
	
	echo elgg_view("output/url", 
				   array("text" => elgg_view_entity_icon($group, "medium", array("img_class"=>"in-profile-group-icon")),
				   "href" => $group_url));
	// $group->name need to handled if it is too long
	echo '<div class="in_profile_group_title">' . elgg_view("output/url", array("text" => $group->name, "href" => $group_url)) . '</div>';
	$userId = elgg_get_page_owner_guid();	
	if($userId == $group->owner_guid)
		echo "<em>".elgg_echo("zhgroups:founder")."</em>";
	else if(check_entity_relationship($userId, "group_admin", $group->guid))
		echo "<em>".elgg_echo("zhgroups:admin")."</em>";
	else
		echo "<em>".elgg_echo("zhgroups:member")."</em>";
	
	echo "</div>";	
}
else {
	// brief view
	$params = array(
		'entity' => $group,
		'metadata' => $metadata,
		'subtitle' => $group->briefdescription,
		'state' => $group->state,
		'city' => $group->city,
	);
	$params = $params + $vars;
	$list_body = elgg_view('group/elements/summary', $params);

	echo elgg_view_image_block($icon, $list_body, $vars);
}