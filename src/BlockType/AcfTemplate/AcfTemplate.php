<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class AcfTemplate extends BlockType {

  public function key() {
		return 'acf_template';
	}

  public function title() {
    return 'ACF Template';
  }

  public function description() {
    return 'Render an existing ACF Engine template.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content = '', $is_preview = false, $editorPostId = 0 ) {

    $data = $block['data'];
    $templateId = get_field('template_id');
    $templateKey = get_field('template_key');

    $templatePost = get_post( $templateId );
    $templatePostContent = $templatePost->post_content;
    print $this->parseBlockContent( $templatePostContent );

  }

}
