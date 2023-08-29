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
    $default     = isset($this->defaults[$control_id]) ? $this->defaults[$control_id] : 'block';
    $this->element->add_responsive_control(
      $control_id,
      [
        'label' => 'Hide',
        'seperator' => 'after',
        'type' => Controls_Manager::SWITCHER,
				'label_on' => 'Yes',
				'label_off' => 'No',
        'default' => $default,
				'return_value' => 'none',
        'selectors' => [
          "{{WRAPPER}} {$this->selector}" => 'display: {{VALUE}}',
        ],
      ]
    );

    $control_id  = to_snake_case($this->name) . '_text_align';
    $default     = isset($this->defaults[$control_id]) ? $this->defaults[$control_id] : 'center';
		$this->element->add_control(
			$control_id,
			[
				'label' => 'Alignment',
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => 'Left',
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => 'Center',
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => 'Right',
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => $default,
				'toggle' => true,
				'selectors' => [
					"{{WRAPPER}} {$this->selector}" => 'text-align: {{VALUE}};',
				],
			]
		);

    $control_id  = to_snake_case($this->name) . '_margin';
    $default     = isset($this->defaults[$control_id]) ? $this->defaults[$control_id] : [];
		$this->element->add_responsive_control(
			$control_id,
			[
				'label' => 'Margin',
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
        'default' => $default,
				'selectors' => [
					"{{WRAPPER}} {$this->selector}" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

    $control_id  = to_snake_case($this->name) . '_padding';
    $default     = isset($this->defaults[$control_id]) ? $this->defaults[$control_id] : [];
		$this->element->add_responsive_control(
			$control_id,
			[
				'label' => 'Padding',
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
        'default' => $default,
				'selectors' => [
					"{{WRAPPER}} {$this->selector}" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
          "{{WRAPPER}} {$this->selector}" => 'color: {{VALUE}}',
        ],
      ]
    );

    $control_id  = to_snake_case($this->name) . '_text_shadow';
    $default     = isset($this->defaults[$control_id]) ? $this->defaults[$control_id] : [];
		$this->element->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => $control_id,
				'selector' => "{{WRAPPER}} {$this->selector}",
        'fields_options' => $default
			]
		);


    $control_id  = to_snake_case($this->name) . '_typography';
    $default     = isset($this->defaults[$control_id]) ? $this->defaults[$control_id] : [];
    $this->element->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => $control_id,
				'selector' => "{{WRAPPER}} {$this->selector}",
        'fields_options' => $default
			]
		);

    $this->element->end_controls_section();
  }
}
