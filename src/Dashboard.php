<?php

namespace AcfEngine\Core;

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Dashboard {

  public function render() {

    require_once( ACF_ENGINE_PATH . 'templates/dashboard/main.php' );

  }

}
