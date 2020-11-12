<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class Query {

  protected $prefix = 'acfg_';
  protected $postType = 'acfg_query';
  protected	$key;

	protected $queryPostType;
	protected $limit;

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

	public function setQueryPostType( $v ) {
		$this->queryPostType = $v;
	}

	public function queryPostType() {
		return $this->queryPostType;
	}

	public function setLimit( $v ) {
		$this->limit = $v;
	}

	public function limit() {
		return $this->limit;
	}

	public function setAuthor( $v ) {
		$this->author = $v;
	}

	public function author() {
		return $this->author;
	}

	public function setMetaQueries( $v ) {
		$this->metaQueries = $v;
	}

	public function metaQueries() {
		return $this->metaQueries;
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

	/*
	 * Run the query
	 */
	public function run() {

		/*
		 * Basic arguments
		 */
		$args = [
			'post_type' 	=> $this->queryPostType(),
			'numberposts' => $this->limit()
		];

		/*
		 * Author handling
		 */
		if( $this->author() ) {

			if( $this->author() == '{{CurrentUser}}' ) {
				$author = get_current_user_id();
			} else {
				$author = $this->author();
			}

			$args['author'] = $author;

		}

		/*
		 * Meta queries
		 */
		if( $this->metaQueries() ) {

			$args['meta_query'] = [];
			foreach( $this->metaQueries() as $mq ) {

				if( $mq->value == '{{CURRENT_POST_ID}}' ) {
					global $post;
					$mq->value = $post->ID;
				}
				$metaQuery = [];
				$metaQuery['key'] 			= $mq->key;
				$metaQuery['value'] 		= $mq->value;
				$metaQuery['compare'] 	= $mq->compare;
				$metaQuery['type'] 	= $mq->type;
				$args['meta_query'][] = $metaQuery;
			}

		}

		$posts = get_posts( $args );
		return $posts;

	}

}
