<?php

namespace AkzentPointsOfInterest\Models;

class PointOfInterest extends \AkzentPointsOfInterest\Core\BaseModel {

  public function __construct($object) {
    parent::__construct($object);
  }

  public function inflections() {
    return array(
      'name' => __( 'Reiseinspirationen' ),
      'singular_name' => __( 'Reiseinspiration' )
    );
  }
}
