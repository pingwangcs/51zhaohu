<?php
$zhaohu = elgg_extract("entity", $vars);
if (!$zhaohu) {
	return;
}

$link = "<a class='elgg-button elgg-button-action' href='" . $zhaohu->getURL() . "'>" . elgg_echo("zhaohu:add_to_calendar") . "</a>";

$location = $zhaohu->location;

$start = date(ZHAOHU_MANAGER_FORMAT_DATE, $zhaohu->start_day) . " " . date('H:i', $zhaohu->start_time) . ":00";

if ($zhaohu->end_ts) {
	$end = date('Y-m-d H:i:00', $zhaohu->end_ts);
} else {
	$end_ts = mktime(date('H', $zhaohu->start_time), date('i', $zhaohu->start_time), 0,date('m', $zhaohu->start_day), date('d', $zhaohu->start_day), date('Y', $zhaohu->start_day));
	$end_ts = $end_ts + 3600;
	$end = date('Y-m-d H:i:00', $end_ts);
}

$title = $zhaohu->title;
$description = elgg_get_excerpt($zhaohu->description, 500);
$organizer = $zhaohu->getOwnerEntity()->name;

?>

<div id='addthisevent'>
<span class="addthisevent">
	<?php echo $link; ?>
	<div>
		<span class="_start"><?php echo $start; ?></span>
		<span class="_end"><?php echo $end; ?></span>
		<span class="_summary"><?php echo $title; ?></span>
		<span class="_description"><?php echo $description; ?></span>
		<span class="_location"><?php echo $location; ?></span>
		<span class="_organizer"><?php echo $organizer;?></span>
		<span class="_organizer_email">noreply</span>
		<span class="_date_format">YYYY-MM-DD</span>
	</div>
</span>
</div>

<?php
/*
<span class="_start">8-05-2012 11:38:46</span>
<span class="_end">8-05-2012 11:38:46</span>
<span class="_zonecode">35</span>
<span class="_summary">Summary of the event</span>
<span class="_description">Description of the event</span>
<span class="_location">Location of the event</span>
<span class="_organizer">Organizer</span>
<span class="_organizer_email">Organizer e-mail</span>
<span class="_facebook_event">http://www.facebook.com/events/160427380695693</span>
<span class="_all_day_event">true</span>
<span class="_date_format">DD/MM/YYYY</span>
 */