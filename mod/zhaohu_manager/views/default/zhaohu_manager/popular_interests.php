<?php
	// generate a ul here including all the popular interests
	$default_interests = array("Holiday", "Games", "Students", "Outdoor", "Dating", "Pets", "Travel");
	$interests =  elgg_extract("interests", $vars, $default_interests);
	
	$header_title = elgg_echo("zhaohu:popular_interests");
	$content = "<div id='zhaohu_popular_interests' class='zhaohu-homepage-left-sidebar-div'>";
	$content .= "<div id='zhaohu_popular_interests_header'>$header_title</div>";
	$content .= "<div id='zhaohu_popular_interests_listing'>";
	$content .= '<ul id="zhaohu_homepage_popular_interests_list">';
	$site_url = elgg_get_site_url();
	
	$right_arrow_url =  $site_url . "mod/zhaohu_theme/images/arrow-right.png";
	foreach ($interests as $interest){
		$li_content = elgg_echo($interest) . "<img src='" . $right_arrow_url . "'/>";
		$content .= "<li class='zhaohu-homepage-popular-interest'>" . elgg_view("output/url", array("href" => "#", "text" => $li_content, "class"=>"popular-tag-item")) . "</li>";
	}
	$content .= "</ul>";
	$content .= "</div>";
	$content .= "</div>";
	echo $content;