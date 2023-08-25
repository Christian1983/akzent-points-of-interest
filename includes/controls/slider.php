<?php

namespace AkzentPointsOfInterest\Controls;
defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
class SliderControl extends BaseControl {

  public function create() {
		new DataControl('Slider Data', $this->element, null, []);
		$card_control = new CardBaseControl('Card', $this->element, null, []);

  }

}
