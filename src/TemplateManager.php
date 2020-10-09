<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class TemplateManager {

  public function setup() {

    add_action('save_post', [$this, 'savePost'], 10, 3);
    add_action('init', [$this, 'registerTaxonomies']);

		/* handle single template load */
		add_filter( 'single_template', [$this, 'singleTemplateLoader']);

  }


  public function savePost( $postId, $post, $update ) {

    // only target our post type registrations
    if( $post->post_type !== 'acfe_template' ) {
      return;
    }

		$data = new \stdClass();
		$data->id = $postId;

		$data->key = get_field('key', $postId);
		if( !$data->key ) {
			return;
		}

		$data->title = get_field('title', $postId);
		$data->type = get_field('type', $postId);

		/* update post title */
		remove_action( 'save_post', [$this, 'savePost'] );
		wp_update_post(
			[
				'ID' => $postId,
				'post_title' => $data->title
			]
		);

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

	/*
	 * Single Template Loader Method
	 * Callback for filter "single_template"
	 * https://developer.wordpress.org/reference/hooks/type_template/
	 */
	public function singleTemplateLoader( $template ) {

		if(1==1) { // add proper condition handling here 
	    $template = ACF_ENGINE_PATH . '/templates/singles/base.php';
	  }
	  return $template;

	}




}
