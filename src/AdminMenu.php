<?php

namespace AcfEngine\Core;

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
     ACF_ENGINE_TEXT_DOMAIN,
     'ACF Engine',
     'Dashboard',
     'edit_posts',
     ACF_ENGINE_TEXT_DOMAIN
   );

   \add_submenu_page(
     ACF_ENGINE_TEXT_DOMAIN,
     'Post Types',
     'Post Types',
     'edit_posts',
     ACF_ENGINE_TEXT_DOMAIN . '-post-types',
     [$this, 'pagePostTypes']
   );

   \add_submenu_page(
     ACF_ENGINE_TEXT_DOMAIN,
     'Taxonomies',
     'Taxonomies',
     'edit_posts',
     ACF_ENGINE_TEXT_DOMAIN . '-taxonomies',
     [$this, 'pageTaxonomies']
   );

  }

  public function pageDashboard() {

    print 'DASHBOARD ACF ENGINE';

  }

}
