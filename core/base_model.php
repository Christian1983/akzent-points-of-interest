<?php

namespace AkzentPointsOfInterest\Core;
use function AkzentPointsOfInterest\Helper\to_camel_case;
use function AkzentPointsOfInterest\Helper\to_snake_case;

defined('ABSPATH') || exit;

class BaseModel {

  private $model_name;
  private $post_name;
  private $menu_visibility;
  private $menu_icon;
  private $menu_order;
  private $inflections;


  public function __construct($object) {
    $path = explode('\\', get_called_class());
    $this->model_name = array_pop($path);
    $this->post_name = to_snake_case($this->model_name);
    $this->create_from_object($object);
  }

  public static function all() {
    $query_args = array(
      'post_type' => 'points_of_interest',
    );

    $post_query = new \WP_Query($query_args);
    return $post_query->posts;
  }

  public static function find($id) {
    $query_args = array(
      'post_type' => 'points_of_interest',
      'meta_query' => array(
        array(
          'key' => 'akzent_id',
          'value' => $id,
          'compare' => '='
        )
      )
    );

    $post_query = new \WP_Query($query_args);
    return $post_query->posts[0];
  }

  public function create_from_object($object) {
    $post_array       = self::build_post_array($object);
    $post_meta_array  = self::build_post_meta_array($object);
    $new_post_id      = wp_insert_post($post_array);
    if (is_wp_error(!$new_post_id)) {
      foreach($post_meta_array as $key => $value) {
        add_post_meta($new_post_id, $key, $value);
      }
      return $this->find($object->akzent_id);
    }
  }
  private function build_post_array($object) {
    $title    = $object->name;
    $desc     = $object->description;
    $disply   = $object->display;

    return array(
      'post_title' => $title,
      'post_content' => $desc,
      'post_status' => $disply ? 'publish' : 'private',
      'post_author' => 1,
      'post_type' => 'points_of_interest'
    );
  }

  private function build_post_meta_array($object) {
    return array(
      'akzent_id' => $object->akzent_id,
      'rating'  => $object->rating,
      'number_of_ratings' => $object->number_of_ratings,
      'display'  => $object->display,
      'zipcode'  => $object->zipcode,
      'city'     => $object->city,
      'street'   => $object->street
    );
  }
}
