<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class AcfRepeaterTable extends BlockType {

  public function key() {
		return 'acf_repeater_table';
	}

  public function title() {
    return 'ACF Repeater Table';
  }

  public function description() {
    return 'Use an ACF repeater field to make a table display.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $postId ) {

		if( $isPreview ) {

		}

		$this->render( $block, $content, $postId );

  }

	protected function render( $block, $content, $postId ) {

		print 'REPEATER TABLE';

	}

}
