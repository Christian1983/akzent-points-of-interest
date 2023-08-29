<?php

namespace AkzentPointsOfInterest\Controls;
defined('ABSPATH') || exit;

class CardControl extends BaseControl {

  private $size;

  function __construct($args) {
    parent::__construct($args);
    $this->size = isset($args['size']) ? $args['size'] : 'large';
  }
  public function create() {
    new TextControl(['name' => 'Title', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-title', 'defaults' => $this->defaults()]);
    new TextControl(['name' => 'Address', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-address-line', 'defaults' => $this->defaults()]);
    new TextControl(['name' => 'Content', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-content', 'defaults' => $this->defaults()]);
    new TextControl(['name' => 'Distance', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-distance', 'defaults' => $this->defaults()]);
    new TextControl(['name' => 'Rating', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-rating', 'defaults' => $this->defaults()]);
  }

  private function defaults() {
    if ($this->size == 'large') return $this->defaults_large();
    if ($this->size == 'medium') return $this->defaults_medium();
    if ($this->size == 'small') return $this->defaults_small();

    return $this->defaults_large();
  }

  private function defaults_large() {
    return [
      'title_text_color' => '#FFF',
      'title_text_align' => 'center',
      'title_typography' => [
        'typography' => ['default' => 'yes'],
        'font_weight' => ['default' => '100'],
        'font_family' => ['default' => 'Verdana'],
        'font_size' => [ 'default' => [ 'unit' => 'vw', 'size' => 3 ], 'tablet_default' => [ 'unit' => 'px', 'size' => 28 ], 'mobile_default' => [ 'unit' => 'px', 'size' => 16 ] ],
        'letter_spacing' => [ 'default' => ['unit' => 'rem', 'size' => 0.45]],
        'word_spacing' => [ 'default' => ['unit' => 'rem', 'size' => 0.75], 'tablet_default' => ['unit' => 'rem', 'size' => 0.25], 'mobile_default' => ['unit' => 'rem', 'size' => 0.25]]
      ],

      'title_text_shadow' => [
        'horizontal' => ['default' => '1'],
        'vertical' => ['default' => '1'],
        'blur' => ['default' => '0'],
        'color' => ['default' => 'rgba(0,0,0,0.75)']
      ],

      'address_text_color' => '#F2F2F2',
      'address_text_align' => 'center',
      'address_typography' => [
        'typography' => ['default' => 'yes'],
        'font_weight' => ['default' => '200'],
        'font_family' => ['default' => 'Verdana'],
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

      //TODO: fix this, it dosent work
      'content_hide' => [
        'default' => 'no',
        'tablet_default' => 'yes',
        'mobile_default' => 'yes'
      ],

      'content_padding' => [
        'unit' => 'px',
        'top' => 15,
        'right' => 15,
        'bottom' => 15,
        'left' => 15
      ],
      'content_text_color' => '#F2F2F2',
      'content_typography' => [
        'typography' => ['default' => 'yes'],
        'font_weight' => ['default' => '400'],
        'font_family' => ['default' => 'Verdana'],
        'font_size' => [ 'default' => [ 'unit' => 'vw', 'size' => 1.0 ] ],
      ],
      'content_text_shadow' => [
        'horizontal' => ['default' => 1],
        'vertical' => ['default' => 1],
        'blur' => ['default' => 0],
        'color' => ['default' => 'rgba(0,0,0,0.75)']
      ],

      'distance_text_color' => AKZENT_POINTS_OF_INTEREST_PRIMARY_COLOR,
      'distance_text_align' => 'left',
      'distance_padding' => [
        'unit' => 'px',
        'top' => 15,
        'right' => 15,
        'bottom' => 15,
        'left' => 15
      ],
      'distance_typography' => [
        'font_weight' => ['default' => '400'],
        'font_family' => ['default' => 'Verdana'],
        'font_size' => [ 'default' => [ 'unit' => 'vw', 'size' => 1.25 ], 'tablet_default' => [ 'unit' => 'px', 'size' => 14 ], 'mobile_default' => [ 'unit' => 'px', 'size' => 12 ] ],
      ],
      'distance_text_shadow' => [
        'horizontal' => ['default' => 1],
        'vertical' => ['default' => 1],
        'blur' => ['default' => 0],
        'color' => ['default' => 'rgba(255,255,255,0.75)']
      ],


      'rating_text_color' => AKZENT_POINTS_OF_INTEREST_PRIMARY_COLOR,
      'rating_text_align' => 'right',
      'rating_padding' => [
        'unit' => 'px',
        'top' => 15,
        'right' => 15,
        'bottom' => 15,
        'left' => 15
      ],
      'rating_typography' => [
        'font_weight' => ['default' => '100'],
        'font_family' => ['default' => 'Verdana'],
        'font_size' => [ 'default' => [ 'unit' => 'vw', 'size' => 1.25 ], 'tablet_default' => [ 'unit' => 'vw', 'size' => 1 ], 'mobile_default' => [ 'unit' => 'vw', 'size' => 1 ] ],
      ],
      'rating_text_shadow' => [
        'horizontal' => ['default' => 1],
        'vertical' => ['default' => 1],
        'blur' => ['default' => 0],
        'color' => ['default' => 'rgba(255,255,255,1.0)']
      ],

    ];
  }

  private function defaults_medium() {

  }

  private function defaults_small() {
    $a=1;
    return [
      'title_text_color' => '#FFF',
      'title_text_align' => 'center',
      'title_typography' => [
        'typography' => ['default' => 'yes'],
        'font_weight' => ['default' => '200'],
        'font_family' => ['default' => 'Verdana'],
        'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 24 ] ],
        'letter_spacing' => [ 'default' => ['unit' => 'rem', 'size' => 0.25]],
        'word_spacing' => [ 'default' => ['unit' => 'rem', 'size' => 0.35]]
      ],

      'title_text_shadow' => [
        'horizontal' => ['default' => '1'],
        'vertical' => ['default' => '1'],
        'blur' => ['default' => '0'],
        'color' => ['default' => 'rgba(0,0,0,0.75)']
      ],

      'address_text_color' => '#F2F2F2',
      'address_text_align' => 'center',
      'address_typography' => [
        'typography' => ['default' => 'yes'],
        'font_weight' => ['default' => '200'],
        'font_family' => ['default' => 'Verdana'],
        'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 16 ] ],
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

      //TODO: fix this, it dosent work
      'content_hide' => [
        'default' => 1,
        'tablet_default' => 1,
        'mobile_default' => 1
      ],

      'content_padding' => [
        'unit' => 'px',
        'top' => 15,
        'right' => 15,
        'bottom' => 15,
        'left' => 15
      ],
      'content_text_color' => '#F2F2F2',
      'content_typography' => [
        'typography' => ['default' => 'yes'],
        'font_weight' => ['default' => '400'],
        'font_family' => ['default' => 'Verdana'],
        'font_size' => [ 'default' => [ 'unit' => 'vw', 'size' => 1.0 ] ],
      ],
      'content_text_shadow' => [
        'horizontal' => ['default' => 1],
        'vertical' => ['default' => 1],
        'blur' => ['default' => 0],
        'color' => ['default' => 'rgba(0,0,0,0.75)']
      ],

      'distance_text_color' => AKZENT_POINTS_OF_INTEREST_PRIMARY_COLOR,
      'distance_text_align' => 'left',
      'distance_padding' => [
        'unit' => 'px',
        'top' => 15,
        'right' => 15,
        'bottom' => 15,
        'left' => 15
      ],
      'distance_typography' => [
        'font_weight' => ['default' => '400'],
        'font_family' => ['default' => 'Verdana'],
        'font_size' => [ 'default' => [ 'unit' => 'vw', 'size' => 1.25 ], 'tablet_default' => [ 'unit' => 'px', 'size' => 14 ], 'mobile_default' => [ 'unit' => 'px', 'size' => 12 ] ],
      ],
      'distance_text_shadow' => [
        'horizontal' => ['default' => 1],
        'vertical' => ['default' => 1],
        'blur' => ['default' => 0],
        'color' => ['default' => 'rgba(255,255,255,0.75)']
      ],


      'rating_text_color' => AKZENT_POINTS_OF_INTEREST_PRIMARY_COLOR,
      'rating_text_align' => 'right',
      'rating_padding' => [
        'unit' => 'px',
        'top' => 15,
        'right' => 15,
        'bottom' => 15,
        'left' => 15
      ],
      'rating_typography' => [
        'font_weight' => ['default' => '100'],
        'font_family' => ['default' => 'Verdana'],
        'font_size' => [ 'default' => [ 'unit' => 'vw', 'size' => 1.25 ], 'tablet_default' => [ 'unit' => 'vw', 'size' => 1 ], 'mobile_default' => [ 'unit' => 'vw', 'size' => 1 ] ],
      ],
      'rating_text_shadow' => [
        'horizontal' => ['default' => 1],
        'vertical' => ['default' => 1],
        'blur' => ['default' => 0],
        'color' => ['default' => 'rgba(255,255,255,1.0)']
      ],

    ];
  }
}
