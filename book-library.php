<?php

/*
Plugin Name: Book library
Plugin URI: https://wordpress.org/
Description: This is book library plugin.
Version: 1.0.0
Author: Akshay
Author URI: https://wordpress.org/
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wpbl
Domain Path: /languages
*/

/**
 * Basic plugin definitions
 *
 * @package Book library
 * @since 1.0.0
 */
if ( ! defined( 'WP_BL_DIR' ) ) {
	define( 'WP_BL_DIR', plugin_dir_path( __FILE__ ) ); // Plugin dir
}
if ( ! defined( 'WP_BL_VERSION' ) ) {
	define( 'WP_BL_VERSION', '1.0.0' );  // Plugin Version
}
if ( ! defined( 'WP_BL_URL' ) ) {
	define( 'WP_BL_URL', plugin_dir_url( __FILE__ ) );   // Plugin url
}
if ( ! defined( 'WP_BL_INC_DIR' ) ) {
	define( 'WP_BL_INC_DIR', WP_BL_DIR . '/includes' );   // Plugin include dir
}
if ( ! defined( 'WP_BL_INC_URL' ) ) {
	define( 'WP_BL_INC_URL', WP_BL_URL . '/includes' );    // Plugin include url
}
if ( ! defined( 'WP_BL_PREFIX' ) ) {
	define( 'WP_BL_PREFIX', 'wp_bl' ); // Plugin Prefix
}
if ( ! defined( 'WP_BL_VAR_PREFIX' ) ) {
	define( 'WP_BL_VAR_PREFIX', '_wp_bl_' ); // Variable Prefix
}
if ( ! defined( 'WP_BL_POST_TYPE_BOOK' ) ) {
	define( 'WP_BL_POST_TYPE_BOOK', 'wp_bl_book' ); // Post Type for Book
}
if ( ! defined( 'WP_BL_POST_PER_PAGE' ) ) {
	define( 'WP_BL_POST_PER_PAGE', 5 ); // Post Type for Book
}
if ( ! defined( 'WP_BL_SEARCH_TITLE' ) ) {
	define( 'WP_BL_SEARCH_TITLE', 'Book' ); // Post Type for Book
}

/**
 * Load Text Domain
 *
 * This gets the plugin ready for translation.
 *
 * @package Book library
 * @since 1.0.0
 */
load_plugin_textdomain( 'wpbl', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * Activation Hook
 *
 * Register plugin activation hook.
 *
 * @package Book library
 * @since 1.0.0
 */
register_activation_hook( __FILE__, 'wp_bl_install' );

function wp_bl_install() {

}

/**
 * Deactivation Hook
 *
 * Register plugin deactivation hook.
 *
 * @package Book library
 * @since 1.0.0
 */
register_deactivation_hook( __FILE__, 'wp_bl_uninstall' );

function wp_bl_uninstall() {

}

// Global variables
global $wp_bl_scripts;

// Script class handles most of script functionalities of plugin
include_once( WP_BL_INC_DIR . '/class-wp-bl-scripts.php' );
$wp_bl_scripts = new Wp_Bl_Scripts();
$wp_bl_scripts->add_hooks();

// Admin class handles most of backend functionalities of plugin
include_once( WP_BL_INC_DIR . '/class-wp-bl-admin.php' );
$wp_bl_scripts = new Wp_Bl_Admin();
$wp_bl_scripts->add_hooks();

// Public class handles most of frontend functionalities of plugin
include_once( WP_BL_INC_DIR . '/class-wp-bl-public.php' );
$wp_bl_scripts = new Wp_Bl_Public();
$wp_bl_scripts->add_hooks();

// Registring Post type functionality
require_once( WP_BL_INC_DIR . '/wp-bl-post-type.php' );
