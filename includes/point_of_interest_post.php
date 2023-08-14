<?php

namespace akzent_points_of_interest;
class PointOfInterestPost {
  public static function save($obj) {
    $t = self::find_by($obj->akzent_id);
    if ($t == NULL) {
      self::create($obj);
    } else {
      self::update($obj, $t);
    }
  }

  public static function destroy_all() {
    $query_args = array('post_type' => 'points_of_interest', 'posts_per_page' => -1);
    $post_query = new WP_Query($query_args);
    if ($post_query->have_posts()) {
      array_map(array(get_called_class(), 'delete_post'), $post_query->posts);
      wp_reset_postdata();
    }
  }

  private static function delete_post($post) {
    wp_delete_post($post->ID, true);
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
    $post_obj     = self::build_post_array($obj);
    $new_post_id  = wp_insert_post($post_obj);
    $a = 1;
    //$poi_image = new AkzentPointOfInterestImage($obj, $new_post_id);
    //$poi_image->create_poi_images();
    //self::create_post_meta_data(self::build_post_meta_array($obj), $new_post_id);
    return $new_post_id;
  }

  private static function create_poi_featured_image($obj, $post_id) {
    $image_url = $obj->images[0]->url;
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents( $image_url );
    $filename = basename($image_url);
    $file_ext_tmp = explode('.', $filename);
    $file_ext = explode('?', $file_ext_tmp[1]);
    $filename = "{$obj->akzent_id}.{$file_ext[0]}";

    if(wp_mkdir_p($upload_dir['path']))
      $file = $upload_dir['path'] . '/' . $filename;
    else
      $file = $upload_dir['basedir'] . '/' . $filename;
      file_put_contents($file, $image_data);

      $wp_filetype = wp_check_filetype($filename, null );
      $attachment = array(
          'post_mime_type' => $wp_filetype['type'],
          'post_title' => sanitize_file_name($filename),
          'post_content' => '',
          'post_status' => 'inherit'
      );
      $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
      require_once(ABSPATH . 'wp-admin/includes/image.php');
      $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
      $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
      $res2= set_post_thumbnail( $post_id, $attach_id );
  }

  private static function update($obj, $old_post) {
    $post_obj       = self::build_post_array($obj);
    $post_obj['ID'] = $old_post->ID;
    $new_post_id    = wp_insert_post($post_obj);

    self::update_post_meta_data(self::build_post_meta_array($obj), $new_post_id);
    return $new_post_id;
  }
  private static function create_post_meta_data($obj, $id) {
    foreach($obj as $key => $value) {
      add_post_meta($id, $key, $value);
    }
  }

  private static function update_post_meta_data($obj, $id) {
    foreach($obj as $key => $value) {
      update__post_meta($id, $key, $value);
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

}
