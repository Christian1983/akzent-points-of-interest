<?php

namespace AkzentPointsOfInterest\Loader;
defined('ABSPATH') || exit;

class BaseLoader {

  private $post_type_registered;
  function __construct() {
    $a = wp_get_theme()->get_stylesheet();
    $this->load_files();
    add_action('wp_enqueue_style', [$this, 'register_styles']);
    add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
    add_action('init', [$this, 'register_post_type']);
  }

  private function load_files() {
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/settings.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/api.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/helper/string.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/models/point_of_interest.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/models/point_of_interest_image.php';
  }

  public function register_post_type() {

    $this->post_type_registered = register_post_type(
      'points_of_interest',
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
        'has_archive' => true,
        'public' => true,
        'show_in_rest' => true, // nötig damit gutenberg die pois 'sehen' kann
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 4,
        'menu_icon' => AKZENT_POINTS_OF_INTEREST_DEFAULT_ICON,
        'rewrite' => array('slug' => 'reiseinspirationen'),
        'supports' => array('title', 'editor', 'description', 'author', 'thumbnail', 'custom-fields')
      )
    );
  }


  public function add_meta_information() {
    add_meta_box();
  }
  public function register_styles() {
    wp_register_style('akzent_main_style', plugins_url('assets/css/main.css', AKZENT_POINTS_OF_INTEREST_FILE) );
  }

  public function register_scripts() {
  }

  public function valid() {
    // base needs only to check if post type register_worked
    return $this->post_type_registered;
  }
}
