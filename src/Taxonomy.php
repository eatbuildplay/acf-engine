<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class Taxonomy {

  protected $prefix = 'acfe_';
  public 		$key;

  public function init() {
		$this->parseArgs();
		$this->register();
	}

  /*
   *
   * Taxonomy registration
   * https://developer.wordpress.org/reference/functions/register_taxonomy/
   *
   */
  public function register() {
    $reg = register_taxonomy(
      $this->getPrefixedKey(),
      $this->objectType(),
      $this->args()
    );
	}

  public function setObjectType( $v ) {
    $this->objectType = $v;
  }

  public function objectType() {
    return $this->objectType;
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
    return [
      'label' => 'Freddy'
    ];
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
