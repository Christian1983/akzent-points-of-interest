<?php

namespace AkzentPointsOfInterest\Models;

class PointOfInterestImage extends \AkzentPointsOfInterest\Core\BaseModel {

  public $path;
  public $filename;
  public $url;
  public $post_id;

  public function __construct($poi_name, $url, $post_id) {
    parent::__construct();
    $this->post_id = $post_id;
    $this->filename = $this->build_filename($object);
    $this->path = $this->build_path($object);
    $this->url  = $url;
  }

  private function download_image($image, $path) {
    $filename = self::build_image_name($image);
    $image_data = file_get_contents( $this->url );
    $file = trailingslashit( $path ) . $filename;
    file_put_contents($file, $image_data);
  }

  private function build_filename() {

  }

  private function build_path() {

  }
  private function check_directory() {

  }

}
