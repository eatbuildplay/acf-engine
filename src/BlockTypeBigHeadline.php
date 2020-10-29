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

		// check for field placeholders
		if( strpos('{{', $text) !== false ) {
			$value = get_field( 'heading', $editorPostId );
		} else {
			$value = $text;
		}

    print '<h2 style="font-size: 4.5em;">';
    print $value;
    print '</h2>';

	}

	protected function render( $block, $content, $editorPostId ) {

		$value = get_field('text');

		// check for field placeholders
		if( strpos( $value, '{{' ) !== false ) {

			preg_match_all('/{{(.*?)}}/', $value, $matches);
			if( !empty( $matches[1] )) {
				foreach( $matches[1] as $placeholder ) {
					$placeholderValue = get_field( 'heading', $editorPostId );
					$value = str_replace('{{'.$placeholder.'}}', $placeholderValue, $value);
				}
			}
		}

    print '<h2 style="font-size: 4.5em;">';
    print $value;
    print '</h2>';

	}

}
