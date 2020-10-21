<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class Taxonomy {

  protected $prefix = 'acfg_';
	protected $postType = 'acfg_taxonomy';
  public 		$key;
	protected $labels = [];
	protected	$description;
	protected $objectType = [];
	protected $public;
	protected $publicQueryable;
	protected $hierarchical;
	protected $showUi;
	protected $showInMenu;
	protected $showInNavMenus;
	protected $showInRest;
	protected $restBase;
	protected $restControllerClass;
	protected $showTagcloud;
	protected $showInQuickEdit;
	protected $showAdminColumn;
	protected $metaBoxCb;
	protected $metaBoxSanitizeCb;
	protected $capabilities;
	protected $rewrite;
	protected $queryVar;
	protected $updateCountCallback;
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

	}

  public function args() {
    return $this->defaultArgs();
  }

  public function defaultArgs() {
    return [
      'label' => 'Freddy'
    ];
  }

  public function getPrefixedKey() {
		return $this->prefix . $this->key();
	}

  public function setKey( $value ) {
		$this->key = $value;
	}

	public function key() {
		return $this->key;
	}

	public function labels() {
		return $this->labels;
	}

	public function setLabels( $v ) {
		$this->labels = v;
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

	public function setPublicQueryable( $v ) {
		$this->publicQueryable = $v;
	}

	public function publicQueryable() {
		return $this->publicQueryable;
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

	public function setShowMenu( $v ) {
		$this->showMenu = $v;
	}

	public function showMenu() {
		return $this->showMenu;
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

	public function setControllerClass( $v ) {
		$this->controllerClass = $v;
	}

	public function controllerClass() {
		return $this->controllerClass;
	}

	public function setShowTagcloud( $v ) {
		$this->showTagcloud = $v;
	}

	public function showTagcloud() {
		return $this->showTagcloud;
	}

	public function setShowAdminColumn( $v ) {
		$this->showAdminColumn = $v;
	}

	public function showAdminColumn() {
		return $this->showAdminColumn;
	}

	public function setMetaBoxCb( $v ) {
		$this->metaBoxCb = $v;
	}

	public function metaBoxCb() {
		return $this->metaBoxCb;
	}

	public function setMetaBoxSanitizeCb( $v ) {
		$this->metaBoxSanitizeCb = $v;
	}

	public function metaBoxSanitizeCb() {
		return $this->metaBoxSanitizeCb;
	}

	public function setCapabilities( $v ) {
		$this->capabilities = $v;
	}

	public function capabilities() {
		return $this->capabilities;
	}

	public function setRewrite( $v ) {
		$this->rewrite = $v;
	}

	public function rewrite() {
		return $this->rewrite;
	}

	public function setQueryVar( $v ) {
		$this->queryVar = $v;
	}

	public function queryVar() {
		return $this->queryVar;
	}

	public function setUpdateCountCallback( $v ) {
		$this->updateCountCallback = $v;
	}

	public function updateCountCallback() {
		return $this->updateCountCallback;
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
 				'post_title'     => 'Imported Tax',
 				'post_status'    => 'publish'
 			]
 		);

 		/*
 		 * update acf fields with meta data
 		 */
 		update_field( 'key', $this->key, $postId );

 		return $postId;

 	}

	public function postType() {
		return $this->postType;
	}



}
