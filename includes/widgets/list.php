<?php

namespace AkzentPointsOfInterest\Widgets;
defined('ABSPATH') || exit;

use AkzentPointsOfInterest\Models\PointOfInterest;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Plugin;
use Elementor\Widget_Base;


class PostList extends Widget_Base {


  public function __construct($data = [], $args = null) {
    parent::__construct($data, $args);
 }

 public function get_style_depends() {
  return [ 'akzent_post_list_widget_style' ];
 }

	public function get_name() {
    return 'List';
  }

	public function get_title() {
    return 'Post List';
  }

	public function get_icon() {
    return 'eicon-post-list';
  }

	public function get_custom_help_url() {
    return 'https://www.akzent.de';
  }

	public function get_categories() {
    return [ 'akzent-points-of-interest' ];
  }

  public function get_keywords() {
		return [ 'list', 'points of interest', 'akzent', 'poi', 'post' ];
	}

  protected function render() {
    $points_of_interest = PointOfInterest::all();
    foreach($points_of_interest as $point) {
      $image_url = get_the_post_thumbnail_url($point->ID);
      ?>
        <div class="akzent-post-list-card">
          <div class="akzent-post-flex">
            <div class="akzent-post-list-thumb">
              <?php echo get_the_post_thumbnail($point->ID) ?>
            </div>
            <div class="akzent-post-list-content">
              <h3 class='akzent-header'><?php echo $point->post_title ?></h3>
              <p><?php echo $point->post_content?></p>
            </div>
          </div>
          <div class="akzent-footer">
            <div class="akzent-post-flex akzent-justfiy-between">
              <small>Entfernung</small>
              <small>Bewertung</small>
            </div>
            <div class="akzent-post-flex akzent-justfiy-between">
              <small><?php echo $point->distance ?></small>
              <div><?php echo $this->star_rating_render($point->rating) ?></div>
            </div>
          </div>
        </div>
      <?
    }
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
