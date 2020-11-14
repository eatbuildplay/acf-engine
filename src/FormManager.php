<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class FormManager {

  public function setup() {

    add_action('save_post', [$this, 'savePost'], 10, 3);
    add_action('wp', [$this, 'registerForms']);

  }


  public function savePost( $postId, $post, $update ) {

    // only target our post type registrations
    if( $post->post_type !== 'acfg_form' ) {
      return;
    }

		$data = new \stdClass();
		$data->key 							= get_field('key', $postId);

		if( !$data->key ) {
			return;
		}

		$data->title 						= get_field('title', $postId);
		$data->postId 					= get_field('post_id', $postId);
		$data->newPost 					= get_field('new_post', $postId);
		$data->fieldGroups 			= get_field('form_field_groups', $postId);
		$data->fields 					= get_field('form_fields', $postId);
		$data->postTitle 				= get_field('post_title', $postId);
		$data->postContent 			= get_field('post_content', $postId);
		$data->form 						= get_field('form', $postId);
		$data->formAttributes 	= get_field('form_attributes', $postId);
		$data->return 					= get_field('return', $postId);
		$data->htmlBeforeFields = get_field('html_before_fields', $postId);
		$data->htmlAfterFields 	= get_field('html_after_fields', $postId);
		$data->submitValue 			= get_field('submit_value', $postId);
		$data->updatedMessage 	= get_field('updated_message', $postId);
		$data->labelPlacement		= get_field('label_placement', $postId);
		$data->instructionPlacement = get_field('instruction_placement', $postId);
		$data->formFieldEl			= get_field('form_field_el', $postId);
		$data->uploader					= get_field('uploader', $postId);
		$data->honeypot					= get_field('honeypot', $postId);
		$data->htmlUpdatedMessage = get_field('html_updated_message', $postId);
		$data->htmlSubmitButton	= get_field('html_submit_button', $postId);
		$data->htmlSubmitSpinner = get_field('html_submit_spinner', $postId);
		$data->kses 						= get_field('kses', $postId);

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
    \file_put_contents( \AcfEngine\Plugin::dataStoragePath() . 'forms/' . $data->key . '.json', $json );

  }

  public function registerForms() {

    // get all the data files stored
    $dataFiles = $this->findFormDataFiles();

    if( !empty( $dataFiles )) {

      foreach( $dataFiles as $filename ) {

        $json = file_get_contents( \AcfEngine\Plugin::dataStoragePath() . 'forms/' . $filename );
        $data = json_decode( $json );

        $f = new FormCustom();
        $f->setKey( $data->key );
				$f->setTitle( $data->title );
				$f->setPostId( $data->postId );
				$f->setNewPost( $data->newPost );
				$f->setFieldGroups( $data->fieldGroups );
				$f->setFields( $data->fields );
				$f->setPostTitle( $data->postTitle );
				$f->setPostContent( $data->postContent );
				$f->setForm( $data->form );
				$f->setFormAttributes( $data->formAttributes );
				$f->setReturn( $data->return );
				$f->setHtmlBeforeFields( $data->htmlBeforeFields );
				$f->setHtmlAfterFields( $data->htmlAfterFields );
				$f->setSubmitValue( $data->submitValue );
				$f->setUpdatedMessage( $data->updatedMessage );
				$f->setLabelPlacement( $data->labelPlacement );
				$f->setInstructionPlacement( $data->instructionPlacement );
				$f->setFormFieldEl( $data->formFieldEl );
				$f->setUploader( $data->uploader );
				$f->setHoneypot( $data->honeypot );
				$f->setHtmlUpdatedMessage( $data->htmlUpdatedMessage );
				$f->setHtmlSubmitButton( $data->htmlSubmitButton );
				$f->setHtmlSubmitSpinner( $data->htmlSubmitSpinner );
				$f->setKses( $data->kses );
        $f->register();

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
