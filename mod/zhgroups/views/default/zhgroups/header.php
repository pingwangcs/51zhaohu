<?php
/**
 * Main content header
 *
 * Title and title menu
 *
 * @uses $vars['header_override'] HTML for overriding the default header (override)
 * @uses $vars['title']           Title text (override)
 * @uses $vars['context']         Page context (override)
 */

if (isset($vars['buttons'])) {
	// it was a bad idea to implement buttons with a pass through
	elgg_deprecated_notice("Use elgg_register_menu_item() to register for the title menu", 1.0);
}

if (isset($vars['header_override'])) {
	echo $vars['header_override'];
	return true;
}

$context = elgg_extract('context', $vars, elgg_get_context());

if(isset($vars['title']) && $vars['title'] != '')
{
	$title = elgg_extract('title', $vars);
	$title = elgg_view_title($title, array('class' => 'zhaohu-heading-main'));
	echo '<div id="pg_id">' . $title . "</div>";
}