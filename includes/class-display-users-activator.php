<?php
/**
 * Fired during plugin activation.
 * This class defines all code necessary to run during the plugin's activation.
 * @package  DisplayUsers
 * @version	 2.0.0
 * @author   Devnath verma
 */
 
class DU4WP_Register_Activator {
		
	/**
	 * Create table
	 * @package  DisplayUsers
	 * @version	 2.0.0
	 * @author   Devnath verma
	 */
	public static function display_users_activate() {
		
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			
		$display_users_table = 'CREATE TABLE IF NOT EXISTS `'.$wpdb->prefix.'display_users` (
								`id` int(11) NOT NULL AUTO_INCREMENT,
								`title` varchar(255) NOT NULL,
								`data` text DEFAULT NULL,
								 PRIMARY KEY (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;';
		dbDelta( $display_users_table );
	}
}