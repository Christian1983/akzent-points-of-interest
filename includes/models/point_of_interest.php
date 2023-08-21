<?php

namespace AkzentPointsOfInterest\Models;
class PointOfInterest {
  public static function save($obj) {
    $t = self::find_by($obj->akzent_id);
    if ($t == NULL) {
      return self::create($obj);
    } else {
      return self::update($obj, $t);
    }
  }

  private static function find_by($akzent_id) {
    $query_args = array(
      'post_type' => 'points_of_interest',
      'meta_query' => array(
        array(
          'key' => 'akzent_id',
          'value' => $akzent_id,
          'compare' => '='
        )
      )
    );

    $post_query = new \WP_Query($query_args);
    if ($post_query->have_posts()) {
      return $post_query->the_post();
    } else {
      return NULL;
    }
  }

  private static function create($obj) {
    $post_array       = self::build_post_array($obj);
    $post_meta_array  = self::build_post_meta_array($obj);
    $new_post_id  = wp_insert_post($post_array);
    if (is_wp_error( $new_post_id )) { return false; }

    foreach($post_meta_array as $key => $value) {
      add_post_meta( $new_post_id, $key, $value );
    }

    return true;
  }

  private static function update($obj, $old_post) {
    //TODO: implement
  }

  private static function create_post_meta_data($obj, $id) {
    foreach($obj as $key => $value) {
      add_post_meta($id, $key, $value);
    }
  }

  private static function update_post_meta_data($obj, $id) {
    foreach($obj as $key => $value) {
      update_post_meta($id, $key, $value);
    }
  }

  private static function build_post_array($obj) {
    $title    = $obj->name;
    $desc     = $obj->description;
    $disply  = $obj->display;

    $post_array = array(
      'post_title' => $title,
      'post_content' => $desc,
      'post_status' => $disply ? 'publish' : 'private',
      'post_author' => 1,
      'post_type' => 'points_of_interest'
    );

    return $post_array;
  }

  private static function build_post_meta_array($obj) {
    $post_meta_array = array(
      'akzent_id' => $obj->akzent_id,
      'rating'  => $obj->rating,
      'number_of_ratings' => $obj->number_of_ratings,
      'display'  => $obj->display,
      'zipcode'  => $obj->zipcode,
      'city'     => $obj->city,
      'street'   => $obj->street
    );

    return $post_meta_array;
  }

  public static function register() {
    $result = register_post_type( 'points_of_interest',
      array(
        'labels' => array(
            'name' => __( 'Reiseinspirationen' ),
            'singular_name' => __( 'Reiseinspiration' )
          ),
          'capabilities' => array(
            'read_points_of_interest' => true,
            'delete_points_of_interest' => true,
            'create_points_of_interest' => false,
            'edit_points_of_interest' => false,
          ),
          'has_archive' => true,
          'public' => true,
          'show_in_rest' => true, // nötig damit gutenberg die pois 'sehen' kann
          'show_ui' => true,
          'show_in_menu' => true,
          'menu_position' => 4,
          'menu_icon' => 'dashicons-sticky',
          'rewrite' => array('slug' => 'reiseinspirationen'),
          'supports' => array('title', 'editor', 'description', 'author', 'thumbnail', 'custom-fields')
        )
      );
  }

  public static function destroy_all() {
    $query_args = array('post_type' => 'points_of_interest', 'posts_per_page' => -1);
    $post_query = new \WP_Query($query_args);
    if ($post_query->have_posts()) {
      array_map(array(get_called_class(), 'delete_post'), $post_query->posts);
      wp_reset_postdata();
    }
  }

  private static function delete_post($post) {
    wp_delete_post($post->ID, true);
  }
}
