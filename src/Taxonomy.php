<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class Taxonomy {

  protected $prefix = 'acfg_';
  public 		$key;
	public 		$description;
	public 		$objectType = [];

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

		$key = $this->getPrefixedKey();
		$objectType = $this->objectType();
		$objectType = explode(',', $objectType);

		$objectTypePrefixed = [];
		foreach( $objectType as $ot ) {
			$objectTypePrefixed[] = 'acfe_' . $ot;
		}

		$args = $this->args();

    $reg = register_taxonomy(
      $key,
      $objectTypePrefixed,
      $args
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

	public function setDescription( $v ) {
		$this->description = $v;
	}

	public function description() {
		return $this->description;
	}

	public function setPublic( $v ) {
		$this->public = $v;
	}

	public function public() {
		return $this->public;
	}

	public function setPublicQueryable( $v ) {
		$this->publicQueryable = $v;
	}

	public function Queryable() {
		return $this->publicQueryable;
	}

	// hierarchical
	// show_ui
	// show_in_menu
	// show_in_nav_menus
	// show_in_rest
	// rest_base
	// rest_controller_class
	// show_tagcloud
	// show_admin_column
	// meta_box_cb
	// meta_box_sanitize_cb
	// capabilities
	// rewrite
	// query_var
	// update_count_callback
	// default_term

}
