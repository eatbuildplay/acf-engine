<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class PostType {

	protected $prefix = 'acfe_';
	public 		$key;
	public 		$nameSingular;
	public 		$namePlural;
	public 		$showInMenu = true;

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
			'description'         => __($this->namePlural(), 'acf-engine'),
			'labels'              => $this->labels(),
			'menu_icon'           => 'dashicons-feedback',
			'public'              => true,
			'supports' 						=> $this->supports(),
			'show_ui'             => true,
			'show_in_menu'        => $this->showInMenu(),
			'menu_position'       => 20,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => $this->showArchive(),
			'hierarchical'        => false,
			'exclude_from_search' => $this->excludeFromSearch(),
			'show_in_rest'        => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'rewrite'             => array(
				'slug'       				=> $this->customPermalink(),
				'with_front' 				=> false,
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
			'add_new_item'          => __('Add New item', 'acf-engine'),
			'add_new'               => __('Add New', 'acf-engine'),
			'new_item'              => __('New item', 'acf-engine'),
			'edit_item'             => __('Edit item', 'acf-engine'),
			'update_item'           => __('Update item', 'acf-engine'),
			'view_item'             => __('View item', 'acf-engine'),
			'view_items'            => __('View items', 'acf-engine'),
			'search_items'          => __('Search item', 'acf-engine'),
			'not_found'             => __('Not found', 'acf-engine'),
			'not_found_in_trash'    => __('Not found in Trash', 'acf-engine'),
			'featured_image'        => __('Featured Image', 'acf-engine'),
			'set_featured_image'    => __('Set featured image', 'acf-engine'),
			'remove_featured_image' => __('Remove featured image', 'acf-engine'),
			'use_featured_image'    => __('Use as featured image', 'acf-engine'),
			'insert_into_item'      => __('Insert into item', 'acf-engine'),
			'uploaded_to_this_item' => __('Uploaded to this Newsletter', 'acf-engine'),
			'items_list'            => __('Items list', 'acf-engine'),
			'items_list_navigation' => __('Items list navigation', 'acf-engine'),
			'filter_items_list'     => __('Filter Items list', 'acf-engine'),
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

	public function supports() {
		return ['title'];
	}

	public function setKey( $value ) {
		$this->key = $value;
	}

	public function key() {
		return $this->key;
	}

}
