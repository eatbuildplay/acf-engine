<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class TableOfContents extends BlockType {

  public function key() {
		return 'table_of_contents';
	}

  public function title() {
    return 'Table Of Contents';
  }

  public function description() {
    return 'ACFG Table Of Contents';
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
		print 'TABLE OF CONTENTS';
	}

}
