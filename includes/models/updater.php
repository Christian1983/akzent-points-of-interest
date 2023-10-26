<?php

namespace AkzentPointsOfInterest\Models;

defined('ABSPATH') || exit;

class Updater {

  private $api = null;

  private $hotel_url = "";
  private $points_of_interest_db = [];
  private $points_of_interest_remote = [];

  function __construct() {
    $api_key                          = get_option(\AkzentPointsOfInterest\Settings::OPTIONS_BASE_NAME)['api_key'];
    $filter                           = new \AkzentPointsOfInterest\Models\Filter();
    $this->api                        = new \AkzentPointsOfInterest\API();
    $this->hotel_url                  = trailingslashit($this->api->base_url) . trailingslashit($api_key);
    $this->points_of_interest_remote  = json_decode($this->api->get($this->hotel_url)['body']);
    $this->points_of_interest_db      = $this->update_check_list_map($filter->results);

    $this->check_changed_points_of_interest();
  }
  private function check_changed_points_of_interest() {
    $difference                 = array_diff($this->points_of_interest_remote, $this->points_of_interest_db);
    if (empty($difference)) { return ; }

    foreach($difference as $entry) {
      $id = explode(',', $entry)[0];
      if ( str_contains(implode($this->points_of_interest_db), $id) ) {
        PointOfInterest::delete(PointOfInterest::find_by($id));
        new Builder($this->api->fetch($id));
      } else {
        if ( str_contains(implode($this->points_of_interest_remote), $id) ) {
          new Builder($this->api->fetch($id));
        } else {
          PointOfInterest::delete(PointOfInterest::find_by($id));
        }
      }
    }
    return 0;
  }
  private function check_list() {
    $points_of_interest = new \AkzentPointsOfInterest\Models\Filter();
    return $this->update_check_list_map($points_of_interest);
  }

  private function update_check_list_map($array) {
    $final_array = [];
    foreach($array as $entry) {
      $final_array[] = "{$entry->akzent_id}, {$entry->updated_at}";
    }

    return $final_array;
  }
}
