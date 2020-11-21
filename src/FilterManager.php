<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class FilterManager {

  public function setup() {

    add_action('save_post', [$this, 'savePost'], 10, 3);
    add_action('wp', [$this, 'registerFilters']);

  }


  public function savePost( $postId, $post, $update ) {

    // only target our post type registrations
    if( $post->post_type !== 'acfg_filter' ) {
      return;
    }

		$data = new \stdClass();
		$data->key 							= get_field('key', $postId);

		if( !$data->key ) {
			return;
		}

		$data->title 						= get_field('title', $postId);

		/*
		 * Post create field handling
		 */
		if( $data->newPost == true ) {
			$data->newPost = [
				'post_type' 		=> get_field('create_post_type', $postId),
				'post_title' 		=> get_field('create_post_title', $postId),
				'post_content' 	=> get_field('create_post_content', $postId),
				'post_status' 	=> get_field('create_post_status', $postId),
			];
		}

		/* update post title */
		remove_action( 'save_post', [$this, 'savePost'] );
		wp_update_post(
			[
				'ID' => $postId,
				'post_title' => $data->title
			]
		);

    $json = json_encode( $data );
    \file_put_contents( \AcfEngine\Plugin::dataStoragePath() . 'filters/' . $data->key . '.json', $json );

  }

  public function registerFilters() {

    // get all the data files stored
    $dataFiles = $this->findFilterDataFiles();

    if( !empty( $dataFiles )) {

			$filtersRegistered = [];

      foreach( $dataFiles as $filename ) {

        $json = file_get_contents( \AcfEngine\Plugin::dataStoragePath() . 'filters/' . $filename );
        $data = json_decode( $json );

        $f = new FilterCustom();
        $f->setKey( $data->key );
				$f->setTitle( $data->title );
				$f->setPostId( $data->postId );
				$f->setNewPost( $data->newPost );
				$f->setFieldGroups( $data->fieldGroups );
				$f->setFields( $data->fields );
				$f->setPostTitle( $data->postTitle );
				$f->setPostContent( $data->postContent );
				$f->setFilter( $data->filter );
				$f->setFilterAttributes( $data->filterAttributes );
				$f->setReturn( $data->return );
				$f->setHtmlBeforeFields( $data->htmlBeforeFields );
				$f->setHtmlAfterFields( $data->htmlAfterFields );
				$f->setSubmitValue( $data->submitValue );
				$f->setUpdatedMessage( $data->updatedMessage );
				$f->setLabelPlacement( $data->labelPlacement );
				$f->setInstructionPlacement( $data->instructionPlacement );
				$f->setFilterFieldEl( $data->filterFieldEl );
				$f->setUploader( $data->uploader );
				$f->setHoneypot( $data->honeypot );
				$f->setHtmlUpdatedMessage( $data->htmlUpdatedMessage );
				$f->setHtmlSubmitButton( $data->htmlSubmitButton );
				$f->setHtmlSubmitSpinner( $data->htmlSubmitSpinner );
				$f->setKses( $data->kses );
        $f->register();

				// stash registered filter object
				$filtersRegistered[ $data->key ] = $f;

      }

    }

		return $filtersRegistered;

  }

  protected function findFilterDataFiles() {

		if( !is_dir( \AcfEngine\Plugin::dataStoragePath() . 'filters')) {
			return [];
		}

		$files = [];
    $dir = new \DirectoryIterator( \AcfEngine\Plugin::dataStoragePath() . 'filters' );

    foreach ($dir as $fileInfo) {
      if (!$fileInfo->isDot()) {
        $files[] = $fileInfo->getFilename();
      }
    }

    return $files;

  }

}
