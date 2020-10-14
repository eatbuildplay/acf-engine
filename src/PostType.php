<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class PostType {

	protected $prefix = 'acfe_';
	protected $postType = 'acfe_post_type';
	public 		$key;
	public 		$nameSingular;
	public 		$namePlural;
	public 		$showInMenu 	= true;
	public 		$menuPosition = 10;
	public 		$supports;
	public 		$description = '';
	public 		$menuIcon = 'dashicons-feedback';
	protected   $public = true;
	protected   $publiclyQueryable = true;
	protected   $showUi = true;
	protected   $hierarchical = false;
	protected   $showInAdminBar = true;
	protected   $showInNavMenus = true;
	protected   $canExport = true;
	protected   $showInRest = false;
	protected   $withFront = true;

	public function init() {
		$this->parseArgs();
		$this->register();
	}

	public function parseArgs() {

		// set default plural name
		if( !$this->namePlural ) {
			$this->namePlural = $this->nameSingular . 's';
		}

	}

	public function getPrefixedKey() {
		return $this->prefix . $this->key();
	}

	public function register() {

		$this->showArchive = true;
		$this->excludeFromSearch = false;
		$this->customPermalink = null;

		return register_post_type( $this->getPrefixedKey(), $this->args() );

	}

	public function defaultArgs() {
		$args = [
			'label'               => __($this->nameSingular(), 'acf-engine'),
			'description'         => __($this->description(), 'acf-engine'),
			'labels'              => $this->labels(),
			'menu_icon'           => $this->menuIcon(),
			'public'              => $this->publicShow(),
			'supports' 			  => $this->supports(),
			'show_ui'             => $this->showUi(),
			'show_in_menu'        => $this->showInMenu(),
			'menu_position'       => $this->menuPosition(),
			'show_in_admin_bar'   => $this->showInAdminBar(),
			'show_in_nav_menus'   => $this->showInNavMenus(),
			'can_export'          => $this->canExport(),
			'has_archive'         => $this->showArchive(),
			'hierarchical'        => $this->hierarchical(),
			'exclude_from_search' => $this->excludeFromSearch(),
			'show_in_rest'        => $this->showInRest(),
			'publicly_queryable'  => $this->publiclyQueryable(),
			'capability_type'     => 'post',
			'rewrite'             => array(
				'slug'       				=> $this->customPermalink(),
				'with_front' 				=> $this->withFront(),
			)
		];

		if( !empty( $this->templatePaths() )) {
			$args['template'] 			= [ $this->templatePaths() ];
			$args['template_lock'] 	= 'all';
		}

		return $args;

	}

	public function labels() {
		return $this->defaultLabels();
	}

	public function defaultLabels() {

		return [
			'name'                  => $this->nameSingular(),
			'menu_name'             => $this->namePlural(),
			'name_admin_bar'        => $this->namePlural(),
			'archives'              => $this->nameSingular() . __(' Archives', 'acf-engine'),
			'attributes'            => $this->nameSingular() . __(' Attributes', 'acf-engine'),
			'parent_item_colon'     => __('Parent ', 'acf-engine') . $this->nameSingular(),
			'all_items'             => __('All ', 'acf-engine') . $this->namePlural(),
			'add_new_item'          => __('Add New ', 'acf-engine'). $this->nameSingular(),
			'add_new'               => __('Add New', 'acf-engine'),
			'new_item'              => __('New ', 'acf-engine'). $this->nameSingular(),
			'edit_item'             => __('Edit ', 'acf-engine'). $this->nameSingular(),
			'update_item'           => __('Update ', 'acf-engine'). $this->nameSingular(),
			'view_item'             => __('View ', 'acf-engine'). $this->nameSingular(),
			'view_items'            => __('View ', 'acf-engine'). $this->namePlural(),
			'search_items'          => __('Search ', 'acf-engine'). $this->nameSingular(),
			'not_found'             => __('Not found', 'acf-engine'),
			'not_found_in_trash'    => __('Not found in Trash', 'acf-engine'),
			'featured_image'        => __('Featured Image', 'acf-engine'),
			'set_featured_image'    => __('Set featured image', 'acf-engine'),
			'remove_featured_image' => __('Remove featured image', 'acf-engine'),
			'use_featured_image'    => __('Use as featured image', 'acf-engine'),
			'insert_into_item'      => __('Insert into ', 'acf-engine'). $this->nameSingular(),
			'uploaded_to_this_item' => __('Uploaded to this Newsletter', 'acf-engine'),
			'items_list'            => $this->namePlural(). __(' list', 'acf-engine'),
			'items_list_navigation' => $this->namePlural() . __(' list navigation', 'acf-engine'),
			'filter_items_list'     => __('Filter '. $this->namePlural() .' list', 'acf-engine'),
		];

	}

	/*
	 * Default settings
	 */
	public function showArchive() {
		if( is_null( $this->showArchive )) {
			return false;
		}
		return (bool) $this->showArchive;
	}

	public function excludeFromSearch() {
		if( is_null( $this->excludeFromSearch) ) {
			return false;
		}
		return $this->excludeFromSearch;
	}

	public function customPermalink() {
		if( is_null( $this->customPermalink ) ) {
			return str_replace('sb-', '', $this->key());
		}
		return $this->customPermalink;
	}

	public function templatePaths() {
		return false;
	}

	public function setNamePlural( $namePlural ) {
		$this->namePlural = $namePlural;
	}

	public function namePlural() {
		return $this->namePlural;
	}

	public function args() {
		return $this->defaultArgs();
	}

	public function setNameSingular( $value ) {
		$this->nameSingular = $value;
	}

	public function nameSingular() {
		return $this->nameSingular;
	}

	/*
	 *
	 * Menu settings
	 *
	 */
	public function setShowInMenu( $v ) {
		$this->showInMenu = $v;
	}

	public function showInMenu() {
		return $this->showInMenu;
	}

	public function setMenuPosition( $v ) {
		$this->menuPosition = (int) $v;
	}

	public function menuPosition() {
		return $this->menuPosition;
	}

	public function setSupports( $v ) {
		$this->supports = $v;
	}

	public function supports() {
		return $this->supports;
	}

	public function setKey( $value ) {
		$this->key = $value;
	}

	public function key() {
		return $this->key;
	}


    public function description() {
        return $this->description;
    }

    public function setDescription( $v ) {
        $this->description = $v;
    }

    public function publicShow() {
        return $this->public;
    }
    public function setPublicShow( $v ) {
        $this->public = (bool) $v;
    }

    public function publiclyQueryable() {
        return $this->publiclyQueryable;
    }
    public function setPubliclyQueryable( $v ) {
        $this->publiclyQueryable = (bool) $v;
    }

    public function showUi() {
        return $this->showUi;
    }
    public function setShowUi( $v ) {
        $this->showUi = (bool) $v;
    }

    public function showInAdminBar() {
        return $this->showInAdminBar;
    }
    public function setShowInAdminBar( $v ) {
        $this->showInAdminBar = (bool) $v;
    }

    public function showInNavMenus() {
        return $this->showInNavMenus;
    }
    public function setShowInNavMenus( $v ) {
        $this->showInNavMenus = (bool) $v;
    }

    public function canExport() {
        return $this->canExport;
    }
    public function setCanExport( $v ) {
        $this->canExport = (bool) $v;
    }

    public function showInRest() {
        return $this->showInRest;
    }
    public function setShowInRest( $v ) {
        $this->showInRest = (bool) $v;
    }

    public function withFront() {
        return $this->withFront;
    }
    public function setWithFront( $v ) {
        $this->withFront = (bool) $v;
    }

    public function menuIcon() {
        return $this->menuIcon;
    }
    public function setMenuIcon( $v ) {
        $this->menuIcon =  $v;
    }


    public function hierarchical() {
        return $this->hierarchical;
    }
    public function setHierarchical( $v ) {
        $this->hierarchical = (bool) $v;
    }

	public function postType() {
		return $this->postType;
	}

	/*
	 * Make a WP post with meta data from the current properties of this object
	 */
	public function import() {

		/*
		 * insert into db with create post
		 */
		$postId = wp_insert_post(
			[
				'post_type'      => $this->postType(),
				'post_title'     => $this->nameSingular(),
				'post_status'    => 'publish'
			]
		);

		/*
		 * update acf fields with meta data
		 */
		update_field( 'key', $this->key, $postId );
		update_field( 'title', $this->nameSingular(), $postId );
		// update_field( 'description', $this->description(), $postId );

		return $postId;

	}

}
