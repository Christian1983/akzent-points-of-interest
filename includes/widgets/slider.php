<?php

namespace AkzentPointsOfInterest\Widgets;
defined('ABSPATH') || exit;

class Slider extends WidgetBase {

	public function get_style_depends() {
		return [ 'akzent_slider_widget_style' ];
	 }

	 public function get_script_depends() {
		return [ 'akzent_slider_widget_swiper_script', 'akzent_slider_widget_script' ];
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
		$points_of_interest = PointOfInterest::all();
		?>
			<div class="swiper">
				<!-- Additional required wrapper -->
				<div class="swiper-wrapper">
					<!-- Slides -->
					<?php
						foreach($points_of_interest as $point) {
							$image_url = get_the_post_thumbnail_url($point->ID);
							?>
							<div class="swiper-slide" style="height: 480px">
								<div class="akzent-slider-card" style="position: relative;">
									<div class="akzent-slider-card-header" style="position: absolute; top: 0; left: 0; z-index: 10; width: 100%; height: 100%;">
										<div style="display: flex; align-items: center; height: 100%; ">
										<div style="width: 100%; text-align: center;">
											<h3 style="color: #f2f2f2; text-shadow: 1px 1px black "><?php echo $point->post_title ?></h3>
											<div style="background: rgba(0,0,0,0.45); padding: 15px; color: white; text-shadow: 1px 1px black">
												<div style="display: flex; justify-content: space-between">
													<small>Entfernung</small>
													<small>Bewertung</small>
												</div>
												<div style="display: flex; justify-content: space-between">
													<small><?php echo $point->distance ?></small>
													<div><?php echo $this->star_rating_render($point->rating) ?></div>
												</div>
											</div>
										</div>
										</div>
									</div>

									<div class="akzent-slider-card-image-container" style="height: 460px">
										<img src="<? echo $image_url ?>" alt="">
									</div>
								</div>
							</div>
					<?php } ?>
				</div>
				<!-- If we need pagination -->
				<div class="swiper-pagination"></div>

				<!-- If we need navigation buttons -->
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>

				<!-- If we need scrollbar -->
				<!-- <div class="swiper-scrollbar"></div> -->
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
