<?php

namespace AkzentPointsOfInterest\Models;

defined('ABSPATH') || exit;

class Filter {

  public $results = [];
  private $update_checker = null;
  /**
	 * Sort, filter and check for updates.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string   $orderBy        Field wich should be used for order
	 * @param string   $orderDesc      Order direction
	 * @param array    $metaFilter     Contains all filter for meta fields eg.: ['akzent_id', 123, '='] or ['rating', 2.5, '=>']
	 */
  function __construct($orderBy='post_title', $orderDesc=false, $metaFilter=[]) {
    // check every 300 seconds if new data is available
    $this->update_checker = new  Updater();
    $current_api_key = get_option(\AkzentPointsOfInterest\Settings::OPTIONS_BASE_NAME)['api_key'];
    if (!empty($current_api_key)) {
      if (get_transient('akzent_points_of_interest_data_check_1') === false) {
        $this->update_checker->check_changed_points_of_interest();
        set_transient('akzent_points_of_interest_data_check', true, 300);
      }
    }

    $query_args = $this->sanitize_filter($orderBy, $orderDesc, $metaFilter);
    $post_query = new \WP_Query($query_args);
    if ($post_query->have_posts()) {
      foreach($post_query->posts as $post) {
        $this->results[] = new PointOfInterest($post);
      }
    }

  }


  /**
	 * Sanitizes the filter params and builds an array
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string   $orderBy        Field wich should be used for order
	 * @param string   $orderDesc      Order direction
	 * @param array    $metaFilter     Contains all filter for meta fields eg.: ['akzent_id', 123, '='] or ['rating', 2.5, '=>']
	 */
  private function sanitize_filter($orderBy, $orderDesc, $metaFilter) {
    $filterObject = array();

    $filterObject['post_type'] = AKZENT_POINTS_OF_INTEREST_CPT_NAME;
    $filterObject['order'] = $orderDesc ? 'DESC' : 'ASC';
    if ($orderBy == 'name' || $orderBy == 'title' || $orderBy == 'post_title') {
      $filterObject['orderby'] = 'post_title';
    } else {
      $filterObject['orderby'] = 'meta_' . $orderBy;
    }

    if (!empty($metaFilter)) {
      $filterObject['meta_query'] = array();
      foreach($metaFilter as $index => $filter_array) {
        $field = $filter_array[0];
        $value = $filter_array[1];
        $compare = $filter_array[2];
        $final_meta_filter_array[] = array(
          'meta_key' => $field,
          'meta_value' => $value,
          'meta_compare' => $compare
          );
        }
      $filterObject[] = $final_meta_filter_array;
    }

    return $filterObject;
  }

}
