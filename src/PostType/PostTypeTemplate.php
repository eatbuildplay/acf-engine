<?php

namespace AcfEngine\Core\PostType;

if (!defined('ABSPATH')) {
	exit;
}

class PostTypeTemplate extends PostType {

  public function key() {
		return 'template';
	}

	public function nameSingular() {
		return 'Template';
	}

	public function namePlural() {
		return 'Templates';
	}

	public function showInMenu() {
		return false;
	}

	public function supports() {
		return ['editor'];
	}

}
