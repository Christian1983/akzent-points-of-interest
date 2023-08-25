<?php

namespace AkzentPointsOfInterest\Controls;
defined('ABSPATH') || exit;

class CardBaseControl extends BaseControl {
  public function create() {
		$this->element->start_controls_section(
			'card_selection_section',
			[
				'label' => esc_html__( 'Style', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

    $this->element->add_control(
      'card_selection_control',
      [
        'label' => 'Card Type',
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
          'image' => [
            'title' => 'Image',
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

		//new TextControl('Title', $this, 'akzent-point-of-interest-title', []);
		//new TextControl('Adresse', $this, 'akzent-point-of-interest-address-line', []);
		//new TextControl('Inhalt', $this, 'akzent-point-of-interest-content', []);
		//new TextControl('Entfernung', $this, 'akzent-point-of-interest-distance', []);
		//new TextControl('Rating', $this, 'akzent-point-of-interest-rating-stars', []);
  }



}
