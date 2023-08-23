<?php

namespace AkzentPointsOfInterest\Widgets;
defined('ABSPATH') || exit;

use AkzentPointsOfInterest\Models\PointOfInterest;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Plugin;
use Elementor\Widget_Base;


class PostList extends Widget_Base {

  public function __construct($data = [], $args = null) {
    parent::__construct($data, $args);
 }

 public function get_style_depends() {
  return [ 'akzent_base_layout_style', 'akzent_post_list_widget_style' ];
 }

	public function get_name() {
    return 'List';
  }

	public function get_title() {
    return 'Post List';
  }

	public function get_icon() {
    return 'eicon-post-list';
  }

	public function get_custom_help_url() {
    return 'https://www.akzent.de';
  }

	public function get_categories() {
    return [ 'akzent-points-of-interest' ];
  }

  public function get_keywords() {
		return [ 'list', 'points of interest', 'akzent', 'poi', 'post' ];
	}

  protected function render() {
    $points_of_interest = PointOfInterest::all();
    foreach($points_of_interest as $point) {
    }
  }

}
