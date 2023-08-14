<?php

namespace akzent_points_of_interest;

final class Plugin
{

	private static $_instance = null;
  private $settings = null;
  const MINIMUM_ELEMENTOR_VERSION = '3.2.0';
  const MINIMUM_PHP_VERSION = '7.0';

  /**
   * Constructor
   *
   * Perform some compatibility checks to make sure basic requirements are meet.
   * If all compatibility checks pass, initialize the functionality.
   *
   * @since 1.0.0
   * @access public
   */
  public function __construct()
  {

    if ($this->is_compatible()) {
      add_action('elementor/init', [$this, 'init']);
    } else {
      $a = 1;
    }

  }

    /**
   * Initialize
   *
   * Load the addons functionality only after Elementor is initialized.
   *
   * Fired by `elementor/init` action hook.
   *
   * @since 1.0.0
   * @access public
   */
  public function init()
  {
    add_action( 'elementor/widgets/register', [ $this, 'register_widget' ] );
  }

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 * @return \Elementor_Test_Addon\Plugin An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

  /**
   * Compatibility Checks
   *
   * Checks whether the site meets the addon requirement.
   *
   * @since 1.0.0
   * @access public
   */

  public function register_widget( $widgets_manager ) {
    require_once( __DIR__ . '/widgets/base.php');
    $widgets_manager->register(new widgets\Base);
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

    // Check for required PHP version
    if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
      add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
      return false;
    }

    return true;
  }

  /**
   * Admin notice
   *
   * Warning when the site doesn't have Elementor installed or activated.
   *
   * @since 1.0.0
   * @access public
   */
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
      esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'AKZENT Reiseinspirationen'),
      '<strong>' . esc_html__('AKZENT Reiseinspirationen', 'elementor-test-addon') . '</strong>',
      '<strong>' . esc_html__('Elementor', 'elementor-test-addon') . '</strong>',
      self::MINIMUM_ELEMENTOR_VERSION
    );

    printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

  }

  /**
   * Admin notice
   *
   * Warning when the site doesn't have a minimum required PHP version.
   *
   * @since 1.0.0
   * @access public
   */
  public function admin_notice_minimum_php_version()
  {

    if (isset($_GET['activate']))
      unset($_GET['activate']);

    $message = sprintf(
      /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
      esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'AKZENT Reiseinspirationen'),
      '<strong>' . esc_html__('AKZENT Reiseinspirationen', 'elementor-test-addon') . '</strong>',
      '<strong>' . esc_html__('PHP', 'elementor-test-addon') . '</strong>',
      self::MINIMUM_PHP_VERSION
    );

    printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

  }



}

Plugin::instance();
