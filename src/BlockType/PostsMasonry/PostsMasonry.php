<?php

namespace AcfEngine\Core\BlockType;
use AcfEngine\Core\QueryManager;
use AcfEngine\Core\TemplateManager;

if (!defined('ABSPATH')) {
	exit;
}

class PostsMasonry extends BlockType {

  public function key() {
		return 'posts_masonry';
	}

  public function title() {
    return 'Posts Masonry';
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

		print '<div class="acfg-grid">';

		foreach( $data as $item ) {

			$post = $item;
			$blocks = parse_blocks( $templatePost->post_content );

			print '<div class="acfg-grid-item">';

				print '<a href="' . get_permalink( $post ) . '">';

				foreach ($blocks as $block) {
					echo render_block($block);
				}

				print '</a>';

				if( current_user_can('editor') || current_user_can('administrator') ) {
					print '<a class="acfg-admin-edit" href="' . get_edit_post_link( $post ) . '">';
					print 'EDIT POST';
					print '</a>';
				}

			print '</div>';

		}

		print '</div>';

		print '<a class="acfg-admin-edit" href="' . get_edit_post_link( $templatePost ) . '">';
		print 'EDIT LOOP TEMPLATE';
		print '</a>';

	}

	public function enqueueStyle() {
    return ACF_ENGINE_URL . 'src/BlockType/PostsMasonry/styles.css?test=232132';
  }

}
