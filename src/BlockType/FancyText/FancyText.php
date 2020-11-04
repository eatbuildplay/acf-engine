<?php

namespace AcfEngine\Core\BlockType;

class FancyText {

  public function __construct() {

    add_action( 'init', [$this, 'init'] );

  }

  public function init() {

    wp_register_script(
      'acfg-block-fancytext-editor',
      ACF_ENGINE_URL . 'src/BlockType/FancyText/build/editor.js',
      ['wp-blocks', 'wp-element', 'wp-editor', 'wp-components'],
      '1.0.0'
    );

    wp_register_script(
      'acfg-block-fancytext-front',
      ACF_ENGINE_URL . 'src/BlockType/FancyText/build/front.js',
      ['wp-blocks', 'wp-element', 'wp-editor', 'wp-components'],
      '1.0.0'
    );

    register_block_type( 'acfg/fancytext', array(
      'editor_script' => 'acfg-block-fancytext-editor',
      'script' => 'acfg-block-fancytext-front',
    ));

  }


}
