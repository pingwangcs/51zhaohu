<?php
/**
 * zhaohu in group content layout
 *
 * @uses $vars['content']        HTML of main content area
 * @uses $vars['sidebar']        HTML of the sidebar
 * @uses $vars['header']         HTML of the content area header (override)
 * @uses $vars['nav']            HTML of the content area nav (override)
 * @uses $vars['footer']         HTML of the content area footer
 * @uses $vars['filter']         HTML of the content area filter (override)
 * @uses $vars['title']          Title text (override)
 * @uses $vars['context']        Page context (override)
 * @uses $vars['filter_context'] Filter context: everyone, friends, mine
 * @uses $vars['class']          Additional class to apply to layout
 */

// give plugins an opportunity to add to content sidebars
$sidebar_content = elgg_extract('sidebar', $vars, '');
$params = $vars;
$params['content'] = $sidebar_content;
$sidebar = elgg_view('page/layouts/content/sidebar', $params);
$group = elgg_extract('group', $vars);

// allow page handlers to override the default filter
if (isset($vars['filter'])) {
	$vars['filter_override'] = $vars['filter'];
}
$filter = elgg_view('page/layouts/content/filter', $vars);

// the all important content
$content = elgg_extract('content', $vars, '');

$output = '<div class="groups-profile clearfix elgg-image-block">';

// render left side bar (group info div)
$output .= elgg_view('zhgroups/inGroup', array("entity" => $group));

if($sidebar_content == ''){
	$output .= '<div class="zhaohu-group-content-div">';
}
else{
	$output .= '<div class="zhaohu-group-middle-div">';
}

// allow page handlers to override the default header
if (isset($vars['header'])) {
	$vars['header_override'] = $vars['header'];
}
$header = elgg_view('zhgroups/header', $vars);
$output .= $header;

$output .= $content;
$output .= '</div></div>';

// optional footer for main content area
$footer_content = elgg_extract('footer', $vars, '');
$params = $vars;
$params['content'] = $footer_content;
$footer = elgg_view('page/layouts/content/footer', $params);

$body = $filter . $output . $footer;

$vars['content'] = $body;
$vars['sidebar'] = $sidebar;

if($sidebar_content == ''){
	echo elgg_view_layout('zhaohu_group_one_column', $vars);
}
else
{
	echo elgg_view_layout('zhaohu_group_one_sidebar', $vars);
}


