<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class PostTypeRenderCode extends PostType {

  public function key() {
		return 'render_code';
	}

	public function nameSingular() {
		return 'Render Code';
	}

	public function namePlural() {
		return 'Render Code';
	}

	public function showInMenu() {
		return false;
	}

	public function supports() {
		return [''];
	}

}
