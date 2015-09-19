<?php
/**
 * Album sorting view
 */

$album = $vars['album'];
$image_guids = $album->getImageList();

echo '<div>';
echo elgg_echo('tidypics:sort:instruct');
echo '</div>';

echo '<div>';
echo elgg_view('input/hidden', array('name' => 'guids'));
echo elgg_view('input/hidden', array('name' => 'album_guid', 'value' => $album->guid));
echo elgg_view('input/submit', array('value' => elgg_echo('save')));
echo elgg_view('output/url', array(
'text' => elgg_echo('cancel'),
'href' => $album->getURL(),
'class' => 'elgg-button elgg-button-cancel',
));
echo '</div>';

echo '<div class="elgg-foot">';
echo '<ul id="tidypics-sort" class="elgg-gallery">';
foreach ($image_guids as $image_guid) {
	$image = get_entity($image_guid);
	$img = elgg_view('output/img', array(
		'src' => $image->getIconURL(),
	));
	echo "<li class=\"mam\" id=\"$image_guid\">$img</li>";
}
echo '</ul>';
