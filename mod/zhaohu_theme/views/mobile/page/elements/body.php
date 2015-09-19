<?php
/**
 * Elgg mobile page body wrapper
 *
 * @uses $vars['body'] The HTML of the page body
 */

echo elgg_extract('body', $vars, '');