<?php

namespace AkzentPointsOfInterest\Views;

defined('ABSPATH') || exit;

class ImageCardGridView {
  /**
   * BaseControl Class for creating Elementor widget controls based on the name
   *
   * @since 1.0.0
   * @access public
   *
   * @param array    $posts       Point of Interest custom post type array
   * @param string   $image_size  Elementor Image Size
   * @param string   $max_height  The max height in px for the card (Based on smallest image, since akzent ignores all my warning about image sizes)
   *                              i mean, images with height: 4800 width: 960 should not be uploaded but if i validate them im the bad guy -.-
   */
  static function render($posts, $image_size) {
    require_once AKZENT_POINTS_OF_INTEREST_PATH . 'includes/views/image_card.php';
    wp_enqueue_style( 'akzent_bootstrap_style' );
    wp_enqueue_style( 'akzent_main_style' );
    wp_enqueue_style( 'akzent_grid_style' );

		?>
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g4">
        <?php foreach($posts as $point ) : ?>
          <div class="col" style="margin-bottom: 25px">
            <?php ImageCardView::render($point, $image_size, 0); ?>
          </div>
        <?php endforeach; ?>
      </div>
		<?

  }
}
