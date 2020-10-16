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

		$data->slug = get_field('slug', $postId);
		if( !$data->slug ) {
			return;
		}

		$data->pageTitle = get_field('page_title', $postId);
		$data->menuTitle = get_field('menu_title', $postId);

    $json = json_encode( $data );

    \file_put_contents( ACF_ENGINE_PATH . 'data/options-pages/' . $data->slug . '.json', $json );

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
