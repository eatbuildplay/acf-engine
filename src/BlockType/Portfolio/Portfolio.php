<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Portfolio extends BlockType {

  public function key() {
		return 'portfolio';
	}

  public function title() {
    return 'Portfolio';
  }

  public function description() {
    return 'ACFG Portfolio';
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
		print 'PORTFOLIO';
	}

}
