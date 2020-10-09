<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class ComponentManager {

  public function setup() {

    add_action('save_post', [$this, 'savePost'], 10, 3);
    add_action('init', [$this, 'registerComponents']);

  }


  public function savePost( $postId, $post, $update ) {

    // only target our post type registrations
    if( $post->post_type !== 'acfe_component' ) {
      return;
    }

		$data = new \stdClass();
		$data->key = get_field('key', $postId);

		if( !$data->key ) {
			return;
		}

    $json = json_encode( $data );
    \file_put_contents( ACF_ENGINE_PATH . 'data/components/' . $data->key . '.json', $json );

  }

  public function registerComponents() {

    // get all the data files stored
    $dataFiles = $this->findComponentDataFiles();

    if( !empty( $dataFiles )) {

      foreach( $dataFiles as $filename ) {

        $json = file_get_contents( ACF_ENGINE_PATH . 'data/components/' . $filename );
        $data = json_decode( $json );

        $c = new ComponentCustom();
        $c->setKey( $data->key );
        $c->register();

      }

    }

  }

  protected function findComponentDataFiles() {

    $files = [];
    $dir = new \DirectoryIterator( ACF_ENGINE_PATH . 'data/components' );
    foreach ($dir as $fileInfo) {
      if (!$fileInfo->isDot()) {
        $files[] = $fileInfo->getFilename();
      }
    }

    return $files;

  }




}
