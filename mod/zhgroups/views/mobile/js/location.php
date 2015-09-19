<?php ?>
elgg.provide("elgg.zhlocation");

var usStates =
{
"AL": "Alabama",
"AK": "Alaska",
"AS": "American Samoa",
"AZ": "Arizona",
"AR": "Arkansas",
"CA": "California",
"CO": "Colorado",
"CT": "Connecticut",
"DE": "Delaware",
"DC": "District Of Columbia",
"FM": "Federated States Of Micronesia",
"FL": "Florida",
"GA": "Georgia",
"GU": "Guam",
"HI": "Hawaii",
"ID": "Idaho",
"IL": "Illinois",
"IN": "Indiana",
"IA": "Iowa",
"KS": "Kansas",
"KY": "Kentucky",
"LA": "Louisiana",
"ME": "Maine",
"MH": "Marshall Islands",
"MD": "Maryland",
"MA": "Massachusetts",
"MI": "Michigan",
"MN": "Minnesota",
"MS": "Mississippi",
"MO": "Missouri",
"MT": "Montana",
"NE": "Nebraska",
"NV": "Nevada",
"NH": "New Hampshire",
"NJ": "New Jersey",
"NM": "New Mexico",
"NY": "New York",
"NC": "North Carolina",
"ND": "North Dakota",
"MP": "Northern Mariana Islands",
"OH": "Ohio",
"OK": "Oklahoma",
"OR": "Oregon",
"PW": "Palau",
"PA": "Pennsylvania",
"PR": "Puerto Rico",
"RI": "Rhode Island",
"SC": "South Carolina",
"SD": "South Dakota",
"TN": "Tennessee",
"TX": "Texas",
"UT": "Utah",
"VT": "Vermont",
"VI": "Virgin Islands",
"VA": "Virginia",
"WA": "Washington",
"WV": "West Virginia",
"WI": "Wisconsin",
"WY": "Wyoming"
};

var caStates = {
"AB": "Alberta",
"BC": "British Columbia",
"MB": "Manitoba",
"NB": "New Brunswick",
"NL": "Newfoundland and Labrador",
"NS": "Nova Scotia",
"ON": "Ontario",
"PE": "Prince Edward Island",
"QC": "Quebec",
"SK": "Saskatchewan",
"NT": "Northwest Territories",
"NU": "Nunavut",
"YT": "Yukon",
};

elgg.zhlocation.init = function() {
    initStates();

	$("#zh_country").change(function () {
        genStates();
    });
}

function initStates(){  
  genStates();
  var cur = $("#zh_state_val").val();
  if(!cur) cur = 'WA';
  $('#zh_state').val(cur);
}

function genStates() {
  states = $("#zh_country").val()=='US' ? usStates : caStates;
  $('#zh_state').empty();
  for (var k in states) {
    var opt = $('<option value="'+k+'">'+states[k]+'</option>');
    $('#zh_state').append(opt);
  }
}

elgg.register_hook_handler('init', 'system', elgg.zhlocation.init);




