<?php

namespace AkzentPointsOfInterest\Loader;
defined('ABSPATH') || exit;

class ElementorLoader {

  function __construct() {
    $this->load_files();
    add_action('wp_enqueue_style', [$this, 'register_styles']);
    add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
    add_action('elementor/elements/categories_registered', [$this, 'register_widgets_category']);
    add_action('elementor/widgets/register', [$this, 'register_widgets']);
  }

  private function load_files() {
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/render.php';

    // widgets
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/widgets/base.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/widgets/list.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/widgets/slider.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/widgets/card_grid.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/controls/card_grid.php';

    // controls
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/controls/base.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/controls/card_base.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/controls/card_horizontal.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/controls/card_image.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/controls/card_vertical.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/controls/data.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/controls/slider.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/controls/text.php';
  }

  public function register_styles() {
    wp_register_style('akzent_bootstrap_style', plugins_url('assets/lib/bootstrap/bootstrap5.min.css', AKZENT_POINTS_OF_INTEREST_FILE) );
    wp_register_style('akzent_post_list_widget_style', plugins_url('assets/css/post_list.css', AKZENT_POINTS_OF_INTEREST_FILE) );
    wp_register_style('akzent_slider_widget_style', plugins_url('assets/lib/swiper/css/swiper.min.css', AKZENT_POINTS_OF_INTEREST_FILE) );
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
    $widgets_manager->register(new Widgets\PostList);
    $widgets_manager->register(new Widgets\CardGrid);
    $widgets_manager->register(new Widgets\Slider);
  }

  public function register_scripts() {
    // we cant use wp_enqueue_style as intended, hthe hook always fires after wp_enqueue_scripts.
    // but then swiper does not work
    $this->register_styles();
    wp_register_script('akzent_slider_widget_swiper_script', plugins_url('assets/lib/swiper/swiper.min.js', AKZENT_POINTS_OF_INTEREST_FILE) );
    wp_register_script('akzent_slider_widget_initialization_script', plugins_url('assets/js/slider.js', AKZENT_POINTS_OF_INTEREST_FILE));
  }


}
