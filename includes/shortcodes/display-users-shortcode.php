<?php
/**
 * Fetching results from database.
 * @package  	DisplayUsers
 * @subpackage  wp-display-users/includes/shortcodes/display-users-shortcode
 * @author   	Devnath verma
 * @version  	2.0.0
 */
global $wpdb;
if( ! empty( $atts['id'] ) ) {
	$display_users_data = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'display_users WHERE id='.$atts['id'].'' );
	if( empty( $display_users_data ) ) return;

	$unserialize_user_data = unserialize($display_users_data->data);
	echo '<div class="display-user-container">';
		
		$user_args['role'] 		= $unserialize_user_data['user_role'];
		$user_args['orderby'] 	= $unserialize_user_data['user_order_by'];
		$user_args['order']   	= $unserialize_user_data['user_order'];
		
		if( isset( $unserialize_user_data['user_filter'] ) && $unserialize_user_data['user_filter'] == 'include' ) {
	
			if( ! empty( $unserialize_user_data['user_id'] ) )
				$user_args['include'] = $unserialize_user_data['user_id'];
			else
				$user_args['include'] = '';
		}
		
		if( isset( $unserialize_user_data['user_filter'] ) && $unserialize_user_data['user_filter'] == 'exclude' ) {
			
			if( ! empty( $unserialize_user_data['user_id'] ) )
				$user_args['exclude'] = $unserialize_user_data['user_id'];
			else
				$user_args['exclude'] = '';
		}
		
		if( isset( $unserialize_user_data['user_limit'] ) && ! empty( $unserialize_user_data['user_limit'] ) )
			$user_args['number'] 	= $unserialize_user_data['user_limit']; 
		else
			$user_args['number'] 	= 10;
		
		if ( get_query_var( 'paged' ) )
			$paged = get_query_var( 'paged' ); 
		else if( get_query_var( 'page' ) )
			$paged = get_query_var( 'page' ); 
		else 
			$paged = 1; 
		
		$user_args['offset'] = ($paged - 1) * $user_args['number'];
		
		$user_query = new WP_User_Query( $user_args );
		
		if ( ! empty( $user_query->results ) ) {
			foreach ( $user_query->results as $user ) { 
				echo '<div class="display-user-container-inner display-user-avatar-align-'.$unserialize_user_data['user_avatar_align'].' display-user-avatar-shape-'.$unserialize_user_data['user_avatar_shape'].'">';
						if( isset( $unserialize_user_data['user_avatar'] ) && $unserialize_user_data['user_avatar'] == 'yes' ) :
							echo get_avatar( $user->ID, $unserialize_user_data['user_avatar_size'] );
						endif; 
							 
						if( isset( $unserialize_user_data['user_name'] ) && $unserialize_user_data['user_name'] == 'yes' ) : 
							echo '<h6 class="display-user-title">';  
								if( ! empty( get_the_author_meta( 'display_name', $user->ID ) ) ) :
									echo get_the_author_meta( 'display_name', $user->ID ); 
								endif;
							echo '</h6>';  
						endif; 
						
						if( isset( $unserialize_user_data['user_description'] ) && $unserialize_user_data['user_description'] == 'yes' ) :							echo '<p class="description">';  
								if( ! empty( get_the_author_meta( 'description', $user->ID ) ) ) :
									echo wp_trim_words( get_the_author_meta( 'description', $user->ID ), absint( $unserialize_user_data['user_description_length'] ), '&hellip;' ) ;
								endif;
							echo '</p>'; 
						endif;
						
						if( isset( $unserialize_user_data['user_email'] ) && $unserialize_user_data['user_email'] == 'yes' ) :
							echo '<span class="display-user-icon">'; 
								if( ! empty( get_the_author_meta( 'email', $user->ID ) ) ) :
									echo '<b>Email:</b> '. get_the_author_meta( 'email', $user->ID ) .'<br />';  
								endif;
							echo '</span>';
						endif; 
						if( isset( $unserialize_user_data['user_website'] ) && $unserialize_user_data['user_website'] == 'yes' ) : 
							echo '<span class="display-user-icon">';
								if( ! empty( get_the_author_meta( 'url', $user->ID ) ) ) :
									echo '<b>Website:</b> '. get_the_author_meta( 'url', $user->ID ) .'<br />';  
								endif;
							echo '</span>';
						endif;
				echo '</div>';
			}
		}
		
		$total_user = $user_query->total_users;  
		$total_pages = ceil( $total_user / $user_args['number'] );
		echo '<div class="display-users-pagination">';
		$current_page = max( 1, get_query_var('paged') );
		echo paginate_links( array( 'base' => get_pagenum_link(1) . '%_%', 'format' => 'page/%#%/', 'current' => $current_page, 			'total' => $total_pages, 'prev_next' => true, 'type' => 'list' ) );
		echo '</div>';
	echo '</div>';
}