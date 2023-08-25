<?php

namespace AkzentPointsOfInterest;
defined('ABSPATH') || exit;
use AkzentPointsOfInterest\Models\PointOfInterest;


class Plugin
{

  public static $_instance = null;
  public $settings;
  public $api;
  public $base_loader;
  public $elementor_loader;

  const MINIMUM_ELEMENTOR_VERSION = '3.2.0';

  private function __construct()
  {
    add_action('init', [$this, 'init'], 0);
  }


  public function init() {
    if ($this->init_base_loader()) {
      if ($this->is_compatible()) {
        $this->init_elementor_loader();
      }
    }

    $this->settings = new Settings();
    $this->api = new API();
    //add_action('init', [$this, 'register_poi_post_type']);
    //add_action('elementor/elements/categories_registered', [$this, 'register_widgets_category']);
    //add_action('elementor/widgets/register', [$this, 'register_widgets']);
    //add_action('update_option_' . Settings::OPTIONS_BASE_NAME, [$this, 'initial_fetch_points_of_interest']);
    //add_action('wp_enqueue_style', [$this, 'register_akzent_styles']);
    //add_action('wp_enqueue_scripts', [$this, 'register_akzent_scripts']);
  }

  private function init_base_loader() {
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/loader/base.php';
    $this->base_loader = new Loader\BaseLoader();
    return $this->base_loader->valid();
  }

  private function init_elementor_loader() {
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/loader/elementor.php';
    $this->elementor_loader = new Loader\ElementorLoader();
    return true;
  }

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
