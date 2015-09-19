<?php
/**
 * The Wire English language file
 */

$english = array(

	/**
	 * Menu items and titles
	 */
	'wire' => "The Wire",
	'wire:everyone' => "All wire posts",
	'wire:user' => "%s's wire posts",
	'wire:friends' => "Friends' wire posts",
	'wire:reply' => "Reply",
	'wire:replying' => "Replying to %s (@%s) who wrote",
	'wire:replyto' => "Replying to %s",
	'wire:thread' => "Thread",
	'wire:thread:name' => 'Thread about <a href="%s">%s</a>',
	'wire:charleft' => "characters remaining",
	'wire:tags' => "Wire posts tagged with '%s'",
	'wire:noposts' => "No wire posts yet",
	'item:object:wire' => "Wire posts",
	'wire:update' => 'Update',
	'wire:by' => 'Wire post by %s',

	'wire:previous' => "Previous",
	'wire:hide' => "Hide",
	'wire:previous:help' => "View previous post",
	'wire:hide:help' => "Hide previous post",

	/**
	 * The wire river
	 */
	'river:create:object:wire' => "%s posted to the %s",
	'wire:wire' => 'wire',

	/**
	 * Wire widget
	 */
	'wire:widget:desc' => 'Display your latest wire posts',
	'wire:num' => 'Number of posts to display',
	'wire:moreposts' => 'More wire posts',

	/**
	 * Status messages
	 */
	'wire:posted' => "Your message was successfully posted to the wire.",
	'wire:deleted' => "The wire post was successfully deleted.",
	'wire:blank' => "Sorry, you need to enter some text before we can post this.",
	'wire:notfound' => "Sorry, we could not find the specified wire post.",
	'wire:notdeleted' => "Sorry. We could not delete this wire post.",

	/**
	 * Notifications
	 */
	'wire:notify:subject' => "New wire post about %s",
	'wire:notify:reply' => '%s responded to %s on the wire:',
	'wire:notify:post' => '%s posted on the wire:',
	'wire:notify:source' => 'The posts can be found at: <a href="%s">%s</a>',

);

add_translation("en", $english);
