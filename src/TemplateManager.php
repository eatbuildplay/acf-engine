<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class TemplateManager {

  public function setup() {

    add_action('save_post', [$this, 'savePost'], 10, 3);
    add_action('init', [$this, 'registerTaxonomies']);

  }


  public function savePost( $postId, $post, $update ) {

    // only target our post type registrations
    if( $post->post_type !== 'acfe_template' ) {
      return;
    }

		$data = new \stdClass();

		$data->key = get_field('key', $postId);
		if( !$data->key ) {
			return;
		}

    $json = json_encode( $data );

    \file_put_contents( ACF_ENGINE_PATH . 'data/templates/' . $data->key . '.json', $json );

  }

  public function registerTaxonomies() {

    // get all the data files stored
    $dataFiles = $this->findTemplateDataFiles();

    if( !empty( $dataFiles )) {

      foreach( $dataFiles as $filename ) {

        $json = file_get_contents( ACF_ENGINE_PATH . 'data/templates/' . $filename );
        $data = json_decode( $json );

        $tc = new TemplateCustom();
        $tc->setKey( $data->key );
        $tc->register();


      }

    }

  }

  protected function findTemplateDataFiles() {

    $files = [];
    $dir = new \DirectoryIterator( ACF_ENGINE_PATH . 'data/templates' );
    foreach ($dir as $fileInfo) {
      if (!$fileInfo->isDot()) {
        $files[] = $fileInfo->getFilename();
      }
    }

    return $files;

  }




}
