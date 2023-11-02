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
    $this->api                        = new \AkzentPointsOfInterest\API();
    $this->hotel_url                  = trailingslashit($this->api->base_url) . trailingslashit($api_key);
    $this->points_of_interest_remote  = json_decode($this->api->get($this->hotel_url)['body']);
    $this->points_of_interest_db      = $this->check_list();
  }

  public function check_changed_points_of_interest() {
    $difference = $this->extract_id_map(array_diff($this->points_of_interest_remote, $this->points_of_interest_db));
    $difference_delete = $this->extract_id_map(array_diff($this->points_of_interest_db, $this->points_of_interest_remote));

    $remote = $this->points_of_interest_remote;
    $db = $this->points_of_interest_db;
    if (!empty($difference)) {
      foreach($difference as $entry) {
        $id = explode(',', $entry)[0];
        if ( str_contains(implode($this->points_of_interest_db), $id) ) {
          PointOfInterest::delete(PointOfInterest::find_by($id));
          new Builder($this->api->fetch($id));
        } else {
          if ( str_contains(implode($this->points_of_interest_remote), $id) ) {
            new Builder($this->api->fetch($id));
          }
        }
      }
    }

    // final difference to delete
    $fdifference_delete = array_diff($difference_delete, $difference);
    if (!empty($fdifference_delete)) {
      foreach($difference_delete as $entry) {
        $id = explode(',', $entry)[0];
        PointOfInterest::delete(PointOfInterest::find_by($id));
      }
    }
  }
  private function check_list() {
    $points_of_interest = $this->current_points_of_interest();
    return $this->update_check_list_map($points_of_interest);
  }

  private function update_check_list_map($array) {
    $final_array = [];
    foreach($array as $entry) {
      $final_array[] = "{$entry->akzent_id}, {$entry->updated_at}";
    }

    return $final_array;
  }

  private function extract_id_map($array) {
    $ids=[];
    foreach( $array as $entry) {
      $ids[] = explode(',', $entry)[0];
    }

    return $ids;
  }

  private function current_points_of_interest() {
    $query_args = array('post_type' => AKZENT_POINTS_OF_INTEREST_CPT_NAME);
    $post_query = new \WP_Query($query_args);
    $posts      = $post_query->posts;
    if ($post_query->have_posts()) {
      return $post_query->posts;
    } else {
      return [];
    }
  }
}
