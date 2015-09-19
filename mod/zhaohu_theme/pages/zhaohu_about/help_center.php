<?php
/*
 * Zhaohu help center page
 */

$site_url = elgg_get_site_url();
$search_bar_image_url =  $site_url . "mod/zhaohu_theme/images/search_bar.png";
$join_group_image_url =  $site_url . "mod/zhaohu_theme/images/join_group.png";
$promote_to_group_admin_image_url = $site_url . "mod/zhaohu_theme/images/promote_to_group_admin.png";
$group_drop_down_button_image_url = $site_url . "mod/zhaohu_theme/images/group_drop_down_button.png";
$group_drop_down_menu_image_url = $site_url . "mod/zhaohu_theme/images/group_drop_down_menu.png";

$title = elgg_echo("zhaohu:help_center");

$content = '<div class="zhaohu-zhaohu-about zhaohu-zhaohu-about-help-center">';
$content .= '<div class="zhaohu-zhaohu-about-help-center-title">帮助中心</div>';
$content .= "
<h3>1. 注册</h3>

<h4>1.1 用户名和昵称的区别?</h4>
用户名显示 在客官的个人设置中,登录的时候可以使用。（温馨提示 :用户名注册后不可以更改哦）
<br>昵称是客官游走江湖的称号,如果想更改请去个人设置中。

<h4>2.2 找回密码和重置密码</h4>
点击<a href=\"http://51zhaohu.com/forgotpassword\">找回密码</a>,我们将发送新的密码到客官的注册邮件当中。

<h3>2. 编辑个人信息</h3>
<h4>2.1 编辑头像</h4>
我们给客官有默认的头像,虽然默认头像已经足够完美。客官仍然可以在<a href=\"http://51zhaohu.com/profile/\">个人设置</a>中把您玉树凌风或者魅力冻人的个性照上传上来。

<h4>2.2 编辑资料</h4>
客官的资料越详细会有更多的江湖中人追随您哦,51招呼店小二期待您出彩的个人资料让我们Surprise。

<h4>2.3 设置</h4>
个人设置中客官可以更改江湖昵称,密码,语言设置等。

<h3>3. 寻找小组</h3>

客官想寻找自己喜欢的江湖吗?请去我们的搜索栏, <img src=\"$search_bar_image_url\" height=\"30\">
根据您的兴趣和所在地,您会找到自己喜欢的江湖,和有共同兴趣的小伙伴。点击“小组”会出现不同的小组图标,点击“招呼”会出现不同的活动信息。

<h3>4. 寻找活动</h3>

找到了自己喜欢的江湖（小组）,点击小组页面左上方<img src=\"$join_group_image_url\" height=\"30\">图标后,
该江湖会定期发出不同的活动邀约,请客官随时关注,哈哈,如此简单便利的招呼江湖。
		
<h3>5. 创建小组</h3>

点击右上角的“创建小组”按钮来创建属于客官您的江湖（小组）吧,非常之简单,客官定能操作的得心应手,如果有不满意,请反馈给我们的客服或者发邮件给
我们,客官的满意是51招呼店小二的荣幸。招呼小二建议客官您将描述写的越有特色,越能吸引人哦。创建小组是客官发布活动的第一步哦,客官有了自己的江湖就可以发布您的活动邀约。带*号为必填的。

<h3>6. 组长特权</h3>

组长可以发起招呼,编辑小组信息,群发邮件,任命管理员,注意注意,只有小组长才可以发布照片哦。
其他人只有被<img src=\"$promote_to_group_admin_image_url\" height=\"30\">才可以发布图片哦。

<h3>7. 发布招呼</h3>

<h4>7.1 我的江湖我做主</h4>

客官可以根据您江湖的特性发布相关活动邀约,点击小组页面左上方最右边的<img src=\"$group_drop_down_button_image_url\" height=\"30\">
会出现下拉框,然后点击“发起招呼”,请注意：带*号的为必填项。

<h4>7.2 费用：</h4>
客官可根据活动所需自由填写费用。

<h4>7.3 群发邮件：</h4>
组长或者管理员可以群发邮件给组内成员,通知组内成员最新消息。51招呼会近期推出站内消息功能,客官请稍后哦。

<h4>7.4 关闭通知：</h4>
客官可以取消给组内成员发邮件的功能。

<h3>8. 举报</h3>
如果客官觉得此江湖有各种违法的蛛丝马迹,请点击页面底部的“举报该页面”链接举报该江湖给我们,请放心客官您的一言一行我们都会保密的。

";

$content .= '</div>';


$vars = array(
	'content' => $content,
);

$body = elgg_view_layout('one_column', $vars);

echo elgg_view_page($title, $body);