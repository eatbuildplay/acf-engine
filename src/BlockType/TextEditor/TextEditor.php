<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class TextEditor extends BlockType {

  public function key() {
		return 'text_editor';
	}

  public function title() {
    return 'ACFG Text Editor';
  }

  public function description() {
    return 'A text editor input with rendering as a block of text.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $postId ) {
		$this->render( $block, $content, $postId );
  }

	protected function render( $block, $content, $postId ) {

    $text = get_field( 'text' );
		$text = $this->replaceDynamicTags( $text, $postId );

		print '<div class="acfg-text-editor">' . $text . '</div>';

		$boxedWidth = get_field( 'boxed_width' );
		if( $boxedWidth ) {
			$maxWidth = get_field('max_width');
			print '<style>';
			print '.acfg-text-editor {';
			print 'max-width: ' . $maxWidth . 'px;';
			print 'margin-left: auto;';
			print 'margin-right: auto;';
			print '}';
			print '</style>';
		}

	}

}
