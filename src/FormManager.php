<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class FormManager {

  public function setup() {

    add_action('save_post', [$this, 'savePost'], 10, 3);
    add_action('init', [$this, 'registerForms']);

  }


  public function savePost( $postId, $post, $update ) {

    // only target our post type registrations
    if( $post->post_type !== 'acfg_form' ) {
      return;
    }

		$data = new \stdClass();
		$data->key = get_field('key', $postId);

		if( !$data->key ) {
			return;
		}

    $json = json_encode( $data );
    \file_put_contents( \AcfEngine\Plugin::dataStoragePath() . 'forms/' . $data->key . '.json', $json );

  }

  public function registerForms() {

    // get all the data files stored
    $dataFiles = $this->findFormDataFiles();

    if( !empty( $dataFiles )) {

      foreach( $dataFiles as $filename ) {

        $json = file_get_contents( \AcfEngine\Plugin::dataStoragePath() . 'forms/' . $filename );
        $data = json_decode( $json );

        $c = new FormCustom();
        $c->setKey( $data->key );
        $c->register();

      }

    }

  }

  protected function findFormDataFiles() {

		if( !is_dir( \AcfEngine\Plugin::dataStoragePath() . 'forms')) {
			return [];
		}

		$files = [];
    $dir = new \DirectoryIterator( \AcfEngine\Plugin::dataStoragePath() . 'forms' );

    foreach ($dir as $fileInfo) {
      if (!$fileInfo->isDot()) {
        $files[] = $fileInfo->getFilename();
      }
    }

    return $files;

  }

}
