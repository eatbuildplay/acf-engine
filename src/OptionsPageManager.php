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
    if( $post->post_type !== 'acfg_options_page' ) {
      return;
    }

		$data = new \stdClass();

		$data->menuSlug = get_field('menu_slug', $postId);
		if( !$data->menuSlug ) {
			return;
		}

		$data->pageTitle = get_field('page_title', $postId);
		$data->menuTitle = get_field('menu_title', $postId);
		$data->capability = get_field('capability', $postId);
		$data->position = get_field('position', $postId);
		$data->parentSlug = get_field('parent_slug', $postId);
		$data->iconUrl = get_field('icon_url', $postId);
		$data->redirect = get_field('redirect', $postId);
		$data->postId = get_field('post_id', $postId);
		$data->autoload = get_field('autoload', $postId);
		$data->updateButton = get_field('update_button', $postId);
		$data->updatedMessage = get_field('updated_message', $postId);

		/* update post title */
		remove_action( 'save_post', [$this, 'savePost'] );
		wp_update_post(
			[
				'ID' => $postId,
				'post_title' => $data->pageTitle
			]
		);

    $json = json_encode( $data );

    \file_put_contents( \AcfEngine\Plugin::dataStoragePath() . 'options-pages/' . $data->menuSlug . '.json', $json );

  }

  public function registerOptionsPages() {

    // get all the data files stored
    $dataFiles = $this->findDataFiles();

    if( !empty( $dataFiles )) {

      foreach( $dataFiles as $filename ) {

        $json = file_get_contents( \AcfEngine\Plugin::dataStoragePath() . 'options-pages/' . $filename );
        $data = json_decode( $json );

        $obj = $this->initObject( $data );
        $obj->init();

      }

    }

  }

	public function loadDataFile( $filename ) {
		$json = file_get_contents( \AcfEngine\Plugin::dataStoragePath() . 'options-pages/' . $filename );
		return json_decode( $json );
	}

	public function initObject( $data ) {
		$obj = new OptionsPageCustom();
		$obj->setMenuSlug( $data->menuSlug );
		$obj->setPageTitle( $data->pageTitle );

		if( $data->menuTitle ) {
			$obj->setMenuTitle( $data->menuTitle );
		}

		$obj->setCapability( $data->capability );
		$obj->setPosition( $data->position );
		$obj->setParentSlug( $data->parentSlug );
		$obj->setIconUrl( $data->iconUrl );
		$obj->setRedirect( $data->redirect );
		$obj->setPostId( $data->postId );
		$obj->setAutoload( $data->autoload );
		$obj->setUpdateButton( $data->updateButton );
		$obj->setUpdatedMessage( $data->updatedMessage );
		return $obj;
	}

	public function getDataFiles() {
		return $this->findDataFiles();
	}

	public function fetchByKey( $key ) {

		$posts = get_posts([
			'post_type' 	=> 'acfg_options_page',
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

  protected function findDataFiles() {

		if( !is_dir( \AcfEngine\Plugin::dataStoragePath() . 'options-pages')) {
			return [];
		}

		$files = [];
    $dir = new \DirectoryIterator( \AcfEngine\Plugin::dataStoragePath() . 'options-pages' );

    foreach ($dir as $fileInfo) {
      if (!$fileInfo->isDot()) {
        $files[] = $fileInfo->getFilename();
      }
    }

    return $files;

  }




}
