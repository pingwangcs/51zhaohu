<?php
/**
 * Full view of an image
 *
 * @uses $vars['entity'] TidypicsImage
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$image = $photo = $vars['entity'];
$album = $image->getContainerEntity();

$img = elgg_view_entity_icon($image, 'large', array(
	'href' => $image->getIconURL('master'),
	'img_class' => 'tidypics-photo',
	'link_class' => 'tidypics-lightbox',
));

$owner_link = elgg_view('output/url', array(
	'href' => $photo->getOwnerEntity()->getURL(),
	'text' => $photo->getOwnerEntity()->name,
));
$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($image->time_created);

$owner_icon = elgg_view_entity_icon($photo->getOwnerEntity(), 'tiny');

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'photos',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date";

$params = array(
	'entity' => $photo,
	'title' => false,
	'metadata' => $metadata,
	'subtitle' => $subtitle,
	'tags' => $tags,
);
$list_body = elgg_view('object/elements/summary', $params);

$params = array('class' => 'mbl');
$summary = elgg_view_image_block($owner_icon, $list_body, $params);

echo $summary;

echo '<div class="tidypics-photo-wrapper center">';
if ($album->getSize() > 1) {
	echo elgg_view('object/image/navigation', $vars);
}
echo elgg_view('photos/tagging/help', $vars);
echo elgg_view('photos/tagging/select', $vars);
echo $img;
echo elgg_view('photos/tagging/tags', $vars);
echo '</div>';

if ($photo->description) {
	echo elgg_view('output/longtext', array(
		'value' => $photo->description,
		'class' => 'mbl',
	));
}

echo elgg_view_comments($photo);
