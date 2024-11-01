<?php 
/**
 * Required file for add user role.
 * @package  	DisplayUsers
 * @subpackage  wp-display-users/includes/forms/display-users-add-role
 * @author   	Devnath verma
 * @version  	2.0.0
 */
global $wpdb, $wp_roles;
if ( isset( $_POST['display_users_save'] ) ) { 
	
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
				
		$wpdb->insert( $wpdb->prefix.'display_users', $display_users_data );
		$display_users_messages = __( 'Role created successfully.', 'wp-display-users' );
		$_POST = '';
	}
} 	

if( ! empty( $display_users_messages ) ) {
	echo '<div id="message" class="display-users-update">';
	echo $display_users_messages;
	echo '</div>';
}			
?>

<form id="display-users-wizard-form" class="display-users-wizard-form" action="" method="post">	
	<div class="row">
		<div class="form-group col-md-2">
			<label for="title">
				<?php _e( 'Role Title', 'wp-display-users' ); ?><span style="color:#F00;">*</span>
			</label>
		</div>
		<div class="form-group col-md-10">
			<input type="text" name="title" id="title" class="form-control" value="<?php if( isset( $_POST['title'] ) ) { echo $_POST['title']; } ?>" />
			<p class="description">
				<?php _e( 'Please enter here role title.', 'wp-display-users' ); ?>
			</p>
		</div>
	</div>
    <div class="row">
		<div class="form-group col-md-2">
			<label for="user_role">
				<?php _e( 'Select Role', 'wp-display-users' ); ?>
			</label>
		</div>
		<div class="form-group col-md-10">
			<?php if( ! empty( $wp_roles->get_names() ) ) { ?>
				<select name="display_user_data[user_role]" id="user_role" class="form-control">
					<?php foreach( $wp_roles->get_names() as $key => $user_role ) { ?>
						<option value="<?php echo $user_role; ?>"<?php if( isset( $_POST['display_user_data']['user_role'] ) ) { selected( $_POST['display_user_data']['user_role'], $user_role ); } ?>>		<?php echo $user_role; ?>
						</option>
					<?php } ?>
				</select>
			<?php } ?>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-2">
			<label for="user_order">
				<?php _e( 'Order', 'wp-display-users' ); ?>
			</label>
		</div>
		<div class="form-group col-md-4">
			<select name="display_user_data[user_order]" id="user_order" class="form-control">
				<option value="ASC"<?php if( isset( $_POST['display_user_data']['user_order']) ) { selected( $_POST['display_user_data']['user_order'], 'ASC' ); } ?>>
					<?php _e( 'Ascending', 'wp-display-users' ); ?>
				</option>
				<option value="DESC"<?php if( isset( $_POST['display_user_data']['user_order']) ) { selected( $_POST['display_user_data']['user_order'], 'DESC' ); } ?>>
					<?php _e( 'Descending', 'wp-display-users' ); ?>
				</option>
			</select>
		</div>
		<div class="form-group col-md-2">
			<label for="user_order_by">
				<?php _e( 'Order By', 'wp-display-users' ); ?>
			</label>
		</div>
		<div class="form-group col-md-4">
			<select name="display_user_data[user_order_by]" id="user_order_by" class="form-control">
				<option value="ID"<?php if( isset( $_POST['display_user_data']['user_order_by']) ) { selected( $_POST['display_user_data']['user_order_by'], 'ID'); } ?>>
					<?php _e( 'ID', 'wp-display-users' ); ?>
				</option>
				<option value="display_name"<?php if( isset( $_POST['display_user_data']['user_order_by'] ) ) { selected( $_POST['display_user_data']['user_order_by'],'display_name' ); } ?>>		<?php _e( 'Display Name', 'wp-display-users' ); ?>
				</option>
				<option value="user_name"<?php if( isset( $_POST['display_user_data']['user_order_by'] ) ) { selected( $_POST['display_user_data']['user_order_by'],'user_name' ); } ?>>		<?php _e( 'User Name', 'wp-display-users' ); ?>
				</option>
				<option value="user_login"<?php if( isset( $_POST['display_user_data']['user_order_by'] ) ) { selected( $_POST['display_user_data']['user_order_by'],'user_login' ); } ?>>		<?php _e( 'User Login', 'wp-display-users' ); ?>
				</option>
				<option value="user_nicename"<?php if( isset( $_POST['display_user_data']['user_order_by'] ) ) { selected( $_POST['display_user_data']['user_order_by'],'user_nicename' ); } ?>>	<?php _e( 'User Nicename', 'wp-display-users' ); ?>
				</option>
				<option value="user_email"<?php if( isset( $_POST['display_user_data']['user_order_by'] ) ) { selected( $_POST['display_user_data']['user_order_by'],'user_email' ); } ?>>		<?php _e( 'User Email', 'wp-display-users' ); ?>
				</option>
				<option value="post_count"<?php if( isset( $_POST['display_user_data']['user_order_by'] ) ) { selected( $_POST['display_user_data']['user_order_by'],'post_count' ); } ?>>		<?php _e( 'Post Count', 'wp-display-users' ); ?>
				</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-2">
			<label for="user_limit">
				<?php _e( 'Limit', 'wp-display-users' ); ?>
			</label>
		</div>
		<div class="form-group col-md-10">
			<input type="number" step="1" min="0" name="display_user_data[user_limit]" id="user_limit" class="form-control" value="<?php if( isset( $_POST['display_user_data']['user_limit'] ) ) { echo $_POST['display_user_data']['user_limit']; } else { echo 10; } ?>" />
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-2">
			<label for="user_name">
				<?php _e( 'Display Name', 'wp-display-users' ); ?>
			</label>
		</div>
		<div class="form-group col-md-2">
			<select class="form-control" name="display_user_data[user_name]" id="user_name">
				<option value='yes'<?php if( isset( $_POST['display_user_data']['user_name'] ) ) { selected( $_POST['display_user_data']['user_name'], 'yes' ); } ?>>
					<?php _e( 'Yes', 'wp-display-users' ); ?>
				</option>
				<option value='no'<?php if( isset( $_POST['display_user_data']['user_name'] ) ) { selected( $_POST['display_user_data']['user_name'], 'no' ); } ?>>		
					<?php _e( 'No', 'wp-display-users' ); ?>
				</option>
			</select>
		</div>
		<div class="form-group col-md-2">
			<label for="user_email">
				<?php _e( 'Display Email', 'wp-display-users' ); ?>
			</label>
		</div>
		<div class="form-group col-md-2">
			<select class="form-control" name="display_user_data[user_email]" id="user_email">
				<option value='yes'<?php if( isset( $_POST['display_user_data']['user_email'] ) ) { selected( $_POST['display_user_data']['user_email'], 'yes' ); } ?>>
					<?php _e( 'Yes', 'wp-display-users' ); ?>
				</option>
				<option value='no'<?php if( isset( $_POST['display_user_data']['user_email'] ) ) { selected( $_POST['display_user_data']['user_email'], 'no' ); } ?>>		
					<?php _e( 'No', 'wp-display-users' ); ?>
				</option>
			</select>
		</div>
		<div class="form-group col-md-2">
			<label for="user_website">
				<?php _e( 'Display Website', 'wp-display-users' ); ?>
			</label>
		</div>
		<div class="form-group col-md-2">
			<select class="form-control" name="display_user_data[user_website]" id="user_website">
				<option value='yes'<?php if( isset( $_POST['display_user_data']['user_website'] ) ) { selected( $_POST['display_user_data']['user_website'], 'yes' ); } ?>>
					<?php _e( 'Yes', 'wp-display-users' ); ?>
				</option>
				<option value='no'<?php if( isset( $_POST['display_user_data']['user_website'] ) ) { selected( $_POST['display_user_data']['user_website'], 'no' ); } ?>>		
					<?php _e( 'No', 'wp-display-users' ); ?>
				</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-2">
			<label for="user_description">
				<?php _e( 'Display Description', 'wp-display-users' ); ?>
			</label>
		</div>
		<div class="form-group col-md-3">
			<select class="form-control" name="display_user_data[user_description]" id="user_email">
				<option value='yes'<?php if( isset( $_POST['display_user_data']['user_description'] ) ) { selected( $_POST['display_user_data']['user_description'], 'yes' ); } ?>>
					<?php _e( 'Yes', 'wp-display-users' ); ?>
				</option>
				<option value='no'<?php if( isset( $_POST['display_user_data']['user_description'] ) ) { selected( $_POST['display_user_data']['user_description'], 'no' ); } ?>>		
					<?php _e( 'No', 'wp-display-users' ); ?>
				</option>
			</select>
		</div>
		<div class="form-group col-md-2">
			<label for="user_description_length">
				<?php _e( 'Description Length', 'wp-display-users' ); ?>
			</label>
		</div>
		<div class="form-group col-md-3">
			<input type="number" step="1" min="0" name="display_user_data[user_description_length]" id="user_description_length" class="form-control" value="<?php if( isset( $_POST['display_user_data']['user_description_length'] ) ) { echo $_POST['display_user_data']['user_description_length']; } else { echo 20; } ?>" />
		</div>
	</div>	
	<div class="row">
		<div class="form-group col-md-2">
			<label for="user_avatar">
				<?php _e( 'Display Avatar', 'wp-display-users' ); ?>
			</label>
		</div>
		<div class="form-group col-md-8">
			<select class="form-control" name="display_user_data[user_avatar]" id="user_avatar">
				<option value='yes'<?php if( isset( $_POST['display_user_data']['user_avatar'] ) ) { selected( $_POST['display_user_data']['user_avatar'], 'yes' ); } ?>>
					<?php _e( 'Yes', 'wp-display-users' ); ?>
				</option>
				<option value='no'<?php if( isset( $_POST['display_user_data']['user_avatar'] ) ) { selected( $_POST['display_user_data']['user_avatar'], 'no' ); } ?>>		
					<?php _e( 'No', 'wp-display-users' ); ?>
				</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-2">
			<label for="user_avatar_size">
				<?php _e( 'Size', 'wp-display-users' ); ?>
			</label>
		</div>
		<div class="form-group col-md-2">
			<input class="form-control" name="display_user_data[user_avatar_size]" id="user_avatar_size" type="number" step="1" min="0" value="<?php if( isset( $_POST['display_user_data']['user_avatar_size'] ) ) { echo (int)( $_POST['display_user_data']['user_avatar_size'] ); } else { echo 90; } ?>" />
		</div>
		<div class="form-group col-md-1">
			<label for="user_avatar_align">
				<?php _e( 'Align', 'wp-display-users' ); ?>
			</label>
		</div>
		<div class="form-group col-md-2">	
			<select class="form-control" name="display_user_data[user_avatar_align]" id="user_avatar_align">
				<option value="left"<?php if( isset( $_POST['display_user_data']['user_avatar_align'] ) ) { selected( $_POST['display_user_data']['user_avatar_align'], 'left' ); } ?>>
					<?php _e( 'Left', 'wp-display-users' ) ?>
				</option>
				<option value="right"<?php if( isset( $_POST['display_user_data']['user_avatar_align'] ) ) { selected( $_POST['display_user_data']['user_avatar_align'], 'right' ); } ?>>
					<?php _e( 'Right', 'wp-display-users' ) ?>
				</option>
			</select>
		</div>
		<div class="form-group col-md-1">
			<label for="user_avatar_shape">
				<?php _e( 'Shape', 'wp-display-users' ); ?>
			</label>
		</div>	
		<div class="form-group col-md-2">
			<select class="form-control" name="display_user_data[user_avatar_shape]" id="user_avatar_shape">
				<option value='square'<?php if( isset( $_POST['display_user_data']['user_avatar_shape'] ) ) { selected( $_POST['display_user_data']['user_avatar_shape'], 'square' ); } ?>>
					<?php _e( 'Square', 'wp-display-users' ); ?>
				</option>
				<option value='rounded'<?php if( isset( $_POST['display_user_data']['user_avatar_shape'] ) ) { selected( $_POST['display_user_data']['user_avatar_shape'], 'rounded' ); } ?>>		
					<?php _e( 'Rounded', 'wp-display-users' ); ?>
				</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-2">
			<label for="user_filter">
				<?php _e( 'Filter by user ID', 'wp-display-users' ); ?>
			</label>
		</div>
		<div class="form-group col-md-3">
			<select name="display_user_data[user_filter]" id="user_filter" class="form-control">
				<option value=""><?php _e( 'None', 'wp-display-users' ); ?></option>	
				<option value="include"<?php if( isset( $_POST['display_user_data']['user_filter'] ) ) { selected( $_POST['display_user_data']['user_filter'], 'include' ); } ?>>
					<?php _e( 'Include', 'wp-display-users' ); ?>
				</option>
				<option value="exclude"<?php if( isset( $_POST['display_user_data']['user_filter'] ) ) { selected( $_POST['display_user_data']['user_filter'], 'exclude' ); } ?>>
					<?php _e( 'Exclude', 'wp-display-users' ); ?>
				</option>
			</select>
			<p class="description">
				<?php _e( 'Please choose any one option for include or exclude users.', 'wp-display-users' ); ?>
			</p>
		</div>
		<div class="form-group col-md-2">
			<label for="user_id">User ID</label>
	  	</div>
		<div class="form-group col-md-3">
			<input type="text" name="display_user_data[user_id]" id="user_id" class="form-control" value="<?php if( isset( $_POST['display_user_data']['user_id'] ) ) { echo $_POST['display_user_data']['user_id']; } ?>" />
			<p class="description">
				<?php _e( 'Please enter here { Users IDs } by comma seprated. { Example : 1, 2, 3 }', 'wp-display-users' ); ?>
			</p>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-2">
			<?php if( $_GET['action'] == 'edit' && isset( $_GET['id'] ) ) { ?>
			<input type="submit" name="display_users_update" id="submit" class="button action-button" value="Update" />
			<?php } else { ?>
			<input type="submit" name="display_users_save" id="submit" class="button action-button" value="Save" />
			<?php } ?>
		</div>
	</div>
</form>       