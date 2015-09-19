<?php
/**
 * Wire add form body
 *
 * @uses $vars['post']
 */
elgg_load_js('elgg.wire');
if (!isset($vars['entity_guid']) && !isset($vars['post_guid'])) {
	register_error("wire:add:input:invalid");
	return;
}

$post_guid = elgg_extract('post_guid', $vars);
$post = get_entity($post_guid);

$text = elgg_echo('post');
if ($post) {
	$text = elgg_echo('wire:reply');
	$event_guid = $post->entity_guid;
} else {
	$event_guid = $vars['entity_guid'];
}

if ($post) {
	echo elgg_view('input/hidden', array(
		'name' => 'parent_guid',
		'value' => $post->guid,
	));
	$add_id = $post->guid;
} else {
	$add_id = "new";
}

echo elgg_view('input/plaintext', array(
	'name' => 'body',
	'class' => 'mtm wire-textarea',
	'id' => "wire-textarea-{$add_id}",
));
?>
<div class="wire-overmax" id="wire-overmax-<?php echo $add_id?>">
</div>

<div class="elgg-foot mts">
<?php

echo elgg_view('input/submit', array(
	'value' => $text,
	'class' => 'elgg-button-submit wire-submit',
	'id' => "wire-submit-{$add_id}",
));
echo elgg_view('input/hidden', array(
		'name' => 'entity_guid',
		'value' => $event_guid,
));
?>
</div>