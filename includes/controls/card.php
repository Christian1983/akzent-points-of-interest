<?php

namespace AkzentPointsOfInterest\Controls;
defined('ABSPATH') || exit;

class CardControl extends BaseControl {

  private $size;

  function __construct($args) {
    $this->size = isset($args['size']) ? $args['size'] : 'large';
    parent::__construct($args);
  }
  public function create() {
    new TextControl(['name' => 'Title', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-title', 'defaults' => $this->defaults()]);
    new TextControl(['name' => 'Address', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-address-line', 'defaults' => $this->defaults()]);
    new TextControl(['name' => 'Content', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-content', 'defaults' => $this->defaults()]);
    new TextControl(['name' => 'Distance', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-distance', 'defaults' => $this->defaults()]);
    new TextControl(['name' => 'Rating', 'element' => $this->element, 'selector' => 'akzent-point-of-interest-rating-wrapper', 'defaults' => $this->defaults()]);
  }

  private function defaults() {
    if ($this->size == 'medium') return $this->defaults_medium();
    if ($this->size == 'small') return $this->defaults_small();

    return $this->defaults_base();
  }

  private function defaults_medium() {
    $override = $this->defaults_base();
    $override['title_typography']['font_size']['default'] = ['unit' => 'px', 'size' => 24];

    return $override;
  }

  private function defaults_small() {
    $override = $this->defaults_base();
    $override['title_typography']['font_size']['default'] = ['unit' => 'px', 'size' => 24];
    $override['content_hide']['desktop'] = 'none';
    $override['address_typography']['font_size'] = [ 'default' => [ 'unit' => 'px', 'size' => 11 ] ];
    return $override;
  }

  private function defaults_base() {
    return [

      // ### TITLE ###
      'title_text_align' => 'center',
      'title_typography' => [
        'typography' => ['default' => 'yes'],
        'font_family' => ['default' => 'Verdana'],
        'font_size' => [ 'default' => [ 'unit' => 'vw', 'size' => 2.0 ], 'tablet_default' => [ 'unit' => 'px', 'size' => 32 ], 'mobile_default' => [ 'unit' => 'px', 'size' => 28 ] ],
        'letter_spacing' => [ 'default' => ['unit' => 'rem', 'size' => 0.45]],
        'word_spacing' => [ 'default' => ['unit' => 'rem', 'size' => 0.75], 'tablet_default' => ['unit' => 'rem', 'size' => 0.25], 'mobile_default' => ['unit' => 'rem', 'size' => 0.25]]
      ],

      'title_text_shadow' => [
        'text_shadow' => ['default' => [
          'horizontal' => 1,
          'vertical' => 1,
          'blur' => 5,
          'color' => 'rgba(0,0,0,1.0)'
        ]],
      ],

      'title_margin' => [
        'unit' => 'vw',
        'top' => 0,
        'right' => 0,
        'bottom' => 0,
        'left' => 0
      ],

      // ### ADDRESS ###
      'address_text_align' => 'center',
      'address_typography' => [
        'typography' => ['default' => 'yes'],
        'font_weight' => ['default' => '200', 'tablet_default' => '400', 'mobile_default' => '400'],
        'font_family' => ['default' => 'Verdana'],
        'font_size' => [ 'default' => [ 'unit' => 'vw', 'size' => 1.25 ], 'tablet_default' => [ 'unit' => 'vw', 'size' => 2 ], 'mobile_default' => [ 'unit' => 'vw', 'size' => 3 ] ],
        'word_spacing' => [ 'default' => ['unit' => 'px', 'size' => 10], 'tablet_default' => ['unit' => 'px', 'size' => 8], 'mobile_default' => ['unit' => 'px', 'size' => 6]],
      ],
      'address_text_shadow' => [
        'text_shadow' => ['default' => [
          'horizontal' => 1,
          'vertical' => 1,
          'blur' => 5,
          'color' => 'rgba(0,0,0,1.0)'
        ]],
      ],

      'address_margin' => [
        'unit' => 'vw',
        'top' => 0,
        'right' => 0,
        'bottom' => 3,
        'left' => 0
      ],

      // ### CONTENT ###
      //TODO: fix this, it dosent work
      'content_hide' => [
        'desktop' => 'block',
        'tablet' => 'none',
        'mobile' => 'none',
      ],

      'content_padding' => [
        'isLinked' => false,
        'unit' => 'rem',
        'top' => 0,
        'right' => 3,
        'bottom' => 0,
        'left' => 3
      ],

      'content_typography' => [
        'typography' => ['default' => 'yes'],
        'font_weight' => ['default' => '400'],
        'font_family' => ['default' => 'Verdana'],
        'font_size' => [ 'default' => [ 'unit' => 'rem', 'size' => 0.85 ] ],
      ],

      'content_text_shadow' => [
        'text_shadow' => ['default' => [
          'horizontal' => 1,
          'vertical' => 1,
          'blur' => 1,
          'color' => 'rgba(0,0,0,1.0)'
        ]],
      ],

      // ### DISTANCE ###
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
        'text_shadow' => ['default' => [
          'horizontal' => 1,
          'vertical' => 1,
          'blur' => 0,
          'color' => 'rgba(0,0,0,1.0)'
        ]],
      ],


      // ### RATING ###
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
        'text_shadow' => ['default' => [
          'horizontal' => 1,
          'vertical' => 1,
          'blur' => 2,
          'color' => 'rgba(0,0,0,1.0)'
        ]],
      ],

    ];
  }
}
