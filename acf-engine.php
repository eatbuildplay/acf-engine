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

define( 'ACF_ENGINE_PATH', plugin_dir_path( __FILE__ ) );
define( 'ACF_ENGINE_URL', plugin_dir_url( __FILE__ ) );
define( 'ACF_ENGINE_VERSION', '1.0.0' );

class Plugin {

}

new Plugin();
