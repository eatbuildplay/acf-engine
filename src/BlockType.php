<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class BlockType {

  protected $prefix = 'acfe_';
  public 		$key;
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

}
