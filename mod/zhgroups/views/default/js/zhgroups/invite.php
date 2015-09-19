<?php
/**
 * Extend the global site JS
 */
?>
//<script>
elgg.provide("elgg.zhinvite");

elgg.zhinvite.init = function() {
	// group invite
	$('#zh_email_add').live('click', elgg.zhinvite.email_add);
	$('#zh_invite_email_results .elgg-icon-delete-alt').live("click", function() {
		$(this).parent('div').remove();
	});
	/*
	// suggested groups join clicks
	$(".group-tools-suggested-groups .elgg-button-action").live("click", function() {

		elgg.action($(this).attr("href"));

		$(this).css("visibility", "hidden");
		
		return false;
	});*/
}

elgg.zhinvite.email_add = function() {
	regexpr = "[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}";
	var emailInput = $("#zh_invite_email_input").val();
	//fordebug alert(emailInput);
	$("#zh_invite_email_invalid").hide();
	$("#zh_invite_email_invalid").html("The following emails are invalide, please check and try again:</br>");

	var delimiter;
	if(emailInput.indexOf(";") > -1)
		delimiter = ";";
	else if(emailInput.indexOf(",") > -1)
		delimiter = ",";
	else if(emailInput.indexOf("；") > -1)
		delimiter = "；";
	else if(emailInput.indexOf("，") > -1)
		delimiter = "，";
	
	var emails = emailInput.split(delimiter);
	$.each(emails, function( index, email ) {
		//fordebug alert(email);
		email = $.trim(email);		
		if (!email.match(new RegExp(regexpr, "i"))) {
			$("#zh_invite_email_invalid").append(email+";");
			$("#zh_invite_email_invalid").show();
		}
		else {
			var str = "<div><input type='hidden' value='" + email + "' name='email2invite[]' />";
			str += email;
			str += "<span class='elgg-icon elgg-icon-delete-alt'></span></div>";
			$("#zh_invite_email_results").append(str);			
		}
	});	
	$("#zh_invite_email_input").val('');
	//$("#tag_val").val($(this).text());
	//alert($(this).text());
}

//register init hook
elgg.register_hook_handler("init", "system", elgg.zhinvite.init);
