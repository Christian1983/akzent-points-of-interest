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

		new TextControl(['name' => 'Title', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-title', 'defaults' => []]);
    new TextControl(['name' => 'Adresse', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-address-line', 'defaults' => []]);
    new TextControl(['name' => 'Inhalt', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-content', 'defaults' => []]);
    new TextControl(['name' => 'Entfernung', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-distance', 'defaults' => []]);
    new TextControl(['name' => 'Rating', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-rating-stars', 'defaults' => []]);
  }



}
