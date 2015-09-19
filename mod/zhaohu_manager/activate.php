<?php
/**
 * Register the ElggNews class for the object/news subtype
 */

if (get_subtype_id('object', 'zhaohu')) {
	update_subtype('object', 'zhaohu', 'Zhaohu');
} else {
	add_subtype('object', 'zhaohu', 'Zhaohu');
}

if (get_subtype_id('object', 'coupon')) {
	update_subtype('object', 'coupon', 'Coupon');
} else {
	add_subtype('object', 'coupon', 'Coupon');
}