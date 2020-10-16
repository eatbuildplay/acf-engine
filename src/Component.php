<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class Component {

  protected $prefix = 'acfg_';
  public 		$key;

  public function init() {
		$this->parseArgs();
		$this->register();
	}

  /*
   *
   * Component registration
   * https://developer.wordpress.org/reference/functions/register_taxonomy/
   *
   */
  public function register() {

    // add main menu item

    // add submenu items




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

  public function setKey( $value ) {
		$this->key = $value;
	}

	public function key() {
		return $this->key;
	}

}
