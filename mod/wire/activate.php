<?php
/**
 * Register the Wire class for the object/wire subtype
 */

if (get_subtype_id('object', 'wire')) {
	update_subtype('object', 'wire', 'Wire');
} else {
	add_subtype('object', 'wire', 'Wire');
}
