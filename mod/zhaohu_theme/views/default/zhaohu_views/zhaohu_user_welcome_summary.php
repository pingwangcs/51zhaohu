<?php
/**
 * zhaohu user welcome message summary view, the div contain user group summary info
* @uses user $vars['user'] the current logged in user
*/

$user = $vars['user'];
// $user->joined_groups = elgg_get_entities_from_relationship(array(
//  		'type' => 'group',
//  		'relationship' => 'member',
//  		'relationship_guid' => $user->guid,
//  		'inverse_relationship' => false,
//  		'count' => true,
// ));
// $user->save();
//for debug register_error('joined_groups '.$user->joined_groups);
$joined_group_number = empty($user->joined_groups) ? 0 : $user->joined_groups;

$state = empty($user->state)?'WA':$user->state;
if(!$_SESSION['_nearby_group'] || time()-$_SESSION['_nearby_timestamp']>ZHAOHU_SESSION_DATA_TTL) {
	$_SESSION['_nearby_group'] = getGroupsNearby($state, '', 0, 0, true) - countJoinedGroupsInState($user->guid, $state);
	$_SESSION['_nearby_timestamp'] = time();
}
$nearby_group_number = $_SESSION['_nearby_group'];

$joined_group_div = '<div class="zhaohu_user_welcome_group_number" id="zhuw_jg">' . $joined_group_number . '</div>';
$group_joined = '<div class="zhaohu_user_welcome_group_string">' . elgg_echo('zhgroups:joined_groups:p1') . $joined_group_div . elgg_echo('zhgroups:joined_groups:p2') . '</div>';

if($nearby_group_number > 0) {
	$nearby_group_div = '<div class="zhaohu_user_welcome_group_number" id="zhuw_nbg">' . $nearby_group_number . '</div>';
	$group_to_join = '<div class="zhaohu_user_welcome_group_string">' . elgg_echo('zhgroups:nearby_groups:p1') . $nearby_group_div . elgg_echo('zhgroups:nearby_groups:p2') . '</div>';
} else {
	$group_to_join = '';
}

echo '<div id="zhaohu_user_welcome_summary_div">' . $group_joined . $group_to_join . '</div>';

