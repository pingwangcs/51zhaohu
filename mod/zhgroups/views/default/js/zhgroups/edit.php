<?php ?>
elgg.provide("elgg.zhgroups");


elgg.zhgroups.init = function() {

    $("#zhge_interests").live("click", function(event){
		$("#zhge_i_dd").show();    
		event.stopPropagation();
    });
    //
    $("#zhge_interests").live("dbclick", function(event){
			event.stopPropagation();
    });
    
	$('.zhge-i-opt').live('click', function() {
		var i = $("#zhge_interests").val();
		i = i?i+', ':i;
		$("#zhge_interests").val(i+$(this).text());
		//$("#zhge_i_dd").hide();
		return false;
	});
	    
    
    // hide drop down menu items
    $("body").live("click", function(){
    	$("#zhge_i_dd").hide();  
    });    

}

elgg.register_hook_handler('init', 'system', elgg.zhgroups.init);




