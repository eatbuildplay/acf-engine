<?php

namespace AcfEngine\Core\BlockType;

class FancyText {

  public function __construct() {

    add_action( 'init', [$this, 'init'] );

  }

  public function init() {

    wp_register_script(
      'acfg-block-fancytext',
      ACF_ENGINE_URL . '/build/index.js',
      ['wp-blocks', 'wp-element', 'wp-editor', 'wp-components'],
      '1.0.0'
    );

    register_block_type( 'acfg/fancytext', array(
      'editor_script' => 'acfg-block-fancytext',
    ));

  }


}
