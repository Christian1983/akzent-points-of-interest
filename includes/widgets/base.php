<?php

namespace AkzentPointsOfInterest\Widgets;
defined('ABSPATH') || exit;

use AkzentPointsOfInterest\Models\PointOfInterest;
use AkzentPointsOfInterest\Render;
use Elementor\Controls_Manager;

abstract class WidgetBase extends \Elementor\Widget_Base {

	public $points_of_interest;

	public $render;

  protected function register_controls() {

		$this->start_controls_section(
			'section_data',
			[
				'label' => 'Daten',
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'akzent_sort_field',
			[
				'label' => 'Sortieren nach',
				'type' => Controls_Manager::SELECT,
				'default' => 'post_title',
				'options' => [
          'post_title' => 'Name',
          'rating' => 'Bewertungen',
					'number_of_ratings' => 'anzahl Bewertungen',
          'distance' => 'Entfernung',
				],
			]
		);

		// wird an $orderDesc (boolean) übergeben
		$this->add_control(
			'akzent_sort_direction',
			[
				'label' => 'Sortier Reihenfolge',
				'type' => Controls_Manager::SELECT,
				'default' => false,
				'options' => [
					0 => 'Aufsteigend',
					1 => 'Absteigend',
				],
			]
		);

		$this->end_controls_section();

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

    $this->end_controls_section();
	}

	public function get_points_of_interest_for_settings($settings) {
		$this->render = new Render();
		$this->points_of_interest = PointOfInterest::filter($settings['akzent_sort_field'], $settings['akzent_sort_direction']);
	}


}
