<?php

namespace AcfEngine\Core\PostType;

if (!defined('ABSPATH')) {
	exit;
}

class PostTypeFilter extends PostType {

	public function key() {
		return 'filter';
	}

	public function nameSingular() {
		return 'Filter';
	}

	public function showInMenu() {
		return false;
	}

	public function supports() {
		return [''];
	}

}
