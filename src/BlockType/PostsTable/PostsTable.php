<?php

namespace AcfEngine\Core\BlockType;
use AcfEngine\Core\QueryManager;

if (!defined('ABSPATH')) {
	exit;
}

class PostsTable extends BlockType {

  public function key() {
		return 'posts_table';
	}

  public function title() {
    return 'Posts Table';
  }

  public function description() {
    return 'Displays posts in a table format.';
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

		$columns = get_field('columns');

		if( !$columns ) {
			print '<h2>No columns defined.</h2>';
			return;
		}

		$columnFieldKeys = [];
		foreach( $columns as $row ) {
			$columnFieldKeys[] = $row['column_field_key'];
		}

		$queryKey = get_field('query');
		$query = QueryManager::load( $queryKey );
		$posts = $query->run();

    if( !$posts ) {
      print '<h2>No posts returned in query.</h2>';
    }

    print '<div class="acfg-posts-table">';
    print '<table>';
    foreach( $posts as $post ) {

      print '<tr>';

			foreach( $columnFieldKeys as $fieldKey ) {

				print '<td>';
	      print get_field( $fieldKey, $post->ID );
	      print '</td>';

			}

			if( get_field('management_column') == 1 ) {

				print '<td>';
				print '<a href="' . get_edit_post_link( $post ) . '">Edit</a>';
				print '</td>';

			}

      print '</tr>';

    }
    print '</table>';
    print '</div>';

	}

}
