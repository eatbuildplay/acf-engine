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
     2
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
     'edit.php?post_type=acfe_post_type',
   );

   \add_submenu_page(
     ACF_ENGINE_TEXT_DOMAIN,
     'Taxonomies',
     'Taxonomies',
     'edit_posts',
     'edit.php?post_type=acfe_taxonomy',
   );

   \add_submenu_page(
     ACF_ENGINE_TEXT_DOMAIN,
     'Options Pages',
     'Options Pages',
     'edit_posts',
     'edit.php?post_type=acfe_options_page',
   );

   \add_submenu_page(
     ACF_ENGINE_TEXT_DOMAIN,
     'Block Types',
     'Block Types',
     'edit_posts',
     'edit.php?post_type=acfe_block_type',
   );

   \add_submenu_page(
     ACF_ENGINE_TEXT_DOMAIN,
     'Templates',
     'Templates',
     'edit_posts',
     'edit.php?post_type=acfe_template',
   );

   \add_submenu_page(
     ACF_ENGINE_TEXT_DOMAIN,
     'Components',
     'Components',
     'edit_posts',
     'edit.php?post_type=acfe_component',
   );

  }

  public function pageDashboard() {

    print 'DASHBOARD ACF ENGINE';

  }

  public function pagePostTypes() {

    print 'DASHBOARD POST TYPES';

  }

  public function pageTaxonomies() {

    print 'DASHBOARD TAXES';

  }

  public function pageSettingsPages() {

    print 'SETTINGS PAGES';

  }

}
