<?php

namespace AkzentPointsOfInterest\Widgets;

use AkzentPointsOfInterest\Models\PointOfInterest;

class Slider extends \Elementor\Widget_Image_Gallery {
  public function get_name() {
    return 'Image Slider';
  }

	public function get_title() {
    return 'Image Slider';
  }
	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
    return [ 'akzent-points-of-interest' ];
  }

  protected function render() {
		$settings = $this->get_settings_for_display();
		$lazyload = false;

		if ( empty( $settings['carousel'] ) ) {
			return;
		}

		$slides = [];

		foreach ( $settings['carousel'] as $index => $attachment ) {
			$image_url = Group_Control_Image_Size::get_attachment_image_src( $attachment['id'], 'thumbnail', $settings );

			if ( ! $image_url && isset( $attachment['url'] ) ) {
				$image_url = $attachment['url'];
			}

			if ( $lazyload ) {
				$image_html = '<img class="swiper-slide-image swiper-lazy" data-src="' . esc_attr( $image_url ) . '" alt="' . esc_attr( Control_Media::get_image_alt( $attachment ) ) . '" />';
			} else {
				$image_html = '<img class="swiper-slide-image" src="' . esc_attr( $image_url ) . '" alt="' . esc_attr( Control_Media::get_image_alt( $attachment ) ) . '" />';
			}

			$link_tag = '';

			$link = $this->get_link_url( $attachment, $settings );

			if ( $link ) {
				$link_key = 'link_' . $index;

				$this->add_lightbox_data_attributes( $link_key, $attachment['id'], $settings['open_lightbox'], $this->get_id() );

				if ( Plugin::$instance->editor->is_edit_mode() ) {
					$this->add_render_attribute( $link_key, [
						'class' => 'elementor-clickable',
					] );
				}

				$this->add_link_attributes( $link_key, $link );

				$link_tag = '<a ' . $this->get_render_attribute_string( $link_key ) . '>';
			}

			$image_caption = $this->get_image_caption( $attachment );

			$slide_count = $index + 1;
			$slide_setting_key = 'swiper_slide_' . $index;

			$this->add_render_attribute( $slide_setting_key, [
				'class' => 'swiper-slide',
				'role' => 'group',
				'aria-roledescription' => 'slide',
				'aria-label' => sprintf(
					/* translators: 1: Slide count, 2: Total slides count. */
					esc_html__( '%1$s of %2$s', 'elementor' ),
					$slide_count,
					count( $settings['carousel'] )
				),
			] );

			$slide_html = '<div ' . $this->get_render_attribute_string( $slide_setting_key ) . '>' . $link_tag . '<figure class="swiper-slide-inner">' . $image_html;

			if ( $lazyload ) {
				$slide_html .= '<div class="swiper-lazy-preloader"></div>';
			}

			if ( ! empty( $image_caption ) ) {
				$slide_html .= '<figcaption class="elementor-image-carousel-caption">' . wp_kses_post( $image_caption ) . '</figcaption>';
			}

			$slide_html .= '</figure>';

			if ( $link ) {
				$slide_html .= '</a>';
			}

			$slide_html .= '</div>';

			$slides[] = $slide_html;

		}

		if ( empty( $slides ) ) {
			return;
		}

		$swiper_class = Plugin::$instance->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';
		$has_autoplay_enabled = 'yes' === $this->get_settings_for_display( 'autoplay' );

		$this->add_render_attribute( [
			'carousel' => [
				'class' => 'elementor-image-carousel swiper-wrapper',
				'aria-live' => $has_autoplay_enabled ? 'off' : 'polite',
			],
			'carousel-wrapper' => [
				'class' => 'elementor-image-carousel-wrapper ' . $swiper_class,
				'dir' => $settings['direction'],
			],
		] );

		$show_dots = ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) );
		$show_arrows = ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) );

		if ( 'yes' === $settings['image_stretch'] ) {
			$this->add_render_attribute( 'carousel', 'class', 'swiper-image-stretch' );
		}

		$slides_count = count( $settings['carousel'] );
		?>
		<div <?php $this->print_render_attribute_string( 'carousel-wrapper' ); ?>>
			<div <?php $this->print_render_attribute_string( 'carousel' ); ?>>
				<?php // PHPCS - $slides contains the slides content, all the relevent content is escaped above. ?>
				<?php echo implode( '', $slides ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<?php if ( 1 < $slides_count ) : ?>
				<?php if ( $show_arrows ) : ?>
					<div class="elementor-swiper-button elementor-swiper-button-prev" role="button" tabindex="0">
						<?php $this->render_swiper_button( 'previous' ); ?>
					</div>
					<div class="elementor-swiper-button elementor-swiper-button-next" role="button" tabindex="0">
						<?php $this->render_swiper_button( 'next' ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $show_dots ) : ?>
					<div class="swiper-pagination"></div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php
	}


}
