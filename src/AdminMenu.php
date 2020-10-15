<?php

namespace AcfEngine\Core;

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class AdminMenu {

  public function __construct() {

    $this->init();

    acf_add_options_sub_page(array(
      'page_title'  => __('ACF Engine Settings'),
      'menu_title'  => __('Settings'),
      'parent_slug' => ACF_ENGINE_TEXT_DOMAIN,
    ));

  }

  public function init() {

    add_action('admin_menu', [$this, 'menu']);

    /* highlight ACF Engine main menu */
    add_filter('parent_file', [$this, 'setParentMenu'], 10, 2 );

  }

  public function setParentMenu( $parent_file ) {

    global $submenu_file, $current_screen;

    $cpts = [
      'acfe_post_type',
      'acfe_taxonomy',
      'acfe_options_page',
      'acfe_block_type',
      'acfe_template',
      'acfe_component',
      'acfe_render_code'
    ];

    if( in_array($current_screen->post_type, $cpts)) {
      $parent_file = 'acf-engine';
    }

    return $parent_file;

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
     'Field Groups',
     'Field Groups',
     'edit_posts',
     'edit.php?post_type=acf-field-group',
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
     'Render Code',
     'Render Code',
     'edit_posts',
     'edit.php?post_type=acfe_render_code',
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
    $d = new Dashboard();
    $d->render();
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
