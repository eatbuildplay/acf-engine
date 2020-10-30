<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class BigHeadline extends BlockType {

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

  public function callback( $block, $content, $isPreview, $postId ) {

		if( $isPreview ) {
			$previewPost = $this->getPreviewPost( $postId );
			$postId = $previewPost->ID;
    }

		$this->render( $block, $content, $postId );

  }

	protected function render( $block, $content, $postId ) {

		$value = get_field('text');
		$size = get_field('size');
		$color = get_field('color');

		$value = $this->replaceDynamicTags( $value, $postId );

    print '<h2 class="acfg-big-headline">';
    print $value;
    print '</h2>';

		print '<style>';
		print '.acfg-big-headline {';
		print 'font-size: ' . $size . 'em;';
		print 'color: ' . $color . ';';
		print '}';

		if( $block['align'] == '' ) {
			print '.acfg-big-headline {';
			print 'max-width: 1200px;';
			print 'margin: 25px auto;';
			print '}';
		}

		print '</style>';

	}

}
