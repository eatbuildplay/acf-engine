<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class OptionsPage {

  protected $prefix = 'acfe_';
  public 		$key;

  public function init() {
		$this->parseArgs();
		$this->register();
	}

  /*
   *
   * Options Page Registration
   *
   *
   */
  public function register() {

    acf_add_options_page(array(
  		'page_title' 	=> 'Theme General Settings',
  		'menu_title'	=> 'Theme Settings',
  		'menu_slug' 	=> 'theme-general-settings',
  		'capability'	=> 'edit_posts',
  		'redirect'		=> false
  	));

	}

  public function parseArgs() {


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
