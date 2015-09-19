<?php
	// generate a div which includes all the social media follow up links
	
	$header_title = elgg_echo("zhaohu:follow_us");
	$content = "<div id='zhaohu_homepage_follow_us' class='zhaohu-homepage-right-sidebar-div'>";
	$content .= "<div id='zhaohu_homepage_follow_us_header' class='zhaohu-homepage-right-sidebar-div-header'>$header_title</div>";
	$content .= "<div id='zhaohu_homepage_follow_us_content' class='zhaohu-homepage-right-sidebar-div-content'>";
	$content .= '<ul id="zhaohu_homepage_follow_us_list">';
	$site_url = elgg_get_site_url();

	$social_medias = array(
			array("image" => "fb.png", "url" => "https://www.facebook.com/51zhaohu"),
			array("image" => "twitter.png", "url" => "https://twitter.com/51zhaohu"),
			array("image" => "sina_weibo.png", "url" => "http://www.weibo.com/u/5360144513?topnav=1&wvr=6&topsug=1"),
// 			array("image" => "tengxun_weibo.png", "url" => "http://www.weibo.com"),
			array("image" => "youtube.png", "url" => "https://www.youtube.com/channel/UCHoX0-P-STtjC_QFuxHxEBA"),
			array("image" => "linkedin.png", "url" => "https://www.linkedin.com/company/51zhaohu-51%E6%8B%9B%E5%91%BC%EF%BC%89"),
			array("image" => "google_plus.png", "url" => "https://plus.google.com/107568181588466061304")
			);

	foreach ($social_medias as $social_media){
		$image_url = $site_url . "mod/zhaohu_theme/images/" . $social_media["image"];
		$url = $social_media["url"];
		$image_content = "<img class='zhaohu-social-media-icon' src='" . $image_url . "'/>";
		$content .= "<li class='zhaohu-homepage-social-media'>" . elgg_view("output/url", array("href" => $url, "text" => $image_content)) . "</li>";
	}
	$content .= "</ul>";
	$content .= "</div>";
	$content .= "</div>";
	echo $content;