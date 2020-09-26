<?php

namespace AcfEngine\PostTypes;

if (!defined('ABSPATH')) {
	exit;
}

class PostType {

	protected $prefix = 'acfeng-';

	public function init() {

		$this->loadUserSettings();
		$this->register();

	}

	public function getPrefixedKey() {
		return $this->prefix . $this->key();
	}

	public function register() {

		register_post_type( $this->getPrefixedKey(), $this->args() );

	}

	public function defaultArgs() {
		$args = [
			'label'               => __($this->renderName(), 'acf-engine'),
			'description'         => __($this->namePlural(), 'acf-engine'),
			'labels'              => $this->labels(),
			'menu_icon'           => 'dashicons-feedback',
			'public'              => true,
			'supports' 						=> array('title', 'editor', 'thumbnail',  'custom-fields'),
			'show_ui'             => true,
			'show_in_menu'        => true,
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
			'name'                  => $this->renderName(),
			'menu_name'             => $this->renderName(),
			'name_admin_bar'        => $this->renderName(),
			'archives'              => $this->renderName() . __(' Archives', 'acf-engine'),
			'attributes'            => $this->renderName() . __(' Attributes', 'acf-engine'),
			'parent_item_colon'     => __('Parent ', 'acf-engine') . $this->renderName(),
			'all_items'             => __('All ', 'acf-engine') . $this->renderName(),
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

	public function namePlural() {
		return $this->renderName() . 's';
	}

	public function args() {
		return $this->defaultArgs();
	}

	/*
	 * Standard user settings loader
	 * Override if you have custom settings
	 */
	 public function loadUserSettings() {

		$optionKeyBase = str_replace( '-', '_', $this->key() );

 		$this->excludeFromSearch = !get_field($optionKeyBase.'_show_in_search', 'option');
 		$this->showPage 					= get_field($optionKeyBase.'_show_page', 'option');
 		$this->showArchive 				= get_field($optionKeyBase.'_show_archive', 'option');
 		$this->alternateNameSet  	= get_field($optionKeyBase.'_alternate_name_check', 'option');
 		$this->alternateName      = get_field($optionKeyBase.'_the_alternative_name', 'option');
 		$this->postTypeName       = $this->alternateNameSet && !empty($this->alternateName) ? $this->alternateName : $this->renderName();
 		$this->customPermalink    = !empty(get_field($optionKeyBase.'_permalinks', 'option')) ? get_field($optionKeyBase.'_permalinks', 'option') : $this->key();
 		$this->categoryEnabled 	 	= get_field($optionKeyBase.'_categories', 'option');
 		$this->tagEnabled       	= get_field($optionKeyBase.'_tags', 'option');

 	}

	public function renderName() {

		// custom name set by user
		if( $this->alternateNameSet && !$this->alternateName == '' ) {
			return $this->alternateName;
		}

		// default name set in post type
		return $this->name();

	}

}
