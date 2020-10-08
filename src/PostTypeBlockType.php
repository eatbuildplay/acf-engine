<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class PostTypeBlockType extends PostType {

  public function key() {
		return 'block_type';
	}

	public function nameSingular() {
		return 'Block Type';
	}

	public function namePlural() {
		return 'Block Types';
	}

	public function showInMenu() {
		return false;
	}

	public function supports() {
		return [''];
	}

}
