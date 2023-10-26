<?php

namespace AkzentPointsOfInterest\Models;

defined('ABSPATH') || exit;

class PointOfInterest extends \stdClass {

    /**
	 * Model class so we have meta and post information in one stdClass
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param WP_Post   $post          The custom post type post wich we use to create our model
	 */
  function __construct($post) {
    $meta  = get_post_meta($post->ID);

    foreach($post as $key => $value) {
      $this->$key = $value;
    }

    foreach($meta as $key => $value) {
      $this->$key = $value[0];
    }
  }


  public static function destroy_all() {
    $query_args = array('post_type' => AKZENT_POINTS_OF_INTEREST_CPT_NAME, 'posts_per_page' => -1);
    $post_query = new \WP_Query($query_args);
    if ($post_query->have_posts()) {
      array_map(array(get_called_class(), 'delete'), $post_query->posts);
      wp_reset_postdata();
    }
  }

  public static function delete($post) {
    wp_delete_attachment( $post->ID, true );
    wp_delete_post($post->ID, true);
  }
}
