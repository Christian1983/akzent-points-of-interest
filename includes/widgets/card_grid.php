<?php

namespace AkzentPointsOfInterest\Widgets;
defined('ABSPATH') || exit;

use AkzentPointsOfInterest\Models\PointOfInterest;
use AkzentPointsOfInterest\Widgets\WidgetBase;
use Elementor\Controls_Manager;


class CardGrid extends WidgetBase {

  private $controls_injected = false;

  public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );
    //add_action( 'elementor/element/akzent-points-of-interest-card-grid/section_typography_color/after_section_end', [$this, 'inject_custom_controls'], 10, 3 );

  }

  public function inject_custom_controls($element, $args ) {

    $element->start_controls_section(
			'section_footer',
			[
				'label' => 'Footer',
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

    $element->add_control(
      'background_color_footer',
      [
        'label' => 'Hintergrund',
        'type' => Controls_Manager::COLOR,
        'default' => '#4b68c9',
        'selectors' => [
          '{{WRAPPER}} .akzent-point-of-interest-footer' => 'background: {{VALUE}}',
        ],
      ]
    );

    $element->add_control(
      'text_color_footer',
      [
        'label' => 'Text',
        'type' => Controls_Manager::COLOR,
        'default' => '#FFF',
        'selectors' => [
          '{{WRAPPER}} .akzent-point-of-interest-footer' => 'color: {{VALUE}}',
        ],
      ]
    );

    $element->end_controls_section();

  }

  public function get_style_depends() {
    return [ 'akzent_base_layout_style' ];
   }
	public function get_name() {
    return 'akzent-points-of-interest-card-grid';
  }

	public function get_title() {
    return 'Card Grid';
  }

	public function get_icon() {
    return 'eicon-gallery-grid';
  }

	public function get_custom_help_url() {
    return 'https://www.akzent.de';
  }

	public function get_categories() {
    return [ 'akzent-points-of-interest' ];
  }

  public function get_keywords() {
		return [ 'image', 'photo', 'visual', 'grid', 'card', 'post', 'akzent' ];
	}

  protected function render() {
    $settings = $this->get_settings_for_display();
    $this->get_points_of_interest_for_settings($settings);

		?>
		<div id="AkzentCardGrid" class="row row-cols-1 row-cols-md-<?php echo $settings['card_grid_columns_tablet']?> row-cols-lg-<?php echo $settings['card_grid_columns_desktop']?> g-4">
      <?php foreach ( $this->points_of_interest as $index => $point ) : ?>
        <div class="col">
          <?php echo $this->card_template($point); ?>
        </div>
      <?php endforeach; ?>
    </div>
		<?php
	}

  protected function card_template($point) {
    $img_html = get_the_post_thumbnail($point->ID);
    $img_url  = get_the_post_thumbnail_url($point->ID);
    ?>
      <div class="card">
        <img class="card-img-top" style="height: 10vw; object-fit: cover;" src="<?php echo $img_url ?>" alt="">
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
              <span class="akzent-point-of-interest-rating-stars"><?php echo "{$this->star_rating_render($point->rating)}" ?></span>
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
