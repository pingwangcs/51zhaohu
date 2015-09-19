<?php
/*
 * Zhaohu about us page
 */

$title = elgg_echo("zhaohu:about_us");
$site_url = elgg_get_site_url();
$logo_url =  $site_url . "mod/zhaohu_theme/images/logo_hand.png";

$content = '<div class="zhaohu-zhaohu-about">';

$content .= '<div class="zhaohu-zhaohu-about-video">';
$content .= '<iframe width="80%" height="315" src="//www.youtube.com/embed/G7cqecuaxOM" frameborder="0" allowfullscreen></iframe>';
$content .= '</div>';


$content .= '<div class="zhaohu-zhaohu-about-text">';
$content .= "<p>51Zhaohu®旨在提供北美华人活动资讯，让居住在北美的华人或者说中文的人找到有共同兴趣的伙伴，并通过各类线下活动来与伙伴们进行交流互动。无论你想要自己在当地组建一个新的朋友圈，还是加入当地一个已经组建好并且经常举办聚会的朋友圈，51Zhaohu®都可以让这些变得易如反掌。</p>";
$content .= "<p>51Zhaohu®希望能够通过推动北美各地的华人自愿自发地组织各类线下活动来提高当地华人之间的亲密度以及振兴当地华人团体的活力。51Zhaohu®相信所有留美的华人都可以通过创建和发展各类以不同兴趣为主题的朋友圈来提高个人的生活质量，对当地的华人社区产生正面的影响，甚至对整个北美华人社区的发展产生积极的推动作用。</p>";
$content .= '</div></div>';

$vars = array(
	'content' => $content,
);

$body = elgg_view_layout('one_column', $vars);

echo elgg_view_page($title, $body);