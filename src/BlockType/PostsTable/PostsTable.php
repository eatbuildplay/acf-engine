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

				$fieldObject = get_field_object( $fieldKey, $post->ID );
				$tl = new \AcfEngine\Core\TemplateLoader();
				$tl->path = 'templates/fields/' . $fieldObject['type'] . '/';
				$tl->name = 'default';
				$tl->data = [
					'field'  => $fieldObject,
					'value'  => $fieldObject['value'],
					'postId' => $post->ID
				];
				$content = $tl->get();

				print '<td>';
	      print $content;
	      print '</td>';

			}

			if( get_field('management_column') == 1 ) {

				print '<td>';
				print '<a href="' . get_edit_post_link( $post ) . '">Edit</a>';
				print '</td>';

			}

      print '</tr>';

    }

		$calculations = get_field('calculations');

		if( !empty($calculations)) {
			foreach( $calculations as $calculation ) {

				$valueField = $calculation['value_field'];
				$groupingField = $calculation['grouping_field'];
				$type = get_field('type', $post->ID);

				if(!$groupingField) {
					$result = 0;
				} else {
					$result = [];
				}
				foreach( $posts as $post ) {

					if(!$groupingField) {
						// singular calculation
						$result += (int) get_field($valueField, $post->ID);
					} else {
						// grouped calculations
						$group = get_field($groupingField, $post->ID);
						if( !isset( $result[$group] )) {
							$result[$group] = 0;
						}
						$result[$group] += (int) get_field($valueField, $post->ID);
					}

				}



			} // end foreach over all calculations
		}

		if( $calculations ) {

			print '<tfoot>';
			print '<tr>';
			print '<td>';
			if( is_array( $result )) {
				foreach( $result as $index => $value ) {
					print '<h3>' . $index . ' - ' . $value . '</h3>';
				}
			} else {
					print '<h3>' . $result . '</h3>';
			}
			print '</td>';
			print '</tr>';
			print '</tfoot>';

		}

		print '</table>';
		print '</div>';

	}

}
