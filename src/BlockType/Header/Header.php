<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Header extends BlockType {

  public function key() {
		return 'header';
	}

  public function title() {
    return 'ACFG Header';
  }

  public function description() {
    return 'Renders the website header.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $postId ) {
		$this->render( $block, $content, $postId );
  }

	protected function render( $block, $content, $postId ) {

		print 'HEADER AREA';

	}

}
