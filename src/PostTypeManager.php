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
		$data->description = get_field('description', $postId);
		$data->labels = [
		   'name' =>  get_field('name', $postId),
		   'menuName' =>  get_field('menu_name', $postId),
		   'nameAdminBar' =>  get_field('name_admin_bar', $postId),
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
		$data->menuIcon  = get_field('menu_icon', $postId);
		$data->public  = get_field('public', $postId);
		$data->supports = get_field('supports', $postId);
		$data->showUi = get_field('show_ui', $postId);
		$data->showInMenu = get_field('show_in_menu', $postId);
		$data->menuPosition = get_field('menu_position', $postId);
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
		$data->publiclyQueryable = get_field('publicly_queryable', $postId);
		$data->capabilityType = get_field('capability_type', $postId);
		$data->rewrite = [
		    'slug'          => get_field('slug', $postId),
            'withFront'    => get_field('with_front', $postId),
        ];


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

        $data = $this->loadDataFile( $filename );
				$obj 	= $this->initObject( $data );
        $obj->register();

      }
    }
  }

	public function fetchByKey( $key ) {

		$posts = get_posts([
			'post_type' 	=> 'acfe_post_type',
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
		$json = file_get_contents( ACF_ENGINE_PATH . 'data/post-types/' . $filename );
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
		return $obj;
	}

	public function getDataFiles() {
		return $this->findPostTypeDataFiles();
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
