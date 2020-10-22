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

    $json = json_encode( $data );

    \file_put_contents( ACF_ENGINE_PATH . 'data/options-pages/' . $data->menuSlug . '.json', $json );

  }

  public function registerOptionsPages() {

    // get all the data files stored
    $dataFiles = $this->findOptionsPageDataFiles();

    if( !empty( $dataFiles )) {

      foreach( $dataFiles as $filename ) {

        $json = file_get_contents( ACF_ENGINE_PATH . 'data/options-pages/' . $filename );
        $data = json_decode( $json );

        $op = new OptionsPageCustom();
        $op->setMenuSlug( $data->menuSlug );
				$op->setPageTitle( $data->pageTitle );
				if( $data->menuTitle ) {
					$op->setMenuTitle( $data->menuTitle );
				}

				$op->setAutoload( $data->autoload );
				$op->setUpdateButton( $data->updateButton );
				$op->setUpdatedMessage( $data->updatedMessage );
        $op->init();

      }

    }

  }

  protected function findOptionsPageDataFiles() {

		if( !is_dir( ACF_ENGINE_DATA_PATH . 'options-pages')) {
			return [];
		}

		$files = [];
    $dir = new \DirectoryIterator( ACF_ENGINE_DATA_PATH . 'options-pages' );

    foreach ($dir as $fileInfo) {
      if (!$fileInfo->isDot()) {
        $files[] = $fileInfo->getFilename();
      }
    }

    return $files;

  }




}
