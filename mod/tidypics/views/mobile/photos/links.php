<?php
echo elgg_view('output/url', array(
		'text' => elgg_echo('album:all'),
		'href' => 'photos/all',
		'class' => 'elgg-button elgg-button-action',
));

echo elgg_view('output/url', array(
		'text' => elgg_echo('tidypics:siteimagesall'),
		'href' => 'photos/siteimagesall',
		'class' => 'elgg-button elgg-button-action',
));

echo elgg_view('output/url', array(
		'text' => elgg_echo('tidypics:mostviewed'),
		'href' => 'photos/mostviewed',
		'class' => 'elgg-button elgg-button-action',
));
echo '<br>';