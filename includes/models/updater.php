<?php

namespace AkzentPointsOfInterest\Models;

defined('ABSPATH') || exit;

class Updater {

  public static function check_list() {
    $points_of_interest = self::filter();
    return self::update_check_list_map($points_of_interest);
  }
}
