<?php

namespace AkzentPointsOfInterest\Controls;
defined('ABSPATH') || exit;

class SliderBaseControl extends BaseControl {
  public function create() {
    new DataControl(array('name' => 'Slider', 'element' => $this->element));
		$this->element->start_controls_section(
			'image_section',
			[
				'label' => 'Bildgröße',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->element->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude' => [ 'custom' ],
				'include' => [],
				'default' => 'large',
			]
		);

    $this->element->end_controls_section();
  }

}
