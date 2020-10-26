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

		/* handle archive template load */
		add_filter( 'archive_template', [$this, 'archiveTemplateLoader']);

  }


  public function savePost( $postId, $post, $update ) {

    // only target our post type registrations
    if( $post->post_type !== 'acfg_template' ) {
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

    \file_put_contents( \AcfEngine\Plugin::dataStoragePath() . 'templates/' . $data->key . '.json', $json );

  }

  public function registerTaxonomies() {

    // get all the data files stored
    $dataFiles = $this->findDataFiles();

    if( !empty( $dataFiles )) {

      foreach( $dataFiles as $filename ) {

        $json = file_get_contents( \AcfEngine\Plugin::dataStoragePath() . 'templates/' . $filename );
        $data = json_decode( $json );

        $tc = new TemplateCustom();
        $tc->setKey( $data->key );
        $tc->register();


      }

    }

  }

	public function getDataFiles() {
		return $this->findDataFiles();
	}

  protected function findDataFiles() {

		if( !is_dir( \AcfEngine\Plugin::dataStoragePath() . 'templates')) {
			return [];
		}

		$files = [];
    $dir = new \DirectoryIterator( \AcfEngine\Plugin::dataStoragePath() . 'templates' );

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

		global $post;

		$singleTemplates = $this->findSingleTemplates( $post->post_type );
		if( empty( $singleTemplates )) {
			return $template; // no single templates available
		}

		$GLOBALS['acfg_template_singles'] = $singleTemplates;

		// use base single template
	  return ACF_ENGINE_PATH . 'templates/singles/base.php';

	}

	// return template keys matching post_type
	public function findSingleTemplates( $postType ) {

		$templatePosts = get_posts([
			'post_type' => 'acfg_template',
			'numberposts' => -1,
			'meta_query' => [
				[
					'key' 	=> 'type',
					'value' => 'single_post'
				],
				[
					'key' => 'post_type',
					'value' => $postType
				]
			]
		]);

		if( empty( $templatePosts )) {
			return []; // no single templates found
		}

		$templates = [];
		foreach( $templatePosts as $templatePost ) {
			$templates[] = [
				'id' 	=> $templatePost->ID,
				'key' => get_field('key', $templatePost->ID)
			];
		}
		return $templates;

	}

	/*
	 * Archive Template Loader Method
	 * Callback for filter "archive_template"
	 * https://developer.wordpress.org/reference/hooks/type_template/
	 */
	public function archiveTemplateLoader( $template ) {

		global $post;

		$archiveTemplates = $this->findArchiveTemplates( $post->post_type );
		if( empty( $archiveTemplates )) {
			return $template; // no archive templates available
		}

		$GLOBALS['acfg_archive_templates'] = $archiveTemplates;
		return ACF_ENGINE_PATH . '/templates/archives/base.php';

	}

	// return template keys matching post_type
	public function findArchiveTemplates( $postType ) {

		$templatePosts = get_posts([
			'post_type' => 'acfg_template',
			'numberposts' => -1,
			'meta_query' => [
				[
					'key' 	=> 'type',
					'value' => 'archive_page'
				],
				[
					'key' 	=> 'post_type',
					'value' => $postType
				]
			]
		]);

		if( empty( $templatePosts )) {
			return []; // no single templates found
		}

		$templates = [];
		foreach( $templatePosts as $templatePost ) {
			$templates[] = [
				'id' => $templatePost->ID,
				'key' => get_field('key', $templatePost->ID)
			];
		}
		return $templates;

	}

	public function loadDataFile( $filename ) {
		$json = file_get_contents( \AcfEngine\Plugin::dataStoragePath() . 'templates/' . $filename );
		return json_decode( $json );
	}

	public function initObject( $data ) {
		$obj = new TemplateCustom();
		$obj->setKey( $data->key );
		return $obj;
	}

	public function fetchByKey( $key ) {

		$posts = get_posts([
			'post_type' 	=> 'acfg_template',
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

}
