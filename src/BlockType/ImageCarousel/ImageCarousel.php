<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class ImageCarousel extends BlockType {

  public function key() {
		return 'image_carousel';
	}

  public function title() {
    return 'Image Carousel';
  }

  public function description() {
    return 'ACFG Image Carousel';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $postId ) {

		if( $isPreview ) {
			$previewPost = $this->getPreviewPost( $postId );
			$postId = $previewPost->ID;
    }

		$this->render( $block, $content, $postId );

  }

	protected function render( $block, $content, $postId ) {
		print 'IMAGE CAROUSEL';
	}

}
