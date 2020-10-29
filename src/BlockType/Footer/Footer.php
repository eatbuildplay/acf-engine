<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Footer extends BlockType {

  public function key() {
		return 'footer';
	}

  public function title() {
    return 'ACFG Footer';
  }

  public function description() {
    return 'Renders a website footer.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $postId ) {
		$this->render( $block, $content, $postId );
  }

	protected function render( $block, $content, $postId ) {

		print 'FOOTER AREA';

	}

}
