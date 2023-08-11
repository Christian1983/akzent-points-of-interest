<?php

namespace akzent_points_of_interest;

final class API {
  public static function get_all() {
    $url = self::full_url();
    $response = wp_remote_get( self::full_url() );
    if (is_wp_error($response)) { return false; }

    if ($response['response']['code'] == 200) {
      $body = wp_remote_retrieve_body( $response );
      $data = json_decode( $body );
      if ( !empty($data) ) {
        foreach( $data as $poi) {
          AkzentPointOfInterestsPost::save($poi);
        }
      }
     }
  }

  public static function validate_url($api_key) {
    $full_url = self::base_url() . "/{$api_key}/point_of_interests";
    $response = wp_remote_get( $full_url );
    $a = 1;
    if (is_wp_error($response)) { return false; }

    return $response['response']['code'] == 200;
  }

  private static function base_url() {
    if (str_contains(home_url(), 'localhost')) {
      return 'http://akzentde-web-1:3000/api/v2/hotels';
    } else {
      return 'https://www.akzent.de/api/v2/hotels';
    }
  }
}
