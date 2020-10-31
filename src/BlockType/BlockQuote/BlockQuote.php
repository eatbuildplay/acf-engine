<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class BlockQuote extends BlockType {

  public function key() {
		return 'block_quote';
	}

  public function title() {
    return 'Block Quote';
  }

  public function description() {
    return 'Render a block quote.';
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
		print 'BLOCK QUOTE';
	}

}
