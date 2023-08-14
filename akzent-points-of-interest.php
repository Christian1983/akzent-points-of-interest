<?php
/**
 * Plugin Name: AKZENT Reiseinspirationen
 * Description: Die AKZENT Reiseinspirationen für Ihre Website.
 * Plugin URI:  https://www.akzent.de
 * Version:     1.0.0
 * Author:      Christian Neumann
 * Author URI:  https://github.com/Christian1983
 * Text Domain: akzent-points-of-interest
 * Elementor tested up to: 3.15.1
 * Elementor Pro tested up to: 3.15.0
 */

 // Exit if accessed directly
defined( 'ABSPATH' ) || exit;
define( 'AKZENT_POINTS_OF_INTEREST_VERSION', '1.0.0' );
define( 'AKZENT_POINTS_OF_INTEREST_PATH', plugin_dir_path( __FILE__ ) );
define( 'AKZENT_POINTS_OF_INTEREST_URL', plugin_dir_url( __FILE__ ) );


require_once( __DIR__ . '/includes/plugin.php' );
function plugin_deactivation()
{
	require_once( __DIR__ . '/includes/post_type.php');
	\akzent_points_of_interest\PostType::destroy_all();
	delete_option('akzent_point_of_interest_options');
	unregister_post_type('points_of_interest');
}

function akzent_points_of_interest() {
	// Run the plugin
	\akzent_points_of_interest\Plugin::instance();
}

function akzent_points_of_interest_settings() {
	require_once( __DIR__ . '/includes/settings.php');
	\akzent_points_of_interest\Settings::add_default_options();
	\akzent_points_of_interest\Settings::add_settings_api_defaults();
}

function register_post_types() {
	require_once( __DIR__ . '/includes/point_of_interest_post.php');
	\akzent_points_of_interest\PointOfInterestPost::register();
}

function get_points_of_interest() {
	require_once( __DIR__ . '/includes/api.php');
	\akzent_points_of_interest\API::get_all();
}

add_action( 'admin_menu', 'akzent_points_of_interest_settings');
add_action( 'init', 'register_post_types' );
add_action( 'update_option_akzent_point_of_interest_options', 'get_points_of_interest', 10, 2);
add_action( 'plugins_loaded', 'akzent_points_of_interest' );
