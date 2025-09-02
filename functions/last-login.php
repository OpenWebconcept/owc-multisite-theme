<?php

/**
 * Retrieves a user's last login time.
 *
 * @package strl
 *
 * @param  string   $user_id    The user's username.
 * @param  boolean  $echo       Wether or not to echo the value.
 * @return string   $login_time The last login time.
 */
function strl_get_user_last_login( $user_id ) {
	$last_login = get_user_meta( $user_id, 'last_login', true );
	$login_time = __( 'Never logged in', 'strl' );

	if ( ! empty( $last_login ) ) {
		if ( is_array( $last_login ) ) {
			$login_time = human_time_diff( array_pop( $last_login ) );
			// It doesnt read translations here...
		} elseif ( 'Never logged in' === $last_login || 'Nooit ingelogd' === $last_login ) {
			$login_time = $login_time;
		} else {
			$login_time = human_time_diff( $last_login );
		}
	} else {
		// Update never logged in users with "never logged in"
		update_user_meta( $user_id, 'last_login', $login_time );
	}

	return $login_time;
}

/**
 * Adds and updates the User Meta with their last login time.
 *
 * @package strl
 *
 * @param string  $user_login The user's username.
 * @param WP_User $user       WP_User object of the logged-in user.
 */
function strl_user_last_login( $user_login, $user ) {
	update_user_meta( $user->ID, 'last_login', time() );
}
add_action( 'wp_login', 'strl_user_last_login', 10, 2 );

/**
 * Adds the last login column to the Users columns.
 *
 * @package strl
 *
 * @param array<string> $columns The column header labels keyed by column ID.
 */
function strl_user_last_login_column( $columns ) {
	$columns['last_login'] = __( 'Last Login', 'strl' );
	return $columns;
}
add_filter( 'manage_users_columns', 'strl_user_last_login_column' );

/**
 * Adds the last login value to the Last Login column.
 *
 * @package strl
 *
 * @param string $output      Custom column output. Default empty.
 * @param string $column_name Column name.
 * @param int    $user_id     ID of the currently-listed user.
 */
function strl_last_login_column_value( $output, $column_name, $user_id ) {
	// Change the output to the last login, only if the column name is last_login.
	$output = 'last_login' !== $column_name ? $output : strl_get_user_last_login( $user_id );
	return $output;
}
add_filter( 'manage_users_custom_column', 'strl_last_login_column_value', 10, 3 );


/**
 * Adds the Last Login column to sortable columns.
 *
 * @package strl
 *
 * @param array<string> $sortable_columns An array of sortable column names.
 */
function strl_make_last_login_sortable( $sortable_columns ) {
	$sortable_columns['last_login'] = 'last_login';
	return $sortable_columns;
}
add_filter( 'manage_users_sortable_columns', 'strl_make_last_login_sortable' );

/**
 * Sets the last login time as the order value.
 *
 * @package strl
 *
 * @param WP_User_Query $user_query The WP_User_Query instance.
 */
function strl_set_last_login_order_value( $user_query ) {
	global $current_screen;
	$current_screen_id = isset( $current_screen->id ) ? $current_screen->id : '';

	// Checks to see if we're an admin and on the users screen.
	if ( ! is_admin() || 'users' !== $current_screen_id  ) {
		return;
	}

	if ( 'last_login' === $user_query->get( 'orderby' ) ) {
		$user_query->set( 'orderby', 'meta_value' );
		$user_query->set( 'meta_key', 'last_login' );
	}
}
add_filter( 'pre_get_users', 'strl_set_last_login_order_value' );
