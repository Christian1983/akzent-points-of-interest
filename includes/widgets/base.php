<?php

namespace AkzentPointsOfInterest\Widgets;
defined('ABSPATH') || exit;

use AkzentPointsOfInterest\Models\PointOfInterest;
use AkzentPointsOfInterest\Render;

abstract class WidgetBase extends \Elementor\Widget_Base {

	public $points_of_interest;

	public $render;

	public function get_style_depends() {
    return [ 'akzent_bootstrap_style', 'akzent_main_style' ];
   }

	public function get_points_of_interest_for_settings($settings) {
		$this->render = new Render();
		$this->points_of_interest = PointOfInterest::filter($settings['sort_field'], $settings['sort_direction']);
	}


}
