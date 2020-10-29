<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class StarRating extends BlockType {

  public function key() {
		return 'star_rating';
	}

  public function title() {
    return 'ACFG Star Rating';
  }

  public function description() {
    return 'Adds a star rating.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $postId ) {
		$this->render( $block, $content, $postId );
  }

	protected function render( $block, $content, $postId ) {

		print '<div class="acfg-star-rating">';
    print get_field('rating');
		print '</div>';

	}

}
