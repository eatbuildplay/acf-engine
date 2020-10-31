<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Accordion extends BlockType {

  public function key() {
		return 'accordion';
	}

  public function title() {
    return 'Accordion';
  }

  public function description() {
    return 'An accordion filled with content.';
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

		print 'ACCORDION';

	}

}
