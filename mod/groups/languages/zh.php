<?php
/**
 * Elgg groups plugin language pack
 *
 * @package ElggGroups
 */

$chinese = array(

	/**
	 * Menu items and titles
	 */
	'groups' => "小组" ,
	'groups:owned' => "建立的小组" ,
	'groups:owned:user' => '小组%s拥有',
	'groups:yours' => "加入的小组" ,
	'groups:user' => "%s的小组" ,
	'groups:all' => "全站小组" ,
	'groups:add' => "创建小组",
	'groups:edit' => "编辑小组" ,
	'groups:delete' => "删除小组" ,
	'groups:membershiprequests' => "管理加入申请" ,
	'groups:membershiprequests:pending' => '管理加入申请 (%s)',
	'groups:invitations' => '小组邀请',
	'groups:invitations:pending' => '小组邀请 (%s)',

	'groups:icon' => "小组图标(文件格式: jpeg/jpg或png，空白即不改动)" ,
	'groups:name' => "小组名字" ,
	'groups:username' => "小组简称 (在URL中显示,只能输入英文字母)" ,
	'groups:description' => "描述" ,
	'groups:briefdescription' => "简介" ,
	'groups:interests' => "兴趣" ,
	'groups:website' => "网站" ,
	'groups:members' => "小组成员" ,
	'groups:my_status' => '我的状态',
	'groups:my_status:group_owner' => '小组长',
	'groups:my_status:group_member' => '小组成员',
	'groups:subscribed' => '小组通知开启',
	'groups:unsubscribed' => '小组通知关闭',

	'groups:members:title' => '%s的成员',
	'groups:members:more' => "查看所有成员",
	'groups:membership' => "成员" ,
	'groups:access' => "访问权限" ,
	'groups:owner' => "所有者" ,
	'groups:owner:warning' => "提醒: 如果做了这个修改, 客官就不再是这个小组的所有者了",
	'groups:widget:num_display' => "显示多少个小组" ,
	'groups:widget:membership' => "小组成员" ,
	'groups:widgets:description' => "在客官您的档案里显示您参与的小组" ,
	'groups:noaccess' => "无法访问小组" ,
	'groups:permissions:error' => 'Sorry，客官您没有权限执行这个操作',
	'groups:ingroup' => 'in the group',
	'groups:cantcreate' => 'Sorry，客官您没有权限创建小组,',
	'groups:cantedit' => "Sorry,客官您无法编辑小组," ,
	'groups:saved' => "小组成功保存" ,
	'groups:featured' => "推荐小组" ,
	'groups:makeunfeatured' => "移除推荐" ,
	'groups:makefeatured' => "添加推荐" ,
	'groups:featuredon' => "您推荐了该小组" ,
	'groups:unfeatured' => '从推荐小组中移除了%s',
	'groups:featured_error' => '无效小组',
	'groups:joinrequest' => "请求加入" ,
	'groups:join' => "加入小组" ,
	'groups:leave' => "离开小组" ,
	'groups:invite' => "邀请好友" ,
	'groups:invite:title' => '邀请好友到这个小组',
	'groups:inviteto' => "邀请好友到 '%s'" ,
	'groups:nofriends' => "客官您的好友都加入这个小组了" ,
	'groups:nofriendsatall' => '您还没有好友可以邀请',
	'groups:viagroups' => "通过小组" ,
	'groups:group' => "小组" ,
	'groups:search:tags' => "标签",
	'groups:search:title' => "搜索带有'%s'标签的小组",
	'groups:search:none' => "没有找到相关的小组",
	'groups:search_in_group' => "在小组中搜索",
	'groups:acl' => "小组: %s",

	'discussion:notification:topic:subject' => '新的小组讨论帖',
	'groups:notification' =>
'%s 发了新的小组讨论帖 %s:

%s
%s

查看和回复讨论帖:
%s
',

	'discussion:notification:reply:body' =>
'%s replied to the discussion topic %s in the group %s:

%s

View and reply to the discussion:
%s
',

	'groups:activity' => "小组活动",
	'groups:enableactivity' => 'Enable group activity',
	'groups:activity:none' => "There is no group activity yet",

	'groups:notfound' => "小组未找到" ,
	'groups:notfound:details' => "请求的小组不存在或者无权限访问" ,

	'groups:requests:none' => "目前没有成员申请" ,

	'groups:invitations:none' => '目前还没有邀请.',

	'item:object:groupforumtopic' => "论坛主题" ,

	'groupforumtopic:new' => "发帖讨论" ,

	'groups:count' => "小组创建了" ,
	'groups:open' => "开放小组" ,
	'groups:closed' => "封闭小组" ,
	'groups:member' => "成员" ,
	'groups:searchtag' => "通过tag搜索小组" ,

	'groups:more' => '更多小组',
	'groups:none' => '尚无小组',


	/*
	 * Access
	 */
	'groups:access:private' => "封闭 - 用户必须收到邀请" ,
	'groups:access:public' => "开放 - 任何用户都可以加入" ,
	'groups:access:group' => '仅限小组成员',
	'groups:closedgroup' => "本小组是封闭性质. 如需要申请加入,请点击\"申请加入\" 菜单" ,
	'groups:closedgroup:request' => 'To ask to be added, click the "request membership" menu link.',
	'groups:visibility' => "谁可以访问本小组?" ,

	/*
	Group tools
	*/
	'groups:enableforum' => "开启小组讨论" ,
	'groups:yes' => "是" ,
	'groups:no' => "否" ,
	'groups:lastupdated' => "最后更新 %s  由 %s  " ,
	'groups:lastcomment' => '最新评论 %s 由 %s',

	/*
	Group discussion
	*/
	'discussion' => 'Discussion',
	'discussion:add' => 'Add discussion topic',
	'discussion:latest' => 'Latest discussion',
	'discussion:group' => 'Group discussion',
	'discussion:none' => 'No discussion',
	'discussion:reply:title' => 'Reply by %s',

	'discussion:topic:created' => 'The discussion topic was created.',
	'discussion:topic:updated' => 'The discussion topic was updated.',
	'discussion:topic:deleted' => 'Discussion topic has been deleted.',

	'discussion:topic:notfound' => 'Discussion topic not found',
	'discussion:error:notsaved' => 'Unable to save this topic',
	'discussion:error:missing' => 'Both title and message are required fields',
	'discussion:error:permissions' => 'You do not have permissions to perform this action',
	'discussion:error:notdeleted' => 'Could not delete the discussion topic',

	'discussion:reply:deleted' => 'Discussion reply has been deleted.',
	'discussion:reply:error:notdeleted' => 'Could not delete the discussion reply',

	'reply:this' => '回复',

	'group:replies' => "回复" ,
	'groups:forum:created' => 'Created %s with %d comments',
	'groups:forum:created:single' => 'Created %s with %d reply',
	'groups:forum' => "小组论坛" ,
	'groups:addtopic' => "添加主题" ,
	'groups:forumlatest' => "最新主题" ,
	'groups:latestdiscussion' => "最新话题" ,
	'groups:newest' => "最新" ,
	'groups:popular' => "热门" ,
	'groupspost:success' => "客官您的评论已经发布" ,
	'groups:alldiscussion' => "最新话题" ,
	'groups:edittopic' => "编辑话题" ,
	'groups:topicmessage' => "话题消息" ,
	'groups:topicstatus' => "话题状态" ,
	'groups:reply' => "发布评论" ,
	'groups:topic' => "主题" ,
	'groups:posts' => "回复" ,
	'groups:lastperson' => "最后回复者" ,
	'groups:when' => "时间" ,
	'grouptopic:notcreated' => "没有主题创建" ,
	'groups:topicopen' => "开放" ,
	'groups:topicclosed' => "关闭" ,
	'groups:topicresolved' => "解决" ,
	'grouptopic:created' => "客官您的话题已经创建了" ,
	'groupstopic:deleted' => "这个话题已经删除了" ,
	'groups:topicsticky' => "置顶" ,
	'groups:topicisclosed' => "话题已经关闭" ,
	'groups:topiccloseddesc' => "话题已经关闭并且不再接受新的评论了" ,
	'grouptopic:error' => "客官您的小组话题无法创建.请再试一次或者联系客服" ,
	'groups:forumpost:edited' => "客官您已经成功编辑了论坛帖子" ,
	'groups:forumpost:error' => "编辑论坛帖子时候遇到了问题" ,


	'groups:privategroup' => "这个小组需要申请才能加入" ,
	'groups:notitle' => "请为客官您的小组添加名字" ,
	'groups:duptitle' => '客官，这个名字已经被占吶，请再想一个名字哟～',
	'groups:nointerests' => "请为客官您的小组添加一个或者多个标签",
	'groups:cantjoin' => "Sorry，无法加入小组," ,
	'groups:cantleave' => "Sorry，无法离开小组," ,
	'groups:owner:cantleave' => 'Sorry，请客官在编辑小组页面任命新的组长再离开.',
	'groups:removeuser' => '从小组中删除',
	'groups:cantremove' => 'Sorry，无法从小组中删除,',
	'groups:removed' => '成功从小组中删除 %s',
	'groups:addedtogroup' => "成功添加了用户到小组里" ,
	'groups:joinrequestnotmade' => "抱歉无法申请加入," ,
	'groups:joinrequestmade' => "申请已经发出" ,
	'groups:joined' => "成功加入了小组！" ,
	'groups:left' => "成功离开了小组" ,
	'groups:notowner' => "Sorry，客官您不是小组的所有者" ,
	'groups:notmember' => 'Sorry，客官您还不是小组的成员',
	'groups:alreadymember' => "客官您已经是该小组的成员!" ,
	'groups:userinvited' => "邀请已经发出" ,
	'groups:usernotinvited' => "Sorry，无法邀请用户," ,
	'groups:useralreadyinvited' => "用户已经被邀请过了" ,
	'groups:invite:subject' => "%s 客官您已经被邀请加入小组 %s!" ,
	'groups:updated' => "最后评论" ,
	'groups:started' => "始于" ,
	'groups:joinrequest:remove:check' => "确定删除本次申请?" ,
	'groups:invite:remove:check' => '确认删除这次邀请?',
	'groups:invite:body' => " %s 客官您好,

%s 邀请您参加 '%s' 小组. 点击以下链接，查看您的邀请:

%s",

	'groups:welcome:subject' => "欢迎来到%s小组!" ,
	'groups:welcome:body' => " %s 客官您好!

客官您是'%s'小组的成员了! 点击下面的链接开始参与到小组中吧

%s",

	'groups:request:subject' => "%s 请求加入小组 %s" ,
	'groups:request:body' => " %s 您好,

%s has requested to join the '%s' group. Click below to view their profile:

%s

or click below to view the group's join requests:

%s",

	/*
		Forum river items
	*/

	'river:create:group:default' => '%s创建了小组%s',
	'river:join:group:default' => '%s加入了小组%s',
	'river:create:object:groupforumtopic' => '%s发了讨论帖%s',
	'river:reply:object:groupforumtopic' => '%s回复讨论帖%s',
	
	'groups:nowidgets' => "该小组没有被构件定义过" ,


	'groups:widgets:members:title' => "小组成员" ,
	'groups:widgets:members:description' => "列出小组的成员" ,
	'groups:widgets:members:label:displaynum' => "列出小组的成员" ,
	'groups:widgets:members:label:pleaseedit' => "请配置该构件" ,

	'groups:widgets:entities:title' => "小组对象" ,
	'groups:widgets:entities:description' => "列出小组的对象" ,
	'groups:widgets:entities:label:displaynum' => "列出小组的对象" ,
	'groups:widgets:entities:label:pleaseedit' => "请配置该构件" ,

	'groups:forumtopic:edited' => "论坛帖子成功编辑" ,

	'groups:allowhiddengroups' => "客官您想允许私人小组(不可见)吗?" ,
	'groups:whocancreate' => '谁能创建小组?',

	/**
	 * Action messages
	 */
	'group:deleted' => "小组和小组内容都删除了" ,
	'group:notdeleted' => "Sorry，无法删除小组," ,

	'group:notfound' => '找不到这个小组',
	'grouppost:deleted' => "小组帖子删除了" ,
	'grouppost:notdeleted' => "小组帖子无法删除" ,
	'groupstopic:deleted' => "这个话题已经删除了" ,
	'groupstopic:notdeleted' => "话题没删除" ,
	'grouptopic:blank' => "无主题" ,
	'grouptopic:notfound' => '无法找到主题',
	'grouppost:nopost' => '空主题',
	'groups:deletewarning' => "客官您想删除本小组吗?" ,

	'groups:invitekilled' => '邀请已经被删除',
	'groups:joinrequestkilled' => "申请已经被删除",

	// ecml
	'groups:ecml:discussion' => '小组讨论',
	'groups:ecml:groupprofile' => '小组档案',

);

add_translation("zh", $chinese);
