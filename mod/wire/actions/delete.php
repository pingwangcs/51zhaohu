<?php
/**
 * Action for deleting a wire post
 * 
 */

// Get input data
$guid = (int) get_input('guid');

// Make sure we actually have permission to edit
$wire = get_entity($guid);
if ($wire->getSubtype() == "wire" && $wire->canEdit()) {

	// unset reply metadata on children
	$children = elgg_get_entities_from_relationship(array(
		'relationship' => 'parent',
		'relationship_guid' => $guid,
		'inverse_relationship' => true,
	));
	if ($children) {
		foreach ($children as $child) {
			$child->reply = false;
		}
	}

	$orig_entity = get_entity($wire->entity_guid);

	// Delete it
	$rowsaffected = $wire->delete();
	if ($rowsaffected > 0) {
		// Success message
		system_message(elgg_echo("wire:deleted"));
	} else {
		register_error(elgg_echo("wire:notdeleted"));
	}
	forward($orig_entity->getURL());
}
