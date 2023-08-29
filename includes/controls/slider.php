<?php

namespace AkzentPointsOfInterest\Controls;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;

class SliderControl extends BaseControl
{

   function __construct($args) {
    parent::__construct($args);
  }

  public function create() {
    new SliderBaseControl(array('name' => 'Image Slider', 'element' => $this->element));
    new TextControl(['name' => 'Title', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-title', 'defaults' => $this->defaults()]);
    new TextControl(['name' => 'Address', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-address-line', 'defaults' => $this->defaults()]);
    new TextControl(['name' => 'Content', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-content', 'defaults' => $this->defaults()]);
    new TextControl(['name' => 'Distance', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-distance', 'defaults' => $this->defaults()]);
    new TextControl(['name' => 'Rating', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-rating', 'defaults' => $this->defaults()]);
  }

  private function defaults() {
    return [
      'title_text_color' => '#FFF',
      'title_text_align' => 'center',
      'title_typography' => [
        'typography' => ['default' => 'yes'],
        'font_weight' => ['default' => '200'],
        'font_family' => ['default' => 'Saira'],
        'font_size' => [ 'default' => [ 'unit' => 'vw', 'size' => 2.25 ], 'tablet_default' => [ 'unit' => 'px', 'size' => 14 ], 'mobile_default' => [ 'unit' => 'px', 'size' => 30 ] ],
        'letter_spacing' => [ 'default' => ['unit' => 'rem', 'size' => 0.45]],
        'word_spacing' => [ 'default' => ['unit' => 'rem', 'size' => 0.45]]
      ],

      'title_text_shadow' => [
        'horizontal' => ['default' => 1],
        'vertical' => ['default' => 1],
        'blur' => ['default' => 0],
        'color' => ['default' => 'rgba(0,0,0,1)']
      ],

      'address_text_color' => '#F2F2F2',
      'address_text_align' => 'center',
      'address_typography' => [
        'typography' => ['default' => 'yes'],
        'font_weight' => ['default' => '200'],
        'font_family' => ['default' => 'Saira'],
        'font_size' => [ 'default' => [ 'unit' => 'vw', 'size' => 1.25 ] ],
      ],
      'address_text_shadow' => [
        'horizontal' => ['default' => 1],
        'vertical' => ['default' => 1],
        'blur' => ['default' => 0],
        'color' => ['default' => 'rgba(0,0,0,0.75)']
      ],

      'address_margin' => [
        'unit' => 'vw',
        'top' => 0,
        'right' => 0,
        'bottom' => 3,
        'left' => 0
      ],

      'content_hide' => [
        'default' => 'no',
        'tablet_default' => 'yes',
        'mobile_default' => 'yes'
      ],
      'content_text_color' => '#F2F2F2',
      'content_typography' => [
        'typography' => ['default' => 'yes'],
        'font_weight' => ['default' => '400'],
        'font_family' => ['default' => 'Saira'],
        'font_size' => [ 'default' => [ 'unit' => 'vw', 'size' => 1.25 ] ],
      ],
      'content_text_shadow' => [
        'horizontal' => ['default' => 1],
        'vertical' => ['default' => 1],
        'blur' => ['default' => 0],
        'color' => ['default' => 'rgba(0,0,0,0.75)']
      ],

      'distance_text_color' => AKZENT_POINTS_OF_INTEREST_PRIMARY_COLOR,
      'distance_text_align' => 'center',
      'distance_typography' => [
        'typography' => ['default' => 'yes'],
        'font_weight' => ['default' => '400'],
        'font_family' => ['default' => 'Saira'],
        'font_size' => [ 'default' => [ 'unit' => 'vw', 'size' => 1.25 ], 'tablet_default' => [ 'unit' => 'px', 'size' => 14 ], 'mobile_default' => [ 'unit' => 'px', 'size' => 12 ] ],
      ],
      'distance_text_shadow' => [
        'horizontal' => ['default' => 1],
        'vertical' => ['default' => 1],
        'blur' => ['default' => 0],
        'color' => ['default' => 'rgba(255,255,255,0.75)']
      ],


      'rating_text_color' => AKZENT_POINTS_OF_INTEREST_PRIMARY_COLOR,
      'rating_text_align' => 'center',
      'rating_typography' => [
        'typography' => ['default' => 'yes'],
        'font_weight' => ['default' => '400'],
        'font_family' => ['default' => 'Saira'],
        'font_size' => [ 'default' => [ 'unit' => 'vw', 'size' => 1.25 ], 'tablet_default' => [ 'unit' => 'px', 'size' => 14 ], 'mobile_default' => [ 'unit' => 'px', 'size' => 12 ] ],
      ],
      'rating_text_shadow' => [
        'horizontal' => ['default' => 1],
        'vertical' => ['default' => 1],
        'blur' => ['default' => 0],
        'color' => ['default' => 'rgba(255,255,255,0.75)']
      ],

    ];
  }

}
