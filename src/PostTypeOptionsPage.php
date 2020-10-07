<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class PostTypeOptionsPage extends PostType {

  public function key() {
		return 'options_page';
	}

	public function nameSingular() {
		return 'Options Page';
	}

	public function namePlural() {
		return 'Options Pages';
	}

	public function showInMenu() {
		return false;
	}

	public function supports() {
		return [''];
	}

}
