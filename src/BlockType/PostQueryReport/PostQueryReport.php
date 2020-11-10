<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class PostQueryReport extends BlockType {

  public function key() {
		return 'post_query_report';
	}

  public function title() {
    return 'Post Query Report';
  }

  public function description() {
    return 'ACFG query posts and report on a given field.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $postId ) {

		$this->render( $block, $content, $postId );

  }

	protected function render( $block, $content, $postId ) {

    $postTypePrefix = 'acfg_';
    $postTypeKey = 'set';
    $posts = get_posts([
      'post_type' => $postTypePrefix . $postTypeKey,
      'numberposts' => -1
    ]);

    $totalReps = 0;
		$totalMinutes = 0;
    foreach( $posts as $post ) {

			if( get_field('unit', $post->ID) == 'reps' ) {
				$totalReps += (int) get_field('value', $post->ID);
			}

			if( get_field('unit', $post->ID) == 'minutes' ) {
				$totalMinutes += (int) get_field('value', $post->ID);
			}

    }

    print '<div class="acfg-post-query-report">';
    print '<h4>Reps Total</h4>';
    print '<h2>' . $totalReps . '</h2>';
		print '<h4>Minutes Total</h4>';
    print '<h2>' . $totalMinutes . '</h2>';
    print '</div>';

	}

}
