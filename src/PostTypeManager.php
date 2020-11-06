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
    if( $post->post_type !== 'acfg_post_type' ) {
      return;
    }

		$data = new \stdClass();

		$data->key = get_field('key', $postId);
		if( !$data->key ) {
			return;
		}

		$data->nameSingular = get_field('singular_name', $postId);
		$data->namePlural = get_field('plural_name', $postId);
		$data->description = get_field('description', $postId);
    $data->name = get_field('name', $postId);
		$data->labels = [
			'name' =>  $data->name,
			'menuName' =>  get_field('menu_name', $postId),
			'archives' =>  get_field('archives', $postId),
			'attributes' =>  get_field('attributes', $postId),
			'parentItemColon' =>  get_field('parent_item_colon', $postId),
			'allItems' =>  get_field('all_items', $postId),
			'addNewItem' =>  get_field('add_new_item', $postId),
			'addNew' =>  get_field('add_new', $postId),
			'newItem' =>  get_field('new_item', $postId),
			'editItem' =>  get_field('edit_item', $postId),
			'updateItem' =>  get_field('update_item', $postId),
			'viewItem' =>  get_field('view_item', $postId),
			'viewItems' =>  get_field('view_items', $postId),
			'searchItems' =>  get_field('search_items', $postId),
			'notFound' =>  get_field('not_found', $postId),
			'notFoundInTrash' =>  get_field('not_found_in_trash', $postId),
			'featuredImage' =>  get_field('featured_image', $postId),
			'setFeaturedImage' =>  get_field('set_featured_image', $postId),
			'removeFeaturedImage' =>  get_field('remove_featured_image', $postId),
			'useFeaturedImage' =>  get_field('use_featured_image', $postId),
			'insertIntoItem' =>  get_field('insert_into_item', $postId),
			'uploadedToThisItem' =>  get_field('uploaded_to_this_item', $postId),
			'itemsList' =>  get_field('items_list', $postId),
			'itemsListNavigation' =>  get_field('items_list_navigation', $postId),
			'filterItemsList' =>  get_field('filter_items_list', $postId),
    ];
		$data->public  = get_field('public', $postId);
		$data->supports = get_field('supports', $postId);
		$data->showUi = get_field('show_ui', $postId);
		$data->showInMenu = get_field('menu_settings', $postId)['show_in_menu'];
    $data->menuPosition = get_field('menu_settings', $postId)['menu_position'];
    $data->menuIcon  = get_field('menu_settings', $postId)['menu_icon'];
		$data->showInAdminBar = get_field('show_in_admin_bar', $postId);
		$data->showInNavMenus = get_field('show_in_nav_menus', $postId);
		$data->canExport = get_field('can_export', $postId);
		$data->showArchive = get_field('has_archive', $postId);
		$data->hierarchical = get_field('hierarchical', $postId);
		$data->mapMetaCap = get_field('map_meta_cap', $postId);
		$data->queryVar = get_field('query_var', $postId);
		$data->deleteWithUser = get_field('delete_with_user', $postId);
		$data->excludeFromSearch = get_field('exclude_from_search', $postId);
		$data->showInRest = get_field('show_in_rest', $postId);
		$data->restBase = get_field('rest_base', $postId);
		$data->restControllerClass = get_field('rest_controller_class', $postId);
		$data->publiclyQueryable = get_field('publicly_queryable', $postId);
		$data->capabilityType = get_field('capability_type', $postId);
        $data->capabilities = get_field('capabilities', $postId);
		if (get_field('rewrite', $postId)) {
	    $data->rewrite = [
	      'slug'          => get_field('slug', $postId),
	      'withFront'    => get_field('with_front', $postId),
	      'feeds'    => get_field('feeds', $postId),
	      'pages'    => get_field('pages', $postId),
	      'epMask'    => get_field('ep_mask', $postId),
	    ];
    } else {
      $data->rewrite = get_field('rewrite', $postId);
    }

		/* update post title */
		remove_action( 'save_post', [$this, 'savePost'] );
		wp_update_post(
			[
				'ID' => $postId,
				'post_title' => $data->nameSingular
			]
		);

    $postTypeJson = json_encode( $data );

    if (!is_dir(\AcfEngine\Plugin::dataStoragePath() . 'post-types/')) {
    	// @TODO throw error here
			return;
    }

    \file_put_contents( \AcfEngine\Plugin::dataStoragePath() . 'post-types/' . $data->key . '.json', $postTypeJson );

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

        $data = $this->loadDataFile( $filename );
				$obj 	= $this->initObject( $data );
        $obj->register();

      }
    }
  }

	public function fetchByKey( $key ) {

		$posts = get_posts([
			'post_type' 	=> 'acfg_post_type',
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

	public function loadDataFile( $filename ) {
		$json = file_get_contents( \AcfEngine\Plugin::dataStoragePath() . 'post-types/' . $filename );
		return json_decode( $json );
	}

	public function initObject( $data ) {
		$obj = new PostTypeCustom();
		$obj->setKey( $data->key );
		$obj->setNameSingular( $data->nameSingular );

		if( $data->namePlural ) {
			$obj->setNamePlural( $data->namePlural );
		}

		if( isset($data->showInMenu) && !$data->showInMenu ) {
			$obj->setShowInMenu( false );
		}

		if( isset($data->menuPosition) && is_numeric($data->menuPosition) ) {
			$obj->setMenuPosition( $data->menuPosition );
		}

		if( isset($data->supports) ) {
			$obj->setSupports( $data->supports );
		}

        if( $data->description ) {
            $obj->setDescription( $data->description );
        }

        if( isset($data->showInRest) && !$data->showInRest ) {
            $obj->setShowInRest( false );
        }

        if( $data->menuIcon ) {
            $obj->setMenuIcon( $data->menuIcon );
        }

        if( isset($data->public) && !$data->public ) {
            $obj->setPublic( false );
        }

        if( isset($data->publiclyQueryable) && !$data->publiclyQueryable ) {
            $obj->setPubliclyQueryable( false );
        }

        if( isset($data->showUi) && !$data->showUi ) {
            $obj->setShowUi( false );
        }

        if( isset($data->hierarchical) && $data->hierarchical ) {
            $obj->setHierarchical( true );
        }

        if( isset($data->excludeFromSearch) && !$data->excludeFromSearch ) {
            $obj->setExcludeFromSearch( false );
        }

        if( isset($data->showArchive) && !$data->showArchive ) {
            $obj->setShowArchive( false );
        }

        if( isset($data->mapMetaCap) && $data->mapMetaCap ) {
            $obj->setMapMetaCap( true );
        }

        if( isset($data->queryVar) && !$data->queryVar ) {
            $obj->setQueryVar( false );
        }

        if( isset($data->deleteWithUser) && $data->deleteWithUser ) {
            $obj->setDeleteWithUser( true );
        }

        if( $data->restBase ) {
            $obj->setRestBase( $data->restBase );
        }

        if( $data->restControllerClass ) {
            $obj->setRestControllerClass( $data->restControllerClass );
        }

        if( $data->capabilityType ) {
            $obj->setCapabilityType( $data->capabilityType );
        }

        if( $data->capabilities ) {
            $obj->setCapabilities( $data->capabilities );
        }

        if( isset($data->showInAdminBar) && !$data->showInAdminBar ) {
            $obj->setShowInAdminBar( false );
        }

        if( isset($data->showInNavMenus) && !$data->showInNavMenus ) {
            $obj->setShowInNavMenus( false );
        }

        if( isset($data->rewrite) && !$data->rewrite ) {
            $obj->setRewrite( false );
        }

        if( isset($data->rewrite->slug) && !$data->rewrite->slug ) {
            $obj->setRewriteSlug( false );
        }

        if( isset($data->rewrite->withFront) && !$data->rewrite->withFront ) {
            $obj->setRewriteWithFront( false );
        }

        if( isset($data->rewrite->feeds) && !$data->rewrite->feeds ) {
            $obj->setRewriteFeeds( false );
        }

        if( isset($data->rewrite->pages) && !$data->rewrite->pages ) {
            $obj->setRewritePages( false );
        }

        if( isset($data->rewrite->epMask) && !$data->rewrite->epMask ) {
            $obj->setRewriteEpMask( false );
        }

		return $obj;
	}

	public function getDataFiles() {
		return $this->findPostTypeDataFiles();
	}

  protected function findPostTypeDataFiles() {

		if( !is_dir( \AcfEngine\Plugin::dataStoragePath() . 'post-types')) {
			return [];
		}

		$files = [];
    $dir = new \DirectoryIterator( \AcfEngine\Plugin::dataStoragePath() . 'post-types' );

    foreach ($dir as $fileInfo) {
      if (!$fileInfo->isDot()) {
        $files[] = $fileInfo->getFilename();
      }
    }

    return $files;

  }




}
