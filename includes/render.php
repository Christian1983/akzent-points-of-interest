<?php

namespace AkzentPointsOfInterest;
defined('ABSPATH') || exit;

class Render {

  private $post_id;
  private $thumb_id;
  public function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    if ($this->post_id == $post_id) {
      $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
      return $html;
    }
  }
  public function card_vertical($point, $image_size='thumbnail') {
    if (!$point) { return; }

    $this->post_id  = $point->ID;
    $this->thumb_id = get_post_thumbnail_id($point->ID);

    add_filter( 'post_thumbnail_html', [ $this, 'remove_thumbnail_dimensions' ], 10, 3 );
    $img_html = get_the_post_thumbnail($this->post_id, $image_size, array('class' => 'card-img-top'));

    ?>
      <div class="card akzent-point-of-interest-card">
        <?php echo $img_html ?>
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
              <span class="akzent-point-of-interest-distance"><?php echo "{$point->distancew} entfernt" ?></span>
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

  public function card_horizontal($point, $image_size='thumbnail') {
    if (!$point) { return; }

    $this->post_id  = $point->ID;
    $this->thumb_id = get_post_thumbnail_id($point->ID);

    add_filter( 'post_thumbnail_html', [ $this, 'remove_thumbnail_dimensions' ], 10, 3 );
    $img_html = get_the_post_thumbnail($this->post_id, $image_size, array('class' => 'card-img-top'));

    ?>
      <div class="card akzent-point-of-interest-card">
        <?php echo $img_html ?>
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
              <span class="akzent-point-of-interest-distance-symbol float-left" style="margin-right: 5px"><i class="eicon-map-pin"></i></span>
              <span class="akzent-point-of-interest-distance"><?php echo "{$point->distancew} entfernt" ?></span>
            </div>
            <div>
              <span class="akzent-point-of-interest-rating-symbol float-left" style="margin-right: 5px"><i class="eicon-rating"></i></span>
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



  public function card_image($point, $image_size="large") {
    if (!$point) { return; }

    $this->post_id  = $point->ID;
    $this->thumb_id = get_post_thumbnail_id($point->ID);

    add_filter( 'post_thumbnail_html', [ $this, 'remove_thumbnail_dimensions' ], 10, 3 );
    $img_html = get_the_post_thumbnail($this->post_id, $image_size, array('class' => 'card-img-top'));

    ?>
      <div class="card akzent-point-of-interest-image-card">
        <div style="position: relative; height: 100%; width: 100%;">
          <?php echo $img_html ?>
          <div class='floating-body' style='display: flex; flex-wrap: wrap; flex-direction: column; justify-content: center; align-items: center; position: absolute; top:0; left: 0; width: 100%; height: 100%'>
            <div class="akzent-point-of-interest-title">
              <?php echo $point->post_title ?>
            </div>
            <div class="akzent-point-of-interest-address-line">
                <span><?php echo $point->street ?></span>
                <span><?php echo $point->city ?></span>
                <span><?php echo $point->zipcode ?></span>
            </div>
            <div class="akzent-point-of-interest-content" style="margin-top: 1rem; padding: 15px">
              <?php echo $point->post_content ?>
            </div>

            <div style="position: absolute; bottom: 0; display: flex; justify-content:space-between; width: 100%; padding: 15px">
              <div>
                <span class="akzent-point-of-interest-distance-symbol" style="margin-right: 5px"><i class="eicon-map-pin"></i></span>
                <span class="akzent-point-of-interest-distance"><?php echo "{$point->distancew} entfernt" ?></span>
              </div>
              <div>
                <span class="akzent-point-of-interest-rating-symbol" style="margin-right: 5px"><i class="eicon-rating"></i></span>
                <span class="akzent-point-of-interest-rating-stars"><?php echo $this->star_rating_render($point->rating) ?></span>
              </div>
            </div>
          </div>
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
