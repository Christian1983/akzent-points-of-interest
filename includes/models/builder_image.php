<?php

namespace AkzentPointsOfInterest\Models;

defined('ABSPATH') || exit;

class BuilderImage {
  public $filename;
  private $path;
  private $url;
  private $file;
  private $post_id;

  function __construct($image_object, $post_id) {
    $this->path     = $this->build_filepath();
    $this->filename = $this->build_filename($image_object);
    $this->file     = $this->path . $this->filename;
    $this->url      = $image_object->url;
    $this->post_id  = $post_id;
  }

  public function save() {
    $this->download_image();
    $this->create_featured_image();
  }

  private function download_image() {
    $image_data = file_get_contents( $this->url );
    $file = $this->file;
    file_put_contents($file, $image_data);
  }

  private function build_filepath() {
    $path = wp_upload_dir();

    if(wp_mkdir_p($path['path'])) {
      $path = trailingslashit( wp_upload_dir()['path'] ) . AKZENT_POINTS_OF_INTEREST_IMAGE_PATH;
    } else {
      $path = trailingslashitI(wp_upload_dir()['basedir'])  . AKZENT_POINTS_OF_INTEREST_IMAGE_PATH;
    }

    if ( !is_dir($path) ) { wp_mkdir_p($path); }
    return $path;
  }

  private function build_filename($image) {
    $filename = basename($image->url);
    $url=array(
      "%C3%84","%C3%A4",
      "%C3%9C","%C3%BC",
      "%C3%96","%C3%B6",
      "%C3%82","%C3%A2",
      "%C3%81","%C3%A1"
    );

   $chars_replacement=array(
    'Ae','ae',
    'Ue','ue'.
    'Oe','oe',
    'A','a',
    'A','a'
   );

    $sanitized_filename = str_replace($url, $chars_replacement, $filename);
    $sanitized_filename = explode('?', $sanitized_filename)[0];

    return $sanitized_filename;
  }

  private function create_featured_image() {
    $wp_filetype = wp_check_filetype($this->filename, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($this->filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );

    $attach_id = wp_insert_attachment( $attachment, $this->file, $this->post_id );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $this->file );
    $res1 = wp_update_attachment_metadata( $attach_id, $attach_data );
    $res2 = set_post_thumbnail( $this->post_id, $attach_id );
  }
}
