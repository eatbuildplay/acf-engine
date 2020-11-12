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
        $data->title = get_field('title', $postId);
		$data->nameSingular = get_field('singular_name', $postId);
		$data->namePlural = get_field('plural_name', $postId);
		$data->objectType = get_field('object_type', $postId);
		$data->labels = get_field('labels', $postId);
		$data->public = get_field('public', $postId);
		$data->publiclyQueryable = get_field('publicly_queryable', $postId);
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
		$data->capabilities = get_field('capabilities', $postId);
		$data->rewrite = get_field('rewrite', $postId);
		$data->defaultTerm = get_field('default_term', $postId);

		/* update post title */
		remove_action( 'save_post', [$this, 'savePost'] );
		wp_update_post(
			[
				'ID' => $postId,
				'post_title' => $data->title
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
		$obj->setTitle( $data->title );
		$obj->setNameSingular( $data->nameSingular );

        if( isset($data->namePlural) && $data->namePlural ) {
            $obj->setNamePlural( $data->namePlural );
        }

		$obj->setLabels( $data->labels );

        if( isset($data->description) && $data->description ) {
            $obj->setDescription( $data->description );
        }

        if( isset($data->public) && !$data->public ) {
            $obj->setPublic( false );
        }

        if( isset($data->publiclyQueryable) && !$data->publiclyQueryable ) {
            $obj->setPubliclyQueryable( false );
        }

        if( isset($data->hierarchical) && $data->hierarchical ) {
            $obj->setHierarchical( true );
        }

        if( isset($data->showUi) && !$data->showUi ) {
            $obj->setShowUi( false );
        }

        if( isset($data->showInMenu) && !$data->showInMenu ) {
            $obj->setShowInMenu( false );
        }

        if( isset($data->showInNavMenus) && !$data->showInNavMenus ) {
            $obj->setShowInNavMenus( $data->showInNavMenus );
        }

        if( isset($data->showInRest) && !$data->showInRest ) {
            $obj->setShowInRest( false );
        }

        if( isset($data->restBase) && $data->restBase ) {
            $obj->setRestBase( $data->restBase );
        }

        if( isset( $data->restControllerClass ) && $data->restControllerClass ) {
            $obj->setRestControllerClass( $data->restControllerClass );
        }

        if( isset($data->showTagcloud) && !$data->showTagcloud ) {
            $obj->setShowTagcloud( false );
        }

        if( isset($data->showInQuickEdit) && !$data->showInQuickEdit ) {
            $obj->setShowInQuickEdit( false );
        }

        if( isset($data->showAdminColumn) && $data->showAdminColumn ) {
            $obj->setShowAdminColumn( true );
        }

        if( isset($data->capabilities) && $data->capabilities ) {
            $obj->setCapabilities( $data->capabilities );
        }

        if( isset($data->rewrite) ) {
            $obj->setRewrite( $data->rewrite );
        }

        if( isset($data->defaultTerm) ) {
            $obj->setDefaultTerm( $data->defaultTerm );
        }

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
