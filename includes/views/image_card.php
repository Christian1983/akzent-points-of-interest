<?php

namespace AkzentPointsOfInterest\Views;

defined('ABSPATH') || exit;

class ImageCardView {

  /**
   * BaseControl Class for creating Elementor widget controls based on the name
   *
   * @since 1.0.0
   * @access public
   *
   * @param object   $point       Point of Interest custom post type
   * @param string   $image_size  Elementor Image Size
   * @param integer  $max_height  The max height in px for the card
   */
  static function render($point, $image_size, $max_height=0) {
    if (!$point) {
      return;
    }

    $img_html = get_the_post_thumbnail($point->ID, $image_size, array('class' => 'card-img-top'));

    ?>
    <div class="akzent-point-of-interest-image-card" style="height: <?php echo $max_height > 0 ? $max_height . 'px' : 'unset'; ?>">
      <div class="akzent-point-of-interest-image-wrapper">
        <?php echo $img_html ?>
      </div>
      <div class="akzent-point-of-interest-image-card-inner">
        <div class="akzent-point-of-interest-title-wrapper akzent-w100">
          <div class="akzent-point-of-interest-title">
            <?php echo $point->post_title ?>
          </div>
        </div>

          <div class="akzent-point-of-interest-address-wrapper akzent-w100">
            <div class="akzent-point-of-interest-address-line">
              <span> <?php echo $point->zipcode ?> </span>
              <span> <?php echo $point->city ?> </span>
              <span> <?php echo $point->street ?> </span>
            </div>
          </div>

          <div class="akzent-point-of-interest-content-wrapper akzent-w100">
            <div class="akzent-point-of-interest-content">
              <?php echo $point->post_content ?>
            </div>
          </div>

          <div class="akzent-point-of-interest-image-card-footer akzent-w100">
            <div class="bottom-footer">
              <div class="akzent-point-of-interest-distance-wrapper">
                <span class="akzent-point-of-interest-distance"><?php echo $point->distancew ?> entfernt</span>
              </div>

              <div class="akzent-point-of-interest-rating-wrapper">
                <span class="akzent-point-of-interest-rating"><?php echo self::star_rating_render($point->rating) ?></span>
              </div>
            </div>

            <?php if ($point->user != ''): ?>
              <div class="copyright-footer-note akzent-w100">
                <small class="akzent-w100">Copyright © <?php echo $point->user;?></small>
              </div>
            <?php endif; ?>
          </div>

      </div>
    </div>
    <?php
  }

  static function star_rating_render($rating) {
    $final_str = "";

    for ($i = 1; $i <= 5; $i++) {
      if ($rating >= 0.8) {
        $final_str .= "<small style='padding-top: 2px;' class='dashicons dashicons-star-filled'></small>";
      } elseif ($rating >= 0.3) {
        $final_str .= "<small style='padding-top: 2px;' class='dashicons dashicons-star-half'></small>";
      } else {
        $final_str .= "<small style='padding-top: 2px;' class='dashicons dashicons-star-empty'></small>";
      }
      $rating = $rating - 1.0;
    }

    return $final_str;
  }
}

