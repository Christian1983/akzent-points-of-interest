<?php

namespace AkzentPointsOfInterest\Widgets;
defined('ABSPATH') || exit;

use AkzentPointsOfInterest\Controls\SliderControl;

class Slider extends WidgetBase {

	public function get_style_depends() {
		return [ 'akzent_slider_widget_style', 'akzent_main_style' ];
	 }

	 public function get_script_depends() {
		return [ 'akzent_slider_widget_swiper_script', 'akzent_slider_widget_initialization_script' ];
	 }

	 public function register_controls() {
		$controls = new SliderControl(array('name' => 'Slider', 'element' => $this));
	 }

	public function get_name() {
    return 'Slider';
  }

	public function get_title() {
    return 'Image Carousel';
  }

	public function get_icon() {
    return 'eicon-carousel';
  }

	public function get_custom_help_url() {
    return 'https://www.akzent.de';
  }

	public function get_categories() {
    return [ 'akzent-points-of-interest' ];
  }

  public function get_keywords() {
		return [ 'slider', 'carousel', 'points of interest', 'akzent', 'poi', 'post' ];
	}

	protected function render() {
    $settings = $this->get_settings_for_display();
    $this->get_points_of_interest_for_settings($settings);


		?>
			<div class="swiper">
				<div class="swiper-wrapper">
					<?php foreach($this->points_of_interest as $point ) : ?>
						<div class="swiper-slide">
							<?php $this->render->card_image($point, $settings['card_image_size']); ?>
						</div>
					<?php endforeach; ?>
				</div>


				<div class="swiper-button-prev"><i class="eicon-chevron-left"></i></div>
				<div class="swiper-button-next"><i class="eicon-chevron-right"></i></div>
				<div class="swiper-pagination"></div>
				<!-- If we need scrollbar -->
				<div class="swiper-scrollbar"></div>
			</div>
		<?
	}

}
