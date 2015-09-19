<?php
/*
 *  zhaohu_theme css 
 */
?>

.zhaohu-topbar-div{
	height: 52px; /* need to match .elgg-menu-topbar > li */
<!-- 	font-family: Tahoma, Geneva, sans-serif; -->
	
}

div.zhaohu-topbar-div:hover{
	
}

/* login and register link in top bar*/
.zhaohu-topbar-login-reg-link{
	border: 1px solid #55ACEE;
	padding: 5px 24px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	margin-top: 26px;
}


a.zhaohu-topbar-login-reg-link:hover{
	background-color: #55ACEE;
	color: white;
	text-decoration: none;
}

div.zhaohu-topbar-special-div > a {
	color: orange;
	text-decoration: underline;
	font-weight: bold;
}

div.zhaohu-topbar-special-div > a:hover {
	background-color: orange;
}

.zhaohu-topbar-func-div > a {
	font-size: 20px;
	line-height: 80px;
	display: block;
	color: #55ACEE;
	padding-left: 8px;
	padding-right: 8px;
	transition: all 0.2s linear;
}

.zhaohu-topbar-func-div > a:hover {
	color: white;
	background-color: #55ACEE;
	text-decoration: none;
}

.zhaohu-topbar-profile-img{
	height: 40px;
	width: 40px;
	webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
}

.zhaohu-heading-main{
	color: black;
	font-size: 22px;
}

.social-buttons {
	display: inline;
	height: 25px;
	float: left;
	overflow:visible;
}

.social-buttons div{
  	display: inline;
  	float: left;
	overflow:visible;
	position:relative;
	vertical-align:top;
	padding-right: 10px;
	height: 25px;
}

.zhaohu-footer{
	margin: 15px auto;
}

.zhaohu-footer > a{
	color: #999;
}

.zhaohu-list {
	border-top: 1px dotted #CCCCCC;
	margin: 5px 0;
	clear: both;
}
.zhaohu-list > li {
	border-bottom: 1px dotted #CCCCCC;
}

div.zhaohu_highlight{
	background-image: url(<?php echo elgg_get_site_url(); ?>mod/zhaohu_theme/images/table_game.png);
	position: relative;
	background-position: center center;
	background-repeat: no-repeat;
	background-size: cover;
	height: 350px;
	color: white;
	width: 90%;
	margin: 0 auto;
}

div.highlight-zhaohus{
	display: none;
	position: absolute;
	right: 20px;
	background-color: #999;
	width: 280px;
	height: 370px;
	webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";       /* IE 8 */
	filter: alpha(opacity=70);  /* IE 5-7 */
	-moz-opacity: 0.7;          /* Netscape */
	-khtml-opacity: 0.7;        /* Safari 1.x */
	opacity: 0.7;
}

.latest-zhaohus-header{
	margin: 8px auto;
	width: 90px;
	font-size: 16px;
	font-weight: bold;
	color: floralwhite;
}

.latest_zhaohu_item{
	left: 5px;
	position: relative;
	padding: 5px;
}

.latest_zhaohu_item_title{
	font-size: 14px;
}

.latest_zhaohu_item_title > a{
	color: darkred;
	text-decoration: underline;
}

.latest_zhaohu_item_time{
	font-size: 12px;
	color: floralwhite;
}

.latest_zhaohu_item_author{
	font-size: 12px;
}

div.latest_zhaohu_item_author a{
	color: black;
	text-decoration: underline;
}

div#zhaohu_user_welcome_div{
	position: relative;
	background-color: #C2E5E9;
	background-position: center center;
	background-repeat: no-repeat;
	background-size: cover;
	height: 350px;
	color: white;
}

div#zhaohu_user_welcome_content_div{
	height: 210px;
	position: relative;
	top: 85px;
	width: 990px;
	margin: 0 auto;
}

div#zhaohu_user_welcome_message_div{
	padding: 30px;
	position: relative;
	float:left;
	top: 0px;
	left: 100px;
	height: 100px;
	width: 430px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	background-color: #999;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";       /* IE 8 */
	filter: alpha(opacity=70);  /* IE 5-7 */
	-moz-opacity: 0.7;          /* Netscape */
	-khtml-opacity: 0.7;        /* Safari 1.x */
	opacity: 0.7;
}

div#zhaohu_user_welcome_hello{
	font-size: 22px;
	font-weight: bold;
	margin: 5px;
	margin-bottom: 15px;
}

div#zhaohu_user_welcome_message{
	font-size: 18px;
	line-height: 30px;
	margin: 5px;
}

div#zhaohu_user_welcome_summary_div{
	float: right;
	width: 360px;
	height: 150px;
	top: 10px;
	right: 20px;
	position: relative;
}

div.zhaohu_user_welcome_group_number{
	font-size: 22px;
	webkit-border-radius: 50px;
	-moz-border-radius: 50px;
	border-radius: 50px;
	width: 50px;
	height: 50px;
	display: inline-block;
	line-height: 50px;
	text-align: center;
	border: solid;
	margin: 0 5px;
	text-decoration: underline;
	cursor: pointer;
}

div.zhaohu_user_welcome_group_string{
	font-size: 18px;
	margin: 10px 0;
	color: #999;
}

div.zhaohu-home-page{
	min-height: 360px;
}

div.zhaohu-one-column{
	min-height: 360px;
	width: 90%;
	margin: 0 auto;
}

.zhaohu-profile{
	float: left;
	margin-bottom: 15px;
	margin-top: 10px;
}

.social_connect_site_connect{
	padding: 0px;
}

a {
color: #55ACEE;
}

#zhaohu_profile_joined_groups{
	margin-top: 20px;
	border-top: 1px solid #e8e8e8;
	padding-top: 10px;
}


/*** ownerblock ***/
#zhaohu-profile-owner-block {
	width: 200px;
	float: left;
	background-color: #F4F4F4;
	padding: 5px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	border: 1px solid #e8e8e8;
}
#zhaohu-profile-owner-block .large {
	margin-bottom: 10px;
}
#zhaohu-profile-owner-block a.elgg-button-action {
	margin-bottom: 4px;
	display: table;
}

#zhaohu_profile_picture_edit{
	width: 740px;
	float: left;
	margin-left: 20px;
	margin-bottom: 20px;
}

#zhaohu_profile_edit{
	width: 740px;
	float: left;
	margin-left: 20px;
	margin-bottom: 20px;
}

#zhaohu_profile_settings{
	width: 740px;
	float: left;
	margin-left: 20px;
	margin-bottom: 20px;
}

.group-info-bar-tags{
	width: 200px
}

.zhaohu-zhaohu-about{
	margin-top: 20px;
	border-top: 1px solid #DEDEDE;
	min-height: 40px;
	padding: 10px;
}

a.zhaohu-help-link{
	font-size: 13px;
	color: white;
	display: inline-block;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	border: 1px solid #e8e8e8;
	background-color: #FE8A20;
	padding: 3px 6px;
	line-height: 13px;
	
}

a.zhaohu-help-link:hover{
	text-decoration: none;
	cursor: pointer;
	background-color: #f55d6a;
}

.zhaohu-zhaohu-about-part{
	width: 50%;
	float: left;
}

.zhaohu-zhaohu-about-inner{
	padding: 10px;
	font-size: 14px;
	line-height: 20px;
	min-height: 280px;
}

.zhaohu-zhaohu-about-inner > h3{
	padding-bottom: 6px;
}

.zhaohu-zhaohu-about-service-terms{
	padding: 20px;
}

.zhaohu-zhaohu-about-video{
	text-align: center;
	padding: 10px;
}

.zhaohu-zhaohu-about-text{
	font-size: 16px;
	line-height: 26px;
	margin-top: 15px;
}

#zhaohu_contact_us{
	margin: 20px;
	border-top: 1px solid #DEDEDE;
	padding-top: 20px;
}

.zhaohu-contact-us-head{
	font-size: 20px;
	font-weight: bold;
}

.zhaohu-zhaohu-about-help-center-title{
	font-size: 20px;
	font-weight: bold;
	text-align: center;
}

.zhaohu-zhaohu-about-help-center{
	line-height: 25px;
}

.zhaohu-zhaohu-about-help-center > h3{
	padding-top: 15px;	
}

.zhaohu-zhaohu-about-help-center > img{
	vertical-align:middle;
} 

#zhaohu_contact_us_details{
	width: 400px;
	margin: 0 auto;
	border: 1px solid #DEDEDE;
	padding: 5px 15px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	margin-bottom: 15px;
}

.zhaohu-contact-us-person{
	border: 1px solid #DEDEDE;
	padding: 5px 15px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	display: block;
	float: left;
	width: 45%;
	min-height: 100px;
	margin: 5px 5px;
	line-height: 20px
}

.zhaohu-contact-us-join-us{
	border: 1px solid #DEDEDE;
	padding: 5px 15px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	width: 400px;
	margin: 0 auto;
	line-height: 20px;
	display: inline-block;
	margin-left: 259px;
}

#zhaohu_contact_us_details > p{
	margin-bottom: 0px;
}

form#contactus{
	margin: 0 auto;
	display: block;
	width: 522px;
	margin-bottom: 10px;
}

 /* style for about pages */

p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:0in;
	line-height:115%;
	font-size:11.0pt;
	font-family:Calibri;}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{margin:0in;
	margin-bottom:.0001pt;
	font-size:11.0pt;
	font-family:Calibri;}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{margin:0in;
	margin-bottom:.0001pt;
	font-size:11.0pt;
	font-family:Calibri;}
zhaohu-zhaohu-about a:link, span.MsoHyperlink
	{color:blue;
	text-decoration:underline;}
zhaohu-zhaohu-about a:visited, span.MsoHyperlinkFollowed
	{color:purple;
	text-decoration:underline;}
.MsoChpDefault
	{font-size:11.0pt;
	font-family:Calibri;}
.MsoPapDefault
	{margin-bottom:10.0pt;
	line-height:115%;}
 /* Page Definitions */
@page WordSection1
	{size:8.5in 11.0in;
	margin:1.0in 1.0in 1.0in 1.0in;}
div.WordSection1
	{page:WordSection1;}
 /* List Definitions */
zhaohu-zhaohu-about ol
	{margin-bottom:0in;}
zhaohu-zhaohu-about ul
	{margin-bottom:0in;}
	
p.zhaohu-policy-statement-title{
	text-align: center;
	font-size: 22px;
}

p.zhaohu-policy-statement-header{
	font-size: 18px;
}

.zhaohu-register-terms-link{
	font-size: 14px;
	text-decoration: underline;
}

div.zhaohu-arrow-div{
	display: inline-block;
	position: relative;
	top: 180px;
}

div#zhaohu_homepage_left_arrow_div{
	left: 100px;
	top: -200px;
	position: relative;
}

div#zhaohu_homepage_right_arrow_div{
	top: -200px;
	right: -85%;
	position: relative;
}

.zhaohu-arrow-img{
	width: 40px;
}

a#zhaohu-homepage-background-link {
    display: block;
    height: 100%;
    width: 100%;
    text-decoration: none;
}

div#zhaohu_highlight_div{
	-webkit-transition: background 1.0s ease-in-out;
	-moz-transition: background 1.0s ease-in-out;
	-o-transition: background 1.0s ease-in-out;
	-ms-transition: background 1.0s ease-in-out;
	transition: background 1.0s ease-in-out;
}

.elgg-page-body{
	background-color: rgb(248, 248, 248);
	border-top: 1px solid #DEDEDE;
	border-bottom: 1px solid #DEDEDE;
}