<?php
// newest users
$users = elgg_list_entities(array(
	'type' => 'user',
	'subtype'=> null,
	'full_view' => FALSE
));

function event_add_featured_no($event) {
// 	register_error("event id {$event->guid}");
// 	return true;
	if($event->featured_zh == "y")
		return true;
	$event->featured_zh = "n";
	return $event->save();
}

$previous_access = elgg_set_ignore_access(true);
$options = array(
		'type' 			=> 'object',
		'subtype' 		=> 'zhaohu',
		'limit' => 0,
);
$batch = new ElggBatch('elgg_get_entities', $options, 'event_add_featured_no', 100);
elgg_set_ignore_access($previous_access);

if ($batch->callbackResult) {
	register_error("Elgg Groups upgrade (feature) succeeded");
} else {
	register_error("Elgg Groups upgrade (feature) failed");
}


?>



<div class="elgg-module elgg-module-inline">
	<div class="elgg-head">
		<h3><?php echo elgg_echo('admin:users:newest'); ?></h3>
	</div>
	<div class="elgg-body">
		<?php echo $users; ?>
	</div>
</div>
