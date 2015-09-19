<?php ?>
//<script>
var event_manager_gmap;
var event_manager_geocoder;
var event_manager_gmarkers = [];

$(function() {
	//google.maps.event.addDomListener(window, 'load', initMapDiv);
	//google.maps.event.addListener(document.getElementById('zhaohu_gm_canvas'), 
	//		'load', initMapDiv);
	//initMapDiv();
	$(window).load(initMapDiv);

	$('#zhaohu_manager_zhaohu_get_directions').live("click", function(e)	{
		//frmAddress = $('#address_from').val();
		var location = $('#zhaohu_gm_location').text();
		
		window.open( '//maps.google.com/maps?daddr=' +location);
		
		e.preventDefault();
	});	
});

/*
 * Global GoogleMaps init
 */
function initMapDiv(){	
	var element = 'zhaohu_gm_canvas';
	var location = $('#zhaohu_gm_location').text();

	//alert(location);
	var zhaohu_manager_geocoder = new google.maps.Geocoder();
	
	var myOptions = {
    	zoom: 8,
    	mapTypeId: google.maps.MapTypeId.ROADMAP
  	};
	var zhaohu_manager_gmap = new google.maps.Map(document.getElementById(element), myOptions);
	zhaohu_manager_geocoder.geocode( { 'address': location}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {          
    	  zhaohu_manager_gmap.setCenter(results[0].geometry.location);    	  
    	  var marker = new google.maps.Marker({
    	      position: results[0].geometry.location,
    	      map: zhaohu_manager_gmap,
    	     // title: 'TODO'
    	  });    	  
      }
    });
}