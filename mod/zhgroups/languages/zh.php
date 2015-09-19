<?php
/**
 * zhaohu Index English language file
*/

$chinese = array(
		'user:username' => '用户名',
		'profile:view' => '个人信息',
		'profile:home_mobile' => '<---',
		'profile:address' => '街道地址',
		'profile:country' => '国家',//must have
		'profile:state' => '州',
		'profile:city' => '城镇（请填写英文）',
		'profile:zip' => '邮编',
		'profile:gender' => '性别',
		'profile:female' => '女',
		'profile:male' => '男',
		'profile:birthdate' => '生日',
		'profile:birthYear' => '出生年份',
		'profile:birthMonth' => '出生月份',
		'profile:birthDay' => '出生日期',
		'profile:QQ' => 'QQ',
		'profile:edit:fail' => '抱歉无法编辑个人资料,',
		'profile:zip:err' => '客官您的zip code格式好像不对哦',
		'zhgroups:memberof' => '参加的小组(%s)',
		//
		'zhgroups:whatsnew' => "新鲜事",
		'groups:country' => '国家',//must have
		'groups:state' => '州',
		'groups:city' => '城镇（请填写英文）',
		'groups:tagstoolong' => '客官, 您的小组兴趣太长.',
		'groups:desptoolong' => '客官, 您的小组描述太长.',
		'groups:citytoolong' => '客官, 您的小组城市名太长.',
		'groups:nametoolong' => '客官, 您的小组名太长.',
		'zhgroups:add_users' => "添加用户",
		'zhgroups:mail' => "群发邮件",
		'zhgroups:removeuser' => "删除成员",
		'zhgroups:email' => "发邮件",
		'zhgroups:nearby' => "附近的小组",
		'zhgroup:home' => '小组主页',
		'zhgroup:photos' => '照片',
		'zhgroups:invite' => '邀请朋友',
		//
		'zhgroups:admin' => '管理员',
		'zhgroups:admins' => '管理员',
		'zhgroups:contact:title' => '通过邮件联系组长',
		'zhgroups:contact' => '联系组长',
		'zhgroups:admin:none' => '暂无内容',
		//
		'zhgroups:clear_selection' => '清除选择',
		'zhgroups:all_members' => '所有成员',		
		'zhgroups:notmember' => '客官需要先加入小组才能进行这项操作',
		'zhgroups:toggleadmin:owner' => "客官已经是小组长, 所以不能降级成为小组管理员",
		//notifications
		'zhgroups:notifications:sub' => '开启通知',
		'zhgroups:notifications:unsub' => '关闭通知',
		'zhgroups:notifications:msg:sub' => '成功订阅小组通知邮件',
		'zhgroups:notifications:msg:unsub' => '客官将不再收到小组通知邮件',
		'zhgroups:notifications:sub:error' => 'Sorry无法订阅小组通知邮件.',
		'zhgroups:notifications:unsub:error' => 'Sorry无法取消订阅小组通知邮件.',
		'zhgroups:emunsub:error' => 'Sorry无法关闭小组通知.',
		// group admins
		//'zhgroups:multiple_admin:group_admins' => "Group admins",
		'zhgroups:multiple_admin:remove' => "取消管理员",
		'zhgroups:multiple_admin:add' => "升级为管理员",
		// group admins - action
		'zhgroups:action:toggle_admin:success:remove' => "成功取消了%s的小组管理员权限",
		'zhgroups:action:toggle_admin:success:add' => "成功升级%s为小组管理员",
		'river:zhgroups:admin:add' => '%s升级为%s的小组管理员',
		'zhgroups:image:format:error' => '客官，抱歉无法支持您上传的文件格式',
		// group mail
		'zhgroups:mail:to' => "To",
		'zhgroups:mail:message:from' => "来自小组",
		
		'zhgroups:mail:title' => "给小组成员群发邮件",
		'zhgroups:mail:form:recipients' => "收件人数",
		'zhgroups:mail:form:members:selection' => "选择成员",
		
		'zhgroups:mail:form:subject' => "主题",
		'zhgroups:mail:form:body' => "内容",
		
		'zhgroups:mail:form:js:members' => "请选择至少一个成员作为收件人",
		'zhgroups:mail:form:js:description' => "请输入邮件内容",
		//Unsubscribe
		'zhgroups:mail:unsub1' => "取消订阅",
		'zhgroups:mail:unsub2' => "来自这个招呼小组的类似邮件",
		'51zhaohu:address' => "51zhaohu,Bellevue, WA USA",
		// group mail - action
		'zhgroups:action:mail:success' => "成功发送邮件",
		
		// actions
		'zhgroups:action:error:entity' => "The given GUID didn't result in a correct entity",
		'zhaohu:emails:empty' => "请输入一个或多个邮件地址啊，亲",
		'zhgroups:mail:subject:empty' => "请输入邮件主题啊，亲",
		'zhgroups:mail:body:empty' => "请输入邮件内容啊，亲",
		'zhaohu:hi' => "%s 客官,",
		'zhgroups:join:subject' => "%s加入了%s",
		'zhgroups:join:body' => "%s 客官,
		好消息！
		
		<a href='%s'>%s</a>客官加入了<a href='%s'>%s</a>活动小组.
		点击查阅<a href='%s'>%s</a>客官的详细信息.",
		'zhgroups:add:admin:subject' => "您升为%s的管理员啦啦啦",
		'zhgroups:add:admin:body' => "%s 客官,
		恭喜您！
		
		<a href='%s'>%s</a>把您升为<a href='%s'>%s</a>的管理员啦啦啦.
		点击查阅<a href='%s'>%s</a>的详细信息.",
		'zhgroups:rm:admin:subject' => "您不再是%s的管理员了呜呜呜",
		'zhgroups:rm:admin:body' => "%s 客官,		
		
		<a href='%s'>%s</a>取消了您<a href='%s'>%s</a>的管理员身份呜呜呜.
		非常感谢您在<a href='%s'>%s</a>上的付出.
		现在您可以抛开责任只管和小伙伴们开心地玩耍啦啦啦.",
		'zhgroups:transfer:onwer:subject' => "您升为%s的小组长啦啦啦",
		'zhgroups:transfer:onwer:body' => "%s 客官,
		恭喜您！

		<a href='%s'>%s</a>刚刚把<a href='%s'>%s</a>的组长之位传给您啦啦啦. 
		点击查阅<a href='%s'>%s</a>的详细信息.",
		'zhgroups:markfeatured' => "升级为推荐小组",
		'zhgroups:unmarkfeatured' => "降级为非推荐小组",
		// group invite message
		'zhgroups:groups:invite:body' => "Hi %s,
		
%s邀请您加入'%s'.
%s
		
点击以下链接查看您的邀请:
%s",
		// group add message
		'zhgroups:groups:invite:add:subject' => "You've been added to the group %s",
		'zhgroups:groups:invite:add:body' => "Hi %s,
		
%s added you to the group %s.
%s
		
To view the group click on this link
%s",
		'zhgroups:group:invite:add:confirm' => "Are you sure you want to add these users directly?",
		'zhgroups:unsub:site' => "如果客官不愿意继续接收来自51招呼的类似邮件，客官可以访问您的个人资料页面并点击设置按钮更新您的通知设置.",
		'zh:learn:more' => '更多内容',
		'can' => 'Canada',
		'usa' => 'United States',
);
		
add_translation('zh', $chinese);		