<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class PostTypePostType extends PostType {

	public function key() {
		return 'post_type';
	}

	public function name() {
		return 'Post Type';
	}

	public function showInMenu() {
		return false;
	}

	public function supports() {
		return [''];
	}

}
