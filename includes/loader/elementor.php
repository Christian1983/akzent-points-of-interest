<?php

namespace AkzentPointsOfInterest\Loader;
defined('ABSPATH') || exit;

class ElementorLoader {

  function __construct() {
    $this->load_files();
    //add_action('wp_enqueue_style', [$this, 'register_styles']);
    add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
    add_action('elementor/elements/categories_registered', [$this, 'register_widgets_category']);
    add_action('elementor/widgets/register', [$this, 'register_widgets']);
  }

  private function load_files() {
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/render.php';

    // controls
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/controls/base.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/controls/card.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/controls/data.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/controls/grid.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/controls/slider.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/controls/text.php';
  }

  public function register_styles() {
    wp_register_style('akzent_bootstrap_style', plugins_url('assets/lib/bootstrap/bootstrap5.min.css', AKZENT_POINTS_OF_INTEREST_FILE) );
    wp_register_style('akzent_main_style', plugins_url('assets/css/main.css', AKZENT_POINTS_OF_INTEREST_FILE) );
    wp_register_style('akzent_image_card_style', plugins_url('assets/css/image_card.css', AKZENT_POINTS_OF_INTEREST_FILE));
    wp_register_style('akzent_small_card_style', plugins_url('assets/css/small_card.css', AKZENT_POINTS_OF_INTEREST_FILE));
    wp_register_style('akzent_slider_style', plugins_url('assets/css/slider.css', AKZENT_POINTS_OF_INTEREST_FILE));
    wp_register_style('akzent_slider_widget_style', plugins_url('assets/lib/swiper/css/swiper.min.css', AKZENT_POINTS_OF_INTEREST_FILE) );
  }

  public function register_scripts() {
    // we cant use wp_enqueue_style as intended, the hook always fires after wp_enqueue_scripts.
    // but then swiper does not work
    $this->register_styles();
    wp_register_script('akzent_slider_widget_swiper_script', plugins_url('assets/lib/swiper/swiper.min.js', AKZENT_POINTS_OF_INTEREST_FILE) );
    wp_register_script('akzent_slider_widget_initialization_script', plugins_url('assets/js/slider.js', AKZENT_POINTS_OF_INTEREST_FILE));
  }


  public function register_widgets_category($elements_manager) {
    $elements_manager->add_category(
      'akzent-points-of-interest',
      [
        'title' => AKZENT_POINTS_OF_INTEREST_PLUGIN_NAME,
        'icon' => AKZENT_POINTS_OF_INTEREST_DEFAULT_ICON,
      ]
    );
  }

  public function register_widgets( $widgets_manager ) {
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/widgets/base.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/widgets/slider.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/widgets/grid.php';
    $widgets_manager->register(new \AkzentPointsOfInterest\Widgets\Grid);
    $widgets_manager->register(new \AkzentPointsOfInterest\Widgets\Slider);
  }


}
