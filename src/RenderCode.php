<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class RenderCode {

  protected $prefix = 'acfg_';
  public 		$key;
	public 		$title;

  public function init() {
		$this->parseArgs();
		$this->register();
	}

  /*
   *
   * Render code registration
   *
   */
  public function register() {

		$args = [
			'name'              => $this->getPrefixedKey(),
			'title'             => $this->title(),
		];

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
