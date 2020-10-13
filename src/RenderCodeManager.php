<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class RenderCodeManager {

  public function setup() {

    add_action('save_post', [$this, 'savePost'], 10, 3);
    add_action('init', [$this, 'registerPostTypes']);

  }

  public function savePost( $postId, $post, $update ) {

    // only target our post type registrations
    if( $post->post_type !== 'acfe_render_code' ) {
      return;
    }

		$postTypeData = new \stdClass();

		$postTypeData->key = get_field('key', $postId);
		if( !$postTypeData->key ) {
			return;
		}

		$postTypeData->nameSingular = get_field('singular_name', $postId);
		$postTypeData->namePlural = get_field('plural_name', $postId);

		/* update post title */
		remove_action( 'save_post', [$this, 'savePost'] );
		wp_update_post(
			[
				'ID' => $postId,
				'post_title' => $postTypeData->nameSingular
			]
		);

    $postTypeJson = json_encode( $postTypeData );

    \file_put_contents( ACF_ENGINE_PATH . 'data/render-code/' . $postTypeData->key . '.json', $postTypeJson );

  }

  public function registerPostTypes() {

    // get all the data files stored and register post types
    $files = $this->findRenderCodeDataFiles();

    if( !empty( $files )) {

      foreach( $files as $filename ) {

        $json = file_get_contents( ACF_ENGINE_PATH . 'data/render-code/' . $filename );
        $data = json_decode( $json );

        $rc = new RenderCodeCustom();
        $rc->setKey( $data->key );
        $rc->register();

      }
    }
  }

  protected function findRenderCodeDataFiles() {

		if( !is_dir( ACF_ENGINE_DATA_PATH . 'render-code')) {
			return [];
		}

		$files = [];
    $dir = new \DirectoryIterator( ACF_ENGINE_DATA_PATH . 'render-code' );

    foreach ($dir as $fileInfo) {
      if (!$fileInfo->isDot()) {
        $files[] = $fileInfo->getFilename();
      }
    }

    return $files;

  }




}
