<?php

namespace AcfEngine\Core\BlockType;
use AcfEngine\Core\QueryManager;

if (!defined('ABSPATH')) {
	exit;
}

class Filter extends BlockType {

  public function key() {
		return 'filter';
	}

  public function title() {
    return 'Filter';
  }

  public function description() {
    return 'ACFG Filter';
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

  /*
   * How to make the list of options in the filter?
   * What options should be available for exercise?
   * With exercise it is a post relationship type...
   */

	protected function render( $block, $content, $postId ) {

    $metaKey = get_field_object('metakey');

    // var_dump( $metaKey );

    // load query
    $queryKey = get_field('query');
		$query = QueryManager::load( $queryKey );
		$posts = $query->run();

    // var_dump( $query );

    $posts = get_posts([
      'post_type' => 'acfg_exercise',
      'numberposts' => -1
    ]);

    $options = [];
    foreach( $posts as $post ) {
      $option = new \stdClass;
			$option->key = $post->ID;
      $option->name = $post->post_title;
      $options[] = $option;
    }

    // $query->queryPostType()

    print '<select class="acfg-filter">';
    foreach( $options as $option ) {
      print '<option value="' . $option->key . '">';
      print $option->name;
      print '</option>';
    }
    print '</select>';

	}

  public function enqueueScript() {
    return ACF_ENGINE_URL . 'src/BlockType/Filter/script.js';
  }

  public function enqueueStyle() {
    return ACF_ENGINE_URL . 'src/BlockType/Filter/styles.css';
  }

}
