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
defined('ABSPATH') || exit;
define('AKZENT_POINTS_OF_INTEREST_VERSION', '1.0.2');
define('AKZENT_POINTS_OF_INTEREST_FILE', __FILE__);
define('AKZENT_POINTS_OF_INTEREST_PATH', plugin_dir_path(AKZENT_POINTS_OF_INTEREST_FILE));
define('AKZENT_POINTS_OF_INTEREST_IMAGE_PATH', 'points_of_interest_images/');
define('AKZENT_POINTS_OF_INTEREST_PLUGIN_SLUG', 'akzent-points-of-interest/akzent-points-of-interest.php');
define('AKZENT_POINTS_OF_INTEREST_CPT_NAME', 'points_of_interest');
define('AKZENT_POINTS_OF_INTEREST_PLUGIN_NAME', 'AKZENT Reiseinspirationen');
define('AKZENT_POINTS_OF_INTEREST_DEFAULT_ICON', 'dashicons-sticky');
define('AKZENT_POINTS_OF_INTEREST_PRIMARY_COLOR', '#cca772');

if (!version_compare(PHP_VERSION, '7.0', '>=')) {
  //TODO: Implement
  //printf("<div class='notice notice-warning is-dismissible'>PHP Version nicht kompatibel mit dem Plugin! (> 7.0)");
} elseif (!version_compare(get_bloginfo('version'), '5.6.1', '>=')) {
  //TODO: Implement
  //printf("<div class='notice notice-warning is-dismissible'>Wordpress Version nicht kompatibel mit dem Plugin! (> 5.6.1)");
} else {
  require AKZENT_POINTS_OF_INTEREST_PATH . 'includes/plugin.php';
}
