<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class Template {

  protected $prefix = 'acfg_';
	protected $postType = 'acfg_post_type';
  protected $key;
	protected $title;

  public function init() {
		$this->parseArgs();
		$this->register();
	}

  /*
   *
   * Template registration
   *
   */
  public function register() {

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
    return [];
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

	public function setTitle( $v ) {
		$this->title = $v;
	}

	public function title() {
		return $this->title;
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
		update_field( 'key', $this->key, $postId );
		update_field( 'title', $this->title(), $postId );

		return $postId;

	}

	public function postType() {
		return $this->postType;
	}

}
