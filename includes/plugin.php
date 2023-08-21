<?php

namespace AkzentPointsOfInterest;

use AkzentPointsOfInterest\Models\PointOfInterest;

defined('ABSPATH') || exit;
class Plugin
{

  public static $_instance = null;
  public $settings;
  public $api;

  const MINIMUM_ELEMENTOR_VERSION = '3.2.0';

  private function __construct()
  {
    add_action('init', [$this, 'init'], 0);
  }


  public function init()
  {
    $this->load_files();
    $this->settings = new Settings();
    $this->api = new API();
    add_action('init', [$this, 'register_poi_post_type']);
    add_action('elementor/elements/categories_registered', [$this, 'register_widgets_category']);
    add_action('elementor/widgets/register', [$this, 'register_widgets']);
    add_action('update_option_' . Settings::OPTIONS_BASE_NAME, [$this, 'initial_fetch_points_of_interest']);
    add_action('wp_enqueue_scripts', [$this, 'register_widget_styles']);
  }

  private function load_files()
  {
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/settings.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/api.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/helper/string.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/models/point_of_interest.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/models/point_of_interest_image.php';
  }

  public function register_widget_styles() {
    wp_register_style('akzent_post_list_widget_style', plugins_url('assets/css/post_list.css', AKZENT_POINTS_OF_INTEREST_FILE), [ 'elementor-frontend'] );
  }

  public function register_poi_post_type()
  {
    $result = register_post_type(
      'point_of_interest',
      array(
        'labels' => array(
          'name' => __('Reiseinspirationen'),
          'singular_name' => __('Reiseinspiration')
        ),
        'capabilities' => array(
          'read_points_of_interest' => true,
          'delete_points_of_interest' => true,
          'create_points_of_interest' => false,
          'edit_points_of_interest' => false,
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

  public function register_widgets_category($elements_manager) {
    $elements_manager->add_category(
      'akzent-points-of-interest',
      [
        'title' => AKZENT_POINTS_OF_INTEREST_PLUGIN_NAME,
        'icon' => AKZENT_POINTS_OF_INTEREST_DEFAULT_ICON,
      ]
    );
  }


  public function register_widgets($widgets_manager)
  {
    if ($this->is_compatible()) {
      require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/widgets/list.php';
      require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/widgets/slider.php';
      $widgets_manager->register(new Widgets\PostList);
      $widgets_manager->register(new Widgets\Slider);
    }
  }

  // initial create of poi model
  public function initial_fetch_points_of_interest()
  {
    $cpt_objects = $this->api->get_all();
    foreach($cpt_objects as $object) {
      $is_saved = Models\PointOfInterest::save($object);
    }
  }

  public static function instance()
  {

    if (is_null(self::$_instance)) {
      self::$_instance = new self();
      do_action('akzent_points_of_interest/loaded');
    }

    return self::$_instance;

  }


  public function is_compatible()
  {
    // Check if Elementor is installed and activated
    if (!did_action('elementor/loaded')) {
      add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
      return false;
    }

    // Check for required Elementor version
    if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
      add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
      return false;
    }


    return true;
  }

  public function admin_notice_missing_main_plugin()
  {

    if (isset($_GET['activate']))
      unset($_GET['activate']);

    $message = sprintf(
      /* translators: 1: Plugin name 2: Elementor */
      esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementor-test-addon'),
      '<strong>' . esc_html__('AKZENT Reiseinspirationen', 'elementor-test-addon') . '</strong>',
      '<strong>' . esc_html__('Elementor', 'elementor-test-addon') . '</strong>'
    );

    printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

  }

  /**
   * Admin notice
   *
   * Warning when the site doesn't have a minimum required Elementor version.
   *
   * @since 1.0.0
   * @access public
   */
  public function admin_notice_minimum_elementor_version()
  {

    if (isset($_GET['activate']))
      unset($_GET['activate']);

    $message = sprintf(
      /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
      esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', AKZENT_POINTS_OF_INTEREST_PLUGIN_NAME),
      '<strong>' . AKZENT_POINTS_OF_INTEREST_PLUGIN_NAME . '</strong>',
      '<strong>' . 'Elementor' . '</strong>',
      self::MINIMUM_ELEMENTOR_VERSION
    );

    printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

  }

}

Plugin::instance();
