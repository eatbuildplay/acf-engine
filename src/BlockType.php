<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class BlockType {

  protected $prefix = 'acfe_';
	protected $postType = 'acfe_block_type';
  public 		$key;
	protected $renderCode;
	protected $category;
	public 		$renderTemplate;
	public 		$renderCallback;

  public function init() {
		$this->parseArgs();
		$this->register();
	}

  /*
   *
   * Block registration
   * https://www.advancedcustomfields.com/resources/acf_register_block_type/
   *
   */
  public function register() {

		$args = [
			'name'              => $this->getPrefixedKey(),
			'title'             => $this->title(),
			'description'       => $this->description(),
			'category'          => 'formatting',
			'mode'							=> 'preview',
			'supports'					=> [
				'align' => true,
        'mode' 	=> true,
        'jsx' 	=> true
			]
		];

		if( $this->renderTemplate() ) {
			$args['render_template'] = $this->renderTemplate();
		} elseif( $this->renderCallback() ) {
			$args['render_callback'] = $this->renderCallback();
		} else {
			$args['render_callback'] = [$this, 'defaultCallback'];
		}

    acf_register_block_type( $args );

	}

	public function setRenderTemplate( $v ) {
		$this->renderTemplate = $v;
	}

	public function renderCallback() {
		return $this->renderCallback;
	}

	public function setRenderCallback( $v ) {
		$this->renderCallback = $v;
	}

	public function renderTemplate() {
		return $this->renderTemplate;
	}

	/*
	 * Default callback registered when blocks created
	 * Uses the render_code field (user written code)
	 */
	public function defaultCallback( $block, $content = '', $isPreview, $editorPostId ) {

		$filename = str_replace('acf/acfe-', '', $block['name']) . '.json';
		$filename = str_replace('-', '_', $filename);

		$json = file_get_contents( ACF_ENGINE_PATH . 'data/block-types/' . $filename );
		$data = json_decode( $json );

		$code = get_field( 'render_code', $data->id );
		print $code;

	}

  public function parseArgs() {



	}

  public function args() {
    return $this->defaultArgs();
  }

  public function defaultArgs() {

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

	public function setDescription( $v ) {
		$this->description = $v;
	}

	public function description() {
		return $this->description;
	}

	public function setRenderCode( $v ) {
		$this->renderCode = $v;
	}

	public function renderCode() {
		return $this->renderCode;
	}

	public function setCategory( $v ) {
		$this->category = $v;
	}

	public function category() {
		return $this->category;
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
		update_field( 'title', $this->title, $postId );
		update_field( 'description', $this->description, $postId );

		return $postId;

	}

}
