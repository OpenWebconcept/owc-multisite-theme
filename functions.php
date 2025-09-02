<?php

define( 'THEME_DIR', get_stylesheet_directory() );
define( 'IMAGEPATH', get_stylesheet_directory_uri() . '/assets/img/' );

// Favor subsite breadcrumbs settings over network settings
define( 'BCN_SETTINGS_FAVOR_LOCAL', true );

require_once( 'functions/error-handler.php' );
require_once( 'functions/helpers.php' );
require_once( 'functions/actions.php' );
require_once( 'functions/navigation.php' );
require_once( 'functions/filters.php' );
require_once( 'functions/shortcodes.php' );
require_once( 'functions/cpts.php' );
require_once( 'functions/taxonomies.php' );
require_once( 'functions/last-login.php' );

if ( class_exists( 'acf' ) ) {
	require_once( 'functions/acf.php' );
	require_once( 'functions/acf/class-acf-field-post-type-selector.php' );
	require_once( 'functions/acf-cpts.php' );
	require_once( 'functions/acf/class-acf-field-gravity-forms.php' );
	require_once( 'functions/acf/class-acf-field-google-font-selector.php' );
} else {
	if ( ! is_admin() && ! wp_doing_cron() && false === strpos($_SERVER['REQUEST_URI'], 'wp-login.php') && false === strpos($_SERVER['REQUEST_URI'], 'wp-admin') ) {
		// If the user cannot activate plugins, they should not be able to use this theme.
		echo __( 'This theme requires the Advanced Custom Fields plugin. Please contact your site administrator.', 'strl' );
		wp_die();
	} else {
		add_action( 'admin_notices', 'strl_acf_notice' );
	}
}

require_once( 'functions/facetwp.php' );
