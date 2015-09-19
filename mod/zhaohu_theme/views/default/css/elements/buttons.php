<?php
/**
 * CSS buttons
 *
 * @package Elgg.Core
 * @subpackage UI
 */
?>
/* **************************
	BUTTONS
************************** */

/* Base */
.elgg-button {
	font-size: 14px;
	
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;

	width: auto;
	padding: 2px 4px;
	cursor: pointer;
	outline: none;
	
	-webkit-box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.40);
	-moz-box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.40);
	box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.40);
}
a.elgg-button {
	padding: 3px 6px;
}

/* Submit: This button should convey, "you're about to take some definitive action" */
.elgg-button-submit {
	color: white;
	text-decoration: none;
	border: 1px solid #55ACEE;
	background: #55ACEE;
	padding: 4px 10px;
}

.elgg-button-submit:hover {
	border-color: #0054a7;
	text-decoration: none;
	color: white;
	background: #0054a7;
}

.elgg-button-submit.elgg-state-disabled {
	background: #999;
	border-color: #999;
	cursor: default;
}

.elgg-button-submit[disabled] {
	color: #DEDEDE;
	background: #999;
	border-color: #999;
	cursor: default;
}

/* Cancel: This button should convey a negative but easily reversible action (e.g., turning off a plugin) */
a.elgg-button-cancel {
	color: #333;
	background: #ddd;
	border: 1px solid #999;
	padding: 4px 10px;
}
a.elgg-button-cancel:hover {
	color: #444;
	background-color: #999;
	background-position: left 10px;
	text-decoration: none;
}

/* Action: This button should convey a normal, inconsequential action, such as clicking a link */
.elgg-button-action {
	background: #55ACEE;
	border: 1px solid #55ACEE;
	color: #fff;
	padding: 2px 15px;
	text-align: center;
	text-decoration: none;
	cursor: pointer;
	
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	
	margin-top: 10px;
	margin-right: 10px;
	display: inline-block;
}

.elgg-button-action:hover,
.elgg-button-action:focus {
	background-color: #0054a7;
	color: white;
	text-decoration: none;
}

/* Delete: This button should convey "be careful before you click me" */
.elgg-button-delete {
	color: #fff;
	text-decoration: none;
	border: 1px solid #333;
	background: #555;
}
.elgg-button-delete:hover {
	color: #fff;
	background-color: #333;
	background-position: left 10px;
	text-decoration: none;
}

.elgg-button-dropdown {
	padding:3px 6px;
	text-decoration:none;
	display:block;
	font-weight:bold;
	position:relative;
	margin-left:0;
	color: white;
	border:1px solid #71B9F7;
	
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	border-radius:4px;
	
	-webkit-box-shadow: 0 0 0;
	-moz-box-shadow: 0 0 0;
	box-shadow: 0 0 0;
	
	/*background-image:url(<?php echo elgg_get_site_url(); ?>_graphics/elgg_sprites.png);
	background-position:-150px -51px;
	background-repeat:no-repeat;*/
}

.elgg-button-dropdown:after {
	content: " \25BC ";
	font-size:smaller;
}

.elgg-button-dropdown:hover {
	background-color:#71B9F7;
	text-decoration:none;
}

.elgg-button-dropdown.elgg-state-active {
	background: #ccc;
	outline: none;
	color: #333;
	border:1px solid #ccc;
	
	-webkit-border-radius:4px 4px 0 0;
	-moz-border-radius:4px 4px 0 0;
	border-radius:4px 4px 0 0;
}

.zhaohu-search {
	-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
	-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
	box-shadow:inset 0px 1px 0px 0px #ffffff;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #79bbff), color-stop(1, #378de5) );
	background:-moz-linear-gradient( center top, #79bbff 5%, #378de5 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#79bbff', endColorstr='#378de5');
	
	background-color:#ededed;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	display:inline-block;
	text-indent:0;
	border:1px solid #dcdcdc;
	display:inline-block;
	color:#ffffff;
	font-family:Arial;
	font-size:15px;
	font-weight:bold;
	font-style:normal;
	height:31px;
	line-height:31px;
	width:95px;
	text-align:center;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #528ecc;
	margin: 5px;
}
.zhaohu-search:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #378de5), color-stop(1, #79bbff) );
	background:-moz-linear-gradient( center top, #378de5 5%, #79bbff 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff');
	background-color:#378de5;
	color:#ffffff;
	text-decoration:none;
}.zhaohu-search:active {
	position:relative;
	top:1px;
}

.zhaohu-action {
	width: 78px;
	display: inline-block;
	padding: 5px;
	margin: 2px;
	color: #333;
	cursor: pointer;
	text-decoration: none;
	margin-bottom: 2px;
	border: 1px solid #CCC;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	text-align: center;
	background: white;
}

.zhaohu-action:hover {
	text-decoration: none;
	background: #4690D6;
	color: white;
	border: 1px solid #4690D6;
}

.switch-view {
	font-size: 16px;
}