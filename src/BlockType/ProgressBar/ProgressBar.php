<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class ProgressBar extends BlockType {

  public function key() {
		return 'progress_bar';
	}

  public function title() {
    return 'Progress Bar';
  }

  public function description() {
    return 'ACFG Progress Bar';
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
		print 'PROGRESS BAR';
	}

}
