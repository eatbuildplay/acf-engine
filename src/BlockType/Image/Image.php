<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Image extends BlockType {

  public function key() {
		return 'image';
	}

  public function title() {
    return 'ACFG Image';
  }

  public function description() {
    return 'Displays a single image.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $postId ) {

    /*if( $isPreview ) {
			$previewPost = $this->getPreviewPost( $postId );
			$postId = $previewPost->ID;
    }*/

		$this->render( $block, $content, $postId );
  }

	protected function render( $block, $content, $postId ) {

		$image  = get_field('image');
    $size = 'full';

    print '<div class="acfg-image">';
    print wp_get_attachment_image( $image, $size );
    print '</div>';

		print '<style>';
		print '.acfg-image {';
    print 'max-width: 100%;';
		print '}';
		print '</style>';

	}

}
