<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class TaxonomyManager {

	private $postTypeKey = 'acfg_taxonomy';

  public function setup() {

    add_action('save_post', [$this, 'savePost'], 10, 3);
    add_action('init', [$this, 'registerTaxonomies']);

  }


  public function savePost( $postId, $post, $update ) {

    // only target our post type registrations
    if( $post->post_type !== $this->postTypeKey() ) {
      return;
    }

		$data = new \stdClass();

		$data->key = get_field('key', $postId);
		if( !$data->key ) {
			return;
		}

		$data->description = get_field('description', $postId);
		$data->nameSingular = get_field('title', $postId);
		$data->namePlural = get_field('plural_name', $postId);
		$data->objectType = get_field('object_type', $postId);
		$data->labels = get_field('labels', $postId);
		$data->public = get_field('public', $postId);
		$data->publicQueryable = get_field('public_queryable', $postId);
		$data->hierarchical = get_field('hierarchical', $postId);
		$data->showUi = get_field('show_ui', $postId);
		$data->showInMenu = get_field('show_in_menu', $postId);
		$data->showInNavMenus = get_field('show_in_nav_menus', $postId);
		$data->showInRest = get_field('show_in_rest', $postId);
		$data->restBase = get_field('rest_base', $postId);
		$data->restControllerClass = get_field('rest_controller_class', $postId);
		$data->showTagcloud = get_field('show_tagcloud', $postId);
		$data->showInQuickEdit = get_field('show_in_quick_edit', $postId);
		$data->showAdminColumn = get_field('show_admin_column', $postId);
		$data->metaBoxCb = get_field('show_meta_box_cb', $postId);
		$data->metaBoxSanitizeCb = get_field('show_meta_box_sanitize_cb', $postId);
		$data->capabilities = get_field('capabilities', $postId);
		$data->rewrite = get_field('rewrite', $postId);
		$data->queryVar = get_field('query_var', $postId);
		$data->updateCountCallback = get_field('update_count_callback', $postId);
		$data->defaultTerm = get_field('default_term', $postId);

		/* update post title */
		remove_action( 'save_post', [$this, 'savePost'] );
		wp_update_post(
			[
				'ID' => $postId,
				'post_title' => $data->nameSingular
			]
		);

    $json = json_encode( $data );

    if (!is_dir(\AcfEngine\Plugin::dataStoragePath() . 'taxonomies/')) {
        mkdir(\AcfEngine\Plugin::dataStoragePath() . 'taxonomies/', 0777, true);
    }

    \file_put_contents( \AcfEngine\Plugin::dataStoragePath() . 'taxonomies/' . $data->key . '.json', $json );

  }

  public function registerTaxonomies() {

    // get all the data files stored
    $dataFiles = $this->findTaxonomyDataFiles();

    if( !empty( $dataFiles )) {

      foreach( $dataFiles as $filename ) {

				$data = $this->loadDataFile( $filename );
				$obj 	= $this->initObject( $data );
        $obj->register();

      }

    }

  }

  protected function findTaxonomyDataFiles() {

		if( !is_dir( \AcfEngine\Plugin::dataStoragePath() . 'taxonomies')) {
			return [];
		}

		$files = [];
    $dir = new \DirectoryIterator( \AcfEngine\Plugin::dataStoragePath() . 'taxonomies' );

    foreach ($dir as $fileInfo) {
      if (!$fileInfo->isDot()) {
        $files[] = $fileInfo->getFilename();
      }
    }

    return $files;

  }

	public function getDataFiles() {
		return $this->findTaxonomyDataFiles();
	}

	public function loadDataFile( $filename ) {
		$json = file_get_contents( \AcfEngine\Plugin::dataStoragePath() . 'taxonomies/' . $filename );
		return json_decode( $json );
	}

	public function initObject( $data ) {

		$obj = new TaxonomyCustom();
		$obj->setKey( $data->key );
		$obj->setObjectType( $data->objectType );
		$obj->setLabels( $data->labels );
		$obj->setDescription( $data->description );
		$obj->setPublic( $data->public );
		$obj->setPublicQueryable( $data->publicQueryable );
		$obj->setHierarchical( $data->hierarchical );
		$obj->setShowUi( $data->showUi );
		$obj->setShowInMenu( $data->showInMenu );
		$obj->showInNavMenus( $data->showInNavMenus );
		$obj->showInRest( $data->showInRest );
		$obj->setRestBase( $data->restBase );
		$obj->setRestControllerClass( $data->restControllerClass );
		$obj->setShowTagcloud( $data->showTagcloud );
		$obj->setShowInQuickEdit( $data->showInQuickEdit );
		$obj->setShowAdminColumn( $data->showAdminColumn );
		$obj->setMetaBoxCb( $data->metaBoxCb );
		$obj->setMetaBoxSanitizeCb( $data->metaBoxSanitizeCb );
		$obj->setCapabilities( $data->capabilities );
		$obj->setRewrite( $data->rewrite );
		$obj->setQueryVar( $data->queryVar );
		$obj->setUpdateCountCallback( $data->updateCountCallback );
		$obj->setDefaultTerm( $data->defaultTerm );
		return $obj;

	}

	public function fetchByKey( $key ) {

		$posts = get_posts([
			'post_type' 	=> 'acfg_taxonomy',
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

	public function postTypeKey() {
		return $this->postTypeKey;
	}

}
