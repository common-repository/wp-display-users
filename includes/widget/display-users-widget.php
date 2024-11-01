<?php
/**
 * Class responsible for display users on frontend.
 * @package  	DisplayUsers
 * @subpackage  wp-display-users/includes/widget/display-users-widget
 * @author   	Devnath verma
 * @version  	2.0.0
 */
if ( ! class_exists( 'Display_Users_Widget' ) ) {

	class Display_Users_Widget extends WP_Widget {
	
		/**
		 * WP Display Users widget class.
		 * @package  DisplayUsers
		 * @version  2.0.0
		 * @author   Devnath verma
		 */
		public function __construct() {
			
			// Set up the widget options.
			$widget_options = array(
				'classname'   => 'wp-display-users',
				'description' => __( 'A widget that display the users.', 'wp-display-users' ),
				'customize_selective_refresh' => true
			);
			
			// Control the width and height
			$control_options = array(
				'id_base' => 'wp-display-users'
			);
			
			// Create the widget
			parent::__construct( 'wp-display-users', __( 'Display Users', 'wp-display-users' ), $widget_options, $control_options );
		}
		
		/**
		 * Display the form to edit widget settings.
		 * @param array $instance The widget settings.
		 */
		public function form( $instance ) {
			
			global $wpdb;
			$display_users_roles = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'display_users' );
		 
			// Extract the array to allow easy use of variables.
			extract( $instance ); ?>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title :' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"  value="<?php echo esc_attr( $instance['title'] ); ?>">
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('role_id');?>">
					<?php _e( 'Select Role :' ); ?> 
				</label> 
				<?php if( $display_users_roles ) { ?>
					<select class="widefat" id="<?php echo $this->get_field_id('role_id'); ?>" name="<?php echo $this->get_field_name( 'role_id' ); ?>">		<option value="">Select Role</option>
						<?php foreach($display_users_roles as $users_roles){  ?>
							<option value="<?php echo $users_roles->id; ?>"<?php selected( $users_roles->id, $instance['role_id'] ); ?>>								<?php echo $users_roles->title; ?>
							</option>
						<?php } ?>
					</select>
				<?php } ?>
			</p> 
		
		<?php }
		
		/**
		 * Display the widget.
		 * Filters the instance data, fetches the output, displays it.
		 * @param array $args  Registered sidebar arguments including before_title, after_title, before_widget, and after_widget.
	 	 * @param array $instance The widget instance settings.
		 */
		public function widget( $args, $instance ) { 
			
			global $wpdb;
			extract( $args );
			$instance['title'] 	= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'] );
			$atts['id']			= $instance['role_id'];
			
			// Output the theme's $before_widget wrapper.
			echo $args['before_widget'];
			
			// If the title not empty, display it.
			if ( isset( $instance['title'] ) && ! empty( $instance['title'] ) ) {
					
				echo $args['before_title'] . $instance['title'] . $args['after_title'];
			} 
			
			include DU4WP_PLUGIN_INCLUDES . 'shortcodes/display-users-shortcode.php';
			
			// Close the theme's widget wrapper.
			echo $args['after_widget']; 
		}
		
		/**
		 * Save and sanitize widget settings.
		 * @param array  $new_instance New widget settings.
		 * @param array  $old_instance Previous widget settings.
		 * @return array Sanitized settings.
		 */
		public function update( $new_instance, $old_instance ) {
			
			$instance = $old_instance;
			$instance['title'] 	 = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['role_id'] = (int)$new_instance['role_id'];
			return $instance;
		}
	}
}	