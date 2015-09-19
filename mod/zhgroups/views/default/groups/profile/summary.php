<?php
/**
 * Group profile summary
 *
 * Icon and profile fields
 *
 * @uses $vars['group']
 */

if (!isset($vars['entity']) || !$vars['entity']) {
	echo elgg_echo('groups:notfound');
	return true;
}

$group = $vars['entity'];
$owner = $group->getOwnerEntity();

if (!$owner) {
	// not having an owner is very bad so we throw an exception
	$msg = elgg_echo('InvalidParameterException:IdNotExistForGUID', array('group owner', $group->guid));
	throw new InvalidParameterException($msg);
}
//$group = elgg_get_page_owner_entity();
if (!empty($group) && ($group instanceof ElggGroup)) {
	$num_upcoming = countZhaohuForGroup($group->guid, false);
	$num_past = countZhaohuForGroup($group->guid, true) - $num_upcoming;
	$group->upcomingZh = $num_upcoming;
	$group->pastZh = $num_past;
	$group->save();
}
?>
<div class="groups-profile clearfix elgg-image-block zh-group-info-sidbar">
<?php
	echo elgg_view('zhgroups/inGroup', array("entity" => $group));
?>
	<div id="groups_zhaohus">
		<?php
			$form = elgg_view_form("groups/zhaohus", array(
				"id" => "groups_zhaohus_form",
				"class" => "elgg-form-alt mtm",
				"enctype" => "multipart/form-data"),array(
				"entity" => $group));
			echo $form;
		?>
	</div>	
</div>


