<?php
/**
 * Remove options on plugin delete.
 *
 * @package  DisplayUsers
 * @version	 2.0.0
 * @author   Devnath verma
 */

/**
 * @uses int $blog_id
 * @uses object $wpdb
 * @uses delete_option()
 * @uses is_multisite()
 * @uses switch_to_blog()
 * @uses wp_get_sites()
 */

if( ! defined('WP_UNINSTALL_PLUGIN') ) {
	
  	die( 'You are not allowed to call this page directly.' );
}

global $wpdb, $blog_id;

// Remove settings for all sites in multisite
if( is_multisite() ) {
	
  	$blogs = wp_get_sites();
  
  	foreach($blogs as $blog) {
	  
		switch_to_blog( $blog->blog_id );
		
    	$wpdb->query( 'DROP TABLE IF EXISTS '.$wpdb->prefix.'display_users' );
  	}
  
} else {
  
	$wpdb->query( 'DROP TABLE IF EXISTS '.$wpdb->prefix.'display_users' );
}