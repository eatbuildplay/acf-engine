<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class FlipBox extends BlockType {

  public function key() {
		return 'flip_box';
	}

  public function title() {
    return 'Flip Box';
  }

  public function description() {
    return 'Render a flip box.';
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

		print 'Flip Box';

	}

}
