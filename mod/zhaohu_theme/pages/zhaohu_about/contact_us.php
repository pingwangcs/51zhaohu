<?php
/*
 * Zhaohu help center page
 */

$title = elgg_echo("zhaohu:contact_us");
$content = '<div id="zhaohu_contact_us">';
$content .= '<div id="zhaohu_contact_us_details">';
$content .= '<p class="zhaohu-contact-us-head">' . elgg_echo("zhaohu:contact_us") . '</p>';
$content .= '<br>QQ: 1723449376';
$content .= '<br>Facebook: <a href="https://www.facebook.com/51zhaohu">https://www.facebook.com/51zhaohu</a>';
$content .= '<br>Email: support@51zhaohu.com';
// $content .= '<br>' . elgg_echo("zhaohu:weixin") . ': XXX';
// $content .= '<br>' . elgg_echo("zhaohu:weibo") . ': XXX';
$content .= '</div>';

$content .= '<div class="zhaohu-contact-us-person">';
$content .= '<h3>Bella: </h3>';
$content .= '<p>正能量女王，51招呼的创意和市场一姐，想与51招呼合作的朋友们，可以随时联系阿五。</p>';
$content .= 'Email: bella@51zhaohu.com';
$content .= '</div>';

$content .= '<div class="zhaohu-contact-us-person">';
$content .= '<h3>Joey: </h3>';
$content .= '<p>来自厦门的新好男生Joey诚邀各种帅哥美女为本小店开张捧场助兴，欢聚一堂。在此恭候各位大驾光临！</p>';
$content .= 'Email: joey@51zhaohu.com';
$content .= '</div>';

$content .= '<div class="zhaohu-contact-us-person">';
$content .= '<h3>阿招: </h3>';
$content .= '<p>码工！一枚神经敏感的码工。大家对网站有任何意见，欢迎发私信。</p>';
$content .= 'Email: azhao@51zhaohu.com';
$content .= '</div>';

$content .= '<div class="zhaohu-contact-us-person">';
$content .= '<h3>阿呼: </h3>';
$content .= '<p>还是码工！人见人爱，花见花开的帅锅，性格细心体贴，收入稳定，无不良嗜好，还灰常幽默哦。已婚，句号。如果大家想对51招呼撒花或者拍砖，都可以联系人家哦。</p>';
$content .= 'Email: ahu@51zhaohu.com';
$content .= '</div>';

$content .= '<div class="zhaohu-contact-us-join-us">';
$content .= '<h3>加入我们</h3><br>';
$content .= '<p>Social Media Intern:</p>';
$content .= '<p>我们是致力于将兴趣化为动力的创业团队,如果你对互联网和创业有足够的热情和动力请加入我们。</p>';
$content .= '<p>Responsibilities:</p>';
$content .= '<ul>';
$content .= '<li>1. 管理和监督51招呼的social media 平台。</li>';
$content .= '<li>2. 发布每天的内容和图片。</li>';
$content .= '<li>3. 并将每天social media 平台上用户的反馈进行总结和分析。</li>';
$content .= '</ul>';
$content .= "<p></p>";
$content .= '<p>Requirements:</p>';
$content .= '<ul>';
$content .= '<li>1. College degree or above。</li>';
$content .= '<li>2. 较好的中英文写作能力。</li>';
$content .= '<li>3. 熟悉中国和美国的social media平台,并且对新鲜事物有较强的接收能力。</li>';
$content .= '<li>4. 熟悉办公软件,并且愿意接收挑战。</li>';
$content .= '</ul>';
$content .= '<p>请发送简历到hr@51zhaohu.com</p>';
$content .= '</div>';

$vars = array(
	'content' => $content,
);

$body = elgg_view_layout('one_column', $vars);

echo elgg_view_page($title, $body);