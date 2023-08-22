<?php

namespace AkzentPointsOfInterest\Widgets;
defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use AkzentPointsOfInterest\Render;

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
    $a = $this->points_of_interest;

		?>
		<div id="AkzentCardGrid" class="row row-cols-1 row-cols-md-<?php echo $settings['card_grid_columns_tablet']?> row-cols-lg-<?php echo $settings['card_grid_columns_desktop']?> g-4">
      <?php foreach ( $this->points_of_interest as $point ) : ?>
        <div class="col">
          <?php $this->render->card_vertical($point); ?>
        </div>
      <?php endforeach; ?>
    </div>
		<?php
	}


}
