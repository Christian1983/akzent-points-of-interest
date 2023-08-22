<?php

namespace AkzentPointsOfInterest\Widgets;
defined('ABSPATH') || exit;

use AkzentPointsOfInterest\Models\PointOfInterest;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Plugin;

class CardGrid extends Widget_Base {

  public function get_style_depends() {
    return [ 'akzent_base_layout_style' ];
   }
	public function get_name() {
    return 'Card Grid';
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

  protected function register_controls() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => 'Layout',
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'card_grid_columns_tablet',
			[
				'label' => 'Spalten Tablet',
				'type' => Controls_Manager::SELECT,
				'default' => 2,
				'options' => [
          '1' => 1,
          '2' => 2,
          '3' => 3,
          '4' => 4,
          '5' => 6,
          '6' => 7,
				],
			]
		);

		$this->add_control(
			'card_grid_columns_desktop',
			[
				'label' => 'Spalten desktop',
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 3,
				'options' => [
          '1' => 1,
          '2' => 2,
          '3' => 3,
          '4' => 4,
          '5' => 6,
          '6' => 7,
				],
			]
		);

		$this->end_controls_section();


    $this->start_controls_section(
			'section_typography_color',
			[
				'label' => 'Farben',
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

    $this->add_control(
      'text_color_title',
      [
        'label' => 'Titel',
				'type' => Controls_Manager::COLOR,
        'default' => '#777',
				'selectors' => [
					'{{WRAPPER}} .akzent-point-of-interest-title' => 'color: {{VALUE}}',
				],
      ]
    );

    $this->add_control(
      'text_color_adress',
      [
        'label' => 'Adresse',
				'type' => Controls_Manager::COLOR,
        'default' => '#777',
				'selectors' => [
					'{{WRAPPER}} .akzent-point-of-interest-address-line' => 'color: {{VALUE}}',
				],
      ]
    );

    $this->add_control(
      'text_color_distance_symbol',
      [
        'label' => 'Entfernung',
				'type' => Controls_Manager::COLOR,
        'default' => '#777',
				'selectors' => [
					'{{WRAPPER}} .akzent-point-of-interest-distance-symbol' => 'color: {{VALUE}}',
				],
      ]
    );

    $this->add_control(
      'text_color_distance',
      [
        'label' => 'Entfernung',
				'type' => Controls_Manager::COLOR,
        'default' => '#777',
				'selectors' => [
					'{{WRAPPER}} .akzent-point-of-interest-distance' => 'color: {{VALUE}}',
				],
      ]
    );

    $this->add_control(
      'text_color_rating_symbol',
      [
        'label' => 'Bewertungs Indikator',
				'type' => Controls_Manager::COLOR,
        'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .akzent-point-of-interest-rating-symbol' => 'color: {{VALUE}}',
				],
      ]
    );

    $this->add_control(
      'text_color_ratings_stars',
      [
        'label' => 'Bewertungssymbole',
				'type' => Controls_Manager::COLOR,
        'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .akzent-point-of-interest-rating-stars' => 'color: {{VALUE}}',
				],
      ]
    );

    $this->add_control(
      'text_color_footer',
      [
        'label' => 'Footer',
				'type' => Controls_Manager::COLOR,
        'default' => '#4b68c9',
				'selectors' => [
					'{{WRAPPER}} .akzent-point-of-interest-footer' => 'background: {{VALUE}}',
				],
      ]
    );

    $this->end_controls_section();

	}

  protected function render() {
    $settings = $this->get_settings_for_display();
    $points_of_interest = PointOfInterest::all();
		?>
		<div id="AkzentCardGrid" class="row row-cols-1 row-cols-md-<?php echo $settings['card_grid_columns_tablet']?> row-cols-lg-<?php echo $settings['card_grid_columns_desktop']?> g-4">
      <?php foreach ( $points_of_interest as $index => $point ) : ?>
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
