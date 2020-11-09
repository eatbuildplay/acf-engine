<?php

namespace AcfEngine\Core\PostType;

if (!defined('ABSPATH')) {
	exit;
}

class PostTypeComponent extends PostType {

  public function key() {
		return 'component';
	}

	public function nameSingular() {
		return 'Component';
	}

	public function namePlural() {
		return 'Components';
	}

	public function showInMenu() {
		return false;
	}

	public function supports() {
		return [''];
	}

}
