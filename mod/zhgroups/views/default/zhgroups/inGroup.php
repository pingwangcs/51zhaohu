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

if (!empty($group) && ($group instanceof ElggGroup)) {
	$num_upcoming = $group->upcomingZh;
	$num_past = $group->pastZh;
}
?>
	<div id="zhaohu_group_left_info_bar">
		<div id="zhaohu_group_info" class="zhaohu-group-sidebar-div">
			<div class="groups-profile-icon">
				<?php
					// we don't force icons to be square so don't set width/height
					echo elgg_view_entity_icon($group, 'large', array(
						'href' => '',
						'width' => '',
						'height' => '',
					)); 
				?>
			</div>
			<p>
			<?php
				if($group->city && $group->state)
					echo $group->city . ", " . $group->state;
			?>
			</p>
			<p>
			<?php
				echo elgg_echo('zhgroups:date_created'). ": " . date("Y-m-d", $group->time_created);
			?>
			</p>						
			<p>
				<?php echo elgg_echo("zhgroups:founder") . ": " . $owner->name; ?><br>
				<?php
				echo elgg_view_entity_icon($owner, 'small', array(
						'width' => '',
						'height' => '',
				));
				?>
			</p>
			<p>
			<?php
				//echo elgg_echo('zhgroups:members') . ": " . $group->getMembers(0, 0, TRUE);
				// for now, score is the number of members
				echo elgg_echo('zhgroups:members') . ": " . $group->score;
			?>
			</p>
			<p>
			<?php
				$tags = $group->getTags();
				if($tags){
					echo elgg_view("output/tags", array('value' => $tags, 'list_class' => 'group-info-bar-tags'));
				}
			?>
			</p>
			<p>
			<?php
				echo elgg_echo('zhaohu:upcoming_zhaohus') . ": " . $num_upcoming;
			?>
			</p>
			<p>
			<?php
				echo elgg_echo('zhaohu:past_zhaohus') . ": " . $num_past;
			?>
			</p>
		</div>
		<div class="groups-profile-fields elgg-body zhaohu-group-description zhaohu-group-sidebar-div">
			<?php
				echo elgg_view("output/longtext", array('value' => $group->description));
			?>
		</div>
		<?php
			echo elgg_view("zhgroups/nearby", $vars);
		?>		
	</div>
	

