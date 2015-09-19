<?php ?>
elgg.provide("elgg.zhgroups");


elgg.zhgroups.init = function() {

    $("#zhp_interests").live("click", function(event){
		$("#zhp_interest_dd").show();    
		event.stopPropagation();
    });

    $("#zhp_interests").live("dbclick", function(event){
			event.stopPropagation();
    });
    
	$('.zhp-i-opt').live('click', function() {
		var i = $("#zhp_interests").val();
		i = i?i+', ':i;
		$("#zhp_interests").val(i+$(this).text());
		return false;
	});	 

    $("body").live("click", function(){
    	$("#zhp_interest_dd").hide();  
    });
}

elgg.register_hook_handler('init', 'system', elgg.zhgroups.init);




