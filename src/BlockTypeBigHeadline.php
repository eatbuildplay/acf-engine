<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class BlockTypeBigHeadline extends BlockType {

  public function key() {
		return 'big_headline';
	}

  public function title() {
    return 'Big Headline';
  }

  public function description() {
    return 'A big bold and beautiful headline.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $editorPostId ) {
		if( $isPreview ) {
      $this->renderPreview( $block, $content, $editorPostId );
    } else {
      $this->render( $block, $content, $editorPostId );
    }
  }

	protected function renderPreview( $block, $content, $editorPostId ) {

    $text = get_field('text');
    print '<h2 style="font-size: 4.5em;">';
    print $text;
    print '</h2>';

	}

	protected function render( $block, $content, $editorPostId ) {

    $text = get_field('text');
    print '<h2 style="font-size: 4.5em;">';
    print $text;
    print '</h2>';

	}

}
