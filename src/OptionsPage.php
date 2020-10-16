<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class OptionsPage {

	protected $key;
  protected $prefix = 'acfg-';
	protected $pageTitle;
	protected $menuTitle;
	protected $menuSlug;
	protected $capability;
	protected $position;
	protected $parenSlug;
	protected $iconUrl;
	protected $redirect;
	protected $postId;
	protected $autoload;
	protected $updateButton;
	protected $updatedMessage;

  public function init() {
		$this->parseArgs();
		$this->register();
	}

  /*
   *
   * Options Page Registration
	 *
   */
  public function register() {

    acf_add_options_page(array(
  		'page_title' 	=> $this->pageTitle(),
  		'menu_title'	=> $this->menuTitle(),
  		'menu_slug' 	=> $this->getPrefixedSlug(),
  		'capability'	=> 'edit_posts',
  		'redirect'		=> false
  	));

	}

	public function setKey( $v ) {
		$this->key = $v;
	}

	public function key() {
		return $this->key;
	}

	public function setPageTitle( $v ) {
		$this->pageTitle = $v;
	}

	public function pageTitle() {
		return $this->pageTitle;
	}

	public function setMenuTitle( $v ) {
		$this->menuTitle = $v;
	}

	public function menuTitle() {
		return $this->menuTitle;
	}

	public function setCapability( $v ) {
		$this->capability = $v;
	}

	public function menuCapability() {
		return $this->capability;
	}

	public function setCapability( $v ) {
		$this->capability = $v;
	}

	public function menuCapability() {
		return $this->capability;
	}

	public function setPosition( $v ) {
		$this->position = $v;
	}

	public function menuPosition() {
		return $this->position;
	}

	public function setParentSlug( $v ) {
		$this->parentSlug = $v;
	}

	public function parentSlug() {
		return $this->parentSlug;
	}

	public function setIconUrl( $v ) {
		$this->iconUrl = $v;
	}

	public function iconUrl() {
		return $this->parentSlug;
	}

	public function setIconUrl( $v ) {
		$this->iconUrl = $v;
	}

	public function iconUrl() {
		return $this->parentSlug;
	}

	public function setRedirect( $v ) {
		$this->redirect = $v;
	}

	public function redirect() {
		return $this->redirect;
	}

	public function setPostId( $v ) {
		$this->postId = $v;
	}

	public function postId() {
		return $this->postId;
	}

	public function setAutoload( $v ) {
		$this->autoload = $v;
	}

	public function autoload() {
		return $this->autoload;
	}

	public function setUpdateButton( $v ) {
		$this->updateButton = $v;
	}

	public function updateButton() {
		return $this->updateButton;
	}

	public function setUpdatedMessage( $v ) {
		$this->updatedMessage = $v;
	}

	public function updatedMessage() {
		return $this->updatedMessage;
	}

  public function parseArgs() {

		if( !$this->menuTitle ) {
			$this->menuTitle = $this->pageTitle;
		}

	}

  public function args() {
    return $this->defaultArgs();
  }

  public function defaultArgs() {
    return [];
  }

  public function getPrefixedSlug() {
		return $this->prefix . $this->slug();
	}

  public function setMenuSlug( $v ) {
		$this->menuSlug = $v;
	}

	public function menuSlug() {
		return $this->menuSlug;
	}

	public function setMenuSlug( $v ) {
		$this->menuSlug = $v;
	}

	public function menuSlug() {
		return $this->menuSlug;
	}

}
