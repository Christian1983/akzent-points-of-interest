<?php

namespace AkzentPointsOfInterest\Controls;
defined('ABSPATH') || exit;


// i want a constructable class thats gives me sections for its name
// with default controls eg.: size, color, align etc.
abstract class BaseControl {

  public $name;
  public $element;
  public $selector;
  public $defaults = [];
  public $section_name;

  /**
	 * BaseControl Class for creating Elementor widget controls based on the name
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param object   $element     The WidgetBase Object to wich we want to add controls
	 * @param array    $selector    The css class selector
   * @param array    $defaults    The defaults for various values, eg.: defaults['title_color' => '#FFF']
	 */
  function __construct($name, $element, $selector=null, $defaults=[]) {
    $this->name         = $name;
    $this->element      = $element;
    $this->selector     = $selector;
    $this->defaults     = array_merge($this->defaults, $defaults);
    $this->section_name = 'section_' . $this->element->get_name();
    $this->create();
  }

  abstract protected function create();
}
