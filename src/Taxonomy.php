<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class Taxonomy {

	protected $prefix = 'acfg_';
	protected $postType = 'acfg_taxonomy';
	protected $key;
	protected $title;
	protected $nameSingular;
	protected $namePlural;
	protected $labels = [];
	protected $description;
	protected $objectType = [];
	protected $public = true;
	protected $publiclyQueryable = true;
	protected $hierarchical = false;
	protected $showUi = true;
	protected $showInMenu = true;
	protected $showInNavMenus = true;
	protected $showInRest = true; // default true to better support gutenberg
	protected $restBase;
	protected $restControllerClass = 'WP_REST_Terms_Controller';
	protected $showTagcloud = true;
	protected $showInQuickEdit = true;
	protected $showAdminColumn = false;
    protected $capabilities = [];
	protected $rewrite;
	protected $defaultTerm;


  public function init() {
		$this->parseArgs();
		$this->register();
	}

  /*
   *
   * Taxonomy registration
   * https://developer.wordpress.org/reference/functions/register_taxonomy/
   *
   */
  public function register() {

		$key = $this->getPrefixedKey();
		$objectType = $this->objectType();
		$objectType = str_replace( '\'', '', $objectType );

		if( !is_array( $objectType )) {
			$objectType = explode(',', $objectType);
		}

		$objectTypePrefixed = [];
		foreach( $objectType as $ot ) {
			$objectTypePrefixed[] = 'acfg_' . $ot;
		}

		$args = $this->args();
    $reg = register_taxonomy(
      $key,
      $objectTypePrefixed,
      $args
    );

	}

  public function setObjectType( $v ) {
    $this->objectType = $v;
  }

  public function objectType() {
    return $this->objectType;
  }

  public function parseArgs() {

    if( !$this->objectType ) {
      $this->objectType = 'post';
    }

    if( !$this->namePlural ) {
        $this->namePlural = $this->nameSingular() . 's';
    }
  }

  public function args() {
    return $this->defaultArgs();
  }

  public function defaultArgs() {
	$args = [
		'description'         => __($this->description(), 'acf-engine'),
		'labels'              => $this->labels(),
		'public'              => $this->public(),
		'hierarchical'        => $this->hierarchical(),
		'show_ui'             => $this->showUi(),
		'show_in_menu'        => $this->showInMenu(),
		'show_in_rest'        => $this->showInRest(),
		'rest_base'           => $this->restBase(),
		'show_tagcloud'		  => $this->showTagcloud(),
		'show_in_quick_edit'  => $this->showInQuickEdit(),
		'show_admin_column'   => $this->showAdminColumn(),
		'capabilities'        => $this->capabilities(),
		'rewrite'             => $this->rewrite(),
		'default_term'		  => $this->defaultTerm()
	];

	if( $this->publiclyQueryable() ) {
		$args['publicly_queryable'] = $this->publiclyQueryable();
	}

	if( $this->showInNavMenus() ) {
		$args['show_in_nav_menus'] = $this->showInNavMenus();
	}
	if( $this->restControllerClass() ) {
		$args['rest_controller_class'] 	= $this->restControllerClass();
	}

	return $args;
  }

  public function labels() {
	return $this->defaultLabels();
  }

  public function defaultLabels() {

	return [
		'name'                  => $this->nameSingular(),
		'singular_name'         => $this->nameSingular(),
		'menu_name'             => $this->nameSingular(),
		'all_items'             => __('All ', 'acf-engine') . $this->namePlural(),
        'edit_item'             => __('Edit ', 'acf-engine'). $this->nameSingular(),
        'view_item'             => __('View ', 'acf-engine'). $this->nameSingular(),
        'update_item'           => __('Update ', 'acf-engine'). $this->nameSingular(),
		'add_new_item'          => __('Add New ', 'acf-engine'). $this->nameSingular(),
        'new_item_name'         => __('New '. $this->nameSingular() .'Name', 'acf-engine'),
        'parent_item'           => __('Parent ', 'acf-engine') . $this->nameSingular(),
        'parent_item_colon'     => __('Parent '. $this->nameSingular() .':', 'acf-engine'),
        'search_items'          => __('Search ', 'acf-engine'). $this->nameSingular(),
        'popular_items'         => __('Popular ', 'acf-engine'). $this->namePlural(),
        'separate_items_with_commas' => __('Separate '. $this->namePlural() .' with commas ', 'acf-engine'),
        'add_or_remove_items'   => __('Add or remove ', 'acf-engine'). $this->namePlural(),
        'choose_from_most_used' => __('Choose from the most used ', 'acf-engine'). $this->namePlural(),
        'not_found'             => __('No '. $this->nameSingular() .' found', 'acf-engine'),
        'back_to_items'         => __('← Back to ', 'acf-engine'). $this->namePlural(),
	];

  }

  public function getPrefixedKey() {
		return $this->prefix . $this->key();
	}

  public function setKey( $v ) {
		$this->key = $v;
	}

	public function key() {
		return $this->key;
	}

	public function setTitle( $v ) {
		$this->title = $v;
	}

	public function title() {
		return $this->title;
	}

    public function setNameSingular( $v ) {
        $this->nameSingular = $v;
    }

    public function nameSingular() {
        return $this->nameSingular;
    }

    public function setNamePlural( $v ) {
        $this->namePlural = $v;
    }

    public function namePlural() {
        return $this->namePlural;
    }

	public function setLabels( $v ) {
		$this->labels = $v;
	}

	public function setDescription( $v ) {
		$this->description = $v;
	}

	public function description() {
		return $this->description;
	}

	public function setPublic( $v ) {
		$this->public = $v;
	}

	public function public() {
		return $this->public;
	}

	public function setPubliclyQueryable( $v ) {
		$this->publiclyQueryable = $v;
	}

	public function publiclyQueryable() {
		return $this->publiclyQueryable;
	}

	public function setHierarchical( $v ) {
		$this->hierarchical = $v;
	}

	public function hierarchical() {
		return $this->hierarchical;
	}

	public function setShowUi( $v ) {
		$this->showUi = $v;
	}

	public function showUi() {
		return $this->showUi;
	}

	public function setShowInMenu( $v ) {
		$this->showInMenu = $v;
	}

	public function showInMenu() {
		return $this->showInMenu;
	}

	public function setShowInNavMenus( $v ) {
		$this->showInNavMenus = $v;
	}

	public function showInNavMenus() {
		return $this->showInNavMenus;
	}

	public function setShowInRest( $v ) {
		$this->showInRest = $v;
	}

	public function showInRest() {
		return $this->showInRest;
	}

	public function setRestBase( $v ) {
		$this->restBase = $v;
	}

	public function restBase() {
		return $this->restBase;
	}

	public function setRestControllerClass( $v ) {
		$this->restControllerClass = $v;
	}

	public function restControllerClass() {
		return $this->restControllerClass;
	}

	public function setShowTagcloud( $v ) {
		$this->showTagcloud = $v;
	}

	public function showTagcloud() {
		return $this->showTagcloud;
	}

	public function setShowInQuickEdit( $v ) {
		$this->showInQuickEdit = $v;
	}

	public function showInQuickEdit() {
		return $this->showInQuickEdit;
	}

	public function setShowAdminColumn( $v ) {
		$this->showAdminColumn = $v;
	}

	public function showAdminColumn() {
		return $this->showAdminColumn;
	}

	public function setCapabilities( $v ) {
		$this->capabilities = [$v];
	}

	public function capabilities() {
		return [$this->capabilities];
	}

	public function setRewrite( $v ) {
		$this->rewrite = $v;
	}

	public function rewrite() {
		return $this->rewrite;
	}

	public function setDefaultTerm( $v ) {
		$this->defaultTerm = $v;
	}

	public function defaultTerm() {
		return $this->defaultTerm;
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
 				'post_title'     => $this->title(),
 				'post_status'    => 'publish'
 			]
 		);

 		/*
 		 * update acf fields with meta data
 		 */
 		update_field( 'key', $this->key(), $postId );
		update_field( 'title', $this->title(), $postId );
		update_field( 'labels', $this->labels(), $postId );
		update_field( 'description', $this->description(), $postId );
		update_field( 'object_type', $this->objectType(), $postId );
		update_field( 'public', $this->public(), $postId );
		update_field( 'publicly_queryable', $this->publiclyQueryable(), $postId );
		update_field( 'hierarchical', $this->hierarchical(), $postId );
		update_field( 'show_ui', $this->showUi(), $postId );
		update_field( 'show_in_menu', $this->showInMenu(), $postId );
		update_field( 'show_in_nav_menus', $this->showInNavMenus(), $postId );
		update_field( 'show_in_rest', $this->showInRest(), $postId );
		update_field( 'rest_base', $this->restBase(), $postId );
		update_field( 'rest_controller_class', $this->restControllerClass(), $postId );
		update_field( 'show_tagcloud', $this->showTagcloud(), $postId );
		update_field( 'show_in_quick_edit', $this->showInQuickEdit(), $postId );
		update_field( 'show_admin_column', $this->showAdminColumn(), $postId );
		update_field( 'capabilities', $this->capabilities(), $postId );
		update_field( 'rewrite', $this->rewrite(), $postId );
		update_field( 'default_term', $this->defaultTerm(), $postId );

 		return $postId;

 	}

	public function postType() {
		return $this->postType;
	}



}
