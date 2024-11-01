<?php
/**
 * Loads and defines the internationalization files for this plugin so that it is ready for translation.
 * @package  DisplayUsers
 * @version	 2.0.0
 * @author   Devnath verma
 */
 
class DU4WP_Register_Textdomain {

	/**
	 * Load the plugin text domain for translation.
  	 * @package  DisplayUsers
	 * @version	 2.0.0
	 * @author   Devnath verma
	 */
	public static function display_users_textdomain() {
		
		load_plugin_textdomain(
			'wp-display-users',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages'
		);
	}
}