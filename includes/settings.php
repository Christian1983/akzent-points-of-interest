<?php

namespace akzent_points_of_interest;

class Settings {
  const OPTION = 'akzent_point_of_interest_options';

  public static function add_default_options() {
    $default_options = array();
    $default_options['api_key'] = '';

    add_option('akzent_point_of_interest_options', $default_options);
  }

  public static function add_settings_api_defaults() {
    $klazz = get_called_class();
    add_options_page(
      'Reiseinspirationen', // page_title
      'Reiseinspirationen', // menu title
      'manage_options', // capability
      'akzent_points_of_interest_settings', // menu_slug
      [ $klazz, 'create_admin_page'] // function
    );

    register_setting(
      'akzent_point_of_interest_option_group', // option_group
      'akzent_point_of_interest_options', // option_name
      [ $klazz, 'api_key_sanitize'], // sanitize_callback
    );

    add_settings_section(
      'akzent_point_of_interest_setting_api_section', // id
      '', // title
      [ $klazz, 'section_info_callback' ], // callback
      'akzent-point-of-interest-admin' // page
    );

    add_settings_field(
      'api_key', // id
      'Schlüssel', // title
      [ $klazz, 'api_key_callback' ], // callback
      'akzent-point-of-interest-admin', // page
      'akzent_point_of_interest_setting_api_section' // section
    );
  }

  /**
   * CALLBACKS
   */
  public static function section_info_callback() {
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
  public static function api_key_callback() {
    $akzent_point_of_interest_options = get_option( 'akzent_point_of_interest_options' );
		printf(
			'<input class="regular-text" type="text" name="akzent_point_of_interest_options[api_key]" id="api_key" value="%s">',
			isset( $akzent_point_of_interest_options['api_key'] ) ? esc_attr( $akzent_point_of_interest_options['api_key']) : ''
		);
	}

  public static function create_admin_page() {
		?>
      <div class="wrap">
        <h2>Reiseinspirationen Konfiguration</h2>

        <form method="post" action="options.php">
          <?php
            settings_fields( 'akzent_point_of_interest_option_group' );
            do_settings_sections( 'akzent-point-of-interest-admin' );
            submit_button();
          ?>
        </form>
      </div>
	<?php }


  /**
   * SANITIZE & VALIDATE
   */
  private static function api_key_validate($key) {
    require_once(__DIR__ . '/api.php');
    return API::validate_url($key);
  }


  public static function api_key_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['api_key'] ) ) {
      if (self::api_key_validate($input['api_key'])) {
        $sanitary_values['api_key'] = sanitize_text_field( $input['api_key'] );
      } else {
        add_settings_error('akzent_point_of_interest_option_group', 'akzent_point_of_interest_options[api_key]', 'Schlüssel ist ungültig.');
        $options = get_option( 'akzent_point_of_interest_options' );
        $sanitary_values['api_key'] = $options['api_key'];
      }
		}

		return $sanitary_values;
	}
}
