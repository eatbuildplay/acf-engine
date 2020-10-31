<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Testimonial extends BlockType {

  public function key() {
		return 'testimonial';
	}

  public function title() {
    return 'Testimonial';
  }

  public function description() {
    return 'ACFG Testimonial';
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
		print 'TESTIMONIAL';
	}

}
