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

define( 'AKZENT_POINTS_OF_INTEREST_PATH', plugin_dir_path( __FILE__ ) );
define( 'AKZENT_POINTS_OF_INTEREST_URL', plugin_dir_url( __FILE__ ) );
define( 'AKZENT_POINTS_OF_INTEREST_VERSION', '1.0.1' );

 function akzent_points_of_interest() {
	require_once( __DIR__ . '/includes/plugin.php' );

	// Run the plugin
	\akzent_points_of_interest\Plugin::instance();
}
add_action( 'plugins_loaded', 'akzent_points_of_interest' );

