<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class ShareButtons extends BlockType {

  public function key() {
		return 'share_buttons';
	}

  public function title() {
    return 'Share Buttons';
  }

  public function description() {
    return 'ACFG Share Buttons';
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
		print 'SHARE BUTTONS';
	}

}
