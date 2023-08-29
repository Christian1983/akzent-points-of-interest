<?php

namespace AkzentPointsOfInterest\Controls;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;

class SliderControl extends BaseControl
{

  public $local_defaults;

  function __construct($args) {
    parent::__construct($args);
    $a=\Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY;

    $this->local_defaults = [

    ];
  }

  public function create() {
    new SliderBaseControl(array('name' => 'Image Slider', 'element' => $this->element));
    new TextControl(['name' => 'Title', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-title', 'defaults' => $this->defaults()]);
    new TextControl(['name' => 'Adresse', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-address-line', 'defaults' => []]);
    new TextControl(['name' => 'Inhalt', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-content', 'defaults' => []]);
    new TextControl(['name' => 'Entfernung', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-distance', 'defaults' => []]);
    new TextControl(['name' => 'Rating', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-rating-stars', 'defaults' => []]);
  }

  private function defaults() {
    return [
      'title_text_color' => '#FFF',
      'title_typography' => [
        'typography' => ['default' => 'yes'],
        'font_weight' => ['default' => '100'],
        'font_family' => ['default' => 'Saira'],
        'font_size' => [ 'default' => [ 'unit' => 'vw', 'size' => 2.25 ] ],
        'letter_spacing' => [ 'default' => ['unit' => 'rem', 'size' => 0.45]],
        'word_spacing' => [ 'default' => ['unit' => 'rem', 'size' => 0.45]]
      ],

      'title_text_shadow' => [
        'blur' => ['default' => 15],
        'color' => ['default' => 'rgba(0,0,0,0.25)']
      ]
    ];
  }

}
