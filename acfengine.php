<?php

/**
 *
 * Plugin Name: ACF Engine
 * Plugin URI: https://acfengine.com/
 * Description: Provides data-driven solutions powered by ACF including custom post types, custom taxonomies, options pages and rendering templates.
 * Version: 1.0.4
 * Author: Eat/Build/Play
 * Author URI: https://eatbuildplay.com
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @fs_premium_only /vendor/acf/
 * @fs_premium_only /src/Form.php, /src/FormCustom.php, /src/FormManager.php
 * @fs_premium_only /src/Component.php, /src/ComponentCustom.php, /src/ComponentManager.php
 *
 */

namespace AcfEngine;
use AcfEngine\Core\AdminMenu;
use AcfEngine\Core\PostType\PostTypeManager;
use AcfEngine\Core\TaxonomyManager;
use AcfEngine\Core\TaxonomyCustom;
use AcfEngine\Core\TaxonomyTaxonomy;
use AcfEngine\Core\OptionsPageManager;
use AcfEngine\Core\BlockType\BlockTypeManager;
use AcfEngine\Core\TemplateManager;
use AcfEngine\Core\QueryManager;
use AcfEngine\Core\ComponentManager;
use AcfEngine\Core\FormManager;
use AcfEngine\Core\Import;

define( 'ACF_ENGINE_PATH', plugin_dir_path( __FILE__ ) );
define( 'ACF_ENGINE_URL', plugin_dir_url( __FILE__ ) );
define( 'ACF_ENGINE_VERSION', '1.0.4' );
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
    $m = new PostTypeManager();
    $m->setup();

    // init taxonomy manager
    $m = new TaxonomyManager();
    $m->setup();

    // init options page manager
    $m = new OptionsPageManager();
    $m->setup();

    // init block type manager
    $m = new BlockTypeManager();
    $m->setup();

    // init template manager
    $m = new TemplateManager();
    $m->setup();

    /* load pro component managers */
    if ( $this->freemius()->is__premium_only() ) :

      // init form manager
      $m = new FormManager();
      $m->setup();

      // init form manager
      $m = new QueryManager();
      $m->setup();

      // init component manager
      $m = new ComponentManager();
      $m->setup();

    endif; /* end load pro component managers */

    /* enqueue scripts */
    add_action('wp_enqueue_scripts', [$this, 'scripts']);

    // add the action delete file json post type or taxonomy
    add_action( 'before_delete_post',[$this, 'beforeDeletePost'], 10, 1 );

    /*
     * Handle rewrite flush if requested
     */
    if( get_option( 'acfg_flush_rewrite', 0 ) == 1 ) {
      flush_rewrite_rules();
      update_option('acfg_flush_rewrite', 1);
    }

    /*
     * Set Ajax Url
     */


  }

  public function beforeDeletePost( $id_acfg ) {
    $acfg_post = get_post($id_acfg);
    if ($acfg_post->post_type == 'acfg_post_type'){
      $acfg_key = get_post_meta($id_acfg,'key',true);
      wp_delete_file(\AcfEngine\Plugin::dataStoragePath() . 'post-types/' . $acfg_key . '.json');
    }
    if ($acfg_post->post_type == 'acfg_taxonomy'){
      $acfg_key = get_post_meta($id_acfg,'key',true);
      wp_delete_file(\AcfEngine\Plugin::dataStoragePath() . 'taxonomies/' . $acfg_key . '.json');
    }
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

    } elseif( 0 === strpos( $className, 'AcfEngine\Core\PostType' ) ) {

      $className = str_replace('AcfEngine\Core\PostType\\', '', $className);
      $className = 'PostType/' . $className;

    }
    else {

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
      array( 'jquery', 'wp-util' ),
      '1.0.0',
      false
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

    // enable scripts for front-end acf forms
    acf_form_head();

  }

  // Create a helper function for easy SDK access.
  public static function freemius() {

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
      ));
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
      'templates',
      'queries'
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
