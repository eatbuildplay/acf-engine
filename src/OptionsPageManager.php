<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class OptionsPageManager {

  public function setup() {

    add_action('save_post', [$this, 'savePost'], 10, 3);
    add_action('init', [$this, 'registerOptionsPages']);

  }


  public function savePost( $postId, $post, $update ) {

    // only target our post type registrations
    if( $post->post_type !== 'acfe_options_page' ) {
      return;
    }

		$data = new \stdClass();

		$data->key = get_field('key', $postId);
		if( !$data->key ) {
			return;
		}

    $json = json_encode( $data );

    \file_put_contents( ACF_ENGINE_PATH . 'data/options-pages/' . $data->key . '.json', $json );

  }

  public function registerOptionsPages() {

    // get all the data files stored
    $dataFiles = $this->findOptionsPageDataFiles();

    if( !empty( $dataFiles )) {

      foreach( $dataFiles as $filename ) {

        $json = file_get_contents( ACF_ENGINE_PATH . 'data/options-pages/' . $filename );
        $data = json_decode( $json );

        $tc = new OptionsPageCustom();
        $tc->setKey( $data->key );

        $postType->register();


      }

    }

  }

  protected function findOptionsPageDataFiles() {

    $files = [];
    $dir = new \DirectoryIterator( ACF_ENGINE_PATH . 'data/options-pages' );
    foreach ($dir as $fileInfo) {
      if (!$fileInfo->isDot()) {
        $files[] = $fileInfo->getFilename();
      }
    }

    return $files;

  }




}
