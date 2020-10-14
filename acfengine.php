<?php

/**
 *
 * Plugin Name: ACF Engine
 * Plugin URI: https://eatbuildplay.com/plugins/acfengine/
 * Description: Provides data-driven solutions powered by ACF including custom post types, custom taxonomies, options pages and rendering templates.
 * Version: 1.0.0
 * Author: Casey Milne, Eat/Build/Play
 * Author URI: https://eatbuildplay.com
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 */

namespace AcfEngine;
use AcfEngine\Core\AdminMenu;
use AcfEngine\Core\PostTypePostType;
use AcfEngine\Core\PostTypeCustom;
use AcfEngine\Core\PostTypeManager;
use AcfEngine\Core\TaxonomyManager;
use AcfEngine\Core\TaxonomyCustom;
use AcfEngine\Core\TaxonomyTaxonomy;
use AcfEngine\Core\OptionsPageManager;
use AcfEngine\Core\ComponentManager;
use AcfEngine\Core\BlockTypeManager;
use AcfEngine\Core\TemplateManager;
use AcfEngine\Core\RenderCodeManager;
use AcfEngine\Core\Import;

define( 'ACF_ENGINE_PATH', plugin_dir_path( __FILE__ ) );
define( 'ACF_ENGINE_DATA_PATH', ACF_ENGINE_PATH . 'data/' );
define( 'ACF_ENGINE_URL', plugin_dir_url( __FILE__ ) );
define( 'ACF_ENGINE_VERSION', '1.0.0' );
define( 'ACF_ENGINE_TEXT_DOMAIN', 'acf-engine');

class Plugin {

  public function __construct() {

    // integrate freemium
    $this->freemius();

    // embed acf
    require_once( ACF_ENGINE_PATH . 'vendor/acf/advanced-custom-fields-pro/acf.php' );

    // embed acf code field
    require_once( ACF_ENGINE_PATH . 'vendor/acf-code-field/acf-code-field.php' );

    // setup autoloader
    spl_autoload_register( [$this, 'autoloader'] );

    // setup local acf json save
    // add_filter('acf/settings/save_json', [$this, 'acfSaveLocal'], 99);
    add_filter('acf/settings/load_json', [$this, 'acfLoadLocal'], 99);

    // init admin menu
    new AdminMenu();

    // init importer
    $import = new Import();
    $import->init();

    // init the post type manager
    $ptm = new PostTypeManager();
    $ptm->setup();

    // init taxonomy manager
    $tm = new TaxonomyManager();
    $tm->setup();

    // init options page manager
    $opm = new OptionsPageManager();
    $opm->setup();

    // init component manager
    $opm = new ComponentManager();
    $opm->setup();

    // init block type manager
    $opm = new BlockTypeManager();
    $opm->setup();

    // init template manager
    $opm = new TemplateManager();
    $opm->setup();

    $rcm = new RenderCodeManager();
    $rcm->setup();

    /* enqueue scripts */
    add_action('wp_enqueue_scripts', [$this, 'scripts']);

  }

  public function acfSaveLocal( $path ) {
    return ACF_ENGINE_PATH . 'data/fields';
  }

  public function acfLoadLocal( $paths ) {
    $paths[] = ACF_ENGINE_PATH . 'fields/';
    return $paths;
  }

  public function autoloader( $className ) {

    if ( 0 !== strpos( $className, 'AcfEngine\Core' ) ) {
      return;
    }

    // strip the namespace leaving only the final class name
    $className = str_replace('AcfEngine\Core\\', '', $className);
    require( ACF_ENGINE_PATH . 'src/' . $className . '.php' );

  }

  public function scripts() {

    wp_enqueue_script(
      'acfg-js',
      ACF_ENGINE_URL . 'scripts/js/acfg.js',
      array( 'jquery' ),
      '1.0.0',
      true
    );

    wp_enqueue_style(
      'acfg-css',
      ACF_ENGINE_URL . 'scripts/css/acfg.css',
      array(),
      true
    );

  }

    // Create a helper function for easy SDK access.
    public function freemius() {

      global $afcg_freemius;

      if ( ! isset( $afcg_freemius ) ) {

        // Include Freemius SDK.
        require_once ACF_ENGINE_PATH . 'vendor/freemius/start.php';

        $afcg_freemius = fs_dynamic_init( array(
          'id'                  => '7042',
          'slug'                => 'acfengine',
          'premium_slug'        => 'acf-engine-premium',
          'type'                => 'plugin',
          'public_key'          => 'pk_1cfe4c350f5a0a42d9f2b9960fce6',
          'is_premium'          => false,
          'has_addons'          => false,
          'has_paid_plans'      => true,
          'menu' => array(
            'slug'           => 'acf-engine',
            'account'        => false,
            'contact'        => false,
            'support'        => false,
          ),
          'secret_key'          => 'sk_rcg1N_(M~ga=dy*_6C<XyrqomrW~K',
        )
      );
    }

    return $afcg_freemius;

  }

  public function activation() {

    $dataDirs = [
      'block-types',
      'components',
      'fields',
      'forms',
      'options-pages',
      'post-types',
      'render-code',
      'taxonomies',
      'templates'
    ];

    $dataPath = ACF_ENGINE_PATH . 'data/';

    foreach( $dataDirs as $dirName ) {
      $dirPath = $dataPath . $dirName;
      if( !file_exists( $dirPath )) {
        mkdir( $dirPath );
      }
    }

  }

}

new Plugin();

/*
 * Activation and deactivation hooks
 */
register_activation_hook(__FILE__, '\AcfEngine\Plugin::activation');
