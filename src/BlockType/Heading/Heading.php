<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Heading extends BlockType {

  public function key() {
		return 'heading';
	}

  public function title() {
    return 'ACFG Heading';
  }

  public function description() {
    return 'A heading wrapping in an HTML heading tag such as <h2>.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $postId ) {
		$this->render( $block, $content, $postId );
  }

	protected function render( $block, $content, $postId ) {

    $text = get_field( 'text' );

		print '<h2>' . $text . '</h2>';

	}

}
