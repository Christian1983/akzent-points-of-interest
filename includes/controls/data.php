<?php

namespace AkzentPointsOfInterest\Controls;
defined('ABSPATH') || exit;

use function AkzentPointsOfInterest\Helper\to_snake_case;
use Elementor\Controls_Manager;
class DataControl extends BaseControl {

  public function create() {
		$this->element->start_controls_section(
			$this->section_name,
			[
				'label' => 'Daten',
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$control_id  = to_snake_case($this->name) . '_sort';
		$this->element->add_control(
			'sort_field',
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

		$control_id  = to_snake_case($this->name) . '_sort_direction';
		// wird an $orderDesc (boolean) übergeben
		$this->element->add_control(
			'sort_direction',
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

		$this->element->end_controls_section();
  }
}
