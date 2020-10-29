<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Button extends BlockType {

  public function key() {
		return 'button';
	}

  public function title() {
    return 'ACFG Button';
  }

  public function description() {
    return 'Adds a button.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $postId ) {
		$this->render( $block, $content, $postId );
  }

	protected function render( $block, $content, $postId ) {

    print '<a href="' . get_field('link') . '">';
		print '<button>';
    print get_field('text');
    print '</button>';
    print '</a>';

	}

}
