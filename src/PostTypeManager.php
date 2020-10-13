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

		$data = new \stdClass();

		$data->key = get_field('key', $postId);
		if( !$data->key ) {
			return;
		}

		$data->nameSingular = get_field('singular_name', $postId);
		$data->namePlural = get_field('plural_name', $postId);
		$data->showInMenu = get_field('show_in_menu', $postId);
		$data->menuPosition = get_field('menu_position', $postId);
		$data->supports = get_field('supports', $postId);

		/* update post title */
		remove_action( 'save_post', [$this, 'savePost'] );
		wp_update_post(
			[
				'ID' => $postId,
				'post_title' => $data->nameSingular
			]
		);

    $postTypeJson = json_encode( $data );

    \file_put_contents( ACF_ENGINE_PATH . 'data/post-types/' . $data->key . '.json', $postTypeJson );

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

		$pt = new PostTypeRenderCode();
    $pt->init();

    // get all the data files stored and register post types
    $files = $this->findPostTypeDataFiles();

    if( !empty( $files )) {

      foreach( $files as $filename ) {

        $json = file_get_contents( ACF_ENGINE_PATH . 'data/post-types/' . $filename );
        $data = json_decode( $json );

        $postType = new PostTypeCustom();
        $postType->setKey( $data->key );
        $postType->setNameSingular( $data->nameSingular );

				if( $data->namePlural ) {
					$postType->setNamePlural( $data->namePlural );
				}

				if( isset($data->showInMenu) && !$data->showInMenu ) {
					$postType->setShowInMenu( false );
				}

				if( isset($data->menuPosition) && is_numeric($data->menuPosition) ) {
					$postType->setMenuPosition( $data->menuPosition );
				}

				if( isset($data->supports) ) {
					$postType->setSupports( $data->supports );
				}

        $postType->register();

      }
    }
  }

  protected function findPostTypeDataFiles() {

		if( !is_dir( ACF_ENGINE_DATA_PATH . 'post-types')) {
			return [];
		}

		$files = [];
    $dir = new \DirectoryIterator( ACF_ENGINE_DATA_PATH . 'post-types' );

    foreach ($dir as $fileInfo) {
      if (!$fileInfo->isDot()) {
        $files[] = $fileInfo->getFilename();
      }
    }

    return $files;

  }




}
