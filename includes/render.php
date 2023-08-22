<?php

namespace AkzentPointsOfInterest;
defined('ABSPATH') || exit;

class Render {

  public static function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
      $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
      return $html;
  }

  public function card_vertical($point) {
    //add_filter( 'post_thumbnail_html', [ get_called_class(), 'remove_thumbnail_dimensions' ], 10, 3 );
    if (!$point) { return; }
    $img_url  = get_the_post_thumbnail_url($point->ID);
    ?>
      <div class="card">
        <img class="card-img-top" style="height: 10vw; object-fit: cover;" src="<?php echo $img_url ?>" alt="<?php "Bild vom {$point->post_title}"?>">
        <div class="card-body">
          <div class="card-title akzent-point-of-interest-title" style="margin-bottom: 2rem">
            <div><?php echo $point->post_title ?></div>
            <div class="akzent-point-of-interest-address-line" style="font-size: 12px">
              <span><?php echo $point->street ?></span>
              <span><?php echo $point->city ?></span>
              <span><?php echo $point->zipcode ?></span>
            </div>
          </div>
          <div>
            <div>
              <span class="akzent-point-of-interest-distance-symbol" style="margin-right: 5px"><i class="eicon-map-pin"></i></span>
              <span class="akzent-point-of-interest-distance"><?php echo "{$point->distance} entfernt" ?></span>
            </div>
            <div>
              <span class="akzent-point-of-interest-rating-symbol" style="margin-right: 5px"><i class="eicon-rating"></i></span>
              <span class="akzent-point-of-interest-rating-stars"><?php echo $this->star_rating_render($point->rating) ?></span>
            </div>
          </div>
        </div>
        <div class="akzent-point-of-interest-footer card-footer" style="text-align:center">
          <small style="font-size: 1rem; color: white">Details</small>
        </div>
      </div>
    <?php
  }

  private function star_rating_render($rating) {
    $final_str = "";

    for ($i = 1; $i <= 5; $i++) {
      if ($rating >= 0.8) { $final_str .= "<small style='padding-top: 2px;' class='dashicons dashicons-star-filled'></small>"; }
      elseif ($rating >= 0.3) { $final_str .= "<small style='padding-top: 2px;' class='dashicons dashicons-star-half'></small>"; }
      else { $final_str .= "<small style='padding-top: 2px;' class='dashicons dashicons-star-empty'></small>"; }
      $rating = $rating - 1.0;
    }

    return $final_str;
  }
}
