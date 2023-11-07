<?php

namespace AkzentPointsOfInterest;
defined('ABSPATH') || exit;
class API
{

  public $base_url = '';

  public function __construct() {
    if (strpos(home_url(), 'localhost') !== false) {
      $this->base_url = 'http://akzentde-web-1:3000/api/v2/hotels';
    } else {
      $this->base_url = 'https://www.akzent.de/api/v2/hotels';
    }
    add_action('check_changed_points_of_interest', [$this, 'check_changed_points_of_interest']);
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

  public function get($url) {
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
