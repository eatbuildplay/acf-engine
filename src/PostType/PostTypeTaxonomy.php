<?php

namespace AcfEngine\Core\PostType;

if (!defined('ABSPATH')) {
	exit;
}

class PostTypeTaxonomy extends PostType {

  public function key() {
		return 'taxonomy';
	}

	public function nameSingular() {
		return 'Taxonomy';
	}

	public function namePlural() {
		return 'Taxonomies';
	}

	public function showInMenu() {
		return false;
	}

	public function supports() {
		return [''];
	}

}
