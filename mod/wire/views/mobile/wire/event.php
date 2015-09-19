<?php
/**
 * List comments with optional add form
 *
 * @uses $vars['entity']        ElggEntity
 * @uses $vars['show_add_form'] Display add form or not
 * @uses $vars['id']            Optional id for the div
 * @uses $vars['class']         Optional additional class for the div
 */
$show_add_form = elgg_extract('show_add_form', $vars, true);

echo '<div class="event-wire">';

$entity_guid = $vars['entity_guid'];
//fordebug register_error("in view entity_guid {$entity_guid}");
$options = array(
		'type' 			=> 'object',
		'subtype' 		=> 'wire',
		'limit' 		=> WIRE_POST_LIMIT,
);

$options['metadata_name_value_pairs'][]
	= array('name' => 'entity_guid', 'value' => $vars['entity_guid']);

$html = elgg_list_entities_from_metadata($options);

echo '<h3>' . elgg_echo('comments') . '</h3>';
if ($show_add_form) {
	echo elgg_view_form('wire/add', array(), $vars);
}

if ($html) {
	echo $html;
}

echo '</div>';
