<?php

namespace akzent_points_of_interest;
class PointOfInterestImage {
  private $obj;
  private $post_id;

  function __construct($obj, $post_id) {
    $this->obj = $obj;
    $this->post_id = $post_id;
  }

  public function create_poi_images() {
    if ($this->obj->images == NULL) { return; }

    foreach($this->obj->images as $image) {
      $path = self::create_poi_image_directory();
      $this->download_image($image, $path);
    }

    $featured_image = $this->obj->images[0];
    $name = $this->build_image_name($featured_image);
    $path = $this->build_image_path($this->obj);
    $this->create_featured_image($name, $path);
  }

  private function download_image($image, $path) {
    $filename = self::build_image_name($image);
    $image_data = file_get_contents( $image->url );
    $file = trailingslashit( $path ) . $filename;
    file_put_contents($file, $image_data);
  }

  private function build_image_name($image) {
    $filename = basename($image->url);
    $file_ext_tmp = explode('.', $filename);
    $file_ext = explode('?', $file_ext_tmp[1]);

    return "{$image->id}.{$file_ext[0]}";
  }

  private function build_image_path($obj) {
    $poi_name = str_replace(' ', '_', strtolower($obj->name));
    $path = wp_upload_dir();
    if(wp_mkdir_p($path['path'])) {
      $path = trailingslashit( wp_upload_dir()['path'] ) . $poi_name;
    } else {
      $path = trailingslashit( wp_upload_dir()['basedir'] ) . $poi_name;
    }

    return $path;
  }

  private function create_poi_image_directory() {
    $path = self::build_image_path($this->obj);
    if ( !is_dir($path) ) {
      return wp_mkdir_p($path);
    }

    return $path;
  }

  private function create_featured_image($filename, $path) {
    $wp_filetype = wp_check_filetype($filename, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $file = trailingslashit( $path ) . $filename;

    $attach_id = wp_insert_attachment( $attachment, $file, $this->post_id );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    $res1 = wp_update_attachment_metadata( $attach_id, $attach_data );
    $res2 = set_post_thumbnail( $this->post_id, $attach_id );
  }
}
