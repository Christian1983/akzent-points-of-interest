<?php

namespace AkzentPointsOfInterest\Controls;
use function AkzentPointsOfInterest\Helper\to_snake_case;
defined('ABSPATH') || exit;

use Elementor\Controls_Manager;

// i want a constructable class thats gives me sections for its name
// with default controls eg.: size, color, align etc.
class TextControl {

  private $name;
  private $element;
  private $defaults;
  private $section_name;

  public function __constructor($name, $element, $defaults=[]) {
    $this->name         = $name;
    $this->element      = $element;
    $this->defaults     = $defaults;
    $this->section_name = 'section_' . $this->element->get_name();
  }

  public function create() {
		$this->element->start_controls_section(
			'section_data',
			[
				'label' => $this->name,
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

    $secion_id  = to_snake_case($this->name) . '_text_color';
    $default    = isset($this->defaults[$secion_id]) ? $this->defaults[$secion_id] : '#FFF';
    $this->add_control(
      $section_id,
      [
        'label' => 'Farbe',
				'type' => Controls_Manager::COLOR,
        'default' => ,
				'selectors' => [
					'{{WRAPPER}} .akzent-point-of-interest-title' => 'color: {{VALUE}}',
				],
      ]
    );

    $this->element->end_controls_section();
  }
}
