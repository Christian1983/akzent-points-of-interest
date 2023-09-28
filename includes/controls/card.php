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
    return $this->defaults_base();
  }

  private function defaults_medium() {
    return $this->defaults_base();
  }

  private function defaults_small() {
    return $this->defaults_base();
  }

  private function defaults_base() {
    return [
    ];
  }
}
