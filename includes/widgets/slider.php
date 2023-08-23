<?php

namespace AkzentPointsOfInterest\Widgets;
defined('ABSPATH') || exit;

class Slider extends WidgetBase {

	public function get_style_depends() {
		return [ 'akzent_slider_widget_style', 'akzent_main_style' ];
	 }

	 public function get_script_depends() {
		return [ 'akzent_slider_widget_swiper_script', 'akzent_slider_widget_initialization_script' ];
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
		$slides = array_chunk($this->points_of_interest, $settings['card_grid_columns_tablet'])


		?>
			<div class="swiper">
				<div class="swiper-wrapper">
					<?php foreach($slides as $points) : ?>
						<div class="swiper-slide" style="display: flex; justify-content: space-between">
							<?php foreach($points as $point ) : ?>
								<?php $this->render->card_image($point, $settings['card_image_size']); ?>
							<?php endforeach; ?>
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

	private function star_rating_render($rating) {
    $final_str = "<small style='padding-right: 5px'>". round($rating, 1) ."</small>";

    for ($i = 1; $i <= 5; $i++) {
      if ($rating >= 0.8) { $final_str .= "<small style='padding-top: 2px;' class='dashicons dashicons-star-filled'></small>"; }
      elseif ($rating >= 0.3) { $final_str .= "<small style='padding-top: 2px;' class='dashicons dashicons-star-half'></small>"; }
      else { $final_str .= "<small style='padding-top: 2px;' class='dashicons dashicons-star-empty'></small>"; }
      $rating = $rating - 1.0;
    }

    return $final_str;
  }

}
