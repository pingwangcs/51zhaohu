<?php
class Coupon extends ElggObject {
	const SUBTYPE = "coupon";

	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes["subtype"] = self::SUBTYPE;
	}

	public static function gen($user, $event) {
		$result = false;
		$coupon = new Coupon();
		$code = Coupon::genCode(COUPON_CODE_LEN);
		if($code==null){
			elgg_log("ZHError ,Coupon::gen, genCode failed, zhaohu_id {$event->guid} logged_user_id "
			.elgg_get_logged_in_user_guid(), "ERROR");
			return $result;
		}
		$coupon->used = false;
		$coupon->code = $code;
		$coupon->user_guid = $user->guid;
		$coupon->event_guid = $event->guid;
		//$coupon->owner_guid = $user->guid;
		$coupon->count = 0;
		$coupon->save();
		return true;
		//for test
		//notifyOnCoupon($user, $event, $coupon, $group);
	}
	
	public function delete(){
		$result = false;
		$event = get_entity($this->event_guid);
		$result = remove_entity_relationship($this->event_guid, ZHAOHU_MANAGER_RELATION_ATTENDING, $this->user_guid);
		if(!$result){
			elgg_log("ZHError ,coupon:delete, failed to remove_entity_relationship, coupon_id {$this->guid}", "ERROR");
			return false;
		}
		parent::delete();
		return true;
	}

	public function isUsed(){
		return $this->used;
	}
	
	public function useCoupon(){
		$this->count ++;
		$this->used = true;
	}
	
	public static function try_get_coupon_for_event($event_guid){
		$options = array (
				'count_only' => true,
				'event_guid' => $event_guid,
				'offset' => 0,
				'limit' => 0,
		);
		$res = zh_find_coupons($options);
		return $res['count']>0;
	}
	
	private static function genCode($length = 4){
		$count = 0;
		while($count<COUPON_CODE_TRIES){
			$code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $length);
			if(!Coupon::try_get_coupon_by_code($code)){
				return $code;
			}
		}
		return null;
	}
	
	private static function try_get_coupon_by_code($code){
		$options = array (
				'count_only' => true,
				'code' => $code,
				'offset' => 0,
				'limit' => 0,
		);
		$res = zh_find_coupons($options);
		return $res['count']>0;
	}

}
