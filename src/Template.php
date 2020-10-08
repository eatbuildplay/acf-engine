<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class Template {

  protected $prefix = 'acfe_';
  public 		$key;

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

}
