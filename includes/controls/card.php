<?php

namespace AkzentPointsOfInterest\Controls;
defined('ABSPATH') || exit;

class CardControl extends BaseControl {
  public function create() {
		$this->element->start_controls_section(
			'card_selection_section',
			[
				'label' => 'Card Selection',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

    $this->element->add_control(
      'card_type',
      [
        'label' => 'Card Typ',
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
          'image' => [
            'title' => 'Bild',
            'icon' => 'eicon-text-align-left',
          ],
          'vertical' => [
            'title' => 'Vertikal',
            'icon' => 'eicon-text-align-left',
          ],
          'horizontal' => [
            'title' => 'Horizontal',
            'icon' => 'eicon-text-align-left',
          ],
        ],
        'default' => 'image',
        'toggle' => true,
      ]
    );
    $this->element->end_controls_section();
  }
}
