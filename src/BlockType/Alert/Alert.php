<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Alert extends BlockType {

  public function key() {
		return 'alert';
	}

  public function title() {
    return 'Alert';
  }

  public function description() {
    return 'A single alert with content.';
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
		print 'ALERT';
	}

}
