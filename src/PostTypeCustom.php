<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class PostTypeCustom extends PostType {

	public $key;
	public $name;

	public function key() {
		return $this->key;
	}

	public function name() {
		return $this->name;
	}

}
