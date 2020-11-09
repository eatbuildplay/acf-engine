<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class Form {

  protected $prefix = 'acfg_';
	protected $postType = 'acfg_form';
  protected	$key;
	protected $postId;

  public function init() {
		$this->parseArgs();
		$this->register();
	}

  /*
   *
   * Form registration
   *
   */
  public function register() {

		$args = $this->args();
		acf_register_form( $args );

	}


  public function parseArgs() {


	}

  public function args() {
    return $this->defaultArgs();
  }

  public function defaultArgs() {

		$args = [
			'id' 			=> $this->key(),
			'post_id' => $this->postId()
		];



		return $args;

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

	public function setPostId( $v ) {
		$this->postId = $v;
	}

	public function postId() {
		return $this->postId;
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
				'post_title'     => $this->title,
				'post_status'    => 'publish'
			]
		);

		/*
		 * update acf fields with meta data
		 */
		update_field( 'key', $this->key, $postId );

		return $postId;

	}

}
