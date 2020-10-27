<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class BlockTypeAcfFieldImage extends BlockType {

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
			$this->renderPreview( $block, $content, $editorPostId );
		} else {
			$this->render( $block, $content, $editorPostId );
		}
  }

	protected function renderPreview( $block, $content, $editorPostId ) {

		$templatePostType = get_field('post_type', $editorPostId);

		$previewPosts = get_posts([
			'post_type' => $templatePostType
		]);
		if( empty( $previewPosts )) {
			print 'SORRY NO POSTS AVAILABLE TO USE FOR PREVIEW.';
			return;
		}

		$previewPost = $previewPosts[0];
		$fieldKey = get_field('meta_key');
		$fieldPostId = get_field('post_id');
		if( $fieldPostId == 'current' ) {
			$fieldValue = get_field( $fieldKey, $previewPost->ID );
		} else {
			$fieldValue = get_field( $fieldKey, $fieldPostId );
		}

		$size = 'full'; // (thumbnail, medium, large, full or custom size)
		if( $fieldValue ) {
			print wp_get_attachment_image( $fieldValue, $size );
		}
		return;

	}

	protected function render( $block, $content, $editorPostId ) {

		if( isset( $GLOBALS['acfg_loop_field_value'] )) {
			$size = 'full';
	    print wp_get_attachment_image( $GLOBALS['acfg_loop_field_value'], $size );
			return;
		}

		$data = $block['data'];
    $fieldKey = get_field('meta_key');
    $fieldPostId = get_field('post_id');

		var_dump( $fieldKey );
		var_dump( $fieldPostId );
		var_dump( $editorPostId );

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
