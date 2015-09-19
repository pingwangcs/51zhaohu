<?php
/**
 * View conversation thread
 */

$thread_id = get_input('thread_id');
$post = get_entity($thread_id);
if(!$post){
	//putlog
	forward(REFERER);
}
$orig_entity = get_entity($post->entity_guid);
if(!$orig_entity){
	//putlog
	forward(REFERER);
}

$title = elgg_echo('wire:thread');
$name = elgg_echo('wire:thread:name', array($orig_entity->getURL(), $orig_entity->title));

$content = elgg_list_entities_from_metadata(array(
	"metadata_name" => "wire_thread",
	"metadata_value" => $thread_id,
	"type" => "object",
	"subtype" => "wire",
	"limit" => WIRE_POST_LIMIT,
));

// $body = elgg_view_layout('content', array(
// 	'filter' => false,
// 	'content' => $content,
// 	'title' => $title,
// ));

if(elgg_get_viewtype() == 'default'){
	$group = $orig_entity->getContainerEntity();
	$body = elgg_view('zhgroups/group_header', array("group" => $group));
	
	$body .= elgg_view('zhgroups/inGroupContent', array(
			'filter' => false,
			'content' => $content,
			'title' => $name,
			'group' => $group,
	));
} else {
	$body = elgg_view_layout('one_column', array(
			'content' => $content,
			'title' => $name,
	));
}

echo elgg_view_page($title, $body);
