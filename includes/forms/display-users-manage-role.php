<?php
/**
 * Required file for Manage user roles.
 * @package  	DisplayUsers
 * @subpackage  wp-display-users/includes/forms/display-users-manage-role
 * @author   	Devnath verma
 * @version  	2.0.0
 */
global $wpdb; 
class DU4WP_Manage_Rule_Table extends WP_List_Table {
    
	var $display_users_manage_rule_data;
	var $found_data;
	
	function __construct() {
		
		global $wpdb, $status, $page;
		parent::__construct( array(
				'singular'  => 'display-user',    
				'plural'    => 'display-users',  
				'ajax'      => false       
		) );
		
		if( $_GET['page'] == 'display-users' && ! empty( $_POST['s'] ) ) {
			
			$query = 'SELECT * FROM '.$wpdb->prefix.'display_users WHERE title LIKE "%'.$_POST['s'].'%"';
		
		} else {
			
			$query = 'SELECT * FROM '.$wpdb->prefix.'display_users';
		}
			
		$this->display_users_manage_rule_data = $wpdb->get_results( $query, ARRAY_A );
		add_action( 'admin_head', array( &$this, 'admin_header' ) );            
	}
	
	function admin_header() {
		
		$page = ( isset( $_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
		if( 'display-users' != $page )
		return;
		
		echo '<style type="text/css">';
		echo '.wp-list-table .column-title  { width: 20%; }';
		echo '.wp-list-table .column-user_shortcode  { width: 20%;}';
		echo '</style>';
	}
	  
	function no_items() {
		
		echo 'No records founds in database.';
	}
		
	function column_default( $item, $column_name ) {
		
		switch( $column_name ) {
			case 'title': 
			case 'user_shortcode':
			default:
			return $item[$column_name] ; //Show the whole array for troubleshooting purposes
		}
	}
	
	function get_sortable_columns() {
		
		$sortable_columns = array(
			'title'   			=> array( 'title', false ),
			'user_shortcode'   	=> array( 'user_shortcode', false )
		);
		
		return $sortable_columns;
	}
	
	function get_columns() {
		
		$columns = array(
			'cb'        		=> '<input type="checkbox" />',
			'title' 			=> 'Title',
			'user_shortcode'  	=> 'Shortcode'
		);
		
		return $columns;
	}
	
	function usort_reorder( $a, $b ) { 
	 
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : '';
		$order = ( ! empty( $_GET['order'] ) ) ? $_GET['order'] : 'asc';
		$result = strcmp( $a[$orderby], $b[$orderby] );
		return ( $order === 'asc' ) ? $result : -$result;
	}
	
	function column_title( $item ) {
		
		$actions = array(
			'edit'   => sprintf('<a href="?page=%s&tab=manage-role&action=%s&id=%s">Edit</a>',$_REQUEST['page'],'edit',$item['id']),
			'delete' => sprintf('<a href="?page=%s&tab=manage-role&action=%s&id=%s">Delete</a>',$_REQUEST['page'],'delete',$item['id'])
		);
		
		return sprintf('%1$s %2$s', $item['title'], $this->row_actions($actions) );
	}
	
	function get_bulk_actions() {
		
		$actions = array( 'delete' => 'Delete' );
		
		return $actions;
	}
	
	function column_cb($item) {
		
		return sprintf( '<input type="checkbox" name="id[]" value="%s" />', $item['id'] );
	}
	
	function column_user_shortcode( $item ) {
		
		return sprintf( '[wp_display_user id='.$item["id"].']' );
	}
	
	function prepare_items() {
		
		$columns  = $this->get_columns();
		$hidden   = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );
		usort( $this->display_users_manage_rule_data, array( &$this, 'usort_reorder' ) );
	
		$per_page = 10;
		$current_page = $this->get_pagenum();
		$total_items = count( $this->display_users_manage_rule_data );
		$this->found_data = array_slice( $this->display_users_manage_rule_data,( ( $current_page-1 )* $per_page ), $per_page );
		$this->set_pagination_args( array( 'total_items' => $total_items, 'per_page' => $per_page ) );
		$this->items = $this->found_data;
	}
}

if( ! empty( $_GET['action'] ) && $_GET['action'] == 'delete' && ! empty( $_GET['id'] ) && $_GET['tab'] == 'manage-role' ) {

	$wpdb->delete( $wpdb->prefix.'display_users', array( 'id' => $_GET['id'] ) );
	$display_users_messages = __( 'Selected record deleted successfully.', 'wp-display-users' );	
}

if( ! empty( $_POST['action'] ) && $_POST['action'] == 'delete' && ! empty( $_POST['id'] ) && $_GET['tab']== 'manage-role' ) {

	foreach( $_POST['id'] as $id ) {
	
		$wpdb->delete( $wpdb->prefix.'display_users', array( 'id' => $id ) );
	}

    $display_users_messages = __( 'Selected record deleted successfully.', 'wp-display-users' );
}

if( ! empty( $_GET['action'] ) && $_GET['action'] == 'edit' && ! empty( $_GET['id'] ) ) {
	
	if ( isset( $_POST['display_users_update'] ) ) {
		
		if ( empty( $_POST['title'] ) ) {
		
			$display_users_error = __('Please enter role title.', 'wp-display-users');
		}
		
		$display_users_data = array( 
			'title' => $_POST['title'],
			'data' 	=> serialize( $_POST['display_user_data'] )
		);
		
		if ( ! empty( $display_users_error ) ) {
				
			echo '<div class="display-users-error">';
			echo $display_users_error;
			echo '</div>';
		
		} else {
		
			$wpdb->update( $wpdb->prefix.'display_users', $display_users_data, array( 'id' => $_GET['id'] ) );
			$display_users_messages = __( 'Role updated successfully.', 'wp-display-users' );
		}
	}	

	$display_users_data = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'display_users WHERE id='.$_GET['id'].'' );
	$_POST = (array)$display_users_data;
	$_POST['display_user_data'] = unserialize($display_users_data->data);
    include DU4WP_PLUGIN_INCLUDES . 'forms/display-users-add-role.php';

} else {
    
	if( ! empty( $display_users_messages ) ) {
		echo '<div id="message" class="display-users-update">';
		echo $display_users_messages;
		echo '</div>';
	}	
	
	$display_users_manage_rule_table = new DU4WP_Manage_Rule_Table();
	$display_users_manage_rule_table->prepare_items();
	echo '<form method="post">';
	$display_users_manage_rule_table->search_box( 'search', 'search_id' );
	$display_users_manage_rule_table->display();
	echo '</form> ';
}