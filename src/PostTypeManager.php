<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class PostTypeManager {

  public function setup() {

    add_action('save_post', [$this, 'savePost'], 10, 3);
    add_action('init', [$this, 'registerPostTypes']);

  }

  public function savePost( $postId, $post, $update ) {

    // only target our post type registrations
    if( $post->post_type !== 'acfe_post_type' ) {
      return;
    }

		$postTypeData = new \stdClass();

		$postTypeData->key = get_field('key', $postId);
		if( !$postTypeData->key ) {
			return;
		}

		$postTypeData->nameSingular = get_field('singular_name', $postId);
		$postTypeData->namePlural = get_field('plural_name', $postId);

    $postTypeJson = json_encode( $postTypeData );

    \file_put_contents( ACF_ENGINE_PATH . 'data/post-types/' . $postTypeData->key . '.json', $postTypeJson );

  }

  public function registerPostTypes() {

    // register our default post types
    $pt = new PostTypePostType();
    $pt->init();

		$pt = new PostTypeTaxonomy();
    $pt->init();

		$pt = new PostTypeOptionsPage();
    $pt->init();

		$pt = new PostTypeComponent();
    $pt->init();

		$pt = new PostTypeBlockType();
    $pt->init();

		$pt = new PostTypeTemplate();
    $pt->init();

    // get all the data files stored and register post types
    $ptDataFiles = $this->findPostTypeDataFiles();

    if( !empty( $ptDataFiles )) {

      foreach( $ptDataFiles as $ptDataFilename ) {

        $ptJson = file_get_contents( ACF_ENGINE_PATH . 'data/post-types/' . $ptDataFilename );
        $ptData = json_decode( $ptJson );

        $postType = new PostTypeCustom();
        $postType->setKey( $ptData->key );
        $postType->setNameSingular( $ptData->nameSingular );

				if( $ptData->namePlural ) {
					$postType->setNamePlural( $ptData->namePlural );
				}

        $postType->register();

      }
    }
  }

  protected function findPostTypeDataFiles() {

    $files = [];
    $dir = new \DirectoryIterator( ACF_ENGINE_PATH . 'data/post-types' );
    foreach ($dir as $fileInfo) {
      if (!$fileInfo->isDot()) {
        $files[] = $fileInfo->getFilename();
      }
    }

    return $files;

  }




}
