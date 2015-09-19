<?php
$entity = $vars["entity"];
$siteUrl = elgg_get_site_url();

echo '<div id="zhaohu_operations" class="zhaohu-group-sidebar-div">';
echo '<div id="zhaohu_operations_header">';
echo elgg_echo("zhaohu:operations:header");
echo "</div>";

echo elgg_view("output/url",
		array('class' => 'zhaohu-action',
				"href" => "zhaohus/zhaohu/edit/" . $entity->getGUID(),
				"text" => elgg_echo('edit')));

$href = $siteUrl . "action/zhaohu_manager/zhaohu/publish?guid=" . $entity->getGUID();
$href = elgg_add_action_tokens_to_url($href);

echo elgg_view("output/confirmlink",
		array("is_action" => true,
				'class' => 'zhaohu-action',
				'confirm' => elgg_echo('zhaohu:publishwarning'),
				"href" => $href,
				"text" => elgg_echo('publish')));

$href = $siteUrl . "action/zhaohu_manager/zhaohu/cancel?guid=" . $entity->getGUID();
$href = elgg_add_action_tokens_to_url($href);

echo elgg_view("output/confirmlink",
		array("is_action" => true,
				'class' => 'zhaohu-action',
				'confirm' => elgg_echo('zhaohu:cancelwarning'),
				"href" => $href,
				"text" => elgg_echo('cancel')));

$href = $siteUrl . "action/zhaohu_manager/zhaohu/delete?guid=" . $entity->getGUID();
$href = elgg_add_action_tokens_to_url($href);

echo elgg_view("output/confirmlink",
		array("is_action" => true,
				'class' => 'zhaohu-action',
				'confirm' => elgg_echo('zhaohu:deletewarning'),
				"href" => $href,
				"text" => elgg_echo('delete')));

if ($entity->status == 'published') {
	$bc_href = $siteUrl . "zhaohus/zhaohu/broadcast?guid=" . $entity->getGUID();
	echo elgg_view("output/url",
			array('class' => 'zhaohu-action',
					"href" => $bc_href,
					"text" => elgg_echo('zhaohu:broadcast')));	
}
//check if group admin
// $group = $entity->getContainerEntity();
// if ($group->canEdit()){}

if(elgg_is_admin_logged_in()) {
	$href = $siteUrl . "zhaohus/zhaohu/coupons?guid=" . $entity->getGUID();
	echo elgg_view("output/url",
			array('class' => 'zhaohu-action',
					"href" => $href,
					"text" => elgg_echo('coupon:view')));
	
	$href = $siteUrl . "zhaohus/zhaohu/usecoupon?guid=" . $entity->getGUID();
	echo elgg_view("output/url",
			array('class' => 'zhaohu-action',
					"href" => $href,
					"text" => elgg_echo('coupon:use')));
	
	$href = $siteUrl . "action/coupons/gen?guid=" . $entity->getGUID();
	$href = elgg_add_action_tokens_to_url($href);
	echo elgg_view("output/url",
			array('class' => 'zhaohu-action',
					"href" => $href,
					"text" => elgg_echo('coupon:gen')));
	
	$href = $siteUrl . "action/coupons/send?guid=" . $entity->getGUID();
	$href = elgg_add_action_tokens_to_url($href);
	echo elgg_view("output/url",
			array('class' => 'zhaohu-action',
					"href" => $href,
					"text" => elgg_echo('coupon:send')));
	
	if($entity->featured_zh == "y") {
		$f_href = $siteUrl . "action/zhaohu_manager/zhaohu/feature?guid={$entity->guid}&action_type=unfeature";
		$f_text = elgg_echo('zhaohu:unfeature');
	} else {
		$f_href = $siteUrl . "action/zhaohu_manager/zhaohu/feature?guid={$entity->guid}&action_type=feature";
		$f_text = elgg_echo('zhaohu:feature');		
	}
	
	$f_href = elgg_add_action_tokens_to_url($f_href);
	echo elgg_view("output/url",
			array("is_action" => true,
					'class' => 'zhaohu-action',
					"href" => $f_href,
					"text" => $f_text));	
}

echo "</div>";