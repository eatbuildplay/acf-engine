<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class BlockTypeAcfFieldNumber extends BlockType {

  public function key() {
		return 'acf_field_number';
	}

  public function title() {
    return 'ACF Number Field';
  }

  public function description() {
    return 'Render a single ACF number field with formatting options.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content = '', $is_preview = false, $editorPostId = 0 ) {

    $data = $block['data'];
    $fieldKey = get_field('meta_key');
    $fieldPostId = get_field('post_id');
    $numberPrepend = get_field('number_prepend');
    $numberAppend = get_field('number_append');
    $fieldValue = get_field( $fieldKey, $fieldPostId );

    print '<h2>';
    print $numberPrepend . $fieldValue . $numberAppend;
    print '</h2>';

  }

}
