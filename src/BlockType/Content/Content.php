<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Content extends BlockType {

  public function key() {
		return 'content';
	}

  public function title() {
    return 'ACFG Content';
  }

  public function description() {
    return 'Renders the current post content equivalent to calling the_content() core WP function.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $postId ) {
		$this->render( $block, $content, $postId );
  }

	protected function render( $block, $content, $postId ) {

		the_content();

	}

}
