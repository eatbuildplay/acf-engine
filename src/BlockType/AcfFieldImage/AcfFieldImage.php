<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class AcfFieldImage extends BlockType {

  public function key() {
		return 'acf_field_image';
	}

  public function title() {
    return 'ACF Image Field';
  }

  public function description() {
    return 'Render a single ACF image field with formatting options.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $editorPostId ) {
		if( $isPreview ) {
			$previewPost = $this->getPreviewPost( $editorPostId );
			$editorPostId = $previewPost->ID;
		}

		$this->render( $block, $content, $editorPostId );
  }

	protected function render( $block, $content, $editorPostId ) {

		if( isset( $GLOBALS['acfg_loop_field_value'] )) {
			$size = 'full';
			print '<div class="acfg-image">';
	    print wp_get_attachment_image( $GLOBALS['acfg_loop_field_value'], $size );
			print '</div>';
			return;
		}

		$data = $block['data'];
    $fieldKey = get_field('meta_key');
    $fieldPostId = get_field('post_id');

		if( $fieldPostId == 'current' ) {
			$fieldValue = get_field( $fieldKey, $editorPostId );
		} else {
			$fieldValue = get_field( $fieldKey, $fieldPostId );
		}

    $size = 'full'; // (thumbnail, medium, large, full or custom size)
    if( $fieldValue ) {
      print wp_get_attachment_image( $fieldValue, $size );
    }

	}

}
