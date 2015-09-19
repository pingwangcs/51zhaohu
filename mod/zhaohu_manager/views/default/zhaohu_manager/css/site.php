<?php
	$graphics_folder = $vars["url"] . "mod/zhaohu_manager/_graphics/";
?>

/* Zhaohu global */
.zhaohu_manager_required {
	color: #AAAAAA;
}

/* Zhaohu Edit */
#zhaohu_manager_zhaohu_edit label{
	font-weight: normal;
	font-size: 100%;
}

#zhaohu_manager_zhaohu_edit > fieldset > table {
	width: 100%;
}

#zhaohu_manager_zhaohu_edit .zhaohu_manager_zhaohu_edit_label {
	max-width: 250px;
}

.zhaohu_manager_zhaohu_edit_date {
	width: 100px;
	height: 20px;
	padding: 0 5px;
}

#zhaohu_manager_zhaohu_edit > fieldset > table td {
	padding: 2px 0px;
}

.zhaohu_manager_zhaohu_list_search_input
{
	width: 300px;
}
.zhaohu_manager_zhaohu_list_owner, .zhaohu_manager_zhaohu_view_owner
{
	color: #808080;
	font-size: 11px;
	border-bottom: 1px solid #CCCCCC;
	padding: 0 0 2px;
}

#zhaohu_past {
	position: relative;
	margin-top: 5px;
  	left: 73%;
}

.zhaohu_manager_zhaohu_list_count
{
	color: #666666;
    font-weight: bold;
    margin: 0 0 5px 4px;
}

#zhaohu_manager_zhaohu_listing div.pagination {
	margin: 0;
}

#zhaohu_manager_zhaohu_listing .elgg-list {
	border-top: none;
}

#zhaohu_manager_result_refreshing {
	display: none;
	float: right;
	color: #AAAAAA;
}

#zhaohu_manager_zhaohu_list_search_more {
	border: 1px solid #CCCCCC;
    cursor: pointer;
    line-height: 31px;
    padding: 5px;
    text-align: center;
    width: auto;
    
    -webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}

#zhaohu_manager_zhaohu_list_search_more:hover {
	border-color: #4690D6;
}

/* Zhaohu Search */
#zhaohu_manager_search_form label {
	font-weight: normal;
	font-size: 100%;
}

#past_zhaohus {
	display: inline-block;
}

#zhaohu_manager_zhaohu_search_advanced_container .elgg-input-dropdown {
	width: 100px;
}

#zhaohu_manager_zhaohu_search_advanced_container .elgg-input-date {
	width: 100px;
}

/* Zhaohu view */

.zhaohu-manager-zhaohu-view-image {
	float: right;
	margin: 10px;
	background: #FFFFFF;
}

#zhaohu_details_information{
	padding-left: 10px;
}

.zhaohu-manager-zhaohu-map {
	vertical-align: top;
	margin-top: 10px;
	background: #FFFFFF;	
	width: 100%;
	border: 1px solid #DEDEDE;
}

.zhaohu-comments{
	float: left;
	padding-left: 10px;
}

.zhaohu-manager-zhaohu-title {
	margin-top: 0px;
	margin-bottom: 15px;
	font-size: 32px;
	line-height: 32px;
}

#zhaohu-video iframe{
	width: 530px;
	height: 315px;
}

#zhaohu_user_actions{
	padding-left: 10px;
	padding-bottom: 10px;
	padding-top: 10px;
}

.zhaohu-manager-zhaohu-description {
	padding: 10px;
	background: #FFFFFF;
	width: 90%
}

div.zhaohu-manager-zhaohu-list-attendees {
	min-height: 100px;
	margin-top: 10px
}

div#addthisevent{
	margin: 10px 0;
}

div.zhaohu-right-sidebar{
	padding: 0;
	background-color: rgb(248, 248, 248);
}

.zhaohu-manager-zhaohu-view-attendees > div > h3{
	font-size: 13px;
}

.zhaohu-manager-zhaohu-view-attendees > div.elgg-head > h3 > a{
	color: #55ACEE;
	font-size: 12px;
	text-decoration: underline;
}

.zhaohu-manager-zhaohu-view-attendees > div.elgg-head{
	margin-bottom: 0px;
}

.zhaohu-manager-zhaohu-view-attendees .elgg-avatar {
	float: left;
	margin-right: 5px;
}

.zhaohu-attendee-item{
	margin: 1px;
}

div#zhaohu_operations_header{
	text-align: center;
	background: #e4e4e4;
	padding: 5px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	font-size: 13px;
	font-weight: bold;
	margin-bottom: 5px;
}

.zhaohu-attendee-image{
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	border: 1px solid #eeeeee;
}

.user-profile-image{
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	border: 1px solid #eeeeee;
}

.zhaohu-manager-zhaohu-details label {
	white-space: nowrap;
	padding-right: 20px;
	font-size: 100%;
}

.zhaohu-manager-zhaohu-details .elgg-output {
	margin: 0px;
}

/* Zhaohu tool links */

.zhaohu_manager_zhaohu_actions {
	background: url(<?php echo $graphics_folder; ?>arrows_down.png) right center no-repeat;
	padding-right: 15px;
	cursor: pointer;
	font-weight: bold;
}

/* google maps */
.gmaps_infowindow,
.gmaps_infowindow_text div.zhaohu_manager_zhaohu_view_owner {
	font-size: 11px;
}

.gmaps_infowindow_text {
	float: left;
	width: 250px;
}

.gmaps_infowindow_icon {
	float: right;
	height: 100px;
	width: 100px;
	padding: 10px;
	border: 1px solid #CCCCCC;
}

.addthisevent {
	display: none;
}

.addthisevent_dropdown {
	display: none;
	right: 0px;
	left: inherit !important;
	position: absolute;
	padding: 10px 0;
	background: white;
	border: 1px solid #CCC;
}

.addthisevent_dropdown span {
	display: block;
	white-space: nowrap;
	color: #4690D6;
	padding: 5px 15px;
}

.addthisevent_dropdown span:hover {
	color: white;
	background: #4690D6;
	cursor: pointer;
}

.elgg-input-plaintext {
	width: 60%;
	height: 60px;
}

/* ***************************************
	TABS
*************************************** */
.elgg-tabs {
	margin-bottom: 5px;
	border-bottom: 1px solid #3399FF;
	display: table;
	width: 100%;
}
.elgg-tabs li {
	float: left;
	border: 1px solid #3399FF;
	border-bottom-width: 0;
	margin: 0 0 0 10px;
	background: #FFFFFF;
}
.elgg-tabs a {
	text-decoration: none;
	display: block;
	padding: 3px 10px 0 10px;
	text-align: center;
	height: 21px;
}
.elgg-tabs a:hover {
	background: #dedede;
}
.elgg-tabs .elgg-state-selected {
	border-color: #3399FF;
	background: white;
}
.elgg-tabs .elgg-state-selected a {
	position: relative;
	top: 2px;
	background: white;
}

.elgg-sidebar {
    background: #FFFFFF;
}

.elgg-layout-one-sidebar {
	background-color: rgb(248, 248, 248);
}

.zhaohu-edit-tags {
    width:20em;
    height:5em;
    border:solid 1px #c0c0c0;
    overflow:auto;
}

div#zhaohu_search_and_result_div {
	width: 990px;
	margin: 5px auto;
	position: relative;
	top: -33px;
	min-height: 220px;
}

div#zhaohu_search_result_div{
	margin-top: 20px;
	margin-bottom: 20px;
}

div#zhaohu_search_div{
	width: 650px;
	margin: auto;
	background-image: -moz-linear-gradient(#ededed, silver);
	background-image: -webkit-linear-gradient(#ededed, silver);
	background-image: linear-gradient(#ededed, silver);
	background-repeat: repeat-x;
	border-bottom-color: #000;
	text-shadow: none;
	padding: 2px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	position: relative;
}

.zhaohu-search-div-input{
	margin: 5px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	padding: 5px;
	font-size: 16px;
	color: #333;
	background-color: #FFF;
	height: 30px;
}

div.zhaohu-group-search-result{
	margin: 10px;
	border: #999;
	border-style: solid;
	border-width: 1px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	height: 220px;
	width: 220px;
	position: relative;
	background-color: #F4F4F4;
	background-position: center center;
	background-repeat: no-repeat;
	background-size: cover;
	cursor: pointer;
}

div.zhaohu-group-search-result-text {
	position: absolute;
	bottom: 0px;
	font-size: 15px;
	width: 220px;
	height: 40px;
	background-color: white;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=85)";
	filter: alpha(opacity=85);
	-moz-opacity: 0.85;
	-khtml-opacity: 0.85;
	opacity: 0.85;
	-webkit-border-radius: 0px 0px 5px 5px;
	-moz-border-radius: 0px 0px 5px 5px;
	border-radius: 0px 0px 5px 5px;
}

a.zhaohu-group-search-result-link{
	display: inline-block;
	line-height: 40px;
	margin-left: 5px;
	font-size: 13px;
}

div.zhaohu-group-search-result img{
	-webkit-border-radius: 4px 4px 0px 0px;
	-moz-border-radius: 4px 4px 0px 0px;
	border-radius: 4px 4px 0px 0px;
}

img.zhaohu-featured-icon-search-result{
	display: block;
	position: relative;
	left: 11px;
	width: 18px;
}

div.zhaohu-featured-group-div{
	border: 1px solid white;
	padding: 1px;
	width: 40px;
	position: relative;
	background: gold;
	left: 160px;
	top: 6px;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=85)";
	filter: alpha(opacity=85);
	-moz-opacity: 0.85;
	-khtml-opacity: 0.85;
	opacity: 0.85;
	-webkit-border-radius: 60px;
	-moz-border-radius: 60px;
	border-radius: 60px;
}

img.zhaohu-featured-event-icon{
	display: block;
	position: relative;
	left: 11px;
	width: 18px;
}

div.zhaohu-featured-event-div{
	border: 1px solid white;
	padding: 1px;
	width: 40px;
	position: relative;
	background: gold;
	left: 0px;
	top: 20px;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=85)";
	filter: alpha(opacity=85);
	-moz-opacity: 0.85;
	-khtml-opacity: 0.85;
	opacity: 0.85;
	-webkit-border-radius: 60px;
	-moz-border-radius: 60px;
	border-radius: 60px;
}

div.zhaohu-group-inprofile{
	margin: 10px;
	position: relative;
	width: 100px;
}

#zhaohu_profile_joined_groups > .elgg-gallery > li{
	vertical-align: top;
}

.in-profile-group-icon{
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	border: 1px solid #e8e8e8;
}

#zhf_tag_input {
	width: 260px;
}

#zhf_state_input {
	width: 50px;
}

#zhf_city_input {
	width: 80px;
}

#zhge_i_dd{
    width: 400px;
    background: #FFFFFF;
    padding: 5px 2px 5px 2px;
    position: absolute;
    white-space: nowrap;
    border-color: #CCCCCC;
    border-style: solid;
	z-index: 10;
    border-width: 1px 1px 1px 1px;
    list-style-type: none;
    display: none;
    -webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
}

#zhe_i_dd{
    width: 400px;
    background: #FFFFFF;
    padding: 5px 2px 5px 2px;
    position: absolute;
    white-space: nowrap;
    border-color: #CCCCCC;
    border-style: solid;
	z-index: 10;
    border-width: 1px 1px 1px 1px;
    list-style-type: none;
    display: none;
    -webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
}

#zhp_interest_dd {
    width: 400px;
    background: #FFFFFF;
    padding: 5px 2px 5px 2px;
    position: absolute;
    white-space: nowrap;
    border-color: #CCCCCC;
    border-style: solid;
	z-index: 10;
    border-width: 1px 1px 1px 1px;
    list-style-type: none;
    display: none;
    -webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
}

#zhf_tag_dd {
    width: 400px;
    background: #FFFFFF;
    padding: 5px 2px 5px 2px;
    position: absolute;
    left: -60px;
    white-space: nowrap;
    border-color: #CCCCCC;
    border-style: solid;
	z-index: 10;
    border-width: 1px 1px 1px 1px;
    list-style-type: none;
    display: none;
    -webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
}

#zhf_city_dd {
    width: 500px;
    background: #FFFFFF;
    padding: 5px 2px 5px 0;
    position: absolute;
    left: 150px;
    white-space: nowrap;
    border-color: #CCCCCC;
    border-style: solid;
	z-index: 10;
    border-width: 1px 1px 1px 1px;
    list-style-type: none;
    display: none;
    -webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
}

.zh-state-dd {
    background: #FFFFFF;
    padding: 5px 2px 5px 0;
    position: absolute;
    left: 293px;
    white-space: nowrap;
    border-color: #CCCCCC;
    border-style: solid;
	z-index: 10;
    border-width: 1px 1px 1px 1px;
    list-style-type: none;
    display: none;
    -webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;    
}

.zh-state-dd:before, .zh-state-dd:after {
    content: ".";
    position: absolute;
    left: 10px;
    top: -10px;
    display: block;
    width: 0px;
    height: 0px;
    font-size: 0px;
    line-height: 0;
    border-style: solid;
    border-width: 0px 10px 10px;
    border-color: transparent transparent #FFF;
}

.zh-state-dd li {
	padding: 0 18px 0 10px;
	line-height: 18px;
}

.zht_dd {
    display: none;
    border-color: #CCCCCC;
}
.zht_dd:before, .zht_dd:after {
    content: ".";
    position: absolute;
    top: -10px;
    display: block;
    width: 0px;
    height: 0px;
    font-size: 0px;
    line-height: 0;
    border-style: solid;
    border-width: 0px 10px 10px;
    border-color: transparent transparent #FFF;
}
/* city drop down div position */
.zht_dd_city_position:before, .zht_dd_city_position:after{
	left: 225px;
}
/* tag drop down div position */
.zht_dd_tag_position:before, .zht_dd_tag_position:after{
	left: 180px;
}

.zht_dd li {
    line-height: 20px;
    text-align: center;
    padding: 0px 9px;
    margin: 0px;
    box-sizing: border-box;
    border-right: 1px solid #EEE;
}

.zht_dd ul {
    list-style-type: none;
    float: left;
    width: 25%;
    padding-left: 0px;
    margin-bottom: 12px;
}

div.find_result_entities{
	position: relative;
	width: 500px;
	float: left;
	display: none;
	background-color: white;
	border: 1px solid #CCCCCC;
	padding: 5px 15px;
}

img.zhaohu-hot-topics-icon{
	width: 160px;
	height: 160px;
	margin-left: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}

div.zh-group-info-sidbar{
	padding-left: 0px;
}

.zhaohu-join-button{
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ffc477), color-stop(1, #fb9e25) );
	background:-moz-linear-gradient( center top, #ffc477 5%, #fb9e25 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffc477', endColorstr='#fb9e25');
	color:#FFF;
	padding: 4px 20px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	margin-top: 5px;
	margin-right: 10px;
	display: inline-block;
	font-size: 14px;
}

.zhaohu-join-button:hover{
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #fb9e25), color-stop(1, #ffc477) );
	background:-moz-linear-gradient( center top, #fb9e25 5%, #ffc477 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#fb9e25', endColorstr='#ffc477');
	background-color:#fb9e25;
	color: white;
	text-decoration: none;
}

.zhaohu-invite-button{
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #F5DA81), color-stop(1, #FACC2E) );
	background:-moz-linear-gradient( center top, #F5DA81 5%, #FACC2E 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#F5DA81', endColorstr='#FACC2E');
	color:#FFF;
	padding: 4px 20px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	margin-top: 5px;
	margin-right: 10px;
	display: inline-block;
	font-size: 14px;
}

.zhaohu-invite-button:hover{
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #FACC2E), color-stop(1, #F5DA81) );
	background:-moz-linear-gradient( center top, #FACC2E 5%, #F5DA81 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#FACC2E', endColorstr='#F5DA81');
	background-color:#FACC2E;
	color: white;
	text-decoration: none;
}

#contactus input[type="submit"]{
	background-color:#FE9A20;
	color:#FFF;
	padding: 4px 20px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	margin-top: 10px;
	margin-right: 10px;
	display: inline-block;
	font-size: 14px;
}

#contactus input[type="submit"]:hover{
	background-color:#FE8A20;
	color: white;
	text-decoration: none;
	cursor: pointer;
}

#contactus #scaptcha{
	height: 22px;
}

.zhaohu-manager-zhaohu-view-icon img{
	border:1px solid #e8e8e8;
	padding: 2px;
}

.recommended-zhaohu-item-div img{
	width: 67px;
}

.recommended-zhaohu-item-div{
	padding-left: 5px;
	padding-bottom: 5px;
	font-size: 12px;
}

.recommended-zhaohu-item-title{
	font-size: 14px;
	padding-bottom: 5px;
}

.zhaohu-image-block div.elgg-content{
	margin: 5px 0px;
}

div.zhaohu-image-block{
	padding: 10px 0px;
}

div#zhaohu_homepage_left_side_bar{
	width: 200px;
	float: left;
	position: relative;
}

div#zhaohu_homepage_right_side_bar{
	width: 240px;
	float: right;
	position: relative;
}

div#zhaohu_popular_interests_header{	
	font-size: 16px;
	font-weight: bold;
	padding-left: 15px;
	padding-top: 10px;
	padding-bottom: 10px;
	
}

div#zhaohu_hot_topics_header{	
	font-size: 16px;
	font-weight: bold;
	padding-left: 15px;
	padding-top: 10px;
	padding-bottom: 10px;
	
}

a#more_recommended_zhaohus{
	padding-left: 15px;
	font-size: 12px;
}

div.zhaohu-homepage-right-sidebar-div-footer{
	padding-bottom: 5px;
}

div.zhaohu-homepage-left-sidebar-div{
	width: 180px;
	border: 1px solid #CCCCCC;
	margin-bottom: 20px;
	background-color: white;
}

ul#zhaohu_homepage_popular_interests_list{
	border-top: 1px solid #CCCCCC;
	
}

li.zhaohu-homepage-popular-interest{
	border-bottom: 1px solid #CCCCCC;
	font-size: 15px;
	line-height: 35px;
}

li.zhaohu-homepage-popular-interest > a{
	display: block;
	padding-left: 25px;
}

li.zhaohu-homepage-popular-interest > a:hover{
	background-color: #EEE;
}

li.zhaohu-homepage-popular-interest > a > img{
	padding-left: 80px;
	vertical-align: middle;
}

div.zhaohu-homepage-right-sidebar-div{
	width: 240px;
	border: 1px solid #CCCCCC;
	margin-bottom: 20px;
	background-color: white;
}

div.zhaohu-homepage-right-sidebar-div img#wechat_qrcode_image{
	width: 240px;
}

div.zhaohu-homepage-right-sidebar-div-header{
	font-size: 16px;
	font-weight: bold;
	padding-top: 10px;
	padding-left: 15px;
}

div.zhaohu-homepage-right-sidebar-div-content{
	
}

img.zhaohu-social-media-icon{
	width: 40px;
	height: 40px;
	border: 1 solid #ccc;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	margin: 5px;
}

ul#zhaohu_homepage_follow_us_list{
	padding-left: 10px;
	padding-top: 5px;
	padding-bottom: 5px;
}

li.zhaohu-homepage-social-media{
	display: inline;
}

.zh-share div{
  float: left;
  margin-left: 10px;
}

.zh-login div{
  float: left;
  margin-right: 10px;
}

.paypal_btn{
 padding-top: 5px;
 width : 185px;
}


