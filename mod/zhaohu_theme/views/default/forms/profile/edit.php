<?php
/**
 * Edit profile form
 *
 * @uses vars['entity']
 */
elgg_load_js("zhp.edit");
elgg_load_js("location");
?>
<div>
	<label><?php echo elgg_echo('name'); ?></label>
	<?php echo elgg_view('input/text', array('name' => 'name', 'value' => $vars['entity']->name)); ?>
</div>
<?php
$fieldsWithAccess=array("contactemail", "phone", "birthDay", "QQ");
$iDD = genTagDiv("zhp_interest_dd", "zhp-i-opt");

$sticky_values = elgg_get_sticky_values('profile:edit');

$profile_fields = elgg_get_config('profile_fields');
if (is_array($profile_fields) && count($profile_fields) > 0) {
	foreach ($profile_fields as $shortname => $valtype) {
		$metadata = elgg_get_metadata(array(
			'guid' => $vars['entity']->guid,
			'metadata_name' => $shortname,
			'limit' => false
		));
		if ($metadata) {
			if (is_array($metadata)) {
				$value = '';
				foreach ($metadata as $md) {
					if (!empty($value)) {
						$value .= ', ';
					}
					$value .= $md->value;
					$access_id = $md->access_id;
				}
			} else {
				$value = $metadata->value;
				$access_id = $metadata->access_id;
			}
		} else {
				$value = '';
			if($shortname=='contactemail' || $shortname=='phone' || $shortname=='address')
				$access_id = 0;//Private
			else
				$access_id = 1;//Logged in users
		}

		// sticky form values take precedence over saved ones
		if (isset($sticky_values[$shortname])) {
			$value = $sticky_values[$shortname];
		}
		if (isset($sticky_values['accesslevel'][$shortname])) {
			$access_id = $sticky_values['accesslevel'][$shortname];
		}

?>
<div>
	<label><?php echo elgg_echo("profile:{$shortname}") ?></label>
	<?php
		$params = array(
			'name' => $shortname,
			'value' => $value,
		);
		if($shortname == 'birthYear'){
			$params['options_values'] = zhgroups_date(2014, 1914);
		}
		if($shortname == 'birthMonth'){
			$params['options_values'] = zhgroups_date(1, 12);
		}
		if($shortname == 'birthDay'){
			$params['options_values'] = zhgroups_date(1, 31);
		}
		if($shortname == 'interests')
			$params['id'] = 'zhp_'.$shortname;
		if($shortname == 'gender')
			$params['options_values'] = array('female' => elgg_echo('profile:female'), 'male' => elgg_echo('profile:male'));
		if($shortname == 'country'){
			$params['id'] = 'zh_country';
			if($value == '')
				$params['value'] = 'US';
			$params['options_values'] = array('CA' => elgg_echo('can'), 'US' => elgg_echo('usa'));
		}
		if($shortname == 'state'){
			$params['id'] = 'zh_state';
			echo elgg_view('input/hidden', array('id' => 'zh_state_val','value' => $value));
		}
		echo elgg_view("input/{$valtype}", $params);
		if($shortname == 'interests')
			echo $iDD;
		$params = array(
			'name' => "accesslevel[$shortname]",
			'value' => $access_id,
		);
		if(in_array($shortname, $fieldsWithAccess))
			echo elgg_view('input/access', $params);
		if($shortname=='address'){
			$acc_address = array('class' => "elgg-input-access",
				'disabled' => false,
				'name' => "accesslevel[$shortname]",
				'value' => $access_id,
				'options_values' => array( ACCESS_PRIVATE => elgg_echo("PRIVATE"),ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN")));
			if ($access_id == ACCESS_DEFAULT)
				$acc_address['value'] = get_default_access();
			echo elgg_view('input/dropdown', $acc_address);
		}
	?>
</div>
<?php
	}
}

elgg_clear_sticky_form('profile:edit');

?>
<div class="elgg-foot">
<?php
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['entity']->guid));
	echo elgg_view('input/submit', array('value' => elgg_echo('save')));
	echo elgg_view('output/url', array(
			'text' => elgg_echo('cancel'),
			'href' => $vars['entity']->getURL(),
			'class' => 'elgg-button elgg-button-cancel',
	));
?>
</div>
