<?php

namespace AcfEngine\Core\BlockType;

class NavBar {

  public function __construct() {

    add_action( 'init', [$this, 'init'] );

  }

  public function init() {

    wp_register_script(
      'acfg-block-navbar-editor',
      ACF_ENGINE_URL . 'src/BlockType/NavBar/build/editor.js',
      ['wp-blocks', 'wp-element', 'wp-editor', 'wp-components'],
      '1.0.0'
    );

    wp_register_style(
      'acfg-block-navbar',
      ACF_ENGINE_URL . 'src/BlockType/NavBar/css/style.css',
      [],
      '1.0.0'
    );

    register_block_type( 'acfg/navbar', array(
      'editor_script' => 'acfg-block-navbar-editor',
      'style'         => 'acfg-block-navbar',
    ));

  }


}
