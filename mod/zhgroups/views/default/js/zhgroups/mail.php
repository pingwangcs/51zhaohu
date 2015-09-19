<?php
/**
 * Extend the global site JS
 */
?>
//<script>
elgg.provide("elgg.zhmail");

elgg.zhmail.init = function() {
	$('#zhgroups_mail_clear').click(elgg.zhmail.mail_clear_members);
	$('#zhgroups_mail_all').click(elgg.zhmail.mail_all_members);
	$('#zhgroups_mail_member_selection input[type=checkbox]').live("change", elgg.zhmail.mail_update_recipients);
	$('#zhgroups_mail_form').submit(elgg.zhmail.mail_form_submit);
}

elgg.zhmail.mail_form_submit = function() {
	var result = false;
	var error_msg = "";
	var error_count = 0;

	if ($('#zhgroups_mail_member_selection input[name="user_guids[]"]:checked').length == 0 && $('#zhgroups_mail_memberId').is(':empty')) {
		error_msg += elgg.echo("zhgroups:mail:form:js:members") + '\n';
		error_count++;
	}

	if ($(this).find('input[name="description"]').val() == "") {
		error_msg += elgg.echo("zhgroups:mail:form:js:description") + '\n';
		error_count++;
	}

	if (error_count > 0) {
		alert(error_msg);
	} else {
		result = true;
	}
	return result;
}

elgg.zhmail.mail_clear_members = function() {
	$('#zhgroups_mail_member_selection input[name="user_guids[]"]:checked').each(function() {
		$(this).removeAttr('checked');
	});
	elgg.zhmail.mail_update_recipients();
}

elgg.zhmail.mail_all_members = function() {
	$('#zhgroups_mail_member_selection input[name="user_guids[]"]').each(function() {
		$(this).attr('checked', 'checked');
	});

	elgg.zhmail.mail_update_recipients();
}

elgg.zhmail.mail_update_recipients = function() {
	var count = $('#zhgroups_mail_member_selection input[name="user_guids[]"]:checked').length;

	$('#zhgroups_mail_recipients_count').html(count);
}

//register init hook
elgg.register_hook_handler("init", "system", elgg.zhmail.init);
