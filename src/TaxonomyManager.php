<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class TaxonomyManager {

  public function setup() {

    add_action('save_post', [$this, 'savePost'], 10, 3);
    add_action('init', [$this, 'registerTaxonomies']);

  }


  public function savePost( $postId, $post, $update ) {

    // only target our post type registrations
    if( $post->post_type !== 'acfe_taxonomy' ) {
      return;
    }

		$data = new \stdClass();

		$data->key = get_field('key', $postId);
		if( !$data->key ) {
			return;
		}

		$data->nameSingular = get_field('title', $postId);
		$data->namePlural = get_field('plural_name', $postId);
		$data->objectTypes = get_field('object_types', $postId);

		/* update post title */
		remove_action( 'save_post', [$this, 'savePost'] );
		wp_update_post(
			[
				'ID' => $postId,
				'post_title' => $data->nameSingular
			]
		);

    $json = json_encode( $data );
    \file_put_contents( ACF_ENGINE_PATH . 'data/taxonomies/' . $data->key . '.json', $json );

  }

  public function registerTaxonomies() {

    // get all the data files stored
    $dataFiles = $this->findTaxonomyDataFiles();

    if( !empty( $dataFiles )) {

      foreach( $dataFiles as $filename ) {

				$data = $this->loadDataFile( $filename );
				$obj 	= $this->initObject( $data );
        $obj->register();

      }

    }

  }

  protected function findTaxonomyDataFiles() {

		if( !is_dir( ACF_ENGINE_DATA_PATH . 'taxonomies')) {
			return [];
		}

		$files = [];
    $dir = new \DirectoryIterator( ACF_ENGINE_DATA_PATH . 'taxonomies' );

    foreach ($dir as $fileInfo) {
      if (!$fileInfo->isDot()) {
        $files[] = $fileInfo->getFilename();
      }
    }

    return $files;

  }

	public function getDataFiles() {
		return $this->findTaxonomyDataFiles();
	}

	public function loadDataFile( $filename ) {
		$json = file_get_contents( ACF_ENGINE_PATH . 'data/taxonomies/' . $filename );
		return json_decode( $json );
	}

	public function initObject( $data ) {
		$obj = new TaxonomyCustom();
		$obj->setKey( $data->key );
		return $obj;
	}

	public function fetchByKey( $key ) {

		$posts = get_posts([
			'post_type' 	=> 'acfe_taxonomy',
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


}
