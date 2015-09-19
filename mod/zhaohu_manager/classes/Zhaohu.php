<?php
class Zhaohu extends ElggObject {

		const SUBTYPE = "zhaohu";
				
		protected function initializeAttributes() {
			parent::initializeAttributes();
			
			$this->attributes["subtype"] = self::SUBTYPE;
		}
		
		public function openForRegistration() {
			$result = true;
			/*
			if ($this->registration_ended || (!empty($this->endregistration_day) && $this->endregistration_day < time())) {
				$result = false;
			}*/
				
			return $result;
		}
		
		public function isPast() {
			return $this->end_ts < mktime(0, 0, 0);
		}
		
		public function isCouponExpired(){
			return $this->coupon_end_ts && $this->coupon_end_ts < mktime(0, 0, 0);
		}
		
		public function hasSpotsLeft()	{
			$result = false;
				
			if($this->max_attendees != '') {
				$attendees = $this->countAttendees();
		
				if (($this->max_attendees > $attendees)) {
					$result = true;
				}
			} else {
				$result = true;
			}
				
			return $result;
		}

		public function hasEnoughCouponers()	{
			$result = false;
		
			if($this->has_coupon == 1 && !empty($this->min_attendees)) {
				$num = $this->countAttendees();
		
				if ($num >= $this->min_attendees) {
					$result = true;
				}
			} else {
				$result = true;
			}
		
			return $result;
		}
		/**
		 * Return a list of this group's members.
		 *
		 * @param int  $group_guid The ID of the container/group.
		 * @param int  $limit      The limit
		 * @param int  $offset     The offset
		 * @param int  $site_guid  The site
		 * @param bool $count      Return the users (false) or the count of them (true)
		 *
		 * @return mixed
		 */
		public function getAttendees($limit = ATTENDEE_IN_ZHAOHU_LIMIT, $offset = 0) {
			$old_ia = elgg_set_ignore_access(true);
				
			$entities = elgg_get_entities_from_relationship(array(
					'relationship' => ZHAOHU_MANAGER_RELATION_ATTENDING,
					'relationship_guid' => $this->getGUID(),
					'inverse_relationship' => FALSE,
					//'site_guids' => false,
					'limit' => $limit,
					'offset' => $offset,
			));
				
			elgg_set_ignore_access($old_ia);
				
			return $entities;
		}

		public function countAttendees($count = true) {
			$old_ia = elgg_set_ignore_access(true);
		
			$entities = elgg_get_entities_from_relationship(array(
					'relationship' => ZHAOHU_MANAGER_RELATION_ATTENDING,
					'relationship_guid' => $this->getGUID(),
					'inverse_relationship' => FALSE,
					//'site_guids' => false,
					'count' => $count
			));
		
			elgg_set_ignore_access($old_ia);
		
			return $entities;
		}
				
		public function getRelationshipByUser($user_guid = null) {
			$result = false;
				
			$user_guid = (int)$user_guid;
			if (empty($user_guid)) {
				$user_guid = elgg_get_logged_in_user_guid();
			}
				
			$zhaohu_guid = $this->getGUID();
				
			$row = get_data_row("SELECT * FROM " . elgg_get_config("dbprefix") . "entity_relationships WHERE guid_one=$zhaohu_guid AND guid_two=$user_guid");
			if ($row){
				$result = $row->relationship;
			}
			return $result;
		}
		

		public function getRelationships($count = false) {
			$result = false;
				
			$zhaohu_guid = $this->getGUID();
				
			if ($count){
				$query = "SELECT relationship, count(*) as count FROM " . elgg_get_config("dbprefix") . "entity_relationships WHERE guid_one=$zhaohu_guid GROUP BY relationship ORDER BY relationship ASC";
			} else {
				$query = "SELECT * FROM " . elgg_get_config("dbprefix") . "entity_relationships WHERE guid_one=$zhaohu_guid ORDER BY relationship ASC";
			}
				
			$all_relations = get_data($query);
				
			if (!empty($all_relations)) {
				$result = array("total" => 0);
				foreach ($all_relations as $row) {
					$relationship = $row->relationship;
						
					if ($count){
						$result[$relationship] = $row->count;
						$result["total"] += $row->count;
					} else {
						if (!array_key_exists($relationship, $result)) {
							$result[$relationship] = array();
						}
						$result[$relationship][] = $row->guid_two;
					}
				}
			}
				
			return $result;
		}
		
		public function rsvp($type = ZHAOHU_MANAGER_RELATION_UNDO, $user_guid = 0, $add_to_river = true) {
			$result = false;
			if($this->status == 'cancelled')
			{
				system_message(elgg_echo('zhaohu:rsvp:cancelled'));
				return $result;
			}
				
			$user_guid = sanitise_int($user_guid, false);
				
			if (empty($user_guid)) {
				$user_guid = elgg_get_logged_in_user_guid();
			}
				
			if (!empty($user_guid)) {
				$zhaohu_guid = $this->getGUID();
		
				// remove current relationships
				delete_data("DELETE FROM " . elgg_get_config("dbprefix") . "entity_relationships WHERE guid_one=$zhaohu_guid AND guid_two=$user_guid");
		
				// remove river
				if (get_entity($user_guid) instanceof ElggUser) {
					$params = array(
							"subject_guid" => $user_guid,
							"object_guid" => $zhaohu_guid,
							//"action_type" => "zhaohu_attending"
					);
					elgg_delete_river($params);
				}
		
				// add the new relationship
				if ($type && ($type != ZHAOHU_MANAGER_RELATION_UNDO) && (in_array($type, zhaohu_manager_zhaohu_get_relationship_options()))) {
					if ($result = $this->addRelationship($user_guid, $type)) {
						if ($add_to_river){
							if (get_entity($user_guid) instanceof ElggUser) {
								// add river zhaohus
								if (($type != "zhaohu_waitinglist") && ($type != "zhaohu_pending")) {
									add_to_river('river/zhaohu_relationship/create', $type, $user_guid, $zhaohu_guid);
								}
							}
						}
						$this->notifyOnRsvp($type, $user_guid);
					}
				} else {
					$result = true;
				}
		
				//if ($this->notify_onsignup && ($type !== ZHAOHU_MANAGER_RELATION_ATTENDING_PENDING)) {
				//	$this->notifyOnRsvp($type, $user_guid);
				//}
			}
				
			return $result;
		}

		public function getURL() {
			return elgg_get_site_url() . "zhaohus/zhaohu/view/" . $this->getGUID() . "/" . elgg_get_friendly_title($this->title);
		}
		
		public function getIcon($size = "medium", $icontime = 0) {
			if (!in_array($size, array('small','medium','large','tiny','master','topbar'))) {
				$size = 'medium';
			}				
			$icontime = $this->icontime;

			if($icontime) {
				return elgg_get_site_url() ."zhaohu_icon/$this->guid/$size.jpg";
			} else {
				$icon = pickZhaohuIcon($this);
				return elgg_get_site_url() . "mod/myicon/icon.php?size=$size&icon={$icon}";
			}
		}
		
		public function notifyOnRsvp($type, $user_guid) {
			//$ia = elgg_set_ignore_access(true);
			$user = get_entity($user_guid);
			$group = get_entity($this->container_guid);
			$owner = get_entity($this->getOwnerGUID());
			
			// notify the onwer of the zhaohu
			$owner_subject = elgg_echo('zhaohu:rsvp:owner:subject', array($user->name, $this->title));
	
			$owner_message = '<div style="color:#333;font-size:16px;padding-bottom: 20px;">' . elgg_echo('zhaohu:rsvp:owner:body', array(
					$owner->name,
					$user->getURL(),
					$user->name,
					$this->getURL(),
					$this->title)).'</div>';
	
			zhgroups_send_email_to_user($group, $owner, $owner_subject, $owner_message, true, true);
						
			//elgg_set_ignore_access($ia);
		}
}