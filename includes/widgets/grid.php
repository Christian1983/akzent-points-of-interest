<?php

namespace AkzentPointsOfInterest\Widgets;
defined('ABSPATH') || exit;

use AkzentPointsOfInterest\Controls\GridControl;
class Grid extends WidgetBase {

	public function get_style_depends() {
		return [ 'akzent_bootstrap_style', 'akzent_main_style', 'akzent_image_card_style', 'akzent_grid_style' ];
	 }

	 public function register_controls() {
		$controls = new GridControl(array('name' => 'Slider', 'element' => $this));
	 }

	public function get_name() {
    return 'Grid';
  }

	public function get_title() {
    return 'Image Card Grid';
  }

	public function get_icon() {
    return 'eicon-posts-grid';
  }

	public function get_custom_help_url() {
    return 'https://www.akzent.de';
  }

	public function get_categories() {
    return [ 'akzent-points-of-interest' ];
  }

  public function get_keywords() {
		return [ 'grid', 'cards', 'point of interest', 'points of interest', 'akzent', 'poi', 'post' ];
	}

	protected function render() {
    $settings = $this->get_settings_for_display();
    $this->get_points_of_interest_for_settings($settings);
		require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/views/image_card_grid.php';
		\AkzentPointsOfInterest\Views\ImageCardGridView::render($this->points_of_interest, $settings['thumbnail_size']);
	}

}
