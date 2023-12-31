<?php

namespace AkzentPointsOfInterest\Controls;
defined('ABSPATH') || exit;


// i want a constructable class thats gives me sections for its name
// with default controls eg.: size, color, align etc.
abstract class BaseControl {

  public $name;
  public $element;
  public $selector;
  public $wrapper;

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
  function __construct($args = []) {
    $this->name         = isset($args['name']) ? $args['name'] : get_called_class();
    $this->section_name = "{$this->name}_section";
    $this->element      = $args['element'];
    $this->selector     = isset($args['selector']) ? ".{$args['selector']}" : '';
    $this->wrapper      = "{$this->selector}-wrapper";
    $this->defaults     = array_merge($this->defaults, isset($args['defaults']) ? $args['defaults'] : []);
    $this->create();
  }

  abstract protected function create();
}
