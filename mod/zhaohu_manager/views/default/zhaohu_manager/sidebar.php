<?php
$newBtn = '';
if(($page_owner = elgg_get_page_owner_entity()) && ($page_owner instanceof ElggGroup)){
	group_gatekeeper();

	if($page_owner->canEdit()){
		$newBtn = elgg_view("output/url",
				array("is_action" => true,
						'class' => 'zhaohu-action',
						"href" => "zhaohus/zhaohu/new/" . $page_owner->getGUID(),
						"text" => elgg_echo('zhaohu:new')));		
	}
} elseif(elgg_is_logged_in()) {
	$newBtn = elgg_view("output/url",
			array("is_action" => true,
					'class' => 'zhaohu-action',
					"href" => "zhaohus/zhaohu/new",
					"text" => elgg_echo('zhaohu:new')));	
	}
	
$zhaohus = elgg_get_entities_from_metadata(array(
		'metadata_name' => 'featured_zh',
		'metadata_value' => 'y',
		'limit' => 4,
));
elgg_push_context("sidebar");
$content = elgg_view_entity_list($zhaohus, array("offset" => 0, "pagination" => false, "full_view" => false));
elgg_pop_context("sidebar");



if(empty($content)){
	$content = elgg_echo("notfound");
}


echo <<<HTML

<div>
$newBtn
<br><br>
<h2>Zhaohus we recommend</h2>
<div class="profile-owner-icon">
	$content
</div>
</div>

HTML;
