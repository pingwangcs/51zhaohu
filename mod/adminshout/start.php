<?php
/**
 * AdminShout - send an email message to all site users and group members
 *
 * @package AdminShout
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author slyhne (forked from original Curverider plugin)
 * @link http://zurf.dk/elgg
*/ 

elgg_register_event_handler('init','system','adminshout_init');
function adminshout_init() {

	// Extend CSS
	elgg_extend_view('css/elgg', 'adminshout/css');

	//elgg_register_event_handler('pagesetup', 'system', 'adminshout_pagesetup');

	elgg_register_action("adminshout/siteshout", elgg_get_plugins_path() . "adminshout/actions/siteshout.php", 'admin');

	// admin interface to send site messages
	elgg_register_menu_item('page', array(
					'name' => 'adminshout',
					'href' => elgg_get_site_url() . "admin/adminshout/siteshout",
					'text' => elgg_echo('admin:adminshout'),
					'context' => 'admin',
					'priority' => 201,
					'section' => 'administer'
					));

}

