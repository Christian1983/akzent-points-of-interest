<?php

namespace AkzentPointsOfInterest\Widgets;

class Base extends \Elementor\Widget_Base {
	public function get_name() {
    return 'AKZENT Reiseinspirationen';
  }

	public function get_title() {
    return 'Reiseinspirationen';
  }

	public function get_icon() {
    return 'eicon-star';
  }

	public function get_custom_help_url() {
    return 'https://www.akzent.de';
  }

	public function get_categories() {
    return [ 'akzent-points-of-interest' ];
  }

  public function get_keywords() {
		return [ 'keyword', 'keyword' ];
	}

  protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'list',
			[
				'label' => esc_html__( 'List', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'text',
						'label' => esc_html__( 'Text', 'textdomain' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => esc_html__( 'List Item', 'textdomain' ),
						'default' => esc_html__( 'List Item', 'textdomain' ),
					],
					[
						'name' => 'link',
						'label' => esc_html__( 'Link', 'textdomain' ),
						'type' => \Elementor\Controls_Manager::URL,
						'placeholder' => esc_html__( 'https://your-link.com', 'textdomain' ),
					],
				],
				'default' => [
					[
						'text' => esc_html__( 'List Item #1', 'textdomain' ),
						'link' => 'https://elementor.com/',
					],
					[
						'text' => esc_html__( 'List Item #2', 'textdomain' ),
						'link' => 'https://elementor.com/',
					],
				],
				'title_field' => '{{{ text }}}',
			]
		);

		$this->end_controls_section();

	}

  protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<ul>
		<?php foreach ( $settings['list'] as $index => $item ) : ?>
			<li>
				<?php
				if ( ! $item['link']['url'] ) {
					echo $item['text'];
				} else {
					?><a href="<?php echo esc_url( $item['link']['url'] ); ?>"><?php echo $item['text']; ?></a><?php
				}
				?>
			</li>
		<?php endforeach; ?>
		</ul>
		<?php
	}

	protected function content_template() {
		?>
		<ul>
		<#
		if ( settings.list ) {
			_.each( settings.list, function( item, index ) {
			#>
			<li>
				<# if ( item.link && item.link.url ) { #>
					<a href="{{{ item.link.url }}}">{{{ item.text }}}</a>
				<# } else { #>
					{{{ item.text }}}
				<# } #>
			</li>
			<#
			} );
		}
		#>
		</ul>
		<?php
	}


}
