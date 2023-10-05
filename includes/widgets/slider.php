<?php

namespace AkzentPointsOfInterest\Widgets;
defined('ABSPATH') || exit;

use AkzentPointsOfInterest\Controls\SliderControl;

class Slider extends WidgetBase {

	public function get_style_depends() {
		return [ 'akzent_main_style', 'akzent_swiper_style', 'akzent_image_card_style', 'akzent_slider_style' ];
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
    return 'Image Card Slider';
  }

	public function get_icon() {
    return 'eicon-post-slider';
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

	private function get_smallest_image_size($image_size) {
		$height = 65536;
		foreach($this->points_of_interest as $point) {
			$img_data = wp_get_attachment_image_src( get_post_thumbnail_id( $point->ID ), $image_size );
			if ($height > $img_data[2] ) { $height = $img_data[2]; }
		}

		return $height;
	}
	protected function render() {
    $settings = $this->get_settings_for_display();
    $this->get_points_of_interest_for_settings($settings);
		$max_height = $this->get_smallest_image_size($settings['thumbnail_size']);
		require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/views/slider.php';
		\AkzentPointsOfInterest\Views\ImageCardSliderView::render($this->points_of_interest, $settings['thumbnail_size'], $max_height);
	}

}
