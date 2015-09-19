<?php
$header_title = elgg_echo("zhaohu:hot_topics");
$content = "<div id='zhaohu_hot_topics' class='zhaohu-homepage-left-sidebar-div'>";
$content .= "<div id='zhaohu_hot_topics_header'>$header_title</div>";
$site_url = elgg_get_site_url();
$image_url = $site_url . "mod/zhaohu_theme/images/vday_video.jpg";
$image_content = "<img class='zhaohu-hot-topics-icon' src='" . $image_url . "'/>";

$url = $site_url . "zhaohus/zhaohu/view/1509";
$content .= elgg_view("output/url", array("href" => $url, "text" => $image_content));

$content .= "</div>";
echo $content;