<?php

namespace AkzentPointsOfInterest\Loader;
defined('ABSPATH') || exit;

class BaseLoader {

  function __construct() {
    $this->load_files();
    $this->register_shortcodes();
    //add_filter( 'load_template', [$this, 'assign_template'] );
    add_action( 'wp_register_style', [$this, 'register_styles'] );
    add_action( 'wp_register_scripts', [$this, 'register_scripts'] );
    add_action( 'init', [$this, 'register_point_of_interest'] );
    //\AkzentPointsOfInterest\Models\PointOfInterest::destroy_all();
  }

  private function load_files() {
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/settings.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/api.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/helper/string.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/models/point_of_interest.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/models/point_of_interest_image.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/shortcodes.php';
  }

  private function register_shortcodes() {
    add_shortcode( 'akzent_points_of_interest_grid_short',  ['\AkzentPointsOfInterest\Shortcodes', 'grid']);
    add_shortcode( 'akzent_points_of_interest_slider_short',  ['\AkzentPointsOfInterest\Shortcodes', 'slider']);
  }

  public function register_point_of_interest() {
    register_post_type(
      'point_of_interest',
      apply_filters( 'load_template',
        array(
          'labels' => array(
            'name' => __('Reiseinspirationen'),
            'singular_name' => __('Reiseinspiration')
          ),
          'capabilities' => array(
            'read_points_of_interest' => true,
            'delete_points_of_interest' => true,
            'create_points_of_interest' => true,
            'edit_points_of_interest' => true,
          ),
          'hierarchical' => false, // Hierarchical causes memory issues - WP loads all records!
          'has_archive' => true,
          'public' => true,
          'show_in_rest' => true, // nötig damit gutenberg die pois 'sehen' kann
          'show_ui' => true,
          'show_in_menu' => false,
          'menu_position' => 4,
          'menu_icon' => AKZENT_POINTS_OF_INTEREST_DEFAULT_ICON,
          'rewrite' => array('slug' => 'reiseinspirationen'),
          'supports' => array('title', 'editor', 'description', 'author', 'thumbnail', 'custom-fields')
        )
      )
    );
  }
  public function assign_template( $args ) {
    $args['template'] = AKZENT_POINTS_OF_INTEREST_PATH . 'templates/single.php';
    return $args;
  }


  public function add_meta_information() {
    add_meta_box();
  }
  public function register_styles() {
    wp_enqueue_style('dashicons');
    wp_register_style('akzent_swiper_style', plugins_url('assets/lib/swiper/css/swiper.min.css', AKZENT_POINTS_OF_INTEREST_FILE) );
    wp_register_style('akzent_bootstrap_style', plugins_url('assets/lib/bootstrap/bootstrap5.min.css', AKZENT_POINTS_OF_INTEREST_FILE) );
    wp_register_style('akzent_main_style', plugins_url('assets/css/main.css', AKZENT_POINTS_OF_INTEREST_FILE) );
    wp_register_style('akzent_image_card_style', plugins_url('assets/css/image_card.css', AKZENT_POINTS_OF_INTEREST_FILE));
    wp_register_style('akzent_slider_style', plugins_url('assets/css/slider.css', AKZENT_POINTS_OF_INTEREST_FILE));
    wp_register_style('akzent_grid_style', plugins_url('assets/css/grid.css', AKZENT_POINTS_OF_INTEREST_FILE));
  }

  public function register_scripts() {
    wp_register_script('akzent_slider_widget_swiper_script', plugins_url('assets/lib/swiper/swiper.min.js', AKZENT_POINTS_OF_INTEREST_FILE) );
    wp_register_script('akzent_slider_widget_initialization_script', plugins_url('assets/js/slider.js', AKZENT_POINTS_OF_INTEREST_FILE));
  }

}
