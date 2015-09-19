<?php
/**
* Elgg send a message action page
* 
* @package ElggMessages
*/

$chinese = array(
	/**
	* Menu items and titles
	*/

	'messages' => "消息",
	'messages:unreadcount' => "%s条未读消息",
	'messages:back' => "回收件箱",
	'messages:user' => "%s的收件箱",
	'messages:posttitle' => "%s的消息: %s",
	'messages:inbox' => "收件箱",
	'messages:send' => "发送",
	'messages:sent' => "已发消息",
	'messages:message' => "消息",
	'messages:title' => "主题",
	'messages:to' => "To",
	'messages:from' => "From",
	'messages:fly' => "发送",
	'messages:replying' => "回复",
	'messages:inbox' => "收件箱",
	'messages:sendmessage' => "发送消息",
	'messages:compose' => "编辑消息",
	'messages:add' => "编辑消息",
	'messages:sentmessages' => "发件箱",
	'messages:recent' => "最近消息",
	'messages:original' => "原消息",
	'messages:yours' => "您的消息",
	'messages:answer' => "回复",
	'messages:toggle' => '选中所有',
	'messages:markread' => '标记为已读',
	'messages:recipient' => '选择收件人;',
	'messages:to_user' => 'To: %s',

	'messages:new' => '新消息',

	'notification:method:site' => '站内信',

	'messages:error' => '客官，抱歉无法保存消息.',

	'item:object:messages' => '消息',

	/**
	* Status messages
	*/

	'messages:posted' => "成功发送消息",
	'messages:success:delete:single' => '成功删除消息',
	'messages:success:delete' => '成功删除消息',
	'messages:success:read' => '消息标记为已读',
	'messages:error:messages_not_selected' => '客官，请选择消息',
	'messages:error:delete:single' => '客官，抱歉无法删除消息.',

	/**
	* Email messages
	*/

	'messages:email:subject' => '您有一条新消息!',
	'messages:email:body' => "您有一条来自%s新消息:


	%s


	查看消息, 请点击:

	%s

	给%s发送消息, 请点:

	%s

	请不要直接回复这条消息.",

	/**
	* Error messages
	*/

	'messages:blank' => "客官，请输入消息内容哦～",
	'messages:notfound' => "客官，抱歉无法找到指定消息.",
	'messages:notdeleted' => "客官，抱歉无法删除消息.",
	'messages:nopermission' => "客官，抱歉您没有权限更改消息",
	'messages:nomessages' => "还没有消息",
	'messages:user:nonexist' => "客官，抱歉无法找到收件人",
	'messages:user:blank' => "客官，请选择收件人",

	'messages:deleted_sender' => '发件人已注销账号',

);
		
add_translation("zh", $chinese);