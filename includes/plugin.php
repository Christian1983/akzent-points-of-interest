<?php

namespace AkzentPointsOfInterest;

defined('ABSPATH') || exit;
class Plugin
{

  public static $_instance = null;
  public $settings;

  const MINIMUM_ELEMENTOR_VERSION = '3.2.0';

  private function __construct()
  {
    add_action('init', [$this, 'init'], 0);
  }


  public function init()
  {
    $this->load_files();
    $this->settings = new Settings();
    add_action( 'elementor/widgets/register', [ $this, 'register_widget' ] );
  }

  private function load_files() {
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/settings.php';
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/api.php';
  }

  public function register_widget( $widgets_manager ) {
    if ($this->is_compatible()) {
      require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/widgets/base.php';
      $widgets_manager->register(new widgets\Base);
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
