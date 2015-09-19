<?php
/**
 * Serve up html for a post
 */

$guid = (int) get_input('guid');

$parent = wire_get_parent($guid);
if ($parent) {
	echo elgg_view_entity($parent);
}
