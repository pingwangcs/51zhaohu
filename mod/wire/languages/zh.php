<?php
/**
 * The Wire English language file
 */

$chinese = array(

	/**
	 * Menu items and titles
	 */
	'wire' => "帖子",
	'wire:everyone' => "所有帖子",
	'wire:user' => "%s的帖子",
	'wire:friends' => "朋友的帖子",
	'wire:reply' => "回复",
	'wire:replying' => "回复%s (@%s)的帖子",
	'wire:replyto' => "回复%s",
	'wire:thread' => "此话题",
	'wire:thread:name' => '<a href="%s">%s</a>的帖子',
	'wire:charleft' => "可用字符数",
	'wire:tags' => "带'%s'标签的帖子",
	'wire:noposts' => "还没有帖子",
	'item:object:wire' => "帖子",
	'wire:update' => '更新',
	'wire:by' => '%s发的贴',

	'wire:previous' => "上一条",
	'wire:hide' => "隐藏",
	'wire:previous:help' => "看上一条帖子",
	'wire:hide:help' => "隐藏上一条帖子",

	/**
	 * The wire river
	 */
	'river:create:object:wire' => "%s发了帖子%s",
	'wire:wire' => '帖子',

	/**
	 * Wire widget
	 */
	'wire:widget:desc' => 'Display your latest wire posts',
	'wire:num' => 'Number of posts to display',
	'wire:moreposts' => 'More wire posts',

	/**
	 * Status messages
	 */
	'wire:posted' => "客官发帖成功.",
	'wire:deleted' => "成功删除帖子",
	'wire:blank' => "客官，请输入内容再发帖呦～",
	'wire:notfound' => "抱歉，无法找到改帖子",
	'wire:notdeleted' => "抱歉，无法删除改帖子",

	/**
	 * Notifications
	 */
	'wire:notify:subject' => "关于%s的新帖子",
	'wire:notify:reply' => '%s回复了%s的帖子:',
	'wire:notify:post' => '%s发了帖子:',
	'wire:notify:source' => '请到<a href="%s">%s</a>查看帖子',

);

add_translation('zh', $chinese); 
