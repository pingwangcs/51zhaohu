<?php
//$type: 0 - join, 1 - leave, 2 - create and join, 3 - delete and leave
function updateNearbyGroupCache($user, $group, $type){
	if($user == elgg_get_logged_in_user_entity() && isset($_SESSION['_nearby_group'])) {
		$userState = empty($user->state)?'WA':$user->state;
		if($userState == $group->state){
			switch ($type){
				case 0:
					$_SESSION['_nearby_group'] = $_SESSION['_nearby_group']-1; break;
				case 1:
					$_SESSION['_nearby_group'] = $_SESSION['_nearby_group']+1; break;
			}		
		}
	}
}

function updateJoinedGroupsForDeletion($group){
	$members = $group->getMembers();
	foreach($members as $user){
		$user->joined_groups --;
		$user->save();
	}	
}
