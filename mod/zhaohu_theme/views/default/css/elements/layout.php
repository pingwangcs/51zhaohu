<?php
/**
 * Page Layout
 *
 * Contains CSS for the page shell and page layout
 *
 * Default layout: 990px wide, centered. Used in default page shell
 *
 * @package Elgg.Core
 * @subpackage UI
 */
?>

/* ***************************************
	PAGE LAYOUT
*************************************** */
/***** DEFAULT LAYOUT ******/
<?php // the width is on the page rather than topbar to handle small viewports ?>
.elgg-page-default {
	min-width: 998px;
}
.elgg-page-default .elgg-page-header > .elgg-inner {
	width: 990px;
	margin: 0 auto;
	height: 90px;
}
.elgg-page-default .elgg-page-body > .elgg-inner {
	
}
.elgg-page-default .elgg-page-footer > .elgg-inner {
	width: 990px;
	margin: 0 auto;
	padding: 5px 0;
	text-align: center;
}

/***** TOPBAR ******/
.elgg-page-topbar {
	//background: #333333 url(<?php echo elgg_get_site_url(); ?>_graphics/toptoolbar_background.gif) repeat-x top left;
	background: white;
	border-bottom: 1px solid white;
	position: relative;
	height: 79px;
	z-index: 10;
}
.elgg-page-topbar > .elgg-inner {
    padding-top: 0px;
    padding-bottom: 0px;
    padding-left: 8px;
    padding-right: 8px;
	width: 990px;
	margin: 0 auto;
}

/***** PAGE MESSAGES ******/
.elgg-system-messages {
	position: fixed;
	top: 10px;
	left: 50%;
	width: 300px;
	margin-left: -150px;
	text-align: center;
	z-index: 2000;
}
.elgg-system-messages li {
	margin-top: 10px;
}
.elgg-system-messages li p {
	margin: 0;
}

/***** PAGE BODY LAYOUT ******/
.elgg-layout {
	min-height: 360px;
}
.elgg-layout-one-sidebar {
	width: 990px;
	margin: 5px auto;
}
.elgg-layout-two-sidebar {
	background: transparent url(<?php echo elgg_get_site_url(); ?>_graphics/two_sidebar_background.gif) repeat-y right top;
	width: 990px;
	margin: 5px auto;
	padding-top: 10px;
}
.elgg-layout-one-column
{
}
.elgg-layout-error {
	margin-top: 20px;
}
.elgg-sidebar {
	position: relative;
	padding: 20px 10px;
	float: right;
	width: 200px;
	margin: 0 0 0 10px;
}
.elgg-sidebar-alt {
	position: relative;
	padding: 20px 10px;
	float: left;
	width: 160px;
	margin: 0 10px 0 0;
}
.elgg-main {
	position: relative;
	min-height: 360px;
}
.elgg-main > .elgg-head {
	padding-bottom: 3px;
	border-bottom: 1px solid #CCCCCC;
	margin-bottom: 10px;
}

/***** PAGE FOOTER ******/
.elgg-page-footer {
	background: white;
	position: relative;
	height: 4em;
}
.elgg-page-footer {
	color: #999;
}
.elgg-page-footer a:hover {
	color: #666;
}

/***** Zhaohu theme ******/
.elgg-page{
}

