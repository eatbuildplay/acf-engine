<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Video extends BlockType {

  public function key() {
		return 'video';
	}

  public function title() {
    return 'ACFG Video';
  }

  public function description() {
    return 'A video player.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $postId ) {
		$this->render( $block, $content, $postId );
  }

	protected function render( $block, $content, $postId ) {

    $video = get_field( 'video' );
		print $video;

	}

}
