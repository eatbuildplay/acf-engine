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

		$type = get_field('type');

		if( $type == 'dynamic' ) {
			$ratingDynamic = get_field('rating_dynamic');
			$rating = $this->replaceDynamicTags( $ratingDynamic, $postId );
		} else {
			$rating = get_field('rating');
		}
		ob_start(); ?>

			<div class="acfg-star-rating" style="--rating: <?= $rating ?>;" aria-label="Rating of this product is 0 out of 5.">
			<style>
				:root {
					--star-size: 40px;
					--star-color: #cdcdcd;
					--star-background: #fc0;
				}
				.acfg-star-rating {
					--percent: calc(var(--rating) / 5 * 100%);

					display: inline-block;
					font-size: var(--star-size);
					font-family: Times; /* make sure ★ appears correctly */
					line-height: 1;
					height: ;
				}
				.acfg-star-rating::before {
					content: "★★★★★";
					letter-spacing: 3px;
					background: linear-gradient(
					90deg,
					var(--star-background) var(--percent),
					var(--star-color) var(--percent)
					);
					-webkit-background-clip: text;
					-webkit-text-fill-color: transparent;
				}
			</style>
			
		<?php
		print ob_get_clean();
	}

}
