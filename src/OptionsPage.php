<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class OptionsPage {

  protected $prefix = 'acfe-';
  public 		$slug; // slug is used here as unique key
	public 		$pageTitle;
	public 		$menuTitle;

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
  		'page_title' 	=> $this->pageTitle(),
  		'menu_title'	=> $this->menuTitle(),
  		'menu_slug' 	=> $this->getPrefixedSlug(),
  		'capability'	=> 'edit_posts',
  		'redirect'		=> false
  	));

	}

	public function setPageTitle( $v ) {
		$this->pageTitle = $v;
	}

	public function pageTitle() {
		return $this->pageTitle;
	}

	public function setMenuTitle( $v ) {
		$this->menuTitle = $v;
	}

	public function menuTitle() {
		return $this->menuTitle;
	}

  public function parseArgs() {

		if( !$this->menuTitle ) {
			$this->menuTitle = $this->pageTitle;
		}

	}

  public function args() {
    return $this->defaultArgs();
  }

  public function defaultArgs() {
    return [];
  }

  public function getPrefixedSlug() {
		return $this->prefix . $this->slug();
	}

  public function setSlug( $v ) {
		$this->slug = $v;
	}

	public function slug() {
		return $this->slug;
	}

}
