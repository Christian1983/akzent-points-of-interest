<?php

namespace AkzentPointsOfInterest;
defined('ABSPATH') || exit;
class API
{

  private $base_url = '';

  public function __construct() {
    if (str_contains(home_url(), 'localhost')) {
      $this->base_url = 'http://akzentde-web-1:3000/api/v2/hotels';
    } else {
      $this->base_url = 'https://www.akzent.de/api/v2/hotels';
    }
    add_action('check_changed_points_of_interest', [$this, 'check_changed_points_of_interest']);
    //Models\PointOfInterest::destroy_all();
  }
  public function get_all() {
    $response = $this->get($this->full_url());
    if ($response['code'] == 200) {
      return json_decode($response['body']);
    }  else {
      return [];
    }
  }

  public function fetch($akzent_id) {
    $response = $this->get(trailingslashit( $this->full_url() ) . $akzent_id);
    if ($response['code'] == 200) {
      return json_decode($response['body']);
    }  else {
      return false;
    }
  }

  public function validate($api_key) {
    $full_url = $this->base_url . "/{$api_key}/points_of_interest";
    return $this->get($full_url)['code'] == 200;
  }

  public function check_changed_points_of_interest() {
    set_transient( 'akzent_check_changed_points_of_interest_1', true, 10 );
    $api_key = get_option(Settings::OPTIONS_BASE_NAME)['api_key'];
    $hotel_url = trailingslashit($this->base_url) . trailingslashit($api_key);
    $points_of_interest_db      = Models\PointOfInterest::update_check_list();
    $points_of_interest_remote  = json_decode($this->get($hotel_url)['body']);
    $difference                 = array_diff($points_of_interest_remote, $points_of_interest_db);

    foreach($difference as $entry) {
      $id = explode(',', $entry)[0];
      if ( str_contains(implode($points_of_interest_db), $id) ) {
        Models\PointOfInterest::update($id, $this->fetch($id));
      } else {
        if ( str_contains(implode($points_of_interest_remote), $id) ) {
          // new
          Models\PointOfInterest::create($this->fetch($id));
        } else {
          Models\PointOfInterest::delete(Models\PointOfInterest::find_by($id));
        }
      }
    }
    return 0;
  }

  private function check_new_points_of_interest() {

  }

  private function get($url) {
    $response = wp_remote_get($url);
    if (is_wp_error($response)) {
      return ['body' => '', 'code' => 0];
    } else {
      return ['body' => wp_remote_retrieve_body($response), 'code' => $response['response']['code']];
    }
  }

  private function full_url() {
    $api_key = get_option(Settings::OPTIONS_BASE_NAME)['api_key'];
    return trailingslashit($this->base_url) . trailingslashit($api_key) . 'points_of_interest';
  }
}
