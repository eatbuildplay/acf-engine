<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class BlockQuote extends BlockType {

  public function key() {
		return 'block_quote';
	}

  public function title() {
    return 'Block Quote';
  }

  public function description() {
    return 'Render a block quote.';
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

        if( $color = get_field('color') ) {
            print 'background-color: ' . $color . ';';
        }

        print '}';
        print '</style>';
	}

}
