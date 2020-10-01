<?php

/**
 *
 * Plugin Name: ACF Engine
 * Plugin URI: https://eatbuildplay.com/plugins/acf-engine/
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

define( 'ACF_ENGINE_PATH', plugin_dir_path( __FILE__ ) );
define( 'ACF_ENGINE_URL', plugin_dir_url( __FILE__ ) );
define( 'ACF_ENGINE_VERSION', '1.0.0' );
define( 'ACF_ENGINE_TEXT_DOMAIN', 'acf-engine');

class Plugin {

  public function __construct() {

    require_once( ACF_ENGINE_PATH . 'vendor/acf/advanced-custom-fields-pro/acf.php' );
    spl_autoload_register( [$this, 'autoloader'] );

    new AdminMenu();

    add_action('init', function() {

      $postType = new PostTypePostType();
      $postType->register();

      /*

      get_posts() not available this early, use cached file or direct db query

      $customPostTypes = get_posts([
        'post_type' => 'acfe_post_types',
        'numberposts' => '-1'
      ]);

      */

      $customPostTypes = [
        'whatever'
      ];

      foreach( $customPostTypes as $cpts ) {

        $postType = new PostTypeCustom();
        $postType->key = 'whatever';
        $postType->name = 'Whatever';
        $postType->register();

      }

    }, 10);



  }

  public function autoloader( $className ) {


    if ( 0 !== strpos( $className, 'AcfEngine\Core' ) ) {
      return;
    }

    // strip the namespace leaving only the final class name
    $className = str_replace('AcfEngine\Core\\', '', $className);
    require( ACF_ENGINE_PATH . 'src/' . $className . '.php' );

  }

}

new Plugin();
