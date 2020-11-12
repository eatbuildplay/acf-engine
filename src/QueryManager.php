<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class QueryManager {

  public function setup() {

    add_action('save_post', [$this, 'savePost'], 10, 3);
    add_action('init', [$this, 'registerQueries']);

  }


  public function savePost( $postId, $post, $update ) {

    // only target our post type registrations
    if( $post->post_type !== 'acfg_query' ) {
      return;
    }

		$data = new \stdClass();
		$data->key = get_field('key', $postId);

		if( !$data->key ) {
			return;
		}

		$data->title = get_field('title', $postId);

		$data->queryPostType 		= get_field('query_post_type', $postId);
		$data->limit 						= get_field('limit', $postId);
		$data->author 					= get_field('author', $postId);
		$data->metaQueries 			= get_field('meta_queries', $postId);

		/* update post title */
		remove_action( 'save_post', [$this, 'savePost'] );
		wp_update_post(
			[
				'ID' => $postId,
				'post_title' => $data->title
			]
		);

    $json = json_encode( $data );
    \file_put_contents( \AcfEngine\Plugin::dataStoragePath() . 'queries/' . $data->key . '.json', $json );

  }

	protected function objectInit( $data ) {

		$q = new QueryCustom();
		$q->setKey( $data->key );
		$q->setQueryPostType( $data->queryPostType );
		$q->setLimit( $data->limit );
		$q->setAuthor( $data->author );
		$q->setMetaQueries( $data->metaQueries );
		return $q;

	}

  public function registerQueries() {

    // get all the data files stored
    $dataFiles = $this->findQueryDataFiles();

    if( !empty( $dataFiles )) {

      foreach( $dataFiles as $filename ) {

        $json = file_get_contents( \AcfEngine\Plugin::dataStoragePath() . 'queries/' . $filename );
        $data = json_decode( $json );
        $q = $this->objectInit( $data );
        $q->register();

      }

    }

  }

  protected function findQueryDataFiles() {

		if( !is_dir( \AcfEngine\Plugin::dataStoragePath() . 'queries')) {
			return [];
		}

		$files = [];
    $dir = new \DirectoryIterator( \AcfEngine\Plugin::dataStoragePath() . 'queries' );

    foreach ($dir as $fileInfo) {
      if (!$fileInfo->isDot()) {
        $files[] = $fileInfo->getFilename();
      }
    }

    return $files;

  }

	public static function load( $key ) {

		$filename = $key . '.json';
		$json = file_get_contents( \AcfEngine\Plugin::dataStoragePath() . 'queries/' . $filename );
		$data = json_decode( $json );

		$qm = new QueryManager();
		return $qm->objectInit( $data );

	}

	public function fetchPostByKey( $key ) {

		$posts = get_posts([
			'post_type' 	=> 'acfg_query',
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
