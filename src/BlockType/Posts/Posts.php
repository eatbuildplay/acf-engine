<?php

namespace AcfEngine\Core\BlockType;
use AcfEngine\Core\QueryManager;
use AcfEngine\Core\TemplateManager;

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

		$data = [];
		foreach( $posts as $post ) {

			$post->name = get_field('name', $post->ID );
			$data[] = $post;

		}

		$templateKey = get_field('item_template');
		$tm = new TemplateManager();
		$templatePost = $tm->fetchByKey( $templateKey );

		global $post;

		foreach( $data as $item ) {

			$post = $item;
			$blocks = parse_blocks( $templatePost->post_content );

			print '<div class="acfg-grid-item">';

				foreach ($blocks as $block) {
					echo render_block($block);
				}

			print '</div>';

		}

	}

}
