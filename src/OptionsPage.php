<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class OptionsPage {

	protected $key;
  protected $prefix = 'acfg_';
	protected $postType = 'acfg_options_page';
	protected $pageTitle;
	protected $menuTitle;
	protected $menuSlug;
	protected $capability;
	protected $position;
	protected $parentSlug;
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

		$args = [
			'page_title' 			=> $this->pageTitle(),
  		'menu_title'			=> $this->menuTitle(),
  		'menu_slug' 			=> $this->getPrefixedSlug(),
			'icon_url'				=> $this->iconUrl(),
  		'redirect'				=> $this->redirect(),
			'autoload'				=> $this->autoload(),
			'update_button'		=> $this->updateButton(),
			'updated_message' => $this->updatedMessage()
		];

		if( $this->parentSlug() ) {
			$args['parent_slug'] = $this->parentSlug();
		}

		if( $this->capability() ) {
			$args['capability'] = $this->capability();
		}

		if( $this->postId() ) {
			$args['post_id'] = $this->postId();
		}

		if( $this->position() ) {
			$args['position'] = $this->position();
		}

    acf_add_options_page( $args );

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

	public function capability() {
		return $this->capability;
	}

	public function setCapability( $v ) {
		$this->capability = $v;
	}

	public function setPosition( $v ) {
		$this->position = $v;
	}

	public function position() {
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
		return $this->prefix . $this->menuSlug();
	}

	public function setMenuSlug( $v ) {
		$this->menuSlug = $v;
	}

	public function menuSlug() {
		return $this->menuSlug;
	}

	public function postType() {
		return $this->postType;
	}

	public function import() {

		/*
		 * insert into db with create post
		 */
		$postId = wp_insert_post(
			[
				'post_type'      => $this->postType(),
				'post_title'     => $this->menuSlug,
				'post_status'    => 'publish'
			]
		);

		/*
		 * update acf fields with meta data
		 */
		update_field( 'menu_slug', $this->menuSlug, $postId );
		update_field( 'page_title', $this->pageTitle, $postId );
		update_field( 'menu_title', $this->menuTitle, $postId );
		update_field( 'capability', $this->capability, $postId );
		update_field( 'position', $this->position, $postId );
		update_field( 'parent_slug', $this->parentSlug, $postId );
		update_field( 'icon_url', $this->iconUrl, $postId );
		update_field( 'redirect', $this->redirect, $postId );
		update_field( 'post_id', $this->postId, $postId );
		update_field( 'autoload', $this->iconUrl, $postId );
		update_field( 'update_button', $this->updateButton, $postId );
		update_field( 'updated_message', $this->updatedMessage, $postId );

	}

}
