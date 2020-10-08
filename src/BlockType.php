<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class BlockType {

  protected $prefix = 'acfe_';
  public 		$key;

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

    acf_register_block_type(array(
      'name'              => $this->getPrefixedKey(),
      'title'             => $this->title(),
      'description'       => $this->description(),
      'render_callback'   => [$this, 'callback'],
      'category'          => 'formatting',
    ));

	}

	public function callback() {
		print 'AWESOMEEEE FDFDSFDS097219803 728037 2139';
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
