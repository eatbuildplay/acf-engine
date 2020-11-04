<?php

/**
 *
 * Plugin Name: ACF Engine
 * Plugin URI: https://eatbuildplay.com/plugins/acfengine/
 * Description: Provides data-driven solutions powered by ACF including custom post types, custom taxonomies, options pages and rendering templates.
 * Version: 1.0.2
 * Author: Eat/Build/Play
 * Author URI: https://eatbuildplay.com
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @fs_premium_only /vendor/acf/, /vendor/acf-code-field/, /src/Component.php, /src/ComponentCustom.php, /src/ComponentManager.php, /src/RenderCode.php, /src/RenderCodeCustom.php, /src/RenderCodeManager.php
 * @fs_premium_only /src/Form.php, /src/FormCustom.php, /src/FormManager.php
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
use AcfEngine\Core\BlockType\BlockTypeManager;
use AcfEngine\Core\TemplateManager;
use AcfEngine\Core\RenderCodeManager;
use AcfEngine\Core\Import;

define( 'ACF_ENGINE_PATH', plugin_dir_path( __FILE__ ) );
define( 'ACF_ENGINE_URL', plugin_dir_url( __FILE__ ) );
define( 'ACF_ENGINE_VERSION', '1.0.1' );
define( 'ACF_ENGINE_TEXT_DOMAIN', 'acf-engine');

class Plugin {

  public function __construct() {

    // integrate freemium
    $this->freemius();

    /*
     * Only embed ACF for pro users
     */
    if ( $this->freemius()->is__premium_only() ) :

      // embed acf
      require_once( ACF_ENGINE_PATH . 'vendor/acf/advanced-custom-fields-pro/acf.php' );

      // embed acf code field
      require_once( ACF_ENGINE_PATH . 'vendor/acf-code-field/acf-code-field.php' );

    endif;
    /* end check for pro */

    // setup autoloader
    spl_autoload_register( [$this, 'autoloader'] );

    // setup local acf json save
    add_filter('acf/settings/save_json', [$this, 'acfSaveLocal'], 99);
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

    // init block type manager
    $opm = new BlockTypeManager();
    $opm->setup();

    // init template manager
    $opm = new TemplateManager();
    $opm->setup();

    /* load pro component managers */
    if ( $this->freemius()->is__premium_only() ) :

      // init component manager
      $opm = new ComponentManager();
      $opm->setup();

      // init render code manager
      $rcm = new RenderCodeManager();
      $rcm->setup();

    endif; /* end load pro component managers */

    /* enqueue scripts */
    add_action('wp_enqueue_scripts', [$this, 'scripts']);

  }

  public function acfSaveLocal( $path ) {
    return ACF_ENGINE_PATH . 'fields/';
  }

  public function acfLoadLocal( $paths ) {
    $paths[] = ACF_ENGINE_PATH . 'fields/';
    return $paths;
  }

  public function autoloader( $className ) {

    if ( 0 !== strpos( $className, 'AcfEngine\Core' ) ) {
      return;
    }

    if ( 0 === strpos( $className, 'AcfEngine\Core\BlockType' ) ) {

      $className = str_replace('AcfEngine\Core\BlockType\\', '', $className);
      if( $className == 'BlockType' || $className == 'BlockTypeCustom' || $className == 'BlockTypeManager' ) {
        // do not add dir
      } else {
        $className = $className . '/' . $className;
      }
      $className = 'BlockType/' . $className;

    } else {

      $className = str_replace('AcfEngine\Core\\', '', $className);
      $className = str_replace('\\', '/', $className);

    }

    require( ACF_ENGINE_PATH . 'src/' . $className . '.php' );

  }

  private function __camelCaseToHyphenated( $input ) {
		preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
		$ret = $matches[0];
		foreach ($ret as &$match) {
			$match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
		}
		return implode('-', $ret);
	}

  public function scripts() {

    wp_enqueue_script(
      'acfg-js',
      ACF_ENGINE_URL . 'scripts/js/acfg.js',
      array( 'jquery' ),
      '1.0.0',
      false
    );

    wp_enqueue_script(
      'acfg-react',
      ACF_ENGINE_URL . 'build/index.js',
      array( 'wp-blocks', 'wp-element', 'wp-polyfill' ),
      '18a3fbe1ffe108ec652b0df97bee372e',
      true
    );

    wp_enqueue_style(
      'acfg-css',
      ACF_ENGINE_URL . 'scripts/css/acfg.css',
      array(),
      true
    );

    /* splide slider */

    wp_enqueue_script(
      'acfg-splide-js',
      ACF_ENGINE_URL . 'vendor/splide/js/splide.min.js',
      array(),
      '1.0.0',
      true
    );

    wp_enqueue_style(
      'acfg-splide-css',
      ACF_ENGINE_URL . 'vendor/splide/css/splide.min.css',
      array(),
      true
    );

  }

  // Create a helper function for easy SDK access.
  public function freemius() {

    global $afcgFreemius;

    if ( ! isset( $afcgFreemius ) ) {

      // Include Freemius SDK.
      require_once ACF_ENGINE_PATH . 'vendor/freemius/start.php';

      $afcgFreemius = fs_dynamic_init( array(
        'id'                  => '7042',
        'slug'                => 'acfengine',
        'premium_slug'        => 'acfengine-pro',
        'type'                => 'plugin',
        'public_key'          => 'pk_1cfe4c350f5a0a42d9f2b9960fce6',
        'is_premium'          => true,
        'has_addons'          => false,
        'has_paid_plans'      => false,
        'menu' => array(
          'slug'           => 'acf-engine',
          'account'        => false,
          'contact'        => false,
          'support'        => false,
          'upgrade'        => false,
        ),
        'secret_key'          => 'sk_rcg1N_(M~ga=dy*_6C<XyrqomrW~K',
      )
    );
  }

  return $afcgFreemius;

}

  public function activation() {

    $dataDirs = [
      'block-types',
      'components',
      'forms',
      'options-pages',
      'post-types',
      'render-code',
      'taxonomies',
      'templates'
    ];

    $dataPath = self::dataStoragePath();
    if( !file_exists( $dataPath )) {
      $test = mkdir( $dataPath );
    }

    foreach( $dataDirs as $dirName ) {
      $dirPath = $dataPath . $dirName;
      if( !file_exists( $dirPath )) {
        mkdir( $dirPath );
      }
    }

  }

  public static function dataStoragePath() {

    $uploadDir = wp_upload_dir();
    $storagePath = $uploadDir['basedir'] . '/acfengine/';
    return $storagePath;

  }

}

new Plugin();

/*
 * Activation and deactivation hooks
 */
register_activation_hook(__FILE__, '\AcfEngine\Plugin::activation');
