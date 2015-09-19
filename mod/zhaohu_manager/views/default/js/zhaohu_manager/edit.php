<?php ?>

$(function() {

    $("#zhe_i").live("click", function(event){
		$("#zhe_i_dd").show();    
		event.stopPropagation();
    });    
    
	$('.zhe-i-opt').live('click', function() {
		var i = $("#zhe_i").val();
		i = i?i+', ':i;
		$("#zhe_i").val(i+$(this).text());
		//$("#zhe_i_dd").hide();
		return false;
	});	    

    $("body").live("click", function(){
    	$("#zhe_i_dd").hide();  
    });
	
});



