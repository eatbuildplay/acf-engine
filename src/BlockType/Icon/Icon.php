<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Icon extends BlockType {

  public function key() {
		return 'icon';
	}

  public function title() {
    return 'ACFG Icon';
  }

  public function description() {
    return 'A single icon.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $postId ) {
		$this->render( $block, $content, $postId );
  }

	protected function render( $block, $content, $postId ) {

    $icon = get_field( 'icon' );
    $width = get_field( 'width' );
    $height = get_field( 'height' );

		print '<div class="acfg-icon">';
    print '<span class="dashicons ' . $icon . '"></span>';
    print '</div>';

    print '<style>';

    print '.acfg-icon .dashicons {';
    print 'font-size: ' . $width . 'px;';
    print 'width: ' . $width . 'px;';
    print 'height: ' . $height . 'px;';
    print '}';

		$boxedWidth = get_field( 'boxed_width' );
		if( $boxedWidth ) {
			$maxWidth = get_field('max_width');
			print '.acfg-icon {';
			print 'max-width: ' . $maxWidth . 'px;';
			print 'margin-left: auto;';
			print 'margin-right: auto;';
			print '}';
		}

    $alignment = get_field( 'alignment' );
    print '.acfg-icon {';
    print 'text-align: ' . $alignment . ';';
    print '}';

    print '</style>';

	}

}
