<?php

namespace AcfEngine;

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class AdminMenu {

  public function __construct() {

    $this->init();

  }

  public function init() {

    add_action('admin_menu', [$this, 'menu']);

  }

  public function menu() {

    \add_menu_page(
     'ACF Engine',
     'ACF Engine',
     'edit_posts',
     ACF_ENGINE_TEXT_DOMAIN,
     [$this, 'pageDashboard'],
     'dashicons-welcome-learn-more',
     25
   );

   \add_submenu_page(
     'saber-dashboard',
     'ACF Engine',
     'Dashboard',
     'edit_posts',
     ACF_ENGINE_TEXT_DOMAIN
   );

  }

  public function pageDashboard() {

    print 'DASHBOARD ACF ENGINE';

  }

}
