<?php
/**
 * zhaohu link view
 *
 * @uses string $vars['href'] the link src url.
 * @uses string $vars['text'] the link text
 */

$vars['href'] = elgg_normalize_url($vars['href']);
$vars['href'] = elgg_format_url($vars['href']);
$text = $vars['text'];

$attributes = elgg_format_attributes($vars);
echo "<a $attributes>$text</a>";
