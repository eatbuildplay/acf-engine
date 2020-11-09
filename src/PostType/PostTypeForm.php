<?php

namespace AcfEngine\Core\PostType;

if (!defined('ABSPATH')) {
	exit;
}

class PostTypeForm extends PostType {

	public function key() {
		return 'form';
	}

	public function nameSingular() {
		return 'Form';
	}

	public function showInMenu() {
		return false;
	}

	public function supports() {
		return [''];
	}

}
