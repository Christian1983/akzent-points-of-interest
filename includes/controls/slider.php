<?php

namespace AkzentPointsOfInterest\Controls;
defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
class SliderControl extends BaseControl {

  public function create() {
    new DataControl(array('name' => 'Slider', 'element' => $this->element));
    new CardBaseControl(array('name' => 'Slider', 'element' => $this->element));
  }

}
