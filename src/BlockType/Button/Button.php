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

		/* content */
		print '<div class="acfg-button">';
    print '<a href="' . get_field('link') . '">';
		print '<button>';
    print get_field('text');
    print '</button>';
    print '</a>';
		print '</div>';

		/* styles */
		print '<style>';
		print '.acfg-button button {';

		print 'display: inline-block;';
		print 'cursor: pointer;';

		if( $padding = get_field('padding') ) {
			print 'padding: ' . $padding . 'px;';
		}

		if( $margin = get_field('margin') ) {
			print 'margin: ' . $margin . 'px;';
		}

		if( $fontSize = get_field('font_size') ) {
			print 'font-size: ' . $fontSize . 'em;';
		}

		if( $backgroundColor = get_field('background_color') ) {
			print 'background-color: ' . $backgroundColor . ';';
		}

		print '}';
		print '</style>';

	}

}
