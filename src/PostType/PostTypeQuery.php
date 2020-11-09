<?php

namespace AcfEngine\Core\PostType;

if (!defined('ABSPATH')) {
	exit;
}

class PostTypeQuery extends PostType {

	public function key() {
		return 'query';
	}

	public function nameSingular() {
		return 'Query';
	}

	public function showInMenu() {
		return false;
	}

	public function supports() {
		return [''];
	}

}
