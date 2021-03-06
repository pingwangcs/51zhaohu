<?php
/**
 * Group edit form
 * 
 * @package ElggGroups
 */

// only extract these elements.
$name = $membership = $vis = $entity = null;
extract($vars, EXTR_IF_EXISTS);
elgg_load_js("zhgroups.edit");
elgg_load_js("location");
?>
<div>
	<label><?php echo elgg_echo("groups:icon"); ?></label><br />
	<?php echo elgg_view("input/file", array('name' => 'icon')); ?>
</div>
<div>
    <!-- group name is required in group edit page -->
	<label><?php echo elgg_echo("groups:name") . "*"; ?></label><br />
	<?php echo elgg_view("input/text", array(
		'name' => 'name',
		'value' => $name
	));
	?>
</div>
<?php

$iDD = genTagDiv("zhge_i_dd", "zhge-i-opt");
$group_profile_fields = elgg_get_config('group');
if ($group_profile_fields > 0) {
	foreach ($group_profile_fields as $shortname => $valtype) {
		$line_break = '<br />';
		if ($valtype == 'longtext') {
			$line_break = '';
		}
		echo '<div><label>';
		echo elgg_echo("groups:{$shortname}");
		if ($shortname == 'interests')  // interests is required in group edit page
			echo "*";
		echo "</label>$line_break";
		$value = elgg_extract($shortname, $vars);
		$opt = array(
			'name' => $shortname,
			'value' => $value
		);
		if($shortname == 'interests')
			$opt['id'] = 'zhge_'.$shortname;
		
		if($shortname == 'country'){
			$opt['id'] = 'zh_country';
			if($value == '')
				$opt['value'] = 'US';
			$opt['options_values'] = array('CA' => elgg_echo('can'), 'US' => elgg_echo('usa'));
		}
		if($shortname == 'state'){
			$opt['id'] = 'zh_state';
			echo elgg_view('input/hidden', array('id' => 'zh_state_val','value' => $value));
		}

		echo elgg_view("input/{$valtype}", $opt);
		if($shortname == 'interests')
			echo $iDD;
		
		echo '</div>';
	}
}

echo elgg_view('input/hidden', array(
		'name' => 'membership',
		'value' => ACCESS_PUBLIC,
	));
?>
<!--
<div>
	<label>
		<?php echo elgg_echo('groups:membership'); ?><br />
		<?php echo elgg_view('input/dropdown', array(
			'name' => 'membership',
			'value' => $membership,
			'options_values' => array(
				ACCESS_PRIVATE => elgg_echo('groups:access:private'),
				ACCESS_PUBLIC => elgg_echo('groups:access:public')
			)
		));
		?>
	</label>
</div> -->
	
<?php

if (elgg_get_plugin_setting('hidden_groups', 'groups') == 'yes') {
	$access_options = array(
		ACCESS_PRIVATE => elgg_echo('groups:access:group'),
		ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"),
		ACCESS_PUBLIC => elgg_echo("PUBLIC")
	);
?>

<div>
	<label>
			<?php echo elgg_echo('groups:visibility'); ?><br />
			<?php echo elgg_view('input/access', array(
				'name' => 'vis',
				'value' =>  $vis,
				'options_values' => $access_options,
			));
			?>
	</label>
</div>

<?php 	
}

if (isset($vars['entity'])) {
	$entity     = $vars['entity'];
	$owner_guid = $vars['entity']->owner_guid;
} else {
	$entity = false;
}

if ($entity && ($owner_guid == elgg_get_logged_in_user_guid() || elgg_is_admin_logged_in())) {
	$members = array();

	$options = array(
		'relationship' => 'member',
		'relationship_guid' => $vars['entity']->getGUID(),
		'inverse_relationship' => true,
		'type' => 'user',
		'limit' => 0,
	);

	$batch = new ElggBatch('elgg_get_entities_from_relationship', $options);
	foreach ($batch as $member) {
		$members[$member->guid] = "$member->username";
	}
?>

<div>
	<label>
			<?php echo elgg_echo('groups:owner'); ?><br />
			<?php echo elgg_view('input/dropdown', array(
				'name' => 'owner_guid',
				'value' =>  $owner_guid,
				'options_values' => $members,
				'class' => 'groups-owner-input',
			));
			?>
	</label>
	<?php
	if ($owner_guid == elgg_get_logged_in_user_guid()) {
		echo '<span class="elgg-text-help">' . elgg_echo('groups:owner:warning') . '</span>';
	}
	?>
</div>

<?php	
}
/*
$tools = elgg_get_config('group_tool_options');
if ($tools) {
	usort($tools, create_function('$a,$b', 'return strcmp($a->label,$b->label);'));
	foreach ($tools as $group_option) {
		$group_option_toggle_name = $group_option->name . "_enable";
		$value = elgg_extract($group_option_toggle_name, $vars);
?>
<div>
	<label>
		<?php echo $group_option->label; ?><br />
	</label>
		<?php echo elgg_view("input/radio", array(
			"name" => $group_option_toggle_name,
			"value" => $value,
			'options' => array(
				elgg_echo('groups:yes') => 'yes',
				elgg_echo('groups:no') => 'no',
			),
		));
		?>
</div>
<?php
	}
}*/
?>
<div class="elgg-foot">
<?php

echo elgg_view('input/submit', array('value' => elgg_echo('save')));
if ($entity) {
	echo elgg_view('input/hidden', array(
			'name' => 'group_guid',
			'value' => $entity->getGUID(),
	));
	$cancelURL = $entity->getURL();
} else {
	$cancelURL = elgg_get_site_url();
}

echo elgg_view('output/url', array(
	'text' => elgg_echo('cancel'),
	'href' => $cancelURL,
	'class' => 'elgg-button elgg-button-cancel',
));

if ($entity) {
	$delete_url = 'action/groups/delete?guid=' . $entity->getGUID();
	echo elgg_view('output/confirmlink', array(
		'text' => elgg_echo('groups:delete'),
		'href' => $delete_url,
		'confirm' => elgg_echo('groups:deletewarning'),
		'class' => 'elgg-button elgg-button-delete float-alt',
	));
}
?>
</div>
