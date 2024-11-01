<?php
/**
 * @package   DisplayUsers
 * @author    Devnath verma
 * @license   GPL-2.0+
 * © Copyright 2020 Devnath verma (devnathverma@gmail.com)
 *
 * @wordpress-plugin
 * Plugin Name:       Display Users
 * Plugin URI:        https://github.com/devnathverma/wp-display-users/
 * Description:       A plugin used for display user listing on post, page and sidebar widgets.
 * Version:           2.0.0
 * Author:            Devnath verma
 * Author Email:      devnathverma@gmail.com
 * Text Domain:       wp-display-users
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path:       /languages/
 * GitHub Plugin URI: https://github.com/devnathverma/wp-display-users/
*/
 
/*----------------------------------------------------------------------------*
 * If this file is called directly, abort.
 *-----------------------------------------------------------------------------*/

if( !defined( 'ABSPATH' ) ) {
	
	die( 'You are not allowed to call this page directly.' );
}

if( ! class_exists('WP_Display_Users') ) {
	
	class WP_Display_Users {
		
		/**
		 * Instance of this class.
		 * @version  2.0.0
		 * @access   public
		 * @var      string $_display_users_instance The plugin name to be used in the WP Display Users Plugin.
		 */
		public static $_display_users_instance;
		
		/**
		 * The options data to be used in the WP Display Users Plugin.
		 * @version  2.0.0
		 * @access   public
		 * @var      string $display_users_plugin_options The options data to be used in the WP Display Users Plugin.
		 */
		public $display_users_plugin_options;
		
		/**
		 * The settings class object to be used in the WP Display Users Plugin.
		 * @version  2.0.0
		 * @access   public
		 * @var      string $display_users_return_setting_object The settings class object to be used in the WP Display Users Plugin.
		 */
		public $display_users_return_setting_object;
		
		/**
		 * The class object to be used in the WP Display Users Plugin.
		 * @since    2.0.0
		 * @access   public
		 * @var      string $display_users_object The class object to be used in the WP Display Users Plugin.
		 */
		public $display_users_object;
	
		
		/**
		 * Return an instance of this class.
		 * @package  DisplayUsers
		 * @version	 2.0.0
		 * @author   Devnath verma
		 */
		public static function display_users_instance() {
			
			// If the single instance hasn't been set, set it now.
			if ( self::$_display_users_instance === null )
			self::$_display_users_instance = new self();
	
			return self::$_display_users_instance;
		}
	
		/**
		 * Initialize the class and set its properties.
		 */
		public function __construct() {
	
			register_activation_hook( __FILE__, array( $this, 'display_users_register_activation' ) );
			register_deactivation_hook( __FILE__, array( $this, 'display_users_register_deactivation' ) );
			add_action( 'init', array($this, 'display_users_init') );
			add_action( 'widgets_init' , array( $this, 'display_users_widgets_init' ) );
			$this->display_users_define_constants();
			$this->display_users_internationalization_i18n();
		}
		
		/**
		 * The code that runs during plugin activatation.
		 * @package  DisplayUsers
		 * @version	 2.0.0
		 * @author   Devnath verma
		 */
		public function display_users_register_activation() {
			
			if ( ! current_user_can( 'activate_plugins' ) ) return;
			require_once DU4WP_PLUGIN_INCLUDES . 'class-display-users-activator.php';
			DU4WP_Register_Activator::display_users_activate();
		}
		
		/**
		 * The code that runs during plugin deactivation.
		 * @package  DisplayUsers
		 * @version	 2.0.0
		 * @author   Devnath verma
		 */
		public function display_users_register_deactivation() {
			
			if ( ! current_user_can( 'activate_plugins' ) ) return;
			require_once DU4WP_PLUGIN_INCLUDES . 'class-display-users-deactivator.php';
			DU4WP_Register_Dectivator::display_users_dectivate();
		}
		
		/**
	     * Register required widgets
	     * @package  DisplayUsers
		 * @version	 2.0.0
		 * @author   Devnath verma
		 */
		public function display_users_widgets_init() {

			include DU4WP_PLUGIN_INCLUDES . 'widget/display-users-widget.php';
			register_widget( 'Display_Users_Widget' );
		}
		
		/**
		 * This function used to load text domain for multilanguages.
		 * @package  DisplayUsers
		 * @version	 2.0.0
		 * @author   Devnath verma
		 */	
		public function display_users_internationalization_i18n() {
			
		 	require_once DU4WP_PLUGIN_INCLUDES . 'class-display-users-textdomain.php';
			DU4WP_Register_Textdomain::display_users_textdomain();
		}
		
		/**
	     * Call wordpress actions
		 * @package  DisplayUsers
		 * @version	 2.0.0
		 * @author   Devnath verma
		 */
		public function display_users_init() { 
			
			add_action( 'admin_menu', array( $this, 'display_users_admin_menu') );
			add_action( 'admin_print_styles', array( $this, 'display_users_admin_styles' ) );
			add_action( 'wp_enqueue_scripts' , array( $this, 'display_users_public_scripts' ) );
			add_action( 'plugin_action_links', array( $this, 'display_users_plugin_setting_links' ), 10, 2 );
			add_shortcode( 'wp_display_user', array( $this, 'display_users_return_shortcode' ) );
		}
		
		/**
	     * Define Constants
	     * @package  DisplayUsers
		 * @version	 2.0.0
		 * @author   Devnath verma
		 */
		public function display_users_define_constants() {
			
			define( 'DU4WP_PLUGIN_FOLDER', basename( dirname(__FILE__) ) );
			define( 'DU4WP_PLUGIN_PATH', plugin_dir_path(__FILE__) );
			define( 'DU4WP_PLUGIN_URL', plugins_url( '', __FILE__ ) );
			define( 'DU4WP_PLUGIN_REL_PATH', dirname( plugin_basename( __FILE__ ) ) . '/' );
			define( 'DU4WP_PLUGIN_INCLUDES', DU4WP_PLUGIN_PATH.'includes'.'/' );
			define( 'DU4WP_PLUGIN_LANGUAGES', DU4WP_PLUGIN_PATH.'languages'.'/' );	
			define( 'DU4WP_PLUGIN_URL', plugin_dir_url(DU4WP_PLUGIN_FOLDER).DU4WP_PLUGIN_FOLDER.'/' );
			define( 'DU4WP_PLUGIN_CSS', DU4WP_PLUGIN_URL.'/assets/css'.'/' );
			define( 'DU4WP_PLUGIN_JS', DU4WP_PLUGIN_URL.'/assets/js'.'/' );
			define( 'DU4WP_PLUGIN_IMAGES', DU4WP_PLUGIN_URL.'/assets/images'.'/' );
			define( 'DU4WP_PLUGIN_FONTS', DU4WP_PLUGIN_URL.'/assets/fonts'.'/' );
		}

		/**
		 * This function used to create menus on admin section.
		 * @package  DisplayUsers
		 * @version	 2.0.0
		 * @author   Devnath verma
		 */	
        public function display_users_admin_menu() {
			
			// Create Admin Menus
			add_menu_page(
				__( 'Display Users', 'wp-display-users' ), 
				__( 'Display Users', 'wp-display-users' ), 
				'manage_options', 
				'display-users', 
				array( $this, 'display_users_menu_page' ),
				'dashicons-groups'
			);
		}
		
		/**
	     * Create tabs menu used in plugin
	     * @package  DisplayUsers
		 * @version	 2.0.0
		 * @author   Devnath verma
		 */
		public function display_users_menu_page() {
        	
			if( $_GET['action'] == 'edit' && isset( $_GET['id'] ) )
				$menu_role = __( 'Edit Role', 'wp-display-users' );
			else
				$menu_role = __( 'Add Role', 'wp-display-users' );
			
			$menu_tabs = array(
				'add-role' 		=> $menu_role,  
                'manage-role' 	=> __( 'Manage Roles', 'wp-display-users' )
            );
			
			echo '<div class="display_users_container">';
					echo '<div class="pt-4 col-md-10">';
            			echo '<img src="'.DU4WP_PLUGIN_IMAGES.'display-users-logo.JPG" alt="branding" class="label-icon-default">';
						echo '<ul id="display-users-navigation" class="display-users-navigation-tab">';
					
							if( ! empty( $_GET['tab'] ) ) {
				
								$current_tab = $_GET['tab']; 
							
							} else {
				
								$current_tab = 'add-role'; 
							}
				
							foreach( $menu_tabs as $tab_key => $tab_title ) {
							  
								$active_tab = '';
							  
								if( $current_tab == $tab_key ) {                           
									
									$active_tab = 'display-users-navigation-tab-active';
								}
							  
								echo '<li>';
								echo '<a class="display-users-nav-tab ' . $active_tab . '" href="'.admin_url('admin.php?page=display-users&tab='.$tab_key).'">'. $tab_title .'</a>';
								echo '</li>';
							}
		
						echo '</ul>';
				
						switch( $current_tab ) {
							
							case 'add-role' : 
								$this->display_users_add_role(); 
								break;
							case 'manage-role' : 
								$this->display_users_manage_role(); 
								break;   
							default : 
								$this->display_users_add_role(); 
								break;           
						}
				
					echo '</div>';
			echo '</div>';	
        }
		
		/**
	     * Add user role
	     * @package  DisplayUsers
		 * @version	 2.0.0
		 * @author   Devnath verma
		 */
        public function display_users_add_role() {
        
            include DU4WP_PLUGIN_INCLUDES . 'forms/display-users-add-role.php';
        }
		
		/**
	     * Manages all user roles
	     * @package  DisplayUsers
		 * @version	 2.0.0
		 * @author   Devnath verma
		 */
		public function display_users_manage_role() {

            if( !class_exists( 'WP_List_Table' ) )
			require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
            include DU4WP_PLUGIN_INCLUDES . 'forms/display-users-manage-role.php';
        }
		
		/**
	     * Includes shortcode file for front view used in plugin
	     * @package  DisplayUsers
		 * @version	 2.0.0
		 * @author   Devnath verma
		 */
		public function display_users_return_shortcode( $atts ) {
			
		 	 ob_start();
			 include DU4WP_PLUGIN_INCLUDES . 'shortcodes/display-users-shortcode.php';
			 $content = ob_get_contents();
	         ob_clean();
	      	 return $content;
		}
		
		/**
	     * Load JS and CSS in backend
	     * @package  DisplayUsers
		 * @version	 2.0.0
		 * @author   Devnath verma
		 */
		public function display_users_admin_styles() {

            if( is_admin() ) { 
                
				wp_enqueue_style( 'display-users-bootstrap', DU4WP_PLUGIN_CSS.'display-users-bootstrap.css' );
                wp_enqueue_style( 'display-users-admin', DU4WP_PLUGIN_CSS.'display-users-admin.css' );
            }
        }
		
		/**
	     * Load js and css in frontend section
	     * @package  DisplayUsers
		 * @version	 2.0.0
		 * @author   Devnath verma
	     */
		public function display_users_public_scripts() {
			
			wp_enqueue_style( 'display-users-public', DU4WP_PLUGIN_CSS.'display-users-public.css' );
		}
		
		/**
		 * Add links to settings page.
		 * @param array $widget_links
		 * @param string $widget_file
		 * @return array
		 * @package  DisplayUsers
		 * @version	 2.0.0
		 * @author   Devnath verma
		 */
		public function display_users_plugin_setting_links( $widget_links, $widget_file ) {
			
			if ( ! is_admin() || ! current_user_can( 'manage_options' ) )
			return $widget_links;
	
			static $plugin;
	
			$plugin = plugin_basename( __FILE__ );
	
			if ( $widget_file == $plugin ) {
				
				$settings_link = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php' ) . '?page=display-users', __( 'Settings', 'wp-display-users' ) );
				
				array_unshift( $widget_links, $settings_link );
			}
	
			return $widget_links;
		}
		
    } // END class WP_Display_Users
	
} // END if( ! class_exists( 'WP_Display_Users' ) )


function WP_Display_Users() {
		
	static $display_users_instance;

	//first call to display_users_instance() initializes the plugin
	if ( $display_users_instance === null || ! ($display_users_instance instanceof WP_Display_Users) )
	$display_users_instance = WP_Display_Users::display_users_instance();
	
	return $display_users_instance;
}

WP_Display_Users();