<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class SocialIcons extends BlockType {

  public function key() {
		return 'social_icons';
	}

  public function title() {
    return 'Social Icons';
  }

  public function description() {
    return 'ACFG Social Icons';
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
		print 'SOCIAL ICONS';
	}

}
