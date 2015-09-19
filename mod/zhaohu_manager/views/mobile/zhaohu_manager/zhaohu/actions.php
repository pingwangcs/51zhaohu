<?php

	$zhaohu = $vars["entity"];

	$options = array();
	
	if ($zhaohu->status == 'published' && empty($zhaohu->buyButtonID)) {
		$rsvp = elgg_view("zhaohu_manager/zhaohu/rsvp", $vars);
		echo $rsvp;
	}

	$likes_opt = array(
			'name' => 'likes',
			'text' => elgg_view('likes/button', array('entity' => $zhaohu)),
			'href' => false,
			'priority' => 500,
	);
	echo elgg_view("output/url",$likes_opt);
	
	$likes_count = elgg_view('likes/count', array('entity' => $zhaohu));
	if ($likes_count) {
		$count_opt = array(
				'name' => 'likes_count',
				'text' => $likes_count,
				'href' => false,
				'priority' => 501,
		);
		echo elgg_view("output/url",$count_opt);
	}

if($vars["full"] && elgg_is_logged_in ()) {
	if ($zhaohu->buyButtonID && $zhaohu->payoption1name && $zhaohu->payoption1value){
		$payPart = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value= "'.$zhaohu->buyButtonID.'" >
<table>
<br><tr><td><input type="hidden" name="on0" value="Option"> 提前订票 </td></tr><tr><td><select name="os0">
<option value="Option 1">'.$zhaohu->payoption1name.' | '.$zhaohu->payoption1value.' USD</option>';
		if($zhaohu->payoption2name && $zhaohu->payoption2value){
			$payPart .='<option value="Option 2">'.$zhaohu->payoption2name.' | '.$zhaohu->payoption2value.' USD</option>';
		}
		$payPart .='</select> </td></tr>';		
		$payPart .= '<input type="hidden" name="custom" value="'.elgg_get_logged_in_user_guid().'-'.$zhaohu->guid.'">';
$payPart .= '</table>
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" class="paypal_btn">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>';
		echo $payPart;
	}
}
