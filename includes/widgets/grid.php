<?php

namespace AkzentPointsOfInterest\Widgets;
defined('ABSPATH') || exit;

use AkzentPointsOfInterest\Controls\GridControl;
class Grid extends WidgetBase {

	public function get_style_depends() {
		return [ 'akzent_bootstrap_style', 'akzent_main_style' ];
	 }

	 public function register_controls() {
		$controls = new GridControl(array('name' => 'Slider', 'element' => $this));
	 }

	public function get_name() {
    return 'Grid';
  }

	public function get_title() {
    return 'Gridl';
  }

	public function get_icon() {
    return 'eicon-grid';
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

		?>
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g4">
        <?php foreach($this->points_of_interest as $point ) : ?>
          <div class="col" style="margin-bottom: 25px">
            <?php $this->render->card_image($point, $settings['thumbnail_size']); ?>
          </div>
        <?php endforeach; ?>
      </div>
		<?
	}

}
