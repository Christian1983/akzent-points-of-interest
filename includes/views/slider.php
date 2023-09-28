<?php

namespace AkzentPointsOfInterest\Views;
defined('ABSPATH') || exit;

  /**
	 * BaseControl Class for creating Elementor widget controls based on the name
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array    $posts       Point of Interest custom post type array
	 * @param string   $image_size  Elementor Image Size
   * @param string   $max_height  The max height in px for the card (Based on smallest image, since akzent ignores all my warning about image sizes)
   *                              i mean, images with height: 4800 width: 960 should not be uploaded but if i validate them im the bad guy -.-
	 */
function slider($posts, $image_size, $max_height) {
  require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/views/image_card.php';
  $max_height = '400px';

  ?>
    <div class="akzent-point-of-interest-slider">
      <div class="swiper akzent-swiper">
        <div class="swiper-wrapper" style="margin-bottom: 1vh">
          <?php foreach($posts as $point ) : ?>
            <div class="swiper-slide">
              <?php image_card($point, $image_size, $max_height); ?>
            </div>
          <?php endforeach; ?>
        </div>


        <div class="swiper-button-prev"><i class="eicon-chevron-left"></i></div>
        <div class="swiper-button-next"><i class="eicon-chevron-right"></i></div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  <?
}
