<?php

namespace AkzentPointsOfInterest\Models;

defined('ABSPATH') || exit;

class Filter {

  public $results = [];

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
    if (get_transient( 'akzent_check_changed_points_of_interest_1' ) === false) {
      //do_action( 'check_changed_points_of_interest' );
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
      $filterObject['orderBy'] = 'post_title';
    } else {
      $filterObject['orderBy'] = 'meta_' . $orderBy;
    }

    if (!empty($metaFilter)) {
      $filterObject['meta_query'] = array();
      foreach($metaFilter as $index => $filter_array) {
        $field = $filter_array[0];
        $value = $filter_array[1];
        $compare = $filter_array[2];
        $final_meta_filter_array[] = array(
          'key' => $field,
          'value' => $value,
          'compare' => $compare
          );
        }
    }

    return $filterObject;
  }

}
