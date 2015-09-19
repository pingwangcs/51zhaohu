<?php
/**
 * The wire's JavaScript
 */

$site_url = elgg_get_site_url();

?>

elgg.provide('elgg.wire');

elgg.wire.init = function() {
	$(".wire-submit").live('click', elgg.wire.textCounter);

	$(".wire-previous").live('click', elgg.wire.viewPrevious);
	$(".wire-reply").live('click', elgg.wire.reply);
};

elgg.wire.textCounter = function(event) {
	var limit = 190;
	var submit = $(this);
	var postGuid = $(this).attr("id").split("-").pop();
	//alert('guid '+postGuid);
	var textarea = $("#wire-textarea-"+ postGuid); 
	var status = $("#wire-overmax-"+ postGuid); 
	var over_chars = textarea.val().length - limit;
	if (over_chars > 0) {
		status.html("抱歉，客官输入的内容超出190个字符的上限了。");
		event.preventDefault();
	} else {
		status.html("");
	}
};

elgg.wire.viewPrevious = function(event) {
	var $link = $(this);
	var postGuid = $link.attr("href").split("/").pop();
	var $previousDiv = $("#wire-previous-" + postGuid);

	if ($link.html() == elgg.echo('隐藏')) {
		$link.html(elgg.echo('上一条'));
		$link.attr("title", elgg.echo('看上一条帖子'));
		$previousDiv.slideUp(400);
	} else {
		$link.html(elgg.echo('隐藏'));
		$link.attr("title", elgg.echo('隐藏上一条帖子'));
		
		$.ajax({type: "GET",
			url: elgg.config.wwwroot + "ajax/view/wire/previous",
			dataType: "html",
			cache: false,
			data: {guid: postGuid},
			success: function(htmlData) {
				if (htmlData.length > 0) {
					$previousDiv.html(htmlData);
					$previousDiv.slideDown(600);
				}
			}
		});
	}
	event.preventDefault();
};

elgg.wire.reply = function(e) {
	var $link = $(this);
	var postGuid = $link.attr("href").split("/").pop();
	//alert('postGuid '+postGuid);
	//var $replyDiv = $("#wire-reply");
	var $replyDiv = $("#wire-reply-" + postGuid);
	
	if ($link.html() == elgg.echo('取消')) {
		$link.html(elgg.echo('回复'));
		$replyDiv.slideUp(400);
	} else {
		$link.html(elgg.echo('取消'));
		$.ajax({type: "GET",
			url: elgg.config.wwwroot + "ajax/view/wire/replyinline",
			dataType: "html",
			cache: false,
			data: {guid: postGuid},
			success: function(htmlData) {
				if (htmlData.length > 0) {
					$replyDiv.html(htmlData);
					$replyDiv.slideDown(600);
					//$replyDiv.show();
				}
			}
		});
	}
	e.preventDefault();
}

elgg.register_hook_handler('init', 'system', elgg.wire.init);
