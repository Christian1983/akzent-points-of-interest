<?php

namespace AkzentPointsOfInterest\Models;
class PointOfInterestImage {


  private $filename;
  private $filepath;
  private $url;
  private $post_id;

  function __construct($poi_name, $image_object, $post_id) {
    $this->filename = $this->build_filename($image_object);
    $this->filepath = $this->build_filepath($poi_name);
    $this->url      = $image_object->url;
    $this->post_id  = $post_id;
  }

  // saves all images and sets featured image
  public function save() {
    $this->download_image();
    $this->create_featured_image();
  }

  private function build_filename($image) {
    $filename = basename($image->url);
    $file_ext_tmp = explode('.', $filename);
    $file_ext = explode('?', end($file_ext_tmp));
    return "{$image->id}.{$file_ext[0]}";
  }

  private function build_filepath($poi_name) {
    $path = wp_upload_dir();
    if(wp_mkdir_p($path['path'])) {
      $path = trailingslashit( wp_upload_dir()['path'] ) . $poi_name;
    } else {
      $path = trailingslashit( wp_upload_dir()['basedir'] ) . $poi_name;
    }
    if ( !is_dir($path) ) { wp_mkdir_p($path); }
    return $path;
  }

  private function download_image() {
    $image_data = file_get_contents( $this->url );
    $file = trailingslashit( $this->filepath ) . $this->filename;
    file_put_contents($file, $image_data);
  }

  private function create_featured_image() {
    $wp_filetype = wp_check_filetype($this->filename, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($this->filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $file = trailingslashit( $this->filepath ) . $this->filename;

    $attach_id = wp_insert_attachment( $attachment, $file, $this->post_id );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    $res1 = wp_update_attachment_metadata( $attach_id, $attach_data );
    $res2 = set_post_thumbnail( $this->post_id, $attach_id );
  }

}
