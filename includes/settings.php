<?php

namespace AkzentPointsOfInterest;
defined('ABSPATH') || exit;
class Settings
{

  const OPTIONS_BASE_NAME = 'akzent_point_of_interest_options';
  private $API;

  public $valid_key = false;
  public function __construct()
  {
    $this->add_default_options();
    $this->API = new API();
    add_action('admin_menu', [$this, 'page_init']);
    //add_action('admin_menu', [$this, 'menu_init']);

  }
  private function add_default_options()
  {
    $default_options = array();
    $default_options['api_key'] = '';

    add_option(self::OPTIONS_BASE_NAME, $default_options);
  }

  public function page_init()
  {
    add_options_page(
      'Reiseinspirationen',
      // page_title
      'Reiseinspirationen',
      // menu title
      'manage_options',
      // capability
      'akzent_points_of_interest_settings',
      // menu_slug
      [$this, 'create_admin_page'] // function
    );

    register_setting(
      'akzent_point_of_interest_option_group',
      // option_group
      'akzent_point_of_interest_options',
      // option_name
      [$this, 'api_key_sanitize'], // sanitize_callback
    );

    add_settings_section(
      'akzent_point_of_interest_setting_api_section',
      // id
      '',
      // title
      [$this, 'section_info_callback'],
      // callback
      'akzent-point-of-interest-admin' // page
    );

    add_settings_field(
      'api_key',
      // id
      'API Key',
      // title
      [$this, 'api_key_callback'],
      // callback
      'akzent-point-of-interest-admin',
      // page
      'akzent_point_of_interest_setting_api_section' // section
    );
  }
  /**
   * CALLBACKS
   */
  public function section_info_callback()
  {
    ?>
    <p>Hier muss zum abrufen der Reiseinspirationen der benötigte Schlüssel eingebenen werden</p>
    <p>Den Schlüssel erhalten Sie von der AKZENT Zentrale</p>
    <p>
      <a href="tel:+4905321759140">+49 5321 75 91 - 40</a>
    </p>
    <p>
      <a href="mailto:info@akzent.de">info@akzent.de</a>
    </p>
    <?php
  }
  public function api_key_callback()
  {
    $akzent_point_of_interest_options = get_option('akzent_point_of_interest_options');
    printf(
      '<input class="regular-text" type="text" name="akzent_point_of_interest_options[api_key]" id="api_key" value="%s">',
      isset($akzent_point_of_interest_options['api_key']) ? esc_attr($akzent_point_of_interest_options['api_key']) : ''
    );
  }

  public function create_admin_page()
  {
    ?>
    <div class="wrap">
      <h2>Reiseinspirationen Konfiguration</h2>

      <form method="post" action="options.php">
        <?php
        settings_fields('akzent_point_of_interest_option_group');
        do_settings_sections('akzent-point-of-interest-admin');
        submit_button();
        ?>
      </form>
    </div>
  <?php }


  /**
   * SANITIZE & VALIDATE
   */
  private function api_key_validate($key)
  {
    if ($key == '' || $key == null) {
      add_settings_error('akzent_point_of_interest_option_group', 'akzent_point_of_interest_options[api_key]', 'Bitte füllen Sie den API Key aus.');
    }
    elseif ($this->API->validate($key)) {
      do_action('akzent_points_of_interest/valid_api_key');
      return true;
    } else {
      add_settings_error('akzent_point_of_interest_option_group', 'akzent_point_of_interest_options[api_key]', 'API Key ist ungültig.');
    }

    return false;
  }


  public function api_key_sanitize($input)
  {
    $sanitary_values = array();
    if (isset($input['api_key'])) {
      if ($this->api_key_validate($input['api_key'])) {
        $sanitary_values['api_key'] = sanitize_text_field($input['api_key']);
      } else {
        $options = get_option('akzent_point_of_interest_options');
        $sanitary_values['api_key'] = $options['api_key'];
      }
    }

    return $sanitary_values;
  }
}
