<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class Query {

  protected $prefix = 'acfg_';
  protected $postType = 'acfg_query';
  protected	$key;

  public function init() {
		$this->parseArgs();
		$this->register();
	}

  /*
   *
   * Query setup
   *
   */
  public function register() {


	}


  public function parseArgs() {


	}

  public function args() {
    return $this->defaultArgs();
  }

  public function defaultArgs() {

    $args = [];

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
