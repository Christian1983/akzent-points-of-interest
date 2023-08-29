<?php

namespace AkzentPointsOfInterest\Controls;
use function AkzentPointsOfInterest\Helper\to_snake_case;
defined('ABSPATH') || exit;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;

// i want a constructable class thats gives me sections for its name
// with default controls eg.: size, color, align etc.
class TextControl extends BaseControl {

  public function create() {
    $section_id  = to_snake_case($this->name) . '_section';
		$this->element->start_controls_section(
			$section_id,
			[
				'label' => $this->name,
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

    $control_id  = to_snake_case($this->name) . '_hide';
    $this->element->add_control(
      $control_id,
      [
        'label' => 'Verstecken',
        'seperator' => 'after',
        'type' => Controls_Manager::SWITCHER,
				'label_on' => 'Ja',
				'label_off' => 'Nein',
        'default' => 'block',
				'return_value' => 'none',
        'selectors' => [
          "{{WRAPPER}} .{$this->selector}" => 'display: {{VALUE}}',
        ],
      ]
    );

    $control_id  = to_snake_case($this->name) . '_text_color';
    $default     = isset($this->defaults[$control_id]) ? $this->defaults[$control_id] : '#FFF';
    $this->element->add_control(
      $control_id,
      [
        'label' => 'Farbe',
        'seperator' => 'after',
				'type' => Controls_Manager::COLOR,
        'default' => $default,
        'selectors' => [
          "{{WRAPPER}} .{$this->selector}" => 'color: {{VALUE}}',
        ],
      ]
    );

    $control_id  = to_snake_case($this->name) . '_text_shadow';
    $default     = isset($this->defaults[$control_id]) ? $this->defaults[$control_id] : [];
		$this->element->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => $control_id,
				'selector' => "{{WRAPPER}} .{$this->selector}",
        'fields_options' => $default
			]
		);


    $control_id  = to_snake_case($this->name) . '_typography';
    $default     = isset($this->defaults[$control_id]) ? $this->defaults[$control_id] : [];
    $this->element->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => $control_id,
				'selector' => ".{$this->selector}",
        'fields_options' => $default
			]
		);

    $this->element->end_controls_section();
  }
}
