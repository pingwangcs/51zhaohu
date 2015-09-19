<?php
/**
 * File river view.
 */

$object = $vars['item']->getObjectEntity();
$excerpt = strip_tags($object->description);
$excerpt = wire_filter($excerpt);

$subject = $vars['item']->getSubjectEntity();
$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

$object_link = elgg_view('output/url', array(
	'href' => "wire/owner/$subject->username",
	'text' => elgg_echo('wire:wire'),
	'class' => 'elgg-river-object',
	'is_trusted' => true,
));

$summary = elgg_echo("river:create:object:wire", array($subject_link, $object_link));

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'message' => $excerpt,
	'summary' => $summary,
));