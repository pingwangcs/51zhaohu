<?php 

?>
//<script>
elgg.provide("elgg.zhaohu_manager");
var usCities = [
              ['全部', 'Anaheim', 'Bakersfield', 'Chula Vista', 
               'Fontana', 'Fremont', 'Fresno', 'Glendale', 'Huntington Beach', 'Irvine', 'Long Beach',
               'Los Angeles', 'Modesto', 'Moreno Valley', 'Oakland', 'Oxnard', 'Riverside', 'Sacramento',
               'San Bernardino', 'San Diego', 'San Francisco', 'San Jose', 'Santa Ana', 'Stockton'],
               ['全部', 'Albany',  'Binghamton',  'Buffalo',  'Elmira',  'Ithaca',  'Jamestown',  'Long Beach',
               'Middletown',  'Mount Vernon',  'New Rochelle',  'New York',  'Newburgh',  'Niagara Falls',  'North Tonawanda',
               'Poughkeepsie',  'Rochester',  'Rome',  'Schenectady',  'Syracuse',  'Troy',  'Utica',  'White Plains',  'Yonkers'],
               ['全部', 'Auburn', 'Bellevue', 'Bothell', 'Burien', 
    			'Des Moines', 'Everett', 'Federal Way', 'Issaquah', 'Kent', 'Kirkland', 'Lynnwood', 
    			'Mercer Island', 'Newcastle', 'Northgate', 'Redmond', 'Renton', 'Sammamish', 
    			'SeaTac', 'Seattle', 'Shoreline', 'Tacoma', 'Tukwila']
              ];
var stateMap = {"全部":2, "CA":0, "NY":1, "WA":2};
var defCities = {"全部":"全部", "CA": "Los Angeles","NY": "New York", "WA": "Seattle"};

(function($) {
    $.QueryString = (function(a) {
        if (a == "") return {};
        var b = {};
        for (var i = 0; i < a.length; ++i)
        {
            var p=a[i].split('=');
            if (p.length != 2) continue;
            b[p[0]] = decodeURIComponent(decodeURIComponent(p[1].replace(/\+/g, " ")));
        }
        return b;
    })(window.location.search.substr(1).split('&'))
})(jQuery);

function updateQueryStr(name, value) {
	$.QueryString[name] = encodeURIComponent(value);
	if (history.pushState) {
	    var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' +$.param($.QueryString);
	    window.history.pushState({path:newurl},'',newurl);
	}
}

elgg.zhaohu_manager.init = function() {
	zhaohu_find_init();

	$('.tag-opt').live('click', function() {	
		$("#zhf_tag_input").val($(this).text());
		updateQueryStr('tag', $(this).text());
		updateQueryStr('featured', 'n');
		$("#zhf_tag_dd").hide();
		zhaohu_find();
		return false;
	});

	$('.new-year-background').live('click', function() {	
		$("#zhf_tag_input").val('节日');
		updateQueryStr('tag', '节日');
		updateQueryStr('featured', 'n');
		$("#zhf_tag_dd").hide();
		zhaohu_find();
		clearInterval(background_change_interval);
		return false;
	});

	$('.christmas-background').live('click', function() {	
		$("#zhf_tag_input").val('圣诞节');
		updateQueryStr('tag', '圣诞节');
		updateQueryStr('featured', 'n');
		$("#zhf_tag_dd").hide();
		zhaohu_find();
		clearInterval(background_change_interval);
		return false;
	});

	$('.default-background').live('click', function() {	
		$("#zhf_tag_input").val('全部兴趣');
		updateQueryStr('tag', '全部兴趣');
		updateQueryStr('featured', 'n');
		$("#zhf_tag_dd").hide();
		zhaohu_find();
		clearInterval(background_change_interval);
		return false;
	});

	$('.popular-tag-item').live('click', function() {	
		$("#zhf_tag_input").val($(this).text());
		updateQueryStr('tag', $(this).text());
		updateQueryStr('showType', 'zhaohus');
		updateQueryStr('featured', 'n');
		$("#zhf_tag_dd").hide();
		zhaohu_find();
		return false;
	});

	$('#more_recommended_zhaohus').live('click', function() {
		$("#zhf_tag_input").val('全部兴趣');
		$("#zhf_state_input").val('全部');
		$("#zhf_city_input").val('全部');
		updateQueryStr('tag', '全部兴趣');
		updateQueryStr('state', '全部');
		updateQueryStr('city', '全部');
		updateQueryStr('showType', 'zhaohus');
		updateQueryStr('featured', 'y');
		$("#zhf_tag_dd").hide();
		zhaohu_find();
		return false;
	});

	$('.zhf-state-opt').live('click', function() {
		$("#zhf_state_input").val($(this).text());
		updateQueryStr('state', $(this).text());
		$("#zhf_state_dd").hide();
		zhaohu_gen_cities();
		zhaohu_find();
		return false;
	});

	$('.zhf-city-opt').live('click', function() {	
		$("#zhf_city_input").val($(this).text());
		updateQueryStr('city', $(this).text());
		$("#zhf_city_dd").hide();
		zhaohu_find();
		return false;
	});
	
	$("#zhf_tag_input").live("keydown", function(event){ 
		if ( event.which == 13 ) {
			if($(this).val().length > 90){
				alert('客官输入的关键词太长辣，麻烦改短再试试呢');
			} else{
				updateQueryStr('tag', $(this).val());
				zhaohu_find();
			}
		}
	});

	$("#zhf_state_input").live("keydown", function(event){ 
		if ( event.which == 13 ) {
			if($(this).val().length > 20){
				alert('客官输入的州名太长辣，麻烦改短再试试呢');
			} else{
				updateQueryStr('state', $(this).val());
				zhaohu_gen_cities();
				zhaohu_find();
			}
		}
	});

	$("#zhf_city_input").live("keydown", function(event){ 
		if ( event.which == 13 ) {
			if($(this).val().length > 20){
				alert('客官输入的城镇名太长辣，麻烦改短再试试呢');
			} else{
				updateQueryStr('city', $(this).val());			
				zhaohu_find();
			}
		}
	});	

    $("#zhf_tag_input").live("click", function(event){
    	$("#zhf_state_dd").hide();
    	$("#zhf_city_dd").hide();
		$("#zhf_tag_dd").show();    
		event.stopPropagation();
    });
   
    $("#zhf_state_input").live("click", function(event){
    	$("#zhf_tag_dd").hide();
    	$("#zhf_city_dd").hide();
		$("#zhf_state_dd").show();    
		event.stopPropagation();
    });
    
    $("#zhf_city_input").live("click", function(event){
    	$("#zhf_tag_dd").hide();
    	$("#zhf_state_dd").hide();
		$("#zhf_city_dd").show();    
		event.stopPropagation();
    });	
    
    $("body").live("click", function(){
    	$("#zhf_tag_dd").hide();
    	$("#zhf_state_dd").hide();
    	$("#zhf_city_dd").hide();
    });

	$('#zhf_groups').live('click', function() {
		// need top 3 for user can change them before clicking
		if(zhaohu_check_input()){
			updateQueryStr('tag', $("#zhf_tag_input").val());
			updateQueryStr('state', $("#zhf_state_input").val());
			updateQueryStr('city', $("#zhf_city_input").val());
			updateQueryStr('showType', 'groups');
			zhaohu_find();
		}
		return false;
	});

	$('#zhf_zhaohus').live('click', function() {
		if(zhaohu_check_input()){
			updateQueryStr('tag', $("#zhf_tag_input").val());
			updateQueryStr('state', $("#zhf_state_input").val());
			updateQueryStr('city', $("#zhf_city_input").val());
			updateQueryStr('showType', 'zhaohus');
			var ifPast = $('#zhf_past').is(':checked')?'y':'n';
			updateQueryStr('past', ifPast);
			zhaohu_find();
		}
		return false;
	});

	$('#zhuw_nbg').live('click', function() {
		updateQueryStr('tag', '');
		updateQueryStr('state', '');
		updateQueryStr('city', '');
		updateQueryStr('showType', 'groups');
		updateQueryStr('nearby', 'y');
		zhaohu_find4u();
		return false;
	});

	$('#zhuw_jg').live('click', function() {
		updateQueryStr('tag', '');
		updateQueryStr('state', '');
		updateQueryStr('city', '');
		updateQueryStr('showType', 'groups');
		updateQueryStr('nearby', 'n');
		zhaohu_find4u();
		return false;
	});
};

function zhaohu_check_input(){
	if($("#zhf_tag_input").val().length > 90){
		alert('客官输入的关键词太长辣，麻烦改短再试试呢'); return false;
	}
	if($("#zhf_state_input").val().length > 20){
		alert('客官输入的州名太长辣，麻烦改短再试试呢'); return false;
	}
	if($("#zhf_city_input").val().length > 20){
		alert('客官输入的城镇名太长辣，麻烦改短再试试呢'); return false;
	}
	return true;
}

function zhaohu_gen_cities(){
	var curState = $("#zhf_state_input").val();
	$("#zhf_city_input").val(defCities[curState]);
	//var cities = curState=='CA' ? caCities : waCities;
	var cities = usCities[stateMap[curState]];
	$('#zhf_city_dd').empty();
	var content = '<li><ul><li>';
	var tagNo = 0;
	for (var t in cities) {
		if(tagNo==6) {
			content += '</ul></li><li><ul>';
			tagNo = 0;
		}
		$('#zhf_city_dd').append('<li><a href="#" class="zhf-city-opt" rel="nofollow">'+cities[t]+'</a></li>');
		content += '<li><a href="#" class="zhf-city-opt" rel="nofollow">'+cities[t]+'</a></li>';
		tagNo++;
	}
	content += '</ul></li>';
	$('#zhf_city_dd').html(content);
}

function zhaohu_find_init(){
	//updateQueryStr('showType', 'zhaohus');
	$("#zhf_tag_input").val($.QueryString['tag']);
	$("#zhf_state_input").val($.QueryString['state']);
	$("#zhf_city_input").val($.QueryString['city']);
	updateQueryStr('past', 'n');
	// must have to encode tag
	updateQueryStr('tag', $("#zhf_tag_input").val());
	zhaohu_gen_cities();
	zhaohu_find();
}

function zhaohu_find(){
	var showType = $.QueryString['showType'];
	var state=$.QueryString['state'];
	var city=$.QueryString['city'];
	var tag=$.QueryString['tag'];
	var past=$.QueryString['past'];
	var featured=$.QueryString['featured'];
	var proc, showDiv, hideDiv;
	
	if(showType =='groups'){
		proc = 'zhaohus/proc/groups/find';
		showDiv = '#find_result_groups';
		hideDiv = '#find_result_zhaohus';
	}
	else {
		proc = 'zhaohus/proc/zhaohus/find';
		showDiv = '#find_result_zhaohus';
		hideDiv = '#find_result_groups';
	}
	//fordebug alert("showDiv " + showDiv+" hideDiv "+hideDiv);
	if(!state)
		state='All';
	if(!city)
		city='All';
	if(!tag)
		tag='AllInterests';
	if(!past)
		past='n';
	if(!featured)
		featured='n';
	$.ajax({
		 type: 'GET',
		 cache: false,
		 url: elgg.get_site_url() + proc +'?tag='+tag+'&state='+state+'&city='+city+'&past='+past+'&featured='+featured, // +'&offset='+offset
		 dataType: 'html',
		 success: function(data, status, xml){
			$(showDiv).html(data);					
			$(hideDiv).hide();	
			$(showDiv).show();
		 },
		 error: function(xml, status, error){
			 $(showDiv).html(elgg_echo("zhaohu:error"));
		 },
	});
}

function zhaohu_find4u(){
	var showDiv = '#find_result_groups';
	var hideDiv = '#find_result_zhaohus';
	var nearby = $.QueryString['nearby'];
	var end;

	if(nearby == 'y') {
		end = 'nearby4u';
	}
	else
		end = 'joinedgroups';

	$.ajax({
		 type: 'GET',
		 cache: false,
		 url: elgg.get_site_url() + 'zhaohus/proc/groups/'+end,
		 dataType: 'html',
		 success: function(data, status, xml){
			$(showDiv).html(data);					
			$(hideDiv).hide();	
			$(showDiv).show();
		 },
		 error: function(xml, status, error){
			 $(showDiv).html(elgg_echo("zhaohu:error"));
		 },
	});
}

elgg.register_hook_handler('init', 'system', elgg.zhaohu_manager.init);