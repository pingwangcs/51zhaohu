<?php
/*
 *  zhaohu_theme mobile css 
 */
?>

#zhaohu_mobile_topbar{
	background-color: rgba(254,104,23, 0.9);
	display: -ms-flexbox;
	display: -webkit-flex;
	display: flex;
	-ms-flex-direction: row;
	-webkit-flex-direction: row;
	flex-direction: row;
	position: fixed;
	width: 100%;
	top: 0px;
	left: 0px;
	z-index: 20;
}

#zhaohu_mobile_topbar_photo_wall{
	border: 1px solid rgb(255, 255, 255);
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	padding: 1px 3px;
	line-height: 32px;
	display: flex;
	display: -ms-flexbox;
	display: -webkit-flex;
	margin: 4px;
	font-weight:bold;
<!-- 	background-color: rgb(255, 255, 255); -->
	color:white;
	text-decoration:none;
}

#zhaohu_mobile_topbar #profile{
	border: 1px solid rgb(255, 255, 255);
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	display: flex;
	display: -ms-flexbox;
	display: -webkit-flex;
	padding: 1px;
	margin: 4px 8px;
}

#zhaohu_mobile_topbar #profile img{
	width: 32px;
	height: 32px;

}

#zhaohu_mobile_topbar_login{
	border: 1px solid rgb(255, 255, 255);
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	margin: 4px 8px;
	padding: 1px 4px;
	line-height: 32px;
	font-weight: bold;
}

#zhaohu_mobile_logo{
	-ms-flex: 1 1;
	-webkit-flex: 1 1;
	flex: 1 1;
}

#zhaohu_mobile_topbar a{
	color: white;
}

#zhaohu_mobile_search_img{
	width: 32px;
	height: 32px;
}

#zhaohu_mobile_logo img{
	height: 40px;
	margin-left: 5px;
}

#search_location_state{
	font-size: 16px;
	width: 90px;
	margin: 5px 5px;
}

#zhaohu_mobile_zhaohu_search{
	background-color: rgba(254,104,23, 0.9);
	display: -ms-flexbox;
	display: -webkit-flex;
	display: flex;
	-ms-flex-direction: row;
	-webkit-flex-direction: row;
	flex-direction: row;
	position: fixed;
	width: 100%;
	top: 45px;
	left: 0px;
	z-index: 20;
	font-size: 16px;
}

#zhaohu_homepage_recommended_zhaohus{
	margin-top: 46px;
}

#zhaohu_mobile_search_input{
	border: 1px solid #ccc;
	color: #666;
	font: 120% Arial, Helvetica, sans-serif;
<!-- 	width: 65%; -->
	flex: 1 1;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	font-size: 16px;
	padding: 0 15px;
	height: 40px;
	margin-bottom: 2px;
}

#zhaohu_mobile_search_button{
	display:block;
	border: 1px solid rgb(255, 255, 255);
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	padding: 1px 3px;
	line-height: 32px;
	display: flex;
	display: -ms-flexbox;
	display: -webkit-flex;
	margin: 0 4px;
	display: flex;
	display: -ms-flexbox;
	display: -webkit-flex;
	width: 50px;
	margin-bottom: 2px;
}

#zhaohu_details_information_mobile{
	margin: 5px 0px;
	text-align: center;
	font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
}

@media (min-width:768px){
	.zhaohu-mobile-view-body{
		width:750px;
	}
}

@media (min-width:992px){
	.zhaohu-mobile-view-body{
		width:970px;
	}
}

@media (min-width:1200px){
	.zhaohu-mobile-view-body{
		width:1170px;
	}
}

.zhaohu-mobile-view-body{
	margin-right: auto;
	margin-left: auto;
	font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
}

.zhaohu-view-image-mobile {
	border: 1px solid #ccc;
	padding: 5px;
	background-color: white;
}

.zhaohu_info_mobile{
	text-align: left;
	background: rgba(255,255,255,0.7);
	margin-right: auto;
	margin-left: auto;
	padding-left: 15px;
	padding-right: 15px;
	width: 90%;
	font-size: 14px;
}

.zhaohu_details_mobile{
	text-align: left;
	background: rgba(255,255,255,0.7);
	margin-right: auto;
	margin-left: auto;
	padding-left: 15px;
	padding-right: 15px;
	width: 90%;
	font-size: 14px;
}

.zhaohu_more_mobile{
	text-align: left;
	background: rgba(255,255,255,0.7);
	margin: 15px auto auto auto;
	padding-left: 15px;
	padding-right: 15px;
	width: 90%;
	font-size: 14px;
}

.zhaohu-title-mobile{
	font-size: 18px;
	font-weight: bold;
	margin-bottom: 5px;
	text-align: center;
<!-- 	background: -moz-linear-gradient(left, rgba(255,255,255,0.01) 0%, rgba(255,255,255,0.23) 13%, rgba(255,255,255,0.5) 29%, rgba(255,255,255,0.67) 50%, rgba(255,255,255,0.55) 71%, rgba(255,255,255,0.36) 81%, rgba(255,255,255,0) 100%); -->
<!-- 	background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(255,255,255,0.01)), color-stop(13%,rgba(255,255,255,0.23)), color-stop(29%,rgba(255,255,255,0.5)), color-stop(50%,rgba(255,255,255,0.67)), color-stop(71%,rgba(255,255,255,0.55)), color-stop(81%,rgba(255,255,255,0.36)), color-stop(100%,rgba(255,255,255,0))); -->
<!-- 	background: -webkit-linear-gradient(left, rgba(255,255,255,0.01) 0%,rgba(255,255,255,0.23) 13%,rgba(255,255,255,0.5) 29%,rgba(255,255,255,0.67) 50%,rgba(255,255,255,0.55) 71%,rgba(255,255,255,0.36) 81%,rgba(255,255,255,0) 100%); -->
<!-- 	background: -o-linear-gradient(left, rgba(255,255,255,0.01) 0%,rgba(255,255,255,0.23) 13%,rgba(255,255,255,0.5) 29%,rgba(255,255,255,0.67) 50%,rgba(255,255,255,0.55) 71%,rgba(255,255,255,0.36) 81%,rgba(255,255,255,0) 100%); -->
<!-- 	background: -ms-linear-gradient(left, rgba(255,255,255,0.01) 0%,rgba(255,255,255,0.23) 13%,rgba(255,255,255,0.5) 29%,rgba(255,255,255,0.67) 50%,rgba(255,255,255,0.55) 71%,rgba(255,255,255,0.36) 81%,rgba(255,255,255,0) 100%); -->
<!-- 	background: linear-gradient(to right, rgba(251,158,37,0.01) 0%,rgba(251,158,37,0.23) 13%,rgba(251,158,37,0.5) 29%,rgba(251,158,37,0.67) 50%,rgba(251,158,37,0.55) 71%,rgba(251,158,37,0.36) 81%,rgba(251,158,37,0) 100%); -->
}

.zhaohu-join-button-mobile{
	border: 1px solid;
	width: 90%;
	display: block;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #378de5), color-stop(1, #79bbff) );
	background: -moz-linear-gradient( center top, #378de5 5%, #79bbff 100% );
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff');
	text-align: center;
	text-transform: uppercase;
	color: #fff;
	line-height: 1;
	padding: 0.7em 1em;
	margin: 5px auto;
	font-size: 16px;
	font-weight: bold;
}

.switch-view-mobile{
	border: 1px solid;
	width: 60px;
	display: block;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #378de5), color-stop(1, #79bbff) );
	background: -moz-linear-gradient( center top, #378de5 5%, #79bbff 100% );
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff');
	text-align: center;
	color: #fff;
	padding: 5px 5px;
	font-size: 16px;
	font-weight: bold;
}

.profile-home-mobile{
	display: block;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	color: #4690D6;
	margin: 15px auto;
	font-size: 26px;
	font-weight: bold;
}

.zhaohu-mobile-body{
	padding: 0 10px;
}

.zhaohu-contact-us-head{
	font-size: 20px;
	font-weight: bold;
}

#zhaohu_contact_us_details{
	width: 90%;
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
	width: 90%;
	margin: 5px 5px;
	line-height: 20px
}

.zhaohu-contact-us-join-us{
	border: 1px solid #DEDEDE;
	padding: 5px 15px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	width: 90%;
	margin: 15px auto;
	line-height: 20px;
	display: inline-block;
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

div.zhaohu-one-column{
	min-height: 360px;
	width: 100%;
	margin: 0 auto;
}

form#contactus{
	margin: 0 auto;
	display: block;
	width: 95%;
	margin-bottom: 10px;
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
