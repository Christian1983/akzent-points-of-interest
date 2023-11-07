<?php

namespace AkzentPointsOfInterest;
defined('ABSPATH') || exit;
class Shortcodes {

  private static function get_smallest_image_size($points_of_interest, $image_size) {
		$height = 65536;
		foreach($points_of_interest as $point) {
			$img_data = wp_get_attachment_image_src( get_post_thumbnail_id( $point->ID ), $image_size );
			if ($height > $img_data[2] ) { $height = $img_data[2]; }
		}

		return $height;
	}

	public static function grid() {
    $points_of_interest = Models\PointOfInterest::all();
    $max_height = self::get_smallest_image_size($points_of_interest, 'large');

		self::register_styles();
		self::register_scripts();
		require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/views/image_card_grid.php';
		\AkzentPointsOfInterest\Views\ImageCardGridView::render($points_of_interest, 'large', $max_height);
  }

  public static function slider() {
    $points_of_interest = Models\PointOfInterest::all();
    $max_height = self::get_smallest_image_size($points_of_interest, 'large');

		self::register_styles();
		self::register_scripts();
		require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/views/slider.php';
		\AkzentPointsOfInterest\Views\ImageCardSliderView::render($points_of_interest, 'large', $max_height);
  }

	public static function register_styles() {
    wp_register_style('akzent_swiper_style', plugins_url('assets/lib/swiper/css/swiper.min.css', AKZENT_POINTS_OF_INTEREST_FILE) );
    wp_register_style('akzent_bootstrap_style', plugins_url('assets/lib/bootstrap/bootstrap5.min.css', AKZENT_POINTS_OF_INTEREST_FILE) );
    wp_register_style('akzent_main_style', plugins_url('assets/css/main.css', AKZENT_POINTS_OF_INTEREST_FILE) );
    wp_register_style('akzent_image_card_style', plugins_url('assets/css/image_card.css', AKZENT_POINTS_OF_INTEREST_FILE));
    wp_register_style('akzent_slider_style', plugins_url('assets/css/slider.css', AKZENT_POINTS_OF_INTEREST_FILE));
    wp_register_style('akzent_grid_style', plugins_url('assets/css/grid.css', AKZENT_POINTS_OF_INTEREST_FILE));
  }

  public static function register_scripts() {
    wp_register_script('akzent_slider_widget_swiper_script', plugins_url('assets/lib/swiper/swiper.min.js', AKZENT_POINTS_OF_INTEREST_FILE) );
    wp_register_script('akzent_slider_widget_initialization_script', plugins_url('assets/js/slider.js', AKZENT_POINTS_OF_INTEREST_FILE));
  }
}
