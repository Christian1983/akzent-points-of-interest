<?php

namespace AkzentPointsOfInterest\Models;

defined('ABSPATH') || exit;

class Builder {


  /**
	 * Takes a Array or StdClass and creates a PointOfInterest custom post for every entry and for each image inside that entry.
   * We want to create a new post for every image since we want the featured image function for every post
   * also this way we can easily update and delete
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string   $obj           The Array | StdClass with all information for meta and post aswell as image information.
	 */
  function __construct($obj) {
    if ( empty($obj->images) ) { return false; } // we dont want poi's without images

    $_obj = clone($obj);
    unset($_obj->images); // unset image information in post hash
    foreach($obj->images as $image) {
      $post_array           = $this->build_post_array($_obj);
      $new_post_id          = wp_insert_post($post_array);
      $img_obj              = new BuilderImage($image, $new_post_id);

      $_obj->user           = $image->user;
      $_obj->user_url       = $image->user_url;
      $_obj->filename       = $img_obj->filename;
      $_obj->image_id       = $image->akzent_id;
      $_obj->image_updated  = $image->updated_at;

      $post_meta_array      = $this->build_post_meta_array($_obj);
      if ( !is_wp_error( $new_post_id )) {
        foreach($post_meta_array as $key => $value) {
          add_post_meta( $new_post_id, $key, $value );
        }

        $img_obj->save();
      }

    }
  }

  /**
   * Takes a stdClass and builds the array to create a post
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param \stdClass   $obj
	 */
  private function build_post_array($obj) {
    $post_array = array(
      'post_title'    => $obj->name,
      'post_content'  => $obj->description,
      'post_status'   => $obj->display ? 'publish' : 'private',
      'post_author'   => 1,
      'post_type'     => AKZENT_POINTS_OF_INTEREST_CPT_NAME
    );

    return $post_array;
  }

  private function build_post_meta_array($obj) {
    $post_meta_array = array(
      'akzent_id'         => $obj->akzent_id,
      'rating'            => $obj->rating,
      'number_of_ratings' => $obj->number_of_ratings,
      'display'           => $obj->display,
      'distance'          => $obj->distance,
      'distance_str'      => $obj->distance_word,
      'zipcode'           => $obj->zipcode,
      'city'              => $obj->city,
      'street'            => $obj->street,
      'updated_at'        => $obj->updated_at,
      'user'              => $obj->user,
      'user_url'          => $obj->user_url
    );

    return $post_meta_array;
  }
}
