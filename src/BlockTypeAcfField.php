<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class BlockTypeAcfField extends BlockType {

  public function key() {
		return 'acf_field';
	}

  public function title() {
    return 'ACF Field';
  }

  public function description() {
    return 'Render a single ACF field using default render template or custom template';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content = '', $is_preview = false, $editorPostId = 0 ) {

    $data = $block['data'];
    $fieldKey = get_field('meta_key');
    $fieldPostId = get_field('post_id');
    $fieldValue = get_field( $fieldKey, $fieldPostId );

    print '<h2>';
    print $fieldValue;
    print '</h2>';

  }

}
