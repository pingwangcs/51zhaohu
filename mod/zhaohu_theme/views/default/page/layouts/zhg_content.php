<?php
/**
 * Zhaohu group content page layout
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
 * @uses $vars['entity']         group entity
 */

// give plugins an opportunity to add to content sidebars
$sidebar_content = elgg_extract('sidebar', $vars, '');
$params = $vars;
$params['content'] = $sidebar_content;
$sidebar = elgg_view('page/layouts/content/sidebar', $params);
$group = $vars['entity'];

// allow page handlers to override the default header
if (isset($vars['header'])) {
	$vars['header_override'] = $vars['header'];
}

// allow page handlers to override the default filter
if (isset($vars['filter'])) {
	$vars['filter_override'] = $vars['filter'];
}
$filter = elgg_view('page/layouts/content/filter', $vars);

// the all important content
$content = elgg_extract('content', $vars, '');

// optional footer for main content area
$footer_content = elgg_extract('footer', $vars, '');
$params = $vars;
$params['content'] = $footer_content;
$footer = elgg_view('page/layouts/content/footer', $params);

$body = $header . $filter . $content . $footer;

$params = array(
	'content' => $body,
	'sidebar' => $sidebar,
);
if (isset($vars['class'])) {
	$params['class'] = $vars['class'];
}
$params['sidebar_id'] = 'zhaohu_group_sidebar';
$params['sidebar_class'] = 'zhaohu-group-sidebar-div';

echo elgg_view('zhgroups/group_header', array("group" => $group));
echo '<div id="zhaohu_group_content_div">';
echo elgg_view_layout('zhaohu_group_one_sidebar', $params);
echo '</div>';
