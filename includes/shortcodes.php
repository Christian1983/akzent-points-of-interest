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

		require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/views/image_card_grid.php';
		\AkzentPointsOfInterest\Views\ImageCardGridView::render($points_of_interest, 'large', $max_height);
  }

  public static function slider() {
    $points_of_interest = Models\PointOfInterest::all();
    $max_height = self::get_smallest_image_size($points_of_interest, 'large');

		require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/views/slider.php';
		\AkzentPointsOfInterest\Views\ImageCardSliderView::render($points_of_interest, 'large', $max_height);
  }
}
