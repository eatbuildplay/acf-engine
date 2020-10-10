<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class BlockTypeManager {

  public function setup() {

    add_action('save_post', [$this, 'savePost'], 10, 3);
    add_action('acf/init', [$this, 'registerBlockTypes']);

  }


  public function savePost( $postId, $post, $update ) {

    // only target our post type registrations
    if( $post->post_type !== 'acfe_block_type' ) {
      return;
    }

		$data = new \stdClass();

		$data->key = get_field('key', $postId);
		if( !$data->key ) {
			return;
		}

		$data->id = $postId;
		$data->title = get_field('title', $postId);
		$data->description = get_field('title', $postId);

		/* update post title */
		remove_action( 'save_post', [$this, 'savePost'] );
		wp_update_post(
			[
				'ID' => $postId,
				'post_title' => $data->title
			]
		);

    $json = json_encode( $data );
    \file_put_contents( ACF_ENGINE_PATH . 'data/block-types/' . $data->key . '.json', $json );

  }

  public function registerBlockTypes() {

		/*
		 * Register our internal default block types
		 */

		$bt = new BlockTypeAcfTemplate();
 		$bt->init();

		$bt = new BlockTypeAcfField();
		$bt->init();

		$bt = new BlockTypeAcfFieldNumber();
		$bt->init();

		$bt = new BlockTypeAcfFieldImage();
		$bt->init();

    // get all the data files stored
    $dataFiles = $this->findBlockTypeDataFiles();

    if( !empty( $dataFiles )) {

      foreach( $dataFiles as $filename ) {

        $json = file_get_contents( ACF_ENGINE_PATH . 'data/block-types/' . $filename );
        $data = json_decode( $json );

        $c = new BlockTypeCustom();
        $c->setKey( $data->key );
				$c->setTitle( $data->title );
				$c->setDescription( $data->description );
        $c->register();

      }

    }

  }

  protected function findBlockTypeDataFiles() {

    $files = [];
    $dir = new \DirectoryIterator( ACF_ENGINE_PATH . 'data/block-types' );
    foreach ($dir as $fileInfo) {
      if (!$fileInfo->isDot()) {
        $files[] = $fileInfo->getFilename();
      }
    }

    return $files;

  }




}
