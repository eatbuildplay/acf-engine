<?php

namespace AcfEngine\Core\BlockType;

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
    if( $post->post_type !== 'acfg_block_type' ) {
      return;
    }

		$data = new \stdClass();

		$data->key = get_field('key', $postId);
		if( !$data->key ) {
			return;
		}

		$data->id = $postId;
		$data->title 					= get_field('title', $postId);
		$data->description 		= get_field('title', $postId);
		$data->renderCode 		= get_field('render_code', $postId);
		$data->category		 		= get_field('category', $postId);
		$data->icon		 				= get_field('icon', $postId);
		$data->keywords		 		= get_field('keywords', $postId);
		$data->postTypes			= get_field('post_types', $postId);
		$data->mode						= get_field('mode', $postId);
		$data->align					= get_field('align', $postId);
		$data->alignText			= get_field('align_text', $postId);
		$data->alignContent		= get_field('align_content', $postId);
		$data->renderTemplate	= get_field('render_template', $postId);
		$data->renderCallback	= get_field('render_callback', $postId);
		$data->enqueueStyle		= get_field('enqueue_style', $postId);
		$data->enqueueScript	= get_field('enqueue_script', $postId);
		$data->enqueueAssets	= get_field('enqueue_assets', $postId);
		$data->supports				= get_field('supports', $postId);

		/* update post title */
		remove_action( 'save_post', [$this, 'savePost'] );
		wp_update_post(
			[
				'ID' => $postId,
				'post_title' => $data->title
			]
		);

    $json = json_encode( $data );
    \file_put_contents( \AcfEngine\Plugin::dataStoragePath() . 'block-types/' . $data->key . '.json', $json );

  }

  public function registerBlockTypes() {

		/*
		 * Register our internal default block types
		 */

		$bt = new AcfTemplate();
 		$bt->init();

		$bt = new AcfField();
		$bt->init();

		$bt = new AcfFieldNumber();
		$bt->init();

		$bt = new AcfFieldImage();
		$bt->init();

		$bt = new AcfRepeaterGallery();
		$bt->init();

		$bt = new BigHeadline();
		$bt->init();

    // get all the data files stored
    $dataFiles = $this->findBlockTypeDataFiles();

    if( !empty( $dataFiles )) {

      foreach( $dataFiles as $filename ) {

        $data = $this->loadDataFile( $filename );
				$obj 	= $this->initObject( $data );
        $obj->register();

      }
    }
  }

	public function fetchByKey( $key ) {

		$posts = get_posts([
			'post_type' 	=> 'acfg_block_type',
			'numberposts' => -1,
			'meta_query' => [
				[
					'key' 	=> 'key',
					'value' => $key
				]
			]
		]);

		if( !$posts || empty( $posts )) {
			return false;
		}

		return $posts[0];

	}

	public function initObject( $data ) {
		$obj = new BlockTypeCustom();
		$obj->setKey( $data->key );
		$obj->setTitle( $data->title );
		$obj->setDescription( $data->description );
		return $obj;
	}

	public function loadDataFile( $filename ) {
		$json = file_get_contents( \AcfEngine\Plugin::dataStoragePath() . 'block-types/' . $filename );
		return json_decode( $json );
	}

	// public option to get the data file list
	public function getDataFiles() {
		return $this->findBlockTypeDataFiles();
	}

  protected function findBlockTypeDataFiles() {

    $files = [];
		if( !is_dir( \AcfEngine\Plugin::dataStoragePath() . 'block-types')) {
			return [];
		}
    $dir = new \DirectoryIterator( \AcfEngine\Plugin::dataStoragePath() . 'block-types' );

    foreach ($dir as $fileInfo) {
      if (!$fileInfo->isDot()) {
        $files[] = $fileInfo->getFilename();
      }
    }

    return $files;

  }




}
