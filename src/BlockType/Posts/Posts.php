<?php

namespace AcfEngine\Core\BlockType;
use AcfEngine\Core\QueryManager;

if (!defined('ABSPATH')) {
	exit;
}

class Posts extends BlockType {

  public function key() {
		return 'posts';
	}

  public function title() {
    return 'Posts';
  }

  public function description() {
    return 'ACFG Posts';
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

		$queryKey = get_field('query');
		$query = QueryManager::load( $queryKey );
		$posts = $query->run();

		print 'POSTS';

	}

}
